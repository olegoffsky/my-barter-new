<?php
/*
 * Copyright 2017 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
    if ( !osc_logged_user_id() ) {  
        return false;
    }
  
    $packs = ModelRUpayments::newInstance()->getPacks();
    
    $user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());
    $wallet = ModelRUpayments::newInstance()->getWallet(osc_logged_user_id());
    $amount = isset($wallet['i_amount'])?$wallet['i_amount']:0;
        if($amount!=0) {
		
		if(osc_get_preference ( "currency", "rupayments" )=='BTC'){ 
			$amount2=number_format($amount,8);
		}else{
			$amount2=round($amount,2);
		}
			
            $credit_msg = sprintf(__('Your current credit is %s %s', 'rupayments'), $amount2, osc_get_preference ( "currency", "rupayments" ));
            
            //$formatted_amount = osc_format_price($amount/1000000, osc_get_preference('currency', 'rupayments'));
            //$credit_msg = sprintf(__('Credit packs. Your current credit is %s', 'rupayments'), $formatted_amount);
        } else {
            $credit_msg = __('Your wallet is empty. Buy some credits.', 'rupayments');
        }
    
    // Требуется для показа в некоторых платежных системах
    $sSite_title = mb_eregi_replace ( "http://", "", osc_base_url() );
    $sSite_title = "From ".mb_eregi_replace ( "/", "", $sSite_title );

?>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">

<div class="rupayments">
<h2><span class="mdi mdi-wallet mdi-24px"></span><?php echo $credit_msg; ?></h2></div>
<div id="ollpaysystem">
<table cellpadding="5" cellspacing="5" style="width: 100%;">

<?php if($packs): ?> 
    <?php foreach($packs as $pack) : ?>
        <tr>
           <td colspan="8">
               <div class="menuwallet" style="background-color: <?php echo $pack['f_pack_color']; ?>; repeat-x scroll 0px 0px;text-align: center;"><h2><span class="mdi mdi-currency-usd mdi-24px"></span><?php echo $pack['f_pack_title']; ?> - <?php _e("Price", "rupayments");?>: <?php echo $pack['f_pack_amount'] . " " . osc_get_preference('currency', 'rupayments'); ?> <small><?php echo $pack['f_pack_description']; ?></small></h2></div>
            </td> 
        </tr>
        <tr align="center">
    	<td>
           <div class="scrilpack">
    <?php   
            if ( osc_get_preference("paypal_enabled", "rupayments") == 1 ) Paypal::button( $pack['f_pack_amount'], sprintf(__("Credit for %s %s at %s", "rupayments"), $pack['f_pack_amount'], osc_get_preference("currency", "rupayments"), osc_page_title()), '501x'.$pack['fk_i_pack_id'], array('user' => @$user['pk_i_id'], 'itemid' => @$user['pk_i_id'], 'email' => @$user['s_email'])); 
    ?>
           </div>
           <div class="scrilpack">
    <?php   
            if ( osc_get_preference("co2_enabled", "rupayments") == 1 ) ModelChekout::button( $pack['f_pack_amount'], sprintf(__("Credit for %s%s at %s", "rupayments"), $pack['f_pack_amount'], osc_get_preference("currency", "rupayments"), osc_page_title()), $pack['fk_i_pack_id'], $user['pk_i_id'], 6, sprintf(__("Add funds: %s", "rupayments"), $pack['f_pack_title']), $pack['fk_i_pack_id']);  
    ?>
           </div>
  <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("interkassa_enabled", "rupayments") == 1 ) Interkassa::button ( @$user['s_email'], $pack['f_pack_amount'], "501", $pack['fk_i_pack_id'], sprintf(__("Credit for: %s", "rupayments"), $pack['f_pack_title'])); 
?>
       </div>
	          <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("lp_enabled", "rupayments") == 1 ) Liqpay::button ( @$user['s_email'], $pack['f_pack_amount'], "501", $pack['fk_i_pack_id'], sprintf(__("Credit for: %s", "rupayments"), $pack['f_pack_title']) ); 
?>
       </div>
<div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("robokassa_enabled", "rupayments") == 1 ) Robokassa::button ( @$user['s_email'], $pack['f_pack_amount'], "501", $pack['fk_i_pack_id'], sprintf(__("Credit for: %s", "rupayments"), $pack['f_pack_title']) ); 
?>
       </div>
 <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("wo_enabled", "rupayments") == 1 ) Walletone::button ( @$user['s_email'], $pack['f_pack_amount'], "501", $pack['fk_i_pack_id'], sprintf(__("Credit for: %s", "rupayments"), $pack['f_pack_title']) ); 
?>
 </div>
   <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("payeer_enabled", "rupayments") == 1 ) Payeer::button ( @$user['s_email'], $pack['f_pack_amount'], "501", $pack['fk_i_pack_id'], sprintf(__("Credit for: %s", "rupayments"), $pack['f_pack_title'])); 
?>
       </div>
  <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("freekassa_enabled", "rupayments") == 1 ) Freekassa::button ( @$user['s_email'], $pack['f_pack_amount'], "501", $pack['fk_i_pack_id'], sprintf(__("Credit for: %s", "rupayments"), $pack['f_pack_title'])); 
?>
       </div>
    	   
    	          <div class="scrilpack">
    <?php   
           if ( osc_get_preference("blockchain_enabled", "rupayments") == 1 ) Modelblockchain::button( $pack['f_pack_amount'], sprintf(__("Credit for %s%s at %s", "rupayments"), $pack['f_pack_amount'], osc_get_preference("currency", "rupayments"), osc_page_title()), $pack['fk_i_pack_id'], $user['pk_i_id'], 6, sprintf(__("Add funds: %s", "rupayments"), $pack['f_pack_title']), $pack['fk_i_pack_id']);  
    ?>
           </div>
           <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("yandex_enabled", "rupayments") == 1 ) Yandex::button ( @$user['s_email'], $pack['f_pack_amount'], "501", $pack['fk_i_pack_id'], sprintf(__("Credit for: %s", "rupayments"), $pack['f_pack_title']), $pack['fk_i_pack_id'] ); 
?>
       </div>
	     <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("webmoney_enabled", "rupayments") == 1 ) Webmoney::button ( @$user['s_email'], $pack['f_pack_amount'], "501", $pack['fk_i_pack_id'], sprintf(__("Credit for: %s", "rupayments"), $pack['f_pack_title'])); 
?>
       </div>
           <?php   
                if ( osc_get_preference("fortumo_enabled", "rupayments") == 1 ){?>
        <div class="menuwallet" style="background-color: #02baab; repeat-x scroll 0px 0px;text-align: center;"><h2><?php _e("SMS", "rupayments");?></h2></div>	          
        <div class="rupayments">   
        <?php   
         Modelfortumo::button( $pack['f_pack_amount'], sprintf(__("Credit for %s%s at %s", "rupayments"), $pack['f_pack_amount'], osc_get_preference("currency", "rupayments"), osc_page_title()), $pack['fk_i_pack_id'], $user['pk_i_id'], 6, sprintf(__("Add funds: %s", "rupayments"), $pack['f_pack_title']), $pack['fk_i_pack_id']);  ?>
        	 </div>		
        	<?php } ?>
    	   </td> 
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</table>

</br> 
</div>
<div name="result_div" id="result_div"></div>
<style>small{font-size: 12px;}</style>
<script type="text/javascript">
    var rd = document.getElementById("result_div");
</script>