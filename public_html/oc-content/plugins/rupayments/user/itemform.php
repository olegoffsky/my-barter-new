<?php
/*
 * Copyright 2017 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
if(osc_is_web_user_logged_in()) {
	$sEmail = osc_logged_user_email() ;
} else {
	$sEmail = null ;
}
?>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">
<script type="text/javascript" src="https://do-mos.ru/oc-content/plugins/rupayments/js/ultimate.js"></script>
<script type="text/javascript" src="https://use.fontawesome.com/af830f475b.js" async defer></script>

<?php  //$category_fee = ModelRUpayments::newInstance()->getPublishPrice($categoryId);
       $bPublishform = ModelRUpayments::newInstance()->isPublishPaymentNeededform ($categoryId, $sEmail); ?>
    <h2 class="uservicepayh2form"><?php _e( 'Services for you item:', 'rupayments' );?></h2>
    
<?php if(osc_get_preference ( '3_in_1_pack_status', 'rupayments' )): ?>
<div class="menupack"><h2><span class="mdi mdi-certificate mdi-24px"></span><?php _e('PACK 3-in-1', 'rupayments'); ?> - <?php _e('100x views!', 'rupayments'); ?></h2></div>
<p class="paypal_detail"><?php _e('Attract as many visitors as possible to your ad. This option includes: Premium status, highlighting the ad and automatically moving your ad in the top every day! The duration of the option in days:', 'rupayments'); ?><?php echo osc_get_preference('3_in_1_pack_days', 'rupayments'); ?></p>
<?php endif; ?>
    
<div class="menupremium"><h2><span class="mdi mdi-star mdi-24px"></span><?php _e('PREMIUM', 'rupayments'); ?> - <?php _e('20x views!', 'rupayments'); ?></h2></div>
<p class="paypal_detail"><?php _e('Premium status is when the ads are highlighted and shown on top of free ads in . This promotes more rapid sales. The duration of the option in days:', 'rupayments'); ?><?php echo osc_get_preference('premium_days', 'rupayments'); ?></p>
<div class="menuhigh"><h2><span class="mdi mdi-format-color-fill mdi-24px"></span><?php _e('HIGHLIGHT', 'rupayments'); ?> - <?php _e('5x views!', 'rupayments'); ?></h2></div>
<p class="paypal_detail"><?php _e('This option allows to attract the visitors attention on you ads. Background of your ad becomes highlighted. The duration of the option in days:', 'rupayments'); ?><?php echo osc_get_preference('color_days', 'rupayments'); ?></p> 

<?php if(osc_get_preference('pay_per_show_image_status', 'rupayments')): ?>
<div class="menuimg"><h2><span class="mdi mdi-image mdi-24px"></span><?php _e('SHOW IMAGE', 'rupayments'); ?></h2></div>
<p class="paypal_detail"><?php _e('This option allows you to show uploaded images in your ads', 'rupayments'); ?></p>
<?php endif; ?>
<div id="itemform-block">

        <?php
        if ( $bPublishform) {

            ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="productType" value="101" checked></span><?php echo ModelRUpayments::newInstance()->printPriceLableform( $categoryId, '101', $sEmail );?> <span class="mdi mdi-near-me mdi-24px"></span><?php echo ", "; echo ModelRUpayments::newInstance()->printPriceStrform( $categoryId, '101', $sEmail);?>
            </div>
            <?php
        }
        ?>
        
        <?php if(osc_get_preference('pay_per_show_image_status', 'rupayments')): ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="productType" value="701"></span><?php echo ModelRUpayments::newInstance()->printPriceLableform( $categoryId, '701', $sEmail );?> <span class="mdi mdi-image mdi-24px"></span><?php echo ", "; echo ModelRUpayments::newInstance()->printPriceStrform( $categoryId, '701', $sEmail );?>
            </div>
        <?php endif; ?>
        
        <?php 
            if ( osc_get_preference ( 'allow_high', 'rupayments' )  ) {
            ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="productType" value="301"></span><?php echo ModelRUpayments::newInstance()->printPriceLableform( $categoryId, '301', $sEmail );?> <span class="mdi mdi-format-color-fill mdi-24px"></span><?php echo ", "; echo ModelRUpayments::newInstance()->printPriceStrform( $categoryId, '301', $sEmail );?>
            </div>
            <?php
        }
        ?> 
        
        <?php if(osc_get_preference ( '3_in_1_pack_status', 'rupayments' )): ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="productType" value="801"></span><?php echo ModelRUpayments::newInstance()->printPriceLableform( $categoryId, '801', $sEmail );?> <span class="mdi mdi-certificate mdi-24px"></span><?php  echo ", "; echo ModelRUpayments::newInstance()->printPriceStrform( $categoryId, '801', $sEmail );?>
            </div>
        <?php endif; ?>
        
        <?php
        if ( osc_get_preference ( 'allow_premium', 'rupayments' ) ) {
            ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="productType" value="201"<?php if ( !$bPublishform ) echo " checked";?>></span><?php echo ModelRUpayments::newInstance()->printPriceLableform( $categoryId, '201', $sEmail );?> <span class="mdi mdi-star mdi-24px"></span><?php echo ", "; echo ModelRUpayments::newInstance()->printPriceStrform( $categoryId, '201', $sEmail );?>
            </div>
            <?php
        }
        
        if ( osc_get_preference ( 'allow_premium', 'rupayments' ) && osc_get_preference ( 'allow_high', 'rupayments' ) ) {
            ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="productType" value="231"></span><?php echo ModelRUpayments::newInstance()->printPriceLableform( $categoryId, '231', $sEmail );?> <span class="mdi mdi-star mdi-24px"></span><span class="mdi mdi-format-color-fill mdi-24px"></span><?php  echo ", "; echo ModelRUpayments::newInstance()->printPriceStrform( $categoryId, '231', $sEmail );?>
            </div>
            <?php
        }
        ?>
        
        <?php if(osc_get_preference ( 'allow_premium', 'rupayments' ) && osc_get_preference('pay_per_show_image_status', 'rupayments')): ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="productType" value="711"></span><?php echo ModelRUpayments::newInstance()->printPriceLableform( $categoryId, '711', $sEmail );?> <span class="mdi mdi-star mdi-24px"></span> <span class="mdi mdi-image mdi-24px"></span><?php echo ", "; echo ModelRUpayments::newInstance()->printPriceStrform( $categoryId, '711', $sEmail );?>
            </div>
        <?php endif; ?>
        
        <?php if(osc_get_preference ( 'allow_high', 'rupayments' ) && osc_get_preference('pay_per_show_image_status', 'rupayments')): ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="productType" value="721"></span><?php echo ModelRUpayments::newInstance()->printPriceLableform( $categoryId, '721', $sEmail );?> <span class="mdi mdi-format-color-fill mdi-24px"></span> <span class="mdi mdi-image mdi-24px"></span><?php echo ", "; echo ModelRUpayments::newInstance()->printPriceStrform( $categoryId, '721', $sEmail );?>
            </div>
        <?php endif; ?>
        
        <?php if(osc_get_preference ( 'allow_premium', 'rupayments' ) && osc_get_preference ( 'allow_high', 'rupayments' ) && osc_get_preference('pay_per_show_image_status', 'rupayments')): ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="productType" value="731"></span><?php echo ModelRUpayments::newInstance()->printPriceLableform( $categoryId, '731', $sEmail );?> <span class="mdi mdi-star mdi-24px"></span> <span class="mdi mdi-format-color-fill mdi-24px"></span> <span class="mdi mdi-image mdi-24px"></span><?php echo ", "; echo ModelRUpayments::newInstance()->printPriceStrform( $categoryId, '731', $sEmail );?>
                
        <?php if(osc_get_preference ( '3_in_1_pack_status', 'rupayments' ) && osc_get_preference('pay_per_show_image_status', 'rupayments')): ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="productType" value="811"></span><?php echo ModelRUpayments::newInstance()->printPriceLableform( $categoryId, '811', $sEmail );?> <span class="mdi mdi-certificate mdi-24px"></span> <span class="mdi mdi-image mdi-24px"></span><?php  echo ", "; echo ModelRUpayments::newInstance()->printPriceStrform( $categoryId, '811', $sEmail );?>
            </div>
        <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php
		   if (!$bPublishform ) {
            ?>
		    <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="productType" value="001"></span><?php _e( 'No,thanks', 'rupayments' );?>
            </div>
            <?php
        }
        ?>
</div>