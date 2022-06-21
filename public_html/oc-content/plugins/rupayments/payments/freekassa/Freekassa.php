<?php

class Freekassa {

    public function __construct(){}
	
    public static function button ( $sItemEmail = '', $fAmount = '0.00', $sProductType = '', $iItemId = 0, $sDescription){
		usleep(1200000);
		$transaction_id = 'Fr'. time();
        $mrhLogin = osc_get_preference('ik_co_id_free', 'rupayments');
		$secret_word = osc_get_preference('freekassa_secret', 'rupayments');
        $ENDPOINT     = 'http://www.free-kassa.ru/merchant/cash.php';
		$sign = md5($mrhLogin.':'.$fAmount.':'.$secret_word.':'.$transaction_id);
        ModelRUpayments::newInstance()->saveTransactionId ( $transaction_id, $sItemEmail, $fAmount, $sProductType, $iItemId );


        print "<form name='interkassa' class='nocsrf' action='".$ENDPOINT ." ' method='GET' accept-charset='UTF-8'>
  <input type='hidden' name='m' value='".$mrhLogin."' />
  <input type='hidden' name='o' value='".$transaction_id."' />
  <input type='hidden' name='oa' value='".$fAmount."' />
  <input type='hidden' name='s' value='".$sign."' />
  <button type='submit' name='freekassa' class='chekout udisbutton'>Freekassa</button>
   </form>
        ";   
		  
		  }
}