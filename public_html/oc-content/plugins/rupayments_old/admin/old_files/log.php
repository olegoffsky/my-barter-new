<?php 
    if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); 
    if ( !OC_ADMIN ) exit('User access is not allowed.'); 

    $itemsPerPage = 50;
    $page         = (Params::getParam('iPage') != '') ? Params::getParam('iPage') : 0;
    

/*
 * Copyright 2015 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
   $rupayments_log = ModelRUpayments::newInstance()->getLogs();
   $total_items  = count ( $rupayments_log );
   $total_pages  = ceil($total_items/$itemsPerPage);

//print $total_items." - <br>";
?>
    <a name="log"></a>
    <h2 class="render-title"><b><i class="fa fa-file-text"></i> <?php _e('Ultimate Payments log', 'rupayments'); ?><b></h2>
                
    <div class="dataTables_wrapper">
                    <? if ( osc_version() < '240' ) {?>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="datatables_list">
                   <? echo osc_version(); } else {?>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatables_list">
                    <? } ?>  
                        <thead>
                            <tr>
                                <th class="sorting"><?php _e('ID', 'rupayments'); ?></th>
                                <th ><?php _e('Description', 'rupayments'); ?></th>
                                <th class="sorting"><?php _e('Date', 'rupayments'); ?></th>
                                <th ><?php _e('Amount', 'rupayments'); ?></th>
                                <th ><?php _e('Email', 'rupayments'); ?></th>
                                <th ><?php _e('UserID', 'rupayments'); ?></th>
                                <th ><?php _e('ItemID', 'rupayments'); ?></th>
                                <th ><?php _e('Source', 'rupayments'); ?></th>
                                <!--<th ><?php _e('Product type', 'rupayments'); ?></th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $rupayments_log_per_page = ModelRUpayments::newInstance()->getPaginationLogs ( $itemsPerPage*$page, $itemsPerPage );
                                $odd = 1;
                                foreach ( $rupayments_log_per_page as $logs ) {
                                    if($odd==1) {
                                        $odd_even = "odd";
                                        $odd = 0;
                                    } else {
                                        $odd_even = "even";
                                        $odd = 1;
                                    } 
									
								if($logs['s_currency_code']=='BTC'){ 
									$amount2=number_format($logs['i_amount'],8);
								}else{
									$amount2=round($logs['i_amount'],2);
								}
		
                            ?> 
                            <tr class="<?php echo $odd_even;?>">
                            	<td><?php echo $logs['pk_i_id']; ?></td>
                                <td><?php echo $logs['s_concept']; ?></td>
                            	<td><?php echo osc_format_date($logs['dt_date']); ?></td>
                                <td><?php echo $amount2; echo $logs['s_currency_code']; ?></td>
                            	<td><?php echo $logs['s_email']; ?></td>
                            	<td><?php if ( $logs['fk_i_user_id'] == 0 ) print _e('Unregistered user', 'rupayments');
                                          else echo $logs['fk_i_user_id']; ?></td>
                            	<td><?php echo $logs['fk_i_item_id']; ?></td>
                                <td><?php echo $logs['s_source']; ?></td>
                            	<!--<td><?php if ($logs['i_product_type']=='201') echo _e('Premium Ads', 'rupayments');
					  else if ($logs['i_product_type']=='202') echo _e('Publish & Premium Ads', 'rupayments');
					  else if ($logs['i_product_type']=='101') echo _e('Publish','rupayments');
					  else if ($logs['i_product_type']=='301') echo _e('Highlighted', 'rupayments');
                                          else if ($logs['i_product_type']=='302') echo _e('Publish & Highlighted', 'rupayments');
					  else if ($logs['i_product_type']=='231') echo _e('Premium and Highlighted', 'rupayments');
					  else if ($logs['i_product_type']=='232') echo _e('Publish, Highlighted & Premium Ads', 'rupayments');
					  else if ($logs['i_product_type']=='401') echo _e('TOP','rupayments');
					  else if ($logs['i_product_type']=='411') echo _e('Renew','rupayments');
					  else if ($logs['i_product_type']=='501') echo _e('Pack 1','rupayments');
                                          else if ($logs['i_product_type']=='502') echo _e('Pack 2','rupayments');
                                          else if ($logs['i_product_type']=='503') echo _e('Pack 3','rupayments');
                                          else if ($logs['i_product_type']=='500') echo _e('Wallet','rupayments');
								 ?></td>-->
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    
    </div>
	 <div class="paginate">
   <?php for($i = 0 ; $i < $total_pages ; $i++) {
        if($i == $page) {
            printf('<a class="searchPaginationSelected" href="%s">%d</a>', '?'.$_SERVER['QUERY_STRING'].'&iPage='.$i.'#log', ($i + 1));
        } else {
            printf('<a class="searchPaginationNonSelected" href="%s">%d</a>', '?'.$_SERVER['QUERY_STRING'].'&iPage='.$i.'#log', ($i + 1));
        }
    } ?>
    </div>
		<address class="osclasspro_address">
	<span>&copy; <?php echo date('Y') ?> <a target="_blank" title="osclass-pro.com" href="https://osclass-pro.com/">osclass-pro.com</a>. All rights reserved.</span>
  </p>
  </address>
 <?php echo '<script src="' . osc_base_url() . 'oc-content/plugins/rupayments/admin/js/jquery.admin.js"></script>'; ?>