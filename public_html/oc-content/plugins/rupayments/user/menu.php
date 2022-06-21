<?php
/*
 * Copyright 2016 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
    $itemsPerPage = (Params::getParam('itemsPerPage') != '') ? Params::getParam('itemsPerPage') : 10;
    $page         = (Params::getParam('iPage') != '') ? Params::getParam('iPage') : 0;
    $page_log         = (Params::getParam('iPageLog') != '') ? Params::getParam('iPageLog') : 0;
    $total_items  = Item::newInstance()->countByUserIDEnabled($_SESSION['userId']);
    $total_log_lines  = count ( ModelRUpayments::newInstance()->getUserLogs ( osc_logged_user_id() ) );  
    $total_pages  = ceil($total_items/$itemsPerPage);
    $total_log_pages  = ceil($total_log_lines/$itemsPerPage);
    $items        = Item::newInstance()->findByUserIDEnabled($_SESSION['userId'], $page * $itemsPerPage, $itemsPerPage);

    View::newInstance()->_exportVariableToView('items', $items);
    View::newInstance()->_exportVariableToView('list_total_pages', $total_pages);
    View::newInstance()->_exportVariableToView('list_total_items', $total_items);
    View::newInstance()->_exportVariableToView('items_per_page', $itemsPerPage);
    View::newInstance()->_exportVariableToView('list_page', $page);
    
    $sText = __( 'Valid', 'rupayments' );
	$sTextE = __( 'Expired', 'rupayments' );
	$sTextEA = __( 'Before Expiration', 'rupayments' );
    $sTextDays = __( 'days', 'rupayments' );
    $sTextHours = __( 'hours', 'rupayments' );
	$sTextMinutes = __( 'minutes', 'rupayments' );
   
?>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">
<script type="text/javascript" src="https://do-mos.ru/oc-content/plugins/rupayments/js/ultimate.js"></script>
<script type="text/javascript" src="https://use.fontawesome.com/af830f475b.js" async defer></script>
<div class="menu_ppaypal">
<h2 class="paypal_h"><?php _e('Premium services for you items:', 'rupayments'); ?></h2>
</div>

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


<?php 
    if(osc_count_items() == 0) { ?>
    <h3><?php _e('You don\'t have any listing yet', 'rupayments'); ?></h3>
<?php } 
    else { ?>
    <?php
       $iCount = 1;
    
        while(osc_has_items()) { ?>
         <div class="upay_item">
		<div class="upay_item_info">
            <h3><a class="title" href="<?php echo osc_item_url(); ?>"><?php echo osc_highlight( strip_tags( osc_item_title() ),25 ); ?></a></h3>
			<div class="img">
					  				<?php if( osc_count_item_resources() ) { ?><a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>"  alt="<?php echo osc_item_title(); ?>"/></a><?php } else { ?>
                                                <img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/img/no_photo.gif" alt="" title="" />
                                            <?php } ?>
					  			</div>
            <p class="bottomtext">
                <span class="mdi mdi-update mdi-18px"></span>: <?php echo osc_format_date(osc_item_pub_date()) ; ?>
                <span class="mdi mdi-cash-usd mdi-18px"></span>: <?php echo osc_format_price(osc_item_price()); ?>
            </p>
			</div>
<?php 
   // Load Item Information, so we could tell the user which item is he/she paying for
        $item = Item::newInstance()->findByPrimaryKey(osc_item_id());
        $category_fee = ModelRUpayments::newInstance()->getPublishPrice($item['fk_i_category_id']); 
        $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);		
              ?>
             <div class="upay_item_service">                                             
<form action="<?php echo osc_route_url('rupayments-user-payments'); ?>" name="goToPayForm<?php echo $iCount;?>" method="post">
<script language="javascript">
  function sendForm<?php echo $iCount;?>() {
    if ( $('input[name="product_type<?php echo $iCount;?>"]:checked').val() ) $('input[name="productType"]').val( $('input[name="product_type<?php echo $iCount;?>"]:checked').val() );
    else $('input[name="productType"]').val( "401" );
  
    var goToPayForm<?php echo $iCount;?> = document.forms.goToPayForm<?=$iCount;?>; 
    goToPayForm<?php echo $iCount;?>.submit();
  }
</script>
     <input type='hidden' name='itemId' value='<?php echo $item['pk_i_id']; ?>'>
     <input type='hidden' name='categoryId' value='<?php echo $item['fk_i_category_id']; ?>'> 
     <input type='hidden' name='productType' value='101'> 
     <input type='hidden' name='url_back' value='<?php print osc_base_url() .'index.php?page=custom&route=rupayments-user-menu';?>'>
<?php  {
        $bPublishFeeNeeded = false;
        if ( $category_fee && !ModelRUpayments::newInstance()->publishFeeIsPaid ( $item['pk_i_id'] ) ) {  
        $bPublishFeeNeeded = true; 
		
?>                       <div class="upay_usermenu">
                        <span class="upay_servicespan"><input type="radio" name="product_type<?php echo $iCount;?>" value="101" checked></span>
                        <?php 
            ModelRUpayments::newInstance()->printPriceLable ( $item, '101' );?>
			<span class="mdi mdi-near-me mdi-24px"></span><?php
            print ModelRUpayments::newInstance()->printPriceStr ( $item, '101' );
?></div>
<?php
        }
		}
?>

<?php
		if ( osc_get_preference ( 'allow_renew', 'rupayments' ) && $item['dt_expiration']!="9999-12-31 23:59:59" ) {
?>                       <div class="upay_usermenu">
                        <span class="upay_servicespan"><input type="radio" name="product_type<?php echo $iCount;?>" value="411"></span>
                        <?php 
            ModelRUpayments::newInstance()->printPriceLable ( $item, '411' ); ?>
			<span class="mdi mdi-autorenew mdi-24px"></span><?php 
            print ModelRUpayments::newInstance()->printPriceStr ( $item, '411' );
			if($item['dt_expiration'] <= date("Y-m-d H:i:s")){
			print "<br><span style='color: red;'>".$sTextE."</span>";
			}else{
            if ( ModelRUpayments::newInstance()->printDaysStr ( $item, '411' ) ) print "<br><span style='color: red;'>".$sTextEA." ".ModelRUpayments::newInstance()->iRenewDays." ".$sTextDays." ".ModelRUpayments::newInstance()->iRenewHours." ".$sTextHours ." ".ModelRUpayments::newInstance()->iRenewMinutes." ".$sTextMinutes."</span>";
			}
?></div>
<?php
        }
?>

<?php
        if ( osc_get_preference ( 'allow_move', 'rupayments' ) ) {
?> <div class="upay_usermenu">
  <span class="upay_servicespan"><input type="radio" name="product_type<?php echo $iCount;?>" value="401"<?php if ( !$bPublishFeeNeeded ) print " checked";?>></span>
                        <?php 
            ModelRUpayments::newInstance()->printPriceLable ( $item, '401' ); ?>
			<span class="mdi mdi-arrow-up-thick mdi-24px"></span><?php 
            print ModelRUpayments::newInstance()->printPriceStr ( $item, '401' );
?></div>
<?php
        }
?>

<?php if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])): ?>
<div class="upay_usermenu">
    <span class="upay_servicespan"><input type="radio" name="product_type<?php echo $iCount;?>" value="701"></span>
    <?php 
        ModelRUpayments::newInstance()->printPriceLable ( $item, '701' ); ?>
        <span class="mdi mdi-image mdi-24px"></span><?php 
        print ModelRUpayments::newInstance()->printPriceStr ( $item, '701' );
    ?>
</div>
<?php endif; ?>

<?php if(osc_get_preference ( '3_in_1_pack_status', 'rupayments' )): ?>
    <div class="upay_usermenu">
        <span class="upay_servicespan"><input type="radio" name="product_type<?php echo $iCount;?>" value="801"></span>
        <?php 
        ModelRUpayments::newInstance()->printPriceLable ( $item, '801' ); ?>
		<span class="mdi mdi-certificate mdi-24px"></span><?php 
        print ModelRUpayments::newInstance()->printPriceStr ( $item, '801' );
        
        if ( ModelRUpayments::newInstance()->checkPack3in1($item['pk_i_id']) == 'active' && ModelRUpayments::newInstance()->printDaysStr ( $item, '801' ) ) print "<br><span style='color: red;'>".$sText." ".ModelRUpayments::newInstance()->iPack3in1Days." ".$sTextDays." ".ModelRUpayments::newInstance()->iPack3in1Hours." ".$sTextHours." ".ModelRUpayments::newInstance()->iPack3in1Minutes." ".$sTextMinutes."</span>";
        ?>
    </div>
<?php endif; ?>

<?php
        if ( osc_get_preference ( 'allow_high', 'rupayments' ) ) { //  && !ModelRUpayments::newInstance()->colorFeeIsPaid ( $item['pk_i_id'] ) 
?>                       <div class="upay_usermenu">
                        <span class="upay_servicespan"><input type="radio" name="product_type<?php echo $iCount;?>" value="301"></span>
                        <?php 
            ModelRUpayments::newInstance()->printPriceLable ( $item, '301' ); ?>
			<span class="mdi mdi-format-color-fill mdi-24px"></span><?php 

            print ModelRUpayments::newInstance()->printPriceStr ( $item, '301' );
            
            if ( ModelRUpayments::newInstance()->colorFeeIsPaid ( $item['pk_i_id'] ) && ModelRUpayments::newInstance()->printDaysStr ( $item, '301' ) ) print "<br><span style='color: red;'>".$sText." ".ModelRUpayments::newInstance()->iColorDays." ".$sTextDays." ".ModelRUpayments::newInstance()->iColorHours." ".$sTextHours ." ".ModelRUpayments::newInstance()->iColorMinutes." ".$sTextMinutes."</span>";
?></div>
<?php
        }
        if ( osc_get_preference ( 'allow_premium', 'rupayments' ) ) { // && !ModelRUpayments::newInstance()->premiumFeeIsPaid ( $item['pk_i_id'] ) 
?><div class="upay_usermenu">
                        <span class="upay_servicespan"><input type="radio" name="product_type<?php echo $iCount;?>" value="201"></span>
                        <?php 
            ModelRUpayments::newInstance()->printPriceLable ( $item, '201' ); ?>
			<span class="mdi mdi-star mdi-24px"></span><?php 
            print ModelRUpayments::newInstance()->printPriceStr ( $item, '201' );
            
            if ( ModelRUpayments::newInstance()->premiumFeeIsPaid ( $item['pk_i_id'] ) && ModelRUpayments::newInstance()->printDaysStr ( $item, '201' ) ) print "<br><span style='color: red;'>".$sText." ".ModelRUpayments::newInstance()->iPremiumDays." ".$sTextDays." ".ModelRUpayments::newInstance()->iPremiumHours." ".$sTextHours." ".ModelRUpayments::newInstance()->iPremiumMinutes." ".$sTextMinutes."</span>"
?>
</div>

<?php } ?>

<div class="usermenu_button">
                        <button onclick="sendForm<?=$iCount;?>();"> <?php _e('Select and Pay', 'rupayments'); ?></button>
   </div> </form>
    
               
</div>     

         </div>
    <?php
        $iCount ++;
    } ?>
    <br />
    <div class="paginaterupayments">
   <?php for($i = 0 ; $i < $total_pages ; $i++) {
        if($i == $page) {
            printf('<a class="searchPaginationSelected" href="%s">%d</a>', osc_route_url('rupayments-user-menu', array('iPage' => $i)), ($i + 1));
        } else {
            printf('<a class="searchPaginationNonSelected" href="%s">%d</a>', osc_route_url('rupayments-user-menu', array('iPage' => $i)), ($i + 1));
        }
    } ?>
    </div>
<?php echo '<script src="' . osc_base_url() . 'oc-content/plugins/rupayments/admin/js/jquery.admin.js"></script>'; ?> 
<?php } ?>