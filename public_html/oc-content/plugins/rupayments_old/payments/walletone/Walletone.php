<?php
		   /*
 * Copyright 2017 osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
class Walletone {

    public function __construct(){}

    public static function button($sItemEmail = '', $outSumm  = '0.00', $type = '', $invId = 0, $inv_desc){
		usleep(1200000);
		$transaction_id = 'Wo'. time();
	    $SUCESSURL = osc_base_url() . 'oc-content/plugins/rupayments/payments/walletone/success.php' ;
        $CANCELURL = osc_base_url() . 'oc-content/plugins/rupayments/payments/walletone/fail.php';
        $mrhLogin = osc_get_preference('wologin', 'rupayments');
		$mrhPass1 = osc_get_preference('wopass1', 'rupayments');
		$culture = ruwopaycur();
        $shpType = $type;
	    ModelRUpayments::newInstance()->saveTransactionId ( $transaction_id, $sItemEmail, $outSumm, $type, $invId );
        $fields = array();
          $fields["WMI_MERCHANT_ID"]    = $mrhLogin ;
          $fields["WMI_PAYMENT_AMOUNT"] = $outSumm ;
          $fields["WMI_CURRENCY_ID"]    = $culture ;
		  $fields["WMI_PAYMENT_NO"]     = $transaction_id ;
          $fields["WMI_DESCRIPTION"]    = "BASE64:".base64_encode($inv_desc);
		  $fields["WMI_SUCCESS_URL"]    = $SUCESSURL ;
          $fields["WMI_FAIL_URL"]       = $CANCELURL ;
          $fields["shpType"]       = $shpType ;
          $fields["shpBype"]       = $invId ; 
		  
foreach($fields as $name => $val)
          {
            if (is_array($val))
            {
               usort($val, "strcasecmp");
               $fields[$name] = $val;
            }
          }
 uksort($fields, "strcasecmp");
          $fieldValues = "";
 
          foreach($fields as $value)
          {
              if (is_array($value))
                 foreach($value as $v)
                 {
                    $v = iconv("utf-8", "windows-1251", $v);
                    $fieldValues .= $v;
                 }
             else
            {
               $value = iconv("utf-8", "windows-1251", $value);
               $fieldValues .= $value;
            }
          }		  
 $signature = base64_encode(pack("H*", md5($fieldValues . $mrhPass1)));
 $fields["WMI_SIGNATURE"] = $signature;
            
 
        print "<form action='https://wl.walletone.com/checkout/checkout/Index' class='nocsrf' method='POST' accept-charset='UTF-8'>
                    <input type='hidden' name='WMI_MERCHANT_ID' value='".$mrhLogin."' />
                    <input type='hidden' name='WMI_PAYMENT_AMOUNT' value='".$outSumm."' />
					<input type='hidden' name='WMI_CURRENCY_ID' value='".$culture."' />
					<input type='hidden' name='WMI_PAYMENT_NO' value='".$transaction_id."' />
                    <input type='hidden' name='WMI_DESCRIPTION' value='"."BASE64:".base64_encode($inv_desc)."' />
					<input type='hidden' name='WMI_SUCCESS_URL' value='".$SUCESSURL."' />
					<input type='hidden' name='WMI_FAIL_URL' value='".$CANCELURL."' />
					<input type='hidden' name='shpType' value='".$shpType."' />
					<input type='hidden' name='shpBype' value='".$invId."' />
                    <input type='hidden' name='WMI_SIGNATURE' value='".$signature."' />
                    <button type='submit' name='walletone' class='stripe udisbutton'>Walletone</button>
               </form>
        ";
    }


}