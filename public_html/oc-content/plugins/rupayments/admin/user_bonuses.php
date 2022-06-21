<?php defined('ABS_PATH') or die('Access denied'); 
    $mp = ModelRUpayments::newInstance();
    
    if(Params::getParam('plugin_action') == 'add-bonus') {
        $useremail = Params::getParam("user_email");
		$user = $mp->getUser_rupayments($useremail);
		$amount = Params::getParam("bonus");
        $concept = sprintf(__('Add bonus to user (%s)', 'rupayments'), $user);
		$code = "0";
		$email = Params::getParam("user_id");
		$item = "0";
		$source = "Bonus";
		$product_type = "Bonus";
		$item  = Params::getParam("user_id");
		$currency = osc_get_preference('currency', 'rupayments');
		
        $mp->addWallet($user, $amount);
        $mp->saveLog($concept, $code, $amount, $currency, $useremail, $user, $item, $product_type, $source); 		
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the Bonus is now added', 'rupayments'), 'admin');
		osc_redirect_to(osc_route_admin_url('rupayments-users', array('l' => 'bonuses')));
    }
    else if(Params::getParam('plugin_action') == 'done') {
        osc_set_preference('allow_regbonus', Params::getParam("allow_regbonus") ? Params::getParam("allow_regbonus") : '0', 'rupayments', 'BOOLEAN');
		osc_set_preference('regbonus_value', Params::getParam("regbonus_value") ? Params::getParam("regbonus_value") : '1', 'rupayments', 'STRING');
        osc_set_preference('allow_periodbonus', Params::getParam("allow_periodbonus") ? Params::getParam("allow_periodbonus") : '0', 'rupayments', 'BOOLEAN');
		osc_set_preference('periodbonus_value', Params::getParam("periodbonus_value") ? Params::getParam("periodbonus_value") : '1', 'rupayments', 'STRING');
        osc_set_preference('period_value', Params::getParam("period_value") ? Params::getParam("period_value") : '7', 'rupayments', 'INTEGER');
        osc_set_preference('periodbonus_start_date', date('Y-m-d', time()), 'rupayments', 'STRING');
        
        if(Params::getParam("allow_periodbonus")) osc_set_preference('periodbonus_last_accrual', date('Y-m-d', time()), 'rupayments', 'STRING');
        
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
		osc_redirect_to(osc_route_admin_url('rupayments-users', array('l' => 'bonuses')));
    }
?>

<?php require_once 'top_menu.php'; ?>
<div class="rupayments-manage-wrapper">
    <?php require_once 'left_menu.php'; ?>
    <div class="rupayments-manage-content rupayments-section">
        <div class="cd-tabs">
            <nav>
                <ul class="cd-tabs-navigation">
                    <li><a data-content="bonuses" class="selected" href="javascript:void(0);"><?php _e('Bonuses', 'rupayments'); ?></a></li>
                    <li><a data-content="add-bonus" href="javascript:void(0);"><?php _e('Add Bonus', 'rupayments'); ?></a></li>
                </ul>
            </nav>
            
            <ul class="cd-tabs-content">
                <li data-content="bonuses" class="selected">
                    <form action="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&route=rupayments-users&l=bonuses'; ?>" method="post">
                        <input type="hidden" name="page" value="plugins" />
                        <input type="hidden" name="action" value="renderplugin" />
                        <input type="hidden" name="plugin_action" value="done" />
                        
                        <table class="table table-no-border">
                            <tr>
                                <td style="width: 300px;">
                                    <?php _e('Bonus for new user', 'rupayments'); ?>
                                </td>
                                <td>
                                    <div data-toggle="switch">
                                        <input type="checkbox" class="al2bonus" id="al2bonus"<?php echo (osc_get_preference('allow_regbonus', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_regbonus" value="1" />
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <?php _e('Bonus value', 'rupayments'); ?>
                                </td>
                                <td>
                                    <input type="text" class="xlarge" name="regbonus_value" value="<?php echo osc_get_preference('regbonus_value', 'rupayments'); ?>" />
                                </td>
                            </tr>
                            
                            <tr>
                                <td style="width: 300px;">
                                    <?php _e('Periodic accrual of bonuses', 'rupayments'); ?>
                                </td>
                                <td>
                                    <div data-toggle="switch">
                                        <input type="checkbox" class="al2bonus" id="al2bonus"<?php echo (osc_get_preference('allow_periodbonus', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_periodbonus" value="1" />
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <?php _e('Period bonus amount', 'rupayments'); ?>
                                </td>
                                <td>
                                    <input type="text" class="xlarge" name="periodbonus_value" value="<?php echo osc_get_preference('periodbonus_value', 'rupayments'); ?>" />
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <?php _e('Period', 'rupayments'); ?>
                                </td>
                                <td>
                                    <select name="period_value">
                                        <option value="7" <?php if(osc_get_preference('period_value', 'rupayments') == 7) { echo 'selected="selected"';}; ?> ><?php _e('Week', 'rupayments') ?></option>
        								<option value="30" <?php if(osc_get_preference('period_value', 'rupayments') == 30) { echo 'selected="selected"';}; ?> ><?php _e('Month', 'rupayments') ?></option>
        								<option value="90" <?php if(osc_get_preference('period_value', 'rupayments') == 90) { echo 'selected="selected"';}; ?> ><?php _e('Quarter', 'rupayments') ?></option>                             
                                    </select>
                                </td>
                            </tr>
                        </table>
                        
                        <div class="form-actions">
                            <input type="submit" id="save_changes" value="<?php echo osc_esc_html(__("Save changes", 'rupayments')); ?>" class="btn btn-submit">
                        </div>
                    </form>
                </li>
                
                <li data-content="add-bonus">
                    <form action="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&route=rupayments-users&l=bonuses'; ?>" method="post">
                        <input type="hidden" name="page" value="plugins" />
                        <input type="hidden" name="action" value="renderplugin" />
                        <input type="hidden" name="plugin_action" value="add-bonus" />
                        
                        <table class="table table-no-border">
                            <tr>
                                <td style="width: 300px;">
                                    <i class="fa fa-user"></i> <?php _e('User e-mail', 'rupayments'); ?>
                                </td>
                                <td>
                                    <input type="text" class="xlarge" name="user_email" value="" />
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <i class="fa fa-money"></i> <?php _e('Bonus', 'rupayments'); ?>
                                </td>
                                <td>
                                    <input type="text" class="xlarge" name="bonus" value="" />
                                </td>
                            </tr>
                        </table>
                        
                        <div class="form-actions">
                            <input type="submit" id="save_changes" value="<?php echo osc_esc_html(__("Add Bonus", 'rupayments')); ?>" class="btn btn-submit">
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>