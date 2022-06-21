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
    
    $user_id = osc_logged_user_id();
    
    $buy_list = ModelRUpayments::newInstance()->getEbuyBuyList($user_id);
    $sell_list = ModelRUpayments::newInstance()->getEbuySellList($user_id);
    
    $do = Params::getParam('do');
    
    if($do == 'change-status') {
        
        $status = Params::getParam('deal-status');
        $id = Params::getParam('id');
        
        if($status && $id) {
            $result = ModelRUpayments::newInstance()->changeUserEbuyDealStatus($id, $status, $user_id);
        
            // HACK : This will make possible use of the flash messages ;)
            ob_get_clean();
            
            if($result) {
                osc_add_flash_ok_message(__('Congratulations! Deal Status successfully changed.', 'rupayments'));
            }
            else {
                osc_add_flash_error_message(__('Error: You can\'t change the Deal Status!', 'rupayments'));
            }
        }
        else {
            osc_add_flash_error_message(__('Error: You can\'t change the Deal Status!', 'rupayments'));
        }
        
        osc_redirect_to(osc_route_url('rupayments-user-ebuy-deals'));
    }
?>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/tables.css">
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/tabs.css">
<script type="text/javascript" src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/js/tabs.js"></script>

<div class="menu_ppaypal">
    <h2 class="paypal_h"><?php _e('Deals', 'rupayments'); ?></h2>
</div>

<div class="cd-tabs">
    <nav>
        <ul class="cd-tabs-navigation">
            <li><a data-content="buy-list" class="selected" href="javascript:void(0);"><?php _e('Buy List', 'rupayments'); ?></a></li>
            <li><a data-content="sell-list" href="javascript:void(0);"><?php _e('Sell List', 'rupayments'); ?></a></li>
        </ul>
    </nav>    
    
    <ul class="cd-tabs-content">
        <li data-content="buy-list" class="selected">
            <?php if($buy_list): ?>
                <table>
                    <tr>
                        <th style="width: 200px;"><?php _e('Item', 'rupayments') ?></th>
                        <th><?php _e('Seller', 'rupayments') ?></th>
                        <th><?php _e('Price', 'rupayments') ?></th>
                        <th><?php _e('Payment Status', 'rupayments') ?></th>
                        <th><?php _e('Deal Status', 'rupayments') ?></th>
                        <th><?php _e('Action', 'rupayments') ?></th>
                    </tr>
                    
                    <?php foreach($buy_list as $list): ?>
                    <tr>
                        <td><?php echo $list['s_title']; ?></td>
                        <td><?php echo $list['s_name']; ?></td>
                        <td><?php echo $list['s_item_price'] . $list['s_item_currency']; ?></td>
                        <td><?php echo $list['p_status']; ?></td>
                        <td><?php echo $list['d_status']; ?></td>
                        <td>
                            <?php if($list['i_deal_status'] == 3): ?>
                                <a id="accept" href="<?php echo osc_base_url(true) . '?page=custom&route=rupayments-user-ebuy-deals&do=change-status&deal-status=deal-accept&id=' . $list['fk_i_edeal_id']; ?>" title="<?php _e('Accept Deal', 'rupayments') ?>"><i class="fa fa-check fa-lg"></i></a>
                            <?php elseif(($list['i_deal_status'] == 0 || $list['i_deal_status'] == 4) && $list['i_payment_status'] != 3 && $list['i_payment_status'] != 4): ?>
                                <a id="withdraw" href="<?php echo osc_base_url(true) . '?page=custom&route=rupayments-user-ebuy-deals&do=change-status&deal-status=deal-withdraw-buyer&id=' . $list['fk_i_edeal_id']; ?>" title="<?php _e('Order Withdrawal', 'rupayments') ?>"><i class="fa fa-credit-card fa-lg"></i></a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <div class="flashmessage flashmessage-warning" style="display: block;"><?php _e('No data to display','rupayments') ?></div>
            <?php endif; ?>
        </li>
        
        <li data-content="sell-list">
            <?php if($sell_list): ?>
                <table>
                    <tr>
                        <th style="width: 200px;"><?php _e('Item', 'rupayments') ?></th>
                        <th><?php _e('Buyer', 'rupayments') ?></th>
                        <th><?php _e('Price', 'rupayments') ?></th>
                        <th><?php _e('Payment Status', 'rupayments') ?></th>
                        <th><?php _e('Deal Status', 'rupayments') ?></th>
                        <th><?php _e('Action', 'rupayments') ?></th>
                    </tr>
                    
                    <?php foreach($sell_list as $list): ?>
                    <tr>
                        <td><?php echo $list['s_title']; ?></td>
                        <td><?php echo $list['s_name']; ?></td>
                        <td><?php echo $list['s_item_price'] . $list['s_item_currency']; ?></td>
                        <td><?php echo $list['p_status']; ?></td>
                        <td><?php echo $list['d_status']; ?></td>
                        <td>
                            <?php if($list['i_deal_status'] == 2): ?>
                                <a id="shipment" href="<?php echo osc_base_url(true) . '?page=custom&route=rupayments-user-ebuy-deals&do=change-status&deal-status=deal-shipment&id=' . $list['fk_i_edeal_id']; ?>" title="<?php _e('Item shipped', 'rupayments') ?>"><i class="fa fa-truck fa-lg"></i></a> 
                                <a id="cancel" href="<?php echo osc_base_url(true) . '?page=custom&route=rupayments-user-ebuy-deals&do=change-status&deal-status=deal-cancel&id=' . $list['fk_i_edeal_id']; ?>" title="<?php _e('Cancel Deal', 'rupayments') ?>"><i class="fa fa-times fa-lg"></i></a>
                            <?php elseif(($list['i_deal_status'] == 1 || $list['i_deal_status'] == 5) && $list['i_payment_status'] != 3 && $list['i_payment_status'] != 4): ?>
                                <a id="withdraw" href="<?php echo osc_base_url(true) . '?page=custom&route=rupayments-user-ebuy-deals&do=change-status&deal-status=deal-withdraw-seller&id=' . $list['fk_i_edeal_id']; ?>" title="<?php _e('Order Withdrawal', 'rupayments') ?>"><i class="fa fa-credit-card fa-lg"></i></a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <div class="flashmessage flashmessage-warning" style="display: block;"><?php _e('No data to display','rupayments') ?></div>
            <?php endif; ?>
        </li>
    </ul>
</div>

<script type="text/javascript">
$('a#accept').click(function() {
    if(confirm('<?php _e("Are you sure you want to Accept the Deal? The money will be Credited to the Seller!","rupayments") ?>')) return true;
    
    return false;
});

$('a#shipment').click(function() {
    if(confirm('<?php _e("Are you sure you want to change the status of the Deal to \"Item Shipped\"? While the Buyer doesn\'t confirm receipt of the item, you can\'t change the status of the Deal!","rupayments") ?>')) return true;
    
    return false;
});

$('a#cancel').click(function() {
    if(confirm('<?php _e("Are you sure you want to Cancel the Deal? The money will be Returned to the Buyer!","rupayments") ?>')) return true;
    
    return false;
});
</script>