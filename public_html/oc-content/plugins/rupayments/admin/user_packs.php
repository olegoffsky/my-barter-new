<?php defined('ABS_PATH') or die('Access denied'); 
    $i = 1;
    $packs = ModelRUpayments::newInstance()->getPacks();
    
    if(Params::getParam('plugin_action') == 'done') {
        $set_packs = ModelRUpayments::newInstance()->setPacks();
        
        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'rupayments'), 'admin');
        osc_redirect_to(osc_route_admin_url('rupayments-users', array('l' => 'packs')));
    }
    
    if(Params::getParam('do') == 'pack-delete') {
        $id = Params::getParam('id');
        
        $result = ModelRUpayments::newInstance()->deletePack($id);
        
        ob_get_clean();
        
        if($result)
            osc_add_flash_ok_message(__('Congratulations, the pack deleted successfully', 'rupayments'), 'admin');
        else
            osc_add_flash_error_message(__('The pack could not be deleted', 'rupayments'), 'admin');
            
        osc_redirect_to(osc_route_admin_url('rupayments-users', array('l' => 'packs')));
    }
?>

<?php require_once 'top_menu.php'; ?>
<div class="rupayments-manage-wrapper">
    <?php require_once 'left_menu.php'; ?>
    <div class="rupayments-manage-content rupayments-section">
        <div style="margin:15px;">
            <form action="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&route=rupayments-users&l=packs'; ?>" method="post">
                <input type="hidden" name="page" value="plugins" />
                <input type="hidden" name="action" value="renderplugin" />
                <input type="hidden" name="plugin_action" value="done" />
                
                <table id="table-packs" class="table-striped">
                    <tr>
                        <th><?php _e('ID', 'rupayments'); ?></th>
                        <th><?php _e('Pack Name', 'rupayments'); ?></th>
						<th><?php _e('Pack Description', 'rupayments'); ?></th>
                        <th><?php _e('Color', 'rupayments'); ?></th>
                        <th><?php echo sprintf(__('Amount (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th><?php echo sprintf(__('Bonus (%s)', 'rupayments'), osc_get_preference('currency', 'rupayments')); ?></th>
                        <th style="width: 50px;"><?php _e('Delete', 'rupayments');; ?></th>  
                    </tr>
                    <?php if($packs): ?>
                        <?php foreach($packs as $pack): ?>
                            <tr>
                                <input type="hidden" name="pack_id[]" value="<?php echo $pack['fk_i_pack_id'] ?>" />
                                <td id="id"><?php echo $i; ?></td>
                                <td><input type="text" name="pack_name[]" placeholder="<?php _e('Pack Name', 'rupayments') ?>" value="<?php echo $pack['f_pack_title'] ?>" /></td>
                                <td><input type="text" name="pack_desc[]" placeholder="<?php _e('Pack Description', 'rupayments') ?>" value="<?php echo $pack['f_pack_description'] ?>" /></td>
                                <td><input type="color" name="pack_color[]" value="<?php echo $pack['f_pack_color'] ?>" /></td>
                                <td><input type="number" name="pack_amount[]" placeholder="<?php _e('Amount', 'rupayments') ?>" min="1" value="<?php echo $pack['f_pack_amount'] ?>" /></td>
                                <td><input type="number" name="pack_bonus[]" placeholder="<?php _e('Bonus', 'rupayments') ?>" min="0" value="<?php echo $pack['f_pack_bonus'] ?>" /></td>
                                <td><a id="delete-pack" class="remove" href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&route=rupayments-users&l=packs&do=pack-delete&id=' . $pack['fk_i_pack_id']; ?>" title="<?php _e('Remove Pack', 'rupayments') ?>"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td id="id">1</td>
                        <td><input type="text" name="pack_name[]" placeholder="<?php _e('Pack Name', 'rupayments') ?>" /></td>
                        <td><input type="text" name="pack_desc[]" placeholder="<?php _e('Pack Description', 'rupayments') ?>" /></td>
                        <td><input type="color" name="pack_color[]" value="#018be3" /></td>
                        <td><input type="number" name="pack_amount[]" placeholder="<?php _e('Amount', 'rupayments') ?>" min="1" /></td>
                        <td><input type="number" name="pack_bonus[]" placeholder="<?php _e('Bonus', 'rupayments') ?>" min="0" /></td>
                        <td><a onclick="alert('<?php _e("You can\'t delete the item!") ?>');" class="remove" href="javascript:void(0);"><i class="fa fa-times-circle-o"></i></a></td>
                    </tr>
                    <?php endif; ?>
                </table>
                
                <p class="content">
                    <a id="add-pack" class="btn btn-green" href="javascript:void(0);"><i class="fa fa-plus-square-o fa-lg"></i> <?php _e('Add New Pack', 'rupayments') ?></a>
                </p>
                
                <div class="form-actions">
                    <input type="submit" id="save_changes" value="<?php echo osc_esc_html(__("Save changes", 'rupayments')); ?>" class="btn btn-submit">
                </div>
            </form>
			            <div class="code-block">
                <p class="help-box"><?php _e('Packs allow the user to replenish the wallet balance in site.', 'rupayments'); ?></p>
				 <p class="help-box"><?php _e('Wallet  is available in the user personal acount.', 'rupayments'); ?></p>
                <p class="help-box"><?php _e('Then the user from this balance can pay for services on the site.', 'rupayments'); ?></p>
            </div>
        </div>
    </div>
</div>

<script>
    $('a#add-pack').click(function() {
        var lastId = parseInt($('#table-packs tr:last-child #id').text()) + 1,
            packRow = '<tr><td id="id">' + lastId + '</td><td><input type="text" name="pack_name[]" placeholder="<?php _e("Pack Name","rupayments") ?>" /></td><td><input type="text" name="pack_desc[]" placeholder="<?php _e("Pack Description", "rupayments") ?>" /></td><td><input type="color" name="pack_color[]" value="#018be3" /></td><td><input type="number" name="pack_amount[]" placeholder="<?php _e("Amount", "rupayments") ?>" min="1" /></td><td><input type="number" name="pack_bonus[]" placeholder="<?php _e("Bonus", "rupayments") ?>" min="0" /></td><td><a id="remove-pack" class="remove" href="#"><i class="fa fa-trash-o"></i></a></td></tr>';
        
        $('#table-packs tr:last-child').after(packRow);
    });
    
    $('body').on('click','a#remove-pack',function() {
        $(this).parents('tr').remove();
        
        $('td#id').each(function(index){
            index++;
            $(this).text(index);
        });
    })
    
    $('a#delete-pack').click(function() {
        if(confirm('<?php _e("Are you sure you want to delete this pack?","rupayments") ?>')) return true;
        
        return false;
    });
</script>