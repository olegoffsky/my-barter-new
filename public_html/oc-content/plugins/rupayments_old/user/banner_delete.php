<?php defined('ABS_PATH') or die('Access denied'); 
/*
 * Copyright 2017 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
    if ( !osc_logged_user_id() ) {  
        return false;
    }
    
    $id = Params::getParam('bid');
    
    $result = ModelRUpayments::newInstance()->deleteUserBannerPublish($id, osc_logged_user_id());
        
    // HACK : This will make possible use of the flash messages ;)
    ob_get_clean();
    
    if($result) {
        osc_add_flash_ok_message(_m('Congratulations! Banner successfully deleted.', 'rupayments'));
    }
    else {
        osc_add_flash_error_message(_m('Error: You can\'t delete the banner!', 'rupayments'));
    }
    
    osc_redirect_to(osc_route_url('rupayments-user-banners'));
?>