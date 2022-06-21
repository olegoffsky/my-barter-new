<?php

class Payeer {

    public function __construct(){}
	
    public static function button($sItemEmail = '', $fAmount = '0.00', $sProductType = '', $iItemId = 0, $sDescription){
		
		usleep(1200000);
		
		$m_url = 'https://payeer.com/merchant/';
		$m_shop = osc_get_preference('payeer_merchant_id', 'rupayments');
		$m_orderid = 'Pr'. time();
		$m_amount = number_format($fAmount, 2, '.', '');
		$m_curr = strtoupper(osc_get_preference('currency', 'rupayments'));
		$m_curr = $m_curr == 'RUR' ? 'RUB' : $m_curr;
		$m_desc = base64_encode($sDescription);
		$m_key = osc_get_preference('payeer_secret_key', 'rupayments');

		$arHash = array(
			$m_shop,
			$m_orderid,
			$m_amount,
			$m_curr,
			$m_desc,
			$m_key
		);
		$sign = strtoupper(hash('sha256', implode(":", $arHash)));
		
		if (in_array($m_curr, array('RUB', 'USD', 'EUR')))
		{
			ModelRUpayments::newInstance()->saveTransactionId($m_orderid, $sItemEmail, $fAmount, $sProductType, $iItemId);
			
			print '<form class="nocsrf" action="' . $m_url . '" method="GET">	
				<input type="hidden" name="m_shop" value="' . $m_shop . '" />
				<input type="hidden" name="m_orderid" value="' . $m_orderid . '" />
				<input type="hidden" name="m_amount" value="' . $m_amount . '" />
				<input type="hidden" name="m_curr" value="' . $m_curr . '" />
				<input type="hidden" name="m_desc" value="' . $m_desc . '" />
				<input type="hidden" name="m_sign" value="' . $sign . '" />
				<button type="submit" name="payeer" class="stripe udisbutton">Payeer</button>
			</form>';
		}
    }
}