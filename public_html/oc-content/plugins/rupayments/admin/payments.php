<?php defined('ABS_PATH') or die('Access denied'); 
    if(Params::getParam('plugin_action')=='done') {
        /* Параметры подключения к РР */
        osc_set_preference('paypal_api_username', Params::getParam("paypal_api_username"), 'rupayments', 'STRING');
        osc_set_preference('paypal_api_password', Params::getParam("paypal_api_password"), 'rupayments', 'STRING');
        osc_set_preference('paypal_api_signature', Params::getParam("paypal_api_signature"), 'rupayments', 'STRING');
        osc_set_preference('paypal_email', Params::getParam("paypal_email"), 'rupayments', 'STRING');
        osc_set_preference('paypal_standard', Params::getParam("paypal_standard") ? Params::getParam("paypal_standard") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('paypal_sandbox', Params::getParam("paypal_sandbox") ? Params::getParam("paypal_sandbox") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('paypal_enabled', Params::getParam("paypal_enabled") ? Params::getParam("paypal_enabled") : '0', 'rupayments', 'BOOLEAN');
                 
        /* Параметры подключения к 2Chekout */
        osc_set_preference('language', Params::getParam("language") ? Params::getParam("language") : 'en', 'rupayments', 'STRING');
        osc_set_preference('co2_sandbox', Params::getParam("co2_sandbox") ? Params::getParam("co2_sandbox") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('mrhlogin', Params::getParam("mrhlogin") ? Params::getParam("mrhlogin") : '', 'rupayments','STRING');
        osc_set_preference('secret_word', Params::getParam("secret_word") ? Params::getParam("secret_word") : '', 'rupayments','STRING');
        osc_set_preference('co2_enabled', Params::getParam("co2_enabled") ? Params::getParam("co2_enabled") : '0', 'rupayments', 'BOOLEAN');

        /* Параметры подключения к fortumo */
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
		
		/* Параметры подключения к Yandex */
        osc_set_preference('yandex_receiver', Params::getParam("yandex_receiver") ? Params::getParam("yandex_receiver") : '', 'rupayments', 'STRING');
        osc_set_preference('yandex_currency', Params::getParam("yandex_currency") ? Params::getParam("yandex_currency") : '', 'rupayments', 'STRING');
        osc_set_preference('yandex_secret_word', Params::getParam("yandex_secret_word") ? Params::getParam("yandex_secret_word") : '', 'rupayments', 'STRING');
        osc_set_preference('yandex_enabled', Params::getParam("yandex_enabled") ? Params::getParam("yandex_enabled") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('yandex_by_carta', Params::getParam("yandex_by_carta") ? Params::getParam("yandex_by_carta") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('yandex_by_wallet', Params::getParam("yandex_by_wallet") ? Params::getParam("yandex_by_wallet") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('yandex_by_mobile_phone', Params::getParam("yandex_by_mobile_phone") ? Params::getParam("yandex_by_mobile_phone") : '0', 'rupayments', 'BOOLEAN');
        
		/* Параметры подключения к Interkassa */
        osc_set_preference('ik_co_id', Params::getParam("ik_co_id") ? Params::getParam("ik_co_id") : '', 'rupayments', 'STRING');
        osc_set_preference('interkassa_secret', Params::getParam("interkassa_secret") ? Params::getParam("interkassa_secret") : '', 'rupayments', 'STRING');
		osc_set_preference('interkassa_enabled', Params::getParam("interkassa_enabled") ? Params::getParam("interkassa_enabled") : '0', 'rupayments', 'BOOLEAN');
		
		 /* Параметры подключения к Robo */
		osc_set_preference('mrhlogin', Params::getParam("mrhlogin") ? Params::getParam("mrhlogin") : '', 'rupayments', 'STRING');
        osc_set_preference('mrhpass1', Params::getParam("mrhpass1") ? Params::getParam("mrhpass1") : '', 'rupayments', 'STRING');
        osc_set_preference('mrhpass2', Params::getParam("mrhpass2") ? Params::getParam("mrhpass2") : '', 'rupayments', 'STRING');
		osc_set_preference('robokassa_enabled', Params::getParam("robokassa_enabled") ? Params::getParam("robokassa_enabled") : '0', 'rupayments', 'BOOLEAN');
		osc_set_preference('robo_sandbox', Params::getParam("robo_sandbox") ? Params::getParam("robo_sandbox") : '0', 'rupayments', 'BOOLEAN');
		
		/* Параметры подключения к Walletone */
		osc_set_preference('wologin', Params::getParam("wologin") ? Params::getParam("wologin") : '', 'rupayments', 'STRING');
        osc_set_preference('wopass1', Params::getParam("wopass1") ? Params::getParam("wopass1") : '', 'rupayments', 'STRING');
        osc_set_preference('wopass2', Params::getParam("wopass2") ? Params::getParam("wopass2") : '', 'rupayments', 'STRING');
		osc_set_preference('wo_enabled', Params::getParam("wo_enabled") ? Params::getParam("wo_enabled") : '0', 'rupayments', 'BOOLEAN');
		
		/* Параметры подключения к Payeer */
        osc_set_preference('payeer_merchant_id', Params::getParam("payeer_merchant_id") ? Params::getParam("payeer_merchant_id") : '', 'rupayments', 'STRING');
		osc_set_preference('payeer_secret_key', Params::getParam("payeer_secret_key") ? Params::getParam("payeer_secret_key") : '', 'rupayments', 'STRING');
		osc_set_preference('payeer_ip_filter', Params::getParam("payeer_ip_filter") ? Params::getParam("payeer_ip_filter") : '', 'rupayments', 'STRING');
		osc_set_preference('payeer_enabled', Params::getParam("payeer_enabled") ? Params::getParam("payeer_enabled") : '0', 'rupayments', 'BOOLEAN');
       
	   /* Параметры подключения к Freekassa */
        osc_set_preference('ik_co_id_free', Params::getParam("ik_co_id_free") ? Params::getParam("ik_co_id_free") : '', 'rupayments', 'STRING');
        osc_set_preference('freekassa_secret', Params::getParam("freekassa_secret") ? Params::getParam("freekassa_secret") : '', 'rupayments', 'STRING');
		osc_set_preference('freekassa_secret2', Params::getParam("freekassa_secret2") ? Params::getParam("freekassa_secret2") : '', 'rupayments', 'STRING');
		osc_set_preference('freekassa_enabled', Params::getParam("freekassa_enabled") ? Params::getParam("freekassa_enabled") : '0', 'rupayments', 'BOOLEAN');
		
		/* Параметры подключения к Webmoney */
        osc_set_preference('webmoney_id', Params::getParam("webmoney_id") ? Params::getParam("webmoney_id") : '', 'rupayments', 'STRING');
        osc_set_preference('webmoney_secret', Params::getParam("webmoney_secret") ? Params::getParam("webmoney_secret") : '', 'rupayments', 'STRING');
		osc_set_preference('webmoney_enabled', Params::getParam("webmoney_enabled") ? Params::getParam("webmoney_enabled") : '0', 'rupayments', 'BOOLEAN');
		
		         /* Параметры подключения к Liqpay */
		osc_set_preference('lp_public_key', Params::getParam("lp_public_key") ? Params::getParam("lp_public_key") : '', 'rupayments', 'STRING');
        osc_set_preference('lp_private_key', Params::getParam("lp_private_key") ? Params::getParam("lp_private_key") : '', 'rupayments', 'STRING');
        osc_set_preference('lp_test_public_key', Params::getParam("lp_test_public_key") ? Params::getParam("lp_test_public_key") : '', 'rupayments', 'STRING');
        osc_set_preference('lp_test_private_key', Params::getParam("lp_test_private_key") ? Params::getParam("lp_test_private_key") : '', 'rupayments', 'STRING');
		osc_set_preference('lp_enabled', Params::getParam("lp_enabled") ? Params::getParam("lp_enabled") : '0', 'rupayments', 'BOOLEAN');
		osc_set_preference('lp_sandbox', Params::getParam("lp_sandbox") ? Params::getParam("lp_sandbox") : '0', 'rupayments', 'BOOLEAN');
		
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
        osc_redirect_to(osc_route_admin_url('rupayments-payments'));
    }
?>

<?php require_once 'top_menu.php'; ?>
<div class="rupayments-manage-wrapper">
    <form action="<?php echo osc_admin_base_url(true); ?>" method="post">
        <input type="hidden" name="page" value="plugins" />
        <input type="hidden" name="action" value="renderplugin" />
        <input type="hidden" name="route" value="rupayments-payments" />
        <input type="hidden" name="plugin_action" value="done" />
            
        <div class="cd-tabs">
            <nav>
                <ul class="cd-tabs-navigation">
                    <li>
                        <a data-content="yandex" href="javascript:void(0);">
                            <?php if(osc_get_preference('yandex_enabled', 'rupayments')): ?>
                                <i class="fa fa-check-square" style="color: #25cc25;"></i>
                            <?php else: ?>
                                <i class="fa fa-window-close" style="color: red;"></i>
                            <?php endif; ?> 
                            <?php _e('ЮMoney', 'rupayments'); ?>
                        </a>
                    </li>
                    <li>
                        <a data-content="robokassa" href="javascript:void(0);">
                            <?php if(osc_get_preference('robokassa_enabled', 'rupayments')): ?>
                                <i class="fa fa-check-square" style="color: #25cc25;"></i>
                            <?php else: ?>
                                <i class="fa fa-window-close" style="color: red;"></i>
                            <?php endif; ?> 
                            <?php _e('Robokassa', 'rupayments'); ?>
                        </a>
                    </li>
					<li>
                        <a data-content="freekassa" href="javascript:void(0);">
                            <?php if(osc_get_preference('freekassa_enabled', 'rupayments')): ?>
                                <i class="fa fa-check-square" style="color: #25cc25;"></i>
                            <?php else: ?>
                                <i class="fa fa-window-close" style="color: red;"></i>
                            <?php endif; ?> 
                            <?php _e('Free-kassa', 'rupayments'); ?>
                        </a>
                    </li>
                    <li>
                        <a data-content="interkassa" href="javascript:void(0);">
                            <?php if(osc_get_preference('interkassa_enabled', 'rupayments')): ?>
                                <i class="fa fa-check-square" style="color: #25cc25;"></i>
                            <?php else: ?>
                                <i class="fa fa-window-close" style="color: red;"></i>
                            <?php endif; ?> 
                            <?php _e('Interkassa', 'rupayments'); ?>
                        </a>
                    </li>
					<li>
                        <a data-content="liqpay" href="javascript:void(0);">
                            <?php if(osc_get_preference('lp_enabled', 'rupayments')): ?>
                                <i class="fa fa-check-square" style="color: #25cc25;"></i>
                            <?php else: ?>
                                <i class="fa fa-window-close" style="color: red;"></i>
                            <?php endif; ?> 
                            <?php _e('Liqpay', 'rupayments'); ?>
                        </a>
                    </li>
														                    <li>
                        <a data-content="paypal" class="selected" href="javascript:void(0);">
                            <?php if(osc_get_preference('paypal_enabled', 'rupayments')): ?>
                                <i class="fa fa-check-square" style="color: #25cc25;"></i>
                            <?php else: ?>
                                <i class="fa fa-window-close" style="color: red;"></i>
                            <?php endif; ?> 
                            <?php _e('Paypal', 'rupayments'); ?>
                        </a>
                    </li>
					<li>
                        <a data-content="walletone" href="javascript:void(0);">
                            <?php if(osc_get_preference('wo_enabled', 'rupayments')): ?>
                                <i class="fa fa-check-square" style="color: #25cc25;"></i>
                            <?php else: ?>
                                <i class="fa fa-window-close" style="color: red;"></i>
                            <?php endif; ?> 
                            <?php _e('Walletone', 'rupayments'); ?>
                        </a>
                    </li>
										<li>
                        <a data-content="payeer" href="javascript:void(0);">
                            <?php if(osc_get_preference('payeer_enabled', 'rupayments')): ?>
                                <i class="fa fa-check-square" style="color: #25cc25;"></i>
                            <?php else: ?>
                                <i class="fa fa-window-close" style="color: red;"></i>
                            <?php endif; ?> 
                            <?php _e('Payeer', 'rupayments'); ?>
                        </a>
                    </li>
					<li>
                        <a data-content="webmoney" href="javascript:void(0);">
                            <?php if(osc_get_preference('webmoney_enabled', 'rupayments')): ?>
                                <i class="fa fa-check-square" style="color: #25cc25;"></i>
                            <?php else: ?>
                                <i class="fa fa-window-close" style="color: red;"></i>
                            <?php endif; ?> 
                            <?php _e('Webmoney', 'rupayments'); ?>
                        </a>
                    </li>
					  <li>
                        <a data-content="2checkout" href="javascript:void(0);">
                            <?php if(osc_get_preference('co2_enabled', 'rupayments')): ?>
                                <i class="fa fa-check-square" style="color: #25cc25;"></i>
                            <?php else: ?>
                                <i class="fa fa-window-close" style="color: red;"></i>
                            <?php endif; ?> 
                            <?php _e('2Checkout', 'rupayments'); ?>
                        </a>
                    </li>
                    <li>
                        <a data-content="fortumo" href="javascript:void(0);">
                            <?php if(osc_get_preference('fortumo_enabled', 'rupayments')): ?>
                                <i class="fa fa-check-square" style="color: #25cc25;"></i>
                            <?php else: ?>
                                <i class="fa fa-window-close" style="color: red;"></i>
                            <?php endif; ?> 
                            <?php _e('Fortumo', 'rupayments'); ?>
                        </a>
                    </li>
                    <li>
                        <a data-content="blockchain" href="javascript:void(0);">
                            <?php if(osc_get_preference('blockchain_enabled', 'rupayments')): ?>
                                <i class="fa fa-check-square" style="color: #25cc25;"></i>
                            <?php else: ?>
                                <i class="fa fa-window-close" style="color: red;"></i>
                            <?php endif; ?> 
                            <?php _e('Blockchain (bitcoin)', 'rupayments'); ?>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <ul class="cd-tabs-content">
                <li data-content="paypal" class="selected">
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 200px;">
                                <?php _e('Paypal enable', 'rupayments'); ?>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('paypal_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="paypal_enabled" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Paypal API username', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="paypal_api_username" value="<?php echo osc_get_preference('paypal_api_username', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Paypal API password', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="paypal_api_password" value="<?php echo osc_get_preference('paypal_api_password', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Paypal API signature', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="paypal_api_signature" value="<?php echo osc_get_preference('paypal_api_signature', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Paypal email', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="paypal_email" value="<?php echo osc_get_preference('paypal_email', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Standard Paypal', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Use "Standard Paypal" if "Digital Goods" is not available in your country', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('paypal_standard', 'rupayments') ? 'checked="true"' : ''); ?> name="paypal_standard" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Paypal sandbox', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Use Paypal sandbox to test everything is right before going live', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('paypal_sandbox', 'rupayments') ? 'checked="true"' : ''); ?> name="paypal_sandbox" value="1" />
                                </div>
                            </td>
                        </tr>
                    </table>
                </li>
                
                <li data-content="2checkout">
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 200px;">
                                <?php _e('2checkout enable', 'rupayments'); ?>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('co2_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="co2_enabled" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('2Checkout account number', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="mrhlogin" value="<?php echo osc_get_preference('mrhlogin', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('2Checkout secret word', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="secret_word" value="<?php echo osc_get_preference('secret_word', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Language 2CO page', 'rupayments'); ?>
                            </td>
                            <td>
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
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('2Checkout Sandbox', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Use rupayments sandbox to test everything is right before going live', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('co2_sandbox', 'rupayments') ? 'checked="true"' : ''); ?> name="co2_sandbox" value="1" />
                                </div>
                            </td>
                        </tr>
                    </table>
                </li>
                
                
                <li data-content="yandex">
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 200px;">
                                <?php _e('Yandex enable', 'rupayments'); ?>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('yandex_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="yandex_enabled" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Yandex merchant/account id', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="yandex_receiver" value="<?php echo osc_get_preference('yandex_receiver', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Yandex secret word', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="yandex_secret_word" value="<?php echo osc_get_preference('yandex_secret_word', 'rupayments'); ?>" />
                            </td>
                        </tr>
   
                        <tr>
                            <td>
                                <?php _e('Choose Payment method: Accept card', 'rupayments'); ?>
                            </td>
                            <td>
                                <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('yandex_by_carta', 'rupayments') ? 'checked="true"' : ''); ?> name="yandex_by_carta" value="1" />
                                    <?php _e('Bank card', 'rupayments'); ?>
                                </label>
                            </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Choose Payment method: Yandex.Money Wallet', 'rupayments'); ?>
                            </td>
                            <td>
							<div class="form-label-checkbox">
                                 <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('yandex_by_wallet', 'rupayments') ? 'checked="true"' : ''); ?> name="yandex_by_wallet" value="1" />
                                    <?php _e('ЮMoney', 'rupayments'); ?>
                                </label>
								</div>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <?php _e('Choose Payment method: Mobile phone', 'rupayments'); ?>
                            </td>
                            <td>
							<div class="form-label-checkbox">
                             <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('yandex_by_mobile_phone', 'rupayments') ? 'checked="true"' : ''); ?> name="yandex_by_mobile_phone" value="1" />
                                    <?php _e('Mobile phone', 'rupayments'); ?>
                                </label>
								</div>
                            </td>
                        </tr>
                    </table>
                </li>
                
                <li data-content="interkassa">
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 200px;">
                                <?php _e('Interkassa enable', 'rupayments'); ?>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('interkassa_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="interkassa_enabled" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Interkassa kassa id', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="ik_co_id" value="<?php echo osc_get_preference('ik_co_id', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Interkassa secret key', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="interkassa_secret" value="<?php echo osc_get_preference('interkassa_secret', 'rupayments'); ?>" />
                            </td>
                        </tr>
                    </table>
                </li>
                
                <li data-content="robokassa">
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 200px;">
                                <?php _e('Robokassa enable', 'rupayments'); ?>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('robokassa_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="robokassa_enabled" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('ID shop', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="mrhlogin" value="<?php echo osc_get_preference('mrhlogin', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Password1', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="mrhpass1" value="<?php echo osc_get_preference('mrhpass1', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Password2', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="mrhpass2" value="<?php echo osc_get_preference('mrhpass2', 'rupayments'); ?>" />
                            </td>
                        </tr>
						<tr>
                            <td>
                                <?php _e('Enable Sandbox', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Enable sandbox for development testing', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('robo_sandbox', 'rupayments') ? 'checked="true"' : ''); ?> name="robo_sandbox" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                </li>
                                <li data-content="liqpay">
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 200px;">
                                <?php _e('Liqpay enable', 'rupayments'); ?>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('lp_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="lp_enabled" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Public Key', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="lp_public_key" value="<?php echo osc_get_preference('lp_public_key', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Private Key', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="lp_private_key" value="<?php echo osc_get_preference('lp_private_key', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Test Public Key', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="lp_test_public_key" value="<?php echo osc_get_preference('lp_test_public_key', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Test Private Key', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="lp_test_private_key" value="<?php echo osc_get_preference('lp_test_private_key', 'rupayments'); ?>" />
                            </td>
                        </tr>
						<tr>
                            <td>
                                <?php _e('Enable Sandbox', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Enable sandbox for development testing', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('lp_sandbox', 'rupayments') ? 'checked="true"' : ''); ?> name="lp_sandbox" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                </li>
                
                <li data-content="walletone">
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 200px;">
                                <?php _e('Walletone enable', 'rupayments'); ?>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('wo_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="wo_enabled" value="1" />
                                </div>
                            </td>
                        </tr>       
                        <tr>
                            <td>
                                <?php _e('Kassa ID:', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="wologin" value="<?php echo osc_get_preference('wologin', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Key:', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="wopass1" value="<?php echo osc_get_preference('wopass1', 'rupayments'); ?>" />
                            </td>
                        </tr>
                    </table>
                </li>
                
                <li data-content="fortumo">
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 200px;">
                                <?php _e('Fortumo enable', 'rupayments'); ?> <i id="info" data-tipso="<?php _e('Remember! Fortumo work only in Wallet. Specify at least one Price of pack before use, to enable Wallet in user menu. <br /> Price(or prices) for SMS you specify in your Fortumo merchant account.', 'rupayments'); ?>" class="fa fa-exclamation-circle fa-alert"></i>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('fortumo_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="fortumo_enabled" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Service ID', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="fortumo_mrhlogin" value="<?php echo osc_get_preference('fortumo_mrhlogin', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Secret:', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="fortumo_secret_word" value="<?php echo osc_get_preference('fortumo_secret_word', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Enable Sandbox', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Enable sandbox for development testing', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('fortumo_sandbox', 'rupayments') ? 'checked="true"' : ''); ?> name="fortumo_sandbox" value="1" />
                                </div>
                            </td>
                        </tr>
                    </table>
                </li>
                
                <li data-content="blockchain">
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 200px;">
                                <?php _e('Blockchain enable', 'rupayments'); ?>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('blockchain_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="blockchain_enabled" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('xpub:', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="blockchain_mrhlogin" value="<?php echo osc_get_preference('blockchain_mrhlogin', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('api_key:', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="blockchain_api_key_word" value="<?php echo osc_get_preference('blockchain_api_key_word', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('secret:', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="blockchain_secret_word" value="<?php echo osc_get_preference('blockchain_secret_word', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Count blocks:', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="blockchain_blocks" value="<?php echo osc_get_preference('blockchain_blocks', 'rupayments'); ?>" />
                            </td>
                        </tr>
                    </table>
                </li>
				<li data-content="payeer">
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 200px;">
                                <?php _e('Payeer enable', 'rupayments'); ?>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('payeer_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="payeer_enabled" value="1" />
                                </div>
                            </td>
                        </tr>
						
                        
                        <tr>
                            <td>
                                <?php _e('ID', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="payeer_merchant_id" value="<?php echo osc_get_preference('payeer_merchant_id', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Secret key', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="payeer_secret_key" value="<?php echo osc_get_preference('payeer_secret_key', 'rupayments'); ?>" />
                            </td>
                        </tr>
						<tr>
                            <td>
                                <?php _e('IP - filter', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="payeer_ip_filter" value="<?php echo osc_get_preference('payeer_ip_filter', 'rupayments'); ?>" />
                            </td>
                        </tr>
 
                    </table>
                </li>
				<li data-content="freekassa">
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 200px;">
                                <?php _e('Free-kassa enable', 'rupayments'); ?>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('freekassa_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="freekassa_enabled" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Free-kassa shop id', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="ik_co_id_free" value="<?php echo osc_get_preference('ik_co_id_free', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Free-kassa secret key', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="freekassa_secret" value="<?php echo osc_get_preference('freekassa_secret', 'rupayments'); ?>" />
                            </td>
                        </tr>
						<tr>
                            <td>
                                <?php _e('Free-kassa secret key 2', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="freekassa_secret2" value="<?php echo osc_get_preference('freekassa_secret2', 'rupayments'); ?>" />
                            </td>
                        </tr>
                    </table>
                </li>
				<li data-content="webmoney">
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 200px;">
                                <?php _e('Webmoney enable', 'rupayments'); ?>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('webmoney_enabled', 'rupayments') ? 'checked="true"' : ''); ?> name="webmoney_enabled" value="1" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Wallet №', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="webmoney_id" value="<?php echo osc_get_preference('webmoney_id', 'rupayments'); ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php _e('Webmoney secret', 'rupayments'); ?>
                            </td>
                            <td>
                                <input type="text" class="xlarge" name="webmoney_secret" value="<?php echo osc_get_preference('webmoney_secret_secret', 'rupayments'); ?>" />
                            </td>
                        </tr>

                    </table>
                </li>
            </ul>
        </div>
        
        <div class="form-actions">
            <input type="submit" id="save_changes" value="<?php echo osc_esc_html(__("Save changes", 'rupayments')); ?>" class="btn btn-submit">
        </div>
    </form>
</div>