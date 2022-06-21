<?php
/*
 * Copyright 2015 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
    if(osc_get_preference('pay_per_post', 'rupayments')) {
        // Load Item Information, so we could tell the user which item is he/she paying for
        
        if ( !Params::getParam('itemId') ) {  
            return false;
        }
  
        $item = Item::newInstance()->findByPrimaryKey(Params::getParam('itemId'));
		 $iItemID = Params::getParam('itemId'); 
		View::newInstance()->_exportVariableToView('item', Item::newInstance()->findByPrimaryKey($iItemID));
        if($item) {
            // Check if it's already payed or not
            if(!ModelRUpayments::newInstance()->publishFeeIsPaid(Params::getParam("itemId"))) {
                // Item is not paid, continue
                $category_fee = ModelRUpayments::newInstance()->getPublishPrice($item['fk_i_category_id'], $item);
                if($category_fee > 0) {
                ?>
<?php //echo '<pre>'; print_r($item); echo '</pre>'; ?>
<h3 class="uservicepayh2form"><?php _e( "You can Publish item with additional options:", 'rupayments'); ?></h3><br>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">

<?php if(osc_get_preference ( '3_in_1_pack_status', 'rupayments' )): ?>
<div class="menupack"><h2><span class="mdi mdi-certificate mdi-24px"></span><?php _e('PACK 3-in-1', 'rupayments'); ?> - <?php _e('100x views!', 'rupayments'); ?></h2></div>
<p class="paypal_detail"><?php _e('Attract as many visitors as possible to your ad. This option includes: Premium status, highlighting the ad and automatically moving your ad in the top every day! The duration of the option in days:', 'rupayments'); ?><?php echo osc_get_preference('3_in_1_pack_days', 'rupayments'); ?></p>
<?php endif; ?>

<div class="menupremium"><h2><span class="mdi mdi-star mdi-24px"></span><?php _e('PREMIUM', 'rupayments'); ?> - <?php _e('20x views!', 'rupayments'); ?></h2></div>
<p class="paypal_detail"><?php _e('Premium status is when the ads are highlighted and shown on top of free ads in . This promotes more rapid sales. The duration of the option in days:', 'rupayments'); ?><?php echo osc_get_preference('premium_days', 'rupayments'); ?></p>
<div class="menuhigh"><h2><span class="mdi mdi-format-color-fill mdi-24px"></span><?php _e('HIGHLIGHT', 'rupayments'); ?> - <?php _e('5x views!', 'rupayments'); ?></h2></div>
<p class="paypal_detail"><?php _e('This option allows to attract the visitors attention on you ads. Background of your ad becomes highlighted. The duration of the option in days:', 'rupayments'); ?><?php echo osc_get_preference('color_days', 'rupayments'); ?></p>
<div class="menutop"><h2><span class="mdi mdi-arrow-up-thick mdi-24px"></span><?php _e('MOVE TO TOP', 'rupayments'); ?> - <?php _e('3x views!', 'rupayments'); ?></h2></div>
<p class="paypal_detail"><?php _e('This function moves you ad once on the top of the you category and the main page too.', 'rupayments'); ?></p>
<?php if(osc_get_preference('pay_per_show_image_status', 'rupayments')): ?>
<div class="menuimg"><h2><span class="mdi mdi-image mdi-24px"></span><?php _e('SHOW IMAGE', 'rupayments'); ?></h2></div>
<p class="paypal_detail"><?php _e('This option allows you to show uploaded images in your ads', 'rupayments'); ?></p>
<?php endif; ?>

                <div class="upay_item">
                    			            <div class="upay_item_info">
            <h3><?php echo osc_highlight( strip_tags( osc_item_title() ),25 ); ?></h3>
			<div class="img">
					  				<?php if( osc_count_item_resources() ) { ?><a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" /></a><?php } else { ?>
                                                <img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/img/no_photo.gif" alt="" title="" />
                                            <?php } ?>
					  			</div>
            <p class="bottomtext">
                <span class="mdi mdi-update mdi-18px"></span>: <?php echo osc_format_date(osc_item_pub_date()) ; ?>
                <span class="mdi mdi-cash-usd mdi-18px"></span>: <?php echo osc_format_price(osc_item_price()); ?>
            </p>
			</div> 
                    <div class="upay_item_service">
                        <?php _e("In order to make visible your ad to other users, it's required to pay a fee", 'rupayments'); ?>.<br/>
                        <?php echo sprintf(__('The current fee for this category is: %.2f %s', 'rupayments'), $category_fee, osc_get_preference('currency', 'rupayments')); ?><br/>
                        <?php _e("Durations in prices is for additional options.", 'rupayments'); ?><br/>
                        <table cellpadding="5" cellspacing="5">
                        <form action="<?php echo osc_route_url('rupayments-user-payments'); ?>" name="goToPayForm" method="post">
<script language="javascript">
  function sendForm() {
    $('input[name="productType"]').val( $('input[name="product_type"]:checked').val() );
    var goToPayForm = document.forms.goToPayForm; 
    goToPayForm.submit();
  }
</script>
                        <input type='hidden' name='itemId' value='<?php echo $item['pk_i_id']; ?>'>
                        <input type='hidden' name='categoryId' value='<?php echo $item['fk_i_category_id']; ?>'> 
                        <input type='hidden' name='productType' value='101'> 
                        <input type='hidden' name='url_back' value='rupayments-publish'>
<?php
    if ( $category_fee && ModelRUpayments::newInstance()->isPublishPaymentNeeded ( $item ) ) {
?>
                          <tr>
                              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="101" checked></span></td>
                              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '101' ); ?></td>
                              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '101' );?></td>
                          </tr>
<?php
    }
?>

    <?php if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])): ?>
            <tr>
              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="701"></span></td>
              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '701' ); ?></td>
              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '701' ); ?></td>
            </tr>
    <?php endif; ?>

<?php
    if ( osc_get_preference ( 'allow_high', 'rupayments' ) ) {
?>
                          <tr>
                              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="301"></span></td>
                              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '301' ); ?></td>
                              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '301' ); ?></td>
                          </tr>
<?php
    }
?>

    <?php if(osc_get_preference('pay_per_show_image_status', 'rupayments') && osc_get_preference ( 'allow_high', 'rupayments' ) && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])): ?>
            <tr>
              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="721"></span></td>
              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '721' ); ?></td>
              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '721' ); ?></td>
            </tr>
    <?php endif; ?>
    
    <?php if(osc_get_preference ( '3_in_1_pack_status', 'rupayments' )): ?>
            <tr>
              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="801"></span></td>
              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '801' ); ?></td>
              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '801' ); ?></td>
            </tr>
    <?php endif; ?>

<?php
    if ( osc_get_preference ( 'allow_premium', 'rupayments' ) ) {
?> 
                          <tr>
                              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="201"></span></td>
                              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '201' ); ?></td>
                              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '201' ); ?></td>
                          </tr>
<?php
    }
?>

    <?php if(osc_get_preference('pay_per_show_image_status', 'rupayments') && osc_get_preference ( 'allow_premium', 'rupayments' ) && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])): ?>
            <tr>
              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="711"></span></td>
              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '711' ); ?></td>
              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '711' ); ?></td>
            </tr>
    <?php endif; ?>

<?php
    if ( osc_get_preference ( 'allow_premium', 'rupayments' ) && osc_get_preference ( 'allow_high', 'rupayments' ) ) {
?>  
                          <tr>
                             <td><span class="upay_adminspan"><input type="radio" name="product_type" value="231"></span></td>
                              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '231' ); ?></td>                          
                              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '231' ); ?></td>
                          </tr> 
<?php
    }
?>
    <?php if(osc_get_preference('pay_per_show_image_status', 'rupayments') && osc_get_preference ( 'allow_premium', 'rupayments' ) && osc_get_preference ( 'allow_high', 'rupayments' ) && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])): ?>
            <tr>
              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="731"></span></td>
              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '731' ); ?></td>
              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '731' ); ?></td>
            </tr>
    <?php endif; ?>
    
    <?php if(osc_get_preference ( '3_in_1_pack_status', 'rupayments' ) && osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])): ?>
            <tr>
              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="811"></span></td>
              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '811' ); ?></td>
              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '811' ); ?></td>
            </tr>
    <?php endif; ?>
                          <tr>
                              <td></td>
                              <td> <!--<input type="button" onclick="sendForm();" name="goToPayForm" value="Continue >>">-->
                              <button class="ubutton_from" onclick="sendForm();"><?php _e('Choose and continue', 'rupayments'); ?></button> </td>
                              <td></td>
                          </tr>
                        </form> 
                      </table> 
                    </div>
                    <div style="clear:both;"></div>
                    <div name="result_div" id="result_div"></div>
                    <script type="text/javascript">
                        var rd = document.getElementById("result_div");
                    </script>
                </div>
				</br>
                <?php
                } else {
                    // PRICE IS ZERO!
                    ?>
                    <h1><?php _e("There was an error", 'rupayments'); ?></h1>
                    <div>
                        <p><?php _e("There's no need to pay the publish fee", 'rupayments'); ?></p>
                    </div>
                    <?php
                }
            } else {
                // ITEM WAS ALREADY PAID! STOP HERE
                ?>
                <h1><?php _e('There was an error', 'rupayments'); ?></h1>
                <div>
                    <p><?php _e('The publish fee is already paid', 'rupayments'); ?></p>
                </div>
                <?php
            }
        } else {
            //ITEM DOES NOT EXIST! STOP HERE
            ?>
            <h1><?php _e('There was an error','rupayments'); ?></h1>
            <div>
                <p><?php _e('The item doesn not exists', 'rupayments'); ?></p>
            </div>
            <?php
        }
    } else {
        // NO NEED TO PAY AT ALL!
        ?>
        <h1><?php _e('There was an error', 'rupayments'); ?></h1>
        <div>
            <p><?php _e("There's no need to pay the publish fee", 'rupayments'); ?></p>
        </div>
        <?php
    }
?>