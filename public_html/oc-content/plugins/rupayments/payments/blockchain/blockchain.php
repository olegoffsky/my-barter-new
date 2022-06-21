<?php
		   /*
 * Copyright 2016 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
class Modelblockchain {


    public function __construct(){


}

    public static function button ( $outSumm, $description, $invId, $userid, $type, $labelButton, $co_num ){
	
        $my_xpub = osc_get_preference('blockchain_mrhlogin', 'rupayments');
        $secret_word = osc_get_preference('blockchain_secret_word', 'rupayments');
        $my_api_key = osc_get_preference('blockchain_api_key_word', 'rupayments');
		


$useridAr=array('userid'=>(int)$userid,
'type'=>(int)$type,
'invId'=>(int)$invId);
$useridJson=base64_encode(json_encode($useridAr));


	  
 

		
 
 echo"<script>
function getbit".$type.$invId.$co_num."()
     {


$.ajax({
type: \"POST\",
dataType: \"text\",
url:  '".osc_base_url() . "oc-content/plugins/rupayments/payments/blockchain/create.php',
data: 'amount=' + '".$outSumm."' + '&useridJson=' + '". $useridJson."' + '&description=' + '". base64_encode($description)."',
cache: false,
success: function(text){
document.getElementById(\"ollpaysystem\").innerHTML = text;

}
}
);

return false;
}
</script>
";
       print "
	
  <button class='nocsrf co2b udisbutton bitcoin' type='submit' onclick='getbit".$type.$invId.$co_num."()' name='fort_".$co_num."'>Bitcoin</button>
   
        ";  
		  
		  }
		  
    }