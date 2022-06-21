<?php
/*
 * Copyright 2017-2020 osclass-pro.com and oslass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
  $sPayment_system = ""; 
  $sDescription = ""; 
  $sSite_title = "";
  $iItemID = 0;
  $sPrice = "";
  $sCurrency = "";
  $sUrl_back = "";
  $sProductType = ""; 
  
  // В сессии сохраняется во вспомогательных целях
  if ( Params::getParam("price") > 0 ) {
      $sPrice = Params::getParam("price");
      Session::newInstance()->_set("payment_price", $sPrice);
  }
  
  $sCurrency = osc_get_preference ( "currency", "rupayments" );
  if ( Params::getParam("site_title") > "" ) {
      $sSite_title = Params::getParam("site_title");



      Session::newInstance()->_set("payment_site_title", $sSite_title);
  }
  
  // В случае покупки кредитов, itemID может не передаваться
  if ( Params::getParam("itemID") > 0 ) {
      $iItemID = Params::getParam("itemID");
      Session::newInstance()->_set("payment_itemID", $iItemID);
  }
  $iItemID = Session::newInstance()->_get("payment_itemID");
  /**
  if ( $fp = fopen ( RUPAYMENTS_PATH."log/test_ps.txt", "a" ) ) {
       $text = date('Y-m-d H:i:s')." - ".Params::getParam("itemID") ." - getParam; ".Session::newInstance()->_get("payment_itemID")." - Session; ".$iItemID." - iItemID; stript str 20 \r\n";
       fwrite($fp, $text, 10000);
       fclose($fp);
  }  */
  
  if ( Params::getParam("description") > "" ) {
      $sDescription = Params::getParam("description");
      Session::newInstance()->_set("payment_description", $sDescription);
  }
  
    $sUrl_back = Params::getParam("url_back");
  
  if ( Params::getParam("product_type") > "" ) {
      $sProductType = Params::getParam("product_type");
      Session::newInstance()->_set("payment_product_type", $sProductType);
  }

  // Запоминаем значение payment_system, если получена
  if ( Params::getParam("payment_system") > "" ) {
      $sPayment_system = Params::getParam("payment_system");
      Session::newInstance()->_set ( "payment_system", $sPayment_system); 
  }
   

  // Устанавливаем значение payment_system
  if ( Session::newInstance()->_get("payment_system") > "" ) $sPayment_system = Session::newInstance()->_get("payment_system");
  $sTopHtml = ' 
  <div class="custompaument">
  <h2>'. __('Payment of the order with', 'rupayments').' <span style="color: red;">'.$sPayment_system.'</span></h2>
  <div style="margin: 20px 0 15px 0;"><b>'. __('Your order', 'rupayments').':</b> '.$sDescription.'</div> 
  <div style="margin: 15px 0 20px 0;"><b>'. __('Price of the order', 'rupayments').':</b> '.$sPrice.' '.$sCurrency.'</div>
  ';
                                 
  ?>  
     </div> 