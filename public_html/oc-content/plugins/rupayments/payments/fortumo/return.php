<?php
/*
 
Code was developed in - installPay.ru
Adding other payment systems - installPay.ru

*/

	define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
    require_once ABS_PATH . 'oc-load.php';
echo'Please wait...';             
sleep(4);
   
 
    

    
   

			  osc_add_flash_ok_message(__('Welcome back!If the payment completed - Your wallet is already funded. If the payment is not completed- Try again later.', 'rupayments'));
              rupayments_js_redirect_to(osc_route_url('rupayments-user-pack'));

         

 
   
?>