<?php defined('ABS_PATH') or die('Access denied'); 

    $deals = ModelRUpayments::newInstance()->getEbuyDeals();
    
    $do = Params::getParam('do');
    
    if($do == 'change-status') {
        $status = Params::getParam('deal-status');
        $id = Params::getParam('id');
        
        if($status && $id) {
            $result = ModelRUpayments::newInstance()->changeEbuyDealStatus($id, $status, true);
        
            // HACK : This will make possible use of the flash messages ;)
            ob_get_clean();
            
            if($result) {
                osc_add_flash_ok_message(__('Congratulations! Deal Status successfully changed.', 'rupayments'), 'admin');
            }
            else {
                osc_add_flash_error_message(__('Error: You can\'t change the Deal Status!', 'rupayments'), 'admin');
            }
        }
        else {
            osc_add_flash_error_message(__('Error: You can\'t change the Deal Status!', 'rupayments'), 'admin');
        }
        
        osc_redirect_to(osc_route_admin_url('rupayments-ebuy'));
    }
    

    if(Params::getParam('plugin_action') == 'settings') {
        osc_set_preference('allow_ebuy', Params::getParam("allow_ebuy") ? Params::getParam("allow_ebuy") : '0', 'rupayments', 'BOOLEAN');
        		
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
		osc_redirect_to(osc_route_admin_url('rupayments-ebuy'));
    }
?>

<?php require_once 'top_menu.php'; ?>

<div class="rupayments-manage-wrapper">
    <div class="cd-tabs">
        <nav>
            <ul class="cd-tabs-navigation">
                <li><a data-content="ebuy" class="selected" href="javascript:void(0);"><?php _e('eBuy', 'rupayments'); ?></a></li>
                <li><a data-content="settings" href="javascript:void(0);"><?php _e('Settings', 'rupayments'); ?></a></li>
            </ul>
        </nav>
        
        <ul class="cd-tabs-content">
            <li data-content="ebuy" class="selected">
                <?php if($deals): ?>
                    <table class="table-striped">
                        <tr>
                            <th style="width: 200px;"><?php _e('Item', 'rupayments') ?></th>
                            <th><?php _e('Seller', 'rupayments') ?></th>
                            <th><?php _e('Buyer', 'rupayments') ?></th>
                            <th><?php _e('Price', 'rupayments') ?></th>
                            <th><?php _e('Payment Status', 'rupayments') ?></th>
                            <th><?php _e('Deal Status', 'rupayments') ?></th>
                            <th><?php _e('Action', 'rupayments') ?></th>
                        </tr>
                        
                        <?php foreach($deals as $deal): ?>
                        <tr>
                            <td><?php echo $deal['s_title']; ?></td>
                            <td><?php echo $deal['s_contact_name']; ?></td>
                            <td><?php echo $deal['s_name']; ?></td>
                            <td><?php echo $deal['s_item_price'] . $deal['s_item_currency']; ?></td>
                            <td><?php echo $deal['p_status']; ?></td>
                            <td><?php echo $deal['d_status']; ?></td>
                            <td>
                                <div id="deals-toolbar" data-toolbar="toolbar-options-<?php echo $deal['fk_i_edeal_id'] ?>" class="btn-toolbar">
                                    <i class="fa fa-cog"></i> 
                                </div>
                                <div id="toolbar-options-<?php echo $deal['fk_i_edeal_id'] ?>" class="toolbar-icons hidden">
                                    <a id="accept" href="<?php echo osc_route_admin_url('rupayments-ebuy', array('do' => 'change-status', 'deal-status' => 'deal-accept', 'id' => $deal['fk_i_edeal_id'] )); ?>" title="<?php _e('Accept Deal', 'rupayments') ?>"><i class="fa fa-check"></i></a>
                                    <a id="cancel" href="<?php echo osc_route_admin_url('rupayments-ebuy', array('do' => 'change-status', 'deal-status' => 'deal-cancel', 'id' => $deal['fk_i_edeal_id'] )); ?>" title="<?php _e('Cancel Deal', 'rupayments') ?>"><i class="fa fa-times"></i></a>
                                	<a id="withdrawn" href="<?php echo osc_route_admin_url('rupayments-ebuy', array('do' => 'change-status', 'deal-status' => 'deal-withdrawn', 'id' => $deal['fk_i_edeal_id'] )); ?>" title="<?php _e('Withdrawn', 'rupayments') ?>"><i class="fa fa-credit-card"></i></a>
                                    
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <div class="flashmessage flashmessage-warning" style="display: block;"><?php _e('No data to display','rupayments') ?></div>
                <?php endif; ?>
			<div class="code-block">
                <p class="help-box"><?php _e('This option allows users to sell products directly on your website.', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('All payments for goods will be received by you.', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('On this page there will be information on each sale.', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('The seller and buyer will also be able to see this information in their personal account.', 'rupayments'); ?></p>

            </div>
            </li>
            
            <li data-content="settings">
                <form action="<?php echo osc_admin_base_url(true); ?>" method="post">
                    <input type="hidden" name="page" value="plugins" />
                    <input type="hidden" name="action" value="renderplugin" />
                    <input type="hidden" name="route" value="rupayments-ebuy" />
                    <input type="hidden" name="plugin_action" value="settings" />
                    
                    <table class="table table-no-border">
                        <tr>
                            <td style="width: 300px;">
                                <?php _e('eBuy Status', 'rupayments'); ?> <i id="tips" data-tipso='<?php _e('Allow users to sell in ads via the site', 'rupayments'); ?>' class="fa fa-question-circle fa-help"></i>
                            </td>
                            <td>
                                <div data-toggle="switch">
                                    <input type="checkbox" <?php echo (osc_get_preference('allow_ebuy', 'rupayments') ? 'checked="true"' : ''); ?> name="allow_ebuy" value="1" />
                                </div>
                            </td>
                        </tr>
                    </table>
                    
                    <div class="form-actions">
                        <input type="submit" id="save_changes" value="<?php echo osc_esc_html(__("Save Changes", 'rupayments')); ?>" class="btn btn-submit">
                    </div>
                </form>
            </li>
        </ul>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('div#deals-toolbar').hover(function(){
        var id = $(this).attr('data-toolbar');
        
        $('div[data-toolbar="' + id + '"]').toolbar({
            content: '#' + id,
            style: 'primary',
        	event: 'click',
        	hideOnClick: true
        });
    });
    
    $('a#accept').click(function(){
        if(confirm('<?php _e("Are you sure you want to Accept Deal?","rupayments") ?>')) location.href = $(this).attr('href');
        
        return false;
    });
    
    $('a#cancel').click(function(){
        if(confirm('<?php _e("Are you sure you want to Cancel Deal?","rupayments") ?>')) location.href = $(this).attr('href');
        
        return false;
    });
    
    $('a#withdrawn').click(function() {
        if(confirm('<?php _e("Are you sure you want to change the status of the Deal to \"Money Withdrawn\"?","rupayments") ?>')) location.href = $(this).attr('href');
        
        return false;
    });
});
</script>