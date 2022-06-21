<?php
		   /*
 * Copyright 2017 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

class Robokassa {


    public function __construct(){}
    public static function button($sItemEmail = '', $fAmount = '0.00', $sProductType = '', $iItemId = 0, $sDescription){
        $mrhLogin = osc_get_preference('mrhlogin', 'rupayments');
        $mrhPass1 = osc_get_preference('mrhpass1', 'rupayments');
		$OutSumCurrency = osc_get_preference('currency', 'rupayments');
        $crc  = md5("$mrhLogin:$fAmount:0:$mrhPass1:shp_item=$iItemId:shp_product=$sProductType:shp_user=$sItemEmail");
		$crcue  = md5("$mrhLogin:$fAmount:0:$OutSumCurrency:$mrhPass1:shp_item=$iItemId:shp_product=$sProductType:shp_user=$sItemEmail");
        $encoding = 'utf-8';
		if(osc_get_preference('robo_sandbox', 'rupayments')==1){
		$test = 1;
		}else{
		$test = 0;
		}
		if($OutSumCurrency == "RUB") {

        print "<form class='nocsrf rbc' action='https://auth.robokassa.ru/Merchant/Index.aspx'  method='POST' accept-charset='UTF-8'>
                    <input type='hidden' name='MerchantLogin' value='".$mrhLogin."' />
                    <input type='hidden' name='OutSum' value='".$fAmount."' />
                    <input type='hidden' name='InvId' value='0' />
                    <input type='hidden' name='Description' value='".$sDescription."' />
                    <input type='hidden' name='SignatureValue' value='".$crc."' />
					<input type='hidden' name='shp_item' value='".$iItemId."' />
					<input type='hidden' name='shp_product' value='".$sProductType."' />
					<input type='hidden' name='shp_user' value='".$sItemEmail."' />
                    <input type='hidden' name='Encoding' value='".$encoding."' />
					<input type='hidden' name='IsTest' value='".$test."' />					
                    <button type='submit' name='robokassa' class='stripe udisbutton'>Robokassa</button>
                  
               </form>
        ";
		  }else{

        print "<form class='nocsrf rbc' action='https://auth.robokassa.ru/Merchant/Index.aspx'  method='POST' accept-charset='UTF-8'>
                    <input type='hidden' name='MerchantLogin' value='".$mrhLogin."' />
                    <input type='hidden' name='OutSum' value='".$fAmount."' />
                    <input type='hidden' name='InvId' value='0' />
					<input type='hidden' name='OutSumCurrency' value='".$OutSumCurrency."' />
                    <input type='hidden' name='Description' value='".$description."' />
                    <input type='hidden' name='SignatureValue' value='".$crcue."' />
                    <input type='hidden' name='shp_item' value='".$iItemId."' />
					<input type='hidden' name='shp_product' value='".$sProductType."' />
					<input type='hidden' name='shp_user' value='".$sItemEmail."' />
                    <input type='hidden' name='Encoding' value='".$encoding."' />
					<input type='hidden' name='IsTest' value='".$test."' />	
                    <button type='submit' name='robokassa' class='stripe udisbutton'>Robokassa</button>
               </form>
        ";
		  }
		  
    }


}