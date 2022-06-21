<?php defined('ABS_PATH') or die('Access denied');
    $_r = Params::getParam('route');
?>
<div class="rupayments-manage-menu">
    <ul>
    <?php switch($_r): ?>
<?php case 'rupayments-ads': ?>
            <li <?php if(rupayments_get_left_menu('ads-settings')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo osc_route_admin_url('rupayments-ads', array('l' => 'ads-settings')); ?>"><?php _e('Settings', 'rupayments'); ?></a>
            </li>
    
            <li <?php if(rupayments_get_left_menu('category-prices')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo osc_route_admin_url('rupayments-ads', array('l' => 'category-prices')); ?>"><?php _e('Category Prices', 'rupayments'); ?></a>
            </li>
            
            <li <?php if(rupayments_get_left_menu('region-prices')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo osc_route_admin_url('rupayments-ads', array('l' => 'region-prices')); ?>"><?php _e('Cities Prices', 'rupayments'); ?></a>
            </li>
            
            <li <?php if(rupayments_get_left_menu('publishing-policy')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo osc_route_admin_url('rupayments-ads', array('l' => 'publishing-policy')); ?>"><?php _e('Publishing Policy', 'rupayments'); ?></a>
            </li>
<?php break; ?>
<?php case 'rupayments-users': ?>
            <li <?php if(rupayments_get_left_menu('packs')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo osc_route_admin_url('rupayments-users', array('l' => 'packs')); ?>"><?php _e('Packs', 'rupayments'); ?></a>
            </li>
            
            <li <?php if(rupayments_get_left_menu('groups')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo osc_route_admin_url('rupayments-users', array('l' => 'groups')); ?>"><?php _e('User Groups', 'rupayments'); ?></a>
            </li>
            
            <li <?php if(rupayments_get_left_menu('bonuses')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo osc_route_admin_url('rupayments-users', array('l' => 'bonuses')); ?>"><?php _e('Bonuses', 'rupayments'); ?></a>
            </li>
<?php break; ?>

<?php case 'rupayments-banners': ?>
            <li <?php if(rupayments_get_left_menu('banner-settings')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo osc_route_admin_url('rupayments-banners', array('l' => 'banner-settings')); ?>"><?php _e('Settings', 'rupayments'); ?></a>
            </li>
            
            <li <?php if(rupayments_get_left_menu('banners')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo osc_route_admin_url('rupayments-banners', array('l' => 'banners')); ?>"><?php _e('Banners', 'rupayments'); ?></a>
            </li>
<?php break; ?>
        <?php endswitch; ?>
    </ul>
</div>