<?php
/*
 * Copyright 2017 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

    class Paypal
    {

        public function __construct()
        {
        }

        /**
        * Create and print a "Pay with Paypal" button
        *
        * @param float $amount
        * @param string $description
        * @param string $itemnumber (publish fee, premium, pack and which category)
        * @param string $extra custom variables
        */
        public static function button($amount = '0.00', $description = '', $itemnumber = '101', $extra_array = null, $extra_curr = false) {

            if(osc_get_preference('paypal_standard', 'rupayments')==1) {
                Paypal::standardButton($amount, $description, $itemnumber, $extra_array, $extra_curr);
            } else {
                Paypal::dgButton($amount, $description, $itemnumber, $extra_array, $extra_curr);
            }
        }

        public static function dgButton($amount = '0.00', $description = '', $itemnumber = '101', $extra_array = null, $extra_curr = false) {
            $extra = ppaypal_prepare_custom($extra_array);
            $r = rand(0,1000);
            $extra .= 'random,'.$r;

            $APIUSERNAME  = osc_get_preference('paypal_api_username', 'rupayments');
            $APIPASSWORD  = osc_get_preference('paypal_api_password', 'rupayments');
            $APISIGNATURE = osc_get_preference('paypal_api_signature', 'rupayments');

            if(osc_get_preference('paypal_sandbox', 'rupayments')==1) {
                $ENDPOINT     = 'https://api-3t.sandbox.paypal.com/nvp';
            } else {
                $ENDPOINT     = 'https://api-3t.paypal.com/nvp';
            }

            $VERSION      = '65.1'; // must be >= 65.1
            $REDIRECTURL  = 'https://www.paypal.com/incontext?token=';
            if(osc_get_preference('paypal_sandbox', 'rupayments')==1) {
                $REDIRECTURL  = "https://www.sandbox.paypal.com/incontext?token=";
            }
            
            if($extra_curr) $currency = $extra_curr; else $currency = osc_get_preference('currency', 'rupayments');

            //Build the Credential String:
            $cred_str = 'USER=' . $APIUSERNAME . '&PWD=' . $APIPASSWORD . '&SIGNATURE=' . $APISIGNATURE . '&VERSION=' . $VERSION;
            //For Testing this is hardcoded. You would want to set these variable values dynamically
            $nvp_str  = "&METHOD=SetExpressCheckout"
            . '&RETURNURL=' . osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/paypal/paypal/return.php?extra=' . $extra //set your Return URL here // payments/paypal/paypal/
            . '&CANCELURL=' . osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/paypal/paypal/cancel.php?extra=' . $extra //set your Cancel URL here
            . '&PAYMENTREQUEST_0_CURRENCYCODE=' . $currency
            . '&PAYMENTREQUEST_0_AMT=' . $amount
            . '&PAYMENTREQUEST_0_ITEMAMT=' . $amount
            . '&PAYMENTREQUEST_0_TAXAMT=0'
            . '&PAYMENTREQUEST_0_DESC=' . $description
            . '&PAYMENTREQUEST_0_PAYMENTACTION=Sale'
            . '&L_PAYMENTREQUEST_0_ITEMCATEGORY0=Digital'
            . '&L_PAYMENTREQUEST_0_NAME0=' . $description
            . '&L_PAYMENTREQUEST_0_NUMBER0=' . $itemnumber
            . '&L_PAYMENTREQUEST_0_QTY0=1'
            . '&L_PAYMENTREQUEST_0_TAXAMT0=0'
            . '&L_PAYMENTREQUEST_0_AMT0=' . $amount
            . '&L_PAYMENTREQUEST_0_DESC0=Download'
            . '&CUSTOM=' . $extra
            . '&useraction=commit';

            //combine the two strings and make the API Call
            $req_str = $cred_str . $nvp_str;
            $response = Paypal::httpPost($ENDPOINT, $req_str);

            //check Response
            if($response['ACK'] == "Success" || $response['ACK'] == "SuccessWithWarning") {
                //setup redirect URL
                $redirect_url = $REDIRECTURL . urldecode($response['TOKEN']);
                ?>
                <a href="<?php echo $redirect_url; ?>" class="fixpay" id='paypalBtn_<?php echo $r; ?>'>
                    <img src='<?php echo rupayments_url(); ?>payments/paypal/paypal/PP_logo_h_150x38.png' border='0' />
                </a>
                <script>
                    var dg_<?php echo $r; ?> = new PAYPAL.apps.DGFlow({
                        trigger: "paypalBtn_<?php echo $r; ?>"
                    });
                </script><?php
            } else if($response['ACK'] == 'Failure' || $response['ACK'] == 'FailureWithWarning') {
                $redirect_url = ''; //SOMETHING FAILED
            }
        }

        public static function standardButton($amount = '0.00', $description = '', $itemnumber = '101', $extra_array = null, $extra_curr = false) {
            $extra = ppaypal_prepare_custom($extra_array);
            $r = rand(0,1000);
            $extra .= 'random,'.$r;

            if(osc_get_preference('paypal_sandbox', 'rupayments')==1) {
                $ENDPOINT     = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
            } else {
                $ENDPOINT     = 'https://www.paypal.com/cgi-bin/webscr';
            }

            $RETURNURL = osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/paypal/paypal/return.php?extra=' . $extra;
            $CANCELURL = osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/paypal/paypal/cancel.php?extra=' . $extra;
            $NOTIFYURL = osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/paypal/paypal/notify_url.php?extra=' . $extra;

            ?>


                <form class="nocsrf" action="<?php echo $ENDPOINT; ?>" method="post" id="paypal_<?php echo $r; ?>">
                  <input type="hidden" name="cmd" value="_xclick" />
                  <input type="hidden" name="notify_url" value="<?php echo $NOTIFYURL; ?>" />
                  <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
                  <input type="hidden" name="item_name" value="<?php echo $description; ?>" />
                  <input type="hidden" name="item_number" value="<?php echo $itemnumber; ?>" />
                  <input type="hidden" name="quantity" value="1" />
                  <input type="hidden" name="currency_code" value="<?php if($extra_curr) echo $extra_curr; else echo osc_get_preference('currency', 'rupayments'); ?>" />
                  <input type="hidden" name="custom" value="<?php echo $extra; ?>" />
                  <input type="hidden" name="return" value="<?php echo $RETURNURL; ?>" />
                  <input type="hidden" name="rm" value="2" />
                  <input type="hidden" name="cancel_return" value="<?php echo $CANCELURL; ?>" />
                  <input type="hidden" name="business" value="<?php echo osc_get_preference('paypal_email', 'rupayments'); ?>" />
                  <input type="hidden" name="upload" value="1" />
                  <input type="hidden" name="no_note" value="1" />
                  <input type="hidden" name="charset" value="utf-8" />
                </form>
                <div class="buttons">
                  <div class="right"><a id="button-confirm" class="button" onclick="$('#paypal_<?php echo $r; ?>').submit();"><span class="fixpay"><img src='<?php echo rupayments_url(); ?>payments/paypal/paypal/PP_logo_h_150x38.png' border='0' /></span></a></div>
                </div>
            <?php
        }


        public static function processPayment() {
            return Paypal::processStandardPayment();
        }


        public static function processStandardPayment() {
            if (Params::getParam('payment_status') == 'Completed' || Params::getParam('st') == 'Completed') {
                // Have we processed the ppaypal already?
                $tx = Params::getParam('tx')==''?Params::getParam('tx'):Params::getParam('txn_id');
                $payment = ModelRUpayments::newInstance()->getPayment($tx);
                if (!$payment) {
                    if(Params::getParam('custom')!='') {
                        $custom = Params::getParam('custom');
                    } else if(Params::getParam('cm')!='') {
                        $custom = Params::getParam('cm');
                    } else if(Params::getParam('extra')!='') {
                        $custom = Params::getParam('extra');
                    }
                    $data = ppaypal_get_custom($custom);
                    $product_type = explode('x', Params::getParam('item_number'));
                    
                    // SAVE TRANSACTION LOG
                    
                    // Корректируем коды типа услуги (для полноты отчета в логе) на случай, 
                    // если платить за публикацию надо
                    if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $data['itemid']) ) {
                        if ( $product_type[0] == "201" ) $product_type[0] = "202";
                        if ( $product_type[0] == "301" ) $product_type[0] = "302";
                        if ( $product_type[0] == "231" ) $product_type[0] = "232";
                        if ( $product_type[0] == "701" ) $product_type[0] = "702";
                        if ( $product_type[0] == "711" ) $product_type[0] = "712";
                        if ( $product_type[0] == "721" ) $product_type[0] = "722";
                        if ( $product_type[0] == "731" ) $product_type[0] = "732";
                        if ( $product_type[0] == "801" ) $product_type[0] = "802";
                        if ( $product_type[0] == "811" ) $product_type[0] = "812";
                    }
                    
                    /*
                    ** UPD. v. 3.6.2
                    */
                    
                    if($product_type[0] == '501') $bonus = ModelRUpayments::newInstance()->getPack($product_type[1]);
                    
                    if($bonus && $bonus['f_pack_bonus']) {
                        $bonus_amount = $bonus['f_pack_bonus'];
                        $bonus_text = __(' + Bonus: ', 'rupayments') . $bonus_amount . osc_get_preference('currency', 'rupayments');
                    }
                    
                    if($product_type[0] == '1001') {
                        $ebuy_item = ModelRUpayments::newInstance()->getEbuyItem($product_type[1], true);
                        $item = Item::newInstance()->findByPrimaryKey($ebuy_item['i_item_id']);
                        $item_title = $item['s_title'];
                    }
            
                    $payment_id = ModelRUpayments::newInstance()->saveLog(
                                                                Params::getParam('item_name') . $bonus_text, //concept
                                                                $tx,
                                                                Params::getParam('mc_gross')!=''?Params::getParam('mc_gross'):Params::getParam('payment_gross'), //amount
                                                                Params::getParam('mc_currency'), //currency
                                                                Params::getParam('payer_email')!=''?Params::getParam('payer_email'):'', // payer's email
                                                                $data['user'], //user
                                                                $data['itemid'], //item
                                                                $product_type[0], //product type
                                                                'PAYPAL'); //source
                    
                    $payment_id = ModelRUpayments::newInstance()->lastId;

                    if ($product_type[0] == '101') {
                        ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id ); 
                        if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0);
                    } else if ( $product_type[0] == '201' || $product_type[0] == '202' ) {
                        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                        if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0);
                        ModelRUpayments::newInstance()->payPremiumFee ( $product_type[2], $payment_id ); 
        		    }
        		    else if ( $product_type[0] == '301' || $product_type[0] == '302' ) {
                                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0);
                                ModelRUpayments::newInstance()->setColor ( $product_type[2] ); // $product_type[2], $payment_id
        		    }
                    else if ( $product_type[0] == '701' || $product_type[0] == '702' ) {
                                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                                ModelRUpayments::newInstance()->setImageShow($product_type[2], 1);
        		    }
                    else if ( $product_type[0] == '711' || $product_type[0] == '712' ) {
                                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                                ModelRUpayments::newInstance()->setImageShow($product_type[2], 1);
                                ModelRUpayments::newInstance()->payPremiumFee ( $product_type[2], $payment_id );
        		    }
                    else if ( $product_type[0] == '721' || $product_type[0] == '722' ) {
                                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                                ModelRUpayments::newInstance()->setImageShow($product_type[2], 1);
                                ModelRUpayments::newInstance()->setColor ( $product_type[2] );
        		    }
                    else if ( $product_type[0] == '731' || $product_type[0] == '732' ) {
                                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                                ModelRUpayments::newInstance()->setImageShow($product_type[2], 1);
                                ModelRUpayments::newInstance()->payPremiumFee ( $product_type[2], $payment_id );
                                ModelRUpayments::newInstance()->setColor ( $product_type[2] );
        		    }
                    else if ( $product_type[0] == '801' || $product_type[0] == '802' ) {
                                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                                if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0);
                                
                                ModelRUpayments::newInstance()->setPack3in1($product_type[2], $payment_id);
        		    }
                    else if ( $product_type[0] == '811' || $product_type[0] == '812' ) {
                                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                                
                                ModelRUpayments::newInstance()->setPack3in1($product_type[2], $payment_id);
                                ModelRUpayments::newInstance()->setImageShow($product_type[2], 1);
        		    }
                    else if ($product_type[0] == '901') {
                        ModelRUpayments::newInstance()->setUserBannerPay($product_type[1]);
                    }
                    else if ($product_type[0] == '1001') {
                        ModelRUpayments::newInstance()->setEbuyDealPay($product_type[1], $data['user']);
                    }
        		    else if ($product_type[0] == '401') {
                        ModelRUpayments::newInstance()->setTopItem ( $product_type[2] ); // $product_type[2], $payment_id 
                        if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0); 
                    }
        			else if ($product_type[0] == '411') {
                        ModelRUpayments::newInstance()->setRenew ( $product_type[2] ); // $product_type[2], $payment_id  
                        if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0);
                    }
                    else if ( $product_type[0] == '231' || $product_type[0] == '232' ) {
                        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                        if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0);
                        ModelRUpayments::newInstance()->payPremiumWithColorFee ( $product_type[2], $payment_id );
                    }
                    else if ($product_type[0] == '601') {
                        ModelRUpayments::newInstance()->setUserMembership($product_type[1], $data['user']);
                    }
                    else {
                        ModelRUpayments::newInstance()->addWallet($data['user'], Params::getParam('mc_gross')!=''?Params::getParam('mc_gross') + $bonus_amount:Params::getParam('payment_gross') + $bonus_amount);
                    }

                    return PAYMENT_COMPLETED;
                }
                return PAYMENT_ALREADY_PAID;
            }
            return PAYMENT_PENDING;
        }



        public static function processDGPayment($doresponse, $response) {

            $data = ppaypal_get_custom(Params::getParam('extra'));

            if ($doresponse['ACK'] == 'Success' || $doresponse['ACK'] == 'SuccessWithWarning') {
                $product_type = explode('x', urldecode($response['L_PAYMENTREQUEST_0_NUMBER0']));
                // SAVE TRANSACTION LOG

                // Корректируем коды типа услуги (для полноты отчета в логе) на случай, 
                // если платить за публикацию надо
                if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $data['itemid']) ) {
                    if ( $product_type[0] == "201" ) $product_type[0] = "202";
                    if ( $product_type[0] == "301" ) $product_type[0] = "302";
                    if ( $product_type[0] == "231" ) $product_type[0] = "232";
                    if ( $product_type[0] == "701" ) $product_type[0] = "702";
                    if ( $product_type[0] == "711" ) $product_type[0] = "712";
                    if ( $product_type[0] == "721" ) $product_type[0] = "722";
                    if ( $product_type[0] == "731" ) $product_type[0] = "732";
                    if ( $product_type[0] == "801" ) $product_type[0] = "802";
                    if ( $product_type[0] == "811" ) $product_type[0] = "812";
                }
                
                /*
                ** UPD. v. 3.6.2
                */
                $bonus = ''; $bonus_text = '';
                
                if($product_type[0] == '501') $bonus = ModelRUpayments::newInstance()->getPack($product_type[1]);
                
                if($bonus && $bonus['f_pack_bonus']) {
                    $bonus_amount = $bonus['f_pack_bonus'];
                    $bonus_text = __(' + Bonus: ', 'rupayments') . $bonus_amount . osc_get_preference('currency', 'rupayments');
                }
                
                if($product_type[0] == '1001') {
                    $ebuy_item = ModelRUpayments::newInstance()->getEbuyItem($product_type[1], true);
                    $item = Item::newInstance()->findByPrimaryKey($ebuy_item['i_item_id']);
                    $item_title = $item['s_title'];
                }

            
                $payment_id = ModelRUpayments::newInstance()->saveLog(
                                                            urldecode($response['L_PAYMENTREQUEST_0_NAME0']) . $bonus_text, //concept
                                                            urldecode($doresponse['PAYMENTINFO_0_TRANSACTIONID']),    // transaction code
                                                            urldecode($doresponse['PAYMENTINFO_0_AMT']), //amount
                                                            urldecode($doresponse['PAYMENTINFO_0_CURRENCYCODE']), //currency
                                                            isset($response['EMAIL']) ? urldecode($response['EMAIL']) : '', // payer's email
                                                            $data['user'], //user
                                                            $data['itemid'], //item
                                                            $product_type[0], //product type
                                                            'PAYPAL'); //source

                $payment_id = ModelRUpayments::newInstance()->lastId;
                
                
                if ($product_type[0] == '101') {
                        ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id ); 
                        if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0);
                    } else if ( $product_type[0] == '201' || $product_type[0] == '202' ) {
                        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                        if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0);
                        ModelRUpayments::newInstance()->payPremiumFee ( $product_type[2], $payment_id ); 
        		    }
        		    else if ( $product_type[0] == '301' || $product_type[0] == '302' ) {
                        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                        if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0);
                        ModelRUpayments::newInstance()->setColor ( $product_type[2] ); // $product_type[2], $payment_id
        		    }
                    else if ( $product_type[0] == '701' || $product_type[0] == '702' ) {
                        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                        ModelRUpayments::newInstance()->setImageShow($product_type[2], 1);
        		    }
                    else if ( $product_type[0] == '711' || $product_type[0] == '712' ) {
                        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                        ModelRUpayments::newInstance()->setImageShow($product_type[2], 1);
                        ModelRUpayments::newInstance()->payPremiumFee ( $product_type[2], $payment_id );
        		    }
                    else if ( $product_type[0] == '721' || $product_type[0] == '722' ) {
                        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                        ModelRUpayments::newInstance()->setImageShow($product_type[2], 1);
                        ModelRUpayments::newInstance()->setColor ( $product_type[2] );
        		    }
                    else if ( $product_type[0] == '731' || $product_type[0] == '732' ) {
                        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                        ModelRUpayments::newInstance()->setImageShow($product_type[2], 1);
                        ModelRUpayments::newInstance()->payPremiumFee ( $product_type[2], $payment_id );
                        ModelRUpayments::newInstance()->setColor ( $product_type[2] );
        		    }
                    else if ( $product_type[0] == '801' || $product_type[0] == '802' ) {
                        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                        if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0);
                        
                        ModelRUpayments::newInstance()->setPack3in1($product_type[2], $payment_id);
        		    }
                    else if ( $product_type[0] == '811' || $product_type[0] == '812' ) {
                        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                        
                        ModelRUpayments::newInstance()->setPack3in1($product_type[2], $payment_id);
                        ModelRUpayments::newInstance()->setImageShow($product_type[2], 1);
        		    }
                    else if ($product_type[0] == '901') {
                        ModelRUpayments::newInstance()->setUserBannerPay($product_type[1]);
                    }
                    else if ($product_type[0] == '1001') {
                        ModelRUpayments::newInstance()->setEbuyDealPay($product_type[1], $data['user']);
                    }
        		    else if ($product_type[0] == '401') {
                        ModelRUpayments::newInstance()->setTopItem ( $product_type[2] ); // $product_type[2], $payment_id 
                        if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0); 
                    }
        			else if ($product_type[0] == '411') {
                        ModelRUpayments::newInstance()->setRenew ( $product_type[2] ); // $product_type[2], $payment_id  
                        if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0);
                    }
                    else if ( $product_type[0] == '231' || $product_type[0] == '232' ) {
                        if ( ModelRUpayments::newInstance()->getIsPublishPaymentNeeded ( $product_type[2] ) ) ModelRUpayments::newInstance()->payPublishFee ( $product_type[2], $payment_id );
                        if(osc_get_preference('pay_per_show_image_status', 'rupayments') && !ModelRUpayments::newInstance()->checkShowImage($product_type[2])) ModelRUpayments::newInstance()->setImageShow($product_type[2], 0);
                        ModelRUpayments::newInstance()->payPremiumWithColorFee ( $product_type[2], $payment_id );
                    }
                    else if ($product_type[0] == '601') {
                        ModelRUpayments::newInstance()->setUserMembership($product_type[1], $data['user']);
                    }
                    else {
                        ModelRUpayments::newInstance()->addWallet($data['user'], urldecode($doresponse['PAYMENTINFO_0_AMT']) + $bonus_amount);
                    }

                return PAYMENT_COMPLETED;
            } else if($doresponse['ACK'] == "Failure" || $doresponse['ACK'] == "FailureWithWarning") {
                return PAYMENT_FAILED;
            }
            return PAYMENT_PENDING;
        }



        //Makes an API call using an NVP String and an Endpoint
        public static function httpPost($my_endpoint, $my_api_str) {
            // setting the curl parameters.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $my_endpoint);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            // turning off the server and peer verification(TrustManager Concept).
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            // setting the NVP $my_api_str as POST FIELD to curl
            curl_setopt($ch, CURLOPT_POSTFIELDS, $my_api_str);
            // getting response from server
            $httpResponse = curl_exec($ch);
            if (!$httpResponse) {
                $response = "API_method failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')'; // $API_method
                return $response;
            }
            $httpResponseAr = explode("&", $httpResponse);
            $httpParsedResponseAr = array();
            foreach ($httpResponseAr as $i => $value) {
                $tmpAr = explode("=", $value);
                if (sizeof($tmpAr) > 1) {
                    $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
                }
            }

            if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
                $response = "Invalid HTTP Response for POST request($my_api_str) to $API_Endpoint.";
                return $response;
            }

            return $httpParsedResponseAr;
        }

    }

?>