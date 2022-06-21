<?php
 define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
  require_once ABS_PATH . 'oc-load.php';
rupayments_js_redirect_to(osc_base_url());
osc_add_flash_error_message(__("There was a problem processing your Payment. Please contact the administrators",'rupayments'));

?>
