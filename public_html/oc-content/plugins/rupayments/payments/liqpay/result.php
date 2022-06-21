<?php define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');

    require_once ABS_PATH . 'oc-load.php';

    require_once 'ModelLiqpay.php';

    

    $result = Params::getParam('data');

    $result_signature = Params::getParam('signature');

    
    if(osc_get_preference('lp_sandbox', 'rupayments')) {

        $public_key = osc_get_preference('lp_test_public_key', 'rupayments');

        $private_key = osc_get_preference('lp_test_private_key', 'rupayments');

    }

    else {

        $public_key = osc_get_preference('lp_public_key', 'rupayments');

        $private_key = osc_get_preference('lp_private_key', 'rupayments');

    }

    

    $parsed_data = json_decode(base64_decode($result), true);



    $liqpay = new ModelLiqpay($public_key, $private_key);

    $signature = $liqpay->check_signature($result);

    $order_id = $parsed_data['order_id'];

    if($result_signature == $signature && $parsed_data['status'] == 'success') {

        $order = ModelRUpayments::newInstance()->getTransaction($order_id);

        

        $product_type = $order["i_product_type"];

        

        osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));

        

        $item = Item::newInstance()->findByPrimaryKey($order["fk_i_item_id"]);

	    $aProductTypes = array("501", "502", "503", "601", "901", "1001");

        

        if (!in_array ( $product_type, $aProductTypes)) {

            $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);

            View::newInstance()->_exportVariableToView('category', $category);

        }

        

        if (ModelRUpayments::newInstance()->getIsPublishPaymentNeeded($itemId)) {

            if ($product_type == "201") $product_type = "202";

            if ($product_type == "301") $product_type = "302";

            if ($product_type == "231") $product_type = "232";

            if ($product_type == "701") $product_type = "702";

            if ($product_type == "711") $product_type = "712";

            if ($product_type == "721") $product_type = "722";

            if ($product_type == "731") $product_type = "732";

            if ($product_type == "801") $product_type = "802";

            if ($product_type == "811") $product_type = "812";

        }

        

        if ($product_type == "101") {

            rupayments_js_redirect_to(osc_search_category_url());

        } else if ($product_type == "201" || $product_type == "202") {    

            rupayments_js_redirect_to(osc_search_category_url());

        } else if ($product_type == "301" || $product_type == "302") {

            rupayments_js_redirect_to(osc_search_category_url());

        } else if ($product_type == "401") {

            rupayments_js_redirect_to(osc_search_category_url());

        } else if ($product_type == "411") {

            rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));

        } else if ($product_type == "231" || $product_type == "232") {

            rupayments_js_redirect_to(osc_search_category_url());

        } else if($product_type == "601") {

            rupayments_js_redirect_to(osc_route_url('rupayments-user-membership'));

        } else if($product_type == "701" || $product_type == "702") {

            rupayments_js_redirect_to(osc_search_category_url());

        } else if($product_type == "711" || $product_type == "712") {

            rupayments_js_redirect_to(osc_search_category_url());

        } else if($product_type == "721" || $product_type == "722") {

            rupayments_js_redirect_to(osc_search_category_url());

        } else if($product_type == "731" || $product_type == "732") {

            rupayments_js_redirect_to(osc_search_category_url());

        } else if($product_type == "801" || $product_type == "802") {

            rupayments_js_redirect_to(osc_search_category_url());

        } else if($product_type == "811" || $product_type == "812") {

            rupayments_js_redirect_to(osc_search_category_url());

        } else if($product_type == "901") {

            rupayments_js_redirect_to(osc_route_url('rupayments-user-banners'));

        } else if($product_type == "1001") {

            rupayments_js_redirect_to(osc_route_url('rupayments-user-ebuy-deals'));

        } else {

            if (osc_is_web_user_logged_in()) {

                rupayments_js_redirect_to(osc_route_url('rupayments-user-pack'));

            } else {

                rupayments_js_redirect_to(osc_base_url());

            }

        }

    }

    else {

        osc_add_flash_info_message(__('LiqPay Payment has canceled, you can try again', 'rupayments'));

        rupayments_js_redirect_to(osc_base_url());

    }