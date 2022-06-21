<?php
		   /*
 * Copyright 2015 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
class ModelChekout {


    public function __construct(){}


    /**
     * @param $outSumm
     * @param $invId
     * @param $type
     * @param $labelButton
     */
    public static function button ( $outSumm, $description, $invId, $userid, $type, $labelButton, $co_num, $curCode = false ){
        $mrhLogin = osc_get_preference('mrhlogin', 'rupayments');
        if($curCode) $OutSumCurrency = $curCode;
            else $OutSumCurrency = osc_get_preference('currency', 'rupayments');
		$Lang2co = osc_get_preference('language', 'rupayments');
        $returnLinkUrl = osc_base_url() . 'oc-content/plugins/rupayments/payments/2chekout/return.php ';
		if(osc_get_preference('co2_sandbox', 'rupayments')==1) {
                $ENDPOINT     = 'https://sandbox.2checkout.com/checkout/purchase';
            } else {
                $ENDPOINT     = 'https://www.2checkout.com/checkout/purchase';
            }

        print "<form name='2co_".$co_num."' class='nocsrf co2b' action='".$ENDPOINT ." ' method='post'>
  <input type='hidden' name='sid' value='".$mrhLogin."' />
  <input type='hidden' name='mode' value='2CO' />
  <input type='hidden' name='li_0_type' value='product' />
  <input type='hidden' name='li_0_name' value='".$description."' />
  <input type='hidden' name='li_0_quantity' value='1' />
  <input type='hidden' name='li_0_price' value='".$outSumm."' />
  <input type='hidden' name='li_0_tangible' value='N' />
  <input type='hidden' name='lang' value='".$Lang2co."'>
  <input type='hidden' name='li_0_co2_option_id' value='".$type."' />
  <input type='hidden' name='li_0_co2_item_id' value='".$invId."' />
  <input type='hidden' name='li_0_co2_user_id' value='".$userid."' />
  <input type='hidden' name='currency_code' value='".$OutSumCurrency."' />
  <button type='submit' name='2co_".$co_num."' class='chekout udisbutton'>2Chekout</button>
   </form>
        ";   
		  
		  }
		  
    }