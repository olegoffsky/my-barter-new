<?php defined('ABS_PATH') or die('Access denied'); 
/*
 * Copyright 2017 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
    if ( !osc_logged_user_id() ) {  
        return false;
    }
    
    $user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());
    $ebuy_item = ModelRUpayments::newInstance()->getEbuyItem(Params::getParam('bid'));
    $item = Item::newInstance()->findByPrimaryKey($ebuy_item['i_item_id']);
    $check_ebuy_pay = ModelRUpayments::newInstance()->checkEbuyPay(Params::getParam('bid'), osc_logged_user_id());
    $wallet = ModelRUpayments::newInstance()->getWallet(osc_logged_user_id());
    
    $amount = isset ( $wallet['i_amount'] ) ? $wallet['i_amount'] : 0;
    if ( $amount != 0 ) {
        //$formatted_amount = osc_format_price($amount, osc_get_preference('currency', 'rupayments')); // /1000000
		if(osc_get_preference ( "currency", "rupayments" )=='BTC'){ 
			$amount2=number_format($amount,8);
		}else{
			$amount2=round($amount,2);
		}
        $credit_msg = sprintf(__('Your current credit is %s %s', 'rupayments'), $amount2, osc_get_preference ( "currency", "rupayments" ));
        //$formatted_amount = osc_format_price($amount/1000000, osc_get_preference('currency', 'rupayments'));
        //$credit_msg = sprintf(__('Wallet: Your current credit is %s', 'rupayments'), $formatted_amount);
    } else {
        $credit_msg = __('Your wallet is empty.', 'rupayments');
    }
    
    // Требуется для показа в некоторых платежных системах
    $sSite_title = mb_eregi_replace ( "http://", "", osc_base_url() );
    $sSite_title = "From ".mb_eregi_replace ( "/", "", $sSite_title );
    
    if(!$check_ebuy_pay || !$ebuy_item) {
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_error_message(_m('Error: You can\'t pay for the item!', 'rupayments'));
        osc_redirect_to(osc_route_url('rupayments-user-ebuy-deals'));
    }
?>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">

<div class="menu_ppaypal">
    <h2 class="paypal_h"><?php _e('Pay for Item Purchase', 'rupayments'); ?>: <?php echo $item['s_title']; ?></h2>
</div>

<div class="banner-publish-fee-block" style="margin-left: 0;">
    <p><strong><?php _e('Payment amount', 'rupayments') ?>:</strong> <?php echo $ebuy_item['s_item_price'] . $ebuy_item['s_item_currency']; ?></p>
</div>

<?php if ( isset ($wallet['formatted_amount']) && (bccomp($wallet['formatted_amount'],$ebuy_item['s_item_price'],8) == 1 || bccomp($wallet['formatted_amount'],$ebuy_item['s_item_price'],8) == 0) && $ebuy_item['s_item_currency'] == osc_get_preference ( "currency", "rupayments" )) :?>
    <h3 class="uservicepayh3"><?php echo $credit_msg; ?></h3>
    <div class="scrilpack">
        <?php wallet_button($ebuy_item['s_item_price'], sprintf(__("Payment of Item Purchase: %s", "rupayments"), $item['s_title']), "1001x".$ebuy_item['fk_i_ebuy_id'], array('user' => @$user['pk_i_id'], 'itemid' => $ebuy_item['fk_i_ebuy_id'], 'email' => @$user['s_email'] ) ); ?>
    </div>
<?php endif; ?>

<div class="scrilpack">
<?php   
if ( osc_get_preference("paypal_enabled", "rupayments") == 1 ) Paypal::button( $ebuy_item['s_item_price'], sprintf(__("Payment of Item Purchase: %s", "rupayments"), $item['s_title']), '1001x'.$ebuy_item['fk_i_ebuy_id'], array('user' => @$user['pk_i_id'], 'itemid' => $ebuy_item['fk_i_ebuy_id'], 'email' => @$user['s_email']), $ebuy_item['s_item_currency']); 
?>
</div>

<div class="scrilpack">
<?php   
if ( osc_get_preference("co2_enabled", "rupayments") == 1 ) ModelChekout::button( $ebuy_item['s_item_price'], sprintf(__("Payment of Item Purchase: %s", "rupayments"), $item['s_title']), $ebuy_item['fk_i_ebuy_id'], $user['pk_i_id'], 17, __("Payment of Item Purchase: ", "rupayments") . $item['s_title'], $ebuy_item['fk_i_ebuy_id'], $ebuy_item['s_item_currency']);  
?>
</div>
 <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("interkassa_enabled", "rupayments") == 1 ) Interkassa::button ( @$user['s_email'], $ebuy_item['s_item_price'], "1001", $ebuy_item['fk_i_ebuy_id'], __("Payment of Item Purchase: ", "rupayments") . $item['s_title'], '', $ebuy_item['s_item_currency'] ); 
?>
       </div>
	          <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("lp_enabled", "rupayments") == 1 ) Liqpay::button ( @$user['s_email'], $ebuy_item['s_item_price'], "1001", $ebuy_item['fk_i_ebuy_id'], __("Payment of Item Purchase: ", "rupayments") . $item['s_title'], '', $ebuy_item['s_item_currency'] ); 
?>
       </div>
<div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("robokassa_enabled", "rupayments") == 1 ) Robokassa::button ( @$user['s_email'], $ebuy_item['s_item_price'], "1001", $ebuy_item['fk_i_ebuy_id'], __("Payment of Item Purchase: ", "rupayments") . $item['s_title'], '', $ebuy_item['s_item_currency'] ); 
?>
       </div>
 <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("wo_enabled", "rupayments") == 1 ) Walletone::button ( @$user['s_email'], $ebuy_item['s_item_price'], "1001", $ebuy_item['fk_i_ebuy_id'], __("Payment of Item Purchase: ", "rupayments") . $item['s_title'], '', $ebuy_item['s_item_currency'] ); 
?>
 </div>
 <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("payeer_enabled", "rupayments") == 1 ) Payeer::button ( @$user['s_email'], $ebuy_item['s_item_price'], "1001", $ebuy_item['fk_i_ebuy_id'], __("Payment of Item Purchase: ", "rupayments") . $item['s_title'], '', $ebuy_item['s_item_currency'] ); 
?>
       </div>
 <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("freekassa_enabled", "rupayments") == 1 ) Freekassa::button ( @$user['s_email'], $ebuy_item['s_item_price'], "1001", $ebuy_item['fk_i_ebuy_id'], __("Payment of Item Purchase: ", "rupayments") . $item['s_title'], '', $ebuy_item['s_item_currency'] ); 
?>
       </div>	   
<div class="scrilpack">
<?php   
if ( osc_get_preference("blockchain_enabled", "rupayments") == 1 ) Modelblockchain::button( $ebuy_item['s_item_price'], sprintf(__("Payment of Item Purchase: %s", "rupayments"), $item['s_title']), $ebuy_item['fk_i_ebuy_id'], $user['pk_i_id'], 17, __("Payment of Item Purchase: ", "rupayments") . $item['s_title'], $ebuy_item['fk_i_ebuy_id']);  
?>
</div>
<div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("yandex_enabled", "rupayments") == 1 ) Yandex::button ( @$user['s_email'], $ebuy_item['s_item_price'], "1001", $ebuy_item['fk_i_ebuy_id'], __("Payment of Item Purchase: ", "rupayments") . $item['s_title'], 0 ); 
?>
       </div>
 <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("webmoney_enabled", "rupayments") == 1 ) Webmoney::button ( @$user['s_email'], $ebuy_item['s_item_price'], "1001", $ebuy_item['fk_i_ebuy_id'], __("Payment of Item Purchase: ", "rupayments") . $item['s_title'], '', $ebuy_item['s_item_currency'] ); 
?>
       </div>	