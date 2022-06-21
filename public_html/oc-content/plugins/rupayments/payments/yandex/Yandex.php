<?php
/*
 * Copyright 2017-2020 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
    class Yandex
    {

        public function __construct()
        {
        }
        
        public static function button ( $sItemEmail = '', $fAmount = '0.00', $sProductType = '', $iItemId = 0, $sDescription, $yandex_num  ) {
            usleep(1200000);
            
            $ENDPOINT = 'https://yoomoney.ru/quickpay/confirm.xml';
            $transaction_id = 'Ya'. time();
       
            ModelRUpayments::newInstance()->saveTransactionId ( $transaction_id, $sItemEmail, $fAmount, $sProductType, $iItemId );
  
?>
    <table cellpadding="2" cellspasing="2" border="0">
        <form name='yandex_<?php print $yandex_num;?>' method="POST" action="<?php print $ENDPOINT;?>">
<script language="javascript">
  function sendForm_<?php print $yandex_num;?>() {
      var select_var = $("#select_<?php print $yandex_num;?> option:selected").val();
      $('input[name="successURL"]').val( '<?php print osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/yandex/return.php?tr='.$transaction_id.'&pt=';?>' + select_var  ); //$("#select_<?php print $yandex_num;?> option:selected").val()
      $('input[name="paymentType"]').val( select_var );
      //alert ( $('input[name="successURL"]').val() + " - " );
      document.yandex_<?php print $yandex_num;?>.submit();
  }
</script>
            <input type="hidden" name="receiver" value="<?php print osc_get_preference('yandex_receiver', 'rupayments');?>">
            <input type="hidden" name="formcomment" value="<?php print $sDescription;?>"> <!-- (до 50 символов) — название перевода в истории отправителя.  -->
            <input type="hidden" name="short-dest" value="<?php print $sDescription;?>"> <!-- название перевода на странице подтверждения. Рекомендуем делать его таким же, как formcomment. -->
            <input type="hidden" name="label" value="<?php print $transaction_id;?>"> <!-- метка, которую сайт или приложение присваивает конкретному переводу. Например, в качестве метки можно указывать код или идентификатор заказа. -->
            <input type="hidden" name="quickpay-form" value="small">
            <input type="hidden" name="targets" value="<?php _e('Payment of premium services', 'rupayments');?>"> <!-- назначение платежа. -->
            <input type="hidden" name="sum" value="<?php print number_format ( $fAmount, 2, '.', '' );?>" data-type="number">  
            <input type="hidden" name="successURL" value="<?php print osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/yandex/return.php?tr='.$transaction_id;?>"> 
            <input type="hidden" name="need-fio" value="false">
            <input type="hidden" name="need-email" value="false">
            <input type="hidden" name="need-phone" value="false">
            <input type="hidden" name="need-address" value="false">
			<input type="hidden" name="paymentType" value="AC">
        <tr>
            <td style="font-weight: bold; font-size: 1em; color: #852064;"><?php _e('ЮMoney', 'rupayments');?></td>
        </tr>
        <tr>
            <td>
                <select class="yaform" id="select_<?php print $yandex_num;?>" name="paymentType">
<?php
            if ( osc_get_preference('yandex_by_carta', 'rupayments') ) {?>
                    <option value="AC"><?php _e('by Bank card', 'rupayments');?></option> 
<?php
            }
            if ( osc_get_preference('yandex_by_wallet', 'rupayments') ) {?>
                    <option value="PC"><?php _e('ЮMoney', 'rupayments');?></option> 
<?php
            }
            if ( osc_get_preference('yandex_by_mobile_phone', 'rupayments') ) {?>
                    <option value="MC"><?php _e('By Mobile', 'rupayments');?></option> 
<?php
            }
?>
                </select>
            </td>
        </tr>
        <tr>
            <td style="padding-top:5px;">
                <button class="yaformbutton" onclick="sendForm_<?php print $yandex_num;?>();"><nobr><?php _e('Select and Pay', 'rupayments'); ?></nobr></button> <!--   style='width: 127px; height: 50px; border:none;' -->
            </td>
        </tr>
        </form>
    </table>
<?php   
        }
    
    }

?>