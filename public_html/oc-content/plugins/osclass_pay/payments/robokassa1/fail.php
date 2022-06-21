<?php
$inv_id = Params::getParam("InvId");
osc_add_flash_error_message(__("There was a problem processing your Payment $inv_id\n. Please contact the administrators",'rupayments'));  
if(osc_is_web_user_logged_in()) {
                    rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));
                } else {
                    View::newInstance()->_exportVariableToView('item', Item::newInstance()->findByPrimaryKey($itemId));
                    rupayments_js_redirect_to(osc_item_url());
                }     
?>