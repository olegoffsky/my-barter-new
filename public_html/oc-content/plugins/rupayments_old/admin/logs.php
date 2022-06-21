<?php defined('ABS_PATH') or die('Access denied'); 
    $itemsPerPage = 50;
    $page         = (Params::getParam('iPage') != '') ? Params::getParam('iPage') : 0;
    
    $rupayments_log = ModelRUpayments::newInstance()->getLogs();
    $total_items  = count ( $rupayments_log );
    $total_pages  = ceil($total_items/$itemsPerPage);
    
    $rupayments_log_per_page = ModelRUpayments::newInstance()->getPaginationLogs($itemsPerPage*$page,$itemsPerPage);
?>

<?php require_once 'top_menu.php'; ?>
<div class="rupayments-manage-wrapper">
    <div class="usl-manage-content usl-section">
        <div style="margin:15px;">
            <?php if($rupayments_log_per_page): ?>
                <table class="table-striped">
                    <tr>
                        <th class="sorting"><?php _e('ID', 'rupayments'); ?></th>
                        <th ><?php _e('Description', 'rupayments'); ?></th>
                        <th class="sorting"><?php _e('Date', 'rupayments'); ?></th>
                        <th ><?php _e('Amount', 'rupayments'); ?></th>
                        <th ><?php _e('Email', 'rupayments'); ?></th>
                        <th ><?php _e('UserID', 'rupayments'); ?></th>
                        <th ><?php _e('ItemID', 'rupayments'); ?></th>
                        <th ><?php _e('Source', 'rupayments'); ?></th>
                    </tr>
                    <?php foreach ( $rupayments_log_per_page as $logs ) : ?>
                    <tr>
                        <td><?php echo $logs['pk_i_id']; ?></td>
                        <td><?php echo $logs['s_concept']; ?></td>
                    	<td><?php echo osc_format_date($logs['dt_date']); ?></td>
                        <td><?php if($logs['s_currency_code']=='BTC') $amount2=number_format($logs['i_amount'],8);	
							        else $amount2=round($logs['i_amount'],2);
							echo $amount2; echo $logs['s_currency_code']; ?></td>
                    	<td><?php echo $logs['s_email']; ?></td>
                    	<td><?php if ( $logs['fk_i_user_id'] == 0 ) print _e('Unregistered user', 'rupayments');
                                  else echo $logs['fk_i_user_id']; ?></td>
                    	<td><?php echo $logs['fk_i_item_id']; ?></td>
                        <td><?php echo $logs['s_source']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <div class="paginate">
                    <?php if($total_pages > 1): ?>
                    <?php 
                        for($i = 0 ; $i < $total_pages ; $i++) {
                            if($i == $page) {
                                printf('<a class="searchPaginationSelected" href="%s">%d</a>', '?'.$_SERVER['QUERY_STRING'].'&iPage='.$i, ($i + 1));
                            } else {
                                printf('<a class="searchPaginationNonSelected" href="%s">%d</a>', '?'.$_SERVER['QUERY_STRING'].'&iPage='.$i, ($i + 1));
                            }
                        } 
                    ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="flashmessage" style="display: block;"><?php _e('No data to display','rupayments') ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>