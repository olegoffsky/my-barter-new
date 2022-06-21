<?php defined('ABS_PATH') or die('Access denied'); 
    $i = 1;
    $groups = ModelRUpayments::newInstance()->getUserGroups();
    
    if(Params::getParam('plugin_action') == 'done') {
        $set_groups = ModelRUpayments::newInstance()->setUserGroups();
        
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
        osc_redirect_to(osc_route_admin_url('rupayments-users', array('l' => 'groups')));
    }
    
    if(Params::getParam('do') == 'group-delete') {
        $id = Params::getParam('id');
        
        $result = ModelRUpayments::newInstance()->deleteUserGroup($id);
        
        ob_get_clean();
        
        if($result)
            osc_add_flash_ok_message(__('Congratulations, the group deleted successfully', 'rupayments'), 'admin');
        else
            osc_add_flash_error_message(__('The group could not be deleted', 'rupayments'), 'admin');
            
        osc_redirect_to(osc_route_admin_url('rupayments-users', array('l' => 'groups')));
    }
?>

<?php require_once 'top_menu.php'; ?>
<div class="rupayments-manage-wrapper">
    <?php require_once 'left_menu.php'; ?>
    <div class="rupayments-manage-content rupayments-section">
        <div style="margin:15px;">
            <form action="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&route=rupayments-users&l=groups'; ?>" method="post">
                <input type="hidden" name="page" value="plugins" />
                <input type="hidden" name="action" value="renderplugin" />
                <input type="hidden" name="plugin_action" value="done" />
                
                <table id="table-user-groups" class="table-striped">
                    <tr>
                        <th><?php _e('ID', 'rupayments'); ?></th>
                        <th><?php _e('Group Name', 'rupayments'); ?></th>
						<th style="width: 220px;"><?php _e('Group Description', 'rupayments'); ?></th>
                        <th><?php _e('Color', 'rupayments'); ?></th>
                        <th style="width: 45px;"><?php echo sprintf(__('Fee (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th style="width: 45px;"><?php _e('Discount (%)', 'rupayments'); ?></th>
                        <th style="width: 45px;"><?php _e('Period', 'rupayments'); ?></th>
                        <th style="width: 30px;"><?php _e('Delete', 'rupayments');; ?></th>  
                    </tr>
                    <?php if($groups): ?>
                        <?php foreach($groups as $group): ?>
                            <tr>
                                <input type="hidden" name="group_id[]" value="<?php echo $group['fk_i_group_id'] ?>" />
                                <td id="id"><?php echo $i; ?></td>
                                <td><input type="text" name="group_name[]" placeholder="<?php _e('Group Name', 'rupayments') ?>" value="<?php echo $group['f_group_title'] ?>" /></td>
                                <td><input style="width: 220px;" type="text" name="group_desc[]" placeholder="<?php _e('Group Description', 'rupayments') ?>" value="<?php echo $group['f_group_description'] ?>" /></td>
                                <td><input type="color" name="group_color[]" value="<?php echo $group['f_group_color'] ?>" /></td>
                                <td><input type="number" name="group_fee[]" placeholder="<?php _e('Fee', 'rupayments') ?>" min="1" value="<?php echo $group['f_group_price'] ?>" /></td>
                                <td><input type="number" name="group_discount[]" placeholder="<?php _e('Discount', 'rupayments') ?>" min="0" value="<?php echo $group['f_group_discount'] ?>" /></td>
                                <td><input type="number" name="group_period[]" placeholder="<?php _e('Period', 'rupayments') ?>" min="1" value="<?php echo $group['f_group_period'] ?>" /></td>
                                <td><a id="remove" class="remove" href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&route=rupayments-users&l=groups&do=group-delete&id=' . $group['fk_i_group_id']; ?>" title="<?php _e('Remove User Group', 'rupayments') ?>"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td id="id">1</td>
                        <td><input type="text" name="group_name[]" placeholder="<?php _e('Group Name', 'rupayments') ?>" /></td>
                        <td><input type="text" name="group_desc[]" placeholder="<?php _e('Group Description', 'rupayments') ?>" /></td>
                        <td><input type="color" name="group_color[]" value="#018be3" /></td>
                        <td><input type="number" name="group_fee[]" placeholder="<?php _e('Fee', 'rupayments') ?>" min="1" /></td>
                        <td><input type="number" name="group_discount[]" placeholder="<?php _e('Discount', 'rupayments') ?>" min="0" /></td>
                        <td><input type="number" name="group_period[]" placeholder="<?php _e('Period', 'rupayments') ?>" min="1" /></td>
                        <td><a onclick="alert('<?php _e("You can\'t delete the item!") ?>');" class="remove" href="javascript:void(0);"><i class="fa fa-times-circle-o"></i></a></td>
                    </tr>
                    <?php endif; ?>
                </table>
                
                <p class="content">
                    <a id="add-group" class="btn btn-green" href="javascript:void(0);"><i class="fa fa-plus-square-o fa-lg"></i> <?php _e('Add New Group', 'rupayments') ?></a>
                </p>
                
                <div class="form-actions">
                    <input type="submit" id="save_changes" value="<?php echo osc_esc_html(__("Save changes", 'rupayments')); ?>" class="btn btn-submit">
                </div>
            </form>
			<div class="code-block">
                <p class="help-box"><?php _e('Membership in the group allows users to receive a discount on the purchase of services.', 'rupayments'); ?></p>
            </div>
        </div>
    </div>
</div>

<script>
    $('a#add-group').click(function() {
        var lastId = parseInt($('#table-user-groups tr:last-child #id').text()) + 1,
            groupRow = '<tr><td id="id">' + lastId + '</td><td><input type="text" name="group_name[]" placeholder="<?php _e("Group Name", "rupayments") ?>" /></td><td><input style="width: 220px;" type="text" name="group_desc[]" placeholder="<?php _e("Group Description", "rupayments") ?>" /></td><td><input type="color" name="group_color[]" value="#018be3" /></td><td><input type="number" name="group_fee[]" placeholder="<?php _e("Fee", "rupayments") ?>" min="1" /></td><td><input type="number" name="group_discount[]" placeholder="<?php _e("Discount", "rupayments") ?>" min="0" /></td><td><input type="number" name="group_period[]" placeholder="<?php _e("Period", "rupayments") ?>" min="1" /></td><td><a id="remove-group" class="remove" href="#"><i class="fa fa-trash-o"></i></a></td></tr>';
        
        $('#table-user-groups tr:last-child').after(groupRow);
    });
    
    $('body').on('click','a#remove-group',function() {
        $(this).parents('tr').remove();
        
        $('td#id').each(function(index){
            index++;
            $(this).text(index);
        });
    })
    
    $('a#remove').click(function() {
        if(confirm('<?php _e("Are you sure you want to delete this user group?","rupayments") ?>')) return true;
        
        return false;
    });
</script>