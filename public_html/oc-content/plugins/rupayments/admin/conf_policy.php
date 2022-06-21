<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>
<?php
/*
 * Copyright 2017 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
    $mp = ModelRUpayments::newInstance();

    if(Params::getParam('plugin_action') == 'done') {
        
        $add_type = Params::getParam("add_type");
	$num_wof_adds = Params::getParam("num_wof_adds");
        
        foreach ( $add_type as $k => $v ) {
            $mp->insertPolicy ( $k,  $v==''?NULL:$v, (!isset($num_wof_adds[$k]) || $num_wof_adds[$k]=='')?0:$num_wof_adds[$k] );  			
        }
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
	osc_redirect_to( osc_admin_base_url(true) . '?page=plugins&action=renderplugin&route=rupayments-admin-conf#policy');
    }

    $categories = Category::newInstance()->toTreeAll();
    //$prices getCategoriesPrices();
    $policy     = ModelRUpayments::newInstance()->getCategoriesPolicy(); 
    $cat_policy = array(); 
    
    foreach($policy as $p) {
        $cat_policy[$p['fk_i_category_id']]['i_add_type'] = $p['i_add_type'];
        $cat_policy[$p['fk_i_category_id']]['i_num_wof_adds'] = $p['i_num_wof_adds'];
    }                          

    function categoriesList ( $categories, $depth = 0, $cat_policy ) {
        
        foreach($categories as $c) { 
            
            //$bIsPublishingAllAddsForFree  = ModelRUpayments::newInstance()->isPublishingAllAddsForFree ( $c['pk_i_id'] );
?>
            <tr>
                <td>
                    <?php for ( $d=0; $d<$depth; $d++ ) { echo "&nbsp;&nbsp;"; }; echo $c['s_name']; ?>
                </td>
                <td style="width:20px;">                                                                                                                     
                    <input type="radio" name="add_type[<?php echo $c['pk_i_id']?>]" id="add_type[<?php echo $c['pk_i_id']?>]" value="1" <?php if ( ( @$cat_policy[$c['fk_i_category_id']]['i_add_type'] == 1 && osc_get_preference('pay_per_post', 'rupayments') ) || !osc_get_preference('pay_per_post', 'rupayments') ) print "checked";?> /> <!-- value="" <?php if ( @$cat_policy[$c['fk_i_category_id']]['i_add_type'] != 2 ) print "checked";?> -->
                </td>
                <td style="width:280px;"><?php _e('All ads without Publish fee', 'rupayments'); ?></td>
<?php
            if ( ModelRUpayments::newInstance()->isPublishingAllAddsForFree ( $c['pk_i_id'] ) ) {
?>
                <td></td>
                <td></td>
		<td></td>
<?php
            }
            else {
?>
                <td style="width:20px;">
                    <input type="radio" name="add_type[<?php echo $c['pk_i_id']?>]" id="add_type[<?php echo $c['pk_i_id']?>]" value="2" <?php if ( @$cat_policy[$c['fk_i_category_id']]['i_add_type'] == 2 || @$cat_policy[$c['fk_i_category_id']]['i_add_type'] === NULL ) print "checked";?> /> <!-- <?php if ( @$cat_policy[$c['fk_i_category_id']]['i_add_type'] == 2 ) print "checked";?> -->
                </td>
                <td style="width:280px;"><?php _e('Choose number of ads without Publish fee', 'rupayments'); ?></td>
		<td style="width:50px;">
                    <input style="width:50px;text-align:right;" type="text" name="num_wof_adds[<?php echo $c['pk_i_id']?>]" id="num_wof_adds[<?php echo $c['pk_i_id']?>]" value="<?php print @$cat_policy[$c['fk_i_category_id']]['i_num_wof_adds'];?>" />
                </td>                 
<?php
            }
?>                
            </tr>
        <?php categoriesList($c['categories'], $depth+1, $cat_policy);
        }
    };


?>
    <div class="category">
	    <h2 class="render-title"><b><i class="fa fa-money"></i> <?php _e('Publishing policy', 'rupayments'); ?><b></h2>
        <div class="cat-prices" style="float: left; width: 100%;">
          <!--  <div style="float: left; width: 100%;">  -->
                <form name="rupayments_form" id="rupayments_form" action="<?php echo osc_admin_base_url(true);?>" method="POST" enctype="multipart/form-data" >
                    <fieldset>
                        <input type="hidden" name="page" value="plugins" />
                        <input type="hidden" name="action" value="renderplugin" />
                        <input type="hidden" name="route" value="rupayments-admin-policy" />
                        <input type="hidden" name="plugin_action" value="done" />
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="width:300px;"><?php _e('Category Name', 'rupayments'); ?></td>
                                <td align="center" colspan="5"><?php _e('Policy', 'rupayments'); ?></td>
                            </tr>
                            <?php categoriesList ( $categories, 0, $cat_policy); ?>
                        </table>
                        <button type="submit" style="float: right;" class="btn btn-submit"><?php _e('Update', 'rupayments'); ?></button>
                 </fieldset> 
             </form> 
		<p>
                <?php _e('Important!If you have enabled option - "Item-post Form"', 'rupayments'); ?>.
                <br/>
                <?php _e('For unregistered users Publish Policy work only "All adds without Publish fee" or "Choose number of ads without Publish fee" = 0', 'rupayments'); ?>.
				<br/>
                <?php _e('If you set the value "Choose number of ads without Publish fee" = 1,2,3 etc. An unregistered user will not see in the item-post page that the publishing item must be paid', 'rupayments'); ?>.
                <br/>
				<?php _e('But if he chooses premium or highlights: He will see that he must pay on the next page', 'rupayments'); ?>.
                <br/>
				<?php _e('If he chooses No,thanks: He will only find out about this from a e-mail', 'rupayments'); ?>.
                <br/>
				<?php _e('The best solution. All users must register on your site or you should use "After publish" option and do not use the "Item-post Form" option', 'rupayments'); ?>.
                <br/>
            </p>
			            <div class="code-block">
                <p class="help-box"><?php _e('If you have too many categories and when saving data, not all data is saved - you need to increase <span class="htaccess-function">"max_input_vars"</span> in PHP settings. And maybe:', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<span class="htaccess-function">suhosin.get.max_vars</span>', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<span class="htaccess-function">suhosin.post.max_vars</span>', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<span class="htaccess-function">suhosin.request.max_vars</span>', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<strong>For Example:</strong> if you have 1000 categories you need setup - <span class="htaccess-function">max_input_vars 6000</span>', 'rupayments'); ?></p>
            </div>			
        </div>
		<address class="osclasspro_address">
	<span>&copy; <?php echo date('Y') ?> <a target="_blank" title="osclass-pro.com" href="https://osclass-pro.com/">osclass-pro.com</a>. All rights reserved.</span>
  </address> </div>
 <?php echo '<script src="' . osc_base_url() . 'oc-content/plugins/rupayments/admin/js/jquery.admin.js"></script>'; ?>