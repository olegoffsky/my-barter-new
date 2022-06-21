<?php
/*
 * Copyright 2015 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
$url = '';
$mp = ModelRUpayments::newInstance();
   
if(osc_is_web_user_logged_in()) {
    
    if ( !Params::getParam('extra') ) {  
        return false;
    }
  
    $data = rupayments_get_custom(Params::getParam('extra'));
    $product_type = explode('x', $data['product']);
    $wallet = $mp->getWallet(osc_logged_user_id());
    
    if($product_type[0] == '601') {
        $user_group = ModelRUpayments::newInstance()->getUserGroup($data['itemid']);
        $user_group_title = $user_group['f_group_title'];
        $user_group_price = $user_group['f_group_price'];
        
        if($wallet['formatted_amount'] >= $user_group_price) {
            $payment_id = $mp->saveLog(
                sprintf(__("Payment of membership fee: %s", "rupayments"), $user_group_title), //concept
                'wallet_'.date("YmdHis"), // transaction code
                $user_group_price, //amount
                osc_get_preference("currency", "rupayments"), //currency
                $data['email'], // payer's email
                $data['user'], //user
                $data['itemid'], //item
                $product_type[0], //product type
                'WALLET'); //source
                
            $mp->addWallet(osc_logged_user_id(), -$user_group_price);
            $mp->setUserMembership($data['itemid'], $data['user']);
            $url = osc_route_url('rupayments-user-membership');
        }
    }
    elseif ($product_type[0] == '901') {
        $get_banner = ModelRUpayments::newInstance()->getUserBannerPublish($data['itemid'], osc_logged_user_id());
        
        if($wallet['formatted_amount'] >= $get_banner['i_banner_budget']) {
            $payment_id = $mp->saveLog(
                sprintf(__("Payment of banner public fee: %s", "rupayments"), $data['itemid']), //concept
                'wallet_'.date("YmdHis"), // transaction code
                $get_banner['i_banner_budget'], //amount
                osc_get_preference("currency", "rupayments"), //currency
                $data['email'], // payer's email
                $data['user'], //user
                $data['itemid'], //item
                $product_type[0], //product type
                'WALLET'); //source
                
            $mp->addWallet(osc_logged_user_id(), -$get_banner['i_banner_budget']);
            $mp->setUserBannerPay($data['itemid']);
            $url = osc_route_url('rupayments-user-banners');
        }
    }
    else if($product_type[0] == '1001') {
        $ebuy_item = ModelRUpayments::newInstance()->getEbuyItem($product_type[1], true);
        $item = Item::newInstance()->findByPrimaryKey($ebuy_item['i_item_id']);
        $item_title = $item['s_title'];
        $deal_price = $ebuy_item['s_item_price'];
        
        if($wallet['formatted_amount'] >= $deal_price) {
            $payment_id = $mp->saveLog(
                sprintf(__("Payment of Item Purchase: %s", "rupayments"), $item_title), //concept
                'wallet_'.date("YmdHis"), // transaction code
                $ebuy_item['s_item_price'], //amount
                $ebuy_item['s_item_currency'], //currency
                $data['email'], // payer's email
                $data['user'], //user
                $data['itemid'], //item
                $product_type[0], //product type
                'WALLET'); //source
                
            $mp->addWallet(osc_logged_user_id(), -$ebuy_item['s_item_price']);
            $mp->setEbuyDealPay($data['itemid'], $data['user']);
            $url = osc_route_url('rupayments-user-ebuy-deals');
        } 
    }
    else {
        $item = Item::newInstance()->findByPrimaryKey($data['itemid']);
        $category_fee = 0;
    
        if ( osc_logged_user_id() == $item['fk_i_user_id'] ) { // 
            
            $category_fee = $mp->calculatePrice ( $product_type[0], $item['fk_i_category_id'], $item );
            			
        }
        
        if ( $category_fee > 0 && $wallet['formatted_amount'] >= $category_fee ) {
            
            $payment_id = $mp->saveLog(
                Params::getParam('desc'), //concept
                'wallet_'.date("YmdHis"), // transaction code
                $category_fee, //amount
                osc_get_preference("currency", "rupayments"), //currency
                $data['email'], // payer's email
                $data['user'], //user
                $data['itemid'], //item
                $product_type[0], //product type
                'WALLET'); //source
                
            $mp->addWallet(osc_logged_user_id(), -$category_fee);
            
            if ($product_type[0] == '101') {
                $mp->payPublishFee($data['itemid'], $payment_id);
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !$mp->checkShowImage($data['itemid'])) $mp->setImageShow($data['itemid'], 0);
                $url = osc_search_category_url();
            } 
            else if ($product_type[0] == '201') {
                if ( $mp->getIsPublishPaymentNeeded ( $data['itemid'] ) ) $mp->payPublishFee($data['itemid'], $payment_id);
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !$mp->checkShowImage($data['itemid'])) $mp->setImageShow($data['itemid'], 0);
                $mp->payPremiumFee($data['itemid'], $payment_id);
                $url = osc_search_category_url();
            } 
            else if ($product_type[0] == '301') {
                if ( $mp->getIsPublishPaymentNeeded ( $data['itemid'] ) ) $mp->payPublishFee($data['itemid'], $payment_id);
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !$mp->checkShowImage($data['itemid'])) $mp->setImageShow($data['itemid'], 0);
                $mp->setColor($data['itemid'], $payment_id);
                $url = osc_search_category_url();
            } 
            else if ($product_type[0] == '701') {
                if ( $mp->getIsPublishPaymentNeeded ( $data['itemid'] ) ) $mp->payPublishFee($data['itemid'], $payment_id);
                $mp->setImageShow($data['itemid'], 1);
                $url = osc_search_category_url();
            } 
            else if ($product_type[0] == '711') {
                if ( $mp->getIsPublishPaymentNeeded ( $data['itemid'] ) ) $mp->payPublishFee($data['itemid'], $payment_id);
                $mp->payPremiumFee($data['itemid'], $payment_id);
                $mp->setImageShow($data['itemid'], 1);
                $url = osc_search_category_url();
            } 
            else if ($product_type[0] == '721') {
                if ( $mp->getIsPublishPaymentNeeded ( $data['itemid'] ) ) $mp->payPublishFee($data['itemid'], $payment_id);
                $mp->setColor($data['itemid'], $payment_id);
                $mp->setImageShow($data['itemid'], 1);
                $url = osc_search_category_url();
            } 
            else if ($product_type[0] == '731') {
                if ( $mp->getIsPublishPaymentNeeded ( $data['itemid'] ) ) $mp->payPublishFee($data['itemid'], $payment_id);
                $mp->payPremiumFee($data['itemid'], $payment_id);
                $mp->setColor($data['itemid'], $payment_id);
                $mp->setImageShow($data['itemid'], 1);
                $url = osc_search_category_url();
            } 
            else if ($product_type[0] == '801') {
                if ( $mp->getIsPublishPaymentNeeded ( $data['itemid'] ) ) $mp->payPublishFee($data['itemid'], $payment_id);
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !$mp->checkShowImage($data['itemid'])) $mp->setImageShow($data['itemid'], 0);
                
                $mp->setPack3in1($data['itemid'], $payment_id);
                $url = osc_search_category_url();
            } 
            else if ($product_type[0] == '811') {
                if ( $mp->getIsPublishPaymentNeeded ( $data['itemid'] ) ) $mp->payPublishFee($data['itemid'], $payment_id);
                
                $mp->setPack3in1($data['itemid'], $payment_id);
                $mp->setImageShow($data['itemid'], 1);
                $url = osc_search_category_url();
            } 
            else if ($product_type[0] == '401') {
                $mp->setTopItem($data['itemid'], $payment_id);
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !$mp->checkShowImage($data['itemid'])) $mp->setImageShow($data['itemid'], 0);
                $url = osc_search_category_url();
            }
    		else if ($product_type[0] == '411') {
                $mp->setRenew($data['itemid'], $payment_id);
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !$mp->checkShowImage($data['itemid'])) $mp->setImageShow($data['itemid'], 0);
                $url = osc_route_url('rupayments-user-menu');
            }
            else if ($product_type[0] == '231') {
                if ( $mp->getIsPublishPaymentNeeded ( $data['itemid'] ) ) $mp->payPublishFee($data['itemid'], $payment_id);
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !$mp->checkShowImage($data['itemid'])) $mp->setImageShow($data['itemid'], 0);
                $mp->payPremiumWithColorFee($data['itemid'], $payment_id);
                $url = osc_search_category_url();
            }
        }   
    } 
}

if($url!='') {
    osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
    rupayments_js_redirect_to($url);
} else {
    osc_add_flash_error_message(__('There were some errors, please try again later or contact the administrators', 'rupayments'));
    rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));
}
?>