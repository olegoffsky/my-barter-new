<?php defined('ABS_PATH') or die('Access denied');
    $mp = ModelRUpayments::newInstance();
    
    if(Params::getParam('plugin_action') == 'done') {
        $pub_prices = Params::getParam("pub_prices");
		$ren_prices = Params::getParam("ren_prices");
        $img_prices = Params::getParam("img_prices");
		$top_prices = Params::getParam("top_prices");
        $color_prices = Params::getParam("color_prices");
        $pr_prices  = Params::getParam("pr_prices");
        $pack_prices = Params::getParam("pack_prices");
        
        foreach ( $pr_prices as $k => $v ) {
            $mp->insertPrice ( $k,  $v==''?NULL:$v, $ren_prices[$k]==''?NULL:$ren_prices[$k], $img_prices[$k]==''?NULL:$img_prices[$k], $top_prices[$k]==''?NULL:$top_prices[$k], $color_prices[$k]==''?NULL:$color_prices[$k], $pub_prices[$k]==''?NULL:$pub_prices[$k], $pack_prices[$k]==''?NULL:$pack_prices[$k] );  
        }
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
        osc_redirect_to(osc_route_admin_url('rupayments-ads', array('l' => 'category-prices')));
    }
    
    $categories = Category::newInstance()->toTreeAll();
    $prices     = ModelRUpayments::newInstance()->getCategoriesPrices();
    $cat_prices = array();
    
    foreach($prices as $p) {
        $cat_prices[$p['fk_i_category_id']]['f_publish_cost'] = $p['f_publish_cost'];
		$cat_prices[$p['fk_i_category_id']]['f_renew_cost'] = $p['f_renew_cost'];
        $cat_prices[$p['fk_i_category_id']]['f_picture_cost'] = $p['f_picture_cost'];
        $cat_prices[$p['fk_i_category_id']]['f_premium_cost'] = $p['f_premium_cost'];
        $cat_prices[$p['fk_i_category_id']]['f_top_cost'] = $p['f_top_cost'];
        $cat_prices[$p['fk_i_category_id']]['f_color_cost'] = $p['f_color_cost'];
        $cat_prices[$p['fk_i_category_id']]['f_pack_cost'] = $p['f_pack_cost'];
    }

    function category_deviders($depth) {
    $devider = ''; $spaces = '';

    for($i = 1; $i <= $depth; $i++) {
        $spaces .= '&nbsp;';
    }

    for($i = 1; $i <= $depth; $i++) {
        $devider .= '<i class="fa fa-angle-right">';
    }

    return $spaces . $devider . '&nbsp;';
}

    function drawCategories($categories, $depth = 0, $cat_prices, $parent = 0) {

        foreach($categories as $c) { ?>
            <?php if($depth == 1) $parent_id = $c['fk_i_parent_id']; ?>

            <tr <?php if($depth >= 1): ?>id="subcategories" class="hide" parent-id="<?php echo $parent_id ? $parent_id : $parent; ?>"<?php endif; ?> >
                <td>
                    <?php if(!$depth): ?><span id="cat-prices-switcher" category-id="<?php echo $c['pk_i_id']; ?>" status="hide"><i class="fa fa-plus-circle"></i></span><?php endif; ?> 
                    <?php if(!$depth) echo '<strong>' . $c['s_name'] . '</strong>'; else echo category_deviders($depth) . $c['s_name']; ?>
                </td>
                <td>
                    <input type="text" name="pub_prices[<?php echo $c['pk_i_id']?>]" id="pub_prices[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_publish_cost'] : ''; ?>" />
                </td>
				 <td>
                    <input type="text" name="ren_prices[<?php echo $c['pk_i_id']?>]" id="ren_prices[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_renew_cost'] : ''; ?>" />
                </td>
                <td>
                    <input type="text" name="img_prices[<?php echo $c['pk_i_id']?>]" id="img_prices[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_picture_cost'] : ''; ?>" />
                </td>
                <td>
                    <input type="text" name="pr_prices[<?php echo $c['pk_i_id']?>]" id="pr_prices[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_premium_cost'] : ''; ?>" />
                </td>
				<td>
                    <input type="text" name="top_prices[<?php echo $c['pk_i_id']?>]" id="top_prices[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_top_cost'] : ''; ?>" />
                </td>
                <td>
                    <input type="text" name="color_prices[<?php echo $c['pk_i_id']?>]" id="color_prices[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_color_cost'] : ''; ?>" />
                </td> 
                <td>
                    <input type="text" name="pack_prices[<?php echo $c['pk_i_id']?>]" id="pack_prices[<?php echo $c['pk_i_id']?>]" value="<?php echo isset($cat_prices[$c['pk_i_id']]) ? $cat_prices[$c['pk_i_id']]['f_pack_cost'] : ''; ?>" />
                </td> 
            </tr>

        <?php
            if(isset($c['categories']) && is_array($c['categories'])) {
                $parent_id = $parent_id ? $parent_id : $parent;

                drawCategories($c['categories'], $depth+1, $cat_prices, $parent_id);
            }
        }
    };
?>

<?php require_once 'top_menu.php'; ?>
<div class="rupayments-manage-wrapper">
    <?php require_once 'left_menu.php'; ?>
    <div class="rupayments-manage-content rupayments-section">
        <div style="margin:15px;">
            <form action="<?php echo osc_route_admin_url('rupayments-ads', array('l' => 'category-prices')); ?>" method="post">
                <input type="hidden" name="page" value="plugins" />
                <input type="hidden" name="action" value="renderplugin" />
                <input type="hidden" name="plugin_action" value="done" />
                
                <table id="category-prices" class="table-striped">
                    <tr>
                        <th style="width:200px;"><?php _e('Category Name', 'rupayments'); ?></th>
                        <th><?php echo sprintf(__('Publish (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
						<th><?php echo sprintf(__('Renew (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th><?php echo sprintf(__('Image (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th><?php echo sprintf(__('Premium (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th><?php echo sprintf(__('Move to top (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th><?php echo sprintf(__('Highlighting (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th><?php echo sprintf(__('Pack 3-in-1 (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th> 
                    </tr>
                    <?php drawCategories($categories, 0, $cat_prices); ?>
                </table>
                
                <div class="form-actions">
                    <input type="submit" id="save_changes" value="<?php echo osc_esc_html(__("Save changes", 'rupayments')); ?>" class="btn btn-submit">
                </div>
            </form>
            
            <div class="code-block">
                <p class="help-box"><?php _e('If you have too many categories and when saving data, not all data is saved - you need to increase <span class="htaccess-function">"max_input_vars"</span> in PHP settings. And maybe:', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<span class="htaccess-function">suhosin.get.max_vars</span>', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<span class="htaccess-function">suhosin.post.max_vars</span>', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<span class="htaccess-function">suhosin.request.max_vars</span>', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<strong>For Example:</strong> if you have 1000 categories, you need set - <span class="htaccess-function">max_input_vars 7000</span>', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('<strong>7 input_vars for each category.</strong>', 'rupayments'); ?></p>
            </div>
        </div>
    </div>
</div>