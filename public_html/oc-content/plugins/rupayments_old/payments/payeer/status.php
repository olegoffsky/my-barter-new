<?php

define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
require_once ABS_PATH . 'oc-load.php';

if (Params::getParam('m_operation_id') !== '' && Params::getParam('m_sign') !== '')
{
	$err = false;
	$message = '';
	$sTransactionId = Params::getParam('m_orderid');
	
	// проверка существования заказа
	
	if (ModelRUpayments::newInstance()->isTransactionMade($sTransactionId)) 
	{
		$message .= __(' - undefined order id', 'rupayments') . "\n";
		$err = true;
	}
	else
	{


		$sign_hash = strtoupper(hash('sha256', implode(":", array(
			Params::getParam('m_operation_id'),
			Params::getParam('m_operation_ps'),
			Params::getParam('m_operation_date'),
			Params::getParam('m_operation_pay_date'),
			Params::getParam('m_shop'),
			Params::getParam('m_orderid'),
			Params::getParam('m_amount'),
			Params::getParam('m_curr'),
			Params::getParam('m_desc'),
			Params::getParam('m_status'),
			osc_get_preference('payeer_secret_key', 'rupayments')
		))));
		
		$valid_ip = true;
		$sIP = str_replace(' ', '', osc_get_preference('payeer_ip_filter', 'rupayments'));
		
		if (!empty($sIP))
		{
			$arrIP = explode('.', $_SERVER['REMOTE_ADDR']);
			if (!preg_match('/(^|,)(' . $arrIP[0] . '|\*{1})(\.)' .
			'(' . $arrIP[1] . '|\*{1})(\.)' .
			'(' . $arrIP[2] . '|\*{1})(\.)' .
			'(' . $arrIP[3] . '|\*{1})($|,)/', $sIP))
			{
				$valid_ip = false;
			}
		}
		
		if (!$valid_ip)
		{
			$message .= __(' - the ip address of the server is not trusted', 'rupayments') . "\n" .
			__('   trusted ip: ', 'rupayments') . $sIP . "\n" .
			__('   the ip of the current server: ', 'rupayments') . $_SERVER['REMOTE_ADDR'] . "\n";
			$err = true;
		}

		if (Params::getParam('m_sign') != $sign_hash)
		{
			$message .= __(' - do not match the digital signature', 'rupayments') . "\n";
			$err = true;
		}

		if (!$err)
		{
			// загрузка заказа
			
			$order = ModelRUpayments::newInstance()->getTransaction(Params::getParam('m_orderid'));
			$order_curr = $order['s_currency_code'] == 'RUR' ? 'RUB' : $order['s_currency_code'];
			$order_amount = number_format($order['f_amount'], 2, '.', '');
			
			// проверка суммы и валюты
		
			if (Params::getParam('m_amount') != $order_amount)
			{
				$message .= __(' - wrong amount', 'rupayments') . "\n";
				$err = true;
			}

			if (Params::getParam('m_curr') != $order_curr)
			{
				$message .= __(' - wrong currency', 'rupayments') . "\n";
				$err = true;
			}
			
			// проверка статуса
			
			if (!$err)
			{
				switch (Params::getParam('m_status'))
				{
					case 'success':
					
						$product_type = $order['i_product_type'];
						$iItemId = $order['fk_i_item_id'];
						
						if ($iItemId)
						{
							$item = Item::newInstance()->findByPrimaryKey($iItemId); 
							$iUser = $item['fk_i_user_id'];
						}
						
						if (  stristr ( $product_type, '50' ) || $product_type == '601' || $product_type == '901' || $product_type == '1001' ) {
                $user = User::newInstance()->findByEmail( $order['s_email'] );
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
					
						$sConcept = '';
					
			if (ModelRUpayments::newInstance()->getIsPublishPaymentNeeded($iItemId))
						{
						if ( $product_type == "201" ) {
                    $product_type = "202";
                    $sConcept = __('Publish and Make Item Premium', 'rupayments');
                }
                if ( $product_type == "301" ) {
                    $product_type = "302";
                    $sConcept = __('Publish and Make Item Highlighted', 'rupayments');
                }
                if ( $product_type == "701" ) {
                    $product_type = "702";
                    $sConcept = __('Publish and Show Image', 'rupayments');
                }
                if ( $product_type == "711" ) {
                    $product_type = "712";
                    $sConcept = __('Publish, Make Item Premium and Show Image', 'rupayments');
                }
                if ( $product_type == "721" ) {
                    $product_type = "722";
                    $sConcept = __('Publish, Make Item Highlighted and Show Image', 'rupayments');
                }
                if ( $product_type == "731" ) {
                    $product_type = "732";
                    $sConcept = __('Publish, Make Item Premium, Make Item Highlighted and Show Image', 'rupayments');
                }
                if ( $product_type == "801" ) {
                    $product_type = "802";
                    $sConcept = __('Publish and Apply: Pack 3-in-1', 'rupayments');
                }
                if ( $product_type == "811" ) {
                    $product_type = "812";
                    $sConcept = __('Publish, Activate Show Image and apply: Pack 3-in-1', 'rupayments');
                }
                if ( $product_type == "231" ) {
                    $product_type = "232";
                    $sConcept = __('Publish and Make Item Highlighted and Premium', 'rupayments');
                }
            }
            // и если не надо
            else {
                if ( $product_type == "201" ) $sConcept = __('Make Item Premium', 'rupayments');
                if ( $product_type == "301" ) $sConcept = __('Make Item Highlighted', 'rupayments');
                if ( $product_type == "701" ) $sConcept = __('Show Image', 'rupayments');
                if ( $product_type == "711" ) $sConcept = __('Make Item Premium and Show Image', 'rupayments');
                if ( $product_type == "721" ) $sConcept = __('Make Item Highlighted and Show Image', 'rupayments');
                if ( $product_type == "731" ) $sConcept = __('Make Item Premium, Make Item Highlighted and Show Image', 'rupayments');
                if ( $product_type == "801" ) $sConcept = __('Apply: Pack 3-in-1', 'rupayments');
                if ( $product_type == "811" ) $sConcept = __('Activate Show Image and apply: Pack 3-in-1', 'rupayments');
                if ( $product_type == "231" ) $sConcept = __('Make Item Highlighted and Premium', 'rupayments');
            }
                    
            if ( $product_type == "101" ) $sConcept = __('Publish Item', 'rupayments');
            if ( $product_type == "501" ) $sConcept = $pack_name . $bonus_text;
            if ( $product_type == "601" ) $sConcept = __("Payment of membership fee: ", 'rupayments') . $user_group_title;
            if ( $product_type == "901" ) $sConcept = __('Payment of banner public fee: ', 'rupayments') . $iItemId;
            if ( $product_type == "1001" ) $sConcept = __('Payment of Item Purchase: ', 'rupayments') . $item_title;
			if ( $product_type == "401" ) $sConcept = __('Move to TOP', 'rupayments');
			if ( $product_type == "411" ) $sConcept = __('Renew item', 'rupayments');

						$payment_id = ModelRUpayments::newInstance()->saveLog(
							$sConcept,
							$order['s_transaction_id'],
							$order_amount,
							$order_curr,
							$order['s_email'] !== '' ? $order['s_email'] : '',
							$iUser,
							$iItemId,
							$product_type,
							'Payeer'
						);

						if (isset(ModelRUpayments::newInstance()->lastId))
						{
							$payment_id = ModelRUpayments::newInstance()->lastId;
						}

						 if ($product_type == '101') {
                ModelRUpayments::newInstance()->payPublishFee ( $iItemId, $payment_id ); 
				if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($iItemId)) ModelRUpayments::newInstance()->setImageShow($iItemId, 0);
            } else if ( $product_type == '201' || $product_type == '202' ) {
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $iItemId, $payment_id );
				if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($iItemId)) ModelRUpayments::newInstance()->setImageShow($iItemId, 0);
                ModelRUpayments::newInstance()->payPremiumFee ( $iItemId, $payment_id ); 
	    }
	     else if ( $product_type == '301' || $product_type == '302' ) {
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $iItemId, $payment_id );
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($iItemId)) ModelRUpayments::newInstance()->setImageShow($iItemId, 0);
                
                ModelRUpayments::newInstance()->setColor ( $iItemId ); 
	    }
        else if ( $product_type == '701' || $product_type == '702' ) {
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $iItemId, $payment_id );
                ModelRUpayments::newInstance()->setImageShow($iItemId, 1);
	    }
        else if ( $product_type == '711' || $product_type == '712' ) {
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $iItemId, $payment_id );
                ModelRUpayments::newInstance()->setImageShow($iItemId, 1);
                ModelRUpayments::newInstance()->payPremiumFee ( $iItemId, $payment_id );
	    }
        else if ( $product_type == '721' || $product_type == '722' ) {
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $iItemId, $payment_id );
                ModelRUpayments::newInstance()->setImageShow($iItemId, 1);
                ModelRUpayments::newInstance()->setColor ( $iItemId );
	    }
        else if ( $product_type == '731' || $product_type == '732' ) {
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $iItemId, $payment_id );
                ModelRUpayments::newInstance()->setImageShow($iItemId, 1);
                ModelRUpayments::newInstance()->payPremiumFee ( $iItemId, $payment_id );
                ModelRUpayments::newInstance()->setColor ( $iItemId );
	    }
        else if ( $product_type == '801' || $product_type == '802' ) {
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $iItemId, $payment_id );
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($iItemId)) ModelRUpayments::newInstance()->setImageShow($iItemId, 0);
                
                ModelRUpayments::newInstance()->setPack3in1($iItemId, $payment_id);
	    }
        else if ( $product_type == '811' || $product_type == '812' ) {
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $iItemId, $payment_id );
                
                ModelRUpayments::newInstance()->setPack3in1($iItemId, $payment_id);
                ModelRUpayments::newInstance()->setImageShow($iItemId, 1);
	    }
        else if ( $product_type == '901') {
                ModelRUpayments::newInstance()->setUserBannerPay($iItemId);
	    }
        else if ( $product_type == '1001') {
                ModelRUpayments::newInstance()->setEbuyDealPay($iItemId, $iUser);
	    }
	    else if ($product_type == '401') {
     ModelRUpayments::newInstance()->setTopItem ( $iItemId );  
            } else if ($product_type == '411') {
                ModelRUpayments::newInstance()->setRenew ( $iItemId );  
            }
            else if ( $product_type == '231' || $product_type == '232' ) {
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemId ) ) ModelRUpayments::newInstance()->payPublishFee ( $iItemId, $payment_id );
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($iItemId)) ModelRUpayments::newInstance()->setImageShow($iItemId, 0);
                
                ModelRUpayments::newInstance()->payPremiumWithColorFee ( $iItemId, $payment_id );
            }
            else if ($product_type == '601') {
                ModelRUpayments::newInstance()->setUserMembership($iItemId, $iUser);
            }
            else {
                ModelRUpayments::newInstance()->addWallet ( $iUser, Params::getParam('m_amount')!=''?Params::getParam('m_amount') + $bonus_amount:Params::getParam('m_amount') + $bonus_amount);
            }

						break;
						
					default:
						$message .= __(' - the payment status is not success', 'rupayments') . "\n";
						$err = true;
						break;
				}
			}
		}
		
		if ($err)
		{

			
			exit(Params::getParam('m_orderid') . '|error');
		}
		else
		{
			exit(Params::getParam('m_orderid') . '|success');
		}
	}
}

?>