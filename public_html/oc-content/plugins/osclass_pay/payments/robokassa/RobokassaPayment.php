<?php
class RobokassaPayment {

  public function __construct() { }

  // BUTTON GENERATED VIA FUNCTION OSP_BUTTONS TO PROCESS PAYMENT
  public static function button($amount = '0.00', $description = '', $itemnumber = '', $extra_array = null) {

    //

    $extra = osp_prepare_custom($extra_array) . '|';
    $extra .= 'concept,'.$description.'|';
    $extra .= 'product,'.$itemnumber.'|';
    $r = rand(0,1000);
    $extra .= 'r,'.$r;

    $email = osc_logged_user_email(); 
    $shop_id = osp_param('robokassa_shop_login');
    $password_1 = osp_decrypt(osp_param('robokassa_password_1'));
    $password_2 = osp_decrypt(osp_param('robokassa_password_2'));
    $user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());
    $transaction_id = 'rk' . mb_generate_rand_string(10);

    //$ENDPOINT = '';
    $RETURN_URL = osc_base_url() . 'oc-content/plugins/' . osc_plugin_folder(__FILE__) . 'return.php';

    $pending_data = array(
      's_transaction_id' => $transaction_id,
      'fk_i_user_id' => osc_logged_user_id(),
      's_email' => osc_logged_user_email(),
      's_extra' => $extra,
      's_source' => 'Robokassa',
      'dt_date' => date('Y-m-d h:i:s')
    );
    $order_id = ModelOSP::newInstance()->insertPending($pending_data);
    $items = array(
      'sno' => 'osn',
      'items' => array(
        0 => array(
          'name' => 'Пополнение баланса',
          'quantity' => '1',
          'sum' => round($amount, 2),
          'payment_method' => 'full_payment',
          'payment_object' => 'service',
          'tax' => 'none',
        ),
      ),
    );    
    $arr_encode = json_encode($items); // Преобразовываем JSON в строку
    $receipt = urlencode($arr_encode);
    $receipt_urlencode = urlencode($receipt);
    $sign  = md5($shop_id.':'.round($amount, 2).':'.$order_id.':'.$receipt.':'.$password_1);
    $url ="https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=".$shop_id."&IsTest=0&OutSum=".round($amount, 2)."&InvId=".$order_id."&Receipt=".$receipt_urlencode."&Description=".$description."&SignatureValue=".$sign;

    ModelOSP::newInstance()->updatePendingTransaction($order_id, $payment->id);

    ?>

    <li>
      <a id="osp-button-confirm" class="button osp-has-tooltip" title="<?php echo osc_esc_html(__('You will be redirected to robokassa.ru', 'osclass_pay')); ?>" href="<?php echo $url; ?>">
        <span><img src="<?php echo osp_url(); ?>img/payments/robokassa.png"/></span>
        <strong><?php _e('Pay with Robokassa', 'osclass_pay'); ?></strong>
      </a>
    </li>
    <?php
  }
  public static function processPayment() {
    $order_id = Params::getParam('order_id');
    $transaction_id = Params::getParam('transaction_id');

    if($order_id > 0) {
      $pending = ModelOSP::newInstance()->getPendingById($order_id);
      $transaction_id = $pending['s_transaction_id'];
    } else {
      $pending = ModelOSP::newInstance()->getPendingByTransactionId($transaction_id);
    }

    if(!$pending) {
      $pending = ModelOSP::newInstance()->getPendingByTransactionId(Params::getParam('order'), 'Robokassa');
    }

    if(!$pending || !isset($pending['s_extra']) || $pending['s_extra'] == '' || $pending['pk_i_id'] <= 0) {
      return array(OSP_STATUS_FAILED, __('Failed - unable to find data related to this order (Pending item missing)', 'osclass_pay')); 
    }

    $extra = $pending['s_extra'];     // get pending row
    $data = osp_get_custom($extra);
    $product_type = explode('x', $data['product']);
    $amount = $data['amount']; 

    Params::setParam('extra', $extra);


    if($amount <= 0) { 
      return array(OSP_STATUS_AMOUNT_ZERO, ''); 
    }

    $shop_id = osp_param('robokassa_shop_login');
    $password_1 = osp_decrypt(osp_param('robokassa_password_1'));
    $password_2 = osp_decrypt(osp_param('robokassa_password_2'));
    
    Params::setParam('robokassa_transaction_id', $transaction_id);

    $payment = ModelOSP::newInstance()->getPaymentByCode($transaction_id, 'Robokassa');


    if(!$payment) { 
      // SAVE TRANSACTION LOG
     
          $payment_id = ModelOSP::newInstance()->saveLog(
            $data['concept'], //concept
            $cardinity_id, // transaction code
            $amount, //amount
            strtoupper(Params::getParam('currency')), //currency
            $data['email'], // payer's email
            $data['user'], //user
            osp_create_cart_string($product_type[1], $data['user'], $data['itemid']), // cart string
            $product_type[0], //product type
            'Robokassa' //source
          );



      // Pay it!
      $payment_details = osp_prepare_payment_data($amount, $payment_id, $data['user'], $product_type);   //amount, payment_id, user_id, product_type
      $pay_item = osp_pay_fee($payment_details);


      // Remove pending row
      ModelOSP::newInstance()->deletePending($pending['pk_i_id']);


      return array(OSP_STATUS_COMPLETED, '');
    }

    return array(OSP_STATUS_ALREADY_PAID, ''); 
  }

  public static function processNotification() {
    $order_id = Params::getParam('InvId');
    $transaction_id = Params::getParam('InvId');

    if($order_id > 0) {
      $pending = ModelOSP::newInstance()->getPendingById($order_id);
      $transaction_id = $pending['s_transaction_id'];
    } else {
      $pending = ModelOSP::newInstance()->getPendingByTransactionId($transaction_id);
    }

    if(!$pending) {
      $pending = ModelOSP::newInstance()->getPendingByTransactionId(Params::getParam('order'), 'Robokassa');
    }

    if(!$pending || !isset($pending['s_extra']) || $pending['s_extra'] == '' || $pending['pk_i_id'] <= 0) {
      return array(OSP_STATUS_FAILED, __('Failed - unable to find data related to this order (Pending item missing)', 'osclass_pay')); 
    }

    $extra = $pending['s_extra'];     // get pending row
    $data = osp_get_custom($extra);
    $product_type = explode('x', $data['product']);
    $amount = $data['amount']; 

    Params::setParam('extra', $extra);


    if($amount <= 0) { 
      return array(OSP_STATUS_AMOUNT_ZERO, ''); 
    }

    $shop_id = osp_param('robokassa_shop_login');
    $password_1 = osp_decrypt(osp_param('robokassa_password_1'));
    $password_2 = osp_decrypt(osp_param('robokassa_password_2'));
    $sign = strtoupper(md5($_REQUEST["OutSum"].":".$_REQUEST["InvId"].":".$password_2));
    $crc = strtoupper($_REQUEST["SignatureValue"]);
    if($sign != $sign){
      return array(OSP_STATUS_FAILED, sprintf(__('Payment has not been successfully signed to our account yet. Current payment status is %s', 'osclass_pay'))); 

    }
	else{
		return array(OSP_STATUS_COMPLETED, '');
	}

    Params::setParam('robokassa_transaction_id', $transaction_id);

    $payment = ModelOSP::newInstance()->getPaymentByCode($transaction_id, 'Robokassa');


    if(!$payment) { 
      // SAVE TRANSACTION LOG
      $payment_id = ModelOSP::newInstance()->saveLog(
            $data['concept'], //concept
            $cardinity_id, // transaction code
            $amount, //amount
            strtoupper(Params::getParam('currency')), //currency
            $data['email'], // payer's email
            $data['user'], //user
            osp_create_cart_string($product_type[1], $data['user'], $data['itemid']), // cart string
            $product_type[0], //product type
            'Robokassa' //source
          );


      // Pay it!
      $payment_details = osp_prepare_payment_data($amount, $payment_id, $data['user'], $product_type);   //amount, payment_id, user_id, product_type
      $pay_item = osp_pay_fee($payment_details);


      // Remove pending row
      ModelOSP::newInstance()->deletePending($pending['pk_i_id']);


      return array(OSP_STATUS_COMPLETED, '');
    }

    return array(OSP_STATUS_ALREADY_PAID, ''); 
  }
}


?>
