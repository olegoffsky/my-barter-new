<?php

		   /*
 * Copyright 2016 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
	define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
    require_once ABS_PATH . 'oc-load.php';
	
	    $my_xpub = osc_get_preference('blockchain_mrhlogin', 'rupayments');
        $secret_word = osc_get_preference('blockchain_secret_word', 'rupayments');
        $my_api_key = osc_get_preference('blockchain_api_key_word', 'rupayments');
		$currency = osc_get_preference('currency', 'rupayments');
		
	
   $useridJson = base64_decode(Params::getParam('useridJson'));
	
    $cuid = json_decode($useridJson, true);
    $hashTotal = Params::getParam('amount');
    $description = Params::getParam('description');
	$shpType = intval($cuid["type"]);
    $itemId = intval($cuid["invId"]);
    $userid = intval($cuid["userid"]);

	//https://blockchain.info/tobtc?currency=USD&value=500

	if($currency!='BTC'){
$root_urlEx = 'https://blockchain.info/tobtc';
$parametersEx = 'currency=' .urlencode($currency). '&value=' .urlencode($hashTotal);
$bit = file_get_contents($root_urlEx . '?' . $parametersEx);		
}else{ $bit=$hashTotal; }
if(empty($bit)||$bit<=0){exit('error');}
	
$my_callback_url = osc_base_url() . 'oc-content/plugins/rupayments/payments/blockchain/result.php?secret='.$secret_word;
$root_url = 'https://api.blockchain.info/v2/receive';
$parameters = 'gap_limit=10000&xpub=' .$my_xpub. '&callback=' .urlencode($my_callback_url). '&key=' .$my_api_key;
$response = file_get_contents($root_url . '?' . $parameters);
$object = json_decode($response);
if(!isset($object->address)){exit('error');}

$db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD) or die();
$db->select_db(DB_NAME) or die();

$stmt = $db->prepare("INSERT INTO oc_t_rupayments_bitcoin (  uid, sum, trans_id, curr, var1, var2, time) VALUES ( ?, ?, ?, ?, ?, ?, ?)");
$t=time();
$adress=$object->address;
$stmt->bind_param("idsdssi",  $userid,  $hashTotal, $adress, $bit, $shpType, $itemId, $t);
$result = $stmt->execute();

echo '<p><b>'.base64_decode($description).'</b></p><br>';
echo '<p>'; echo __('Send Bitcoins to ', 'rupayments'); echo '<b>'.$adress . '</b></p>'; 
echo '<p>'; echo __(' Price ', 'rupayments'); echo '<b>'. $bit. ' BTC</b> </p><br>';
echo __('Proof of payment made after ', 'rupayments'); echo osc_get_preference('blockchain_blocks', 'rupayments'); echo __(' blocks (notifications) from Blockchain API ', 'rupayments');
echo '<p>'; echo __('It may take some time', 'rupayments'); echo '</p>';
if(osc_is_web_user_logged_in()) {
echo '<p><a href=' . osc_route_url('rupayments-user-pack') . '>' . __("Click here to go in Wallet", 'rupayments') . '</a></p>';
echo '<p><a href=' . osc_route_url('rupayments-user-menu') . '>' . __("Click here to go in User Menu", 'rupayments') . '</a></p>';
}