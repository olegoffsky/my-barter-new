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
    
    $banner_settings = ModelRUpayments::newInstance()->getBannerSettings(Params::getParam('bid'));
    $view_fee = $banner_settings['f_bs_view_fee'] - $banner_settings['f_bs_view_fee'] * ModelRUpayments::newInstance()->userDiscount / 100;
    $click_fee = $banner_settings['f_bs_click_fee'] - $banner_settings['f_bs_click_fee'] * ModelRUpayments::newInstance()->userDiscount / 100;
    
    if(Params::getParam('action') == 'add-banner') {
        $banner_publish = ModelRUpayments::newInstance()->siteBannerPublish();
        
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations! The request to publish the banner has been successfully sent! <br /> After checking by the moderator, you can pay for the placement of the banner and then it will be shown on the site.', 'rupayments'));
        osc_redirect_to(osc_route_url('rupayments-user-banners'));
    }
?>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">
<script type="text/javascript" src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/js/fineuploader/jquery.fineuploader.min.js"></script>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/fineuploader.css">

<div class="form-container form-horizontal banner-publish-block">
    <div class="resp-wrapper">
        <div class="headerbanuser">
            <h1><?php _e('Publish a banner', 'rupayments'); ?></h1>
        </div>
        <div class="banner-publish-fee-block">
            <h2 class="paypal_h"><?php _e('Banner Fee', 'rupayments'); ?></h2>
            
            <p><?php _e('1x View Fee', 'rupayments'); ?>: <?php echo $view_fee . osc_get_preference('currency', 'rupayments'); ?></p>
            <p><?php _e('1x Click Fee', 'rupayments'); ?>: <?php echo $click_fee . osc_get_preference('currency', 'rupayments'); ?></p>
        </div>
        
        <form action="<?php echo osc_route_url('rupayments-banner-publish',array('bid' => Params::getParam('bid'))); ?>" id="stripe-form" name="stripe-form" enctype="multipart/form-data" method="post">
        
            <input type="hidden" name="action" value="add-banner" />
            <input type="hidden" name="bid" value="<?php echo Params::getParam('bid');?>" />
            
            <div class="control-group">
                <label class="control-label" for="link"><?php _e('Link', 'rupayments'); ?></label> (<?php _e('Full link to your site with HTTP or HTPPS, like http://demo.com', 'rupayments'); ?>)
                <div class="controls">
                    <input id="link" type="text" name="banner_link" />
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="budget"><?php _e('Budget', 'rupayments'); ?></label> (<?php _e('Enter only a number, for example 250', 'rupayments'); ?>)
                <div class="controls">
                    <input id="budget" type="text" name="banner_budget" />
                </div>
            </div>
            
            <div class="control-group banner-upload">
            <?php ModelRUpayments::ajax_banners(); ?>
            </div>
            
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="ui-button ui-button-middle ui-button-main"><?php _e("Publish", 'rupayments'); ?></button>
                </div>
            </div>
        
        </form>
    </div>
</div>

