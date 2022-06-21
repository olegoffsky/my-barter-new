<?php
/*
 
Code was developed in - installPay.ru
Adding other payment systems - installPay.ru

*/


class Modelfortumo {


    public function __construct(){}

    public static function button ( $outSumm, $description, $invId, $userid, $type, $labelButton, $co_num ){
	
        $mrhLogin = osc_get_preference('fortumo_mrhlogin', 'rupayments');
		$OutSumCurrency = osc_get_preference('currency', 'rupayments');
		$Lang2co = osc_get_preference('fortumo_language', 'rupayments');
        $returnLinkUrl = osc_base_url() . 'oc-content/plugins/rupayments/payments/fortumo/return.php';
		if(osc_get_preference('fortumo_sandbox', 'rupayments')==1) {
                $ENDPOINT     = 'http://pay.fortumo.com/mobile_payments/'.$mrhLogin;
            } else {
                $ENDPOINT     = 'http://pay.fortumo.com/mobile_payments/'.$mrhLogin;
            }


$useridAr=array('userid'=>$userid,
'type'=>$type,
'invId'=>$invId);
$useridJson=base64_encode(json_encode($useridAr));

//$signString2=md5('amount=1cuid='.$useridJson.'currency='.$OutSumCurrency.'price='.$outSumm.''.$fortumo_secret_word);

        print "
	<form name='fort_".$co_num."' class='nocsrf co2b' action='".$ENDPOINT ." ' method='get'>
  <input type='hidden' name='service_id' value='".$mrhLogin."' />
  <input type='hidden' name='cuid' value='".$useridJson."' />
  <button type='submit'  name='fort' class='fortumo udisbutton'>Fortumo</button>
   </form>
        ";  
		  
		  }
		  
    }