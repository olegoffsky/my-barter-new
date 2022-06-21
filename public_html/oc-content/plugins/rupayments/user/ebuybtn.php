<?php defined('ABS_PATH') or die('Access denied'); 
    if($item_id) {
        $ebuy_item = ModelRUpayments::newInstance()->getEbuyItem($item_id);
    }
    //$link = osc_route_url('rupayments-ebuy-purchase', array('bid' => $item_id));
    
    if(osc_is_web_user_logged_in()) {
        if(osc_rewrite_enabled()) {
            $link = '/rupayments/ebuy-purchase/' . $item_id;
        }
        else {
            $link = osc_route_url('rupayments-ebuy-purchase', array('bid' => $item_id)); 
        }
    } else {
    	$link = osc_user_login_url();
    }
?>

<?php if($ebuy_item['i_user_id'] != osc_logged_user_id()): ?>
    <a class="ebuy-btn" href="<?php echo $link; ?>"><?php _e('Buy Item', 'rupayments'); ?></a>
<?php else: ?>
    <a class="ebuy-btn" style="opacity: 0.5;" href="javascript: void(0);" title="<?php _e('This is Your Item. You can\'t Buy it!', 'rupayments'); ?>"><?php _e('Buy Item', 'rupayments'); ?></a>
<?php endif; ?>