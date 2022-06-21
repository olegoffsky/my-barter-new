<?php
		   /*
 * Copyright 2017 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
    $mrhPass2 = osc_get_preference('mrhpass2', 'rupayments');
	$currency = osc_get_preference('currency', 'rupayments');
    $outSumm = Params::getParam("OutSum");
    $invId = Params::getParam("InvId");
    $product_type = Params::getParam("shp_product");
	$iItemId  = Params::getParam("shp_item");
	$userid = Params::getParam("shp_user");
    $crc = Params::getParam("SignatureValue");

    $my_crc = strtoupper(md5("$outSumm:$invId:$mrhPass2:shp_item=$iItemId:shp_product=$product_type:shp_user=$userid"));

    if ($my_crc != $crc) {
        echo "bad sign\n";
        exit();
    }
	$user = User::newInstance()->findByEmail ( $userid );
                    $iUser = $user['pk_i_id'];
	  /*
            ** UPD. v. 3.6.2
            */
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
	if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemId ) ) {
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
                                                                $invId,
                                                                $outSumm,
                                                                $currency, //currency
                                                                $userid, // payer's email
                                                                $iUser, //user
                                                                $iItemId, //item 
                                                                $product_type, //product type
                                                                'Robokassa'); //source

    echo "OK$invId\n";
	if ( isset ( ModelRUpayments::newInstance()->lastId ) ) $payment_id = ModelRUpayments::newInstance()->lastId;
	
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
                ModelRUpayments::newInstance()->addWallet ( $iUser, Params::getParam("OutSum")!=''?Params::getParam("OutSum") + $bonus_amount:Params::getParam("OutSum") + $bonus_amount);
            }


?>