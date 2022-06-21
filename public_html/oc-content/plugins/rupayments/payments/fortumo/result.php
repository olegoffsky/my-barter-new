<?php

	define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
    require_once ABS_PATH . 'oc-load.php';
             

  function check_signature($params_array, $secret) {
    ksort($params_array);

    $str = '';
    foreach ($params_array as $k=>$v) {
      if($k != 'sig') {
        $str .= "$k=$v";
      }
    }
    $str .= $secret;
    $signature = md5($str);

    return ($params_array['sig'] == $signature);
  }


  if(!preg_match("/completed/i", $_GET['status'])) { exit('nocompleted');}
  $test = $_GET['test']; 
  if($test){
    echo('TEST OK');
  }
  else {
    echo('OK');
  }


    $hashSid = osc_get_preference('fortumo_mrhlogin', 'rupayments');
    $hashSecretWord = osc_get_preference('fortumo_secret_word', 'rupayments');
	$currency = osc_get_preference('currency', 'rupayments');
    $cuid = base64_decode(Params::getParam('cuid'));
    $cuid = json_decode($cuid, true);
    $hashTotal = Params::getParam('amount');
	$shpType = intval($cuid["type"]);
    $itemId = intval($cuid["invId"]);
    $userid = intval($cuid["userid"]);
	

  if(empty($hashSecretWord)||!check_signature($_GET, $hashSecretWord)) {
    header("HTTP/1.0 404 Not Found");
    die("Error: Invalid signature");
  }
  
    $user = User::newInstance()->findByPrimaryKey($userid);
	$usemail= ModelRUpayments::newInstance()->getUseremail_rupayments($userid);
    
    /*
    ** UPD. v. 3.6.2
    */
    switch($shpType) {
        case 6 :
            $bonus = ModelRUpayments::newInstance()->getPack($itemId);
            $pack_name = $bonus['f_pack_title'];
        
            if($bonus['f_pack_bonus']) {
                $bonus_amount = $bonus['f_pack_bonus'];
                $bonus_text = __(' + Bonus: ', 'rupayments') . $bonus_amount . osc_get_preference('currency', 'rupayments');    
            }
        break;
        
        case 7 :
            $user_group = ModelRUpayments::newInstance()->getUserGroup($itemId);
            $user_group_title = $user_group['f_group_title'];
        break;
    }
          
    if ( $shpType == 9 ) {
        $ist1 = 'Fortumo';
        $pro2co = '231'; 
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Premium and Highlight fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Premium and Highlight fee for item (%s)', 'rupayments'), $itemId); 
    }  
    else if($shpType == 10){
        $ist1 = 'Fortumo';
        $pro2co = '701';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Show Image fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 11){
        $ist1 = 'Fortumo';
        $pro2co = '711';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Make Item Premium and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Make Item Premium and Show Image fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 12){
        $ist1 = 'Fortumo';
        $pro2co = '721';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Make Item Highlighted and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Make Item Highlighted and Show Image fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 13){
        $ist1 = 'Fortumo';
        $pro2co = '731';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish, Make Item Premium, Make Item Highlighted and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Make Item Premium, Make Item Highlighted and Show Image fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 14){
        $ist1 = 'Fortumo';
        $pro2co = '801';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Apply: Pack 3-in-1 fee for item (%s)', 'rupayments'), $itemId);
    }
    else if($shpType == 15){
        $ist1 = 'Fortumo';
        $pro2co = '811';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Show Image fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Activate Show Image and apply: Pack 3-in-1 fee for item (%s)', 'rupayments'), $itemId);
    }
    else if ($shpType == 6) {
        $ist1 = 'Fortumo';
        $pro2co = '501'; 
        $concept = sprintf(__('Credit <strong>' . $pack_name . '</strong>' . $bonus_text, 'rupayments'), $userid);
        $itemId = '0';
    } 
    else if($shpType == 7){
        $ist1 = 'Fortumo';
        $pro2co = '601';
        $concept = sprintf(__("Payment of membership fee: %s", "rupayments"), $user_group_title);
    }
    else if ($shpType == 4){
        $ist1 = 'Fortumo';
        $pro2co = '101'; // 'Publish';
        $concept = sprintf(__('Publish fee for item (%s)', 'rupayments'), $itemId);
    } 
    else if ($shpType == 3){
        $ist1 = 'Fortumo';
        $pro2co = '301'; // 'Highlighted';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Highlight fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Highlight fee for item (%s)', 'rupayments'), $itemId);
    }
    else if ($shpType == 2){
        $ist1 = 'Fortumo';
        $pro2co = '401'; // 'Top';
        $concept = sprintf(__('Move to Top fee for item (%s)', 'rupayments'), $itemId);
    }
	else if ($shpType == 21){
        $ist1 = 'Fortumo';
        $pro2co = '411';
        $concept = sprintf(__('Renew fee for item (%s)', 'rupayments'), $itemId);
    }
    else if ($shpType == 1){
        $ist1 = 'Fortumo';
        $pro2co = '201'; // 'Premium';
        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $itemId ) ) $concept = sprintf(__('Publish and Premium fee for item (%s)', 'rupayments'), $itemId);
        else $concept = sprintf(__('Premium fee for item (%s)', 'rupayments'), $itemId);
    }
    
    if (osc_get_preference('fortumo_sandbox', 'rupayments') == 1) {
        $hashOrder = '1';
    } 
    else {
        $hashOrder = Params::getParam('payment_id');
    }
    

   
        $hashTotal  = round ( $hashTotal  );
        
        
          if ( $shpType == 6) {
              
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
         else {   
             osc_add_flash_error_message(__("There was a problem processing your Payment. Please contact the administrators",'rupayments'));
             if(osc_is_web_user_logged_in()) {
                 rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));
             } else {
                 View::newInstance()->_exportVariableToView('item', Item::newInstance()->findByPrimaryKey($itemId));
                 rupayments_js_redirect_to(osc_item_url());
             }
         }
 
   
?>