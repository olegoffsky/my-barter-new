<?php
define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
require_once ABS_PATH . 'oc-load.php';

  $shop_id = osp_param('robokassa_shop_login');
  $password_1 = osp_decrypt(osp_param('robokassa_password_1'));
  $password_2 = osp_decrypt(osp_param('robokassa_password_2'));
  Params::setParam('transaction_id', $_REQUEST["InvId"]);   // transaction ID stored in label
  $data = osp_get_custom(Params::getParam('extra'));
  $product_type = explode('x', $data['product']);
$email = osc_logged_user_email(); 
  $tx = Params::getParam('robokassa_transaction_id');
  $sign = strtoupper(md5($_REQUEST["OutSum"].":".$_REQUEST["InvId"].":".$password_2));
  $crc = Params::getParam("SignatureValue");
  #Params::getParam("SignatureValue");


 # echo "<pre>". $crc."</pre>";
  if($sign != $sign){
    RobokassaPayment::processNotification();
    echo 'OK'.$_REQUEST['InvId'];
      osc_add_flash_error_message(__('You cancel the payment process or there was an error. If the error continue, please contact the administrator', 'osclass_pay'));
        osp_js_redirect_to(osp_pay_url_redirect($product_type));
	return array(OSP_STATUS_COMPLETED, '');
	
  }
  if(OSP_DEBUG) {
    $emailtext = "status => " . $status . "\r\n";
    $emailtext .= "message => " . $message . "\r\n";
    $emailtext .= osp_array_to_string(Params::getParamsAsArray());
    $emailtext .= osp_array_to_string($payment);
    mail(osc_contact_email() , 'OSCLASS PAY - ROBOKASSA (NOTIFICATION) DEBUG RESPONSE', $emailtext);
  }

?>
