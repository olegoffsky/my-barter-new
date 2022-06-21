<?php
/*
 * Copyright 2018 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

    function rupayments_path () {
        return osc_base_path() . 'oc-content/plugins/' . osc_plugin_folder(__FILE__);
    }

    function rupayments_url () {
        return osc_base_url() . 'oc-content/plugins/' . osc_plugin_folder(__FILE__);
    }

  //  function ppaypal_crypt ($string)
   // {
   //     $cypher = MCRYPT_RIJNDAEL_256;
    //    $mode = MCRYPT_MODE_ECB;
     //   return base64_encode(mcrypt_encrypt($cypher, PAYMENT_CRYPT_KEY, $string, $mode,
     //       mcrypt_create_iv(mcrypt_get_iv_size($cypher, $mode), MCRYPT_RAND)
      //      ));
    //}

   // function ppaypal_decrypt ($string)
    //{
     //   $cypher = MCRYPT_RIJNDAEL_256;
      //  $mode = MCRYPT_MODE_ECB;
      //  return str_replace("\0", "", mcrypt_decrypt($cypher, PAYMENT_CRYPT_KEY,  base64_decode($string), $mode,
      //      mcrypt_create_iv(mcrypt_get_iv_size($cypher, $mode), MCRYPT_RAND)
      //      ));
   // }


    function ppaypal_prepare_custom ( $extra_array = null ) {
        
        if($extra_array!=null) {
            if(is_array($extra_array)) {
                $extra = '';
                foreach($extra_array as $k => $v) {
                    $extra .= $k.",".$v."|";
                }
            } else {
                $extra = $extra_array;
            }
        } else {
            $extra = "";
        }
        return $extra;
    }

    function ppaypal_get_custom ($custom) {
        
        $tmp = array();
        if(preg_match_all('@\|?([^,]+),([^\|]*)@', $custom, $m)){
            $l = count($m[1]);
            for($k=0;$k<$l;$k++) {
                $tmp[$m[1][$k]] = $m[2][$k];
            }
        }
        return $tmp;
    }
	
    function rupayments_prepare_custom ( $extra_array = null ) {
        
        if($extra_array!=null) {
            if(is_array($extra_array)) {
                $extra = '';
                foreach($extra_array as $k => $v) {
                    $extra .= $k.",".$v."|";
                }
            } else {
                $extra = $extra_array;
            }
        } else {
            $extra = "";
        }
        return $extra;
    }

    function rupayments_get_custom ($custom) {
        
        $tmp = array();
        if(preg_match_all('@\|?([^,]+),([^\|]*)@', $custom, $m)){
            $l = count($m[1]);
            for($k=0;$k<$l;$k++) {
                $tmp[$m[1][$k]] = $m[2][$k];
            }
        }
        return $tmp;
    }
    

    /**
     * Create and print a "Wallet" button
     *
     * @param float $amount
     * @param string $description
     * @param string $rpl custom variables
     * @param string $itemnumber (publish fee, premium, pack and which category)
     */
    function wallet_button ( $amount = '0.00', $description = '', $itemnumber = '101', $extra_array = '||' ) {
		$main = osc_base_url();
        $extra = rupayments_prepare_custom($extra_array);
        $extra .= 'concept,'.$description.'|';
        $extra .= 'product,'.$itemnumber.'|';

        print '<a class="wallet udisbutton" href="'.$main.'index.php?page=custom&route=rupayments-wallet&a='.$amount.'&desc='.$description.'&extra='.$extra.'">';_e( "Pay with credit", "rupayments" );print '</a>';
        // print '<a href="'.osc_route_url('rupayments-wallet', array('a' => $amount, 'desc' => $description, 'extra' => $extra)).'"><input type="image" title="Pay with your credit" style="width: 127px; height: 50px; border:none;" src="'.osc_base_url().'oc-content/plugins/rupayments/payments/wallet.png" /></a>';
    }

    /**
     * Redirect to function via JS
     *
     * @param string $url
     */
    function rupayments_js_redirect_to ( $url ) { ?>
        <script type="text/javascript">
            window.top.location.href = "<?php echo $url; ?>";
        </script>
    <?php }

    /**
     * Send email to un-registered users with rupayments options
     *
     * @param array $item
     * @param array $user
     * @param string $sCommand
     * @param string $iProductType (number as string)
     * @param string $sUserType
     */ 
    function rupayments_send_email ( $item, $user, $sCommand, $iProductType ) {   
        if($sCommand == 'admin_send') {
            if($iProductType == '901') {
                $item = array();                        
                $item['s_contact_name'] = osc_logged_user_name(); 
            }
                       
            $item['s_contact_email'] = osc_get_preference('contactEmail', 'osclass');
        }
                        
        if ( !isset ( $item['s_contact_email'] ) && !isset ( $user['s_email'] ) ) {  
            return false;
        }
        
        // Электоронки с предложением оплаты после публикации    
        if ( $sCommand == 'offer' ) {        
            
            // Объявление опубликовано
            if ( $iProductType == '101' ) {
                // И надо платить
                if ( ModelRUpayments::newInstance()->isPublishPaymentNeeded ( $item ) ) {
                    $sPattern = 'email_rupayments_offer_one';
                }
                // Платить не надо
                else {
                    if ( !osc_get_preference('allow_after','rupayments') ) $sPattern = 'email_rupayments_offer_two_not_allow_after'; 
                    else $sPattern = 'email_rupayments_offer_two'; 
                }
            }
            else  {
                if ( !osc_get_preference('allow_after','rupayments') ) $sPattern = 'email_rupayments_offer_three_not_allow_after'; 
                else $sPattern = 'email_rupayments_offer_three'; 
                          
            } 
            rupayments_send_email_offer ( $item, $user, $sPattern, $iProductType );          
        }
        // Электоронки от cron с уведомлением и предложением оплаты 
        else if ( $sCommand == 'alert' ) { 
            
            if ( $iProductType == '201' || $iProductType == '202' ) $sPattern = 'email_rupayments_alert_Premium'; // $sService = "Primium";
            if ( $iProductType == '301' || $iProductType == '302' ) $sPattern = 'email_rupayments_alert_Colorized'; // $sService = "Colorized";
            if ( $iProductType == '411' ) $sPattern = 'email_rupayments_alert_renew'; // $sService = "Colorized"; 			
            // Если истекают одновременно 
            if ( $iProductType == '231' || $iProductType == '232' ) $sPattern = 'email_rupayments_alert_Primium_and_Colorized'; // $sService = "Premium and Colorized"; 
            if ( $iProductType == '601' ) $sPattern = 'email_rupayments_membership_expired'; // Membership plan expires
            if ( $iProductType == '902' ) $sPattern = 'email_rupayments_banner_accepted'; // Banner Accepted
            if ( $iProductType == '903' ) $sPattern = 'email_rupayments_banner_no_funding'; // Banner No Funding
            if ( $iProductType == '1001' ) $sPattern = 'email_rupayments_user_ebuy_purchase'; // User eBuy Deal (purchase)
            
            rupayments_send_email_alert ( $item, $user, $sPattern, $iProductType );
        }
        // Электоронки с уведомлением юзера об изменении статуса его объявления
        // или Wallet по воле админа 
        else if ( $sCommand == 'admin' ) {
            
            //$sService = ''; 
            if ( $iProductType == '101' ) $sPattern = 'email_rupayments_admin_made_Published'; //  $sService = 'Published';
            else if ( $iProductType == '201' || $iProductType == '202' ) $sPattern = 'email_rupayments_admin_made_Premium'; //  $sService = __( 'made Premium', 'rupayments' );
            else if ( $iProductType == '231' || $iProductType == '232' ) $sPattern = 'email_rupayments_admin_made_Premium_Colorized';  // $sService = __( 'made Premium and Colorized', 'rupayments' );
            else if ( $iProductType == '301' || $iProductType == '302' ) $sPattern = 'email_rupayments_admin_made_Colorized';  // $sService = __( 'made Colorized', 'rupayments' );
            else if ( $iProductType == '401' ) $sPattern = 'email_rupayments_admin_moved_to_Top'; // $sService = __( 'moved to Top', 'rupayments' );
			else if ( $iProductType == '411' ) $sPattern = 'email_rupayments_admin_renew';
            
            if ( $iProductType == '501' ) {
                $sPattern = 'email_rupayments_admin_filled_up_Credit_Pack_1';
            }
            else if ( $iProductType == '502' ) {
                $sPattern = 'email_rupayments_admin_filled_up_Credit_Pack_2'; 
            }
            else if ( $iProductType == '503' ) {
                $sPattern = 'email_rupayments_admin_filled_up_Credit_Pack_3'; 
            }
            
            rupayments_send_email_admin ( $item, $user, $sPattern, $iProductType ); 
        }
        else if ($sCommand == 'admin_send') {
            if ( $iProductType == '901' ) $sPattern = 'email_rupayments_admin_banner_added'; // Banner Added
            if ( $iProductType == '1001' ) $sPattern = 'email_rupayments_admin_ebuy_purchase'; // Admin eBuy Deal (purchase)
            
            rupayments_send_email_admin_to ( $item, $user, $sPattern, $iProductType ); 
        }
        else exit();
         
    }
    
    function rupayments_send_email_offer ( $item, $user, $sPattern, $iProductType  ) {
        
        // Устананвливаем требуемые параметры
        $sCommand = "offer";
        
        // Устананвливаем требуемые параметры
        $mPages = new Page () ;
        $aPage = $mPages->findByInternalName ( $sPattern  ) ;
        $locale = osc_current_user_locale() ;
        
        global $content;
        global $words;
        
        $content = array();
        
        if(isset($aPage['locale'][$locale]['s_title'])) {
            $content = $aPage['locale'][$locale];
        } else {
            $content = current($aPage['locale']);
        }

        $item_url    = osc_item_url( ) ;
        $item_url    = '<a href="' . $item_url . '" >' . $item_url . '</a>';
        $emailpayment_url = osc_route_url('rupayments-emailpayment', array ( 'itemId' => $item['pk_i_id'], 
                                                                            'cmd' => $sCommand, 
                                                                            'prodType' => $iProductType ) );
        
                                                    
        $words   = array();
        $words[] = array('{ITEM_ID}', '{CONTACT_NAME}', '{CONTACT_EMAIL}', '{WEB_URL}', '{ITEM_TITLE}',
            '{ITEM_URL}', '{WEB_TITLE}', '{EMAILPAYMENT_LINK}', '{EMAILPAYMENT_URL}', '{DAYS_BEFOR_DEADLINE}' );
              
        if ( isset ( $item['s_contact_email'] ) )     
            $words[] = array ( $item['pk_i_id'], $item['s_contact_name'], $item['s_contact_email'], 
                               osc_base_url(), $item['s_title'], $item_url, osc_page_title(), 
                               '<a href="' . $emailpayment_url . '">' . $emailpayment_url . '</a>', 
                               $emailpayment_url, '' ) ;
        else     
            $words[] = array ( $item['pk_i_id'], $user['s_name'], $user['s_email'], 
                               osc_base_url(), '', $item_url, osc_page_title(), 
                               '<a href="' . $emailpayment_url . '">' . $emailpayment_url . '</a>', 
                               $emailpayment_url, '' ) ;
        
        include ( "function_email_inc.php" );  
    }
    
    function rupayments_send_email_alert ( $item, $user, $sPattern, $iProductType ) {
        
        // Устананвливаем требуемые параметры
        $sCommand = "alert";
        
        // Устананвливаем требуемые параметры
        $mPages = new Page () ;
        $aPage = $mPages->findByInternalName ( $sPattern  ) ;
        $locale = osc_current_user_locale() ;
        
        global $content;
        global $words;
        
        $content = array();
        
        if(isset($aPage['locale'][$locale]['s_title'])) {
            $content = $aPage['locale'][$locale];
        } else {
            $content = current($aPage['locale']);
        }

        $item_url    = osc_item_url( ) ;
        $item_url    = '<a href="' . $item_url . '" >' . $item_url . '</a>';
        $emailpayment_url = osc_route_url('rupayments-emailpayment', array ( 'itemId' => $item['pk_i_id'], 
                                                                            'cmd' => $sCommand, 
                                                                            'prodType' => $iProductType ) );
                                                                            
        if(!isset($item['s_title'])) $item['s_title'] = '';
                                                                            
        if(osc_rewrite_enabled()) {
            $banner_payment_url = osc_base_url() . 'rupayments/banner-pay/' . $item['pk_i_id'];
        }
        else {
            $banner_payment_url = osc_route_url('rupayments-banner-pay', array('bid' => $item['pk_i_id']));
        }
        
        $membership_payment_url = osc_route_url('rupayments-user-membership');
                                                    
        $words   = array();
        $words[] = array('{ITEM_ID}', '{CONTACT_NAME}', '{CONTACT_EMAIL}', '{WEB_URL}', '{ITEM_TITLE}',
            '{ITEM_URL}', '{WEB_TITLE}', '{EMAILPAYMENT_LINK}', '{EMAILPAYMENT_URL}', '{DAYS_BEFOR_DEADLINE}', '{BANNER_PAY_URL}', '{MEMBERSHIP_PAY_LINK}' );
        
        if ( isset ( $item['s_contact_email'] ) )     
            $words[] = array ( $item['pk_i_id'], $item['s_contact_name'], $item['s_contact_email'], 
                               osc_base_url(), $item['s_title'], $item_url, osc_page_title(), 
                               '<a href="' . $emailpayment_url . '">' . $emailpayment_url . '</a>', 
                               $emailpayment_url,  osc_get_preference ( 'days_before_deadline_for_sending_email', 'rupayments' ), '<a href="' . $banner_payment_url . '">' . $banner_payment_url . '</a>', '<a href="' . $membership_payment_url . '">' . $membership_payment_url . '</a>' ) ;
        else     
            $words[] = array ( $item['pk_i_id'], $user['s_name'], $user['s_email'], 
                               osc_base_url(), '', $item_url, osc_page_title(), 
                               '<a href="' . $emailpayment_url . '">' . $emailpayment_url . '</a>', 
                               $emailpayment_url,  osc_get_preference ( 'days_before_deadline_for_sending_email', 'rupayments' ) ) ;
        
        include ( "function_email_inc.php" );  
    }
    
    function rupayments_send_email_admin ( $item, $user, $sPattern, $iProductType ) {
        
        // Устананвливаем требуемые параметры
        $sCommand = "admin";
        
        // Устананвливаем требуемые параметры
        $mPages = new Page () ;
        $aPage = $mPages->findByInternalName ( $sPattern  ) ;
        $locale = osc_current_user_locale() ;
        
        global $content;
        global $words;
        
        $content = array();
        
        if(isset($aPage['locale'][$locale]['s_title'])) {
            $content = $aPage['locale'][$locale];
        } else {
            $content = current($aPage['locale']);
        }

        $item_url    = osc_item_url( ) ;
        $item_url    = '<a href="' . $item_url . '" >' . $item_url . '</a>';
        $emailpayment_url = osc_route_url('rupayments-emailpayment', array ( 'itemId' => $item['pk_i_id'], 
                                                                            'cmd' => $sCommand, 
                                                                            'prodType' => $iProductType ) );
                                                    
        $words   = array();
        $words[] = array('{ITEM_ID}', '{CONTACT_NAME}', '{CONTACT_EMAIL}', '{WEB_URL}', '{ITEM_TITLE}',
            '{ITEM_URL}', '{WEB_TITLE}', '{EMAILPAYMENT_LINK}', '{EMAILPAYMENT_URL}', '{DAYS_BEFOR_DEADLINE}' );
        
        if ( isset ( $item['s_contact_email'] ) )     
            $words[] = array ( $item['pk_i_id'], $item['s_contact_name'], $item['s_contact_email'], 
                               osc_base_url(), $item['s_title'], $item_url, osc_page_title(), 
                               '<a href="' . $emailpayment_url . '">' . $emailpayment_url . '</a>', 
                               $emailpayment_url, '' ) ;
        else     
            $words[] = array ( $item['pk_i_id'], $user['s_name'], $user['s_email'], 
                               osc_base_url(), '', $item_url, osc_page_title(), 
                               '<a href="' . $emailpayment_url . '">' . $emailpayment_url . '</a>', 
                               $emailpayment_url, '' ) ;
        
        include ( "function_email_inc.php" );  
    }
    
    function rupayments_send_email_admin_to ( $item, $user, $sPattern, $iProductType ) {
        // Устананвливаем требуемые параметры
        $sCommand = "admin_send";

        // Устананвливаем требуемые параметры
        $mPages = new Page () ;
        $aPage = $mPages->findByInternalName ( $sPattern  ) ;
        $locale = osc_current_user_locale() ;
        
        global $content;
        global $words;
        
        $content = array();
        
        if(isset($aPage['locale'][$locale]['s_title'])) {
            $content = $aPage['locale'][$locale];
        } else {
            $content = current($aPage['locale']);
        }

        $item_url    = osc_item_url( ) ;
        $item_url    = '<a href="' . $item_url . '" >' . $item_url . '</a>';
        $emailpayment_url = osc_route_url('rupayments-emailpayment', array ( 'itemId' => $item['pk_i_id'], 
                                                                            'cmd' => $sCommand, 
                                                                            'prodType' => $iProductType ) );
        
        if(!isset($item['s_title'])) $item['s_title'] = '';
                                                    
        $words   = array();
        $words[] = array('{ITEM_ID}', '{CONTACT_NAME}', '{CONTACT_EMAIL}', '{WEB_URL}', '{ITEM_TITLE}',
            '{ITEM_URL}', '{WEB_TITLE}', '{EMAILPAYMENT_LINK}', '{EMAILPAYMENT_URL}', '{DAYS_BEFOR_DEADLINE}' );
            
        $words[] = array ( $item['pk_i_id'], $item['s_contact_name'], $item['s_contact_email'], 
                               osc_base_url(), $item['s_title'], $item_url, osc_page_title(), 
                               '<a href="' . $emailpayment_url . '">' . $emailpayment_url . '</a>', 
                               $emailpayment_url,  osc_get_preference ( 'days_before_deadline_for_sending_email', 'rupayments' ) ) ;
                               
        
        $words[] = array ( $item['pk_i_id'], $user['s_name'], $user['s_email'], 
                               osc_base_url(), '', $item_url, osc_page_title(), 
                               '<a href="' . $emailpayment_url . '">' . $emailpayment_url . '</a>', 
                               $emailpayment_url, '' ) ;
        
        include ( "function_email_inc.php" ); 
    }
	
	function rupayments_regbonus_email($userId, $amount) {
	
	$mPages = new Page() ;
	$aPage = $mPages->findByInternalName('rupayments_regbonus_email') ;
	$locale = osc_current_user_locale() ;
	
	global $content;
    global $words;
		
        $content = array();
        if(isset($aPage['locale'][$locale]['s_title'])) {
            $content = $aPage['locale'][$locale];
        } else {
            $content = current($aPage['locale']);
        }
        
        $user = User::newInstance()->findByPrimaryKey($userId);
                                
        $words   = array();
        $words[] = array('{USER_NAME}', '{WEB_TITLE}', '{WEB_URL}', '{BONUS_CREDIT}','{CURRENCY}','{USER_ID}');
        $words[] = array( $user['s_name'], osc_page_title(), osc_base_url(), $amount , osc_get_preference('currency', 'rupayments') , $user['pk_i_id'] );

        
        include ( "function_email_inc.php" );  
    }
    
    function ppaypal_get_class_color ( $item_id ){
        
	    if ( ModelRUpayments::newInstance()->colorFeeIsPaid(osc_item_id()) and ModelRUpayments::newInstance()->get_class_color(osc_item_id()) !== "0000-00-00 00:00:00"){ 
                return 'colorized';
	    }
	    else {
		return 'normal';
	    }
    }
    
    function ppaypal_premium_get_class_color ( $item_id ){
        
        if ( ModelRUpayments::newInstance()->colorFeeIsPaid(osc_premium_id()) and ModelRUpayments::newInstance()->get_class_color(osc_premium_id()) !== "0000-00-00 00:00:00"){ 
                return 'colorized';
	    }
	    else {
		return 'normal';
	    }
    }

	function rupayments_get_class_color ( $item_id ){
        
	    if ( ModelRUpayments::newInstance()->colorFeeIsPaid(osc_item_id()) and ModelRUpayments::newInstance()->get_class_color(osc_item_id()) !== "0000-00-00 00:00:00"){ 
                return 'colorized';
	    }
	    else {
		return 'normal';
	    }
	}
    
	function rupayments_premium_get_class_color ( $item_id ){
		
        if ( ModelRUpayments::newInstance()->colorFeeIsPaid(osc_premium_id()) and ModelRUpayments::newInstance()->get_class_color(osc_premium_id()) !== "0000-00-00 00:00:00"){ 
                return 'colorized';
	    }
	    else {
		return 'normal';
	    }
	}

    function rupayments_get_top_menu($page) {
        $current_page = Params::getParam('route');
        
        if($current_page == $page) return TRUE;
        
        return FALSE;
    }
    
    function rupayments_get_left_menu($page) {
        $current_page = Params::getParam('l');
        
        if($current_page == $page) return TRUE;
        
        return FALSE;
    }
    
    function rupayments_get_top_menu_header() {
        $_r = Params::getParam('route');
        $_l = Params::getParam('l');
        
        switch($_r) {
            case 'rupayments-payments' :
                $header = 'Gateways';
            break;
            
            case 'rupayments-ads' :
                switch($_l) {
                    case 'category-prices' :
                        $header = 'Category Prices';
                    break;
                    
                    case 'region-prices' :
                        $header = 'Region Prices';
                    break;
                    
                    case 'publishing-policy' :
                        $header = 'Publishing Policy';
                    break;
                
                    default: 
                        $header = 'Ads Settings';
                    break;
                }
            break;
            
            case 'rupayments-users' :
                switch($_l) {
                    case 'groups' :
                        $header = 'User Groups';
                    break;
                    
                    case 'bonuses' :
                        $header = 'Bonuses';
                    break;

                    default: 
                        $header = 'Packs';
                    break;
                }
            break;
            
            case 'rupayments-banners' :
                switch($_l) {
                    case 'banners' :
                        $header = 'Banners';
                    break;
                    
                    default :
                        $header = 'Banner Settings';
                    break;
                }
            break;
            
            case 'rupayments-ebuy' :
                $header = 'eBuy';
            break;
            
            case 'rupayments-logs' :
                $header = 'Payment Logs';
            break;
            
            case 'rupayments-help' :
                $header = 'Help';
            break;
            
            default :
                $header = 'Unknown Page';
            break;
        }
        
        return $header;
    }
    
    function rupayments_item_img($item_id) {
        $status = ModelRUpayments::newInstance()->checkShowImage($item_id);
        
        return $status;
    }
    
    function rupayments_ebuy_btn($item_id) {
        if(osc_get_preference('allow_ebuy', 'rupayments')/* && osc_logged_user_id()*/) {
            $status = ModelRUpayments::newInstance()->getEbuyItem($item_id);
            
            if ($status['i_status']) {
                require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'user/ebuybtn.php';
            }
            else {
                return FALSE;
            } 
        }
        
        return FALSE;
    }
	  
function ruwopaycur() {
	  
  if(osc_get_preference('currency', 'rupayments')=="EUR")
  $wopay = '978';
  
  if(osc_get_preference('currency', 'rupayments')=="USD")
  $wopay = '840';
 
  if(osc_get_preference('currency', 'rupayments')=="RUB")
  $wopay = '643';
 
  if(osc_get_preference('currency', 'rupayments')=="UAH")
  $wopay = '980';
  
  if(osc_get_preference('currency', 'rupayments')=="KZT")
  $wopay = '398';
  
  if(osc_get_preference('currency', 'rupayments')=="BYR")
  $wopay = '974';
  
  if(osc_get_preference('currency', 'rupayments')=="TJS")
  $wopay = '972';
  
  if(osc_get_preference('currency', 'rupayments')=="ZAR")
  $wopay = '710';
  
  if(osc_get_preference('currency', 'rupayments')=="AZN")
  $wopay = '944';

  if(osc_get_preference('currency', 'rupayments')=="PLN")
  $wopay = '985';

  return $wopay;
   
 
 }
 
      function print_answer($result, $description)
          {
            print "WMI_RESULT=" . strtoupper($result) . "&";
            print "WMI_DESCRIPTION=" .$description;
            exit();
          }
    
?>