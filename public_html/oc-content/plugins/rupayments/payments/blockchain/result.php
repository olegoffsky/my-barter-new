<?php
		   /*
 * Copyright 2016 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

	define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
    require_once ABS_PATH . 'oc-load.php';
    
	/*
$file='test.txt';
if (!file_exists($file)) {  $fp = fopen($file, "w");}
foreach ($_REQUEST as $key =>$value){ $d.=$key.'='.$value.'&';
}file_put_contents($file, $d."\n", FILE_APPEND);


*/
		
    $hashSid = osc_get_preference('blockchain_mrhlogin', 'rupayments');
    $hashSecretWord = osc_get_preference('blockchain_secret_word', 'rupayments');
	$currency = osc_get_preference('currency', 'rupayments');
	$blocks_ok = osc_get_preference('blockchain_blocks', 'rupayments');
	
	$confirmations = Params::getParam('confirmations');
	if($confirmations==0){exit();}
	if($confirmations<$blocks_ok){exit();}
	echo'*ok*';
	
	$hashOrder = Params::getParam('address');
	$real_secret = Params::getParam('secret');
	$invoice_id =  Params::getParam('invoice_id'); //invoice_id is passed back to the callback URL
	$transaction_hash =  Params::getParam('transaction_hash');
	$value_in_satoshi =  Params::getParam('value');
	$bitsum = $value_in_satoshi / 100000000;

	if($real_secret!=$hashSecretWord){exit();}

$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$thisok=1;
$hashOrder=mysqli_real_escape_string($link, $hashOrder);
$queryH ="SELECT * FROM oc_t_rupayments_bitcoin WHERE trans_id = '".$hashOrder."' LIMIT 1";
$resultH = mysqli_query($link,$queryH); 
$DlsH=mysqli_num_rows($resultH);
       if ($DlsH>0) {
while($rowH = mysqli_fetch_array($resultH))
{ 
 $timelast=$rowH['curr'];
 $time=$rowH['time']; 
 $shpType=$rowH['var1'];
 $itemId=$rowH['var2'];
 $userid=$rowH['uid'];

 $thispay=$rowH['curr'];
 $thisok=$rowH['ok'];
 $hashTotal=$rowH['sum'];
 }

}else{ exit();}

if( $thisok>0){exit();}

if(bccomp($bitsum,$thispay,10)==-1){exit();}

$query2 ="UPDATE oc_t_rupayments_bitcoin SET `ok` = '1'  WHERE trans_id = '".$hashOrder."' LIMIT 1";
$result2 = mysqli_query($link,$query2); 	

  
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
        $ist1 = 'Blockchain';
        $pro2co = '231'; 
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Premium and Highlight fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Premium and Highlight fee for item (%s)', 'rupayments'), $itemId); 
    } 
    else if ($shpType == 10){
        $ist1 = 'Blockchain';
        $pro2co = '701';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Show Image fee for item (%s)', 'rupayments'), $itemId);
    } 
    else if ($shpType == 11){
        $ist1 = 'Blockchain';
        $pro2co = '711';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Make Item Premium and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Make Item Premium and Show Image fee for item (%s)', 'rupayments'), $itemId);
    } 
    else if ($shpType == 12){
        $ist1 = 'Blockchain';
        $pro2co = '721';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Make Item Highlighted and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Make Item Highlighted and Show Image fee for item (%s)', 'rupayments'), $itemId);
    } 
    else if ($shpType == 13){
        $ist1 = 'Blockchain';
        $pro2co = '731';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Make Item Premium, Make Item Highlighted and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Make Item Premium, Make Item Highlighted and Show Image fee for item (%s)', 'rupayments'), $itemId);
    } 
    else if($shpType == 14){
        $ist1 = 'Blockchain';
        $pro2co = '801';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Apply: Pack 3-in-1 fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Apply: Pack 3-in-1 fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 15){
        $ist1 = 'Blockchain';
        $pro2co = '811';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Activate Show Image and apply: Pack 3-in-1 fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Activate Show Image and apply: Pack 3-in-1 fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 16){
        $ist1 = 'Blockchain';
        $pro2co = '901';
        $concept = sprintf(__('Payment of banner public fee (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 17){
        $ist1 = 'Blockchain';
        $pro2co = '1001';
        $concept = sprintf(__('Payment of Item Purchase:  %s', 'rupayments'), $item_title);
    }
    else if ($shpType == 6) {
        $ist1 = 'Blockchain';
        $pro2co = '501'; 
        $concept = sprintf(__('Credit <strong>' . $pack_name . '</strong>' . $bonus_text, 'rupayments'), $userid);
        $itemId = '0';
    } 
    else if($shpType == 7){
        $ist1 = 'Blockchain';
        $pro2co = '601';
        $concept = sprintf(__("Payment of membership fee: %s", "rupayments"), $user_group_title);
    }
    else if ($shpType == 4){
        $ist1 = 'Blockchain';
        $pro2co = '101'; // 'Publish';
        $concept = sprintf(__('Publish fee for item (%s)', 'rupayments'), $itemId);
    } 
    else if ($shpType == 3){
        $ist1 = 'Blockchain';
        $pro2co = '301'; // 'Highlighted';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Highlight fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Highlight fee for item (%s)', 'rupayments'), $itemId);
    }
    else if ($shpType == 2){
        $ist1 = 'Blockchain';
        $pro2co = '401'; // 'Top';
        $concept = sprintf(__('Move to Top fee for item (%s)', 'rupayments'), $itemId);
    }
	else if ($shpType == 21){
        $ist1 = 'Blockchain';
        $pro2co = '411'; 
        $concept = sprintf(__('Renew fee for item (%s)', 'rupayments'), $itemId);
    }
    else if ($shpType == 1){
        $ist1 = 'Blockchain';
        $pro2co = '201'; // 'Premium';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Premium fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Premium fee for item (%s)', 'rupayments'), $itemId);
    }
    

  
    

   
        $hashTotal  = round ( $hashTotal,10  );
        
        
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
             // rupayments_js_redirect_to(osc_search_category_url());
		
         
      
         } else if ($shpType == 2) {
              
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              ModelRUpayments::newInstance()->setTopItem ($itemId);
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
           //   rupayments_js_redirect_to(osc_search_category_url());
          } else if ($shpType == 21) {
              
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 ); 
              ModelRUpayments::newInstance()->setRenew ($itemId);
              
              $item = Item::newInstance()->findByPrimaryKey($itemId);
	          $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	          rupayments_send_email ( $item, osc_user(), 'offer', $pro2co );
	          View::newInstance()->_exportVariableToView('category', $category);
              // Уведомляем юзера о событии
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));

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
            //  rupayments_js_redirect_to(osc_search_category_url());

         
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
             // rupayments_js_redirect_to(osc_search_category_url());
         
         }
         else if ( $shpType == 6) {
              
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 );
              ModelRUpayments::newInstance()->addWallet ($userid, $hashTotal + $bonus_amount);
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
             // rupayments_js_redirect_to(osc_route_url('rupayments-user-pack'));
         
         }
         else if ( $shpType == 7) { // membership
              
              $payment_id = ModelRUpayments::newInstance()->saveLog ( $concept, $hashOrder, $hashTotal, $currency, $usemail, $userid, $itemId, $pro2co, $ist1 );
              ModelRUpayments::newInstance()->setUserMembership($itemId, $userid);
			  osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
         
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
            //  rupayments_js_redirect_to(osc_search_category_url());
         
         } else if ( $shpType == 10 ) {
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
                 //rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));
             } else {
                 //View::newInstance()->_exportVariableToView('item', Item::newInstance()->findByPrimaryKey($itemId));
               //  rupayments_js_redirect_to(osc_item_url());
             }
         }
  
   
?>