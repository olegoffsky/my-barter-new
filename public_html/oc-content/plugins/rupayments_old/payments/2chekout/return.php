<?php
/*
 * Copyright 2017 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
 


	define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
    require_once ABS_PATH . 'oc-load.php';
             
    /**
    * Vars section
    */  
    $hashSid = osc_get_preference('mrhlogin', 'rupayments');
    $hashSecretWord = osc_get_preference('secret_word', 'rupayments');
    $crc = $_REQUEST['key'];
    $hashTotal = $_REQUEST['total'];
    $shpType = $_REQUEST["li_0_co2_option_id"];
    $itemId = $_REQUEST["li_0_co2_item_id"];
    $currency = osc_get_preference('currency', 'rupayments');
    $userid = $_REQUEST["li_0_co2_user_id"];
    $user = User::newInstance()->findByPrimaryKey($userid);
	$usemail= ModelRUpayments::newInstance()->getUseremail_rupayments($userid);
    
    /*
    ** UPD. v. 3.6.2
    */
    
    switch($shpType) {
        case 6 :
            $bonus = ModelRUpayments::newInstance()->getPack($itemId);
            if($bonus) {
                $pack_name = $bonus['f_pack_title'];
                
                if($bonus['f_pack_bonus']) {
                    $bonus_amount = $bonus['f_pack_bonus'];
                    $bonus_text = __(' + Bonus: ', 'rupayments') . $bonus_amount . osc_get_preference('currency', 'rupayments');    
                }
            }
        break;
        
        case 7 :
            $user_group = ModelRUpayments::newInstance()->getUserGroup($itemId);
            $user_group_title = $user_group['f_group_title'];
        break;
        
        case 17 :
            $ebuy_item = ModelRUpayments::newInstance()->getEbuyItem($itemId, true);
            $item = Item::newInstance()->findByPrimaryKey($ebuy_item['i_item_id']);
            $item_title = $item['s_title'];
        break;
    }
    
          
    if ( $shpType == 9 ) {
        $ist1 = '2Checkout';
        $pro2co = '231'; 
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Premium and Highlight fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Premium and Highlight fee for item (%s)', 'rupayments'), $itemId); 
    }  
    else if($shpType == 10){
        $ist1 = '2Checkout';
        $pro2co = '701';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Show Image fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 11){
        $ist1 = '2Checkout';
        $pro2co = '711';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Make Item Premium and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Make Item Premium and Show Image fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 12){
        $ist1 = '2Checkout';
        $pro2co = '721';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Make Item Highlighted and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Make Item Highlighted and Show Image fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 13){
        $ist1 = '2Checkout';
        $pro2co = '731';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Make Item Premium, Make Item Highlighted and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Make Item Premium, Make Item Highlighted and Show Image fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 14){
        $ist1 = '2Checkout';
        $pro2co = '801';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Apply: Pack 3-in-1 fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Apply: Pack 3-in-1 fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 15){
        $ist1 = '2Checkout';
        $pro2co = '811';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Activate Show Image and apply: Pack 3-in-1 fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Activate Show Image and apply: Pack 3-in-1 fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 16){
        $ist1 = '2Checkout';
        $pro2co = '901';
        $concept = sprintf(__('Payment of banner public fee (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 17){
        $ist1 = '2Checkout';
        $pro2co = '1001';
        $concept = sprintf(__('Payment of Item Purchase:  %s', 'rupayments'), $item_title);
    }
    else if ($shpType == 6) {
        $ist1 = '2Checkout';
        $pro2co = '501'; 
        $concept = sprintf(__('Credit <strong>' . $pack_name . '</strong>' . $bonus_text, 'rupayments'), $userid);
        $itemId = '0';
    } 
    else if($shpType == 7){
        $ist1 = '2Checkout';
        $pro2co = '601';
        $concept = sprintf(__("Payment of membership fee: %s", "rupayments"), $user_group_title);
    }
    else if ($shpType == 4){
        $ist1 = '2Checkout';
        $pro2co = '101'; // 'Publish';
        $concept = sprintf(__('Publish fee for item (%s)', 'rupayments'), $itemId);
    } 
    else if ($shpType == 3){
        $ist1 = '2Checkout';
        $pro2co = '301'; // 'Highlighted';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Highlight fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Highlight fee for item (%s)', 'rupayments'), $itemId);
    }
    else if ($shpType == 2){
        $ist1 = '2Checkout';
        $pro2co = '401'; // 'Top';
        $concept = sprintf(__('Move to Top fee for item (%s)', 'rupayments'), $itemId);
    }
	else if ($shpType == 21){
        $ist1 = '2Checkout';
        $pro2co = '411';
        $concept = sprintf(__('Renew fee for item (%s)', 'rupayments'), $itemId);
    }
    else if ($shpType == 1){
        $ist1 = '2Checkout';
        $pro2co = '201'; // 'Premium';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Premium fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Premium fee for item (%s)', 'rupayments'), $itemId);
    }
    
    if (osc_get_preference('co2_sandbox', 'rupayments') == 1) {
        $hashOrder = '1';
    } 
    else {
        $hashOrder = $_REQUEST['order_number'];
    }
    
    $StringToHash = strtoupper(md5($hashSecretWord . $hashSid . $hashOrder . $hashTotal));
     
    if ( $StringToHash != $crc  ) {  
        $result = 'Fail - Hash Mismatch';
    } 
    else { 
   
        $hashTotal  = round ( $hashTotal  );
        
         if ($shpType == 1) {
              
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              
              if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $itemId, $payment_id );
              
              if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($itemId)) ModelRUpayments::newInstance()->setImageShow($itemId, 0);
              ModelRUpayments::newInstance()->payPremiumFee ($itemId, $payment_id);
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_search_category_url());
		
         
      
         } else if ($shpType == 2) {
              
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              ModelRUpayments::newInstance()->setTopItem ($itemId);
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_search_category_url());
         } else if ($shpType == 21) {
              
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              ModelRUpayments::newInstance()->setRenew ($itemId);
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));

         } else if ($shpType == 3) {
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              
              if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $itemId, $payment_id );
              if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($itemId)) ModelRUpayments::newInstance()->setImageShow($itemId, 0);
              
              ModelRUpayments::newInstance()->setColor ($itemId);
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_search_category_url());

         
         }
         else if ($shpType == 4) {
              
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              ModelRUpayments::newInstance()->payPublishFee ($itemId, $payment_id);
              if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($itemId)) ModelRUpayments::newInstance()->setImageShow($itemId, 0);
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_search_category_url());
         
         }
         else if ( $shpType == 6) { // wallet
              
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 );
              ModelRUpayments::newInstance()->addWallet ($userid, $hashTotal + $bonus_amount);
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_route_url('rupayments-user-pack'));
         
         }
         else if ( $shpType == 7) { // membership
              
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 );
              ModelRUpayments::newInstance()->setUserMembership($itemId, $userid);
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_route_url('rupayments-user-membership'));
         
         }
         else if ( $shpType == 9 ) {
              
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              
              if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $itemId, $payment_id );
              if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($itemId)) ModelRUpayments::newInstance()->setImageShow($itemId, 0);
              
              ModelRUpayments::newInstance()->payPremiumWithColorFee ( $itemId, $payment_id );
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_search_category_url());
         
         } 
         else if ( $shpType == 10 ) {
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              
              if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $itemId, $payment_id );
              ModelRUpayments::newInstance()->setImageShow($itemId, 1);
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_search_category_url());
         
         }
         else if ( $shpType == 11 ) {
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              
              if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $itemId, $payment_id );
              ModelRUpayments::newInstance()->payPremiumFee ($itemId, $payment_id);
              ModelRUpayments::newInstance()->setImageShow($itemId, 1);
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_search_category_url());
         
         }
         else if ( $shpType == 12 ) {
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              
              if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $itemId, $payment_id );
              ModelRUpayments::newInstance()->setColor ($itemId);
              ModelRUpayments::newInstance()->setImageShow($itemId, 1);
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_search_category_url());
         
         }
         else if ( $shpType == 13 ) {
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              
              if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $itemId, $payment_id );
              
              ModelRUpayments::newInstance()->payPremiumFee ($itemId, $payment_id);
              ModelRUpayments::newInstance()->setColor ($itemId);
              ModelRUpayments::newInstance()->setImageShow($itemId, 1);
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_search_category_url());
         
         }
         else if ( $shpType == 14 ) {
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              
              if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $itemId, $payment_id );
              if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($itemId)) ModelRUpayments::newInstance()->setImageShow($itemId, 0);
              
              ModelRUpayments::newInstance()->setPack3in1($itemId, $payment_id);
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_search_category_url());
         
         }
         else if ( $shpType == 15 ) {
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              
              if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $itemId, $payment_id );
              
              ModelRUpayments::newInstance()->setPack3in1($itemId, $payment_id);
              ModelRUpayments::newInstance()->setImageShow($itemId, 1);
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_search_category_url());
         
         }
         else if ( $shpType == 16 ) {
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 

              ModelRUpayments::newInstance()->setUserBannerPay($itemId);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_route_url('rupayments-user-banners'));
         
         }
         else if ( $shpType == 17 ) {
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $ebuy_item['s_item_currency'], $usemail, $userid, $itemId, $pro2co, $ist1 ); 

              ModelRUpayments::newInstance()->setEbuyDealPay($itemId, $userid);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
              rupayments_js_redirect_to(osc_route_url('rupayments-user-ebuy-deals'));
         
         }
         else {   
             osc_add_flash_error_message(__("There was a problem processing your Payment. Please contact the administrators",'rupayments'));
             if(osc_is_web_user_logged_in()) {
                 rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));
             } else {
                 View::newInstance()->_exportVariableToView('item', Item::newInstance()->findByPrimaryKey($itemId));
                 rupayments_js_redirect_to(osc_item_url());
             }
         }
     }
   
?>