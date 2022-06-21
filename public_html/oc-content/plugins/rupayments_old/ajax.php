<?php

$action = Params::getParam('do');

switch($action) {
    case 'region-prices' :
        $cat_id = Params::getParam('catId'); 
        $city_id = Params::getParam('cityId');
        $template = '';
        
        if($cat_id || $city_id) {
            $city_id ? $item['fk_i_city_id'] = $city_id : $item = false;
        
            if(osc_is_web_user_logged_in()) {
                $sEmail = osc_logged_user_email() ;
            } else {
                $sEmail = null ;
            }
            
            $bPublishform = ModelRUpayments::newInstance()->isPublishPaymentNeededform ($cat_id, $sEmail, $item);
            
            if ($bPublishform) {
                $template .= '<div class="upay_itemform">
                        <span class="upay_adminspan"><input type="radio" name="productType" value="101" checked></span>' . ModelRUpayments::newInstance()->printPriceLableform( $cat_id, '101', $sEmail, $item ) . ' <span class="mdi mdi-near-me mdi-24px"></span>' . ", " .  ModelRUpayments::newInstance()->printPriceStrform( $cat_id, '101', $sEmail, $item) . '
                    </div>';
            }
            
            if(osc_get_preference('pay_per_show_image_status', 'rupayments')) {
                $template .= '<div class="upay_itemform">
                        <span class="upay_adminspan"><input type="radio" name="productType" value="701"></span>' . ModelRUpayments::newInstance()->printPriceLableform( $cat_id, '701', $sEmail, $item ) . ' <span class="mdi mdi-image mdi-24px"></span>' . ", " .  ModelRUpayments::newInstance()->printPriceStrform( $cat_id, '701', $sEmail, $item) . '
                    </div>';
            }
            
            if (osc_get_preference('allow_high', 'rupayments')) {
                $template .= '<div class="upay_itemform">
                        <span class="upay_adminspan"><input type="radio" name="productType" value="301"></span>' . ModelRUpayments::newInstance()->printPriceLableform( $cat_id, '301', $sEmail, $item ) . ' <span class="mdi mdi-format-color-fill mdi-24px"></span>' . ", " .  ModelRUpayments::newInstance()->printPriceStrform( $cat_id, '301', $sEmail, $item) . '
                    </div>';
            }
            
            if(osc_get_preference('3_in_1_pack_status', 'rupayments' )) {
                $template .= '<div class="upay_itemform">
                        <span class="upay_adminspan"><input type="radio" name="productType" value="801"></span>' . ModelRUpayments::newInstance()->printPriceLableform( $cat_id, '801', $sEmail, $item ) . ' <span class="mdi mdi-certificate mdi-24px"></span>' . ", " .  ModelRUpayments::newInstance()->printPriceStrform( $cat_id, '801', $sEmail, $item) . '
                    </div>';
            }
            
            if (osc_get_preference ('allow_premium', 'rupayments')) {
                $template .= '<div class="upay_itemform">
                        <span class="upay_adminspan"><input type="radio" name="productType" value="201"></span>' . ModelRUpayments::newInstance()->printPriceLableform( $cat_id, '201', $sEmail, $item ) . ' <span class="mdi mdi-star mdi-24px"></span>' . ", " .  ModelRUpayments::newInstance()->printPriceStrform( $cat_id, '201', $sEmail, $item) . '
                    </div>';
            }
            
            if (osc_get_preference('allow_premium', 'rupayments') && osc_get_preference('allow_high', 'rupayments')) {
                $template .= '<div class="upay_itemform">
                        <span class="upay_adminspan"><input type="radio" name="productType" value="231"></span>' . ModelRUpayments::newInstance()->printPriceLableform( $cat_id, '231', $sEmail, $item ) . ' <span class="mdi mdi-star mdi-24px"></span><span class="mdi mdi-format-color-fill mdi-24px"></span>' . ", " .  ModelRUpayments::newInstance()->printPriceStrform( $cat_id, '231', $sEmail, $item) . '
                    </div>';
            }
            
            if(osc_get_preference ('allow_premium', 'rupayments') && osc_get_preference('pay_per_show_image_status', 'rupayments')) {
                $template .= '<div class="upay_itemform">
                        <span class="upay_adminspan"><input type="radio" name="productType" value="711"></span>' . ModelRUpayments::newInstance()->printPriceLableform( $cat_id, '711', $sEmail, $item ) . ' <span class="mdi mdi-star mdi-24px"></span> <span class="mdi mdi-image mdi-24px"></span>' . ", " .  ModelRUpayments::newInstance()->printPriceStrform( $cat_id, '711', $sEmail, $item) . '
                    </div>';
            }
            
            if(osc_get_preference ('allow_high', 'rupayments') && osc_get_preference('pay_per_show_image_status', 'rupayments')) {
                $template .= '<div class="upay_itemform">
                        <span class="upay_adminspan"><input type="radio" name="productType" value="721"></span>' . ModelRUpayments::newInstance()->printPriceLableform( $cat_id, '721', $sEmail, $item ) . ' <span class="mdi mdi-format-color-fill mdi-24px"></span> <span class="mdi mdi-image mdi-24px"></span>' . ", " .  ModelRUpayments::newInstance()->printPriceStrform( $cat_id, '721', $sEmail, $item) . '
                    </div>';
            }
            
            if(osc_get_preference ( 'allow_premium', 'rupayments' ) && osc_get_preference ( 'allow_high', 'rupayments' ) && osc_get_preference('pay_per_show_image_status', 'rupayments')) {
                $template .= '<div class="upay_itemform">
                        <span class="upay_adminspan"><input type="radio" name="productType" value="731"></span>' . ModelRUpayments::newInstance()->printPriceLableform( $cat_id, '731', $sEmail, $item ) . ' <span class="mdi mdi-star mdi-24px"></span> <span class="mdi mdi-format-color-fill mdi-24px"></span> <span class="mdi mdi-image mdi-24px"></span>' . ", " .  ModelRUpayments::newInstance()->printPriceStrform( $cat_id, '731', $sEmail, $item) . '
                    </div>';
            }
            
            if(osc_get_preference('3_in_1_pack_status', 'rupayments') && osc_get_preference('pay_per_show_image_status', 'rupayments')) {
                $template .= '<div class="upay_itemform">
                        <span class="upay_adminspan"><input type="radio" name="productType" value="811"></span>' . ModelRUpayments::newInstance()->printPriceLableform( $cat_id, '811', $sEmail, $item ) . ' <span class="mdi mdi-certificate mdi-24px"></span> <span class="mdi mdi-image mdi-24px"></span>' . ", " .  ModelRUpayments::newInstance()->printPriceStrform( $cat_id, '811', $sEmail, $item) . '
                    </div>';
            }
            
            if(!$bPublishform) {
                $template .= '<div class="upay_itemform">
                        <span class="upay_adminspan"><input type="radio" name="productType" value="001"></span>' . __( 'No,thanks', 'rupayments' ) . '
                    </div>';
            }
            
            echo $template;
        }
    break;
    
    case 'banner-clicks' :
        $banner_id = Params::getParam('bannerId');
        $banner = ModelRUpayments::newInstance()->getBannerPublish($banner_id);
        
        if($banner['i_banner_status'] == 1) {
            $clicks = $banner['i_banner_clicks']; $clicks_fee = $banner['s_banner_click_fee'];
            $spent = $banner['s_banner_spent']; $budget = $banner['i_banner_budget'];
            $upd_clicks = $clicks + 1; 
            $upd_spent = $spent + $clicks_fee;
            
            if($upd_spent >= $budget) {
                $status = 4;
                
                $user = User::newInstance()->findByPrimaryKey($banner['i_user_id']);
                $item = array(
                            'pk_i_id' => $banner['fk_i_banner_id'],
                            's_contact_name' => $user['s_name'],
                            's_contact_email' => $user['s_email']  
                            );
                
                rupayments_send_email ( $item, 0, 'alert', '903' );
            }
                else $status = 1;
            
            $obj = new DAO();
            
            $obj->dao->update(
                    ModelRUpayments::newInstance()->getTable_banners(),
                    array('i_banner_clicks' => $upd_clicks, 's_banner_spent' => $upd_spent, 'i_banner_status' => $status),
                    array('fk_i_banner_id' => $banner_id) 
                );  
        }
    break;
}
?>