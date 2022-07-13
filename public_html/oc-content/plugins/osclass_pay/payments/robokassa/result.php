<?php
define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
require_once ABS_PATH . 'oc-load.php';

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

?>
