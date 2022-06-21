<?php
/*
 * Copyright 2017 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
        if ( !Params::getParam('itemId') ) {  
            return false;
        }
  
        // Load Item Information, so we could tell the user which item is he/she paying for
        $item = Item::newInstance()->findByPrimaryKey(Params::getParam('itemId'));
        $sCommand = Params::getParam('cmd');
        $iProductType = Params::getParam('prodType');
        $category_fee = ModelRUpayments::newInstance()->getPublishPrice($item['fk_i_category_id']); 
        
			$iItemID = Params::getParam('itemId'); 
		View::newInstance()->_exportVariableToView('item', Item::newInstance()->findByPrimaryKey($iItemID));
	$sText = __( 'Premium is valid else', 'rupayments' );
	$sText2 = __( 'Highlited is valid else', 'rupayments' );
	$sTextE = __( 'Expired', 'rupayments' );
	$sTextEA = __( 'Before Expiration', 'rupayments' );
    $sTextDays = __( 'days', 'rupayments' );
    $sTextHours = __( 'hours', 'rupayments' );
	$sTextMinutes = __( 'minutes', 'rupayments' );
        
  if ( $category_fee && ModelRUpayments::newInstance()->isPublishPaymentNeeded ( $item ) ) {
?>
<?php _e("In order to make visible your ad to other users, it's required to pay a fee", 'rupayments'); ?>.<br/>
<?php echo sprintf(__('The current Publish fee for this category is: %.2f %s', 'rupayments'), $category_fee, osc_get_preference('currency', 'rupayments')); ?><br/>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">
<script type="text/javascript" src="https://do-mos.ru/oc-content/plugins/rupayments/js/ultimate.js"></script>
<script type="text/javascript" src="https://use.fontawesome.com/af830f475b.js" async defer></script>
<h3 class="uservicepayh2form"><?php print __( 'Services for you item:', 'rupayments' );?></h3><br/>
<div class="menupremium"><h2><span class="mdi mdi-star mdi-24px"></span><?php _e('PREMIUM', 'rupayments'); ?> - <?php _e('20x views!', 'rupayments'); ?></h2></div>
<p class="paypal_detail"><?php _e('Premium status is when the ads are highlighted and shown on top of free ads in . This promotes more rapid sales. The duration of the option in days:', 'rupayments'); ?><?php echo osc_get_preference('premium_days', 'rupayments'); ?></p>
<div class="menuhigh"><h2><span class="mdi mdi-format-color-fill mdi-24px"></span><?php _e('HIGHLIGHT', 'rupayments'); ?> - <?php _e('5x views!', 'rupayments'); ?></h2></div>
<p class="paypal_detail"><?php _e('This option allows to attract the visitors attention on you ads. Background of your ad becomes highlighted. The duration of the option in days:', 'rupayments'); ?><?php echo osc_get_preference('color_days', 'rupayments'); ?></p>
<div class="menutop"><h2><span class="mdi mdi-arrow-up-thick mdi-24px"></span><?php _e('MOVE TO TOP', 'rupayments'); ?> - <?php _e('3x views!', 'rupayments'); ?></h2></div>
<p class="paypal_detail"><?php _e('This function moves you ad once on the top of the you category and the main page too.', 'rupayments'); ?></p>
        
<?php
        }
        else { 
        }
        
        if ( $iProductType == '201' ) {
?>
<h3 style="margin-top:0.5em; color: red;"><?php if ( ModelRUpayments::newInstance()->premiumFeeIsPaid ( $item['pk_i_id'] ) && ModelRUpayments::newInstance()->printDaysStr ( $item, '201' ) ) print "<br><span style='color: red;'>".$sText." ".ModelRUpayments::newInstance()->iPremiumDays." ".$sTextDays." ".ModelRUpayments::newInstance()->iPremiumHours." ".$sTextHours." ".ModelRUpayments::newInstance()->iPremiumMinutes." ".$sTextMinutes."</span>";?></h3>                    
<?php                        
        }
        
        if ( $iProductType == '301' ) {
?>
 <h3 style="margin-top:0.5em; color: red;"><?php 
                       if ( ModelRUpayments::newInstance()->colorFeeIsPaid ( $item['pk_i_id'] ) && ModelRUpayments::newInstance()->printDaysStr ( $item, '301' ) ) print "<br><span style='color: red;'>".$sText2." ".ModelRUpayments::newInstance()->iColorDays." ".$sTextDays." ".ModelRUpayments::newInstance()->iColorHours." ".$sTextHours ." ".ModelRUpayments::newInstance()->iColorMinutes." ".$sTextMinutes."</span>"; ?>                    
                    
<?php                        
        }
?>
<div class="upay_item">
                    <div class="upay_item_info">
            <h3><a href="<?php echo osc_item_url(); ?>"><?php echo osc_highlight( strip_tags( osc_item_title() ),25 ); ?></a></h3>
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
                        <h3><?php _e( "You can also improve your ad with additional options", 'rupayments'); ?></h3>
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
                        <input type='hidden' name='productType' value='<?php
    if ( $category_fee && ModelRUpayments::newInstance()->isPublishPaymentNeeded ( $item ) ) print "101";
    else  print "401";
?>'> 
                        <input type='hidden' name='url_back' value='rupayments-after'>
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
		if ( osc_get_preference ( 'allow_renew', 'rupayments' ) && $item['dt_expiration']!="9999-12-31 23:59:59" ) {
?>                  <tr>
                      <td><span class="upay_adminspan"><input type="radio" name="product_type" value="411"<?php if ( $iProductType == '411' ) print " checked";?>></span></td>
                      <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '411' ); ?></td>
                      <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '411' ); ?></td>
                   </tr>
<?php
        }
    if ( osc_get_preference ( 'allow_move', 'rupayments' ) ) {
?>
                          <tr>
                              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="401"<?php if ( $iProductType == '401' ) print " checked";?>></span></td>
                              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '401' ); ?></td>
                              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '401' ); ?></td>
                          </tr>
<?php
    }
    if ( osc_get_preference ( 'allow_high', 'rupayments' ) ) { 
?>
                          <tr>
                              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="301"<?php if ( $iProductType == '301' ) print " checked";?>></span></td>
                              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '301' ); ?></td>
                              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '301' ); ?></td>
                          </tr>
<?php
    }
    if ( osc_get_preference ( 'allow_premium', 'rupayments' ) ) {
?> 
                          <tr>
                              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="201"<?php if ( $iProductType == '201' ) print " checked";?>></span></td>
                              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '201' ); ?></td>
                              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '201' ); ?></td>
                          </tr>
<?php
    }
    if ( osc_get_preference ( 'allow_premium', 'rupayments' ) && osc_get_preference ( 'allow_high', 'rupayments' ) ) {
?>  
                          <tr>
                             <td><span class="upay_adminspan"><input type="radio" name="product_type" value="231"<?php if ( $iProductType == '231' ) print " checked";?>></span></td>
                              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '231' ); ?></td>                          
                              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '231' ); ?></td>
                          </tr> 
<?php
    }
    if ( osc_get_preference ( '3_in_1_pack_status', 'rupayments' ) ) {
?> 
                          <tr>
                              <td><span class="upay_adminspan"><input type="radio" name="product_type" value="801"<?php if ( $iProductType == '801' ) print " checked";?>></span></td>
                              <td><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '801' ); ?></td>
                              <td><?php print ModelRUpayments::newInstance()->printPriceStr ( $item, '801' ); ?></td>
                          </tr>
<?php
    }
?>

                          <tr>
                              <td colspan="3">                         
                              <!-- <input type="button" onclick="sendForm();" name="goToPayForm" value="Continue >>"> -->
                              <button class="ubutton_from" onclick="sendForm();"><?php _e('Choose and continue', 'rupayments'); ?></button></td>
                          </tr>
						 
                        </form> 
                      </table> 
					   </div></div>
					   </br>