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
        
        $pub_prices = Params::getParam("pub_prices");
		$ren_prices = Params::getParam("ren_prices");
		$top_prices = Params::getParam("top_prices");
        $color_prices = Params::getParam("color_prices");
        $pr_prices  = Params::getParam("pr_prices");
        $pr_color_discount = Params::getParam("pr_color_discount");
        
        foreach ( $pr_prices as $k => $v ) {
            $mp->insertPrice ( $k,  $v==''?NULL:$v, $ren_prices[$k]==''?NULL:$ren_prices[$k], $top_prices[$k]==''?NULL:$top_prices[$k], $color_prices[$k]==''?NULL:$color_prices[$k], $pub_prices[$k]==''?NULL:$pub_prices[$k], $pr_color_discount[$k]==''?NULL:$pr_color_discount[$k] );  
        }
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
	osc_redirect_to( osc_admin_base_url(true) . '?page=plugins&action=renderplugin&route=rupayments-admin-conf#category');
    }

    $categories = Category::newInstance()->toTreeAll();
    $prices     = ModelRUpayments::newInstance()->getCategoriesPrices();
    $cat_prices = array();
    
    foreach($prices as $p) {
        $cat_prices[$p['fk_i_category_id']]['f_publish_cost'] = $p['f_publish_cost'];
		$cat_prices[$p['fk_i_category_id']]['f_renew_cost'] = $p['f_renew_cost'];
        $cat_prices[$p['fk_i_category_id']]['f_premium_cost'] = $p['f_premium_cost'];
	$cat_prices[$p['fk_i_category_id']]['f_top_cost'] = $p['f_top_cost'];
	$cat_prices[$p['fk_i_category_id']]['f_color_cost'] = $p['f_color_cost'];
        $cat_prices[$p['fk_i_category_id']]['f_premium_color_discount'] = $p['f_premium_color_discount'];
    }                          

    function drawCategories($categories, $depth = 0, $cat_prices) {
        
        foreach($categories as $c) { ?>
            <tr>
                <td>
                    <?php for($d=0;$d<$depth;$d++) { echo "&nbsp;&nbsp;"; }; echo $c['s_name']; ?>
                </td>
                <td>
                    <input style="width:150px;text-align:right;" type="text" name="pub_prices[<?php echo $c['pk_i_id']?>]" id="pub_prices[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_publish_cost'] : ''; ?>" />
                </td>
				 <td>
                    <input style="width:150px;text-align:right;" type="text" name="ren_prices[<?php echo $c['pk_i_id']?>]" id="ren_prices[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_renew_cost'] : ''; ?>" />
                </td>
                <td>
                    <input style="width:150px;text-align:right;" type="text" name="pr_prices[<?php echo $c['pk_i_id']?>]" id="pr_prices[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_premium_cost'] : ''; ?>" />
                </td>
				<td>
                    <input style="width:150px;text-align:right;" type="text" name="top_prices[<?php echo $c['pk_i_id']?>]" id="top_prices[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_top_cost'] : ''; ?>" />
                </td>
                <td>
                    <input style="width:150px;text-align:right;" type="text" name="color_prices[<?php echo $c['pk_i_id']?>]" id="color_prices[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_color_cost'] : ''; ?>" />
                </td> 
                <td>
                    <input style="width:150px;text-align:right;" type="text" name="pr_color_discount[<?php echo $c['pk_i_id']?>]" id="pr_color_discount[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_premium_color_discount'] : ''; ?>" />
                </td> 
            </tr>
        <?php drawCategories($c['categories'], $depth+1, $cat_prices);
        }
    };


?>
    <div id="category">
	    <h2 class="render-title"><b><i class="fa fa-money"></i> <?php _e('Category prices', 'rupayments'); ?><b></h2>
        <div class="cat-prices">
          <!--  <div style="float: left; width: 100%;">  -->
                <form name="rupayments_form" id="rupayments_form" action="<?php echo osc_admin_base_url(true);?>" method="POST" enctype="multipart/form-data" >
                    <fieldset>
                        <input type="hidden" name="page" value="plugins" />
                        <input type="hidden" name="action" value="renderplugin" />
                        <input type="hidden" name="route" value="rupayments-admin-prices" />
                        <input type="hidden" name="plugin_action" value="done" />
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="width:300px;"><?php _e('Category Name', 'rupayments'); ?></td>
                                <td style="width:150px;"><?php echo sprintf(__('Publish (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></td>
								<td style="width:150px;"><?php echo sprintf(__('Renew (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></td>
                                <td style="width:150px;"><?php echo sprintf(__('Premium (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></td>
				<td style="width:150px;"><?php echo sprintf(__('Move to top(%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></td>
                                <td style="width:150px;"><?php echo sprintf(__('Highlighting (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></td>
                                <td style="width:150px;"><?php echo sprintf(__('Discount for Premium with Highlighting (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></td>  
                            </tr>
                            <?php drawCategories($categories, 0, $cat_prices); ?>
                        </table>
                        <button type="submit" style="float: right;" class="btn btn-submit"><?php _e('Update', 'rupayments'); ?></button>
                 </fieldset> 
             </form> 
<p class="help-box"><?php _e('If you have too many categories and when saving data, not all data is saved - you need to increase "max_input_vars" in PHP settings. And maybe:', 'rupayments'); ?></p>
<p class="help-box"><?php _e('suhosin.get.max_vars', 'rupayments'); ?></p>
<p class="help-box"><?php _e('suhosin.post.max_vars', 'rupayments'); ?></p>
<p class="help-box"><?php _e('suhosin.request.max_vars', 'rupayments'); ?></p>
<p class="help-box"><?php _e('too(if you have such directives)', 'rupayments'); ?></p>
<p class="help-box"><?php _e('For Example: if you have 1000 categories you need setup - max_input_vars 6000', 'rupayments'); ?></p>			 
        </div>
		<address class="osclasspro_address">
	<span>&copy; <?php echo date('Y') ?> <a target="_blank" title="osclass-pro.com" href="https://osclass-pro.com/">osclass-pro.com</a>. All rights reserved.</span>
  </address> </div>
 <?php echo '<script src="' . osc_base_url() . 'oc-content/plugins/rupayments/admin/js/jquery.admin.js"></script>'; ?>