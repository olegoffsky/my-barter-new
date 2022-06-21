<?php define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');

require_once ABS_PATH . 'oc-load.php';
require_once 'ModelLiqpay.php';

class Liqpay {
    
    public static function button($sItemEmail = '', $fAmount = '0.00', $sProductType = '', $iItemId = 0, $sDescription){
        
        if(osc_get_preference('lp_sandbox', 'rupayments')) {
            $public_key = osc_get_preference('lp_test_public_key', 'rupayments');
            $private_key = osc_get_preference('lp_test_private_key', 'rupayments');
        }
        else {
            $public_key = osc_get_preference('lp_public_key', 'rupayments');
            $private_key = osc_get_preference('lp_private_key', 'rupayments');
        }
        
        $order_id = 'liqpay_' . md5(strrev(uniqid . $iItemId . time()));
        
        $liqpay = new ModelLiqpay($public_key, $private_key);
        $html = $liqpay->cnb_form(array(
            'action'         => 'pay',
            'amount'         => $fAmount,
            'currency'       => osc_get_preference('currency', 'rupayments'),
            'description'    => $sDescription,
            'order_id'       => $order_id,
            'version'        => '3',
            'result_url'     => PLUGINS_WEB_PATH . 'rupayments/payments/liqpay/result.php',
            'server_url'     => PLUGINS_WEB_PATH . 'rupayments/payments/liqpay/return.php'
        ));
        
        ModelRUpayments::newInstance()->saveTransactionId ( $order_id, $sItemEmail, $fAmount, $sProductType, $iItemId );
        
        print $html;
    }
}

?>