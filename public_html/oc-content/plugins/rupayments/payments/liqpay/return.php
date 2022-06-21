<?php define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');



require_once ABS_PATH . 'oc-load.php';

require_once 'ModelLiqpay.php';



$result = Params::getParam('data');

$result_signature = Params::getParam('signature');



if(osc_get_preference('lp_sandbox', 'rupayments')) {

    $public_key = osc_get_preference('lp_test_public_key', 'rupayments');

    $private_key = osc_get_preference('lp_test_private_key', 'rupayments');

}

else {

    $public_key = osc_get_preference('lp_public_key', 'rupayments');

    $private_key = osc_get_preference('lp_private_key', 'rupayments');

}



$parsed_data = json_decode(base64_decode($result), true);



$liqpay = new ModelLiqpay($public_key, $private_key);

$signature = $liqpay->check_signature($result);

//file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/response.txt', serialize($parsed_data));

$order_id = $parsed_data['order_id'];



if($result_signature == $signature && $parsed_data['status'] == 'success') {

    $currency = osc_get_preference('currency', 'rupayments');

    

    $order = ModelRUpayments::newInstance()->getTransaction($order_id);

    

    if (!ModelRUpayments::newInstance()->isTransactionMade($order_id)) {

        $product_type = $order['i_product_type'];

        $iItemId = $order['fk_i_item_id'];

        

        if ($iItemId) {

            $item = Item::newInstance()->findByPrimaryKey($iItemId); 

            $iUser = $item['fk_i_user_id'];

        }

        

        if (stristr($product_type, '50') || $product_type == '601' || $product_type == '901' || $product_type == '1001') {

            $user = User::newInstance()->findByEmail($order['s_email']);

            $iUser = $user['pk_i_id'];

        }

        

        $bonus = ''; $bonus_text = ''; $bonus_amount = ''; $pack_name = '';

        $user_group = ''; $user_group_title = ''; $ebuy_item = ''; $item = ''; $item_title = '';

        

        switch($product_type) {

            case "501" :

                $bonus = ModelRUpayments::newInstance()->getPack($iItemId);

                if($bonus) {

                    $pack_name = $bonus['f_pack_title'];

                    

                    if($bonus['f_pack_bonus']) {

                        $bonus_amount = $bonus['f_pack_bonus'];

                        $bonus_text = __(' + Bonus: ', 'rupayments') . $bonus_amount . osc_get_preference('currency', 'rupayments');    

                    }

                }

            break;

            

            case "601" :

                $user_group = ModelRUpayments::newInstance()->getUserGroup($iItemId);

                $user_group_title = $user_group['f_group_title'];

            break;

            

            case "1001" :

                $ebuy_item = ModelRUpayments::newInstance()->getEbuyItem($iItemId, true);

                $item = Item::newInstance()->findByPrimaryKey($ebuy_item['i_item_id']);

                $item_title = $item['s_title'];

            break;

        }

    

        $sConcept = "";

        

        // SAVE TRANSACTION LOG

                    

        // Корректируем коды типа услуги (для полноты отчета в логе) на случай, 

        // если платить за публикацию надо

        if (ModelRUpayments::newInstance()->getIsPublishPaymentNeeded($iItemId)) {

            if ($product_type == "201") {

                $product_type = "202";

                $sConcept = __('Publish and Make Item Premium', 'rupayments');

            }

            if ($product_type == "301") {

                $product_type = "302";

                $sConcept = __('Publish and Make Item Highlighted', 'rupayments');

            }

            if ($product_type == "701") {

                $product_type = "702";

                $sConcept = __('Publish and Show Image', 'rupayments');

            }

            if ($product_type == "711") {

                $product_type = "712";

                $sConcept = __('Publish, Make Item Premium and Show Image', 'rupayments');

            }

            if ($product_type == "721") {

                $product_type = "722";

                $sConcept = __('Publish, Make Item Highlighted and Show Image', 'rupayments');

            }

            if ($product_type == "731") {

                $product_type = "732";

                $sConcept = __('Publish, Make Item Premium, Make Item Highlighted and Show Image', 'rupayments');

            }

            if ($product_type == "801") {

                $product_type = "802";

                $sConcept = __('Publish and Apply: Pack 3-in-1', 'rupayments');

            }

            if ($product_type == "811") {

                $product_type = "812";

                $sConcept = __('Publish, Activate Show Image and apply: Pack 3-in-1', 'rupayments');

            }

            if ($product_type == "231") {

                $product_type = "232";

                $sConcept = __('Publish and Make Item Highlighted and Premium', 'rupayments');

            }

        }

        else {

            if ($product_type == "201") $sConcept = __('Make Item Premium', 'rupayments');

            if ($product_type == "301") $sConcept = __('Make Item Highlighted', 'rupayments');

            if ($product_type == "701") $sConcept = __('Show Image', 'rupayments');

            if ($product_type == "711") $sConcept = __('Make Item Premium and Show Image', 'rupayments');

            if ($product_type == "721") $sConcept = __('Make Item Highlighted and Show Image', 'rupayments');

            if ($product_type == "731") $sConcept = __('Make Item Premium, Make Item Highlighted and Show Image', 'rupayments');

            if ($product_type == "801") $sConcept = __('Apply: Pack 3-in-1', 'rupayments');

            if ($product_type == "811") $sConcept = __('Activate Show Image and apply: Pack 3-in-1', 'rupayments');

            if ($product_type == "231") $sConcept = __('Make Item Highlighted and Premium', 'rupayments');

        }

                

        if ($product_type == "101") $sConcept = __('Publish Item', 'rupayments');

        if ($product_type == "501") $sConcept = $pack_name . $bonus_text;

        if ($product_type == "601") $sConcept = __("Payment of membership fee: ", 'rupayments') . $user_group_title;

        if ($product_type == "901") $sConcept = __('Payment of banner public fee: ', 'rupayments') . $iItemId;

        if ($product_type == "1001") $sConcept = __('Payment of Item Purchase: ', 'rupayments') . $item_title;

		if ($product_type == "401") $sConcept = __('Move to TOP', 'rupayments');

		if ($product_type == "411") $sConcept = __('Renew item', 'rupayments');

    

       

        $payment_id = ModelRUpayments::newInstance()->saveLog(

                                                            $sConcept, //concept

                                                            $order_id,

                                                            $order['f_amount'],

                                                            $currency, //currency

                                                            $order['s_email'] != '' ? $order['s_email'] : '', // payer's email

                                                            $iUser, //user

                                                            $iItemId, //item 

                                                            $product_type, //product type

                                                            'LiqPay'); //source

                

        if (isset(ModelRUpayments::newInstance()->lastId)) $payment_id = ModelRUpayments::newInstance()->lastId;



        if ($product_type == '101') {

            ModelRUpayments::newInstance()->payPublishFee($iItemId, $payment_id); 

			if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($iItemId)) ModelRUpayments::newInstance()->setImageShow($iItemId, 0);

        } else if ($product_type == '201' || $product_type == '202') {

            if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded($iItemId)) ModelRUpayments::newInstance()->payPublishFee($iItemId, $payment_id);

			if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($iItemId)) ModelRUpayments::newInstance()->setImageShow($iItemId, 0);

            ModelRUpayments::newInstance()->payPremiumFee($iItemId, $payment_id); 

        }

         else if ($product_type == '301' || $product_type == '302') {

            if (ModelRUpayments::newInstance()->getIsPublishPaymentNeeded($iItemId)) ModelRUpayments::newInstance()->payPublishFee($iItemId, $payment_id);

            if (osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($iItemId)) ModelRUpayments::newInstance()->setImageShow($iItemId, 0);

            

            ModelRUpayments::newInstance()->setColor ( $iItemId ); 

        }

        else if ($product_type == '701' || $product_type == '702') {

            if (ModelRUpayments::newInstance()->getIsPublishPaymentNeeded($iItemId)) ModelRUpayments::newInstance()->payPublishFee($iItemId, $payment_id);

            ModelRUpayments::newInstance()->setImageShow($iItemId, 1);

        }

        else if ($product_type == '711' || $product_type == '712') {

            if (ModelRUpayments::newInstance()->getIsPublishPaymentNeeded($iItemId)) ModelRUpayments::newInstance()->payPublishFee($iItemId, $payment_id);

            ModelRUpayments::newInstance()->setImageShow($iItemId, 1);

            ModelRUpayments::newInstance()->payPremiumFee ( $iItemId, $payment_id );

        }

        else if ($product_type == '721' || $product_type == '722') {

            if (ModelRUpayments::newInstance()->getIsPublishPaymentNeeded($iItemId)) ModelRUpayments::newInstance()->payPublishFee($iItemId, $payment_id);

            ModelRUpayments::newInstance()->setImageShow($iItemId, 1);

            ModelRUpayments::newInstance()->setColor ($iItemId);

        }

        else if ($product_type == '731' || $product_type == '732') {

            if (ModelRUpayments::newInstance()->getIsPublishPaymentNeeded($iItemId)) ModelRUpayments::newInstance()->payPublishFee($iItemId, $payment_id);

            ModelRUpayments::newInstance()->setImageShow($iItemId, 1);

            ModelRUpayments::newInstance()->payPremiumFee ( $iItemId, $payment_id );

            ModelRUpayments::newInstance()->setColor ( $iItemId );

        }

        else if ($product_type == '801' || $product_type == '802') {

            if (ModelRUpayments::newInstance()->getIsPublishPaymentNeeded($iItemId)) ModelRUpayments::newInstance()->payPublishFee($iItemId, $payment_id);

            if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($iItemId)) ModelRUpayments::newInstance()->setImageShow($iItemId, 0);

            

            ModelRUpayments::newInstance()->setPack3in1($iItemId, $payment_id);

        }

        else if ($product_type == '811' || $product_type == '812') {

            if (ModelRUpayments::newInstance()->getIsPublishPaymentNeeded($iItemId)) ModelRUpayments::newInstance()->payPublishFee($iItemId, $payment_id);

            

            ModelRUpayments::newInstance()->setPack3in1($iItemId, $payment_id);

            ModelRUpayments::newInstance()->setImageShow($iItemId, 1);

        }

        else if ($product_type == '901') {

            ModelRUpayments::newInstance()->setUserBannerPay($iItemId);

        }

        else if ($product_type == '1001') {

            ModelRUpayments::newInstance()->setEbuyDealPay($iItemId, $iUser);

        }

        else if ($product_type == '401') {

            ModelRUpayments::newInstance()->setTopItem($iItemId);  

        } else if ($product_type == '411') {

            ModelRUpayments::newInstance()->setRenew($iItemId);  

        }

        else if ($product_type == '231' || $product_type == '232') {

            if (ModelRUpayments::newInstance()->getIsPublishPaymentNeeded($iItemId)) ModelRUpayments::newInstance()->payPublishFee($iItemId, $payment_id);

            if (osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($iItemId)) ModelRUpayments::newInstance()->setImageShow($iItemId, 0);

            

            ModelRUpayments::newInstance()->payPremiumWithColorFee($iItemId, $payment_id);

        }

        else if ($product_type == '601') {

            ModelRUpayments::newInstance()->setUserMembership($iItemId, $iUser);

        }

        else {

            ModelRUpayments::newInstance()->addWallet($iUser, $order['f_amount'] != '' ? $order['f_amount'] + $bonus_amount : $order['f_amount'] + $bonus_amount);

        }

    }

}