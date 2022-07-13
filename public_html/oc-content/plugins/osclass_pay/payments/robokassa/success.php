<?php
  define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
  require_once ABS_PATH . 'oc-load.php';

  if(OSP_DEBUG) {
    $emailtext = "status => " . $status . "\r\n";
    $emailtext .= osp_array_to_string(Params::getParamsAsArray());
    mail(osc_contact_email() , 'OSCLASS PAY - PAYS.CZ SUCCESS DEBUG RESPONSE', $emailtext);
  }

  $data = osp_get_custom(Params::getParam('extra'));
  $product_type = explode('x', $data['product']);
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
    $extra = osp_prepare_custom($extra_array) . '|';
    $extra .= 'concept,'.$description.'|';
    $extra .= 'product,'.$itemnumber.'|';
    $r = rand(0,1000);
    $extra .= 'r,'.$r;

    $email = osc_logged_user_email(); 
    $user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());
    Params::setParam('extra', $extra);


    if($amount <= 0) { 
      return array(OSP_STATUS_AMOUNT_ZERO, ''); 
    }

    $shop_id = osp_param('robokassa_shop_login');
    $password_1 = osp_decrypt(osp_param('robokassa_password_1'));
    $password_2 = osp_decrypt(osp_param('robokassa_password_2'));
    $sign = strtoupper(md5($_REQUEST["OutSum"].":".$_REQUEST["InvId"].":".$password_2));
    $crc = strtoupper($_REQUEST["SignatureValue"]);


    Params::setParam('robokassa_transaction_id', $transaction_id);

    $payment = ModelOSP::newInstance()->getPaymentByCode($transaction_id, 'Robokassa');


    if(!$payment) { 
      // SAVE TRANSACTION LOG
    $payment_id = ModelOSP::newInstance()->saveLog(
            $data['concept'], //concept
      'robokassa_' . date('YmdHis'), // transaction code
        $amount, //amount
      osp_currency(), // currency
        $data['email'], // payer's email
        $data['user'], //user
        osp_create_cart_string($product_type[1], $data['user'], $data['itemid']), // cart string
        $product_type[0], //product type
            'ROBOKASSA' //source
          );


      // Pay it!
      $payment_details = osp_prepare_payment_data($amount, $payment_id, $data['user'], $product_type);   //amount, payment_id, user_id, product_type
      $pay_item = osp_pay_fee($payment_details);


  osc_add_flash_ok_message(__('Your payment was successfully processed and will be finished in few moments.', 'osclass_pay'));
  osp_js_redirect_to(osp_pay_url_redirect($product_type));
  }
?>