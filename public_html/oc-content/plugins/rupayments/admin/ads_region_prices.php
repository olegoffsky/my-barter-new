<?php defined('ABS_PATH') or die('Access denied');
    $countries = ModelRUpayments::newInstance()->getRegions();
    
    if(Params::getParam('plugin_action') == 'done') {
        $pub_prices = Params::getParam("region_publish_cost");
		$ren_prices = Params::getParam("region_renew_cost");
        $image_prices = Params::getParam("region_image_cost");
        $premium_prices  = Params::getParam("region_premium_cost");
		$top_prices = Params::getParam("region_top_cost");
        $color_prices = Params::getParam("region_color_cost");
        $pack_prices  = Params::getParam("region_pack_cost");
        
        $result = ModelRUpayments::newInstance()->setRegionPrices($pub_prices, $ren_prices, $image_prices, $premium_prices, $top_prices, $color_prices, $pack_prices);

        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
        osc_redirect_to(osc_route_admin_url('rupayments-ads', array('l' => 'region-prices')));
    }
    
?>

<?php require_once 'top_menu.php'; ?>
<div class="rupayments-manage-wrapper">
    <?php require_once 'left_menu.php'; ?>
    <div class="rupayments-manage-content rupayments-section">
        <div style="margin:15px;">
            <?php if($countries): ?>
            <form action="<?php echo osc_route_admin_url('rupayments-ads', array('l' => 'region-prices')); ?>" method="post">
                <input type="hidden" name="page" value="plugins" />
                <input type="hidden" name="action" value="renderplugin" />
                <input type="hidden" name="plugin_action" value="done" />
                
                <table  id="region-prices" class="table-striped">
                    <tr>
                        <th style="width:200px;"><?php _e('Region Name', 'rupayments'); ?></th>
                        <th><?php echo sprintf(__('Publish (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
						<th><?php echo sprintf(__('Renew (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th><?php echo sprintf(__('Image (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th><?php echo sprintf(__('Premium (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th><?php echo sprintf(__('Move to top (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th><?php echo sprintf(__('Highlighting (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th><?php echo sprintf(__('Pack 3-in-1 (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>  
                    </tr>
                    
                    <?php foreach($countries as $country): ?>
                    <tr>
                        <td>
                            <?php if(isset($country['regions'])): ?><span id="country-switcher" country-id="<?php echo strtolower($country['pk_c_code']); ?>" status="hide"><i class="fa fa-plus-circle"></i></span><?php endif; ?> 
                            <?php echo '<strong>' . $country['s_name'] . '</strong>'; ?>
                        </td>
                        <td>
                            -
                            <!--
                            <input type="text" name="region_publish_cost[country][<?php echo strtolower($country['pk_c_code']); ?>]" value="<?php echo $country['prices']['f_publish_cost']; ?>" />
                            -->
                        </td>
                        <td>
                            -
                            <!--
                            <input type="text" name="region_renew_cost[country][<?php echo strtolower($country['pk_c_code']); ?>]" value="<?php echo $country['prices']['f_renew_cost']; ?>" />
                            -->
                        </td>
                        <td>
                            -
                            <!--
                            <input type="text" name="region_image_cost[country][<?php echo strtolower($country['pk_c_code']); ?>]" value="<?php echo $country['prices']['f_picture_cost']; ?>" />
                            -->
                        </td>
                        <td>
                            -
                            <!--
                            <input type="text" name="region_premium_cost[country][<?php echo strtolower($country['pk_c_code']); ?>]" value="<?php echo $country['prices']['f_premium_cost']; ?>" />
                            -->
                        </td>
                        <td>
                            -
                            <!--
                            <input type="text" name="region_top_cost[country][<?php echo strtolower($country['pk_c_code']); ?>]" value="<?php echo $country['prices']['f_top_cost']; ?>" />
                            -->
                        </td>
                        <td>
                            -
                            <!--
                            <input type="text" name="region_color_cost[country][<?php echo strtolower($country['pk_c_code']); ?>]" value="<?php echo $country['prices']['f_color_cost']; ?>" />
                            -->
                        </td>
                        <td>
                            -
                            <!--
                            <input type="text" name="region_pack_cost[country][<?php echo strtolower($country['pk_c_code']); ?>]" value="<?php echo $country['prices']['f_pack_cost']; ?>" />
                            -->
                        </td>
                    </tr>
                        <?php if(isset($country['regions'])): ?>
                            <?php foreach($country['regions'] as $region): ?>
                                <tr region-country-id="<?php echo $region['fk_c_country_code']; ?>" class="hide">
                                    <td>
                                        <?php if(isset($region['cities'])): ?><span id="region-switcher" region-id="<?php echo $region['pk_i_id']; ?>" status="hide"><i class="fa fa-plus-circle"></i></span><?php endif; ?> 
                                        <?php echo '<ins>' . $region['s_name'] . '</ins>'; ?>
                                    </td>
                                    <td>
                                        -
                                        <!--
                                        <input type="text" name="region_publish_cost[region][<?php echo $region['pk_i_id']; ?>]" value="<?php echo $region['prices']['f_publish_cost']; ?>" />
                                        -->
                                    </td>
                                    <td>
                                        -
                                        <!--
                                        <input type="text" name="region_renew_cost[region][<?php echo $region['pk_i_id']; ?>]" value="<?php echo $region['prices']['f_renew_cost']; ?>" />
                                        -->
                                    </td>
                                    <td>
                                        -
                                        <!--
                                        <input type="text" name="region_image_cost[region][<?php echo $region['pk_i_id']; ?>]" value="<?php echo $region['prices']['f_picture_cost']; ?>" />
                                        -->
                                    </td>
                                    <td>
                                        -
                                        <!--
                                        <input type="text" name="region_premium_cost[region][<?php echo $region['pk_i_id']; ?>]" value="<?php echo $region['prices']['f_premium_cost']; ?>" />
                                        -->
                                    </td>
                                    <td>
                                        -
                                        <!--
                                        <input type="text" name="region_top_cost[region][<?php echo $region['pk_i_id']; ?>]" value="<?php echo $region['prices']['f_top_cost']; ?>" />
                                        -->
                                    </td>
                                    <td>
                                        -
                                        <!--
                                        <input type="text" name="region_color_cost[region][<?php echo $region['pk_i_id']; ?>]" value="<?php echo $region['prices']['f_color_cost']; ?>" />
                                        -->
                                    </td>
                                    <td>
                                        -
                                        <!--
                                        <input type="text" name="region_pack_cost[region][<?php echo $region['pk_i_id']; ?>]" value="<?php echo $region['prices']['f_pack_cost']; ?>" />
                                        -->
                                    </td>
                                </tr>
                                
                                <?php if(isset($region['cities'])): ?>
                                    <?php foreach($region['cities'] as $city): ?>
                                        <tr city-region-id="<?php echo $city['fk_i_region_id']; ?>" city-country-id="<?php echo $city['fk_c_country_code']; ?>" class="hide">
                                            <td><?php echo '<em>' . $city['s_name'] . '</em>'; ?></td>
                                            <td>
                                                <input type="text" name="region_publish_cost[city][<?php echo $city['pk_i_id']; ?>]" value="<?php echo $city['prices']['f_publish_cost']; ?>" />
                                            </td>
                                            <td>
                                                <input type="text" name="region_renew_cost[city][<?php echo $city['pk_i_id']; ?>]" value="<?php echo $city['prices']['f_renew_cost']; ?>" />
                                            </td>
                                            <td>
                                                <input type="text" name="region_image_cost[city][<?php echo $city['pk_i_id']; ?>]" value="<?php echo $city['prices']['f_picture_cost']; ?>" />
                                            </td>
                                            <td>
                                                <input type="text" name="region_premium_cost[city][<?php echo $city['pk_i_id']; ?>]" value="<?php echo $city['prices']['f_premium_cost']; ?>" />
                                            </td>
                                            <td>
                                                <input type="text" name="region_top_cost[city][<?php echo $city['pk_i_id']; ?>]" value="<?php echo $city['prices']['f_top_cost']; ?>" />
                                            </td>
                                            <td>
                                                <input type="text" name="region_color_cost[city][<?php echo $city['pk_i_id']; ?>]" value="<?php echo $city['prices']['f_color_cost']; ?>" />
                                            </td>
                                            <td>
                                                <input type="text" name="region_pack_cost[city][<?php echo $city['pk_i_id']; ?>]" value="<?php echo $city['prices']['f_pack_cost']; ?>" />
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
                
                <div class="form-actions">
                    <input type="submit" id="save_changes" value="<?php echo osc_esc_html(__("Save changes", 'rupayments')); ?>" class="btn btn-submit">
                </div>
            </form>
            <?php else: ?>
            <div class="flashmessage" style="display: block;"><?php _e('No data to display','rupayments') ?></div>
            <?php endif; ?>
			            <div class="code-block">
				<p class="help-box"><?php _e('If you have many cities. To configure this option, you may need a lot of server resources. Be careful.', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('If you have too many cities and when saving data, not all data is saved - you need to increase <span class="htaccess-function">"max_input_vars"</span> in PHP settings. And maybe:', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<span class="htaccess-function">suhosin.get.max_vars</span>', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<span class="htaccess-function">suhosin.post.max_vars</span>', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<span class="htaccess-function">suhosin.request.max_vars</span>', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('<strong>For Example:</strong> if you have 1000 cities you need setup - <span class="htaccess-function">max_input_vars 7000</span>', 'rupayments'); ?></p>
				<p class="help-box"><?php _e('<strong>7 input_vars for each city.</strong>', 'rupayments'); ?></p>
            </div>
        </div>
    </div>
</div>