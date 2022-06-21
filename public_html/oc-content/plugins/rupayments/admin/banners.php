<?php defined('ABS_PATH') or die('Access denied'); 
    $i = 1;
    $banners = ModelRUpayments::newInstance()->getBannersPublish();
    
    $do = Params::getParam('do');
    $id = Params::getParam('id');
    
    if($do) {
        switch($do) {
            case 'banner-accept' :
                $text = __('Accepted', 'rupayments');
                $result = ModelRUpayments::newInstance()->acceptBannerPublish($id);
            break;
            
            case 'banner-reject' :
                $text = __('Rejected', 'rupayments');
                $result = ModelRUpayments::newInstance()->rejectBannerPublish($id);
            break;
            
            case 'banner-delete' :
                $text = __('Deleted', 'rupayments');
                $result = ModelRUpayments::newInstance()->deleteBannerPublish($id);
            break;
        }
        
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        
        if($result) osc_add_flash_ok_message(__('Congratulations, the banner ' . $text . ' succesfully', 'rupayments'), 'admin');
            else osc_add_flash_error_message(__('Error: The Banner can\'t be ' . $text . '', 'rupayments'), 'admin');
            
        osc_redirect_to(osc_route_admin_url('rupayments-banners', array('l' => 'banners')));
    }
?>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">

<?php require_once 'top_menu.php'; ?>
<div class="rupayments-manage-wrapper">
    <?php require_once 'left_menu.php'; ?>
    
    <div class="rupayments-manage-content rupayments-section">
        <div style="margin:15px;">
            <?php if($banners): ?>
                <table class="table-striped">
                    <tr>
                        <th style="width: 10px;"><?php _e('ID', 'rupayments') ?></th>
                        <th><?php _e('Banner', 'rupayments') ?></th>
                        <th><?php _e('Views', 'rupayments') ?></th>
                        <th><?php _e('Clicks', 'rupayments') ?></th>
                        <th><?php _e('Spent', 'rupayments') ?></th>
                        <th><?php _e('Budget', 'rupayments') ?></th>
                        <th style="width: 115px;"><?php _e('Status', 'rupayments') ?></th>
                        <th style="width: 35px;"><?php _e('Action', 'rupayments') ?></th>
                    </tr>
                    
                    <?php foreach($banners as $banner): ?>
                    <tr>
                         <td><?php echo $i; $i++; ?></td>
                        <td><img style="width: 150px; max-height: 150px;" src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/banners/<?php echo $banner['s_banner_img']; ?>" /></td>
                        <td><?php echo $banner['i_banner_views']; ?><br /><small><?php _e('Fee', 'rupayments') ?>: <?php echo $banner['s_banner_view_fee'] . osc_get_preference('currency', 'rupayments'); ?></small></td>
                        <td><?php echo $banner['i_banner_clicks']; ?><br /><small><?php _e('Fee', 'rupayments') ?>: <?php echo $banner['s_banner_click_fee'] . osc_get_preference('currency', 'rupayments'); ?></small></td>
                        <td><?php echo $banner['s_banner_spent'] . osc_get_preference('currency', 'rupayments'); ?></td>
                        <td><?php echo $banner['i_banner_budget'] . osc_get_preference('currency', 'rupayments'); ?></td>
                        <td> <?php echo $banner['status']; ?></td>
                        <td>
                            <div id="banners-toolbar" data-toolbar="toolbar-options-<?php echo $banner['fk_i_banner_id'] ?>" class="btn-toolbar">
                                <i class="fa fa-cog"></i> 
                            </div>
                            <div id="toolbar-options-<?php echo $banner['fk_i_banner_id'] ?>" class="toolbar-icons hidden">
                                <a id="accept" href="<?php echo osc_route_admin_url('rupayments-banners', array('l' => 'banners','do' => 'banner-accept', 'id' => $banner['fk_i_banner_id'])); ?>" title="<?php _e('Accept Banner', 'rupayments') ?>"><i class="fa fa-check"></i></a>
                                <a id="reject" href="<?php echo osc_route_admin_url('rupayments-banners', array('l' => 'banners','do' => 'banner-reject', 'id' => $banner['fk_i_banner_id'])); ?>" title="<?php _e('Reject Banner', 'rupayments') ?>"><i class="fa fa-times"></i></a>
                            	<a id="remove" href="<?php echo osc_route_admin_url('rupayments-banners', array('l' => 'banners','do' => 'banner-delete', 'id' => $banner['fk_i_banner_id'])); ?>" title="<?php _e('Delete Banner', 'rupayments') ?>"><i class="fa fa-trash-o"></i></a>
                                
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
            <div class="flashmessage flashmessage-warning" style="display: block;"><?php _e('No data to display','rupayments') ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
$('div#banners-toolbar').hover(function(){
    var id = $(this).attr('data-toolbar');
    
    $('div[data-toolbar="' + id + '"]').toolbar({
        content: '#' + id,
        style: 'primary',
    	event: 'click',
    	hideOnClick: true
    });
});

$('a#accept').click(function(){
    location.href = $(this).attr('href');
});

$('a#reject').click(function(){
    location.href = $(this).attr('href');
});

$('a#remove').click(function() {
    if(confirm('<?php _e("Are you sure you want to delete this banner?","rupayments") ?>')) location.href = $(this).attr('href');
    
    return false;
});
</script>