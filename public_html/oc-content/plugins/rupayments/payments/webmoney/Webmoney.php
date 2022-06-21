<?php
/*
 * Copyright 2017 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

class Webmoney {


    public function __construct(){}

    public static function button ( $sItemEmail = '', $fAmount = '0.00', $sProductType = '', $iItemId = 0, $sDescription){
		usleep(1200000);
		$transaction_id = 'Wb'. time();
        $mrhLogin = osc_get_preference('webmoney_id', 'rupayments');
		$OutSumCurrency = osc_get_preference('currency', 'rupayments');
        $ENDPOINT     = 'https://merchant.webmoney.ru/lmi/payment_utf.asp';
		$NOTIFICATION = osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/webmoney/notification.php';
		$SUCCESS = osc_base_url() . 'index.php?page=custom&route=rupayments-payments-webmoney-success';
		$FAIL = osc_base_url() . 'index.php?page=custom&route=rupayments-payments-webmoney-fail';
        ModelRUpayments::newInstance()->saveTransactionId ( $transaction_id, $sItemEmail, $fAmount, $sProductType, $iItemId );


        print "<form name='webmoney' class='nocsrf co2b' action='".$ENDPOINT ." ' method='post' accept-charset='UTF-8'>
  <input type='hidden' name='LMI_PAYEE_PURSE' value='".$mrhLogin."' />
  <input type='hidden' name='FIELD_1' value='".$transaction_id."' />
  <input type='hidden' name='LMI_PAYMENT_AMOUNT' value='".$fAmount."' />
  <input type='hidden' name='LMI_PAYMENT_DESC' value='".$sDescription."' />
  <input type='hidden' name='LMI_SIM_MODE' value='0' />
  <input type='hidden' name='LMI_RESULT_URL' value='".$NOTIFICATION."' />
  <input type='hidden' name='LMI_SUCCESS_URL' value='".$SUCCESS."' />
  <input type='hidden' name='LMI_SUCCESS_METHOD' value='1' />
  <input type='hidden' name='LMI_FAIL_URL' value='".$FAIL."' />
  <input type='hidden' name='LMI_FAIL_METHOD' value='1' />
  <button type='submit' name='webmoney' class='chekout udisbutton'>Webmoney</button>
   </form>
        ";   
		  
		  }
		  
    }
?>