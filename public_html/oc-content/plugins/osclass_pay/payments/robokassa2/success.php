<?php
  define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
  require_once ABS_PATH . 'oc-load.php';

  $status = Params::getParam('status');
  $txnid = Params::getParam('txnid');
  $firstname = Params::getParam('firstname');
  $email = Params::getParam('email');
  $productinfo = Params::getParam('productinfo');
  $amount = Params::getParam('amount');
  $posted_hash = Params::getParam('hash');
  $key = Params::getParam('key');
  $extra = Params::getParam('udf1');
  $url = osp_pay_url_redirect();
  $salt = osp_decrypt(osp_param('Robokassa_salt'));

    $status = RobokassaPayment::processPayment();

    if ($status == OSP_STATUS_COMPLETED) {
      osc_add_flash_ok_message(sprintf(__('Success! Please write down this transaction ID in case you have any problem: %s', 'osclass_pay'), $txnid));
    }

    if(OSP_DEBUG) {
      $emailtext = "status => " . $status . "\r\n";
      $emailtext .= osp_array_to_string(Params::getParamsAsArray('post'));
      mail(osc_contact_email() , 'OSCLASS PAY - ROBOKASSA DEBUG RESPONSE', $emailtext);
    }
  } 


  $data = osp_get_custom(Params::getParam('extra'));
  $product_type = explode('x', $data['product']);

      osp_js_redirect_to($url);
?>