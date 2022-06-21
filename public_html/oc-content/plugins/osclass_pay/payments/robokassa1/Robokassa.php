<?php
		   /*
 * Copyright 2017 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

class RobokassaPayment {


    public function __construct(){}
    public static function button($amount = '0.00', $description = '', $itemnumber = '', $extra_array = null){
        $mrhLogin = osc_get_preference('mrhlogin', 'rupayments');
        $mrhPass1 = osc_get_preference('mrhpass1', 'rupayments');
    $extra = osp_prepare_custom($extra_array) . '|';
    $extra .= 'concept,'.$description.'|';
    $extra .= 'product,'.$itemnumber.'|';
    $r = rand(0,1000);
    $extra .= 'r,'.$r;
    $order_id = Params::getParam('order_id');
    $transaction_id = Params::getParam('transaction_id');
    $product_type = explode('x', $data['product']);
    $email = osc_logged_user_email(); 
    $shop_id = osp_param('yandex_shop_id');
    $secret_key = osp_decrypt(osp_param('yandex_api_secret'));
    $user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());
    $transaction_id = 'ym_' . mb_generate_rand_string(10);
		$OutSumCurrency = osc_get_preference('currency', 'rupayments');
        $crc  = md5("$mrhLogin:$amount:0:$mrhPass1:shp_item=$itemnumber:shp_product=$producttype:shp_user=$email");
		$crcue  = md5("$mrhLogin:$amount:0:$OutSumCurrency:$mrhPass1:shp_item=$itemnumber:shp_product=$producttype:shp_user=$email");
        $encoding = 'utf-8';
		if(osc_get_preference('robo_sandbox', 'rupayments')==1){
		$test = 1;
		}else{
		$test = 0;
		}
		if($OutSumCurrency == "RUB") {

        print "<form class='nocsrf rbc' action='https://auth.robokassa.ru/Merchant/Index.aspx'  method='POST' accept-charset='UTF-8'>
                    <input type='hidden' name='MerchantLogin' value='".$mrhLogin."' />
                    <input type='hidden' name='OutSum' value='".$amount."' />
                    <input type='hidden' name='InvId' value='0' />
                    <input type='hidden' name='Description' value='".$description."' />
                    <input type='hidden' name='SignatureValue' value='".$crc."' />
					<input type='hidden' name='shp_item' value='".$itemnumber."' />
					<input type='hidden' name='shp_product' value='".$order_id."' />
					<input type='hidden' name='shp_user' value='".$email."' />
                    <input type='hidden' name='Encoding' value='".$encoding."' />
					<input type='hidden' name='IsTest' value='".$test."' />					
                    <button type='submit' name='robokassa' class='stripe udisbutton'>Robokassa</button>
                  
               </form>
        ";
		  }else{

        print "<form class='nocsrf rbc' action='https://auth.robokassa.ru/Merchant/Index.aspx'  method='POST' accept-charset='UTF-8'>
                    <input type='hidden' name='MerchantLogin' value='".$mrhLogin."' />
                    <input type='hidden' name='OutSum' value='".$amount."' />
                    <input type='hidden' name='InvId' value='0' />
					<input type='hidden' name='OutSumCurrency' value='".$OutSumCurrency."' />
                    <input type='hidden' name='Description' value='".$description."' />
                    <input type='hidden' name='SignatureValue' value='".$crcue."' />
                    <input type='hidden' name='shp_item' value='".$itemnumber."' />
					<input type='hidden' name='shp_product' value='".$producttype."' />
					<input type='hidden' name='shp_user' value='".$sItemEmail."' />
                    <input type='hidden' name='Encoding' value='".$encoding."' />
					<input type='hidden' name='IsTest' value='".$test."' />	
                    <button type='submit' name='robokassa' class='stripe udisbutton'>Robokassa</button>
               </form>
        ";
		  }
		  
    }


}