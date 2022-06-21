 <?php 
 define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
  require_once ABS_PATH . 'oc-load.php';
  if(osc_is_web_user_logged_in()) {
 rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));
 osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
                } else {
				rupayments_js_redirect_to(osc_base_url());
				osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
                }

   ?>







