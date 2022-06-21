<?php
  /*
 * Copyright 2017 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
  define('ABS_PATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');
    require_once ABS_PATH . 'oc-load.php';
        if ( Params::getParam("productType")  ) {
 
            $sProductType = Params::getParam("productType");
            $iItemID = Params::getParam("itemId");
            $iCategoryId = Params::getParam("categoryId");
            $paid = "admin";
            $sCurrency = osc_get_preference('currency', 'rupayments');
            $sPayment_system = "admin"; 
            $item = $item = Item::newInstance()->findByPrimaryKey($iItemID);  
            // Шлем электронку с уведомлением
            rupayments_send_email ( $item, 0, 'admin', $sProductType );
            
            if ( $sProductType == '101' ) {                                            
                $sPrice = ModelRUpayments::newInstance()->getPublishPrice ( $item['fk_i_category_id'] );
                $sDescription = __('Published', 'rupayments');
				osc_add_flash_ok_message(__('Published', 'rupayments'), 'admin');
            } 
            else if ( $sProductType == '201' ) {                                                                                   
                $sPrice = ModelRUpayments::newInstance()->getPremiumPrice ( $item['fk_i_category_id'] );
                $sDescription = __('Marked as Premium', 'rupayments');
				osc_add_flash_ok_message(__('Marked as Premium', 'rupayments'), 'admin');
            
                // Корректируем запись в лог
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) ) $sDescription = "Publish & ".$sDescription;
            }
            else if ( $sProductType == '301' ) {                                                                 
                $sPrice = ModelRUpayments::newInstance()->getColorPrice ( $item['fk_i_category_id'] );
                $sDescription = __('Marked as Highlighted', 'rupayments');
				osc_add_flash_ok_message(__('Marked as Highlighted', 'rupayments'), 'admin');
            
                // Корректируем запись в лог
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) ) $sDescription = "Publish & ".$sDescription;
            }
            else if ( $sProductType == '701' ) {                                                                 
                $sPrice = ModelRUpayments::newInstance()->getImageShowPrice ( $item['fk_i_category_id'] );
                $sDescription = __('Activated Show Image', 'rupayments');
				osc_add_flash_ok_message(__('Activated Show Image', 'rupayments'), 'admin');
            
                // Корректируем запись в лог
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) ) $sDescription = "Publish & ".$sDescription;
            }
            else if ( $sProductType == '801' ) {                                                                 
                $sPrice = ModelRUpayments::newInstance()->getPack3in1Price ( $item['fk_i_category_id'] );
                $sDescription = __('Apply: Pack 3-in-1', 'rupayments');
				osc_add_flash_ok_message(__('Apply: Pack 3-in-1', 'rupayments'), 'admin');
            
                // Корректируем запись в лог
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) ) $sDescription = "Publish & ".$sDescription;
            }
            else if ( $sProductType == '401' ) {                                                                   
                $sPrice = ModelRUpayments::newInstance()->getTopPrice ( $item['fk_i_category_id'] );
                $sDescription = __('Moved to TOP', 'rupayments');
				osc_add_flash_ok_message(__('Moved to TOP', 'rupayments'), 'admin');
            }
			else if ( $sProductType == '411' ) {                                                                   
                $sPrice = ModelRUpayments::newInstance()->getRenewPrice ( $item['fk_i_category_id'] );
                $sDescription = __('Renewed', 'rupayments');
				osc_add_flash_ok_message(__('Renewed', 'rupayments'), 'admin');
            }
            else if ( $sProductType == '231' ) {                                                                                            
                $sPrice = ModelRUpayments::newInstance()->getPremiumWithColorDiscount ( $item['fk_i_category_id'] );
                $sDescription = __('Marked as Premium and Highlighted', 'rupayments');
            
                // Корректируем запись в лог
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $iItemID ) ) $sDescription = "Publish & ".$sDescription;
            }
            
            
            // Добавляем запись о платеже в логи 
            $payment_id = ModelRUpayments::newInstance()->saveLog ( $sDescription, $paid, $sPrice, $sCurrency, $item['s_contact_email'], $item['fk_i_user_id'], $iItemID, $sProductType, $sPayment_system );
           
            if ( $sProductType == '101' ) {
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])) ModelRUpayments::newInstance()->setImageShow($data['itemid'], 0);
                ModelRUpayments::newInstance()->payPublishFee ( $iItemID, $payment_id );
            } 
            else if ( $sProductType == '201' ) {
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])) ModelRUpayments::newInstance()->setImageShow($data['itemid'], 0);
                ModelRUpayments::newInstance()->payPremiumFee ( $iItemID, $payment_id );
            }
            else if ( $sProductType == '301' ) {
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])) ModelRUpayments::newInstance()->setImageShow($data['itemid'], 0);
                ModelRUpayments::newInstance()->setColor ( $iItemID );
            }
            else if ( $sProductType == '701' ) {
                ModelRUpayments::newInstance()->setImageShow($iItemID, 1);
            }
            else if ( $sProductType == '801' ) {
                ModelRUpayments::newInstance()->setPack3in1($iItemID, $payment_id);
            }
            else if ( $sProductType == '401' ) {
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])) ModelRUpayments::newInstance()->setImageShow($data['itemid'], 0);
                ModelRUpayments::newInstance()->setTopItem ( $iItemID );
            }
			else if ( $sProductType == '411' ) {
			    if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])) ModelRUpayments::newInstance()->setImageShow($data['itemid'], 0); 
                ModelRUpayments::newInstance()->setRenew ( $iItemID );
            }
            else if ( $sProductType == '231' ) {
                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($item['pk_i_id'])) ModelRUpayments::newInstance()->setImageShow($data['itemid'], 0);
                ModelRUpayments::newInstance()->payPremiumWithColorFee ( $iItemID, $payment_id );
            }
           osc_redirect_to( osc_admin_base_url(true) . '?page=items&action=item_edit&id='.$iItemID); 
        }
           
?>