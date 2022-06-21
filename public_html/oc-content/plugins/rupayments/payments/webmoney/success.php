<?php
/*
 * Copyright 2017 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
    
    $transaction_id = Params::getParam("FIELD_1");
    $aDataInner = ModelRUpayments::newInstance()->getTransaction ( $transaction_id );
    
    if ( is_array ( $aDataInner ) ) { 

        if ( count ( $aDataInner ) < 3 ) {
            osc_add_flash_info_message(__('Time of session of your Payment has expired, please try again', 'rupayments'));
            rupayments_js_redirect_to(osc_base_url());
        }
  
        if ( $aData = ModelRUpayments::newInstance()->getPaymentByCode ( $transaction_id, "Webmoney" ) ) {
           
            $product_type = $aData["i_product_type"];
            
            osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
	    $item = Item::newInstance()->findByPrimaryKey ( $aData["fk_i_item_id"] );
	    $aProductTypes = array ( "501", "502", "503", "601", "901", "1001" );
          
            if ( !in_array ( $product_type, $aProductTypes ) ) {
	        $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	        View::newInstance()->_exportVariableToView('category', $category);
            }
            
  if ( $product_type == "101" ) {
                rupayments_js_redirect_to(osc_search_category_url());
            } else if ( $product_type == "201" ) {
               rupayments_js_redirect_to(osc_search_category_url());
            } else if ( $product_type == "301" ) {
               rupayments_js_redirect_to(osc_search_category_url());
            } else if ( $product_type == "401" ) {
               rupayments_js_redirect_to(osc_search_category_url());
            } else if ( $product_type == "411" ) {
               rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));
            } else if ( $product_type == "231" ) {
               rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "601") {
                rupayments_js_redirect_to(osc_route_url('rupayments-user-membership'));
            } else if($product_type == "701") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "711") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "721") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "731") {
                    rupayments_js_redirect_to(osc_search_category_url());
            }
            else if($product_type == "801") {
                    rupayments_js_redirect_to(osc_search_category_url());
            }
            else if($product_type == "811") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } 
            else if ( $product_type == "901" ) {
               rupayments_js_redirect_to(osc_route_url('rupayments-user-banners'));
            } 
            else if($product_type == "1001") {
                rupayments_js_redirect_to(osc_route_url('rupayments-user-ebuy-deals'));
            }
            
	    else {
                if(osc_is_web_user_logged_in()) {
                    rupayments_js_redirect_to(osc_route_url('rupayments-user-pack'));
                } else {
                    // THIS SHOULD NOT HAPPEN
                    rupayments_js_redirect_to(osc_base_url());
                }
            }
        // Если уведомления о платеже не было
        } else {
           osc_add_flash_info_message(__('We are processing your Skrill, if we did not finish in a few seconds, please contact us', 'rupayments'));
            
            $product_type = $aDataInner['i_product_type']; 
            
            if ( $product_type == "501" ) { 
                if(osc_is_web_user_logged_in()) {
                    rupayments_js_redirect_to(osc_route_url('rupayments-user-pack'));
                } else {
                    // THIS SHOULD NOT HAPPEN
                    rupayments_js_redirect_to(osc_base_url());
                }
            }
            else if($product_type == "601") {
                rupayments_js_redirect_to(osc_route_url('rupayments-user-membership'));
            } 
            else if($product_type == "701") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } 
            else if($product_type == "711") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } 
            else if($product_type == "721") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } 
            else if($product_type == "731") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } 
            else if($product_type == "801") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } 
            else if($product_type == "811") {
                    rupayments_js_redirect_to(osc_search_category_url());
            }
            else if($product_type == "901") {
                rupayments_js_redirect_to(osc_route_url('rupayments-user-banners'));
            }
            else if($product_type == "1001") {
                rupayments_js_redirect_to(osc_route_url('rupayments-user-ebuy-deals'));
            }
            else {
                if(osc_is_web_user_logged_in()) {
                    rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));
                } else {
                    View::newInstance()->_exportVariableToView ( 'item', Item::newInstance()->findByPrimaryKey ( $aData["fk_i_item_id"] ) );
                    rupayments_js_redirect_to(osc_item_url());
                }
            }
         
        }
 
    }
    
    else {
        // Такого действительного (по времени) идентификатора транзации нет - возможно истек 
        osc_add_flash_info_message(__('Time of session of your Payment has expired, please try again', 'rupayments'));
        rupayments_js_redirect_to(osc_base_url());
    } 
 
?>