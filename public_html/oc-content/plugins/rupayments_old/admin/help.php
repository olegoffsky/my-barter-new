<?php defined('ABS_PATH') or die('Access denied'); ?>
<?php require_once 'top_menu.php'; ?>
<div class="rupayments-manage-wrapper">
    <div style="margin: 15px;">
        <div class="accordion">
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('Paypal', 'rupayments'); ?></h3>
                
                <div class="info">
                    <h3><?php _e('API or Standard Payments?', 'rupayments'); ?></h3>
                    <p class="info_item">
                        <?php _e('API PayPal give you more control over the Paypal process, it\'s required for digital goods & micropayments (Note: Not all countries are allowed to have digital goods & micropayments processes). On the other side standard Paypal are simple, less customizable but works everywhere', 'rupayments'); ?>.
                        <br/>
                        <?php _e('Microppaypals offers a reduction on the fee to pay Paypal for orders under 4$ (or equivalent), around 5cents + 5% while standard Paypal have a fee around 30cents + 5%. Due the nature of OSClass is recommended to use micropayments, but we\'re aware that they\'re not available worldwide. Please check with Paypal the avalaibility of the service in your area', 'rupayments'); ?>.
                        <br/>
                    </p>
                    <h3><?php _e('Setting up your Paypal account for Standard Payments', 'rupayments'); ?></h3>
                    <p class="info_item">
                        <?php _e('Write your PayPal email and check the "Use Standard Payment" option', 'rupayments'); ?>.
                        <br/>
                    </p>
                    <h3><?php _e('Setting up your Paypal account for micropaymets/API', 'rupayments'); ?></h3>
                    <p class="info_item">
                        <?php _e('Before being able to use Paypal plugin, you need to set up some configuration at your Paypal account', 'rupayments'); ?>.
                        <br/>
                        <?php _e('Your Paypal account has to be set as Business or Premier, you could change that at Your Profile, under My Settings', 'rupayments'); ?>.
                        <br/>
                        <?php echo sprintf( __('You need to sign in up for micropayments/digital good <a href="%s">from here</a>', 'rupayments'), 'https://www.paypal.com/uk/webapps/mpp/micropayments'); ?>.
                        <br/>
                        <?php _e('You need Paypal API credentials (before entering here your API credentials, MODIFY index.php file of this plugin and change the value of PAYPAL_CRYPT_KEY variable to make your API more secure)', 'rupayments'); ?>.
                        <br/>
                        <?php _e('You need to tell Paypal where is your IPN file', 'rupayments'); ?>
                    </p>
                    <h3><?php _e('Setting up your IPN', 'rupayments'); ?></h3>
                    <p class="info_item">
                        <?php _e('Click Profile on the My Account tab', 'rupayments'); ?>.
                        <br/>
                        <?php _e('Click Instant Payment Notification Preferences in the Selling Preferences column', 'rupayments'); ?>.
                        <br/>
                        <?php _e("Click Choose IPN Settings to specify your listener?s URL and activate the listener (usually is http://www.yourdomain.com/oc-content/plugins/rupayments/payments/paypal/paypal/notify_url.php)", 'rupayments'); ?>.
                    </p>
                    <h3><?php _e('How to obtain API credentials', 'ppaypal'); ?></h3>
                    <p class="info_item">
                        <?php _e('In order to use the Paypal plugin you will need Paypal API credentials, you could obtain them for free following theses steps', 'rupayments'); ?>:
                        <br/>
                        <?php _e('Verify your account status. Go to your PayPal Profile under My Settings and verify that your Account Type is Premier or Business, or upgrade your account', "rupayments"); ?>.
                        <br/>
                        <?php _e('Verify your API settings. Click on My Selling Tools. Click Selling Online and verify your API access. Click Update to view or set up your API signature and credentials', 'rupayments'); ?>.
                    </p>
                    <h3><?php _e('Test plugin with Paypal Sandbox', 'rupayments'); ?></h3>
                    <p class="info_item">
                        <?php _e('Register at https://developer.paypal.com/. Go to Dashboard and Create two accounts', 'rupayments'); ?>:
                        <br/>
                        <?php _e('Add a Business account. E-mail of this account (or API data) insert in plugin settings. E-mail use to test plugin with Standard Paypal. API data use to test with Express Checkout', "rupayments"); ?>.
                        <br/>
                        <?php _e('Add a Personal account. With paypal e-mail of Personal account you can pay Premium, Move to top and other plugin options from you site', "rupayments"); ?>.
                        <br/>
                        <?php _e('Important options in Sandbox Business account !!! In Business Account details - Payment Review option - set OFF. Negative Testing - set OFF' , 'rupayments'); ?>.
                        <br/>
                        <?php _e('Check in the plugin "Paypal sandbox" option. Now you can test plugin!' , 'rupayments'); ?>.
                    </p>
                </div>
            </section>
            
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('2Checkout', 'rupayments'); ?></h3>
                
                <div class="info">
                    <h3><?php _e('Test plugin with 2Checkout Sandbox', 'rupayments'); ?></h3>
                    <p class="info_item">
                        <?php _e('1.Register at https://sandbox.2checkout.com/sandbox. Go to Account - Site Managment', 'rupayments'); ?>:
                        <br/>
                        <?php _e('2.Site Settings. Demo Setting select ON', 'rupayments'); ?>.
                        <br/>
        				<?php _e('3.Checkout Options. Pricing Currency - select you currency. Refund Policy - select No refund(or other)', 'rupayments'); ?>.
                        <br/>
        				<?php _e('4.Privacy Policy - select 2Checkout privacy policy(or other)', 'rupayments'); ?>.
        				<br/>
        				<?php _e('See image:', 'rupayments'); ?>
        				<br/>
        				<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/2co_options1.jpg" alt="">
                        <br/>
                        <?php _e('5.Direct Return - select Direct Return(Our URL)' , 'rupayments'); ?>.
        				<br/>
        				<?php _e('6.Approved URL - insert link' , 'rupayments'); ?>:  <b style="color: #2aa4db;"><?php echo osc_base_url().'oc-content/plugins/rupayments/payments/2chekout/return.php';?></b>
        				<br/>
        				<?php _e('See image:', 'rupayments'); ?>
        				<br/>
        				<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/2co_options2.jpg" alt="">
        				<br/>
        				<?php _e('7.Save Changes' , 'rupayments'); ?>
        				<br/>
        				<?php _e('8.Go to you site admin panel. Plugins - 2Chekout options' , 'rupayments'); ?>
        				<br/>
        				<?php _e('9.2Checkout settings field 2Checkout account number - insert Account Number from 2Checkout Sandbox' , 'rupayments'); ?>
        				<br/>
        				<?php _e('Were this number?:', 'rupayments'); ?>
        				<br/>
        				<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/2co_options3.jpg" alt="">
        				<br/>
                        <?php _e('10.2Checkout settings field 2Checkout secret word - insert Secret Word from 2Checkout Sandbox' , 'rupayments'); ?>
        				<br/>
        				<?php _e('Were this number?:', 'rupayments'); ?>
        				<br/>
        				<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/2co_options4.jpg" alt="">
        				<br/>
        				<?php _e('11.Save changes in you site. And test plugin!:', 'rupayments'); ?>
        				<br/>
        				<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/2co_options5.jpg" alt="">
        				<br/>
                    </p>
        			<h3><?php _e('2Checkout real account', 'rupayments'); ?></h3>
                    <p class="info_item">
                        <?php _e('1.Register at https://www.2checkout.com. Go to Account - Site Managment', 'rupayments'); ?>:
                        <br/>
        				<?php _e('2.Site Settings. Demo Setting - select Parameter', 'rupayments'); ?>.
                        <br/>
        				<?php _e('3.Set all options. Direct Return - select Direct Return(Our URL)', 'rupayments'); ?>.
                        <br/>
        				<?php _e('4.Approved URL also', 'rupayments'); ?>:  <b style="color: #2aa4db;"><?php echo osc_base_url().'oc-content/plugins/rupayments/payments/2chekout/return.php';?></b>
                        <br/>
        				<?php _e('5.Insert Account Number and Secret Word from 2Checkout to plugin fields.', 'rupayments'); ?>.
                        <br/>
        				<?php _e('6.Disable - 2Checkout sandbox. Save changes.', 'rupayments'); ?>.
                        <br/>
        			</p>
        			<h3><?php _e('Language 2CO page', 'rupayments'); ?></h3>
        			<p class="info_item"> 
                         <?php _e('This option allow you select in what language buyer see 2Checkout site ', 'rupayments'); ?>.
                         <br/>	
        			</p>
                </div>
            </section>
            
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('ЮMoney', 'rupayments'); ?></h3>
                
                <div class="info">
            <p class="info_item">
                <?php _e('Login or register in', 'rupayments'); ?> <a style="color:#2aa4db;" href="https://yoomoney.ru/" target="_blank">https://yoomoney.ru/</a>
            </p>
			<p class="info_item">
                <?php _e('Зайдите в Настройки - Пакеты/Другие сервисы - Сбор Денег - Уведомления - Уведомления По HTTP - Подключить.', 'rupayments'); ?>
            </p>
			<br/>
        				<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/ymoney1.jpg" alt="">
        				<br/>
						<br/>
        				<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/ymoney2.jpg" alt="">
        				<br/>
						<br/>
        				<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/ymoney3.jpg" alt="">
        				<br/>
			<p class="info_item">
                <?php _e('HTTP-уведомления. Вставьте адрес:', 'rupayments'); ?><b style="color: #2aa4db;"><?php echo osc_base_url().'index.php?page=custom&route=rupayments-payments-yandex-notification';?></b>
            </p>
			<br/>
        				<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/ymoney4.jpg" alt="">
        				<br/>
			<p class="info_item">
                <?php _e('Поставьте галочку - Отправлять уведомления и сохраните настройки. Далее нажмите показать секрет. Вставьте данный набор символов в поле плагина Секретное слово ЮMoney', 'rupayments'); ?>
            </p>
			<br/>
        				<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/ymoney5.jpg" alt="">
        				<br/>
			<p class="info_item">
                <?php _e('Вставьте номер Вашего кошелька в поле плагина Номер вашего кошелька и сохраните.', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Тестовой среды ЮMoney не имеют. Поэтому для тестов можно только сделать реальные платежи.', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Важно! При оплате с мобильных телефонов - ЮMoney не присылает уведомлений на сайт. Поэтому если Вы включите эту опцию, обрабатывать платежи придётся вручную.', 'rupayments'); ?>
            </p>
                </div>
            </section>
            
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('Interkassa', 'rupayments'); ?></h3>
                
                <div class="info">
            <p class="info_item">
                <?php _e('Login or register in', 'rupayments'); ?> <a style="color:#2aa4db;" href="https://www.interkassa.com" target="_blank">https://www.interkassa.com</a>
            </p>
			<p class="info_item">
                <?php _e('Зайдите в Настройки - Мои Кассы - Создайте кассу .', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('В настройках кассы:', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Настройки платежей. Проверять уникальность платежей - вкл.. ', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Платёжные системы - выберите нужные. ', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Интерфейс. Все URL взаимодействия: Тип запроса - POST и разрешить переопределять в запросе', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Безопасность. Цифровая подпись: MD5. Проверять подпись в форме запроса платежа - не включать.', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Секретный ключ( или тестовый секретный ключ) из кабинета Интеркассы вставьте в поле плагина(Интеркасса параметры - Интеркасса секретный ключ).', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('В поле Интеркасса id кассы  вставьте ID Ваше кассы ( раздел Мои Кассы - ID виден под названием кассы)', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Если Вы хотите протестировать взаимодействие с Интеркассой:', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('1. Используйте тестовый секретный ключ в настройках плагина.', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('2. А в кабинете Интеркассы - включите Тестовую платежную систему.', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('3. Никаких дополнительных настроек для тестовых платежей не требуется. В настройках плагина используйте стандартную валюту RUB или UAH, и оплачиваете заказ.', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('4. Просто при оплате на Интеркассе выберите тестовый способо оплаты. И не забудьте выключить его после тестирования!', 'rupayments'); ?>
            </p>
                </div>
            </section>
            
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('Robokassa', 'rupayments'); ?></h3>
                    
                <div class="info">
			<p class="info_item"><?php _e('Tips For Administrators', 'rupayments'); ?></p>
			<p class="info_item">
			   <?php _e('Metod - POST. Signature - MD5', 'rupayments'); ?>
               </p>
  <p class="info_item">
            Result URL: <b style="color: #2aa4db;"><?php echo osc_base_url() .'index.php?page=custom&route=rupayments-payments-robokassa-result';?></b>
        </p>
       <p class="info_item">
            Success URL: <b style="color: green;"><?php echo osc_base_url() .'index.php?page=custom&route=rupayments-payments-robokassa-success';?></b>
        </p>       <p class="info_item">
            Fail URL: <b style="color: red;"><?php echo osc_base_url() .'index.php?page=custom&route=rupayments-payments-robokassa-cancel';?></b>
        </p>
                </div>
            </section>
			<section class="accordion_item">
                <h3 class="title_block"><?php _e('Payeer', 'rupayments'); ?></h3>
                    
                <div class="info">
			<p class="info_item"><?php _e('Tips For Administrators', 'rupayments'); ?></p>
			<p class="info_item">
			   <?php _e('Register at  https://payeer.com/ru/account/  and add new merchant', 'rupayments'); ?>
               </p> 
			     <p class="info_item">
            Result URL: <b style="color: #2aa4db;"><?php echo osc_base_url() .'oc-content/plugins/rupayments/payments/payeer/status.php';?></b>
        </p>
       <p class="info_item">
            Success URL: <b style="color: green;"><?php echo osc_base_url() .'index.php?page=custom&route=rupayments-payments-payeer-success';?></b>
        </p>       <p class="info_item">
            Fail URL: <b style="color: red;"><?php echo osc_base_url() .'index.php?page=custom&route=rupayments-payments-payeer-fail';?></b>
        </p>
			   <p class="info_item">
			   <?php _e('Paste in plugin settings ID and secret key from this merchant', 'rupayments'); ?>
               </p>
			<p class="info_item">
			   <?php _e('Add Merchant URL . By default - https://payeer.com/merchant/', 'rupayments'); ?>
               </p>
 
			  <p class="info_item">
			   <?php _e('IP - filter', 'rupayments'); ?>
               </p>
			   	<?php _e('You can specify the list of all trusted ip addresses of servers, separated by commas.', 'rupayments'); ?>
				<br/>
				<?php _e('You can also specify a mask instead of the ip address. If the field is empty, checking for trusted ip addresses not performed.', 'rupayments'); ?>
				<br/>
				<?php _e('For example', 'rupayments'); ?>:
				<br/>
				185.71.65.92, 185.71.65.189, 149.202.17.210
				<br/>
				<?php _e('Or', 'rupayments'); ?>
				185.*.65.92, 185.71.65.*, 149.*.17.210
				<br/>
				<?php _e('Or', 'rupayments'); ?>
				*.*.*.* - <?php _e('all available IP addresses', 'rupayments'); ?>
                </div>
            </section>
            
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('Walletone', 'rupayments'); ?></h3>
                <div class="info">
          			  <p class="info_item"><?php _e('Tips For Administrators', 'rupayments'); ?></p>
			  <p class="info_item">
			   <?php _e('1.Вам необходимо заргестрировать акканут в кассе Walletone - https://www.walletone.com/merchant/', 'rupayments'); ?>
               </p>
			     <p class="info_item">
			   <?php _e('2. Создайте новый проект. Заполните все требуемые данные.', 'rupayments'); ?>
               <br/></p>
			     <p class="info_item">
			   <?php _e('3. Настройки проекта:.', 'rupayments'); ?>
               </p>
			  <p class="info_item">
			   <?php _e('Metod ECP - POST. Signature - MD5', 'rupayments'); ?>
               </p>
   <p class="info_item">
            Result URL: <b style="color: #2aa4db;"><?php echo osc_base_url() . 'oc-content/plugins/'.RUPAYMENTS_RELATIVE_PATH.'payments/walletone/result.php';?></b></p>
		  <p class="info_item">
			   <?php _e('Сгенерируйте ключ. Внесите ключ и ID кассы ( правый-верхний угол в аккануте, номер под названием кассы) в настройки плагина.', 'rupayments'); ?>
               </p>
		  <p class="info_item">
			   <?php _e('4. Важно! В настроках плагина все цены должны быть с разделителем . (точка). После точки обязательно должно быть две цифры.', 'rupayments'); ?>
               </p>
                </div>
            </section>
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('Free-kassa', 'rupayments'); ?></h3>
                
                <div class="info">
            <p class="info_item">
                <?php _e('Login or register in', 'rupayments'); ?> <a style="color:#2aa4db;" href="http://www.free-kassa.ru" target="_blank">http://www.free-kassa.ru</a>
            </p>
			<p class="info_item">
                <?php _e('Зайдите в Мои Кассы - Добавьте кассу .', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('В настройках кассы:', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Все методы отсылки, оповещения выберите - POST ', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('создайте - Секретное слово и Секретное слово 2 не одинаковыми ', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Режим интеграции выберите - Нет', 'rupayments'); ?>
            </p>
			<p class="info_item">
            URL оповещения: <b style="color: #2aa4db;"><?php echo osc_base_url() .'oc-content/plugins/rupayments/payments/freekassa/status.php';?></b>
        </p>
       <p class="info_item">
            URL возврата в случае успеха: <b style="color: green;"><?php echo osc_base_url() .'index.php?page=custom&route=rupayments-payments-freekassa-success';?></b>
        </p>       <p class="info_item">
            URL возврата в случае неудачи: <b style="color: red;"><?php echo osc_base_url() .'index.php?page=custom&route=rupayments-payments-freekassa-fail';?></b>
        </p>
		<p class="info_item">Подтвержение платежа: Требуется</p>
		  <p class="info_item">
			   <?php _e('Paste in plugin settings ID and secret key from this merchant', 'rupayments'); ?>
               </p>
                </div>
            </section>
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('Webmoney', 'rupayments'); ?></h3>
                
                <div class="info">
            <p class="info_item">
                <?php _e('Login or register in', 'rupayments'); ?> <a style="color:#2aa4db;" href="https://merchant.webmoney.ru/" target="_blank">https://merchant.webmoney.ru/</a>
            </p>
			<p class="info_item">
                <?php _e('Зайдите в', 'rupayments'); ?> <a style="color:#2aa4db;" href="https://merchant.webmoney.ru/conf/purses.asp" target="_blank">https://merchant.webmoney.ru/conf/purses.asp</a>
            </p>
			<p class="info_item">
                <?php _e('Напротив нужного кошелька выбираем настроить.', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Указываем тестовый либо рабочий режим работы', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Указываем торговое имя ', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Указываем Secret Key', 'rupayments'); ?>
            </p>
			<p class="info_item">
                <?php _e('Указываем(необязательно) несколько URL:', 'rupayments'); ?>
            </p>
			<p class="info_item">
            Result URL: <b style="color: #2aa4db;"><?php echo osc_base_url() .'oc-content/plugins/rupayments/payments/webmoney/notification.php';?></b>
        </p>
       <p class="info_item">
            Success URL: <b style="color: green;"><?php echo osc_base_url() .'index.php?page=custom&route=rupayments-payments-webmoney-success';?></b>
        </p>       <p class="info_item">
            Fail URL: <b style="color: red;"><?php echo osc_base_url() .'index.php?page=custom&route=rupayments-payments-webmoney-fail';?></b>
        </p>
		<p class="info_item"><?php _e('Методы вызова - POST', 'rupayments'); ?></p>
		<p class="info_item"><?php _e('Передавать параметры в предварительном запросе - нет. Не выбираем этот check-box!', 'rupayments'); ?></p>
		<p class="info_item"><?php _e('Выбираем check-box [x] Позволять использовать URL, передаваемые в форме, если не указывали Result URL, Success URL, Fail URL', 'rupayments'); ?></p>
		<p class="info_item"><?php _e('Выбираем в Метод формирования контрольной подписи - SHA256', 'rupayments'); ?></p>
		<p class="info_item"><?php _e('Обязательно требовать подтверждение транзакции по СМС - ВЫКЛ', 'rupayments'); ?></p>
		<p class="info_item"><?php _e('Обязательно требовать подпись платежной формы - ВЫКЛ', 'rupayments'); ?></p>
		<p class="info_item"><?php _e('Обеспечивать уникальность lmi_payment_no - ВЫКЛ', 'rupayments'); ?></p>
		<p class="info_item"><?php _e('Сохраняем настройки', 'rupayments'); ?></p>
		  <p class="info_item">
			   <?php _e('Вставляем номер кошелька(полнсотью с буквой R,Z и т.д.) и сектерный ключ в плагин', 'rupayments'); ?>
               </p>
                </div>
            </section>
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('Blockchain', 'rupayments'); ?></h3>
                
                <div class="info">
                    <h3><?php _e('Register wallet in  https://blockchain.info ', 'rupayments'); ?></h3>
        			<h3><?php _e('Get API KEY https://api.blockchain.info/v2/apikey/request/ ', 'rupayments'); ?></h3>
        			<h3><?php _e('secret: - think up any password and past', 'rupayments'); ?></h3>
        			<h3><?php _e('xpub: - copy from you Blockchain wallet and past', 'rupayments'); ?></h3>
        			<h3><?php _e('Count blocks: - you can set value 1-25. This affects the speed of validation of payments. The most used by user - 5 block.', 'rupayments'); ?></h3>
                    <h3><?php _e('If you use 5 blocks - after five notification from Blockchain - payment will be accepted by plugin.', 'rupayments'); ?></h3>
        			<p>
        			<?php _e('Your default currency may be a USD or other currency! Plugin convert currencies to BTC with Blockchain api', 'rupayments'); ?>.
                     <br/>
        			 <p class="info_item">
            			<?php _e('Of course you can use BTC currency only. But other payment systems not work with BTC.', 'rupayments'); ?>.
                     </p>
                </div>
            </section>
            
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('Fortumo', 'rupayments'); ?></h3>
                
                <div class="info">
                    <h3><?php _e('Fortumo setup', 'rupayments'); ?></h3>
                    <p class="info_item"><?php _e('Register - https://fortumo.com/ ', 'rupayments'); ?>
            			<br/>
            			<?php _e('Create new service. Select service type: Cross-Platform Mobile Payments', 'rupayments'); ?>
            			<br/>
            			<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/fortumo_cross.jpg" alt="">
                         <br/>
            			<?php _e('Step1. Select Country (or countries). I am select for example Italy:', 'rupayments'); ?>
            			<br/>
            				<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/select_country_fortumo.jpg" alt="">
                         <br/>
            			 <?php _e('Is Your Service, Game or App Related To…?:Adult or Erotic Content,Lotteries or Gambling,Donations. Select Yes or No.', 'rupayments'); ?>
                         <br/>
            			 	<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/fortumo1.jpg" alt="">
                         <br/>
            			 <?php _e('Setup price. Here are possible options. If you select Single item - you can specify only one price.', 'rupayments'); ?>
                         <br/>
            			 <?php _e('Or you can select Virtual credits. And user can choose the price at which he wants to Fund wallet on your website. As in my example:', 'rupayments'); ?>
                         <br/>
            			 	<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/fortumo_price.jpg" alt="">
                         <br/>
            			 <?php _e('Step2. Add info about you site and service. And paste - To which URL will your payment requests be forwarded to?:', 'rupayments'); ?>
            			<br/>
            			<b style="color: #2aa4db;"><?php echo osc_base_url() .'oc-content/plugins/rupayments/payments/fortumo/result.php';?></b>
            			<br/>
            			<?php _e('And paste - Where to redirect the user after completing the payment?:', 'rupayments'); ?>
            			<br/>
            			 <b style="color: #2aa4db;"><?php echo osc_base_url() .'oc-content/plugins/rupayments/payments/fortumo/return.php';?></b>
            			<br/>
            			<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/fortum_past.jpg" alt="">
                         <br/>
            			 <?php _e('Write Additional information about Your service.', 'rupayments'); ?>
                         <br/>
            			 <?php _e('Step3. Agree to follow all general rules. Confirm.', 'rupayments'); ?>
            			<br/>
            			<?php _e('Service ready to test.'); ?>
            			<br/>
            			<img src="<?php echo osc_base_url();?>oc-content/plugins/rupayments/admin/img/fortumo_end.jpg" alt="">
                         <br/>
            			  <?php _e('ServiceID and Secret past in plugin. Check - Enable Sandbox in plugin Fortumo settings. Test!', 'rupayments'); ?>
            			<br/>
            			  <?php _e('After testing. Check Go live in Fortumo site and get real SMS payments.', 'rupayments'); ?>
            			<br/>
            			  <?php _e('IMPORTANT!!! Fortumo enabled only in user account Wallet. The user can add funds to wallet on you site. And then pay for premium services from Wallet.', 'rupayments'); ?>
            			<br/>
            			
            			<br/>
                     </p>
                </div>
            </section>
            
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('Highlighting', 'rupayments'); ?></h3>
                
                <div class="info">
                    <h3><?php _e('Setting highlighting', 'rupayments'); ?></h3>
                    <p class="info_item">
                        <?php _e('Need small modifictions of theme files. Need add two HTML "id" tag with PHP code in search files.', 'rupayments'); ?>
                       <br/>
					   <p class="info_item">
                        <?php _e('Open these 2 files in your template:', 'rupayments') ?><strong>loop-single.php</strong>, <strong>loop-single-premium.php( or search_list.php and search_gallery.php)</strong>
                    </p>
					<p class="info_item">
                        <?php _e('In default theme Bender and in some other themes, files named:', 'rupayments') ?><strong>loop-single.php</strong>, <strong>loop-single-premium.php</strong>
                    </p>
					<p class="info_item">
                        <?php _e('In Modern theme and in some other themes, files named:', 'rupayments') ?><strong>search_list.php</strong>, <strong>search_gallery.php</strong>
                    </p>
					<p class="info_item">
                       <?php _e('First "id" ( or "class") for premium items', 'rupayments'); ?>
                   <span class="code-block"> 
                            id="<span class="php-tag">&lt;?php</span>
                                <span class="php-function"><span class="php-blue">if</span><span class="php-black">(</span>function_exists('rupayments_premium_get_class_color')){echo rupayments_premium_get_class_color(osc_premium_id());<span class="php-black"> }</span></span>
                            <span class="php-tag">?&gt;</span>"
                        </span>
				   </p>
				   <p class="info_item">
                        <?php _e('Second "id" ( or "class") for items', 'rupayments'); ?>
                    <span class="code-block"> 
                            id="<span class="php-tag">&lt;?php</span>
                                <span class="php-function"><span class="php-blue">if</span><span class="php-black">(</span>function_exists('rupayments_get_class_color')){echo rupayments_get_class_color(osc_item_id());<span class="php-black"> }</span></span>
                            <span class="php-tag">?&gt;</span>"
                        </span>
					</p>
					<p class="info_item">
                       <?php _e('In Highlighted ads will be shown - id = "colorized", normal - id = "normal". Items with id = "colorized" will have a Highlighted color background', 'rupayments'); ?>
                       </p>
					   <p class="info_item">
                        <?php _e('Example, for the Bender theme:', 'rupayments'); ?>
                         </p>
						<p class="info_item">
                        <?php _e('File loop-single.php - 2-line :', 'rupayments'); ?>
                         </p>
						 <p class="info_item">
                        <span class="code-block"> 
                            &lt;li class = "listing-card <span class="php-tag">&lt;?php</span>
                                <span class="php-function"><span class="php-black">echo $class; if(</span>osc_item_is_premium()){echo 'premium';}?&gt;" id="&lt;?php if(function_exists('rupayments_get_class_color')){echo rupayments_get_class_color(osc_item_id()<span class="php-black">);}</span></span>
                            <span class="php-tag">?&gt;</span>"&gt;
                        </span>
					   </p>
						<p class="info_item">
                        <?php _e('File loop-single-premium.php :', 'rupayments'); ?>
                        </p>
						<p class="info_item">
                                                <span class="code-block"> 
                            &lt;li class = "listing-card <span class="php-tag">&lt;?php</span>
                                <span class="php-function"><span class="php-black">echo $class; if(</span>osc_item_is_premium()){echo 'premium';}?&gt;" id="&lt;?php if(function_exists('rupayments_premium_get_class_color')){echo rupayments_premium_get_class_color(osc_premium_id()<span class="php-black">);}</span></span>
                            <span class="php-tag">?&gt;</span>"&gt;
                        </span>
                        </p>
						<p class="info_item">
                        <?php _e('Modified files for Modern and Bender(for examples) in /oc-content/plugins/rupayments/examples.', 'rupayments'); ?>
						</p>
                    </p>
                </div>
            </section>
            
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('Pay per Show Image', 'rupayments'); ?></h3>
                
                <div class="info">
                    
                    <p class="info_item">
                        <?php _e('Open these 3 files in your template:', 'rupayments') ?> <strong>item.php</strong> and <strong>loop-single.php</strong>, <strong>loop-single-premium.php( or search_list.php and search_gallery.php)</strong>
                    </p>
					<p class="info_item">
                        <?php _e('In default theme Bender and in some other themes, files named:', 'rupayments') ?><strong>loop-single.php</strong>, <strong>loop-single-premium.php</strong>
                    </p>
					<p class="info_item">
                        <?php _e('In Modern theme and in some other themes, files named:', 'rupayments') ?><strong>search_list.php</strong>, <strong>search_gallery.php</strong>
                    </p>
                    
                    <p class="info_item">
                        1. <?php _e('In the <strong>item.php</strong> file find line of code:', 'rupayments') ?> 
                        
                        <span class="code-block"> 
                            <span class="php-tag">&lt;?php</span>
                                <span class="php-function"><span class="php-blue">if</span><span class="php-black">(</span> osc_images_enabled_at_items() <span class="php-black">) {</span></span>
                            <span class="php-tag">?&gt;</span>
                        </span>
                        <br /><br />
                        <?php _e('And Replace with:', 'rupayments') ?>
                        
                        <span class="code-block"> 
                            <span class="php-tag">&lt;?php</span>
                                <span class="php-function"><span class="php-blue">if</span><span class="php-black">(</span> osc_images_enabled_at_items() <span class="php-black">&amp;&amp;</span> osc_apply_filter(<span class="php-function-data">'rupayments_item_img'</span>, rupayments_item_img(Params::<span class="php-light-blue">getParam</span>(<span class="php-function-data">'id'</span>)<span class="php-black">))) {</span></span>
                            <span class="php-tag">?&gt;</span>
                        </span>
                    </p>
                    
                    <p class="info_item">
                        2. <?php _e('In the <strong>loop-single.php( or search_list.php and search_gallery.php)</strong> file find line of code:', 'rupayments') ?> 
                        
                        <span class="code-block"> 
                            <span class="php-tag">&lt;?php</span>
                                <span class="php-function"><span class="php-blue">if</span><span class="php-black">(</span> osc_images_enabled_at_items() <span class="php-black">) {</span></span>
                            <span class="php-tag">?&gt;</span>
                        </span>
                        <br /><br />
                        <?php _e('And Replace with:', 'rupayments') ?>
                        
                        <span class="code-block"> 
                            <span class="php-tag">&lt;?php</span>
                                <span class="php-function"><span class="php-blue">if</span><span class="php-black">(</span> osc_images_enabled_at_items() <span class="php-black">&amp;&amp;</span> osc_apply_filter(<span class="php-function-data">'rupayments_item_img'</span>, rupayments_item_img(osc_item_id()<span class="php-black">))) {</span></span>
                            <span class="php-tag">?&gt;</span>
                        </span>
                    </p>
                    
                    <p class="info_item">
                        3. <?php _e('In the <strong>loop-single-premium.php(if such a file is in the theme)</strong> file find line of code:', 'rupayments') ?> 
                        
                        <span class="code-block"> 
                            <span class="php-tag">&lt;?php</span>
                                <span class="php-function"><span class="php-blue">if</span><span class="php-black">(</span> osc_images_enabled_at_items() <span class="php-black">) {</span></span>
                            <span class="php-tag">?&gt;</span>
                        </span>
                        <br /><br />
                        <?php _e('And Replace with:', 'rupayments') ?>
                        
                        <span class="code-block"> 
                            <span class="php-tag">&lt;?php</span>
                                <span class="php-function"><span class="php-blue">if</span><span class="php-black">(</span> osc_images_enabled_at_items() <span class="php-black">&amp;&amp;</span> osc_apply_filter(<span class="php-function-data">'rupayments_item_img'</span>, rupayments_item_img(osc_premium_id()<span class="php-black">))) {</span></span>
                            <span class="php-tag">?&gt;</span>
                        </span>
                    </p>
                    
                    <p class="info_item">
                        <?php _e('Modified files for Modern and Bender (for examples) in <strong>/oc-content/plugins/rupayments/examples</strong>.', 'rupayments'); ?>
                    </p>
                    
                </div>
            </section>
            
            <section class="accordion_item">
                    <h3 class="title_block"><?php _e('How to add button "Buy Item" on the site', 'rupayments') ?></h3>
                    <div class="info">
                        <p class="info_item">
                            <?php _e('It\'s simple, just open file in your template:', 'rupayments') ?> <strong>item.php</strong>
                        </p>
                        
                        <p class="info_item">
                            <?php _e('And add the one line of code:', 'rupayments') ?> 
                            
                            <span class="code-block"> 
                                <span class="php-tag">&lt;?php</span>
                                    <span class="php-function"> osc_run_hook(<span class="php-function-data">'rupayments_ebuy_btn'</span>, rupayments_ebuy_btn(Params::<span class="php-light-blue">getParam</span>(<span class="php-function-data">'id'</span>))); </span>
                                <span class="php-tag">?&gt;</span>
                            </span>
                        </p>
                        
                        <p class="info_item">
                            <?php _e('Modified files for Bender (for examples) in <strong>/oc-content/plugins/rupayments/examples</strong>.', 'rupayments'); ?>
                        </p>
                    </div>
                </section>
            
            <section class="accordion_item">
                <h3 class="title_block"><?php _e('Important information!!!', 'rupayments'); ?></h3>
                
                <div class="info">
                    <p class="info_item">
                        <?php _e('If you test the plugin and publish listings from Front-end, you must logout from  oc-admin. Otherwise you will not see "After publish" option or "Publish fee" option.', 'rupayments'); ?>
                        <br/>
                    </p>
        			<p class="info_item">
                        <?php _e('If you logged in oc-admin you can see buttons for Admin in Front-end item page and make item Premium, Move to TOP, Highlight without Payment.', 'rupayments'); ?>
                        <br/>
                    </p>
        			<p class="info_item">
                        <?php _e('If you logged as user, you can see buttons for User in Front-end item page and Pay item Premium, Move to TOP, Highlight .', 'rupayments'); ?>
                        <br/>
                    </p>
        			<p class="info_item">
                        <?php _e('Enable Cron. We recommend you to use  hourly Crontab on the hosting or server. More: https://osclass.pro/dokumentaciya/cron/ .  ', 'rupayments'); ?>
                        <br/>
                    </p>
					<p class="info_item">
                        <?php _e('Osclass cron is a psevdo cron. And it not work fine. This is only if you not have another choice.  ', 'rupayments'); ?>
                        <br/>
                    </p>
					<p class="info_item">
                        <?php _e('Simle command for CRON -  wget domain.com/index.php?page=cron . Use it hourly.', 'rupayments'); ?>
                        <br/>
                    </p>
					<p class="info_item">
                        <?php _e('After each plugin update first Disable and then Enable plugin to take effect changes.  ', 'rupayments'); ?>
                        <br/>
                    </p>
                </div>
            </section>
        </div>
    </div>
</div>

<script type="text/javascript">
! function(i) {
  var o, n;
  i(".title_block").on("click", function() {
    o = i(this).parents(".accordion_item"), n = o.find(".info"),
      o.hasClass("active_block") ? (o.removeClass("active_block"),
        n.slideUp()) : (o.addClass("active_block"), n.stop(!0, !0).slideDown(),
        o.siblings(".active_block").removeClass("active_block").children(
          ".info").stop(!0, !0).slideUp())
  })
}(jQuery);
</script>