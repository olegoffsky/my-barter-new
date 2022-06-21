<?php defined('ABS_PATH') or die('Access denied');
    if(Params::getParam('plugin_action') == 'done') {
        osc_set_preference('default_premium_cost', Params::getParam("default_premium_cost") ? Params::getParam("default_premium_cost") : '1.0', 'rupayments', 'STRING');
	    osc_set_preference('default_top_cost', Params::getParam("default_top_cost") ? Params::getParam("default_top_cost") : '1.0', 'rupayments', 'STRING');
        osc_set_preference('default_color_cost', Params::getParam("default_color_cost") ? Params::getParam("default_color_cost") : '1.0', 'rupayments', 'STRING');
        osc_set_preference('default_3_in_1_pack_cost', Params::getParam("default_3_in_1_pack_cost") ? Params::getParam("default_3_in_1_pack_cost") : '1.0', 'rupayments', 'STRING');
        osc_set_preference('default_pay_per_show_image_cost', Params::getParam("default_pay_per_show_image_cost") ? Params::getParam("default_pay_per_show_image_cost") : '1.0', 'rupayments', 'STRING');
		osc_set_preference('default_renew_cost', Params::getParam("default_renew_cost") ? Params::getParam("default_renew_cost") : '1.0', 'rupayments', 'STRING');
		osc_set_preference('default_publish_cost', Params::getParam("default_publish_cost") ? Params::getParam("default_publish_cost") : '1.0', 'rupayments', 'STRING');
        osc_set_preference('allow_premium', Params::getParam("allow_premium") ? Params::getParam("allow_premium") : '0', 'rupayments', 'BOOLEAN');
		osc_set_preference('allow_renew', Params::getParam("allow_renew") ? Params::getParam("allow_renew") : '0', 'rupayments', 'BOOLEAN');
	    osc_set_preference('allow_move', Params::getParam("allow_move") ? Params::getParam("allow_move") : '0', 'rupayments', 'BOOLEAN');
	    osc_set_preference('allow_high', Params::getParam("allow_high") ? Params::getParam("allow_high") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('3_in_1_pack_status', Params::getParam("3_in_1_pack_status") ? Params::getParam("3_in_1_pack_status") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('pay_per_show_image_status', Params::getParam("pay_per_show_image_status") ? Params::getParam("pay_per_show_image_status") : '0', 'rupayments', 'BOOLEAN');
	    osc_set_preference('allow_after', Params::getParam("allow_after") ? Params::getParam("allow_after") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('pay_per_post', Params::getParam("pay_per_post") ? Params::getParam("pay_per_post") : '0', 'rupayments', 'BOOLEAN');
        osc_set_preference('color_days', Params::getParam("color_days") ? Params::getParam("color_days") : '7', 'rupayments', 'INTEGER');
        osc_set_preference('premium_days', Params::getParam("premium_days") ? Params::getParam("premium_days") : '7', 'rupayments', 'INTEGER');
        osc_set_preference('3_in_1_pack_days', Params::getParam("3_in_1_pack_days") ? Params::getParam("3_in_1_pack_days") : '7', 'rupayments', 'INTEGER');
        osc_set_preference('currency', Params::getParam("currency") ? Params::getParam("currency") : 'USD', 'rupayments', 'STRING');
        osc_set_preference('days_before_deadline_for_sending_email', Params::getParam("days_before_deadline_for_sending_email"), 'rupayments', 'INTEGER');
		osc_set_preference('color', Params::getParam("color") ? Params::getParam("color") : 'F0E68C', 'rupayments', 'STRING');
      //  osc_set_preference('allow_regbonus', Params::getParam("allow_regbonus") ? Params::getParam("allow_regbonus") : '0', 'rupayments', 'BOOLEAN');
	  //	osc_set_preference('regbonus_value', Params::getParam("regbonus_value") ? Params::getParam("regbonus_value") : '1', 'rupayments', 'STRING');
		osc_set_preference('allow_itempost_form', Params::getParam("allow_itempost_form") ? Params::getParam("allow_itempost_form") : '0', 'rupayments', 'BOOLEAN');
		osc_set_preference('allow_item_form', Params::getParam("allow_item_form") ? Params::getParam("allow_item_form") : '0', 'rupayments', 'BOOLEAN');
        
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
        osc_redirect_to(osc_route_admin_url('rupayments-ads', array('l' => 'ads-settings')));
    }
?>

<?php require_once 'top_menu.php'; ?>
<div class="rupayments-manage-wrapper">
    <?php require_once 'left_menu.php'; ?>
    <div class="rupayments-manage-content rupayments-section">
        <div style="margin:15px;">
            <form action="<?php echo osc_admin_base_url(true); ?>" method="post">
                <input type="hidden" name="page" value="plugins" />
                <input type="hidden" name="action" value="renderplugin" />
                <input type="hidden" name="route" value="rupayments-ads" />
                <input type="hidden" name="plugin_action" value="done" />
                
                <table id="ads-settings" class="table-striped">
                    <tr>
                        <th><?php _e('Service', 'rupayments'); ?></th>
                        <th><?php echo sprintf(__('Cost (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
						<th><?php _e('Duration (days)', 'rupayments'); ?></th>
                        <th><?php _e('Option', 'rupayments'); ?></th>
                        <th style="width: 50px;"><?php _e('Status', 'rupayments');; ?></th>  
                    </tr>
                    
                    
                    
                    <tr>
                        <td>
                            <?php _e('Premium ads', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Allow premium ads', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i>
                        </td>
                        
                        <td>
                            <input type="text" class="xlarge" name="default_premium_cost" value="<?php echo osc_get_preference('default_premium_cost', 'rupayments'); ?>" />
                        </td>
                        
                        <td>
                            <input type="text" class="xlarge" name="premium_days" value="<?php echo osc_get_preference('premium_days', 'rupayments'); ?>" />
                        </td>
                        
                        <td>-</td>
                        
                        <td>
                            <div data-toggle="switch">
                                <input type="checkbox" class="checkbox" id="checkbox" <?php echo (osc_get_preference('allow_premium', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_premium" value="1" />
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <?php _e('Move to Top', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Allow move to top', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i>
                        </td>
                        
                        <td>
                            <input type="text" class="xlarge" name="default_top_cost" value="<?php echo osc_get_preference('default_top_cost', 'rupayments'); ?>" />
                        </td>
                        
                        <td>-</td>
                        <td>-</td>
                        
                        <td>
                            <div data-toggle="switch">
                                <input type="checkbox" class="new2check" id="new2check"<?php echo (osc_get_preference('allow_move', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_move" value="1" />
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <?php _e('Highlight', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Allow highlighting', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i>
                        </td>
                        
                        <td>
                            <input type="text" class="xlarge" name="default_color_cost" value="<?php echo osc_get_preference('default_color_cost', 'rupayments'); ?>" />
                        </td>
                        
                        <td>
                            <input type="text" class="xlarge" name="color_days" value="<?php echo osc_get_preference('color_days', 'rupayments'); ?>" />
                        </td>
                        
                        <td>
                            <input class="jscolor" type="color" class="xlarge" name="color" value="<?php echo osc_esc_html(osc_get_preference('color', 'rupayments')); ?>" />
                        </td>
                        
                        <td>
                            <div data-toggle="switch">
                                <input type="checkbox" class="new2ch2eck" id="new2ch2eck" <?php echo (osc_get_preference('allow_high', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_high" value="1" />
                            </div>
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <td>
                            <?php _e('Pack 3-in-1', 'rupayments'); ?> <i id="tips" data-tipso="<?php _e('Enable purchase of services package (Premium + Highlighting + Move to Top)', 'rupayments'); ?>" class="fa fa-question-circle fa-help"></i>
                        </td>
                        
                        <td>
                            <input type="text" class="xlarge" name="default_3_in_1_pack_cost" value="<?php echo osc_get_preference('default_3_in_1_pack_cost', 'rupayments'); ?>" />
                        </td>
                        
                        <td>
                            <input type="text" class="xlarge" name="3_in_1_pack_days" value="<?php echo osc_get_preference('3_in_1_pack_days', 'rupayments'); ?>" />
                        </td>
                        
                        <td>-</td>
                        
                        <td>
                            <div data-toggle="switch">
                                <input type="checkbox" class="pay2per" id="pay2per"<?php echo (osc_get_preference('3_in_1_pack_status', 'rupayments') ? 'checked="true"' : ''); ?> name="3_in_1_pack_status" value="1" />
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <?php _e('Publish fee', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Pay per post ads', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i> <i id="info" data-tipso="<?php _e('Logout from oc-admin to test this function.', 'rupayments'); ?>" class="fa fa-exclamation-circle fa-alert"></i>
                        </td>
                        
                        <td>
                            <input type="text" class="xlarge" name="default_publish_cost" value="<?php echo osc_get_preference('default_publish_cost', 'rupayments'); ?>" />
                        </td>
                        
                        <td>-</td>
                        <td>-</td>
                        
                        <td>
                            <div data-toggle="switch">
                                <input type="checkbox" class="pay2per" id="pay2per"<?php echo (osc_get_preference('pay_per_post', 'rupayments') ? 'checked="true"' : ''); ?> name="pay_per_post" value="1" />
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <?php _e('Renew fee', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Pay renew expiration item', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i>
                        </td>
                        
                        <td>
                            <input type="text" class="xlarge" name="default_renew_cost" value="<?php echo osc_get_preference('default_renew_cost', 'rupayments'); ?>" />
                        </td>
                        
                        <td>-</td>
                        <td>-</td>
                        
                        <td>
                            <div data-toggle="switch">
                                <input type="checkbox" class="pay2ren" id="pay2ren"<?php echo (osc_get_preference('allow_renew', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_renew" value="1" />
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <?php _e('Pay per Show Image', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('When enabled, users must pay to show images on their ads', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i>
                        </td>
                        
                        <td>
                            <input type="text" class="xlarge" name="default_pay_per_show_image_cost" value="<?php echo osc_get_preference('default_pay_per_show_image_cost', 'rupayments'); ?>" />
                        </td>
                        
                        <td>-</td>
                        <td>-</td>
                        
                        <td>
                            <div data-toggle="switch">
                                <input type="checkbox" class="pay2per" id="pay2per"<?php echo (osc_get_preference('pay_per_show_image_status', 'rupayments') ? 'checked="true"' : ''); ?> name="pay_per_show_image_status" value="1" />
                            </div>
                        </td>
                    </tr>
                    
                    <tr><td colspan="5" style="background: #474749; padding: 10px;"></td></tr>

                    <tr>
                        <td style="width: 300px;">
                            <?php _e('Default currency', 'rupayments'); ?> <i id="info" data-tipso="<?php _e('IMPORTANT! Only 2checkout work with all currencies. <br /> Payumoney work only with INR. Braintree and Fortumo setup currency in your merchant account. For other payment system - see in official sites.', 'rupayments'); ?>" class="fa fa-exclamation-circle fa-alert"></i>
                        </td>
                        <td colspan="4" style="text-align: left;">
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
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <?php _e('After publish', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Allow after publish', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i> <i id="info" data-tipso="<?php _e('This option offers to user after the item publication -  paid services. <br /> Work Only if Item-post Form Disabled. Logout from oc-admin to test this function.', 'rupayments'); ?>" class="fa fa-exclamation-circle fa-alert"></i>
                        </td>
                        <td colspan="4" style="text-align: left;">
                            <div data-toggle="switch">
                                <input type="checkbox" class="al2after" id="al2after"<?php echo (osc_get_preference('allow_after', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_after" value="1" />
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <?php _e('Item-post Form', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('This option offers to user in the item publication step -  paid services.', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i> <i id="info" data-tipso="<?php _e('Logout from oc-admin to test this function.', 'rupayments'); ?>" class="fa fa-exclamation-circle fa-alert"></i>
                        </td>
                        <td colspan="4" style="text-align: left;">
                            <div data-toggle="switch">
                                <input type="checkbox" class="al2form" id="al2form"<?php echo (osc_get_preference('allow_itempost_form', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_itempost_form" value="1" />
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <?php _e('Item Form', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('This option offers to user in the item page -  paid services.', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i> <i id="info" data-tipso="<?php _e('Logout from oc-admin to test this function.', 'rupayments'); ?>" class="fa fa-exclamation-circle fa-alert"></i>
                        </td>
                        <td colspan="4" style="text-align: left;">
                            <div data-toggle="switch">
                                <input type="checkbox" class="al2iform" id="al2iform"<?php echo (osc_get_preference('allow_item_form', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_item_form" value="1" />
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <?php _e('Days (send e-mail) before payment deadline', 'rupayments'); ?>
                        </td>
                        <td colspan="4" style="text-align: left;">
                            <input type="text" class="xlarge" name="days_before_deadline_for_sending_email" value="<?php echo osc_get_preference('days_before_deadline_for_sending_email', 'rupayments'); ?>" />
                        </td>
                    </tr>
                </table>
                
                <div class="form-actions">
                    <input type="submit" id="save_changes" value="<?php echo osc_esc_html(__("Save changes", 'rupayments')); ?>" class="btn btn-submit">
                </div>
            </form>
        </div>
    </div>
</div>