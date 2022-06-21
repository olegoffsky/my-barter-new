<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>
<h2 class="render-title"><b><i class="fa fa-file-text"></i> <?php _e('Help', 'rupayments'); ?></b></h2>
<h3 class="render-title separate-top"><i class="fa"></i> <?php _e('Paypal', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.paypal').toggle();" ><?php _e('Show', 'rupayments'); ?></a></span>
    <div class="form-horizontal">
        <div class="form-row paypal hide">
            <h3><?php _e('API or Standard Payments?', 'rupayments'); ?></h3>
            <p>
                <?php _e('API PayPal give you more control over the Paypal process, it\'s required for digital goods & micropayments (Note: Not all countries are allowed to have digital goods & micropayments processes). On the other side standard Paypal are simple, less customizable but works everywhere.', 'rupayments'); ?>.
                <br/>
                <?php _e('Microppaypals offers a reduction on the fee to pay Paypal for orders under 4$ (or equivalent), around 5cents + 5% while standard Paypal have a fee around 30cents + 5%. Due the nature of OSClass is recommended to use micropayments, but we\'re aware that they\'re not available worldwide. Please check with Paypal the avalaibility of the service in your area.', 'rupayments'); ?>.
                <br/>
            </p>
            <h3><?php _e('Setting up your Paypal account for Standard Payments', 'rupayments'); ?></h3>
            <p>
                <?php _e('Write your PayPal email and check the "Use Standard Payment" option', 'rupayments'); ?>.
                <br/>
            </p>
            <h3><?php _e('Setting up your Paypal account for micropaymets/API', 'rupayments'); ?></h3>
            <p>
                <?php _e('Before being able to use Paypal plugin, you need to set up some configuration at your Paypal account', 'rupayments'); ?>.
                <br/>
                <?php _e('Your Paypal account has to be set as Business or Premier, you could change that at Your Profile, under My Settings', 'rupayments'); ?>.
                <br/>
                <?php echo sprintf( __('You need to sign in up for micropayments/digital good <a href="%s">from here</a>.', 'rupayments'), 'https://merchant.ppaypal.com/cgi-bin/marketingweb?cmd=_render-content&content_ID=merchant/digital_goods'); ?>.
                <br/>
                <?php _e('You need Paypal API credentials (before entering here your API credentials, MODIFY index.php file of this plugin and change the value of PAYPAL_CRYPT_KEY variable to make your API more secure)', 'rupayments'); ?>.
                <br/>
                <?php _e('You need to tell Paypal where is your IPN file', 'rupayments'); ?>
            </p>
            <h3><?php _e('Setting up your IPN', 'rupayments'); ?></h3>
            <p>
                <?php _e('Click Profile on the My Account tab', 'rupayments'); ?>.
                <br/>
                <?php _e('Click Instant Payment Notification Preferences in the Selling Preferences column', 'rupayments'); ?>.
                <br/>
                <?php _e("Click Choose IPN Settings to specify your listener?s URL and activate the listener (usually is http://www.yourdomain.com/oc-content/plugins/rupayments/payments/paypal/paypal/notify_url.php)", 'rupayments'); ?>.
            </p>
            <h3><?php _e('How to obtain API credentials', 'ppaypal'); ?></h3>
            <p>
                <?php _e('In order to use the Paypal plugin you will need Paypal API credentials, you could obtain them for free following theses steps', 'rupayments'); ?>:
                <br/>
                <?php _e('Verify your account status. Go to your PayPal Profile under My Settings and verify that your Account Type is Premier or Business, or upgrade your account', "rupayments"); ?>.
                <br/>
                <?php _e('Verify your API settings. Click on My Selling Tools. Click Selling Online and verify your API access. Click Update to view or set up your API signature and credentials', 'rupayments'); ?>.
            </p>
            <h3><?php _e('Test plugin with Paypal Sandbox', 'rupayments'); ?></h3>
            <p>
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
<h3 class="render-title separate-top"><i class="fa"></i> <?php _e('2Checkout', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.2checkout').toggle();" ><?php _e('Show', 'rupayments'); ?></a></span>
          <div class="form-horizontal 2checkout hide">
        <div class="form-row">
            
			<h3><?php _e('Test plugin with 2Checkout Sandbox', 'rupayments'); ?></h3>
            <p>
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
				<?php _e('6.Approved URL - insert link' , 'rupayments'); ?>:  <b style="color: #2aa4db;">http://<?php echo $_SERVER['SERVER_NAME'].'/oc-content/plugins/rupayments/payments/2chekout/return.php';?></b>
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
            <p>
                <?php _e('1.Register at https://www.2checkout.com. Go to Account - Site Managment', 'rupayments'); ?>:
                <br/>
				<?php _e('2.Site Settings. Demo Setting - select Parameter', 'rupayments'); ?>.
                <br/>
				<?php _e('3.Set all options. Direct Return - select Direct Return(Our URL)', 'rupayments'); ?>.
                <br/>
				<?php _e('4.Approved URL also', 'rupayments'); ?>:  <b style="color: #2aa4db;">http://<?php echo $_SERVER['SERVER_NAME'].'/oc-content/plugins/rupayments/payments/2chekout/return.php';?></b>
                <br/>
				<?php _e('5.Insert Account Number and Secret Word from 2Checkout to plugin fields.', 'rupayments'); ?>.
                <br/>
				<?php _e('6.Disable - 2Checkout sandbox. Save changes.', 'rupayments'); ?>.
                <br/>
			</p>
			<h3><?php _e('Language 2CO page', 'rupayments'); ?></h3>
			<p> 
                 <?php _e('This option allow you select in what language buyer see 2Checkout site ', 'rupayments'); ?>.
                 <br/>	
				 </p></div></div>
<h3 class="render-title separate-top"><i class="fa"></i> <?php _e('Stripe', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.stripe').toggle();" ><?php _e('Show', 'rupayments'); ?></a></span>
    <div class="form-horizontal">
        <div class="form-row stripe hide">
            <p><?php _e('You need to register on the site', 'rupayments'); ?> <a target="_blank" href="https://stripe.com/">https://stripe.com/</a></p>
			<p><?php _e('And then configure the plugin', 'rupayments'); ?></p>
			</div>  
    </div>
<h3 class="render-title separate-top"><i class="fa"></i> <?php _e('Braintree', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.braintree').toggle();" ><?php _e('Show', 'rupayments'); ?></a></span>
    <div class="form-horizontal">
        <div class="form-row braintree hide">
            <h3><?php _e('You need to register on the site', 'rupayments'); ?></h3> <a target="_blank" href="https://www.braintreepayments.com/">https://www.braintreepayments.com/</a>
            <p>
			<p><?php _e('And then configure the plugin', 'rupayments'); ?></p>
			<?php _e('Braintree only works with a single currency which is set in you Braintree account! ', 'rupayments'); ?>.
             <br/>
         </p></div>    
    </div>
<h3 class="render-title separate-top"><i class="fa"></i> <?php _e('Payulatam', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.payulatam').toggle();" ><?php _e('Show', 'rupayments'); ?></a></span>
    <div class="form-horizontal">
        <div class="form-row payulatam hide">
			<?php _e('Payulatam Webcheckout( Payumoney for Latin America) only works with a currencies:', 'rupayments'); ?>
<p>ARS -	Argentenian Pesos</p>
<p>BRL -	Brazilian Reales</p>
<p>CLP -	Chilean Pesos</p>
<p>COP -	Colombian Pesos</p>
<p>MXN -	Mexican Pesos</p>
<p>PEN -	Peruvian New Soles</p>
<p>USD -	U.S. Dollars!</p>
             <br/>
            <h3><?php _e('For work with real payments, sign in:', 'rupayments'); ?></h3><a target="_blank" href="https://www.payulatam.com/">https://www.payulatam.com/</a>
			<h3><?php _e('For testing in Sandbox read:', 'rupayments'); ?></h3><a target="_blank" href="http://developers.payulatam.com/en/web_checkout/sandbox.html">http://developers.payulatam.com/en/web_checkout/sandbox.html</a>
         </p></div>    
    </div>
<h3 class="render-title separate-top"><i class="fa"></i> <?php _e('Payumoney', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.payumoney').toggle();" ><?php _e('Show', 'rupayments'); ?></a></span>
    <div class="form-horizontal">
        <div class="form-row payumoney hide">
            <h3><?php _e('For real sign in', 'rupayments'); ?></h3><a target="_blank" href="https://www.payumoney.com/">https://www.payumoney.com/</a>
			<h3><?php _e('For test account sign in', 'rupayments'); ?></h3><a target="_blank" href="https://test.payumoney.com/">https://test.payumoney.com/</a>
            <p>
			<?php _e('Payumoney only works with a INR currency! ', 'rupayments'); ?>.
             <br/>
         </p></div>    
    </div>
<h3 class="render-title separate-top"><i class="fa"></i> <?php _e('Scrill', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.scrill').toggle();" ><?php _e('Show', 'rupayments'); ?></a></span>
    <div class="form-horizontal">
        <div class="form-row scrill hide">
            <h3><?php _e('For real payments sign in', 'rupayments'); ?></h3><a target="_blank" href="https://www.skrill.com/">https://www.skrill.com/</a>
			<h3><?php _e('For test Enable Sandbox and leave empty all fields in plugin settings for Scrill. Test credit card number you can get from table 2.3.', 'rupayments'); ?></h3><a target="_blank" href="https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf">https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf</a>
            <p>
             <br/>
         </p></div>    
    </div>
	
<h3 class="render-title separate-top"><i class="fa"></i> <?php _e('Blockchain', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.blockchain').toggle();" ><?php _e('Show', 'rupayments'); ?></a></span>
    <div class="form-horizontal">
        <div class="form-row blockchain hide">
            <h3><?php _e('Register wallet in  https://blockchain.info ', 'rupayments'); ?></h3>
			<h3><?php _e('Get API KEY https://api.blockchain.info/v2/apikey/request/ ', 'rupayments'); ?></h3>
			<h3><?php _e('secret: - think up any password and past', 'rupayments'); ?></h3>
			<h3><?php _e('xpub: - copy from you Blockchain wallet and past', 'rupayments'); ?></h3>
			<h3><?php _e('Count blocks: - you can set value 1-25. This affects the speed of validation of payments. The most used by user - 5 block.', 'rupayments'); ?></h3>
            <h3><?php _e('If you use 5 blocks - after five notification from Blockchain - payment will be accepted by plugin.', 'rupayments'); ?></h3>
			<p>
			<?php _e('Your default currency may be a USD or other currency! Plugin convert currencies to BTC with Blockchain api', 'rupayments'); ?>.
             <br/>
			 <p>
			<?php _e('Of course you can use BTC currency only. But other payment systems not work with BTC.', 'rupayments'); ?>.
             <br/>
         </p></div>    
    </div>
	 <!-- fortumo -->
<h3 class="render-title separate-top"><i class="fa"></i> <?php _e('Fortumo', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.fortumo').toggle();" ><?php _e('Show', 'rupayments'); ?></a></span>

        <div class="form-horizontal fortumo hide">
		<h3><?php _e('Fortumo setup', 'rupayments'); ?></h3>
            <p><?php _e('Register - https://fortumo.com/ ', 'rupayments'); ?>
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
			<b style="color: #2aa4db;">http://<?php echo $_SERVER['SERVER_NAME'].'/oc-content/plugins/rupayments/payments/fortumo/result.php';?></b>
			<br/>
			<?php _e('And paste - Where to redirect the user after completing the payment?:', 'rupayments'); ?>
			<br/>
			 <b style="color: #2aa4db;">http://<?php echo $_SERVER['SERVER_NAME'].'/oc-content/plugins/rupayments/payments/fortumo/return.php';?></b>
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
         </p></div>    
 <!-- / fortumo -->  
<h3 class="render-title separate-top"><i class="fa"></i> <?php _e('Highlighting', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.high').toggle();" ><?php _e('Show', 'rupayments'); ?></a></span>
    <div class="form-horizontal">
        <div class="form-row high hide">
              <h3><?php _e('Setting highlighting', 'rupayments'); ?></h3>
            <p>
                <?php _e('Need small modifictions of theme files. Need add two HTML "id" tag with PHP code in search files.', 'rupayments'); ?>
               <br/>
               <?php _e('First "id" for premium items id="&lt;?php if(function_exists(\'rupayments_premium_get_class_color\')){echo rupayments_premium_get_class_color(osc_premium_id());}?&gt;" .', 'rupayments'); ?>
                <br/>
                <?php _e('Second "id" for items id="&lt;?php if(function_exists(\'rupayments_get_class_color\')){echo rupayments_get_class_color(osc_item_id());}?&gt;"', 'rupayments'); ?>
                <br/>
               <?php _e('In Highlighted ads will be shown - id = "colorized", normal - id = "normal". Items with id = "colorized" will have a Highlighted color background', 'rupayments'); ?>
               <br/>
                <?php _e('Example, for the Bender theme:', 'rupayments'); ?>
                <br/>
                <?php _e('File loop-single.php - 2-line :', 'rupayments'); ?>
                <br/>
                <?php _e('&lt;li class = "listing-card &lt;?php echo $class; if(osc_item_is_premium()){echo\'premium\';}?&gt;" id="&lt;?php if(function_exists(\'rupayments_get_class_color\')){echo rupayments_get_class_color(osc_item_id());}?&gt;"&gt;', 'rupayments'); ?>
                <br/>
                <?php _e('File loop-single-premium.php :', 'rupayments'); ?>
                <br/>
                <?php _e('&lt;li class = "listing-card &lt;?php echo $class; if(osc_item_is_premium()){echo\'premium\';}?&gt;" id="&lt;?php if(function_exists(\'rupayments_premium_get_class_color\')){echo rupayments_premium_get_class_color(osc_premium_id());}?&gt;"&gt;', 'rupayments'); ?>
                <br/>
                <?php _e('Modified files for Modern and Bender(for examples) in /oc-content/plugins/rupayments/examples.', 'rupayments'); ?>
            </p></div>    
    </div>	
	<h3 class="render-title separate-top"><i class="fa"></i> <?php _e('Important information!!!', 'rupayments'); ?> <span style="font-size: 1.1em;" ><a style="color:#018BE3!important;" href="javascript:void(0);" onclick="$('.imp').toggle();" ><?php _e('Show', 'rupayments'); ?></a></span>
    <div class="form-horizontal">
        <div class="form-row imp hide">
            <p>
                <?php _e('If you test the plugin and publish listings from Front-end, you must logout from  oc-admin. Otherwise you will not see "After publish" option or "Publish fee" option.', 'rupayments'); ?>
                <br/>
            </p>
			<p>
                <?php _e('If you logged in oc-admin you can see buttons for Admin in Front-end item page and make item Premium, Move to TOP, Highlight without Payment.', 'rupayments'); ?>
                <br/>
            </p>
						<p>
                <?php _e('If you logged as user, you can see buttons for User in Front-end item page and Pay item Premium, Move to TOP, Highlight .', 'rupayments'); ?>
                <br/>
            </p>
			<p>
                <?php _e('Enable Cron. We recommend you to use  hourly Crontab on the hosting or server. More: https://doc.osclass.org/Cron .  ', 'rupayments'); ?>
                <br/>
            </p>
			</div>    
    </div>
    </div>
		<address class="osclasspro_address">
	<span>&copy; <?php echo date('Y') ?> <a target="_blank" title="osclass-pro.com" href="https://www.osclass-pro.com/">osclass-pro.com</a>. All rights reserved.</span>
  </address>