<?php
/*
 * Copyright 2017 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */ 
    
 	$item = Item::newInstance()->findByPrimaryKey(Params::getParam('itemId')); 
	if ( osc_get_preference('allow_itempost_form', 'rupayments')==1 ) {
	   if(osc_get_preference('pay_per_show_image_status', 'rupayments')) ModelRUpayments::newInstance()->setImageShow(Params::getParam('itemId'), 0);
	ModelRUpayments::newInstance()->isPublishPaymentNeedednext ( $item );
	}
   $iProductType = Params::getParam('productType'); 
	if ( $iProductType == '001' ) {
        if(osc_get_preference('pay_per_show_image_status', 'rupayments')) ModelRUpayments::newInstance()->setImageShow(Params::getParam('itemId'), 0);

        if(osc_moderate_items() != -1) osc_add_flash_ok_message( _m('Check your inbox to validate your listing') );
        
        rupayments_js_redirect_to(osc_base_url());
    }
if ( $item = Item::newInstance()->findByPrimaryKey(Params::getParam('itemId')) ) { 
    
    //$category_fee = ModelRUpayments::newInstance()->getPublishPrice($item['fk_i_category_id']);

  
    // Load Item Information, so we could tell the user which item is he/she paying for
    $iItemID = Params::getParam('itemId'); 
	if (osc_get_preference ('allow_itempost_form', 'rupayments') == 1 ){
	$iCategoryId = $item['fk_i_category_id'];	
	}else {		
    $iCategoryId = Params::getParam('categoryId');
	}	
    $sUrlBack = osc_route_url ( Params::getParam('url_back'), array ( 'itemId' => $iItemID ) );
    $sLable = '';
    $sImage = '' ;		
//print Params::getParam('url_back')." - ".$sUrlBack." - <br>";  
  // Ограничиваем показ ссылок Back определенными страницами
    $bShowUrlBack = false; 
    if ( Params::getParam('url_back') == 'rupayments-publish' ) $bShowUrlBack = true;
    if ( mb_stristr ( Params::getParam('url_back'), osc_base_url() ) ) {
        $bShowUrlBack = true;
        $sUrlBack =  Params::getParam('url_back');
    }
                       
    $iPrice = ModelRUpayments::newInstance()->calculatePrice ( $iProductType, $iCategoryId, $item );
  
    $wallet = ModelRUpayments::newInstance()->getWallet(osc_logged_user_id());
    $amount = isset ( $wallet['i_amount'] ) ? $wallet['i_amount'] : 0;
    if ( $amount != 0 ) {
        //$formatted_amount = osc_format_price($amount, osc_get_preference('currency', 'rupayments')); // /1000000
		if(osc_get_preference ( "currency", "rupayments" )=='BTC'){ 
			$amount2=number_format($amount,8);
		}else{
			$amount2=round($amount,2);
		}
        $credit_msg = sprintf(__('Your current credit is %s %s', 'rupayments'), $amount2, osc_get_preference ( "currency", "rupayments" ));
        //$formatted_amount = osc_format_price($amount/1000000, osc_get_preference('currency', 'rupayments'));
        //$credit_msg = sprintf(__('Wallet: Your current credit is %s', 'rupayments'), $formatted_amount);
    } else {
        $credit_msg = __('Your wallet is empty.', 'rupayments');
    }
    
    // Требуется для показа в некоторых платежных системах
    $sSite_title = mb_eregi_replace ( "http://", "", osc_base_url() );
    $sSite_title = " ".mb_eregi_replace ( "/", "", $sSite_title );
    $mnu = osc_base_url();
    $sDescription = "";
    if ( $iProductType == '101' ) {
        $sDescription = __('Publish Item','rupayments');
        $sLable = __('Publish fee for item %d','rupayments');
        $s2CoType = "4";
        $sImage = '<span class="mdi mdi-near-me mdi-36px"></span>' ;			
    }
    else if ( $iProductType == '201' ) {
        
        if ( !ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) || ModelRUpayments::newInstance()->publishFeeIsPaid ( $iItemID )) {
            $sDescription = __('Make Item Premium', 'rupayments');
            $sLable = __( 'Premium fee for item %d', 'rupayments' ); 
			$sImage = '<span class="mdi mdi-star mdi-36px"></span>' ;
        }
        else {
            
	    $sDescription = __('Publish and Make Item Premium', 'rupayments');
            $sLable = __( 'Publish and Premium fee for item %d', 'rupayments' ); 
			$sImage = '<span class="mdi mdi-near-me mdi-36px"></span><span class="mdi mdi-star mdi-36px"></span>' ;
        }
        
        $s2CoType = "1";
		
    }  
    else if ( $iProductType == '301' ) {
        
        if ( !ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) || ModelRUpayments::newInstance()->publishFeeIsPaid ( $iItemID )) {
            $sDescription = __('Make Item Highlighted', 'rupayments');
            $sLable = __( 'Highlighted fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-format-color-fill mdi-36px"></span>' ;
        }
        else {
             
	    $sDescription = __('Publish and Make Item Highlighted', 'rupayments');
            $sLable = __( 'Publish and Highlighted fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-near-me mdi-36px"></span><span class="mdi mdi-format-color-fill mdi-36px"></span>' ;
        }
        
        $s2CoType = "3";

    }
    else if ( $iProductType == '701' ) {
        
        if ( !ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) || ModelRUpayments::newInstance()->publishFeeIsPaid ( $iItemID )) {
            $sDescription = __('Show Image', 'rupayments');
            $sLable = __( 'Show Image fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-image mdi-36px"></span>' ;
        }
        else {
             
	    $sDescription = __('Publish and Show Image', 'rupayments');
            $sLable = __( 'Publish and Show Image fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-near-me mdi-36px"></span><span class="mdi mdi-image mdi-36px"></span>' ;
        }
        
        $s2CoType = "10";

    }
    else if ( $iProductType == '711' ) {
        
        if ( !ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) || ModelRUpayments::newInstance()->publishFeeIsPaid ( $iItemID )) {
            $sDescription = __('Make Item Premium and Show Image', 'rupayments');
            $sLable = __( 'Make Item Premium and Show Image fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-star mdi-36px"></span><span class="mdi mdi-image mdi-36px"></span>' ;
        }
        else {
             
	    $sDescription = __('Publish, Make Item Premium and Show Image', 'rupayments');
            $sLable = __( 'Publish, Make Item Premium and Show Image fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-near-me mdi-36px"></span><span class="mdi mdi-star mdi-36px"></span><span class="mdi mdi-image mdi-36px"></span>' ;
        }
        
        $s2CoType = "11";

    }
    else if ( $iProductType == '721' ) {
        
        if ( !ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) || ModelRUpayments::newInstance()->publishFeeIsPaid ( $iItemID )) {
            $sDescription = __('Make Item Highlighted and Show Image', 'rupayments');
            $sLable = __( 'Make Item Highlighted and Show Image fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-format-color-fill mdi-36px"></span><span class="mdi mdi-image mdi-36px"></span>' ;
        }
        else {
             
	    $sDescription = __('Publish, Make Item Highlighted and Show Image', 'rupayments');
            $sLable = __( 'Publish, Make Item Highlighted and Show Image fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-near-me mdi-36px"><span class="mdi mdi-format-color-fill mdi-36px"></span></span><span class="mdi mdi-image mdi-36px"></span>' ;
        }
        
        $s2CoType = "12";

    }
    else if ( $iProductType == '731' ) {
        
        if ( !ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) || ModelRUpayments::newInstance()->publishFeeIsPaid ( $iItemID )) {
            $sDescription = __('Make Item Premium, Make Item Highlighted and Show Image', 'rupayments');
            $sLable = __( 'Make Item Premium, Make Item Highlighted and Show Image fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-star mdi-36px"></span><span class="mdi mdi-format-color-fill mdi-36px"></span><span class="mdi mdi-image mdi-36px"></span>' ;
        }
        else {
             
	    $sDescription = __('Publish, Make Item Premium, Make Item Highlighted and Show Image', 'rupayments');
            $sLable = __( 'Publish, Make Item Premium, Make Item Highlighted and Show Image fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-near-me mdi-36px"></span><span class="mdi mdi-star mdi-36px"></span><span class="mdi mdi-format-color-fill mdi-36px"></span><span class="mdi mdi-image mdi-36px"></span>' ;
        }
        
        $s2CoType = "13";

    }
    else if ( $iProductType == '801' ) {
        
        if ( !ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) || ModelRUpayments::newInstance()->publishFeeIsPaid ( $iItemID )) {
            $sDescription = __('Apply: Pack 3-in-1', 'rupayments');
            $sLable = __( 'Apply: Pack 3-in-1 fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-certificate mdi-36px"></span>' ;
        }
        else {
             
	    $sDescription = __('Publish and apply: Pack 3-in-1', 'rupayments');
            $sLable = __( 'Publish and apply: Pack 3-in-1 fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-near-me mdi-36px"></span><span class="mdi mdi-certificate mdi-36px"></span>' ;
        }
        
        $s2CoType = "14";

    }
    else if ( $iProductType == '811' ) {
        
        if ( !ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) || ModelRUpayments::newInstance()->publishFeeIsPaid ( $iItemID )) {
            $sDescription = __('Activate Show Image and apply: Pack 3-in-1', 'rupayments');
            $sLable = __( 'Activate Show Image and apply: Pack 3-in-1 fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-image mdi-36px"></span><span class="mdi mdi-certificate mdi-36px"></span>' ;
        }
        else {
             
	    $sDescription = __('Publish, activate Show Image and apply: Pack 3-in-1', 'rupayments');
            $sLable = __( 'Publish, activate Show Image and apply: Pack 3-in-1 fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-near-me mdi-36px"></span><span class="mdi mdi-image mdi-36px"></span><span class="mdi mdi-certificate mdi-36px"></span>' ;
        }
        
        $s2CoType = "15";

    }
    else if ( $iProductType == '231' ) {
        $sAddon = "";                                    
        
        if ( !ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID )  || ModelRUpayments::newInstance()->publishFeeIsPaid ( $iItemID )) {
			$sDescription = __('Make Item Highlighted and Premium', 'rupayments') .$sAddon;
            $sLable = __( 'Premium and Highlighted fee for item %d', 'rupayments' );
        $sImage = '<span class="mdi mdi-star mdi-36px"></span><span class="mdi mdi-format-color-fill mdi-36px"></span>' ;
        }
        else {
            $sDescription = __('Publish and Make Item Highlighted and Premium', 'rupayments') .$sAddon;
            $sLable = __( 'Publish, Premium and Highlighted fee for item %d', 'rupayments' );
			$sImage = '<span class="mdi mdi-near-me mdi-36px"></span><span class="mdi mdi-star mdi-36px"></span><span class="mdi mdi-format-color-fill mdi-36px"></span>' ;
        }
        $s2CoType = "9";
		
    }
    else if ( $iProductType == '401' ) {
        $sDescription = __('Move Item to TOP','rupayments');
        $sLable = __( 'Move to TOP fee for item %d', 'rupayments' );
        $s2CoType = "2";
		$sImage = '<span class="mdi mdi-arrow-up-thick mdi-36px"></span>' ;
    }
	else if ( $iProductType == '411' ) {
        $sDescription = __('Renew Item','rupayments');
        $sLable = __( 'Renew fee for item %d', 'rupayments' );
        $s2CoType = "21";
		$sImage = '<span class="mdi mdi-autorenew mdi-36px"></span>' ;
    }
    
    if ( $bShowUrlBack ) print "<a href='".$sUrlBack."'>".__('Back', 'rupayments')."</a>";
    View::newInstance()->_exportVariableToView('item', Item::newInstance()->findByPrimaryKey($iItemID));	
?>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">   
<script type="text/javascript" src="https://do-mos.ru/oc-content/plugins/rupayments/js/ultimate.js"></script>
<script type="text/javascript" src="https://use.fontawesome.com/af830f475b.js" async defer></script>
<div class="upay_item" id="ollpaysystem">
<div class="upay_item_info">
            <h3><a href="<?php echo osc_item_url(); ?>"><?php echo osc_highlight( strip_tags( osc_item_title() ),25 ); ?></a></h3>
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
   <div class="upay_item_service"> 			
       <h2 class="uservicepayh2"><?php print __( "Your choice is:", "rupayments" )." ".$sDescription." ".$sImage."";  ?></h2>
	   <h2 class="uservicepayh2"><?php print __( "Price:", "rupayments" )." <span class='uservicepay'>".$iPrice." ".osc_get_preference('currency', 'rupayments')."</span>";  ?></h2>
       <h3 class="uservicepayh3"><?php echo $credit_msg; ?></h3>  
<?php  // wallet 
//exit($category_fee);
    if(osc_is_web_user_logged_in()) {     
        //  
        if ( isset ( $wallet['formatted_amount'] ) && (bccomp($wallet['formatted_amount'],$iPrice,8)==1|| bccomp($wallet['formatted_amount'],$iPrice,8)==0) ) {
            print "<div>";
            wallet_button($iPrice, $sDescription, $iProductType."x".$item['fk_i_category_id']."x".$item['pk_i_id'], array('user' => $item['fk_i_user_id'], 'itemid' => $item['pk_i_id'], 'email' => $item['s_contact_email'] ) );
            print "</div>";
        } else { ?>
       <div></div> 
<?php        
        }
    }
?>           
       <h3 style="margin-top: 2em;"><?php _e( "You can pay with:", "rupayments" );  ?></h3>
       
       
<?php   // paypal
        if ( osc_get_preference("paypal_enabled", "rupayments") == 1 ) { ?>
		<div class="upay_payments">
		<?php Paypal::button( $iPrice, sprintf ( $sLable, $iItemID, $iPrice, osc_get_preference ( "currency", "rupayments" ), osc_page_title() ), $iProductType."x".$iCategoryId."x".$iItemID, array ( 'user' => @$item['fk_i_user_id'], 'itemid' => @$iItemID, 'email' => @$item['s_contact_email'] ) ); ?>
  </div>
<?php }
        if ( osc_get_preference("co2_enabled", "rupayments") == 1 ) {?>
		<div class="upay_payments">
		<?php ModelChekout::button( $iPrice, sprintf ( $sLable, $iItemID, $iPrice, osc_get_preference ( "currency", "rupayments" ), osc_page_title() ), $iItemID, $item['fk_i_user_id'], $s2CoType, __("Add funds", "rupayments"), 0 ); ?>
       </div>
<?php  } // blockchain
        if ( osc_get_preference("blockchain_enabled", "rupayments") == 1 )  {?>
		         <div class="upay_payments">
		<?php Modelblockchain::button( $iPrice, sprintf ( $sLable, $iItemID, $iPrice, osc_get_preference ( "currency", "rupayments" ), osc_page_title() ), $iItemID, $item['fk_i_user_id'], $s2CoType, __("Add funds", "rupayments"), 0 ); ?>  
      </div>
<?php  } 
        if ( osc_get_preference("interkassa_enabled", "rupayments") == 1 ) {?>
			       <div class="upay_payments">   
		<?php Interkassa::button ( $item['s_contact_email'], $iPrice, $iProductType, $iItemID, $sDescription, $sSite_title ); ?>
			    </div>			   
<?php     
        } if ( osc_get_preference("lp_enabled", "rupayments") == 1 ) { ?>		
        <div class="upay_payments">
<?php Liqpay::button ( $item['s_contact_email'], $iPrice, $iProductType, $iItemID, $sDescription, $sSite_title ); ?>
		</div>
		 <?php  }  
        if ( osc_get_preference("robokassa_enabled", "rupayments") == 1 ) {?>		
       <div class="upay_payments">
<?php Robokassa::button ( $item['s_contact_email'], $iPrice, $iProductType, $iItemID, $sDescription, $sSite_title ); ?>
		 </div>
		 <?php  } 
        if ( osc_get_preference("wo_enabled", "rupayments") == 1 ) {?>
			<div class="upay_payments">
	<?php Walletone::button ( $item['s_contact_email'], $iPrice, $iProductType, $iItemID, $sDescription, $sSite_title ); ?>
       </div>                                                                            
<?php } 
        if ( osc_get_preference("payeer_enabled", "rupayments") == 1 ) {?>		
       <div class="upay_payments">
<?php Payeer::button ( $item['s_contact_email'], $iPrice, $iProductType, $iItemID, $sDescription, $sSite_title ); ?>
		 </div>
		 <?php  } 
		         if ( osc_get_preference("freekassa_enabled", "rupayments") == 1 ) {?>
			       <div class="upay_payments">   
		<?php Freekassa::button ( $item['s_contact_email'], $iPrice, $iProductType, $iItemID, $sDescription, $sSite_title ); ?>
			    </div>			   
<?php     
        } ?>  
<?php     
        if ( osc_get_preference("yandex_enabled", "rupayments") == 1 ) {?>
		       <div class="upay_payments">
<?php Yandex::button ( $item['s_contact_email'], $iPrice, $iProductType, $iItemID, $sDescription, 0 ); ?>
			          </div>
<?php     
        }    
?>
 <?php 
		         if ( osc_get_preference("webmoney_enabled", "rupayments") == 1 ) {?>
			       <div class="upay_payments">   
		<?php Webmoney::button ( $item['s_contact_email'], $iPrice, $iProductType, $iItemID, $sDescription, $sSite_title ); ?>
			    </div>			   
<?php     
        } ?> 

       
 
	   </div></div> 
       <div style="clear: both;"></div>
       <div name="result_div" id="result_div"></div>
<script type="text/javascript">
    var rd = document.getElementById("result_div");
</script>

<?php
}
// Если страница вызвана не штатно (без параметра itemId) 
else {
    // Ничего не делаем
} 
?>