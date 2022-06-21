<?php
/*
 * Copyright 2016 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

class Interkassa {


    public function __construct(){}

    public static function button ( $sItemEmail = '', $fAmount = '0.00', $sProductType = '', $iItemId = 0, $sDescription){
		usleep(1200000);
		$transaction_id = 'In'. time();
        $mrhLogin = osc_get_preference('ik_co_id', 'rupayments');
		$OutSumCurrency = osc_get_preference('currency', 'rupayments');
        $ENDPOINT     = 'https://sci.interkassa.com/';
		$NOTIFICATION = osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/interkassa/notification.php';
		$SUCCESS = osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/interkassa/success.php?tr='.$transaction_id;
		$PENDING = osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/interkassa/pending.php?tr='.$transaction_id;
		$FAIL = osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/interkassa/fail.php';
        ModelRUpayments::newInstance()->saveTransactionId ( $transaction_id, $sItemEmail, $fAmount, $sProductType, $iItemId );


        print "<form name='interkassa' class='nocsrf co2b' action='".$ENDPOINT ." ' method='post' accept-charset='UTF-8'>
  <input type='hidden' name='ik_co_id' value='".$mrhLogin."' />
  <input type='hidden' name='ik_pm_no' value='".$transaction_id."' />
  <input type='hidden' name='ik_am' value='".$fAmount."' />
  <input type='hidden' name='ik_desc' value='".$sDescription."' />
  <input type='hidden' name='ik_cur' value='".$OutSumCurrency."' />
  <input type='hidden' name='ik_ia_u' value='".$NOTIFICATION."' />
  <input type='hidden' name='ik_ia_m' value='POST' />
  <input type='hidden' name='ik_suc_u' value='".$SUCCESS."' />
  <input type='hidden' name='ik_suc_m' value='POST' />
  <input type='hidden' name='ik_pnd_u' value='".$PENDING."' />
  <input type='hidden' name='ik_pnd_m' value='POST' />
  <input type='hidden' name='ik_fal_u' value='".$FAIL."' />
  <input type='hidden' name='ik_fal_m' value='POST' />
  <button type='submit' name='interkassa' class='chekout udisbutton'>Interkassa</button>
   </form>
        ";   
		  
		  }
		  
    }
?>