<?php
/*
 * Copyright 2015 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
    define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/');
    require_once ABS_PATH . 'oc-load.php';
    
    $transaction_id = Params::getParam("tr");
    $payment_type = Params::getParam("pt");
    // Получаем из БД параметры транзакции, отправленные в Яндекс.Деньги
    $aDataInner = ModelRUpayments::newInstance()->getTransaction ( $transaction_id );
    
    // Если transaction_id зарегистрирована в БД
    if ( is_array ( $aDataInner ) ) { 
    // 
        // Иногда getTransaction() вместо false выдает пустой массив -
        // этот случай приравнивается к false
        if ( count ( $aDataInner ) < 3 ) {
            osc_add_flash_info_message(__('Time of session of your Yandex has expired, please try again', 'rupayments'));
            rupayments_js_redirect_to(osc_base_url());
        }
   

        if ( osc_get_preference('yandex_by_mobile_phone', 'rupayments') == 1 && Params::getParam("pt") == "MC" ) {
            
            $sTransactionId = $transaction_id;
            
            if ( !ModelRUpayments::newInstance()->isTransactionMade ( $sTransactionId ) ) {
 
    //print serialize($aDataInner)." - aDataInner; ".$transaction_id." - transaction_id; ".$payment_type." - payment_type; <br>";
           
                $product_type = $aDataInner['i_product_type'];
                $iItemId = $aDataInner['fk_i_item_id'];
                $fAmount = $aDataInner['f_amount'];
                $sCurrency = "RUB";
                $sEmail = $aDataInner['s_email'];
            
                if ( $iItemId ) {
                    $item = Item::newInstance()->findByPrimaryKey( $iItemId ); 
                    $iUser = $item['fk_i_user_id'];
                }
            
                if (  stristr ( $product_type, '50' ) || $product_type == '601' || $product_type == '901' || $product_type == '1001') {
                $user = User::newInstance()->findByEmail( $arTransactionData['s_email'] );
                $iUser = $user['pk_i_id'];
            }
			
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
        
                // SAVE TRANSACTION LOG
                    
                // Корректируем коды типа услуги (для полноты отчета в логе) на случай, 
                // если платить за публикацию надо
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
            if ( $product_type == "601" ) $sConcept = __('Payment of membership fee: ', 'rupayments') . $user_group_title;
            if ( $product_type == "901" ) $sConcept = __('Payment of banner public fee: ', 'rupayments') . $iItemId;
            if ( $product_type == "1001" ) $sConcept = __('Payment of Item Purchase: ', 'rupayments') . $item_title;
			if ( $product_type == "401" ) $sConcept = __('Move to TOP', 'rupayments');
			if ( $product_type == "411" ) $sConcept = __('Renew item', 'rupayments');
        
           
                $payment_id = ModelRUpayments::newInstance()->saveLog(
                                                                $sConcept, //concept
                                                                $sTransactionId, // transaction id
                                                                $fAmount !=''?$fAmount:$fAmount, //amount
                                                                $sCurrency, //currency
                                                                $sEmail!=''?$sEmail:'', // payer's email
                                                                $iUser, //user
                                                                $iItemId, //item 
                                                                $product_type, //product type
                                                                'Yandex'); //source
                    
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
            }
			else if ($product_type == '411') {
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
                ModelRUpayments::newInstance()->addWallet ( $iUser, Params::getParam('withdraw_amount')!=''?Params::getParam('withdraw_amount') + $bonus_amount:Params::getParam('withdraw_amount') + $bonus_amount);
            }
            }   
        }
        
        // Если от сервера Яндекс.Деньги получен уведомление о платеже и оно обработано
        // или в случае платежа с баланса мобильника
        if ( $aData = ModelRUpayments::newInstance()->getPaymentByCode ( $transaction_id, "Yandex" ) ) {
           
            $product_type = $aData["i_product_type"];
            
            osc_add_flash_ok_message(__('Payment processed correctly', 'rupayments'));
	    $item = Item::newInstance()->findByPrimaryKey ( $aData["fk_i_item_id"] );
	    $aProductTypes = array ( "501", "502", "503", "601", "901", "1001" );
          
            if ( !in_array ( $product_type, $aProductTypes ) ) {
	        $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
	        View::newInstance()->_exportVariableToView('category', $category);
            }
            
             if ( $product_type == "101" ) {
                rupayments_js_redirect_to(osc_search_category_url());
            } else if ( $product_type == "201" ) {
               rupayments_js_redirect_to(osc_search_category_url());
            } else if ( $product_type == "301" ) {
               rupayments_js_redirect_to(osc_search_category_url());
            } else if ( $product_type == "401" ) {
               rupayments_js_redirect_to(osc_search_category_url());
            } else if ( $product_type == "411" ) {
               rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));
            }
            else if ( $product_type == "231" ) {
               rupayments_js_redirect_to(osc_search_category_url());
            }
            else if($product_type == "601") {
                rupayments_js_redirect_to(osc_route_url('rupayments-user-membership'));
            } else if($product_type == "701") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "711") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "721") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "731") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "801") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } else if($product_type == "811") {
                    rupayments_js_redirect_to(osc_search_category_url());
            }
            else if($product_type == "901") {
                rupayments_js_redirect_to(osc_route_url('rupayments-user-banners'));
            }
            else if($product_type == "1001") {
                rupayments_js_redirect_to(osc_route_url('rupayments-user-ebuy-deals'));
            }
            
	    else {
                if(osc_is_web_user_logged_in()) {
                    rupayments_js_redirect_to(osc_route_url('rupayments-user-pack'));
                } else {
                    // THIS SHOULD NOT HAPPEN
                    rupayments_js_redirect_to(osc_base_url());
                }
            }
        // Если уведомления о платеже не было
        } else {
            // Платеж не принят Яндекс.Деньги по какие-то причинам
            $product_type = $aDataInner["i_product_type"];
     
            osc_add_flash_info_message(__('Your Yandex processing did not finished,  please contact with Yandex.Money administration', 'rupayments'));
            if ( $product_type == "501" || $product_type == "502"  || $product_type == "503" ) { 
                if(osc_is_web_user_logged_in()) {
                    rupayments_js_redirect_to(osc_route_url('rupayments-user-pack'));
                } else {
                    // THIS SHOULD NOT HAPPEN
                    rupayments_js_redirect_to(osc_base_url());
                }
            }   else if($product_type == "601") {
                rupayments_js_redirect_to(osc_route_url('rupayments-user-membership'));
            } 
            else if($product_type == "701") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } 
            else if($product_type == "711") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } 
            else if($product_type == "721") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } 
            else if($product_type == "731") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } 
            else if($product_type == "801") {
                    rupayments_js_redirect_to(osc_search_category_url());
            } 
            else if($product_type == "811") {
                    rupayments_js_redirect_to(osc_search_category_url());
            }
            else if($product_type == "901") {
                rupayments_js_redirect_to(osc_route_url('rupayments-user-banners'));
            }
            else if($product_type == "1001") {
                rupayments_js_redirect_to(osc_route_url('rupayments-user-ebuy-deals'));
            }
            else {
                if(osc_is_web_user_logged_in()) {
                    rupayments_js_redirect_to(osc_route_url('rupayments-user-menu'));
                } else {
                    View::newInstance()->_exportVariableToView ( 'item', Item::newInstance()->findByPrimaryKey ( $aData["fk_i_item_id"] ) );
                    rupayments_js_redirect_to(osc_item_url());
                }
            }
         
        }
 
    }
    
    else {
        // Такого действительного (по времени) идентификатора транзации нет - возможно истек 
        osc_add_flash_info_message(__('Time of session of your Yandex has expired, please try again', 'rupayments'));
        rupayments_js_redirect_to(osc_base_url());
    } 
 
?>