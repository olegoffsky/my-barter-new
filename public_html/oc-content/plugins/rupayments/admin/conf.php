<?php
/*
 * Copyright 2017 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

 //  For DEBUGing
    //define('OSC_DEBUG', true) ;
    //define('OSC_DEBUG_LOG', true) ;
ini_set ( 'error_reporting', '2047' ); // -1
ini_set ( 'log_errors', 'On' ); // On
error_reporting(E_ALL);

    if(Params::getParam('plugin_action')=='done') {
        osc_set_preference('default_premium_cost', Params::getParam("default_premium_cost") ? Params::getParam("default_premium_cost") : '1.0', 'rupayments', 'STRING');
	    osc_set_preference('default_top_cost', Params::getParam("default_top_cost") ? Params::getParam("default_top_cost") : '1.0', 'rupayments', 'STRING');
        osc_set_preference('default_color_cost', Params::getParam("default_color_cost") ? Params::getParam("default_color_cost") : '1.0', 'rupayments', 'STRING');
		osc_set_preference('default_renew_cost', Params::getParam("default_renew_cost") ? Params::getParam("default_renew_cost") : '1.0', 'rupayments', 'STRING');
		osc_set_preference('default_publish_cost', Params::getParam("default_publish_cost") ? Params::getParam("default_publish_cost") : '1.0', 'rupayments', 'STRING');
        osc_set_preference('allow_premium', Params::getParam("allow_premium") ? Params::getParam("allow_premium") : '0', 'rupayments', 'BOOLEAN');
		osc_set_preference('allow_renew', Params::getParam("allow_renew") ? Params::getParam("allow_renew") : '0', 'rupayments', 'BOOLEAN');
	    osc_set_preference('allow_move', Params::getParam("allow_move") ? Params::getParam("allow_move") : '0', 'rupayments', 'BOOLEAN');
	    osc_set_preference('allow_high', Params::getParam("allow_high") ? Params::getParam("allow_high") : '0', 'rupayments', 'BOOLEAN');
	    osc_set_preference('allow_after', Params::getParam("allow_after") ? Params::getParam("allow_after") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('pay_per_post', Params::getParam("pay_per_post") ? Params::getParam("pay_per_post") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('color_days', Params::getParam("color_days") ? Params::getParam("color_days") : '7', 'rupayments', 'INTEGER');
        osc_set_preference('premium_days', Params::getParam("premium_days") ? Params::getParam("premium_days") : '7', 'rupayments', 'INTEGER');
        osc_set_preference('currency', Params::getParam("currency") ? Params::getParam("currency") : 'USD', 'rupayments', 'STRING');
        osc_set_preference('pack_price_1', Params::getParam("pack_price_1"), 'rupayments', 'STRING');
        osc_set_preference('pack_price_2', Params::getParam("pack_price_2"), 'rupayments', 'STRING');
        osc_set_preference('pack_price_3', Params::getParam("pack_price_3"), 'rupayments', 'STRING');
        osc_set_preference('discount_for_premium_and_color', Params::getParam("discount_for_premium_and_color"), 'rupayments', 'INTEGER');
        osc_set_preference('days_before_deadline_for_sending_email', Params::getParam("days_before_deadline_for_sending_email"), 'rupayments', 'INTEGER');
		osc_set_preference('language', Params::getParam("language") ? Params::getParam("language") : 'en', 'rupayments', 'STRING');
		osc_set_preference('color', Params::getParam("color") ? Params::getParam("color") : 'F0E68C', 'rupayments', 'STRING');
		osc_set_preference('allow_regbonus', Params::getParam("allow_regbonus") ? Params::getParam("allow_regbonus") : '0', 'rupayments', 'BOOLEAN');
		osc_set_preference('regbonus_value', Params::getParam("regbonus_value") ? Params::getParam("regbonus_value") : '1', 'rupayments', 'STRING');
		osc_set_preference('allow_itempost_form', Params::getParam("allow_itempost_form") ? Params::getParam("allow_itempost_form") : '0', 'rupayments', 'BOOLEAN');
		osc_set_preference('allow_item_form', Params::getParam("allow_item_form") ? Params::getParam("allow_item_form") : '0', 'rupayments', 'BOOLEAN');
        
            /* Параметры подключения к РР */
        osc_set_preference('paypal_api_username', Params::getParam("paypal_api_username"), 'rupayments', 'STRING');
        osc_set_preference('paypal_api_password', Params::getParam("paypal_api_password"), 'rupayments', 'STRING');
        osc_set_preference('paypal_api_signature', Params::getParam("paypal_api_signature"), 'rupayments', 'STRING');
        osc_set_preference('paypal_email', Params::getParam("paypal_email"), 'rupayments', 'STRING');
        osc_set_preference('paypal_standard', Params::getParam("paypal_standard") ? Params::getParam("paypal_standard") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('paypal_sandbox', Params::getParam("paypal_sandbox") ? Params::getParam("paypal_sandbox") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('paypal_enabled', Params::getParam("paypal_enabled") ? Params::getParam("paypal_enabled") : '0', 'rupayments', 'BOOLEAN');
                 
            /* Параметры подключения к 2Chekout */
        //osc_set_preference('co2_email', '', 'rupayments', 'STRING');
        osc_set_preference('co2_sandbox', Params::getParam("co2_sandbox") ? Params::getParam("co2_sandbox") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('mrhlogin', Params::getParam("mrhlogin") ? Params::getParam("mrhlogin") : '', 'rupayments','STRING');
        osc_set_preference('secret_word', Params::getParam("secret_word") ? Params::getParam("secret_word") : '', 'rupayments','STRING');
        osc_set_preference('co2_enabled', Params::getParam("co2_enabled") ? Params::getParam("co2_enabled") : '0', 'rupayments', 'BOOLEAN');
		
		
		            /* Параметры подключения к fortumo */
        //osc_set_preference('co2_email', '', 'rupayments', 'STRING');
        osc_set_preference('fortumo_sandbox', Params::getParam("fortumo_sandbox") ? Params::getParam("fortumo_sandbox") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('fortumo_mrhlogin', Params::getParam("fortumo_mrhlogin") ? Params::getParam("fortumo_mrhlogin") : '', 'rupayments','STRING');
        osc_set_preference('fortumo_language', Params::getParam("fortumo_language") ? Params::getParam("fortumo_language") : '', 'rupayments','STRING');
        osc_set_preference('fortumo_secret_word', Params::getParam("fortumo_secret_word") ? Params::getParam("fortumo_secret_word") : '', 'rupayments','STRING');
        osc_set_preference('fortumo_enabled', Params::getParam("fortumo_enabled") ? Params::getParam("fortumo_enabled") : '0', 'rupayments', 'BOOLEAN');
		
		
          		            /* Параметры подключения к blockchain */

       osc_set_preference('blockchain_mrhlogin', Params::getParam("blockchain_mrhlogin") ? Params::getParam("blockchain_mrhlogin") : '', 'rupayments','STRING');
       osc_set_preference('blockchain_secret_word', Params::getParam("blockchain_secret_word") ? Params::getParam("blockchain_secret_word") : '', 'rupayments','STRING');
       osc_set_preference('blockchain_api_key_word', Params::getParam("blockchain_api_key_word") ? Params::getParam("blockchain_api_key_word") : '', 'rupayments','STRING');
        osc_set_preference('blockchain_enabled', Params::getParam("blockchain_enabled") ? Params::getParam("blockchain_enabled") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('blockchain_blocks', Params::getParam("blockchain_blocks") ? Params::getParam("blockchain_blocks") : '', 'rupayments', 'STRING');

		
            /* Параметры подключения к Braintree */
        osc_set_preference('braintree_MerchantAccountId', Params::getParam("braintree_MerchantAccountId") ? Params::getParam("braintree_MerchantAccountId") : '', 'rupayments', 'STRING');
        osc_set_preference('braintree_PublicKey', Params::getParam("braintree_PublicKey") ? Params::getParam("braintree_PublicKey") : '', 'rupayments','STRING');
        osc_set_preference('braintree_PrivateKey', Params::getParam("braintree_PrivateKey") ? Params::getParam("braintree_PrivateKey") : '', 'rupayments','STRING');
        osc_set_preference('braintree_MerchantAccountId_test', Params::getParam("braintree_MerchantAccountId_test") ? Params::getParam("braintree_MerchantAccountId_test") : '', 'rupayments', 'STRING');
        osc_set_preference('braintree_PublicKey_test', Params::getParam("braintree_PublicKey_test") ? Params::getParam("braintree_PublicKey_test") : '', 'rupayments','STRING');
        osc_set_preference('braintree_PrivateKey_test', Params::getParam("braintree_PrivateKey_test") ? Params::getParam("braintree_PrivateKey_test") : '', 'rupayments','STRING');
        osc_set_preference('braintree_Environment', Params::getParam("braintree_Environment") ? Params::getParam("braintree_Environment") : '0', 'rupayments', 'BOOLEAN'); // sandbox
        osc_set_preference('braintree_enabled', Params::getParam("braintree_enabled") ? Params::getParam("braintree_enabled") : '0', 'rupayments', 'BOOLEAN');
                       
            /* Параметры подключения к stripe */
        osc_set_preference('stripe_public_key', Params::getParam("stripe_public_key") ? Params::getParam("stripe_public_key") : '', 'rupayments','STRING');
        osc_set_preference('stripe_secret_key', Params::getParam("stripe_secret_key") ? Params::getParam("stripe_secret_key") : '', 'rupayments','STRING');
        osc_set_preference('stripe_public_key_test', Params::getParam("stripe_public_key_test") ? Params::getParam("stripe_public_key_test") : '', 'rupayments','STRING');
        osc_set_preference('stripe_secret_key_test', Params::getParam("stripe_secret_key_test") ? Params::getParam("stripe_secret_key_test") : '', 'rupayments','STRING');
        osc_set_preference('stripe_sandbox', Params::getParam("stripe_sandbox") ? Params::getParam("stripe_sandbox") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('stripe_enabled', Params::getParam("stripe_enabled") ? Params::getParam("stripe_enabled") : '0', 'rupayments', 'BOOLEAN');
                     
            /* Параметры подключения к PayUMoney */
        osc_set_preference('payumoney_Key', Params::getParam("payumoney_Key"), 'rupayments','STRING');
        osc_set_preference('payumoney_Salt', Params::getParam("payumoney_Salt"), 'rupayments','STRING');
        osc_set_preference('payumoney_Key_test', Params::getParam("payumoney_Key_test"), 'rupayments','STRING');
        osc_set_preference('payumoney_Salt_test', Params::getParam("payumoney_Salt_test"), 'rupayments','STRING');
        osc_set_preference('payumoney_sandbox', Params::getParam("payumoney_sandbox") ? Params::getParam("payumoney_sandbox") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('payumoney_enabled', Params::getParam("payumoney_enabled") ? Params::getParam("payumoney_enabled") : '0', 'rupayments', 'BOOLEAN');
                    
            /* Параметры подключения к Skrill */
        osc_set_preference('skrill_pay_to_email', Params::getParam("skrill_pay_to_email"), 'rupayments','STRING');
        osc_set_preference('skrill_merchant_id', Params::getParam("skrill_merchant_id"), 'rupayments','STRING');
        osc_set_preference('skrill_secret_word', Params::getParam("skrill_secret_word"), 'rupayments','STRING');
        //osc_set_preference('skrill_test_merchant_email', Params::getParam("skrill_test_merchant_email"), 'rupayments','STRING');
        //osc_set_preference('skrill_test_merchant_id', Params::getParam("skrill_test_merchant_id"), 'rupayments','STRING');
        //osc_set_preference('skrill_test_secret_word', Params::getParam("skrill_test_secret_word"), 'rupayments','STRING');
        osc_set_preference('skrill_recipient_description', Params::getParam("skrill_recipient_description"), 'rupayments','STRING');
        osc_set_preference('skrill_sandbox', Params::getParam("skrill_sandbox") ? Params::getParam("skrill_sandbox") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('skrill_enabled', Params::getParam("skrill_enabled") ? Params::getParam("skrill_enabled") : '0', 'rupayments', 'BOOLEAN');
		
		  /* Параметры подключения к Payulatam */
            osc_set_preference('payulatam_merchantId', Params::getParam("payulatam_merchantId"), 'rupayments', 'STRING');
            osc_set_preference('payulatam_accountId', Params::getParam("payulatam_accountId"), 'rupayments', 'STRING');
            osc_set_preference('payulatam_apikey', Params::getParam("payulatam_apikey"), 'rupayments', 'STRING');
            osc_set_preference('payulatam_language', Params::getParam("payulatam_language"), 'rupayments', 'STRING');
            osc_set_preference('payulatam_tax', Params::getParam("payulatam_tax"), 'rupayments', 'STRING');
            osc_set_preference('payulatam_taxReturnBase', Params::getParam("payulatam_taxReturnBase"), 'rupayments', 'STRING');
            osc_set_preference('payulatam_sandbox', Params::getParam("payulatam_sandbox") ? Params::getParam("payulatam_sandbox") : '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('payulatam_enabled', Params::getParam("payulatam_enabled") ? Params::getParam("payulatam_enabled") : '0', 'rupayments', 'BOOLEAN');
        
        
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
        osc_redirect_to(osc_route_admin_url('rupayments-admin-conf'));
    }
?>
<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/css/admin.css">
<script src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/js/jscolor.js"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<div class="credit-osclasspro"> <a href="https://osclass-pro.com/" target="_blank" class="pro_logo"> <img src="<?php echo osc_base_url();?>/oc-content/plugins/rupayments/admin/img/logo.png" alt="Premium themes and plugins" title="Premium themes and plugins" /> </a>
  <div class="follow">
    <ul>
      <li>Follow us <i class="fa fa-hand-o-right"></i></li>
      <li><a href="https://www.facebook.com/osclassprocom" target="_blank" title="facebook"><img src="<?php echo osc_base_url();?>/oc-content/plugins/rupayments/admin/img/facebook.png" alt=""></a></li>
      <li><a href="https://twitter.com/osclass_pro_com" target="_blank" title="twitter"><img src="<?php echo osc_base_url();?>/oc-content/plugins/rupayments/admin/img/twitter.png" alt=""></a></li>
    </ul>
  </div>
</div>
<div class="clear"></div>
<div id="tabsWithStyle" class="style-tabs">
<ul>
    <li><a href="#general-setting"><div class="icon facebook-icon"><?php _e('Ultimate Payments settings', 'rupayments'); ?></div></a></li>
	<li><a href="#category"><div class="icon facebook-icon"><?php _e('Category prices', 'rupayments'); ?></div></a></li>
	<li><a href="#policy"><div class="icon facebook-icon"><?php _e('Publishing policy', 'rupayments'); ?></div></a></li>
        <li><a href="#log"><div class="icon facebook-icon"><?php _e('Ultimate Payments log', 'rupayments'); ?></div></a></li>
	<li><a href="#bonus"><div class="icon facebook-icon"><?php _e('Add bonus', 'rupayments'); ?></div></a></li>
	<li><a href="#help"><div class="icon facebook-icon"><?php _e('Help', 'rupayments'); ?></div></a></li>
 </ul>

   
    <div id="general-setting">
        
        <h2 class="render-title"><b><i class="fa fa-cog"></i> <?php _e('Ultimate Payments settings', 'rupayments'); ?><b></h2>
        <ul id="error_list"></ul>
        <form name="rupayments_form" action="<?php echo osc_admin_base_url(true); ?>" method="post">
            <input type="hidden" name="page" value="plugins" />
            <input type="hidden" name="action" value="renderplugin" />
            <input type="hidden" name="route" value="rupayments-admin-conf" />
            <input type="hidden" name="plugin_action" value="done" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label"><?php _e('Premium ads', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                    <input type="checkbox" class="checkbox" id="checkbox" <?php echo (osc_get_preference('allow_premium', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_premium" value="1" />
                                    <label for="checkbox"><?php _e('Allow premium ads', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Default premium cost', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="default_premium_cost" value="<?php echo osc_get_preference('default_premium_cost', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Premium days', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="premium_days" value="<?php echo osc_get_preference('premium_days', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Move to Top', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                    <input type="checkbox" class="new2check" id="new2check"<?php echo (osc_get_preference('allow_move', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_move" value="1" />
                                    <label for="new2check"><?php _e('Allow move to top', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Default move to top', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="default_top_cost" value="<?php echo osc_get_preference('default_top_cost', 'rupayments'); ?>" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Highlight', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">

                                    <input type="checkbox" class="new2ch2eck" id="new2ch2eck" <?php echo (osc_get_preference('allow_high', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_high" value="1" />
                                    <label for="new2ch2eck"><?php _e('Allow highlighting', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Default highlighting', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="default_color_cost" value="<?php echo osc_get_preference('default_color_cost', 'rupayments'); ?>" />
                        </div>
                    </div><!-- new rupayments -->
                    <div class="form-row">
                        <div class="form-label"><?php _e('Highlighting days', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="color_days" value="<?php echo osc_get_preference('color_days', 'rupayments'); ?>" />
                        </div>
                    </div>
					<div class="form-row">
                        <div class="form-label"><?php _e('Highlight color', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input class="jscolor" type="text" class="xlarge" name="color" value="<?php echo osc_esc_html(osc_get_preference('color', 'rupayments')); ?>" style="background:<?php echo osc_esc_html(osc_get_preference('color', 'rupayments')); ?>;"/><span>
			    
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Discount for premium and highlighting both', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="discount_for_premium_and_color" value="<?php echo osc_get_preference('discount_for_premium_and_color', 'rupayments'); ?>" />
                        </div>
                    </div>
							<span class="help-box"><?php _e("Leave blank - if you don't want to use discount.", 'rupayments'); ?></span>
							<br>
					<!-- / new rupayments -->
                    <div class="form-row">
                        <div class="form-label"><?php _e('Publish fee', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                    <input type="checkbox" class="pay2per" id="pay2per"<?php echo (osc_get_preference('pay_per_post', 'rupayments') ? 'checked="true"' : ''); ?> name="pay_per_post" value="1" />
                                     <label for="pay2per"><?php _e('Pay per post ads', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
						<span class="help-box"><?php _e("Logout from oc-admin to test this function.", 'rupayments'); ?></span>
                    </div> 
                    <div class="form-row">
                        <div class="form-label"><?php _e('Default publish cost', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="default_publish_cost" value="<?php echo osc_get_preference('default_publish_cost', 'rupayments'); ?>" />
                        </div>
                    </div>
					 <div class="form-row">
                        <div class="form-label"><?php _e('Renew fee', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                    <input type="checkbox" class="pay2ren" id="pay2ren"<?php echo (osc_get_preference('allow_renew', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_renew" value="1" />
                                     <label for="pay2ren"><?php _e('Pay renew expiration item', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
                    </div> 
					<div class="form-row">
                        <div class="form-label"><?php _e('Default renew cost', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="default_renew_cost" value="<?php echo osc_get_preference('default_renew_cost', 'rupayments'); ?>" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('After publish', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                    <input type="checkbox" class="al2after" id="al2after"<?php echo (osc_get_preference('allow_after', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_after" value="1" />
                                    <label for="al2after"><?php _e('Allow after publish', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
						<span class="help-box"><?php _e("This option offers to user after the item publication -  paid services.", 'rupayments'); ?></span>
						<span class="help-box"><?php _e("Work Only if Item-post Form Disabled. Logout from oc-admin to test this function.", 'rupayments'); ?></span>
                    </div><!-- new rupayments -->
						<div class="form-row">
                        <div class="form-label"><?php _e('Item-post Form', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
							<input type="checkbox" class="al2form" id="al2form"<?php echo (osc_get_preference('allow_itempost_form', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_itempost_form" value="1" />
                                    <label for="al2form"><?php _e('Enable', 'rupayments'); ?>
                                <label>

                            </div>
                        </div>
                    </div>
					<span class="help-box"><?php _e("This option offers to user in the item publication step -  paid services.", 'rupayments'); ?></span>
					<span class="help-box"><?php _e("Logout from oc-admin to test this function.", 'rupayments'); ?></span>
					<div class="form-row">
                        <div class="form-label"><?php _e('Item Form', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
							<input type="checkbox" class="al2iform" id="al2iform"<?php echo (osc_get_preference('allow_item_form', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_item_form" value="1" />
                                    <label for="al2iform"><?php _e('Enable', 'rupayments'); ?>
                                <label>

                            </div>
                        </div>
                    </div>
					<span class="help-box"><?php _e("This option offers to user in the item page -  paid services.", 'rupayments'); ?></span>
					<span class="help-box"><?php _e("Logout from oc-admin to test this function.", 'rupayments'); ?></span>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Days (send e-mail) before payment deadline', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="days_before_deadline_for_sending_email" value="<?php echo osc_get_preference('days_before_deadline_for_sending_email', 'rupayments'); ?>" />
                        </div>
                    </div>
					<div class="form-row">
                        <div class="form-label"><?php _e('Bonus for new user', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                    <input type="checkbox" class="al2bonus" id="al2bonus"<?php echo (osc_get_preference('allow_regbonus', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_regbonus" value="1" />
                                    <label for="al2bonus"><?php _e('Enable bonus', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
                    </div> 
					</br>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Bonus value', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="regbonus_value" value="<?php echo osc_get_preference('regbonus_value', 'rupayments'); ?>" />
                        </div>
                    </div>
					<!-- / new rupayments -->
					<h3 class="render-title"><b><?php _e('Currency', 'rupayments'); ?><b></h3>
					<div class="form-row">
					<span class="help-box"><?php _e("IMPORTANT! Only 2checkout work with all currencies.", 'rupayments'); ?></span></div>
                    <div class="form-row">
					<span class="help-box"><?php _e("Payumoney work only with INR. Braintree and Fortumo setup currency in your merchant account. For other payment system - see in official sites.", 'rupayments'); ?></span>
					</div>
					<div class="form-row">
					
                        <div class="form-label"><?php _e('Default currency', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <select name="currency" id="currency">
                                <option value="AED" <?php if(osc_get_preference('currency', 'rupayments')=="AED") { echo 'selected="selected"';}; ?> >AED</option>
								<option value="AFN" <?php if(osc_get_preference('currency', 'rupayments')=="AFN") { echo 'selected="selected"';}; ?> >AFN</option>
								<option value="ALL" <?php if(osc_get_preference('currency', 'rupayments')=="ALL") { echo 'selected="selected"';}; ?> >ALL</option>
							    <option value="ARS" <?php if(osc_get_preference('currency', 'rupayments')=="ARS") { echo 'selected="selected"';}; ?> >ARS</option>
                                <option value="AUD" <?php if(osc_get_preference('currency', 'rupayments')=="AUD") { echo 'selected="selected"';}; ?> >AUD</option>
								<option value="AZN" <?php if(osc_get_preference('currency', 'rupayments')=="AZN") { echo 'selected="selected"';}; ?> >AZN</option>
								<option value="BBD" <?php if(osc_get_preference('currency', 'rupayments')=="BBD") { echo 'selected="selected"';}; ?> >BBD</option>
								<option value="BDT" <?php if(osc_get_preference('currency', 'rupayments')=="BDT") { echo 'selected="selected"';}; ?> >BDT</option>
								<option value="BGN" <?php if(osc_get_preference('currency', 'rupayments')=="BGN") { echo 'selected="selected"';}; ?> >BGN</option>
								<option value="BMD" <?php if(osc_get_preference('currency', 'rupayments')=="BMD") { echo 'selected="selected"';}; ?> >BMD</option>
								<option value="BTC" <?php if(osc_get_preference('currency', 'rupayments')=="BTC") { echo 'selected="selected"';}; ?> >BTC</option>
								<option value="BND" <?php if(osc_get_preference('currency', 'rupayments')=="BND") { echo 'selected="selected"';}; ?> >BND</option>
								<option value="BOB" <?php if(osc_get_preference('currency', 'rupayments')=="BOB") { echo 'selected="selected"';}; ?> >BOB</option>
								<option value="BSD" <?php if(osc_get_preference('currency', 'rupayments')=="BSD") { echo 'selected="selected"';}; ?> >BSD</option>
								<option value="BRL" <?php if(osc_get_preference('currency', 'rupayments')=="BRL") { echo 'selected="selected"';}; ?> >BRL</option>
								<option value="BWP" <?php if(osc_get_preference('currency', 'rupayments')=="BWP") { echo 'selected="selected"';}; ?> >BWP</option>
								<option value="BZD" <?php if(osc_get_preference('currency', 'rupayments')=="BZD") { echo 'selected="selected"';}; ?> >BZD</option>
								<option value="GBP" <?php if(osc_get_preference('currency', 'rupayments')=="GBP") { echo 'selected="selected"';}; ?> >GBP</option>
								<option value="CAD" <?php if(osc_get_preference('currency', 'rupayments')=="CAD") { echo 'selected="selected"';}; ?> >CAD</option>
								<option value="CLP" <?php if(osc_get_preference('currency', 'rupayments')=="CLP") { echo 'selected="selected"';}; ?> >CLP</option>
								<option value="CNY" <?php if(osc_get_preference('currency', 'rupayments')=="CNY") { echo 'selected="selected"';}; ?> >CNY</option>
								<option value="COP" <?php if(osc_get_preference('currency', 'rupayments')=="COP") { echo 'selected="selected"';}; ?> >COP</option>
								<option value="CHF" <?php if(osc_get_preference('currency', 'rupayments')=="CHF") { echo 'selected="selected"';}; ?> >CHF</option>
								<option value="CRC" <?php if(osc_get_preference('currency', 'rupayments')=="CRC") { echo 'selected="selected"';}; ?> >CRC</option>
								<option value="CZK" <?php if(osc_get_preference('currency', 'rupayments')=="CZK") { echo 'selected="selected"';}; ?> >CZK</option>
								<option value="DZD" <?php if(osc_get_preference('currency', 'rupayments')=="DZD") { echo 'selected="selected"';}; ?> >DZD</option>
								<option value="DKK" <?php if(osc_get_preference('currency', 'rupayments')=="DKK") { echo 'selected="selected"';}; ?> >DKK</option>
								<option value="DOP" <?php if(osc_get_preference('currency', 'rupayments')=="DOP") { echo 'selected="selected"';}; ?> >DOP</option>
								<option value="EGP" <?php if(osc_get_preference('currency', 'rupayments')=="EGP") { echo 'selected="selected"';}; ?> >EGP</option>
								<option value="EUR" <?php if(osc_get_preference('currency', 'rupayments')=="EUR") { echo 'selected="selected"';}; ?> >EUR</option>
                                <option value="FJD" <?php if(osc_get_preference('currency', 'rupayments')=="FJD") { echo 'selected="selected"';}; ?> >FJD</option>
								<option value="GTQ" <?php if(osc_get_preference('currency', 'rupayments')=="GTQ") { echo 'selected="selected"';}; ?> >GTQ</option>
								<option value="HKD" <?php if(osc_get_preference('currency', 'rupayments')=="HKD") { echo 'selected="selected"';}; ?> >HKD</option>
								<option value="HNL" <?php if(osc_get_preference('currency', 'rupayments')=="HNL") { echo 'selected="selected"';}; ?> >HNL</option>
								<option value="HRK" <?php if(osc_get_preference('currency', 'rupayments')=="HRK") { echo 'selected="selected"';}; ?> >HRK</option>
								<option value="HUF" <?php if(osc_get_preference('currency', 'rupayments')=="HUF") { echo 'selected="selected"';}; ?> >HUF</option>
								<option value="IDR" <?php if(osc_get_preference('currency', 'rupayments')=="IDR") { echo 'selected="selected"';}; ?> >IDR</option>
								<option value="INR" <?php if(osc_get_preference('currency', 'rupayments')=="INR") { echo 'selected="selected"';}; ?> >INR</option>
								<option value="ILS" <?php if(osc_get_preference('currency', 'rupayments')=="ILS") { echo 'selected="selected"';}; ?> >ILS</option>
								<option value="JMD" <?php if(osc_get_preference('currency', 'rupayments')=="JMD") { echo 'selected="selected"';}; ?> >JMD</option>
								<option value="JPY" <?php if(osc_get_preference('currency', 'rupayments')=="JPY") { echo 'selected="selected"';}; ?> >JPY</option>
								<option value="KES" <?php if(osc_get_preference('currency', 'rupayments')=="KES") { echo 'selected="selected"';}; ?> >KES</option>
								<option value="KRW" <?php if(osc_get_preference('currency', 'rupayments')=="KRW") { echo 'selected="selected"';}; ?> >KRW</option>
								<option value="KZT" <?php if(osc_get_preference('currency', 'rupayments')=="KZT") { echo 'selected="selected"';}; ?> >KZT</option>
								<option value="MAD" <?php if(osc_get_preference('currency', 'rupayments')=="MAD") { echo 'selected="selected"';}; ?> >MAD</option>
								<option value="MMK" <?php if(osc_get_preference('currency', 'rupayments')=="MMK") { echo 'selected="selected"';}; ?> >MMK</option>
								<option value="MOP" <?php if(osc_get_preference('currency', 'rupayments')=="MOP") { echo 'selected="selected"';}; ?> >MOP</option>
								<option value="MRO" <?php if(osc_get_preference('currency', 'rupayments')=="MRO") { echo 'selected="selected"';}; ?> >MRO</option>
								<option value="MVR" <?php if(osc_get_preference('currency', 'rupayments')=="MVR") { echo 'selected="selected"';}; ?> >MVR</option>
								<option value="MUR" <?php if(osc_get_preference('currency', 'rupayments')=="MUR") { echo 'selected="selected"';}; ?> >MUR</option>
								<option value="MYR" <?php if(osc_get_preference('currency', 'rupayments')=="MYR") { echo 'selected="selected"';}; ?> >MYR</option>
								<option value="MXN" <?php if(osc_get_preference('currency', 'rupayments')=="MXN") { echo 'selected="selected"';}; ?> >MXN</option>
								<option value="NIO" <?php if(osc_get_preference('currency', 'rupayments')=="NIO") { echo 'selected="selected"';}; ?> >NIO</option>
								<option value="NPR" <?php if(osc_get_preference('currency', 'rupayments')=="NPR") { echo 'selected="selected"';}; ?> >NPR</option>
								<option value="NZD" <?php if(osc_get_preference('currency', 'rupayments')=="NZD") { echo 'selected="selected"';}; ?> >NZD</option>
								<option value="NOK" <?php if(osc_get_preference('currency', 'rupayments')=="NOK") { echo 'selected="selected"';}; ?> >NOK</option>
								<option value="LAK" <?php if(osc_get_preference('currency', 'rupayments')=="LAK") { echo 'selected="selected"';}; ?> >LAK</option>
								<option value="LBP" <?php if(osc_get_preference('currency', 'rupayments')=="LBP") { echo 'selected="selected"';}; ?> >LBP</option>
								<option value="LKR" <?php if(osc_get_preference('currency', 'rupayments')=="LKR") { echo 'selected="selected"';}; ?> >LKR</option>
								<option value="LRD" <?php if(osc_get_preference('currency', 'rupayments')=="LRD") { echo 'selected="selected"';}; ?> >LRD</option>
								<option value="PEN" <?php if(osc_get_preference('currency', 'rupayments')=="PEN") { echo 'selected="selected"';}; ?> >PEN</option>
								<option value="PGK" <?php if(osc_get_preference('currency', 'rupayments')=="PGK") { echo 'selected="selected"';}; ?> >PGK</option>
								<option value="PHP" <?php if(osc_get_preference('currency', 'rupayments')=="PHP") { echo 'selected="selected"';}; ?> >PHP</option>
								<option value="PKR" <?php if(osc_get_preference('currency', 'rupayments')=="PKR") { echo 'selected="selected"';}; ?> >PKR</option>
								<option value="PLN" <?php if(osc_get_preference('currency', 'rupayments')=="PLN") { echo 'selected="selected"';}; ?> >PLN</option>
								<option value="QAR" <?php if(osc_get_preference('currency', 'rupayments')=="QAR") { echo 'selected="selected"';}; ?> >QAR</option>
								<option value="RON" <?php if(osc_get_preference('currency', 'rupayments')=="RON") { echo 'selected="selected"';}; ?> >RON</option>
                                <option value="RUB" <?php if(osc_get_preference('currency', 'rupayments')=="RUB") { echo 'selected="selected"';}; ?> >RUB</option>
								<option value="SAR" <?php if(osc_get_preference('currency', 'rupayments')=="SAR") { echo 'selected="selected"';}; ?> >SAR</option>
								<option value="SCR" <?php if(osc_get_preference('currency', 'rupayments')=="SCR") { echo 'selected="selected"';}; ?> >SCR</option>
								<option value="SBD" <?php if(osc_get_preference('currency', 'rupayments')=="SBD") { echo 'selected="selected"';}; ?> >SBD</option>
								<option value="SGD" <?php if(osc_get_preference('currency', 'rupayments')=="SGD") { echo 'selected="selected"';}; ?> >SGD</option>
								<option value="SEK" <?php if(osc_get_preference('currency', 'rupayments')=="SEK") { echo 'selected="selected"';}; ?> >SEK</option>	
								<option value="SGF" <?php if(osc_get_preference('currency', 'rupayments')=="SGF") { echo 'selected="selected"';}; ?> >SGF</option>
								<option value="SYP" <?php if(osc_get_preference('currency', 'rupayments')=="SYP") { echo 'selected="selected"';}; ?> >SYP</option>
								<option value="THB" <?php if(osc_get_preference('currency', 'rupayments')=="THB") { echo 'selected="selected"';}; ?> >THB</option>
								<option value="TOP" <?php if(osc_get_preference('currency', 'rupayments')=="TOP") { echo 'selected="selected"';}; ?> >TOP</option>
								<option value="TRY" <?php if(osc_get_preference('currency', 'rupayments')=="TRY") { echo 'selected="selected"';}; ?> >TRY</option>
                                <option value="TTD" <?php if(osc_get_preference('currency', 'rupayments')=="TTD") { echo 'selected="selected"';}; ?> >TTD</option>
								<option value="TWD" <?php if(osc_get_preference('currency', 'rupayments')=="TWD") { echo 'selected="selected"';}; ?> >TWD</option>
								<option value="UAH" <?php if(osc_get_preference('currency', 'rupayments')=="UAH") { echo 'selected="selected"';}; ?> >UAH</option>
								<option value="USD" <?php if(osc_get_preference('currency', 'rupayments')=="USD") { echo 'selected="selected"';}; ?> >USD</option>
								<option value="VND" <?php if(osc_get_preference('currency', 'rupayments')=="VND") { echo 'selected="selected"';}; ?> >VND</option>
								<option value="VUV" <?php if(osc_get_preference('currency', 'rupayments')=="VUV") { echo 'selected="selected"';}; ?> >VUV</option>
								<option value="WST" <?php if(osc_get_preference('currency', 'rupayments')=="WST") { echo 'selected="selected"';}; ?> >WST</option>
								<option value="XCD" <?php if(osc_get_preference('currency', 'rupayments')=="XCD") { echo 'selected="selected"';}; ?> >XCD</option>
								<option value="XOF" <?php if(osc_get_preference('currency', 'rupayments')=="XOF") { echo 'selected="selected"';}; ?> >XOF</option>
								<option value="YER" <?php if(osc_get_preference('currency', 'rupayments')=="YER") { echo 'selected="selected"';}; ?> >YER</option>
								<option value="ZAR" <?php if(osc_get_preference('currency', 'rupayments')=="ZAR") { echo 'selected="selected"';}; ?> >ZAR</option>                              
                            </select>
                        </div>
						
                    </div>             
                    <h3 class="render-title"><b><?php _e('Wallet', 'rupayments'); ?><b></h3>
                    <div class="form-row">
                        <span class="help-box">
                            <?php _e("You could specify up to 3 'packs' that users can buy, so they don't need to pay each time they publish an ad. The credit from the pack will be stored for later uses in Wallet.", 'rupayments'); ?>
						</span>
						</div>
						<div class="form-row">
						 <span class="help-box">
                            <?php _e("Specify at least one Price to add wallet in user account menu.", 'rupayments'); ?>
						</span>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php echo sprintf(__('Price of pack #%d', 'rupayments'), '1'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="pack_price_1" value="<?php echo osc_get_preference('pack_price_1', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php echo sprintf(__('Price of pack #%d', 'rupayments'), '2'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="pack_price_2" value="<?php echo osc_get_preference('pack_price_2', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php echo sprintf(__('Price of pack #%d', 'rupayments'), '3'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="pack_price_3" value="<?php echo osc_get_preference('pack_price_3', 'rupayments'); ?>" /></div>
                    </div>
                    <h3 class="render-title"><b><?php _e('Payments', 'rupayments'); ?><b></h3>
             <!-- PayPal -->
                    <h2 class="render-title separate-top"><i class="fa"></i> <?php _e('Paypal settings', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.paypal').toggle();" ><?php _e('Show options', 'rupayments'); ?></a></span>
                        <input type="checkbox" <?php echo (osc_get_preference('paypal_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="paypal_enabled" value="1" />
                        <?php _e('Paypal enable', 'rupayments'); ?></h2>
                    <div class="form-row paypal hide">
                        <div class="form-label"><?php _e('Paypal API username', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="paypal_api_username" value="<?php echo osc_get_preference('paypal_api_username', 'rupayments'); ?>" /></div>
                    </div>  
                    <div class="form-row paypal hide">
                        <div class="form-label"><?php _e('Paypal API password', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="paypal_api_password" value="<?php echo osc_get_preference('paypal_api_password', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row paypal hide">
                        <div class="form-label"><?php _e('Paypal API signature', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="paypal_api_signature" value="<?php echo osc_get_preference('paypal_api_signature', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row paypal hide">
                        <div class="form-label"><?php _e('Paypal email', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="paypal_email" value="<?php echo osc_get_preference('paypal_email', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row paypal hide">
                        <div class="form-label"><?php _e('Standard Paypal', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('paypal_standard', 'rupayments') ? 'checked="true"' : ''); ?> name="paypal_standard" value="1" />
                                    <?php _e('Use "Standard Paypal" if "Digital Goods" is not available in your country', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row paypal hide">
                        <div class="form-label"><?php _e('Paypal sandbox', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('paypal_sandbox', 'rupayments') ? 'checked="true"' : ''); ?> name="paypal_sandbox" value="1" />
                                    <?php _e('Use Paypal sandbox to test everything is right before going live', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
        
             <!-- / PayPal -->
                   
             <!-- 2checkout -->
                    <h2 class="render-title separate-top"><i class="fa"></i> <?php _e('2Checkout settings', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.2chekout').toggle();" ><?php _e('Show options', 'rupayments'); ?></a></span>
                        <input type="checkbox" <?php echo (osc_get_preference('co2_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="co2_enabled" value="1" />
                        <?php _e('2checkout enable', 'rupayments'); ?></h2>
                    <div class="form-row 2chekout hide">
                        <div class="form-label"><?php _e('2Checkout account number', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="mrhlogin" value="<?php echo osc_get_preference('mrhlogin', 'rupayments'); ?>" />
                        </div>
                    </div>
                    <div class="form-row 2chekout hide">
                        <div class="form-label"><?php _e('2Checkout secret word', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="secret_word" value="<?php echo osc_get_preference('secret_word', 'rupayments'); ?>" />
                        </div>
                    </div> 
					<div class="form-row 2chekout hide">
                        <div class="form-label"><?php _e('Language 2CO page', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <select name="language" id="language">
							    <option value="en" <?php if(osc_get_preference('language', 'rupayments')=="en") { echo 'selected="selected"';}; ?> >English</option>
							    <option value="zh" <?php if(osc_get_preference('language', 'rupayments')=="zh") { echo 'selected="selected"';}; ?> >Chinese</option>
								<option value="da" <?php if(osc_get_preference('language', 'rupayments')=="da") { echo 'selected="selected"';}; ?> >Danish</option>
								<option value="nl" <?php if(osc_get_preference('language', 'rupayments')=="nl") { echo 'selected="selected"';}; ?> >Dutch</option>
								<option value="fr" <?php if(osc_get_preference('language', 'rupayments')=="fr") { echo 'selected="selected"';}; ?> >French</option>
								<option value="gr" <?php if(osc_get_preference('language', 'rupayments')=="gr") { echo 'selected="selected"';}; ?> >German</option>
							    <option value="el" <?php if(osc_get_preference('language', 'rupayments')=="el") { echo 'selected="selected"';}; ?> >Greek</option>
								<option value="it" <?php if(osc_get_preference('language', 'rupayments')=="it") { echo 'selected="selected"';}; ?> >Italian</option>
								<option value="jp" <?php if(osc_get_preference('language', 'rupayments')=="jp") { echo 'selected="selected"';}; ?> >Japanese</option>
								<option value="no" <?php if(osc_get_preference('language', 'rupayments')=="no") { echo 'selected="selected"';}; ?> >Norwegian</option>
                                <option value="pt" <?php if(osc_get_preference('language', 'rupayments')=="pt") { echo 'selected="selected"';}; ?> >Portuguese</option>
                                <option value="sl" <?php if(osc_get_preference('language', 'rupayments')=="sl") { echo 'selected="selected"';}; ?> >Slovenian</option>  
								<option value="es_ib" <?php if(osc_get_preference('language', 'rupayments')=="es_ib") { echo 'selected="selected"';}; ?> >Spanish-European</option>
						        <option value="es_la" <?php if(osc_get_preference('language', 'rupayments')=="es_la") { echo 'selected="selected"';}; ?> >Spanish-Latin American</option>
								<option value="sv" <?php if(osc_get_preference('language', 'rupayments')=="sv") { echo 'selected="selected"';}; ?> >Swedish</option>
						   </select>
						</div>
                    </div>
                    <div class="form-row 2chekout hide">
                        <div class="form-label"><?php _e('2Checkout Sandbox', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('co2_sandbox', 'rupayments') ? 'checked="true"' : ''); ?> name="co2_sandbox" value="1" />
                                    <?php _e('Use rupayments sandbox to test everything is right before going live', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
            
             <!-- / rupayments -->

             <!-- braintree -->
                    <h2 class="render-title separate-top"><i class="fa"></i> <?php _e('Braintree settings', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.braintree').toggle();" ><?php _e('Show options', 'rupayments'); ?></a></span>
                        <input type="checkbox" <?php echo (osc_get_preference('braintree_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="braintree_enabled" value="1" />
                        <?php _e('Braintree enable', 'rupayments'); ?></h2>
                    
                    <div class="form-row braintree hide">
                        <div class="form-label"><?php _e('Braintree merchant id', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="braintree_MerchantAccountId" value="<?php echo osc_get_preference('braintree_MerchantAccountId', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row braintree hide">
                        <div class="form-label"><?php _e('Braintree public key', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="braintree_PublicKey" value="<?php echo osc_get_preference('braintree_PublicKey', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row braintree hide">
                        <div class="form-label"><?php _e('Braintree private key', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="braintree_PrivateKey" value="<?php echo osc_get_preference('braintree_PrivateKey', 'rupayments'); ?>" /></div>
                    </div> 
                    <div class="form-row braintree hide">
                        <div class="form-label"><?php _e('Enable Sandbox', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('braintree_Environment', 'rupayments') ? 'checked="true"' : ''); ?> name="braintree_Environment" value="1" />
                                    <?php _e('Enable sandbox for development testing', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
                    </div> 
                    <div class="form-row braintree hide">
                        <div class="form-label"><?php _e('Braintree merchant id for test', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="braintree_MerchantAccountId_test" value="<?php echo osc_get_preference('braintree_MerchantAccountId_test', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row braintree hide">
                        <div class="form-label"><?php _e('Braintree public key for test', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="braintree_PublicKey_test" value="<?php echo osc_get_preference('braintree_PublicKey_test', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row braintree hide">
                        <div class="form-label"><?php _e('Braintree private key for test', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="braintree_PrivateKey_test" value="<?php echo osc_get_preference('braintree_PrivateKey_test', 'rupayments'); ?>" /></div>
                    </div> 
             <!-- / braintree -->
                    
             <!-- stripe (payment_pro_...) -->
                    <h2 class="render-title separate-top"><i class="fa"></i> <?php _e('Stripe settings', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.stripe').toggle();" ><?php _e('Show options', 'rupayments'); ?></a></span>
                        <input type="checkbox" <?php echo (osc_get_preference('stripe_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="stripe_enabled" value="1" />
                        <?php _e('Stripe enable', 'rupayments'); ?></h2>
                    <div class="form-row stripe hide">
                        <div class="form-label"><?php _e('Stripe secret key', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="stripe_secret_key" value="<?php echo osc_get_preference('stripe_secret_key', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row stripe hide">
                        <div class="form-label"><?php _e('Stripe public key', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="stripe_public_key" value="<?php echo osc_get_preference('stripe_public_key', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row stripe hide"> 
                        <div class="form-label"><?php _e('Enable Sandbox', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('stripe_sandbox', 'rupayments') ? 'checked="true"' : ''); ?> name="stripe_sandbox" value="1" />
                                    <?php _e('Enable sandbox for development testing', 'payment_pro'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row stripe hide">
                        <div class="form-label"><?php _e('Stripe secret key for test', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="stripe_secret_key_test" value="<?php echo osc_get_preference('stripe_secret_key_test', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row stripe hide">
                        <div class="form-label"><?php _e('Stripe public key for test', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="stripe_public_key_test" value="<?php echo osc_get_preference('stripe_public_key_test', 'rupayments'); ?>" /></div>
                    </div>
             <!-- / stripe -->
                    
             <!-- payumoney  -->
                     <h2 class="render-title separate-top"><i class="fa"></i> <?php _e('Payumoney settings', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.payumoney').toggle();" ><?php _e('Show options', 'rupayments'); ?></a></span>
                        <input type="checkbox" <?php echo (osc_get_preference('payumoney_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="payumoney_enabled" value="1" />
                        <?php _e('Payumoney enable', 'rupayments'); ?></h2>
                     <div class="form-row payumoney hide">
                        <div class="form-label"><?php _e('PayUMoney Key', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="payumoney_Key" value="<?php echo osc_get_preference('payumoney_Key', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row payumoney hide">
                        <div class="form-label"><?php _e('PayUMoney Salt', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="payumoney_Salt" value="<?php echo osc_get_preference('payumoney_Salt', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row payumoney hide"> 
                        <div class="form-label"><?php _e('Enable Sandbox', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('payumoney_sandbox', 'rupayments') ? 'checked="true"' : ''); ?> name="payumoney_sandbox" value="1" />
                                    <?php _e('Enable sandbox for development testing', 'payment_pro'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row payumoney hide">
                        <div class="form-label"><?php _e('PayUMoney Key for test', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="payumoney_Key_test" value="<?php echo osc_get_preference('payumoney_Key_test', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row payumoney hide">
                        <div class="form-label"><?php _e('PayUMoney Salt for test', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="payumoney_Salt_test" value="<?php echo osc_get_preference('payumoney_Salt_test', 'rupayments'); ?>" /></div>
                    </div>
             <!-- / payumoney -->
                        
             <!-- skrill  -->
                     <h2 class="render-title separate-top"><i class="fa"></i> <?php _e('Skrill settings', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.skrill').toggle();" ><?php _e('Show options', 'rupayments'); ?></a></span>
                        <input type="checkbox" <?php echo (osc_get_preference('skrill_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="skrill_enabled" value="1" />
                        <?php _e('Skrill enable', 'rupayments'); ?></h2>
                     <div class="form-row skrill hide">
                        <div class="form-label"><?php _e('Skrill account e-mail', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="skrill_pay_to_email" value="<?php echo osc_get_preference('skrill_pay_to_email', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row skrill hide">
                        <div class="form-label"><?php _e('Skrill merchant id', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="skrill_merchant_id" value="<?php echo osc_get_preference('skrill_merchant_id', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row skrill hide">
                        <div class="form-label"><?php _e('Skrill secret word', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="skrill_secret_word" value="<?php echo osc_get_preference('skrill_secret_word', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row skrill hide">
                        <div class="form-label"><?php _e('Skrill recipient description (short)', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="skrill_recipient_description" value="<?php echo osc_get_preference('skrill_recipient_description', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row skrill hide"> 
                        <div class="form-label"><?php _e('Enable Sandbox', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('skrill_sandbox', 'rupayments') ? 'checked="true"' : ''); ?> name="skrill_sandbox" value="1" />
                                    <?php _e('Enable sandbox for development testing', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
                    </div> <!--
                    <div class="form-row skrill hide">
                        <div class="form-label"><?php _e('Skrill test account e-mail', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="skrill_test_merchant_email" value="<?php echo osc_get_preference('skrill_test_merchant_email', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row skrill hide">
                        <div class="form-label"><?php _e('Skrill test merchant id', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="skrill_test_merchant_id" value="<?php echo osc_get_preference('skrill_test_merchant_id', 'rupayments'); ?>" /></div>
                    </div>
                    <div class="form-row skrill hide">
                        <div class="form-label"><?php _e('Skrill test secret word', 'rupayments'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="skrill_test_secret_word" value="<?php echo osc_get_preference('skrill_test_secret_word', 'rupayments'); ?>" /></div>
                    </div> -->
             <!-- / skrill -->
                        
             <!-- payulatam -->
                    <h2 class="render-title separate-top"><i class="fa"></i> <?php _e('Payulatam settings', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.payulatam').toggle();" ><?php _e('Show options', 'rupayments'); ?></a></span>
                        <input type="checkbox" <?php echo (osc_get_preference('payulatam_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="payulatam_enabled" value="1" />
                        <?php _e('Payulatam enable', 'rupayments'); ?></h2>
						<div class="form-row payulatam hide">
						<?php _e('Remember! Payulatam required Tax and taxReturnBase.', 'rupayments'); ?>
					   </div>
					   	<div class="form-row payulatam hide">
						<?php _e('tax! This is the transaction VAT. If VAT zero is sent the system, 19% will be applied automatically. It can contain two decimals. Eg 19000.00. In the where you do not charge VAT, it should should be set as 0.', 'rupayments'); ?>
					   </div>
					   	<div class="form-row payulatam hide">
                        <?php _e('taxReturnBase! This is the base value upon which VAT is calculated. If you do not charge VAT, it should be sent as 0.', 'rupayments'); ?>
					   </div>
					 <div class="form-row payulatam hide">
                        <div class="form-label"><?php _e('tax:', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="payulatam_tax" value="<?php echo osc_get_preference('payulatam_tax', 'rupayments'); ?>" />
                        </div>
                    </div>
					<div class="form-row payulatam hide">
                        <div class="form-label"><?php _e('taxReturnBase:', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="payulatam_taxReturnBase" value="<?php echo osc_get_preference('payulatam_taxReturnBase', 'rupayments'); ?>" />
                        </div>
                    </div>
					<div class="form-row payulatam hide">
                        <div class="form-label"><?php _e('merchantId:', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="payulatam_merchantId" value="<?php echo osc_get_preference('payulatam_merchantId', 'rupayments'); ?>" />
                        </div>
                    </div>
                    <div class="form-row payulatam hide">
                        <div class="form-label"><?php _e('accountId:', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="payulatam_accountId" value="<?php echo osc_get_preference('payulatam_accountId', 'rupayments'); ?>" />
                        </div>
                    </div> 
					  <div class="form-row payulatam hide">
                        <div class="form-label"><?php _e('apikey:', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="payulatam_apikey" value="<?php echo osc_get_preference('payulatam_apikey', 'rupayments'); ?>" />
                        </div>
                    </div> 
				<div class="form-row payulatam hide">
                        <div class="form-label"><?php _e('Language Payulatam', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <select name="payulatam_language" id="language">
							    <option value="en" <?php if(osc_get_preference('payulatam_language', 'rupayments')=="en") { echo 'selected="selected"';}; ?> >English</option>
							    <option value="es" <?php if(osc_get_preference('payulatam_language', 'rupayments')=="es") { echo 'selected="selected"';}; ?> >Spanish</option>
								<option value="pt" <?php if(osc_get_preference('payulatam_language', 'rupayments')=="pt") { echo 'selected="selected"';}; ?> >Portuguese</option>
						   </select>
						</div>
                    </div>
                    <div class="form-row payulatam hide">
                        <div class="form-label"><?php _e('Enable Sandbox', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('payulatam_sandbox', 'rupayments') ? 'checked="true"' : ''); ?> name="payulatam_sandbox" value="1" />
                                </label>
                            </div>
                        </div>
						                                    <?php _e('For testing Apikey, accountid ,merchantId you can get here:', 'rupayments'); ?><a target="_blank" href="http://developers.payulatam.com/en/web_checkout/sandbox.html">http://developers.payulatam.com/en/web_checkout/sandbox.html</a>
                    </div>
            
             <!-- / payulatam -->    
             <!-- fortumo -->
                    <h2 class="render-title separate-top"><i class="fa"></i> <?php _e('Fortumo settings', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.fortumo').toggle();" ><?php _e('Show options', 'rupayments'); ?></a></span>
                        <input type="checkbox" <?php echo (osc_get_preference('fortumo_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="fortumo_enabled" value="1" />
                        <?php _e('fortumo enable', 'rupayments'); ?></h2>
						<div class="form-row fortumo hide">
						<?php _e('Remember! Fortumo work only in Wallet. Specify at least one Price of pack before use, to enable Wallet in user menu.', 'rupayments'); ?>
                       </div>
					   <div class="form-row fortumo hide">
						<?php _e('Price(or prices) for SMS you specify in your Fortumo merchant account.', 'rupayments'); ?>
                       </div>
					<div class="form-row fortumo hide">
                        <div class="form-label"><?php _e('Service ID', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="fortumo_mrhlogin" value="<?php echo osc_get_preference('fortumo_mrhlogin', 'rupayments'); ?>" />
                        </div>
                    </div>
                    <div class="form-row fortumo hide">
                        <div class="form-label"><?php _e('Secret:', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="fortumo_secret_word" value="<?php echo osc_get_preference('fortumo_secret_word', 'rupayments'); ?>" />
                        </div>
                    </div> 
				<!--	<div class="form-row fortumo hide">
                        <div class="form-label"><?php _e('Language Fortumo', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <select name="fortumo_language" id="language">
							    <option value="en" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="en") { echo 'selected="selected"';}; ?> >English</option>
							    <option value="zh" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="zh") { echo 'selected="selected"';}; ?> >Chinese</option>
								<option value="da" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="da") { echo 'selected="selected"';}; ?> >Danish</option>
								<option value="nl" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="nl") { echo 'selected="selected"';}; ?> >Dutch</option>
								<option value="fr" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="fr") { echo 'selected="selected"';}; ?> >French</option>
								<option value="gr" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="gr") { echo 'selected="selected"';}; ?> >German</option>
							    <option value="el" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="el") { echo 'selected="selected"';}; ?> >Greek</option>
								<option value="it" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="it") { echo 'selected="selected"';}; ?> >Italian</option>
								<option value="jp" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="jp") { echo 'selected="selected"';}; ?> >Japanese</option>
								<option value="no" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="no") { echo 'selected="selected"';}; ?> >Norwegian</option>
                                <option value="pt" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="pt") { echo 'selected="selected"';}; ?> >Portuguese</option>
                                <option value="sl" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="sl") { echo 'selected="selected"';}; ?> >Slovenian</option>  
								<option value="es_ib" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="es_ib") { echo 'selected="selected"';}; ?> >Spanish-European</option>
						        <option value="es_la" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="es_la") { echo 'selected="selected"';}; ?> >Spanish-Latin American</option>
								<option value="sv" <?php if(osc_get_preference('fortumo_language', 'rupayments')=="sv") { echo 'selected="selected"';}; ?> >Swedish</option>
						   </select>
						</div>
                    </div> -->
                    <div class="form-row fortumo hide">
                        <div class="form-label"><?php _e('Enable Sandbox', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('fortumo_sandbox', 'rupayments') ? 'checked="true"' : ''); ?> name="fortumo_sandbox" value="1" />
                                    <?php _e('Enable sandbox for development testing', 'rupayments'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
            
             <!-- / fortumo -->    
			 
			 
			 
			 
			 
			 
             <!-- blockchain -->
                    <h2 class="render-title separate-top"><i class="fa"></i> <?php _e('Blockchain (bitcoin) settings', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.blockchain').toggle();" ><?php _e('Show options', 'rupayments'); ?></a></span>
                        <input type="checkbox" <?php echo (osc_get_preference('blockchain_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="blockchain_enabled" value="1" />
                        <?php _e('blockchain enable', 'rupayments'); ?></h2>
						<div class="form-row blockchain hide">
						
                       </div>
					   <div class="form-row blockchain hide">
						
                       </div>
					<div class="form-row blockchain hide">
                        <div class="form-label"><?php _e('xpub:', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="blockchain_mrhlogin" value="<?php echo osc_get_preference('blockchain_mrhlogin', 'rupayments'); ?>" />
                        </div>
                    </div>
                    <div class="form-row blockchain hide">
                        <div class="form-label"><?php _e('api_key:', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="blockchain_api_key_word" value="<?php echo osc_get_preference('blockchain_api_key_word', 'rupayments'); ?>" />
                        </div>
                    </div> 
                      <div class="form-row blockchain hide">
                        <div class="form-label"><?php _e('secret:', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="blockchain_secret_word" value="<?php echo osc_get_preference('blockchain_secret_word', 'rupayments'); ?>" /> 
                        </div>
                    </div> 
					                      <div class="form-row blockchain hide">
                        <div class="form-label"><?php _e('Count blocks:', 'rupayments'); ?></div>
                        <div class="form-controls">
                            <input type="text" class="xlarge" name="blockchain_blocks" value="<?php echo osc_get_preference('blockchain_blocks', 'rupayments'); ?>" /> 
                        </div>
                    </div> 
            
             <!-- / blockchain -->    
			 
			 
			 
                    <div class="clear"></div>
                    <div class="form-actions">
                        <input type="submit" id="save_changes" value="<?php echo osc_esc_html( __('Save changes', 'rupayments') ); ?>" class="btn btn-submit" />
                    </div>
                </div>
            </fieldset>
        </form>
			<script type="text/javascript">
            $(function() {
                $('#tabsWithStyle').tabs();
            });
        </script>
			<address class="osclasspro_address">
	<span>&copy; <?php echo date('Y') ?> <a target="_blank" title="osclass-pro.com" href="https://osclass-pro.com/">osclass-pro.com</a>. All rights reserved.</span>
  </address>
    <?php echo '<script src="' . osc_base_url() . 'oc-content/plugins/rupayments/admin/js/jquery.admin.js"></script>'; ?>
 </div>
  <div id="category">
    <?php include 'conf_prices.php'; ?>
  </div>
  <div id="policy">
    <?php include 'conf_policy.php'; ?>
  </div>
  <div id="log">
    <?php include 'log.php'; ?>
 </div>
 <div id="bonus">
   <?php include 'bonus.php'; ?> 
 </div> 
 <div id="help">
   <?php include 'help.php'; ?>
 </div>
<!--  -->
<?php // print_r(error_get_last()); ?>