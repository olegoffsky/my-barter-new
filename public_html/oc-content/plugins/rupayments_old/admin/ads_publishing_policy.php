<?php defined('ABS_PATH') or die('Access denied');
    $mp = ModelRUpayments::newInstance();
    
    if(Params::getParam('plugin_action') == 'done') {
        
        $free_unlimited_status = Params::getParam("free_unlimited_status");
        $num_free_ads = Params::getParam("num_free_ads");
        if($num_free_ads == ''){
		$dis_free_ads = 0 ;
		}else{
		$dis_free_ads = $num_free_ads ;	
		}
        $mp->insertPolicy($dis_free_ads, $free_unlimited_status);
        
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
        osc_redirect_to(osc_route_admin_url('rupayments-ads', array('l' => 'publishing-policy')));
    }
    
    $categories = Category::newInstance()->toTreeAll();
    $policy     = ModelRUpayments::newInstance()->getCategoriesPolicy(); 
    $user_groups = $mp->getUserGroups();
    $cat_policy = array(); 
    
    foreach($policy as $p) {
        $cat_policy[$p['i_category_id']][$p['i_user_group_id']]['i_num_free_ads'] = $p['i_num_free_ads'];
        $cat_policy[$p['i_category_id']][$p['i_user_group_id']]['i_free_unlimited_status'] = $p['i_free_unlimited_status'];
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
    
    function categoriesList ( $categories, $depth = 0, $cat_policy, $group_id, $parent = 0 ) {
        
        foreach($categories as $c) { 
?>
            <?php if($depth == 1) $parent_id = $c['fk_i_parent_id']; ?>
            <tr <?php if($depth >= 1): ?>id="subcategories" class="hide" parent-id="<?php echo $parent_id ? $parent_id : $parent; ?>" group-id="<?php echo $group_id; ?>"<?php endif; ?>>
                <td>
                    <?php if(!$depth): ?><span id="publish-policy-switcher" category-id="<?php echo $c['pk_i_id']; ?>" group-id="<?php echo $group_id; ?>" status="hide"><i class="fa fa-plus-circle"></i></span><?php endif; ?> 
                    <?php if(!$depth) echo '<strong>' . $c['s_name'] . '</strong>'; else echo category_deviders($depth) . $c['s_name']; ?>
                </td>
                
                <td>
                    <input type="number" name="num_free_ads[<?php echo $c['pk_i_id']?>][<?php echo $group_id; ?>]" <?php if(!osc_get_preference('pay_per_post', 'rupayments') || (@$cat_policy[$c['fk_i_category_id']][$group_id]['i_free_unlimited_status'] == 1 && osc_get_preference('pay_per_post', 'rupayments'))) echo 'readonly'; ?> min="0" value="<?php echo $cat_policy[$c['fk_i_category_id']][$group_id]['i_num_free_ads']; ?>" />
                </td> 
                
                <td class="col-free-publishing">
                    <div data-toggle="mitcher">                                                                                            
                        <input type="checkbox" name="free_unlimited_status[<?php echo $c['pk_i_id']?>][<?php echo $group_id; ?>]" id="free-publishing-switcher" category-id="<?php echo $c['pk_i_id']?>" group-id="<?php echo $group_id; ?>" value="1" <?php if (!osc_get_preference('pay_per_post', 'rupayments')) echo "disabled"; elseif(@$cat_policy[$c['fk_i_category_id']][$group_id]['i_free_unlimited_status'] == 1 && osc_get_preference('pay_per_post', 'rupayments')) echo "checked";?> />
                    </div>
                </td>            
            </tr>
        <?php
            if(isset($c['categories']) && is_array($c['categories'])) {
                $parent_id = $parent_id ? $parent_id : $parent;
                categoriesList($c['categories'], $depth+1, $cat_policy, $group_id, $parent_id);
            }
        }
    };
?>

<?php require_once 'top_menu.php'; ?>
<div class="rupayments-manage-wrapper">
    <?php require_once 'left_menu.php'; ?>
    
    <div class="rupayments-manage-content rupayments-section">
        <form action="<?php echo osc_route_admin_url('rupayments-ads', array('l' => 'publishing-policy')); ?>" method="post">
            <input type="hidden" name="page" value="plugins" />
            <input type="hidden" name="action" value="renderplugin" />
            <input type="hidden" name="plugin_action" value="done" />

            <div class="cd-tabs">
                <nav>
                    <ul class="cd-tabs-navigation">
                        <li><a data-content="default" class="selected" href="javascript:void(0);"><?php _e('Default', 'rupayments'); ?></a></li>
                        <?php if($user_groups): ?>
                            <?php foreach($user_groups as $group): ?>
                                <li><a data-content="<?php echo $group['fk_i_group_id']; ?>" href="javascript:void(0);"><?php echo $group['f_group_title']; ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </nav>
                
                <ul class="cd-tabs-content">
                    <li data-content="default" class="selected">
                        <table id="publishing-policy" class="table-striped">
                            <tr>
                                <th style="width:400px;"><?php _e('Category Name', 'rupayments'); ?></th>
                                <th><?php _e('Quantity of free ads', 'rupayments'); ?></td>
                                <th style="width:100px;"><?php _e('Free Unlimited', 'rupayments'); ?> <?php if(!osc_get_preference('pay_per_post', 'rupayments')): ?><i id="info" data-tipso="<?php _e('Turn on the <strong>Publish fee</strong> to enable this feature', 'rupayments'); ?>" class="fa fa-exclamation-circle fa-alert"></i><?php endif; ?></th>  
                            </tr>
                            <?php categoriesList ( $categories, 0, $cat_policy, 0); ?>
                        </table>
                    </li>
                    
                    <?php if($user_groups): ?>
                        <?php foreach($user_groups as $group): ?>
                            <li data-content="<?php echo $group['fk_i_group_id']; ?>">
                                <table id="publishing-policy" class="table-striped">
                                    <tr>
                                        <th style="width:400px;"><?php _e('Category Name', 'rupayments'); ?></th>
                                        <th><?php _e('Quantity of free ads', 'rupayments'); ?></td>
                                        <th style="width:100px;"><?php _e('Free Unlimited', 'rupayments'); ?> <?php if(!osc_get_preference('pay_per_post', 'rupayments')): ?><i id="info" data-tipso="<?php _e('Turn on the <strong>Publish fee</strong> to enable this feature', 'rupayments'); ?>" class="fa fa-exclamation-circle fa-alert"></i><?php endif; ?></th>  
                                    </tr>
                                    <?php categoriesList ( $categories, 0, $cat_policy, $group['fk_i_group_id']); ?>
                                </table>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div class="form-actions">
                <input type="submit" id="save_changes" value="<?php echo osc_esc_html(__("Save changes", 'rupayments')); ?>" class="btn btn-submit">
            </div>
        </form>
        
        <div class="code-block">
		<p class="help-box"><?php _e('<strong>Important!!!</strong>', 'rupayments'); ?></p>
        <p class="help-box"><?php _e('If you have enabled option - "Item-post Form"', 'rupayments'); ?></p>
            <p class="help-box"><?php _e('For unregistered users Publish Policy work only "All adds without Publish fee" or "Choose number of ads without Publish fee" = 0', 'rupayments'); ?></p>
            <p class="help-box"><?php _e('If you set the value "Choose number of ads without Publish fee" = 1,2,3 etc. An unregistered user will not see in the item-post page that the publishing item must be paid', 'rupayments'); ?></p>
            <p class="help-box"><?php _e('But if he chooses premium or highlights: He will see that he must pay on the next page', 'rupayments'); ?></p>
            <p class="help-box"><?php _e('If he chooses No,thanks: He will only find out about this from a e-mail', 'rupayments'); ?></p>
            <p class="help-box"><?php _e('The best solution. All users must register on your site or you should use "After publish" option and do not use the "Item-post Form" option', 'rupayments'); ?></p>
        </div>
					            <div class="code-block">
                <p class="help-box"><?php _e('If you have too many categories and when saving data, not all data is saved - you need to increase <span class="htaccess-function">"max_input_vars"</span> in PHP settings. And maybe:', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<span class="htaccess-function">suhosin.get.max_vars</span>', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<span class="htaccess-function">suhosin.post.max_vars</span>', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<span class="htaccess-function">suhosin.request.max_vars</span>', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<strong>For Example:</strong> if you have 1000 categories you need setup - <span class="htaccess-function">max_input_vars 7000</span>', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('<strong>7 input_vars for each category.</strong>', 'rupayments'); ?></p>
            </div>	
    </div>
</div>