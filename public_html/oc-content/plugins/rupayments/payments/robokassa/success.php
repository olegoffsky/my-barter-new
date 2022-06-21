<?php
		   /*
 * Copyright 2017 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
 $sigdis = Params::getParam("SignatureValue");
if (isset($sigdis)) {
    $mrhPass1 = osc_get_preference('mrhpass1', 'rupayments');
    $outSumm = Params::getParam("OutSum");
    $invId = Params::getParam("InvId");
	$product_type = Params::getParam("shp_product");
	$shpBype = Params::getParam("shp_item");
	$userid = Params::getParam("shp_user");
    $signature = Params::getParam("SignatureValue");

    $signature = strtoupper($signature);
    $mySignature = strtoupper(md5("$outSumm:$invId:$mrhPass1:shp_item=$shpBype:shp_product=$product_type:shp_user=$userid"));
    if ($mySignature != $signature) {
        echo "bad sign\n";
        exit();
    }

	       osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
	    $item = Item::newInstance()->findByPrimaryKey ( $shpBype );
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
            }
            else if ( $product_type == "231" ) {
               rupayments_js_redirect_to(osc_search_category_url());
            }
            else if($product_type == "601") {
                rupayments_js_redirect_to(osc_route_url('rupayments-user-membership'));
            } else if($product_type == "701") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "711") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "721") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "731") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "801") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "811") {
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
                    rupayments_js_redirect_to(osc_route_url('rupayments-user-pack'));
                } else {
                    // THIS SHOULD NOT HAPPEN
                    rupayments_js_redirect_to(osc_base_url());
                }
            }
        
         

}
?>