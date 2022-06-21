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
    
    $memberships = ModelRUpayments::newInstance()->getUserGroups();
    
    $user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());
    $user_membership = ModelRUpayments::newInstance()->getUserMembership(osc_logged_user_id());
    $wallet = ModelRUpayments::newInstance()->getWallet(osc_logged_user_id());
    
    // Требуется для показа в некоторых платежных системах
    $sSite_title = mb_eregi_replace ( "http://", "", osc_base_url() );
    $sSite_title = "From ".mb_eregi_replace ( "/", "", $sSite_title );
?>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/membership.css">
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">

<div class="menu_ppaypal">
    <h2 class="paypal_h"><?php _e('Membership', 'rupayments'); ?></h2>
</div>

<div class="menuwallet" style="background-color: #c0c0c0; text-align: center; margin-bottom: 30px!important;">
    <h2 style="margin-top: 9px!important; letter-spacing: 0!important;">
        <?php _e('Your Membership Plan:', 'rupayments'); ?>
        <?php if($user_membership): ?>
            <strong><?php echo $user_membership['f_group_title']; ?></strong> <em style="font-size: 12px!important;">(<?php _e('Date Expired:', 'rupayments'); ?> <?php echo $user_membership['f_date_expired']; ?>)</em>
        <?php else: ?>
            <strong><?php _e('Basic', 'rupayments'); ?></strong>
        <?php endif; ?>
    </h2>
</div>

<?php if($memberships): ?>
    <span class="info-block">1. <?php _e('Select membership plan', 'rupayments'); ?>:</span>
    <?php foreach($memberships as $membership): ?>
    <div class="membership-block <?php if(isset($user_membership['f_group_id']) && $user_membership['f_group_id'] != $membership['fk_i_group_id']): ?>membership-disabled<?php endif; ?>">
        <div class="panel price">
            <div class="panel-heading text-center">
                <h3 id="membership-title"><?php echo $membership['f_group_title']; ?></h3>
            </div>
            <div class="panel-body text-center" style="background-color: <?php echo $membership['f_group_color']; ?>;">
                <p id="membership-price" class="lead"><?php echo $membership['f_group_price'] . osc_get_preference('currency', 'rupayments'); ?></p>
            </div>
            <ul class="list-group">
                <?php if($membership['f_group_description']): ?>
                <li class="list-group-item"><?php echo $membership['f_group_description']; ?></li>
                <?php endif; ?>
                <?php if($membership['f_group_discount']): ?>
                <li class="list-group-item"><i class="fa fa-check" style="color: <?php echo $membership['f_group_color']; ?>;"></i> <?php _e('Services discount:', 'rupayments'); ?> <?php echo $membership['f_group_discount']; ?>%</li>
                <?php endif; ?>
                <li class="list-group-item"><i class="fa fa-check" style="color: <?php echo $membership['f_group_color']; ?>;"></i> <?php _e('Duration:', 'rupayments'); ?> <?php echo $membership['f_group_period']; ?> <?php _e('days', 'rupayments'); ?></li>
            </ul>
            <div class="panel-footer"> 
                <?php if((isset($user_membership['f_group_id']) && $user_membership['f_group_id'] == $membership['fk_i_group_id']) || !isset($user_membership['f_group_id'])): ?>
                <a id="select-membership-btn" membership-id="<?php echo $membership['fk_i_group_id']; ?>" class="btn btn-lg btn-block btn-primary" style="background-color: <?php echo $membership['f_group_color']; ?>; border-color: <?php echo $membership['f_group_color']; ?>;" href="javascript:void(0);"> <?php if(isset($user_membership['f_group_id'])): ?><?php _e('Extend Membership', 'rupayments'); ?><?php else: ?><?php _e('Select Plan', 'rupayments'); ?><?php endif; ?></a>
                <?php else: ?>
                <a class="btn btn-lg btn-block btn-primary" style="background-color: #ccc; border-color: #ccc;" href="javascript:void(0);"><?php _e('Plan Disabled', 'rupayments'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    
    <div id="membership-payments-block" style="display: none;">
        <span class="info-block">2. <?php _e('Select a Payment Method', 'rupayments'); ?>:</span>
        
        <?php foreach($memberships as $membership): ?>
        <div id="membership-payments" block-id="<?php echo $membership['fk_i_group_id']; ?>" style="display: none;">
            
            <?php if ( isset ($wallet['formatted_amount']) && (bccomp($wallet['formatted_amount'],$membership['f_group_price'],8) == 1 || bccomp($wallet['formatted_amount'],$membership['f_group_price'],8) == 0)) :?>
            <div class="scrilpack">
                <?php wallet_button($membership['f_group_price'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']), "601x".$membership['fk_i_group_id'], array('user' => @$user['pk_i_id'], 'itemid' => $membership['fk_i_group_id'], 'email' => @$user['s_email'] ) ); ?>
            </div>
            <?php endif; ?>
            
            <div class="scrilpack">
            <?php   
            if ( osc_get_preference("paypal_enabled", "rupayments") == 1 ) Paypal::button( $membership['f_group_price'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']), '601x'.$membership['fk_i_group_id'], array('user' => @$user['pk_i_id'], 'itemid' => $membership['fk_i_group_id'], 'email' => @$user['s_email'])); 
            ?>
            </div>
            
            <div class="scrilpack">
            <?php   
            if ( osc_get_preference("co2_enabled", "rupayments") == 1 ) ModelChekout::button( $membership['f_group_price'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']), $membership['fk_i_group_id'], $user['pk_i_id'], 7, sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']), $membership['fk_i_group_id']);  
            ?>
            </div>
			
  <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("interkassa_enabled", "rupayments") == 1 ) Interkassa::button ( @$user['s_email'], $membership['f_group_price'], "601", $membership['fk_i_group_id'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']) ); 
?>
       </div>
	          <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("lp_enabled", "rupayments") == 1 ) Liqpay::button ( @$user['s_email'], $membership['f_group_price'], "601", $membership['fk_i_group_id'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title'])  ); 
?>
       </div>
<div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("robokassa_enabled", "rupayments") == 1 ) Robokassa::button ( @$user['s_email'], $membership['f_group_price'], "601", $membership['fk_i_group_id'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title'])  ); 
?>
       </div>
 <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("wo_enabled", "rupayments") == 1 ) Walletone::button ( @$user['s_email'], $membership['f_group_price'], "601", $membership['fk_i_group_id'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title'])  ); 
?>
 </div>           
  <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("payeer_enabled", "rupayments") == 1 ) Payeer::button ( @$user['s_email'], $membership['f_group_price'], "601", $membership['fk_i_group_id'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']) ); 
?>
       </div>
  <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("freekassa_enabled", "rupayments") == 1 ) Freekassa::button ( @$user['s_email'], $membership['f_group_price'], "601", $membership['fk_i_group_id'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']) ); 
?>
       </div>	   
            	   
            <div class="scrilpack">
            <?php   
            if ( osc_get_preference("blockchain_enabled", "rupayments") == 1 ) Modelblockchain::button( $membership['f_group_price'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']), $membership['fk_i_group_id'], $user['pk_i_id'], 7, sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']), $membership['fk_i_group_id']);  
            ?>
            </div>
               <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("yandex_enabled", "rupayments") == 1 ) Yandex::button ( @$user['s_email'], $membership['f_group_price'], "601", $membership['fk_i_group_id'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']) , 0 ); 
?>
       </div> 
  <div class="scrilpack">                                                                               
<?php   
        if ( osc_get_preference("webmoney_enabled", "rupayments") == 1 ) Webmoney::button ( @$user['s_email'], $membership['f_group_price'], "601", $membership['fk_i_group_id'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']) ); 
?>
       </div>	 	   
            <?php   
            if ( osc_get_preference("fortumo_enabled", "rupayments") == 1 ){?>
                <div class="menuwallet" style="background-color: #02baab; repeat-x scroll 0px 0px;text-align: center;"><h2><?php _e("SMS", "rupayments");?></h2></div>	          
                <div class="rupayments">   
                <?php   
                 Modelfortumo::button( $membership['f_group_price'], sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']), $membership['fk_i_group_id'], $user['pk_i_id'], 7, sprintf(__("Payment of membership fee: %s", "rupayments"), $membership['f_group_title']), $membership['fk_i_group_id']);  ?>
                </div>		
            <?php } ?>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script type="text/javascript">
$('a#select-membership-btn').click(function(){
    var id = $(this).attr('membership-id');
    
    $(this).parents('div.membership-block').css('opacity',1).addClass('membership-active').siblings('div.membership-block').css('opacity',0.4).removeClass('membership-active').find('a#select-membership-btn').html('<?php _e('Select Plan', 'rupayments'); ?>');
    $(this).html('<i class="fa fa-check"></i> <?php _e('Plan Selected', 'rupayments'); ?>').css('opacity',1);
    $('#membership-payments-block').slideDown();
    $('div#membership-payments').hide();
    $('div#membership-payments[block-id="' + id + '"]').show();
});
</script>