<?php

/*
Plugin Name: Russian Ultimate Payments
Plugin URI: https://osclass-pro.com/
Plugin update URI: russian-ultimate-payments
Description: Russian Ultimate Payments plugin
Version: 4.3.0
Author: Dis
Author URI: https://osclass-pro.com/
Short Name: rupayments
*/
/*
 * Copyright 2017-2020 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

    //define('PAYMENT_CRYPT_KEY', 'randompassqwerchangethis');

    // PAYMENT STATUS
    define('PAYMENT_FAILED', 0);
    define('PAYMENT_COMPLETED', 1);
    define('PAYMENT_PENDING', 2);
    define('PAYMENT_ALREADY_PAID', 3);

    // Path to plugin files
    define('RUPAYMENTS_PATH', osc_plugins_path() . osc_plugin_folder(__FILE__));
    define('RUPAYMENTS_RELATIVE_PATH', osc_plugin_folder(__FILE__));

    // Path to admin assets
    define('RUPAYMENTS_ADM_STYLE', osc_plugin_url(__FILE__) . 'admin/css/');
    define('RUPAYMENTS_ADM_SCRIPT', osc_plugin_url(__FILE__) . 'admin/js/');

    // load necessary functions
    require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'functions.php';
    require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'ModelRUpayments.php';
    require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'payments/paypal/paypal/Paypal.php';
    require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'payments/2chekout/2Chekout.php';

    require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'payments/fortumo/fortumo.php';
    require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'payments/blockchain/blockchain.php';
	require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'payments/yandex/Yandex.php';
	require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'payments/interkassa/Interkassa.php';
	require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'payments/liqpay/liqpay.php';
	require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'payments/robokassa/Robokassa.php';
	require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'payments/walletone/Walletone.php';
	require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'payments/payeer/Payeer.php';
	require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'payments/freekassa/Freekassa.php';
	require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'payments/webmoney/Webmoney.php';

    /**
    * Create tables and variables on t_preference and t_pages
    */
    function rupayments_install() {
        ModelRUpayments::newInstance()->install();
    }

    /**
    * Clean up all the tables and preferences
    */
    function rupayments_uninstall() {
        ModelRUpayments::newInstance()->uninstall();
    }

    /**
    * Create a menu on the admin panel
    */
    function rupayments_admin_menu() {

        osc_add_admin_submenu_page('plugins', __('Russian Ultimate Payments', 'rupayments'), osc_route_admin_url('rupayments-payments'), 'rupayments_settings', 'administrator');
    }

    function rupayments_init_admin_page_header() {
        $_r = Params::getParam('route');

        switch ($_r) {
            case 'rupayments-payments' :
            case 'rupayments-ads' :
            case 'rupayments-users' :
            case 'rupayments-banners' :
            case 'rupayments-ebuy' :
            case 'rupayments-logs' :
            case 'rupayments-help' :
                osc_register_script('tabs-js', RUPAYMENTS_ADM_SCRIPT . 'tabs.js');
                osc_enqueue_script('tabs-js');
                osc_enqueue_style('tabs-style', RUPAYMENTS_ADM_STYLE . 'tabs.css');
                osc_enqueue_style('accordion', RUPAYMENTS_ADM_STYLE . 'accordion.css');
                osc_register_script('switch-js', RUPAYMENTS_ADM_SCRIPT . 'hurkanSwitch.js');
                osc_enqueue_script('switch-js');
                osc_enqueue_style('switch-style', RUPAYMENTS_ADM_STYLE . 'hurkanSwitch.css');
                osc_register_script('tips-js', RUPAYMENTS_ADM_SCRIPT . 'tipso.js');
                osc_enqueue_script('tips-js');
                osc_enqueue_style('tips-style', RUPAYMENTS_ADM_STYLE . 'tipso.css');
                osc_enqueue_style('animate-style', RUPAYMENTS_ADM_STYLE . 'animate.css');
                osc_register_script('toolbar-js', RUPAYMENTS_ADM_SCRIPT . 'toolbar.js');
                osc_enqueue_script('toolbar-js');
                osc_enqueue_style('toolbar-style', RUPAYMENTS_ADM_STYLE . 'toolbar.css');
                osc_enqueue_style('main-style', RUPAYMENTS_ADM_STYLE . 'style.css');
                osc_remove_hook('admin_page_header', 'customPageHeader');
                osc_add_hook('admin_page_header', 'rupayments_admin_page_header');
                osc_register_script('ultimate-admin-js', RUPAYMENTS_ADM_SCRIPT . 'ultimate.js');
                osc_enqueue_script('ultimate-admin-js');
            break;

            default :
            break;
        }
    }

    function rupayments_admin_page_header() {
        echo '<h1>Russian Ultimate Payments</h1>';
    }

    /**
     * Load ppaypal's js library
     */
    function rupayments_load_js () {
        if(Params::getParam('page')=='custom') {
                osc_register_script('paypal', 'https://www.paypalobjects.com/js/external/dg.js', array('jquery'));
                osc_enqueue_script('paypal');

        }

        osc_enqueue_script('jquery');
        osc_register_script('user_script', osc_base_url() . 'oc-content/plugins/rupayments/js/ultimate.js');
        osc_enqueue_script('user_script');

    }

    /**
     * Redirect to ppaypal page after publishing an item
     *
     * @param integer $item
     */
    function rupayments_publish ( $item ) {

        if(osc_get_preference('allow_ebuy', 'rupayments') && osc_logged_user_id()) {
            ModelRUpayments::newInstance()->setEbuyItem($item['pk_i_id'], $item['i_price'], $item['fk_c_currency_code']);
        }
        // Реализация политики публикаций
        if ( ModelRUpayments::newInstance()->policyExecution ( $item['fk_i_category_id'], $item['s_contact_email'] ) ) {

            if(osc_get_preference('pay_per_show_image_status', 'rupayments')) ModelRUpayments::newInstance()->setImageShow(Params::getParam('itemId'), 0);
            // Можно опубликовать объявление NO NEED TO PAY PUBLISH FEE
            if ( !osc_is_admin_user_logged_in() ) rupayments_send_email ( $item, 0, 'offer', '101' );
            // Б/п объявление проводим с регистраций как платного
            ModelRUpayments::newInstance()->createItem($item['pk_i_id'], 1);
            if ( !osc_is_admin_user_logged_in() && osc_get_preference ('allow_itempost_form', 'rupayments') == 1 ){
			    osc_redirect_to(osc_route_url('rupayments-user-payments', array('itemId' => $item['pk_i_id'], 'productType' => Params::getParam('productType'))));
			}
        elseif (!osc_is_admin_user_logged_in() && osc_get_preference ('allow_itempost_form', 'rupayments') == 0 && osc_get_preference ('allow_after', 'rupayments') == 1 ) {
                osc_redirect_to(osc_route_url('rupayments-after', array('itemId' => $item['pk_i_id'])));
            }
        }
        else {

            if(osc_get_preference('pay_per_show_image_status', 'rupayments')) ModelRUpayments::newInstance()->setImageShow(Params::getParam('itemId'), 0);

            // Надо платить PUBLISH FEE и стандартное поведение системы
            // Need to pay to publish ?
            if(osc_get_preference('pay_per_post', 'rupayments')==1) {
                $category_fee = ModelRUpayments::newInstance()->getPublishPrice($item['fk_i_category_id'], $item);
                if ( !osc_is_admin_user_logged_in() ) rupayments_send_email ( $item, 0, 'offer', '101' );
                if ( !osc_is_admin_user_logged_in() && $category_fee>0 ) {
                    // Catch and re-set FlashMessages
                    //osc_resend_flash_messages();
                    $mItems = new ItemActions(false);
                    $mItems->disable($item['pk_i_id']);
                    ModelRUpayments::newInstance()->createItem($item['pk_i_id'],0);
			if (!osc_is_admin_user_logged_in() && osc_get_preference ('allow_itempost_form', 'rupayments') == 1 ){
			osc_redirect_to(osc_route_url('rupayments-user-payments', array('itemId' => $item['pk_i_id'], 'productType' => Params::getParam('productType'))));
			} elseif (!osc_is_admin_user_logged_in() && osc_get_preference ('allow_itempost_form', 'rupayments') == 0) {
                osc_redirect_to(osc_route_url('rupayments-publish', array('itemId' => $item['pk_i_id'])));
            }
                } else {
                    // PRICE IS ZERO
                    ModelRUpayments::newInstance()->createItem($item['pk_i_id'], 1);
                }
            }
            else {
                // NO NEED TO PAY PUBLISH FEE
                if ( !osc_is_admin_user_logged_in() ) rupayments_send_email ( $item, 0, 'offer', '101' );
                ModelRUpayments::newInstance()->createItem($item['pk_i_id'], 1);

                if (!osc_is_admin_user_logged_in() && osc_get_preference ('allow_itempost_form', 'rupayments') == 1 ){
                    osc_redirect_to(osc_route_url('rupayments-user-payments', array('itemId' => $item['pk_i_id'], 'productType' => Params::getParam('productType'))));
                } elseif (!osc_is_admin_user_logged_in() && osc_get_preference ('allow_itempost_form', 'rupayments') == 0 && osc_get_preference ('allow_after', 'rupayments') == 1) {
                    osc_redirect_to(osc_route_url('rupayments-after', array('itemId' => $item['pk_i_id'])));
                }
            }

        }
    }

	 function uedit_publish ( $item ) {
        if(osc_get_preference('allow_ebuy', 'rupayments') && osc_logged_user_id()) {
            ModelRUpayments::newInstance()->setEbuyItem($item['pk_i_id'], $item['i_price'], $item['fk_c_currency_code']);
        }

        if ( !osc_is_admin_user_logged_in() && osc_get_preference ('allow_after', 'rupayments') == 1 ) {
            osc_redirect_to(osc_route_url('rupayments-after', array('itemId' => $item['pk_i_id'])));
        }
    }

    /**
     * Create a new menu option on users' dashboards
     */
    function rupayments_user_menu() {
        if(ModelRUpayments::newInstance()->checkBannersActive()) {
            echo '<li class="opt_rupayments_pack" ><a href="'.osc_route_url('rupayments-user-banners').'" >'.__("Banners", "rupayments").'</a></li>' ;
        }

        if(osc_get_preference('allow_ebuy', 'rupayments')) {
             echo '<li class="opt_rupayments_pack" ><a href="'.osc_route_url('rupayments-user-ebuy-deals').'" >'.__("Deals", "rupayments").'</a></li>' ;
        }

        if(ModelRUpayments::newInstance()->getUserGroups()) {
            echo '<li class="opt_rupayments_membership" ><a href="'.osc_route_url('rupayments-user-membership').'" >'.__("Membership", "rupayments").'</a></li>' ;
        }

        echo '<li class="opt_rupayments" ><a href="'.osc_route_url('rupayments-user-menu').'" >'.__("Premium services", "rupayments").'</a></li>' ;

        if(ModelRUpayments::newInstance()->getPacks()) {
            echo '<li class="opt_rupayments_pack" ><a href="'.osc_route_url('rupayments-user-pack').'" >'.__("Wallet", "rupayments").'
            <!-- Small Hack for Wallet-->
            <span class="im-user-account-count im-count-1">1</span></a></li>' ;
        }
    }

    /**
     * Executed hourly with cron to clean up the expired-premium ads
     */
    function rupayments_cron() {

        // Автоматическое перидоическое поднятие объявлений в ТОП пакета 3-в-1
        ModelRUpayments::newInstance()->setCronPack3in1Top();
        // Автоматическое перидоическое начисление бонусов
        ModelRUpayments::newInstance()->setCronUserBonus();
        // Очиска истекших сервисов Премиум и Цвета
        ModelRUpayments::newInstance()->purgeExpired();
        // Уведомление об истечении срока действия сервисов Премиум и Цвета
        rupayments_cron_alert ();
        // Очиска истекших транзакций Skrill и Yandex
        ModelRUpayments::newInstance()->cleanTransactions();
    }


    /**
     * Executed when an item is manually set to NO-premium to clean up it on the plugin's table
     *
     * @param integer $id
     */
    function rupayments_premium_off($id) {
        ModelRUpayments::newInstance()->premiumOff($id);
    }

    /**
     * Executed before editing an item
     *
     * @param array $item
     */
    function rupayments_before_edit($item) {
        // avoid category changes once the item is paid
        if ( ( osc_get_preference ( 'pay_per_post', 'rupayments' ) == '1' && ModelRUpayments::newInstance()->publishFeeIsPaid ( $item['pk_i_id'] ) ) || (osc_get_preference('allow_premium','rupayments') == '1' && ModelRUpayments::newInstance()->premiumFeeIsPaid ( $item['pk_i_id'] ) ) ) {
            $cat[0] = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
            View::newInstance()->_exportVariableToView('categories', $cat);
        }
    }


    /**
     * Executed before showing an item
     *
     * @param array $item
     */
    function rupayments_show_item($item) {
          if ( osc_get_preference ( "pay_per_post", "rupayments" ) == "1" && !ModelRUpayments::newInstance()->publishFeeIsPaid($item['pk_i_id']) ) {
            rupayments_publish($item);
        }
    }

    function rupayments_item_delete($itemId) {
        ModelRUpayments::newInstance()->deleteItem($itemId);
    }

	function rupayments_delete_user($id) {
        ModelRUpayments::newInstance()->deleteUser($id);
    }

	function rupayments_regbonus($user){
    if(osc_get_preference('allow_regbonus', 'rupayments')==1) {
	$regbonus = osc_get_preference('regbonus_value', 'rupayments');
	ModelRUpayments::newInstance()->addWalletReg($user, $regbonus);
    }
  }

    function rupayments_configure_link() {
        //osc_redirect_to(osc_route_admin_url('rupayments-admin-conf'));
        osc_redirect_to(osc_route_admin_url('rupayments-payments'));
    }

    function rupayments_update_version() {
        ModelRUpayments::newInstance()->versionUpdate();
    }


    function rupayments_payment_wallet () { // $id

        if ( osc_logged_admin_id() ) {

            $flag_OK = false;

            // Store the order in the database.
            if ( Params::getParam("wallet")  ) {

                $sProductType = Params::getParam("pr_type");
                $iUserId = Params::getParam("id");
                $sPrice = Params::getParam("val");
                $sCurrency = osc_get_preference('currency', 'rupayments');
                $iItemID = 0;
                $sPayment_system = "admin";

                $sDescription = "";
                if ( $sProductType == '501' ) $sDescription =  __('Pack 1','rupayments');
                else if ( $sProductType == '502' ) $sDescription =  __('Pack 2','rupayments');
                else if ( $sProductType == '503' ) $sDescription =  __('Pack 3','rupayments');
                $paid = "";

                $user = User::newInstance()->findByPrimaryKey($iUserId);

                // Добавляем запись о платеже в логи
                ModelRUpayments::newInstance()->saveLog ( $sDescription, $paid, $sPrice, $sCurrency, $user['s_email'], $iUserId, $iItemID, $sProductType, $sPayment_system );

                // Добавляем платеж в кошелек
                ModelRUpayments::newInstance()->addWallet ( $iUserId, $sPrice );


                // Отправляем электронку юзеру
                rupayments_send_email ( $item = 0, $user, 'admin', $sProductType );

                $flag_OK = true;
            }

            $packs = array();

            if ( osc_get_preference("pack_price_1", "rupayments") != '' && osc_get_preference ( "pack_price_1", "rupayments" ) != '0' ) {
                $packs[] = osc_get_preference("pack_price_1", "rupayments");
            }
            if ( osc_get_preference("pack_price_2", "rupayments") != '' && osc_get_preference ( "pack_price_2", "rupayments" ) != '0') {
                $packs[] = osc_get_preference("pack_price_2", "rupayments");
            }
            if ( osc_get_preference("pack_price_3", "rupayments") !='' && osc_get_preference ( "pack_price_3", "rupayments" ) !='0') {
                $packs[] = osc_get_preference("pack_price_3", "rupayments");
            }

            $wallet = ModelRUpayments::newInstance()->getWallet(Params::getParam("id"));
            $amount = isset($wallet['i_amount'])?$wallet['i_amount']:0;
            $formatted_amount = "";
            if($amount!=0) {
		if(osc_get_preference ( "currency", "rupayments" )=='BTC'){
			$amount2=number_format($amount,8);
		}else{
			$amount2=round($amount,2);
		}
                $credit_msg = sprintf(__('Credit packs. Your current credit is %s %s', 'rupayments'),  $amount2, osc_get_preference ( "currency", "rupayments" ));
                $formatted_amount = $amount." ".osc_get_preference ( "currency", "rupayments" );
            } else {
                $credit_msg = __('Your wallet is empty. Buy some credits.', 'rupayments');
            }

            // Оставляем сообщения по результатам процесса
            if ( Params::getParam("wallet") ) print '<div style="border: 1px solid #aaa; border-radius: 1em; background-color: #dff0d8; width: 70%; padding: 2em; margin-top: 2em;">';
            if ( $flag_OK ) _e('Filling up processed correctly', 'rupayments');
            if ( !$flag_OK && Params::getParam("wallet") ) _e('Filling up did not processed (there were some errors), please try again later or contact the administrators', 'rupayments');
            if ( Params::getParam("wallet") ) print '</div>';

?>
   <a name="wallet"></a>
   <table cellpadding="5" cellspacing="5" border="0" style="margin-top: 2em;">
       <tr style="font-weight: bold;">
           <td><h3 class="render-title"><?php _e('Wallet', 'rupayments');?></h3></td>
           <td align="center" colspan="<?php echo count($packs)+1;?>"><h3 class="render-title"><?php _e('Fill up the Wallet', 'rupayments');?></h3></td>
       </tr>
       <tr>
           <td><?php if ( $formatted_amount ) print $formatted_amount; else _e('Empty', 'rupayments');?></td>
<?php
            $pack_n = 0;

            if ( count ( $packs ) >= 1 ) {

                foreach ( $packs as $pack ) {
                    $pack_n++;

                    if ( $pack_n == 1 ) $sColor = "#FF5D13";
                    if ( $pack_n == 2 ) $sColor = "#14A7D1";
                    if ( $pack_n == 3 ) $sColor = "#1AAF5D";
?>
           <td><a href="<?php print osc_base_url();?>oc-admin/index.php?page=users&action=edit&id=<?php print Params::getParam("id");?>&wallet=1&val=<?php print $pack;?>&pr_type=<?php print "50".$pack_n;?>#wallet"><?php echo sprintf(__('Credit pack #%d', 'rupayments'), $pack_n); ?> (<?php print $pack." ".osc_get_preference('currency', 'rupayments');?>)  >></a></td>
<?php
                }
            }
?>
       </tr>
   </table>
<?php
        }
    }

    function rupayments_payment_block ( $item ) {
        if ( osc_logged_admin_id() ) {
            rupayments_admin_payment_block ( $item );
        }
        else if ( osc_get_preference('allow_item_form', 'rupayments') && osc_is_web_user_logged_in() && osc_logged_user_id() == osc_item_user_id() ) {
            rupayments_user_payment_block ( $item );
        }
        else {}
    }


    function rupayments_user_payment_block ( $item ) {

        $category_fee = ModelRUpayments::newInstance()->getPublishPrice($item['fk_i_category_id'], $item);

?>
<link rel="stylesheet" href="<?php echo osc_base_url();?>oc-content/plugins/rupayments/css/materialdesignicons.min.css">
<h3 class="uservicepayh2form"><?php print __( 'Services for you item:', 'rupayments' );?></h3><br/>

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
     <input type='hidden' name='url_back' value='<?php print osc_base_url() .'index.php?page=item&id='.$item['pk_i_id'];?>'>
<?php
        $bPublishFeeNeeded = false;
        if ( osc_get_preference('pay_per_post', 'rupayments') &&  $category_fee && !ModelRUpayments::newInstance()->publishFeeIsPaid ( $item['pk_i_id'] ) ) {
            $bPublishFeeNeeded = true;

?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" value="101"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '101' ); print ", "; print ModelRUpayments::newInstance()->printPriceStr ( $item, '101' );?>
      </div>
<?php
        }
?>
      <?php if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])): ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="product_type" value="701"></span><?php ModelRUpayments::newInstance()->printPriceLable( $item, '701' );?><?php print ", "; print ModelRUpayments::newInstance()->printPriceStr( $item, '701' );?>
            </div>
    <?php endif; ?>

<?php
        if ( osc_get_preference ( 'allow_move', 'rupayments' ) && ModelRUpayments::newInstance()->checkPack3in1($item['pk_i_id']) != 'active' ) {
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" value="401"<?php if ( !$bPublishFeeNeeded ) print " checked";?>></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '401' ); print ", "; print ModelRUpayments::newInstance()->printPriceStr ( $item, '401' );?>
      </div>
<?php
        }
        if ( osc_get_preference ( 'allow_high', 'rupayments' ) && !ModelRUpayments::newInstance()->colorFeeIsPaid ( $item['pk_i_id'] ) ) {
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" value="301"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '301' );  print ", "; print ModelRUpayments::newInstance()->printPriceStr ( $item, '301' );?>
      </div>
<?php
        }
?>
      <?php if(osc_get_preference('pay_per_show_image_status', 'rupayments') && osc_get_preference ( 'allow_high', 'rupayments' ) && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id']) && !ModelRUpayments::newInstance()->colorFeeIsPaid ( $item['pk_i_id'] )): ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="product_type" value="721"></span><?php ModelRUpayments::newInstance()->printPriceLable( $item, '721' );?><?php print ", "; print ModelRUpayments::newInstance()->printPriceStr( $item, '721' );?>
            </div>
    <?php endif; ?>


    <?php if(osc_get_preference ( '3_in_1_pack_status', 'rupayments' )  && ModelRUpayments::newInstance()->checkPack3in1($item['pk_i_id']) != 'active'): ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="product_type" value="801"></span><?php ModelRUpayments::newInstance()->printPriceLable( $item, '801' );?><?php print ", "; print ModelRUpayments::newInstance()->printPriceStr( $item, '801' );?>
            </div>
    <?php endif; ?>

<?php
        if ( osc_get_preference ( 'allow_premium', 'rupayments' ) && !ModelRUpayments::newInstance()->premiumFeeIsPaid ( $item['pk_i_id'] ) ) {
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" value="201"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '201' ); print ", "; print ModelRUpayments::newInstance()->printPriceStr ( $item, '201' );?>
      </div>
<?php
        }
?>

      <?php if(osc_get_preference('pay_per_show_image_status', 'rupayments') && osc_get_preference ( 'allow_premium', 'rupayments' ) && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id']) && !ModelRUpayments::newInstance()->premiumFeeIsPaid ( $item['pk_i_id'] )): ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="product_type" value="711"></span><?php ModelRUpayments::newInstance()->printPriceLable( $item, '711' );?><?php print ", "; print ModelRUpayments::newInstance()->printPriceStr( $item, '711' );?>
            </div>
    <?php endif; ?>

<?php
        if ( osc_get_preference ( 'allow_premium', 'rupayments' ) && osc_get_preference ( 'allow_high', 'rupayments' ) && !ModelRUpayments::newInstance()->colorFeeIsPaid ( $item['pk_i_id'] ) && !ModelRUpayments::newInstance()->premiumFeeIsPaid ( $item['pk_i_id'] ) ) {
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" value="231"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '231' ); print ", "; print ModelRUpayments::newInstance()->printPriceStr ( $item, '231' );?>
      </div>
<?php
        }
?>
      <?php if(osc_get_preference('pay_per_show_image_status', 'rupayments') && osc_get_preference ( 'allow_high', 'rupayments' ) && osc_get_preference ( 'allow_premium', 'rupayments' ) && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id']) && !ModelRUpayments::newInstance()->colorFeeIsPaid ( $item['pk_i_id'] ) && !ModelRUpayments::newInstance()->premiumFeeIsPaid ( $item['pk_i_id'] )): ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="product_type" value="731"></span><?php ModelRUpayments::newInstance()->printPriceLable( $item, '731' );?><?php print ", "; print ModelRUpayments::newInstance()->printPriceStr( $item, '731' );?>
            </div>
    <?php endif; ?>

    <?php if(osc_get_preference ( '3_in_1_pack_status', 'rupayments' ) && ModelRUpayments::newInstance()->checkPack3in1($item['pk_i_id']) != 'active' && osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])): ?>
            <div class="upay_itemform">
                <span class="upay_adminspan"><input type="radio" name="product_type" value="811"></span><?php ModelRUpayments::newInstance()->printPriceLable( $item, '811' );?><?php print ", "; print ModelRUpayments::newInstance()->printPriceStr( $item, '811' );?>
            </div>
    <?php endif; ?>
      <button class="ubutton_from" onclick="sendForm();" style="margin: 1em 0 0 1em;"><?php _e('Select and Pay', 'rupayments'); ?></button>
    </form>
<?php
    }

    function rupayments_admin_payment_block ( $item ) {

        if ( Params::getParam("productType")  ) {

            $sProductType = Params::getParam("productType");
            $iItemID = Params::getParam("itemId");
            $iCategoryId = Params::getParam("categoryId");

            $paid = "admin";
            $sCurrency = osc_get_preference('currency', 'rupayments');
            $sPayment_system = "admin";

            // Шлем электронку с уведомлением
            rupayments_send_email ( $item, 0, 'admin', $sProductType );

            if ( $sProductType == '101' ) {
                $sPrice = ModelRUpayments::newInstance()->getPublishPrice ( $item['fk_i_category_id'] );
                $sDescription = __('Published', 'rupayments');
            }
            else if ( $sProductType == '201' ) {
                $sPrice = ModelRUpayments::newInstance()->getPremiumPrice ( $item['fk_i_category_id'] );
                $sDescription = __('Marked as Premium', 'rupayments');

                // Корректируем запись в лог
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) ) $sDescription = "Publish & ".$sDescription;
            }
            else if ( $sProductType == '301' ) {
                $sPrice = ModelRUpayments::newInstance()->getColorPrice ( $item['fk_i_category_id'] );
                $sDescription = __('Marked as Highlighted', 'rupayments');

                // Корректируем запись в лог
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) ) $sDescription = "Publish & ".$sDescription;
            }
            else if ( $sProductType == '401' ) {
                $sPrice = ModelRUpayments::newInstance()->getTopPrice ( $item['fk_i_category_id'] );
                $sDescription = __('Moved to TOP', 'rupayments');
            }
			else if ( $sProductType == '411' ) {
                $sPrice = ModelRUpayments::newInstance()->getRenewPrice ( $item['fk_i_category_id'] );
                $sDescription = __('Renewed', 'rupayments');
            }
            else if ( $sProductType == '231' ) {
                $sPrice = ModelRUpayments::newInstance()->getPremiumWithColorDiscount ( $item['fk_i_category_id'] );
                $sDescription = __('Marked as Premium and Highlighted', 'rupayments');

                // Корректируем запись в лог
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) ) $sDescription = "Publish & ".$sDescription;
            }


            // Добавляем запись о платеже в логи
            $payment_id = ModelRUpayments::newInstance()->saveLog ( $sDescription, $paid, $sPrice, $sCurrency, $item['s_contact_email'], $item['fk_i_user_id'], $iItemID, $sProductType, $sPayment_system );

            if ( $sProductType == '101' ) {
                ModelRUpayments::newInstance()->payPublishFee ( $iItemID, $payment_id );
            }
            else if ( $sProductType == '201' ) {
                ModelRUpayments::newInstance()->payPremiumFee ( $iItemID, $payment_id );
            }
            else if ( $sProductType == '301' ) {
                ModelRUpayments::newInstance()->setColor ( $iItemID );
            }
            else if ( $sProductType == '401' ) {
                ModelRUpayments::newInstance()->setTopItem ( $iItemID );
            }
			else if ( $sProductType == '411' ) {
                ModelRUpayments::newInstance()->setRenew ( $iItemID );
            }
            else if ( $sProductType == '231' ) {
                ModelRUpayments::newInstance()->payPremiumWithColorFee ( $iItemID, $payment_id );
            }

            osc_reset_preferences();
        }

        $category_fee = ModelRUpayments::newInstance()->getPublishPrice($item['fk_i_category_id'], $item);


        // Оставляем сообщения по результатам процесса
        if ( Params::getParam("productType") ) {?>
		<div class="alertultimate">
  <span class="closebtnultimate" onclick="this.parentElement.style.display='none';">&times;</span>
 <?php print $sDescription;?>
</div>

<?php
        }
?>
  <h3 class="uservicepayh2form"><?php print __( 'Admin options:', 'rupayments' );?></h3>
  <form action="#pb" name="goToPayForm" method="post">
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
<?php
$sText = __( 'Valid', 'rupayments' );
	$sTextE = __( 'Expired', 'rupayments' );
	$sTextEA = __( 'Before Expiration', 'rupayments' );
    $sTextDays = __( 'days', 'rupayments' );
    $sTextHours = __( 'hours', 'rupayments' );
	$sTextMinutes = __( 'minutes', 'rupayments' );
        $bPublishFeeNeeded = false;
        if ( osc_get_preference('pay_per_post', 'rupayments') &&  $category_fee && !ModelRUpayments::newInstance()->publishFeeIsPaid ( $item['pk_i_id'] ) ) {
            $bPublishFeeNeeded = true;
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" value="101"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '101' );?>
      </div>

<?php
        }
		if ( osc_get_preference ( 'allow_renew', 'rupayments' ) && $item['dt_expiration']!="9999-12-31 23:59:59" ) {
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" value="411"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '411' );?>
      </div>
<?php
if($item['dt_expiration'] <= date("Y-m-d H:i:s")){
			print "<br><span style='color: red;'>".$sTextE."</span>";
			}else{
            if ( ModelRUpayments::newInstance()->printDaysStr ( $item, '411' ) ) print "<span class='upay_adminspan' style='color: red;'>".$sTextEA." ".ModelRUpayments::newInstance()->iRenewDays." ".$sTextDays." ".ModelRUpayments::newInstance()->iRenewHours." ".$sTextHours ." ".ModelRUpayments::newInstance()->iRenewMinutes." ".$sTextMinutes."</span>";
			}
        }
        if ( osc_get_preference ( 'allow_move', 'rupayments' ) ) {
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" value="401"<?php if ( !$bPublishFeeNeeded ) print " checked";?>></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '401' );?>
      </div>
<?php
        }
        if ( osc_get_preference ( 'allow_high', 'rupayments' ) ) {
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" value="301"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '301' );?>
      </div>
<?php
if ( ModelRUpayments::newInstance()->colorFeeIsPaid ( $item['pk_i_id'] ) && ModelRUpayments::newInstance()->printDaysStr ( $item, '301' ) ) print "<span class='upay_adminspan' style='color: red;'>".$sText." ".ModelRUpayments::newInstance()->iColorDays." ".$sTextDays." ".ModelRUpayments::newInstance()->iColorHours." ".$sTextHours ." ".ModelRUpayments::newInstance()->iColorMinutes." ".$sTextMinutes."</span>";
        }
        if ( osc_get_preference ( 'allow_premium', 'rupayments' ) ) {
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" value="201"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '201' );?>
      </div>
<?php
if ( ModelRUpayments::newInstance()->premiumFeeIsPaid ( $item['pk_i_id'] ) && ModelRUpayments::newInstance()->printDaysStr ( $item, '201' ) ) print "<span class='upay_adminspan' style='color: red;'>".$sText." ".ModelRUpayments::newInstance()->iPremiumDays." ".$sTextDays." ".ModelRUpayments::newInstance()->iPremiumHours." ".$sTextHours." ".ModelRUpayments::newInstance()->iPremiumMinutes." ".$sTextMinutes."</span>";
        }
?>
<div class="upay_itemform">
      <button class="ubutton_from" onclick="sendForm();" style="margin: 1em 0 0 1em;"><?php _e('Apply as admin', 'rupayments'); ?></button>
	  </div>
    </form>
<?php
    }

    function rupayments_cron_alert () {

        $aAlertColor = ModelRUpayments::newInstance()->cronColorExpired ( osc_get_preference("days_before_deadline_for_sending_email", "rupayments") );
        $aAlertPremium = ModelRUpayments::newInstance()->cronPremiumExpired ( osc_get_preference("days_before_deadline_for_sending_email", "rupayments") );
		if ( osc_get_preference ( 'allow_renew', 'rupayments' )){
        $aAlertRenew = ModelRUpayments::newInstance()->cronRenewExpired ( osc_get_preference("days_before_deadline_for_sending_email", "rupayments") );
		} else {
		$aAlertRenew = 0 ;
		}
        $aAlertMembership = ModelRUpayments::newInstance()->cronMembershipExpired ( osc_get_preference("days_before_deadline_for_sending_email", "rupayments") );

        ini_set ( "max_execution_time", ( count ( $aAlertColor ) + count ( $aAlertPremium )*6 + count ( $aAlertRenew )*6 ) );

        for ( $i = 0; $i < count ( $aAlertColor ); $i++ ) {

            $item = Item::newInstance()->findByPrimaryKey ( $aAlertColor[$i] );

            if ( in_array ( $aAlertColor[$i], $aAlertPremium ) ) {
                rupayments_cron_email_filter ( $item, $aAlertColor[$i], '231', TRUE );
            }
            else {
                rupayments_cron_email_filter ( $item, $aAlertColor[$i], '301', TRUE );
            }
            if ( isset ( $item ) ) unset ( $item );
        }

        for ( $i = 0; $i < count ( $aAlertPremium ); $i++ ) {

            $item = Item::newInstance()->findByPrimaryKey ( $aAlertPremium[$i] );

            if ( in_array ( $aAlertPremium[$i], $aAlertColor  ) ) {
                rupayments_cron_email_filter ( $item, $aAlertPremium[$i], '231', TRUE );
            }
            else {
                rupayments_cron_email_filter ( $item, $aAlertPremium[$i], '201', TRUE );
            }
            if ( isset ( $item ) ) unset ( $item );
        }

		if ( osc_get_preference ( 'allow_renew', 'rupayments' )){

		 for ( $i = 0; $i < count ( $aAlertRenew ); $i++ ) {

            $item = Item::newInstance()->findByPrimaryKey ( $aAlertRenew[$i] );

            rupayments_cron_email_filter ( $item, $aAlertRenew[$i], '411', TRUE );

            if ( isset ( $item ) ) unset ( $item );
        }
		}


        for ( $i = 0; $i < count ( $aAlertMembership ); $i++ ) {

            $user = User::newInstance()->findByPrimaryKey($aAlertMembership[$i]['f_user_id']);

            $item = array(
                        'pk_i_id' => $aAlertMembership[$i]['fk_i_ugm_id'],
                        's_contact_name' => $user['s_name'],
                        's_contact_email' => $user['s_email']
                        );

            rupayments_cron_email_filter ( $item, $aAlertMembership[$i], '601', TRUE );

            if ( isset ( $item ) ) unset ( $item );
        }

    }

    function rupayments_cron_email_filter ( $item, $itemId, $product_type, $bVar ) {

        if ( !ModelRUpayments::newInstance()->getCronEmailFilter ( $itemId, $product_type ) ) {

            ModelRUpayments::newInstance()->setCronEmailFilter ( $itemId, $bVar );

            rupayments_send_email ( $item, 0, 'alert', $product_type );
        }
    }

    rupayments_load_js ();

function rupayments_style() {
	osc_enqueue_style('rupayments_style', osc_base_url() . 'oc-content/plugins/rupayments/css/ultimate.css' );
}
	function ucolor_style(){
    $color = osc_get_preference('color', 'rupayments');
    echo '<style type="text/css">#colorized,.colorized{background:'. $color .'!important;}</style>';
  }

  function rupayments_item_block ($categoryId = null) {
    if(osc_get_preference('allow_ebuy', 'rupayments') && osc_logged_user_id()) {
        require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'user/ebuyform.php';
    }

    if( !osc_is_admin_user_logged_in() && osc_get_preference('allow_itempost_form', 'rupayments')==1 ) {
        require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'user/itemform.php';
    }
}

function rupayments_ocadmin_payment_block ( $item ) {
    if(osc_get_preference('allow_ebuy', 'rupayments') && osc_logged_user_id()) {
        require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'user/ebuyform.php';
    }

     if( osc_logged_admin_id()){

		$iItemID = Params::getParam("itemId");
        $item = Item::newInstance()->findByPrimaryKey($iItemID);
        $category_fee = ModelRUpayments::newInstance()->getPublishPrice($item['fk_i_category_id'], $item);
?>
	<script language="javascript">
	$(document).ready(function(){
$("#goToPayForm").validate({
  ignore: ".product_type"
});
});
</script>

  <h3 class="uservicepayh2form"><?php print __( 'Admin Ultimate Payments options:', 'rupayments' );?></h3>
  <form action="<?php echo osc_base_url();?>oc-content/plugins/rupayments/user/item_edit.php" name="goToPayForm" id="goToPayForm" class="nocsrf" method="post">
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
<?php
$sText = __( 'Valid', 'rupayments' );
	$sTextE = __( 'Expired', 'rupayments' );
	$sTextEA = __( 'Before Expiration', 'rupayments' );
    $sTextDays = __( 'days', 'rupayments' );
    $sTextHours = __( 'hours', 'rupayments' );
	$sTextMinutes = __( 'minutes', 'rupayments' );
        $bPublishFeeNeeded = false;
        if ( osc_get_preference('pay_per_post', 'rupayments') &&  $category_fee && !ModelRUpayments::newInstance()->publishFeeIsPaid ( $item['pk_i_id'] ) ) {
            $bPublishFeeNeeded = true;
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" class="product_type" value="101"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '101' );?>
      </div>

<?php
        }
?>

<?php
		if ( osc_get_preference ( 'allow_renew', 'rupayments' ) && $item['dt_expiration']!="9999-12-31 23:59:59" ) {
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" class="product_type" value="411"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '411' );?>
      </div>
<?php
if($item['dt_expiration'] <= date("Y-m-d H:i:s")){
			print "<br><span style='color: red;'>".$sTextE."</span>";
			}else{
            if ( ModelRUpayments::newInstance()->printDaysStr ( $item, '411' ) ) print "<span class='upay_adminspan' style='color: red;'>".$sTextEA." ".ModelRUpayments::newInstance()->iRenewDays." ".$sTextDays." ".ModelRUpayments::newInstance()->iRenewHours." ".$sTextHours ." ".ModelRUpayments::newInstance()->iRenewMinutes." ".$sTextMinutes."</span>";
			}
        }
?>

<?php
        if ( osc_get_preference ( 'allow_move', 'rupayments' ) ) {
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" class="product_type" value="401"<?php if ( !$bPublishFeeNeeded ) print " checked";?>></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '401' );?>
      </div>
<?php
        }
?>

<?php if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])): ?>
    <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" class="product_type" value="701"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '701' );?>
      </div>
<?php endif; ?>

<?php
        if ( osc_get_preference ( 'allow_high', 'rupayments' ) ) {
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" class="product_type" value="301"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '301' );?>
      </div>
<?php
if ( ModelRUpayments::newInstance()->colorFeeIsPaid ( $item['pk_i_id'] ) && ModelRUpayments::newInstance()->printDaysStr ( $item, '301' ) ) print "<span class='upay_adminspan' style='color: red;'>".$sText." ".ModelRUpayments::newInstance()->iColorDays." ".$sTextDays." ".ModelRUpayments::newInstance()->iColorHours." ".$sTextHours ." ".ModelRUpayments::newInstance()->iColorMinutes." ".$sTextMinutes."</span>";
        }
?>

<?php
        if ( osc_get_preference ( 'allow_premium', 'rupayments' ) ) {
?>
      <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" class="product_type" value="201"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '201' );?>
      </div>
<?php
if ( ModelRUpayments::newInstance()->premiumFeeIsPaid ( $item['pk_i_id'] ) && ModelRUpayments::newInstance()->printDaysStr ( $item, '201' ) ) print "<span class='upay_adminspan' style='color: red;'>".$sText." ".ModelRUpayments::newInstance()->iPremiumDays." ".$sTextDays." ".ModelRUpayments::newInstance()->iPremiumHours." ".$sTextHours." ".ModelRUpayments::newInstance()->iPremiumMinutes." ".$sTextMinutes."</span>";
        }
?>

<?php if(osc_get_preference ( '3_in_1_pack_status', 'rupayments' )): ?>
        <div class="upay_itemform">
          <span class="upay_adminspan"><input type="radio" name="product_type" class="product_type" value="801"></span><?php ModelRUpayments::newInstance()->printPriceLable ( $item, '801' );?>
      </div>

<?php
if ( ModelRUpayments::newInstance()->checkPack3in1($item['pk_i_id']) == 'active' && ModelRUpayments::newInstance()->printDaysStr ( $item, '801' ) ) print "<span class='upay_adminspan' style='color: red;'>".$sText." ".ModelRUpayments::newInstance()->iPack3in1Days." ".$sTextDays." ".ModelRUpayments::newInstance()->iPack3in1Hours." ".$sTextHours." ".ModelRUpayments::newInstance()->iPack3in1Minutes." ".$sTextMinutes."</span>";
?>

<?php endif; ?>

<div class="upay_itemform">
      <button class="btn btn-submit" onclick="sendForm();" style="margin: 1em 0 0 1em;"><?php _e('Apply as admin', 'rupayments'); ?></button>
	  </div>
    </form>

<?php
    }
}
    function rupayments_banner_1() {
        ModelRUpayments::newInstance()->siteBanner1();
    }

    function rupayments_banner_2() {
        ModelRUpayments::newInstance()->siteBanner2();
    }

    function rupayments_banner_3() {
        ModelRUpayments::newInstance()->siteBanner3();
    }

    function rupayments_banner_4() {
        ModelRUpayments::newInstance()->siteBanner4();
    }

    function rupayments_banner_5() {
        ModelRUpayments::newInstance()->siteBanner5();
    }

    function rupayments_banner_6() {
        ModelRUpayments::newInstance()->siteBanner6();
    }

    function rupayments_banner_7() {
        ModelRUpayments::newInstance()->siteBanner7();
    }

    function rupayments_banner_8() {
        ModelRUpayments::newInstance()->siteBanner8();
    }

    function rupayments_banner_9() {
        ModelRUpayments::newInstance()->siteBanner9();
    }

    function rupayments_banner_10() {
        ModelRUpayments::newInstance()->siteBanner10();
    }
    /**
     * ADD ROUTES (VERSION 3.2+)
     */

    #ADMIN
    $sub_menu = Params::getParam('l');

    osc_add_route('rupayments-payments', 'rupayments/admin/payments', 'rupayments/admin/payments', osc_plugin_folder(__FILE__).'admin/payments.php');
    osc_add_route('rupayments-ads', 'rupayments/admin/ads', 'rupayments/admin/ads', osc_plugin_folder(__FILE__).'admin/ads_settings.php');
    osc_add_route('rupayments-users', 'rupayments/admin/users', 'rupayments/admin/users', osc_plugin_folder(__FILE__).'admin/user_packs.php');
    osc_add_route('rupayments-banners', 'rupayments/admin/banner-settings', 'rupayments/admin/banner-settings', osc_plugin_folder(__FILE__).'admin/banner_settings.php');
    osc_add_route('rupayments-ebuy', 'rupayments/admin/ebuy', 'rupayments/admin/ebuy', osc_plugin_folder(__FILE__).'admin/ebuy.php');
    osc_add_route('rupayments-logs', 'rupayments/admin/logs', 'rupayments/admin/logs', osc_plugin_folder(__FILE__).'admin/logs.php');
    osc_add_route('rupayments-help', 'rupayments/admin/help', 'rupayments/admin/help', osc_plugin_folder(__FILE__).'admin/help.php');

    switch($sub_menu) {
        case 'category-prices' :
            osc_add_route('rupayments-ads', 'rupayments/admin/ads/category-prices', 'rupayments/admin/ads/category-prices', osc_plugin_folder(__FILE__).'admin/ads_category_prices.php');
        break;

        case 'region-prices' :
            osc_add_route('rupayments-ads', 'rupayments/admin/ads/region-prices', 'rupayments/admin/ads/region-prices', osc_plugin_folder(__FILE__).'admin/ads_region_prices.php');
        break;

        case 'publishing-policy' :
            osc_add_route('rupayments-ads', 'rupayments/admin/ads/publishing-policy', 'rupayments/admin/ads/publishing-policy', osc_plugin_folder(__FILE__).'admin/ads_publishing_policy.php');
        break;

        case 'groups' :
            osc_add_route('rupayments-users', 'rupayments/admin/users/groups', 'rupayments/admin/users/groups', osc_plugin_folder(__FILE__).'admin/user_groups.php');
        break;

        case 'bonuses' :
            osc_add_route('rupayments-users', 'rupayments/admin/users/bonuses', 'rupayments/admin/users/bonuses', osc_plugin_folder(__FILE__).'admin/user_bonuses.php');
        break;

        case 'banners' :
            osc_add_route('rupayments-banners', 'rupayments/admin/banners', 'rupayments/admin/banners', osc_plugin_folder(__FILE__).'admin/banners.php');
        break;
    }

    #CATALOG
    osc_add_route('rupayments-user-membership', 'rupayments/membership', 'rupayments/membership', osc_plugin_folder(__FILE__).'user/membership.php', true);
    osc_add_route('rupayments-banner-publish', 'rupayments/banner-publish/([0-9]+)', 'rupayments/banner-publish/{bid}', osc_plugin_folder(__FILE__).'user/banner_publish.php');
    osc_add_route('rupayments-ebuy-purchase', 'rupayments/ebuy-purchase/([0-9]+)', 'rupayments/ebuy-purchase/{bid}', osc_plugin_folder(__FILE__).'user/ebuy_purchase.php');
    osc_add_route('rupayments-user-ebuy-deals', 'rupayments/ebuy-deals', 'rupayments/ebuy-deals', osc_plugin_folder(__FILE__).'user/ebuy_deals.php', true);
    osc_add_route('rupayments-user-banners', 'rupayments/banners', 'rupayments/banners', osc_plugin_folder(__FILE__).'user/banners.php', true);
    osc_add_route('rupayments-banner-pay', 'rupayments/banner-pay/([0-9]+)', 'rupayments/banner-pay/{bid}', osc_plugin_folder(__FILE__).'user/banner_pay.php', true);
    osc_add_route('rupayments-banner-delete', 'rupayments/banner-delete/([0-9]+)', 'rupayments/banner-delete/{bid}', osc_plugin_folder(__FILE__).'user/banner_delete.php');
    #################################################################
//    osc_add_route('rupayments-admin-conf', 'rupayments/admin/conf', 'rupayments/admin/conf', osc_plugin_folder(__FILE__).'admin/conf.php');
//    osc_add_route('rupayments-admin-prices', 'rupayments/admin/prices', 'rupayments/admin/prices', osc_plugin_folder(__FILE__).'admin/conf_prices.php');
//    osc_add_route('rupayments-admin-policy', 'rupayments/admin/policy', 'rupayments/admin/policy', osc_plugin_folder(__FILE__).'admin/conf_policy.php');
//    osc_add_route('rupayments-admin-bonus', 'rupayments/admin/bonus', 'rupayments/admin/bonus', osc_plugin_folder(__FILE__).'admin/bonus.php');
    osc_add_route('rupayments-publish', 'rupayments/publish/([0-9]+)', 'rupayments/publish/{itemId}', osc_plugin_folder(__FILE__).'user/payperpublish.php');
    osc_add_route('rupayments-after', 'rupayments/after/([0-9]+)', 'rupayments/after/{itemId}', osc_plugin_folder(__FILE__).'user/after.php');
    osc_add_route('rupayments-emailpayment', 'rupayments/emailpayment/([0-9]+)', 'rupayments/emailpayment/{itemId}', osc_plugin_folder(__FILE__).'user/emailpayment.php');
    osc_add_route('rupayments-user-menu', 'rupayments/menu', 'rupayments/menu', osc_plugin_folder(__FILE__).'user/menu.php', true);
    osc_add_route('rupayments-user-pack', 'rupayments/pack', 'rupayments/pack', osc_plugin_folder(__FILE__).'user/pack.php', true);
    osc_add_route('rupayments-user-payments', 'rupayments/payments', 'rupayments/payments', osc_plugin_folder(__FILE__).'user/payments.php'); // , true
    osc_add_route('rupayments-user-payment', 'rupayments/payment', 'rupayments/payment', osc_plugin_folder(__FILE__).'user/payment.php'); // , true
    osc_add_route('rupayments-wallet', 'rupayments/wallet/([^\/]+)/([^\/]+)/([^\/]+)/(.+)', 'rupayments/wallet/{a}/{extra}/{desc}/{product}', osc_plugin_folder(__FILE__).'/user/wallet.php', true);
//    osc_add_route('rupayments-user-payumoney-success', 'rupayments/payments/payumoney', 'rupayments/payments/payumoney/payumoney_success', osc_plugin_folder(__FILE__).'payments/payumoney/payumoney_success.php'); // , true
//    osc_add_route('rupayments-user-payumoney-failure', 'rupayments/payments/payumoney', 'rupayments/payments/payumoney/payumoney_failure', osc_plugin_folder(__FILE__).'payments/payumoney/payumoney_failure.php'); // , true
	#################################################################
	//  ???
	osc_add_route('rupayments-payments-yandex-notification', 'rupayments/payments/yandex', 'rupayments/payments/yandex/notification', osc_plugin_folder(__FILE__).'payments/yandex/notification.php');
	osc_add_route('rupayments-payments-robokassa-result', 'rupayments/payments/robokassa', 'rupayments/payments/robokassa/result', osc_plugin_folder(__FILE__) . 'payments/robokassa/result.php');
    osc_add_route('rupayments-payments-robokassa-success', 'rupayments/payments/robokassa', 'rupayments/payments/robokassa/success', osc_plugin_folder(__FILE__) . 'payments/robokassa/success.php');
	osc_add_route('rupayments-payments-robokassa-cancel', 'rupayments/payments/robokassa', 'rupayments/payments/robokassa/cancel', osc_plugin_folder(__FILE__) . 'payments/robokassa/cancel.php', false);
  //  osc_add_route('rupayments-wo-success', 'rupayments/walletone/success', 'rupayments/payments/walletone/success', osc_plugin_folder(__FILE__) . 'payments/walletone/success.php', false);
  //  osc_add_route('rupayments-wo-fail', 'rupayments/walletone/fail', 'rupayments/payments/walletone/fail', osc_plugin_folder(__FILE__) . 'payments/walletone/fail.php', false);
    osc_add_route('rupayments-payments-payeer-success', 'rupayments/payments/payeer', 'rupayments/payments/payeer/success', osc_plugin_folder(__FILE__) . 'payments/payeer/success.php');
	osc_add_route('rupayments-payments-payeer-fail', 'rupayments/payments/payeer', 'rupayments/payments/payeer/fail', osc_plugin_folder(__FILE__) . 'payments/payeer/fail.php', false);
	osc_add_route('rupayments-payments-freekassa-success', 'rupayments/payments/freekassa', 'rupayments/payments/freekassa/success', osc_plugin_folder(__FILE__) . 'payments/freekassa/success.php');
	osc_add_route('rupayments-payments-freekassa-fail', 'rupayments/payments/freekassa', 'rupayments/payments/freekassa/fail', osc_plugin_folder(__FILE__) . 'payments/freekassa/fail.php', false);
    osc_add_route('rupayments-payments-webmoney-success', 'rupayments/payments/webmoney', 'rupayments/payments/webmoney/success', osc_plugin_folder(__FILE__) . 'payments/webmoney/success.php');
	osc_add_route('rupayments-payments-webmoney-fail', 'rupayments/payments/webmoney', 'rupayments/payments/webmoney/fail', osc_plugin_folder(__FILE__) . 'payments/webmoney/fail.php', false);
    /**
     * ADD HOOKS
     */
    osc_register_plugin(osc_plugin_path(__FILE__), 'rupayments_install');
    osc_add_hook(osc_plugin_path(__FILE__)."_configure", 'rupayments_configure_link');
    osc_add_hook(osc_plugin_path(__FILE__)."_uninstall", 'rupayments_uninstall');
    osc_add_hook(osc_plugin_path(__FILE__)."_enable", 'rupayments_update_version');

    osc_add_hook('admin_menu_init', 'rupayments_admin_menu');

    ###########################################
    osc_add_hook('admin_header', 'rupayments_init_admin_page_header');
    if(osc_get_preference('pay_per_show_image_status', 'rupayments') && isset($item_id)) {
        osc_add_hook('rupayments_item_img', rupayments_item_img($item_id));
    }
    if(osc_get_preference('allow_ebuy', 'rupayments') && isset($item_id)) {
        osc_add_hook('rupayments_ebuy_btn', rupayments_ebuy_btn($item_id));
    }

    osc_add_hook('rupayments_banner_1', 'rupayments_banner_1');
    osc_add_hook('rupayments_banner_2', 'rupayments_banner_2');
    osc_add_hook('rupayments_banner_3', 'rupayments_banner_3');
    osc_add_hook('rupayments_banner_4', 'rupayments_banner_4');
    osc_add_hook('rupayments_banner_5', 'rupayments_banner_5');
    osc_add_hook('rupayments_banner_6', 'rupayments_banner_6');
    osc_add_hook('rupayments_banner_7', 'rupayments_banner_7');
    osc_add_hook('rupayments_banner_8', 'rupayments_banner_8');
    osc_add_hook('rupayments_banner_9', 'rupayments_banner_9');
    osc_add_hook('rupayments_banner_10', 'rupayments_banner_10');
    ###########################################
    osc_add_hook('init', 'rupayments_load_js');
    osc_add_hook('posted_item', 'rupayments_publish', 10);
	osc_add_hook('edited_item', 'uedit_publish', 10);
    osc_add_hook('user_menu', 'rupayments_user_menu');
    osc_add_hook('cron_hourly', 'rupayments_cron');
    osc_add_hook('item_premium_off', 'rupayments_premium_off');
    osc_add_hook('before_item_edit', 'rupayments_before_edit');
    osc_add_hook('show_item', 'rupayments_show_item');
    osc_add_hook('delete_item', 'rupayments_item_delete');
	osc_add_hook('delete_user', 'rupayments_delete_user');
	osc_add_hook('user_register_completed', 'rupayments_regbonus');
    osc_add_hook('item_detail', 'rupayments_payment_block');
  //  osc_add_hook('user_form', 'rupayments_payment_wallet');
    osc_add_hook('header', 'rupayments_style');
    osc_add_hook('header', 'ucolor_style');
    osc_add_hook('item_form', 'rupayments_item_block');
   osc_add_hook('item_edit', 'rupayments_ocadmin_payment_block');

?>
