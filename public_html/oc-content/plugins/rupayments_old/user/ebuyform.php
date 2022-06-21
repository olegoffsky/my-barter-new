<?php defined('ABS_PATH') or die('Access denied'); 
    $id = Params::getParam("itemId");
    $ebuy_item = array();
    
    if($id) {
        $ebuy_item = ModelRUpayments::newInstance()->getEbuyItem($id);
    }
?>

<div class="itemebuyform-block">
    <label class="saleu-label" for="enable-sale"><?php _e('Enable Sale', 'rupayments'); ?></label>
<p class="paypal_detail"><?php _e('You can sale direct in our website. We will receive all payments, and then transfer to you.', 'rupayments'); ?></p>    
    <div class="controls">                               
        <div class="select-box undefined">
            <select name="enable_sale" id="enable-sale">
                <option value="0"><?php _e('Enable online sales...', 'rupayments'); ?></option>
                <option value="1" <?php if(isset($ebuy_item['i_status']) && $ebuy_item['i_status']): ?>selected<?php endif; ?> ><?php _e('Yes', 'rupayments'); ?></option>
                <option value="0" <?php if(isset($ebuy_item['i_status']) && !$ebuy_item['i_status'] && $ebuy_item): ?>selected<?php endif; ?> ><?php _e('No', 'rupayments'); ?></option>
            </select>
        </div>                            
    </div>
</div>