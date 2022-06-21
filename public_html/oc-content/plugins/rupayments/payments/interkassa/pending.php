<?php
/*
 * Copyright 2016 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
    define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
    require_once ABS_PATH . 'oc-load.php';
    
    $transaction_id = Params::getParam("tr");
    $aDataInner = ModelRUpayments::newInstance()->getTransaction ( $transaction_id );
    
            $product_type = $aDataInner["i_product_type"];
     
            osc_add_flash_info_message(__('Your payment processing did not finished,  please wait', 'rupayments'));
            if ( $product_type == "501" || $product_type == "502"  || $product_type == "503" ) { 
                if(osc_is_web_user_logged_in()) {
                    rupayments_js_redirect_to(osc_route_url('rupayments-user-pack'));
                } else {
                    // THIS SHOULD NOT HAPPEN
                    rupayments_js_redirect_to(osc_base_url());
                }
            } else {
                if(osc_is_web_user_logged_in()) {
                    rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));
                } else {
                    View::newInstance()->_exportVariableToView ( 'item', Item::newInstance()->findByPrimaryKey ( $aData["fk_i_item_id"] ) );
                    rupayments_js_redirect_to(osc_item_url());
                }
            }


    
 
?>