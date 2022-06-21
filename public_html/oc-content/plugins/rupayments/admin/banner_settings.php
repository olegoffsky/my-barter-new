<?php defined('ABS_PATH') or die('Access denied'); 
    $i = 1;
    $banners = ModelRUpayments::newInstance()->getBannersSettings();
    
    if(Params::getParam('plugin_action') == 'done') {
        $upd_banner_settings = ModelRUpayments::newInstance()->updateBannersSettings();
        
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
        osc_redirect_to(osc_route_admin_url('rupayments-banners', array('l' => 'banner-settings')));
    }
?>

<?php require_once 'top_menu.php'; ?>
<div class="rupayments-manage-wrapper">
    <?php require_once 'left_menu.php'; ?>
    
    <div class="rupayments-manage-content rupayments-section">
        <div style="margin:15px;">
            <form action="<?php echo osc_route_admin_url('rupayments-banners', array('l' => 'banner-settings')); ?>" method="post">
                <input type="hidden" name="page" value="plugins" />
                <input type="hidden" name="action" value="renderplugin" />
                <input type="hidden" name="plugin_action" value="done" />
                
                <table id="table-banner-settings" class="table-striped">
                    <tr>
                        <th><?php _e('ID', 'rupayments'); ?></th>
                        <th><?php _e('Banner Title', 'rupayments'); ?></th>
						<th><?php _e('Code', 'rupayments'); ?> <i id="info" data-tipso="<?php _e('To enable the ability to buy the publication of banners, put this line of code anywhere in your template!', 'rupayments'); ?>" class="fa fa-exclamation-circle fa-alert"></i></th>
                        <th><?php echo sprintf(__('Views Fee (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th><?php echo sprintf(__('Clicks Fee (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th style="width: 50px;"><?php _e('Status', 'rupayments');; ?></th>  
                    </tr>
                    
                    <?php if($banners): ?>
                        <?php foreach($banners as $k => $banner): ?>
                            <tr>
                                <input type="hidden" name="banner_id[]" value="<?php echo $banner['fk_i_bs_id'] ?>" />
                                <td id="id"><?php echo $i; ?></td>
                                <td><input type="text" name="banner_name[]" placeholder="<?php _e('Banner Title', 'rupayments') ?>" value="<?php echo $banner['fk_bs_title'] ?>" /></td>
                                <td class="banner-code"><?php echo $banner['f_bs_code'] ?></td>
                                <td class="banner-fee"><input type="text" name="banner_view_fee[]" placeholder="<?php _e('Views Fee', 'rupayments') ?>" value="<?php echo $banner['f_bs_view_fee'] ?>" /></td>
                                <td class="banner-fee"><input type="text" name="banner_click_fee[]" placeholder="<?php _e('Clicks Fee', 'rupayments') ?>" min="1" value="<?php echo $banner['f_bs_click_fee'] ?>" /></td>
                                <td>
                                    <div data-toggle="switch">                                                                            
                                        <input type="checkbox" name="banner_status[<?php echo $k; ?>]" value="1" <?php if($banner['f_bs_status']): ?>checked<?php endif; ?> />
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
                
                <div class="form-actions">
                    <input type="submit" id="save_changes" value="<?php echo osc_esc_html(__("Save changes", 'rupayments')); ?>" class="btn btn-submit">
                </div>
            </form>
			<div class="code-block">
                <p class="help-box"><?php _e('You can add the banner code to the any places on the site.', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('Users of the site will be able to buy a place and upload their banner.', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('First the user upload his banner.', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('After that, the banner will be waiting moderation from you in Banners.', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('After your approval, the user will be able to prepay views or clicks of the banner.', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('After the prepayment amount has been used up, the banner will not be displayed.', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('The full statistics of views and clicks the user can see in the personal account on the site.', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('You, too, can see all the statistics in the menu Banners.', 'rupayments'); ?></p>
            </div>
        </div>
    </div>
</div>