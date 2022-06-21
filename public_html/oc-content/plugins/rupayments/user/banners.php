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
    
    $do = Params::getParam('do');
    
    if($do == 'banner-delete') {
        $id = Params::getParam('id');
        
        $result = ModelRUpayments::newInstance()->deleteUserBannerPublish($id, osc_logged_user_id());
        
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        
        if($result) {
            osc_add_flash_ok_message(__('Congratulations! Banner successfully deleted.', 'rupayments'));
        }
        else {
            osc_add_flash_error_message(__('Error: You can\'t delete the banner!', 'rupayments'));
        }
        
        osc_redirect_to(osc_route_url('rupayments-user-banners'));
    }

    $user_banners = ModelRUpayments::newInstance()->getUserBannersPublish(osc_logged_user_id());
?>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/tables.css">
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">

<div class="menu_ppaypal">
    <h2 class="paypal_h"><?php _e('Banners', 'rupayments'); ?></h2>
</div>

<?php if($user_banners): ?>
<table>
    <tr>
        <th><?php _e('Banner', 'rupayments') ?></th>
        <th><?php _e('Views', 'rupayments') ?></th>
        <th><?php _e('Clicks', 'rupayments') ?></th>
        <th><?php _e('Spent', 'rupayments') ?></th>
        <th><?php _e('Budget', 'rupayments') ?></th>
        <th style="width: 115px;"><?php _e('Status', 'rupayments') ?></th>
        <th style="width: 35px;"><?php _e('Action', 'rupayments') ?></th>
    </tr>
    
    <?php foreach($user_banners as $banner): ?>
    <tr>
        <td><img style="width: 150px; max-height: 150px;" src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/banners/<?php echo $banner['s_banner_img']; ?>" /></td>
        <td><?php echo $banner['i_banner_views']; ?><br /><small><?php _e('Fee', 'rupayments') ?>: <?php echo $banner['s_banner_view_fee'] . osc_get_preference('currency', 'rupayments'); ?></small></td>
        <td><?php echo $banner['i_banner_clicks']; ?><br /><small><?php _e('Fee', 'rupayments') ?>: <?php echo $banner['s_banner_click_fee'] . osc_get_preference('currency', 'rupayments'); ?></small></td>
        <td><?php echo $banner['s_banner_spent'] . osc_get_preference('currency', 'rupayments'); ?></td>
        <td><?php echo $banner['i_banner_budget'] . osc_get_preference('currency', 'rupayments'); ?></td>
        <td> <?php echo $banner['status']; ?></td>
        <td>
            <?php if($banner['i_banner_status'] == 3): ?> 
                <a class="banner-pay-btn" href="<?php echo $banner['pay_link']; ?>" title="<?php _e('Pay Now', 'rupayments') ?>"><i class="fa fa-credit-card fa-lg" style="color: #ff9900;"></i></a>
            <?php else: ?>
            <a id="remove" class="remove" href="<?php echo $banner['delete_link']; ?>" title="<?php _e('Remove Banner', 'rupayments') ?>"><i class="fa fa-trash-o fa-lg"></i></a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<div class="flashmessage flashmessage-warning" style="display: block;"><?php _e('No data to display','rupayments') ?></div>
<?php endif; ?>

<script type="text/javascript">
$('a#remove').click(function() {
    if(confirm('<?php _e("Are you sure you want to delete this banner?","rupayments") ?>')) return true;
    
    return false;
});
</script>