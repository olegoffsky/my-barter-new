<?php
/*
 * Copyright 2017-2020 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
    class ModelRUpayments extends DAO
    {

        private static $instance ;
        
        public $userGroupId, $userDiscount;

        public static function newInstance()
        {
            if( !self::$instance instanceof self ) {
                self::$instance = new self ;
            }
            return self::$instance ;
        }


        function __construct()
        {
            parent::__construct();
            
            if(osc_is_web_user_logged_in() && osc_get_preference('version', 'rupayments')) {
                $checkUserMembership = $this->getUserMembership(osc_logged_user_id());
            
                if($checkUserMembership) {
                    $this->userGroupId = $checkUserMembership['f_group_id'];
                    $this->userDiscount = $checkUserMembership['f_group_discount'];
                }
                else {
                    $this->userGroupId = 0;
                    $this->userDiscount = 0;
                }
            }
			 else {
                $this->userGroupId = 0;
                $this->userDiscount = 0;
            }
        }
        
		public function getTable_rupayments_user(){
            return DB_TABLE_PREFIX.'t_user';
        }

        public function getTable_log()
        {
            return DB_TABLE_PREFIX.'t_rupayments_log';
        }

        public function getTable_wallet()
        {
            return DB_TABLE_PREFIX.'t_rupayments_wallet';
        }

        public function getTable_premium()
        {
            return DB_TABLE_PREFIX.'t_rupayments_premium';
        }

        public function getTable_publish()
        {
            return DB_TABLE_PREFIX.'t_rupayments_publish';
        }

        public function getTable_prices()
        {
            return DB_TABLE_PREFIX.'t_rupayments_prices';
        }
        
        public function getTable_policy()
        {
            return DB_TABLE_PREFIX.'t_rupayments_policy';
        }
       
	    public function getTable_item()
        {
            return DB_TABLE_PREFIX.'t_item';
        }
        
        public function getTable_item_description()
        {
            return DB_TABLE_PREFIX.'t_item_description';
        }

        public function getTable_colorized()
        {
            return DB_TABLE_PREFIX.'t_rupayments_colorized';
        }  		
        
	    public function getTable_is_publish_payment_needed()
        {
            return DB_TABLE_PREFIX.'t_rupayments_is_publish_payment_needed';
        }  
        
	    public function getTable_cron_email_filter()
        {
            return DB_TABLE_PREFIX.'t_rupayments_cron_email_filter';
        } 
        
        public function getTable_skrill()
        {
            return DB_TABLE_PREFIX.'t_rupayments_skrill';
        }
		
		 public function getTable_bitcoin()
        {
            return 'oc_t_rupayments_bitcoin';
        } 
        
        public function getTable_region_prices()
        {
            return DB_TABLE_PREFIX.'t_rupayments_region_prices
';
        } 

        public function getTable_packs()
        {
            return DB_TABLE_PREFIX.'t_rupayments_packs';
        } 
        
        public function getTable_user_groups()
        {
            return DB_TABLE_PREFIX.'t_rupayments_user_groups';
        } 
        
        public function getTable_user_memberships() {
            return DB_TABLE_PREFIX.'t_rupayments_user_groups_membership';
        }
        
        public function getTable_banners()
        {
            return DB_TABLE_PREFIX.'t_rupayments_banners';
        }
        
        public function getTable_banner_settings()
        {
            return DB_TABLE_PREFIX.'t_rupayments_banner_settings';
        }
        
         public function getTable_image_show()
        {
            return DB_TABLE_PREFIX.'t_rupayments_image_show';
        }
        
        public function getTable_pack3in1()
        {
            return DB_TABLE_PREFIX.'t_rupayments_top';
        }
        
        public function getTable_ebuy()
        {
            return DB_TABLE_PREFIX.'t_rupayments_ebuy';
        }
        
        public function getTable_ebuy_deals()
        {
            return DB_TABLE_PREFIX.'t_rupayments_ebuy_deals';
        }
        
        public function import($file)
        {                                      
            $sql = file_get_contents($file);
            
            if(! $this->dao->importSQL($sql) ){
                throw new Exception( "Error import SQL::ModelRUpayments<br>".$file ) ; 
            }
            
        }
        public function addban2()
        {                                            
        $sql2 = "INSERT INTO `".DB_TABLE_PREFIX."t_rupayments_banner_settings` (`fk_i_bs_id`, `fk_bs_title`, `f_bs_code`, `f_bs_view_fee`, `f_bs_click_fee`, `f_bs_status`) VALUES
(1, 'Place for Your banner #1', '<span class=\"php-tag\">&lt;?php</span><span class=\"php-function\"> osc_run_hook(<span class=\"php-function-data\">''rupayments_banner_1''</span>);</span><span class=\"php-tag\">?&gt;</span>', '0', '0', 0),
(2, 'Place for Your banner #2', '<span class=\"php-tag\">&lt;?php</span><span class=\"php-function\"> osc_run_hook(<span class=\"php-function-data\">''rupayments_banner_2''</span>); </span><span class=\"php-tag\">?&gt;</span>', '0', '0', 0),
(3, 'Place for Your banner #3', '<span class=\"php-tag\">&lt;?php</span><span class=\"php-function\"> osc_run_hook(<span class=\"php-function-data\">''rupayments_banner_3''</span>); </span><span class=\"php-tag\">?&gt;</span>', '0', '0', 0),
(4, 'Place for Your banner #4', '<span class=\"php-tag\">&lt;?php</span><span class=\"php-function\"> osc_run_hook(<span class=\"php-function-data\">''rupayments_banner_4''</span>); </span><span class=\"php-tag\">?&gt;</span>', '0', '0', 0),
(5, 'Place for Your banner #5', '<span class=\"php-tag\">&lt;?php</span><span class=\"php-function\"> osc_run_hook(<span class=\"php-function-data\">''rupayments_banner_5''</span>); </span><span class=\"php-tag\">?&gt;</span>', '0', '0', 0),
(6, 'Place for Your banner #6', '<span class=\"php-tag\">&lt;?php</span><span class=\"php-function\"> osc_run_hook(<span class=\"php-function-data\">''rupayments_banner_6''</span>); </span><span class=\"php-tag\">?&gt;</span>', '0', '0', 0),
(7, 'Place for Your banner #7', '<span class=\"php-tag\">&lt;?php</span><span class=\"php-function\"> osc_run_hook(<span class=\"php-function-data\">''rupayments_banner_7''</span>); </span><span class=\"php-tag\">?&gt;</span>', '0', '0', 0),
(8, 'Place for Your banner #8', '<span class=\"php-tag\">&lt;?php</span><span class=\"php-function\"> osc_run_hook(<span class=\"php-function-data\">''rupayments_banner_8''</span>); </span><span class=\"php-tag\">?&gt;</span>', '0', '0', 0),
(9, 'Place for Your banner #9', '<span class=\"php-tag\">&lt;?php</span><span class=\"php-function\"> osc_run_hook(<span class=\"php-function-data\">''rupayments_banner_9''</span>); </span><span class=\"php-tag\">?&gt;</span>', '0', '0', 0),
(10, 'Place for Your banner #10', '<span class=\"php-tag\">&lt;?php</span><span class=\"php-function\"> osc_run_hook(<span class=\"php-function-data\">''rupayments_banner_10''</span>); </span><span class=\"php-tag\">?&gt;</span>', '0', '0', 0);";

            $this->dao->query($sql2);
        }
        public function install() {

            $this->import ( RUPAYMENTS_PATH.'struct.sql' );
           $this->addban2();
            osc_set_preference('version', '430', 'rupayments', 'INTEGER');
            osc_set_preference('default_premium_cost', '0', 'rupayments', 'STRING');
	    osc_set_preference('default_top_cost', '0', 'rupayments', 'STRING');
	    osc_set_preference('default_color_cost', '0', 'rupayments', 'STRING');
        osc_set_preference('allow_premium', '0', 'rupayments', 'BOOLEAN');
	    osc_set_preference('allow_move', '0', 'rupayments', 'BOOLEAN');
	    osc_set_preference('allow_high', '0', 'rupayments', 'BOOLEAN');
	    osc_set_preference('allow_after', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('default_publish_cost', '0', 'rupayments', 'STRING');
			osc_set_preference('default_renew_cost', '0', 'rupayments', 'STRING');
			osc_set_preference('color', '#FF8040', 'rupayments', 'STRING');
            osc_set_preference('pay_per_post', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('color_days', '7', 'rupayments', 'INTEGER');
            osc_set_preference('premium_days', '7', 'rupayments', 'INTEGER');
            osc_set_preference('currency', 'USD', 'rupayments', 'STRING');
			osc_set_preference('allow_regbonus', '0', 'rupayments', 'BOOLEAN');
			osc_set_preference('regbonus_value', '0', 'rupayments', 'STRING');
            osc_set_preference('days_before_deadline_for_sending_email', '2', 'rupayments', 'INTEGER');
			osc_set_preference('allow_itempost_form', '0', 'rupayments', 'BOOLEAN');
			osc_set_preference('allow_item_form', '0', 'rupayments', 'BOOLEAN');
			osc_set_preference('allow_renew', '0', 'rupayments', 'BOOLEAN');
             
            /* Параметры подключения к РР */
            osc_set_preference('paypal_api_username', '', 'rupayments', 'STRING');
            osc_set_preference('paypal_api_password', '', 'rupayments', 'STRING');
            osc_set_preference('paypal_api_signature', '', 'rupayments', 'STRING');
            osc_set_preference('paypal_email', '', 'rupayments', 'STRING');
            osc_set_preference('paypal_standard', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('paypal_sandbox', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('paypal_enabled', '0', 'rupayments', 'BOOLEAN');
            
            /* Параметры подключения к 2Chekout */
            osc_set_preference('co2_email', '', 'rupayments', 'STRING');
            osc_set_preference('co2_sandbox', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('mrhlogin','','rupayments','STRING');
            osc_set_preference('secret_word','','rupayments','STRING');
            osc_set_preference('co2_enabled', '0', 'rupayments', 'BOOLEAN');
			osc_set_preference('language', 'en', 'rupayments', 'STRING');
			
			 /* Параметры подключения к fortumo */
            osc_set_preference('fortumo_email', '', 'rupayments', 'STRING');
            osc_set_preference('fortumo_sandbox', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('fortumo_mrhlogin','','rupayments','STRING');
            osc_set_preference('fortumo_secret_word','','rupayments','STRING');
            osc_set_preference('fortumo_enabled', '0', 'rupayments', 'BOOLEAN');
			osc_set_preference('fortumo_language', 'en', 'rupayments', 'STRING');
            
						
			 /* Параметры подключения к blockchain */

 
            osc_set_preference('blockchain_mrhlogin','','rupayments','STRING');
            osc_set_preference('blockchain_secret_word','','rupayments','STRING');
            osc_set_preference('blockchain_api_key_word','','rupayments','STRING');
            osc_set_preference('blockchain_enabled', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('blockchain_blocks', '0', 'rupayments', 'STRING');

			
            
            /* UPDATED PREFERENCES */
            osc_set_preference('3_in_1_pack_days', '7', 'rupayments', 'INTEGER');
            osc_set_preference('3_in_1_pack_status', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('allow_ebuy', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('allow_periodbonus', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('default_3_in_1_pack_cost', '0', 'rupayments', 'STRING');
            osc_set_preference('default_pay_per_show_image_cost', '0', 'rupayments', 'STRING');
            osc_set_preference('pay_per_show_image_status', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('periodbonus_last_accrual', '0', 'rupayments', 'STRING');
            osc_set_preference('periodbonus_start_date', '0', 'rupayments', 'STRING');
            osc_set_preference('periodbonus_value', '0', 'rupayments', 'STRING');
            osc_set_preference('period_value', '7', 'rupayments', 'INTEGER');
			
			                        /* Параметры подключения к Yandex */ 
            osc_set_preference('yandex_receiver', '', 'rupayments', 'STRING');
            osc_set_preference('yandex_secret_word', '', 'rupayments', 'STRING');
            osc_set_preference('yandex_currency', '643', 'rupayments', 'STRING');
            osc_set_preference('yandex_enabled', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('yandex_by_carta', '1', 'rupayments', 'BOOLEAN');
            osc_set_preference('yandex_by_wallet', '1', 'rupayments', 'BOOLEAN');
            osc_set_preference('yandex_by_mobile_phone', '1', 'rupayments', 'BOOLEAN');
			
			               /* Параметры подключения к Interkassa*/ 
            osc_set_preference('ik_co_id', '', 'rupayments', 'STRING');
            osc_set_preference('interkassa_secret', '', 'rupayments', 'STRING');
            osc_set_preference('interkassa_enabled', '0', 'rupayments', 'BOOLEAN');
			              /* Параметры подключения к Robokassa*/ 
			osc_set_preference('mrhlogin','','rupayments','STRING');
            osc_set_preference('mrhpass1','','rupayments','STRING');
            osc_set_preference('mrhpass2','','rupayments','STRING');
			osc_set_preference('robokassa_enabled', '0', 'rupayments', 'BOOLEAN');
			osc_set_preference('robo_sandbox', '0', 'rupayments', 'BOOLEAN');
			
				              /* Параметры подключения к Walletone*/ 
			osc_set_preference('wologin','','rupayments','STRING');
            osc_set_preference('wopass1','','rupayments','STRING');
            osc_set_preference('wopass2','','rupayments','STRING');
			osc_set_preference('wo_enabled', '0', 'rupayments', 'BOOLEAN');
			
			/* Параметры подключения к Payeer*/ 
			osc_set_preference('payeer_merchant_id', '', 'rupayments', 'STRING');
			osc_set_preference('payeer_secret_key', '', 'rupayments', 'STRING');
			osc_set_preference('payeer_ip_filter', '', 'rupayments', 'STRING');
			osc_set_preference('payeer_enabled', '0', 'rupayments', 'BOOLEAN');
			
			               /* Параметры подключения к Freekassa*/ 
            osc_set_preference('ik_co_id_free', '', 'rupayments', 'STRING');
            osc_set_preference('freekassa_secret', '', 'rupayments', 'STRING');
			osc_set_preference('freekassa_secret2', '', 'rupayments', 'STRING');
            osc_set_preference('freekassa_enabled', '0', 'rupayments', 'BOOLEAN');
			
			               /* Параметры подключения к Webmoney*/ 
            osc_set_preference('webmoney_id', '', 'rupayments', 'STRING');
            osc_set_preference('webmoney_secret', '', 'rupayments', 'STRING');
			osc_set_preference('webmoney_enabled', '0', 'rupayments', 'BOOLEAN');


            
            
            $this->dao->select('pk_i_id') ;
            $this->dao->from(DB_TABLE_PREFIX.'t_item') ;
            $result = $this->dao->get();
            if($result) {
                $items  = $result->result();
                $date = date("Y-m-d H:i:s");
                foreach($items as $item) {
                    $this->createItem($item['pk_i_id'], 1, $date);
                }
            }

            $sEnd = '<p>Это автоматическое письмо, если Вы уже сделали это, пожалуйста, проигнорируйте это письмо.</p><p>Спасибо.</p>';
           
            $description[osc_language()]['s_title'] = '{WEB_TITLE} - Опция публикации вашего объявления: {ITEM_TITLE}';
            $description[osc_language()]['s_text'] = 'Мы только что опубликовали Ваше объявление ({ITEM_TITLE}) на {WEB_TITLE}. <p>Чтобы ваше объявление было доступно любому пользователю на {WEB_TITLE}, Вы должны завершить процесс и оплатить публикацию. Вы можете сделать это по следующей ссылке:  {EMAILPAYMENT_LINK}</p><p></p><p> Вы можете улучшить своё объявление, купив услугу Премиум и/или Выделение цветом, Поднятие в Топ на {WEB_TITLE}. Сделать это можно по следующей ссылке: {EMAILPAYMENT_LINK}</p>'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_offer_one', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = 'Мы только что опубликовали Ваше объявление ({ITEM_TITLE}) на {WEB_TITLE}.<p>Мы получили Ваш платёж.</p> <p>Вы можете улучшить своё объявление, купив услугу Премиум и/или Выделение цветом, Поднятие в Топ на {WEB_TITLE}.  Сделать это можно по следующей ссылке: {EMAILPAYMENT_LINK}</p>'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_offer_two_not_allow_after', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = 'Мы только что опубликовали Ваше объявление ({ITEM_TITLE}) на {WEB_TITLE}.<p>Вы можете улучшить своё объявление, купив услугу Премиум и/или Выделение цветом, Поднятие в Топ на {WEB_TITLE}.  Сделать это можно по следующей ссылке: {EMAILPAYMENT_LINK}</p>'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_offer_two', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = '<p>Мы получили Ваш платёж.</p>Вы можете улучшить своё объявление, купив услугу Премиум и/или Выделение цветом, Поднятие в Топ на {WEB_TITLE}. Сделать это можно по следующей ссылке:   {EMAILPAYMENT_LINK}'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_offer_three_not_allow_after', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = 'Вы можете улучшить своё объявление, купив услугу Премиум и/или Выделение цветом, Поднятие в Топ на {WEB_TITLE}.Сделать это можно по следующей ссылке:   {EMAILPAYMENT_LINK}'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_offer_three', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = 'Для Вашего объявления действует услуга Премиум и она будет ещё активна {DAYS_BEFOR_DEADLINE} дней.<p>Вы можете продлить услугу или купить другую услугу, чтобы улучшить Ваше объявление{WEB_TITLE}. Сделать это можно по следующей ссылке:   {EMAILPAYMENT_LINK}</p>'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_alert_Premium', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = 'Для Вашего объявления действует услуга Выделение цветом и она будет ещё активна {DAYS_BEFOR_DEADLINE} дней.<p>Вы можете продлить услугу или купить другую услугу, чтобы улучшить Ваше объявление{WEB_TITLE}. Сделать это можно по следующей ссылке:   {EMAILPAYMENT_LINK}</p>'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_alert_Colorized', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = 'Для Вашего объявления действует услуга Премиум с Выделением цветом и она будет ещё активна {DAYS_BEFOR_DEADLINE} дней.<p>Вы можете продлить услугу или купить другую услугу, чтобы улучшить Ваше объявление {WEB_TITLE}. Сделать это можно по следующей ссылке:   {EMAILPAYMENT_LINK}</p>'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_alert_Primium_and_Colorized', 'b_indelible' => '1'),
                $description
            );
			
			$description[osc_language()]['s_text'] = 'Срок публикации Вашего объявления заканчивается и оно будет ещё активно {DAYS_BEFOR_DEADLINE} дней.<p> Вы можете продлить срок публикации объявления на {WEB_TITLE}. Сделать это можно по следующей ссылке:   {EMAILPAYMENT_LINK}</p>'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_alert_renew', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = 'Администратор только что разместил Ваше объявление ({ITEM_TITLE}) на {WEB_TITLE}.'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_made_Published', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = 'Администратор применил услугу Премиум к объявлению ({ITEM_TITLE}) на {WEB_TITLE}.'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_made_Premium', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = 'Администратор применил услугу Премиум и Выделение цветом к объявлению ({ITEM_TITLE}) на {WEB_TITLE}.'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_made_Premium_Colorized', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = 'Администратор применил услугу Выделение цветом к объявлению({ITEM_TITLE}) на {WEB_TITLE}.'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_made_Colorized', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = 'Администратор применил услугу Поднятие в Топ ({ITEM_TITLE}) на {WEB_TITLE}.'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_moved_to_Top', 'b_indelible' => '1'),
                $description
            );
			
			$description[osc_language()]['s_text'] = 'Администратор продлил срок размещения объявления ({ITEM_TITLE}) на {WEB_TITLE}.'.$sEnd;
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_renew', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = '<p>Администратор пополнил Ваш кошелёк на сайте {WEB_TITLE}.</p>'.$sEnd; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_filled_up_Credit_Pack_1', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = '<p>Администратор пополнил Ваш кошелёк на сайте {WEB_TITLE}.</p>'.$sEnd; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_filled_up_Credit_Pack_2', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_text'] = '<p>Администратор пополнил Ваш кошелёк на сайте {WEB_TITLE}.</p>'.$sEnd; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_filled_up_Credit_Pack_3', 'b_indelible' => '1'),
                $description
            );
			$description[osc_language()]['s_title'] = '{WEB_TITLE} - Вы получили Бонус!';
            $description[osc_language()]['s_text'] = '<p>Привет, {USER_NAME}</p><p>Вы получили Бонус {BONUS_CREDIT} {CURRENCY} в кошелёк. <p>Войдите в свой личный кабинет и воспользуйтесь услугами на {WEB_TITLE}</p>';
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'rupayments_regbonus_email', 'b_indelible' => '1'),
                $description
                );
                
            /*
            ** UPD. 3.6.2 
            */
            // Banner Added
            $description[osc_language()]['s_title'] = '{WEB_TITLE} - Пользователь: {CONTACT_NAME} добавил баннер на сайт!';
            $description[osc_language()]['s_text'] = '<p><strong>{CONTACT_NAME}</strong> только что добавил баннер на сайт: <strong>{WEB_TITLE}</strong>.</p>'.$sEnd; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_banner_added', 'b_indelible' => '1'),
                $description
            );
            
            // Banner Accepted
            $description[osc_language()]['s_title'] = '{WEB_TITLE} - Баннер принят!';
            $description[osc_language()]['s_text'] = '<p>Привет, <strong>{CONTACT_NAME}</strong></p><p>Администратор одобрил Ваш баннер для размещения на сайте: <strong>{WEB_TITLE}</strong>.</p><p>Вы можете оплатить размещение баннера по этой ссылке: {BANNER_PAY_URL}</p>'.$sEnd; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_banner_accepted', 'b_indelible' => '1'),
                $description
            );
            
            // Banner No Funding
            $description[osc_language()]['s_title'] = '{WEB_TITLE} - Баннер больше не показывается!';
            $description[osc_language()]['s_text'] = '<p>Привет, <strong>{CONTACT_NAME}</strong></p><p>Ваши деньги на размещение баннера израсходованы.</p>'.$sEnd; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_banner_no_funding', 'b_indelible' => '1'),
                $description
            );
            
            // User eBuy Deal (purchase)
            $description[osc_language()]['s_title'] = '{WEB_TITLE} - Оплата Вашего товара!';
            $description[osc_language()]['s_text'] = '<p>Привет, <strong>{CONTACT_NAME}</strong></p><p>На сайте <strong>{WEB_TITLE}</strong>, была произведена оплата за Ваш товар.</p>'.$sEnd; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_user_ebuy_purchase', 'b_indelible' => '1'),
                $description
            );
            
            // Admin eBuy Deal (purchase)
            $description[osc_language()]['s_title'] = '{WEB_TITLE} - Совершена оплата за товар!';
            $description[osc_language()]['s_text'] = '<p>На Вашем сайте: <strong>{WEB_TITLE}</strong> была совершена оплата за товар.</p>'.$sEnd; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_ebuy_purchase', 'b_indelible' => '1'),
                $description
            );
            
            // Membership plan expires
            $description[osc_language()]['s_title'] = '{WEB_TITLE} - Истекает срок участия в группе!';
            $description[osc_language()]['s_text'] = '<p>Привет, <strong>{CONTACT_NAME}</strong></p><p>Истекает срок участия в группе и он будет ещё активен {DAYS_BEFOR_DEADLINE} дней.<p>Вы можете продлить срок участия в группе на <strong>{WEB_TITLE}</strong>. Сделать это можно по следующей ссылке:   {MEMBERSHIP_PAY_LINK}</p>'.$sEnd; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_membership_expired', 'b_indelible' => '1'),
                $description
            );
 
        }

        public function premiumOff($id) {
            $this->dao->delete($this->getTable_premium(), array('fk_i_item_id' => $id));
        }
		
		public function colorOff($id) {
            $this->dao->delete($this->getTable_colorized(), array('fk_i_item_id' => $id));
        }

        public function deleteItem($id) {
            $this->premiumOff($id);
			$this->colorOff($id);
            $this->dao->delete($this->getTable_publish(), array('fk_i_item_id' => $id));
			$this->dao->delete($this->getTable_is_publish_payment_needed(), array('fk_i_item_id' => $id));
            $this->dao->delete($this->getTable_image_show(), array('fk_i_item_id' => $id));
            $this->dao->delete($this->getTable_pack3in1(), array('fk_i_item_id' => $id));
            $this->dao->delete($this->getTable_ebuy(), array('i_item_id' => $id));
            $this->dao->delete($this->getTable_ebuy_deals(), array('i_item_id' => $id));
        }
		public function deleteUser($id) {
            $this->dao->delete($this->getTable_wallet(), array('fk_i_user_id' => $id));
            $this->dao->delete($this->getTable_user_memberships(), array('f_user_id' => $id));
        }

        /**
         * Remove data and tables related to the plugin.
         */
        public function uninstall()
        {
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_premium()) ) ;
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_publish()) ) ;
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_wallet()) ) ;
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_prices()) ) ;
	        $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_colorized()) ) ;
	        $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_log()) ) ;
	        $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_is_publish_payment_needed()) ) ;
	        $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_cron_email_filter()) ) ;
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_policy()) ) ;
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_skrill()) ) ;
			$this->dao->query(sprintf('DROP TABLE %s', $this->getTable_bitcoin()) ) ;
            
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_region_prices()));
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_packs()));
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_user_groups()));
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_user_memberships()));
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_banners()));
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_banner_settings()));
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_image_show()));
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_pack3in1()));
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_ebuy()));
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_ebuy_deals()));
            
                                                       
            Page::newInstance()->deleteByInternalName('email_rupayments_offer_one');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_offer_two_not_allow_after');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_offer_two');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_offer_three_not_allow_after');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_offer_three');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_alert_Premium');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_alert_Colorized');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_alert_Primium_and_Colorized');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_admin_made_Published');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_admin_made_Premium');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_admin_made_Premium_Colorized');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_admin_made_Colorized');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_admin_moved_to_Top');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_admin_filled_up_Credit_Pack_1');
                     
            Page::newInstance()->deleteByInternalName('email_rupayments_admin_filled_up_Credit_Pack_2');
        
            Page::newInstance()->deleteByInternalName('email_rupayments_admin_filled_up_Credit_Pack_3');
			
            Page::newInstance()->deleteByInternalName('rupayments_regbonus_email');
			
            Page::newInstance()->deleteByInternalName('email_rupayments_alert_renew');
			
            Page::newInstance()->deleteByInternalName('email_rupayments_admin_renew');
            
            Page::newInstance()->deleteByInternalName('email_rupayments_admin_banner_added');
            
            Page::newInstance()->deleteByInternalName('email_rupayments_banner_accepted');
            
            Page::newInstance()->deleteByInternalName('email_rupayments_banner_no_funding');
            
            Page::newInstance()->deleteByInternalName('email_rupayments_user_ebuy_purchase');
            
            Page::newInstance()->deleteByInternalName('email_rupayments_admin_ebuy_purchase');
            
            Page::newInstance()->deleteByInternalName('email_rupayments_membership_expired');

            Preference::newInstance()->delete(array('s_section' => 'rupayments'));
        }

        public function versionUpdate() {
            $version = osc_get_preference('version', 'rupayments');
            if ( $version < 320 ) {
				$this->dao->query(sprintf('ALTER TABLE %s CHANGE i_amount i_amount DECIMAL(32,8) NOT NULL DEFAULT 0.00000000', ModelRUpayments::newInstance()->getTable_log()));
				$this->dao->query(sprintf('ALTER TABLE %s CHANGE i_amount i_amount DECIMAL(32,8) NOT NULL DEFAULT 0.00000000', ModelRUpayments::newInstance()->getTable_wallet()));
				$this->import ( RUPAYMENTS_PATH.'struct2.sql' );
				$description[osc_language()]['s_title'] = '{WEB_TITLE} - You have received a bonus!';
                $description[osc_language()]['s_text'] = '<p>Hi, {USER_NAME}</p><p>You have received a bonus {BONUS_CREDIT} {CURRENCY} in your wallet. <p>Log in to your account and use one of the premium services on site {WEB_TITLE}</p>';
                $res = Page::newInstance()->insert(
                array('s_internal_name' => 'rupayments_regbonus_email', 'b_indelible' => '1'),
                $description
                );
				osc_set_preference('version', 320, 'rupayments', 'INTEGER');
                osc_reset_preferences();
            }
			 if ( $version < 340 ) {
				$this->dao->query(sprintf("CREATE TABLE %st_rupayments_colorized (fk_i_item_id INT UNSIGNED NOT NULL, dt_date DATETIME NOT NULL , PRIMARY KEY (fk_i_item_id), FOREIGN KEY (fk_i_item_id) REFERENCES %st_item (pk_i_id)) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';", DB_TABLE_PREFIX, DB_TABLE_PREFIX));
				$this->dao->query(sprintf("INSERT INTO %st_rupayments_colorized (fk_i_item_id, dt_date) SELECT pk_i_id, dt_p_colorized FROM %st_item ;", DB_TABLE_PREFIX, DB_TABLE_PREFIX));
                $this->dao->query(sprintf("ALTER TABLE %st_item DROP dt_p_colorized ;", DB_TABLE_PREFIX)) ;
				osc_set_preference('version', 340, 'rupayments', 'INTEGER');
                osc_reset_preferences();
            }

			 if ( $version < 361 ) {
				$this->dao->query(sprintf("ALTER TABLE %st_rupayments_prices ADD COLUMN f_renew_cost FLOAT NULL ;", DB_TABLE_PREFIX));
				osc_set_preference('allow_renew', '1', 'rupayments', 'BOOLEAN');
				osc_set_preference('default_renew_cost', '5', 'rupayments', 'STRING');
				osc_set_preference('version', 361, 'rupayments', 'INTEGER');
				osc_set_preference('allow_item_form', '1', 'rupayments', 'BOOLEAN');
				osc_delete_preference('paypal_api_username', 'rupayments');
                osc_delete_preference('paypal_api_password', 'rupayments');
                osc_delete_preference('paypal_api_signature', 'rupayments');
				$description[osc_language()]['s_title'] = '{WEB_TITLE} - Admin Renew yout item!';
				$description[osc_language()]['s_text'] = 'Администратор just Renew your item ({ITEM_TITLE}) on {WEB_TITLE}.';
                $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_renew', 'b_indelible' => '1'),
                $description
                 );
				 $description[osc_language()]['s_title'] = '{WEB_TITLE} - Your ad expires!';
				 $description[osc_language()]['s_text'] = 'Your ad expires и она будет ещё активна {DAYS_BEFOR_DEADLINE} days.<p>You may Renew your ad in {WEB_TITLE}. Сделать это можно по следующей ссылке:   {EMAILPAYMENT_LINK}</p>';
                  $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_alert_renew', 'b_indelible' => '1'),
                $description
                 );
                osc_reset_preferences();
            }
			if ( $version < 401 ) {
			$this->dao->query(sprintf("DROP TABLE %st_rupayments_policy ;", DB_TABLE_PREFIX)) ;
			$this->import ( RUPAYMENTS_PATH.'struct.sql' );
			$this->dao->query(sprintf("ALTER TABLE %st_rupayments_prices DROP f_premium_color_discount ;", DB_TABLE_PREFIX));
			$this->dao->query(sprintf("ALTER TABLE %st_rupayments_prices ADD COLUMN f_pack_cost FLOAT NULL ;", DB_TABLE_PREFIX));
			$this->dao->query(sprintf("ALTER TABLE %st_rupayments_prices ADD COLUMN f_picture_cost FLOAT NULL ;", DB_TABLE_PREFIX));
			$this->addban2();
			osc_set_preference('version', 401, 'rupayments', 'INTEGER');
            osc_set_preference('3_in_1_pack_days', '7', 'rupayments', 'INTEGER');
            osc_set_preference('3_in_1_pack_status', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('allow_ebuy', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('allow_periodbonus', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('default_3_in_1_pack_cost', '0', 'rupayments', 'STRING');
            osc_set_preference('default_pay_per_show_image_cost', '0', 'rupayments', 'STRING');
            osc_set_preference('pay_per_show_image_status', '0', 'rupayments', 'BOOLEAN');
            osc_set_preference('periodbonus_last_accrual', '0', 'rupayments', 'STRING');
            osc_set_preference('periodbonus_start_date', '0', 'rupayments', 'STRING');
            osc_set_preference('periodbonus_value', '0', 'rupayments', 'STRING');
            osc_set_preference('period_value', '7', 'rupayments', 'INTEGER');
			
			$description[osc_language()]['s_title'] = '{WEB_TITLE} - User: {CONTACT_NAME} added a banner on the site!';
            $description[osc_language()]['s_text'] = '<p><strong>{CONTACT_NAME}</strong> just added a banner on the site: <strong>{WEB_TITLE}</strong>.</p>'; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_banner_added', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_title'] = '{WEB_TITLE} - Banner accepted!';
            $description[osc_language()]['s_text'] = '<p>Hi, <strong>{CONTACT_NAME}</strong></p><p>The administrator has just accepted your banner on the site: <strong>{WEB_TITLE}</strong>.</p><p>You can pay for the publication of the banner by clicking on this link: {BANNER_PAY_URL}</p>'; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_banner_accepted', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_title'] = '{WEB_TITLE} - The banner is no longer displayed!';
            $description[osc_language()]['s_text'] = '<p>Hi, <strong>{CONTACT_NAME}</strong></p><p>There is not enough money to display your banner.</p>'; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_banner_no_funding', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_title'] = '{WEB_TITLE} - Successful purchase of your goods!';
            $description[osc_language()]['s_text'] = '<p>Hi, <strong>{CONTACT_NAME}</strong></p><p>On the <strong>{WEB_TITLE}</strong>, the user paid for your product.</p>'; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_user_ebuy_purchase', 'b_indelible' => '1'),
                $description
            );

            $description[osc_language()]['s_title'] = '{WEB_TITLE} - Purchase of goods is completed!';
            $description[osc_language()]['s_text'] = '<p>On your site: <strong>{WEB_TITLE}</strong> received payment for the goods.</p>'; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_admin_ebuy_purchase', 'b_indelible' => '1'),
                $description
            );
            
            $description[osc_language()]['s_title'] = '{WEB_TITLE} - Membership Plan expires!';
            $description[osc_language()]['s_text'] = '<p>Hi, <strong>{CONTACT_NAME}</strong></p><p>Your Membership Plan expires и она будет ещё активна {DAYS_BEFOR_DEADLINE} days.<p>You may extend the time of your Membership Plan in <strong>{WEB_TITLE}</strong>. Сделать это можно по следующей ссылке:   {MEMBERSHIP_PAY_LINK}</p>'; 
            $res = Page::newInstance()->insert(
                array('s_internal_name' => 'email_rupayments_membership_expired', 'b_indelible' => '1'),
                $description
            );
			osc_reset_preferences();
            }
			if ( $version < 430 ) {
				osc_set_preference('version', 430, 'rupayments', 'INTEGER');
                osc_reset_preferences();
            }
        }

        public function getPaymentByCode($code, $source) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_log());
            $this->dao->where('s_code', $code);
            $this->dao->where('s_source', $source);
            $result = $this->dao->get();
            if($result) {
                return $result->row();
            }
            return false;
        }

        public function getPayment($rupaymentsId) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_log());
            $this->dao->where('pk_i_id', $rupaymentsId);
            $result = $this->dao->get();
            if($result) {
                return $result->row();
            }
            return false;
        }

        public function getPublishData($itemId) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_publish());
            $this->dao->where('fk_i_item_id', $itemId);
            $result = $this->dao->get();
            if($result) {
                return $result->row();
            }
            return false;
        }
        
	public function get_class_color($itemId){

            $this->dao->select('*');
            $this->dao->from($this->getTable_colorized());
            $this->dao->where('fk_i_item_id', $itemId);
            $result = $this->dao->get();
            if($result) {
                $cat = $result->row();
                if(isset($cat['dt_date'])) {
                    return $cat["dt_date"];
                }
            }
         return false;
        }

        public function getPremiumData($itemId) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_premium());
            $this->dao->where('fk_i_item_id', $itemId);
            $result = $this->dao->get();
            if($result) {
                return $result->row();
            }
            return false;
        }
        
        public function getPublishPrice ( $categoryId, $item = false ) {
            $price = osc_get_preference('default_publish_cost', 'rupayments') - osc_get_preference('default_publish_cost', 'rupayments')  * $this->userDiscount / 100;
            
            $city = "";
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_prices());
            $this->dao->where('fk_i_category_id', $categoryId);
            $result = $this->dao->get();
            
            if($item && $item['fk_i_city_id']) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_region_prices());
                $this->dao->where('fk_s_region_id', $item['fk_i_city_id']);
                $this->dao->where('f_region_type', 'city');
                $result_city = $this->dao->get();
                
                if($result_city->numRows()) $city = $result_city->row();
            }
            
            if($result->numRows() || $city) {
                $cat = $result->row(); $cat_price = null; $city_price = null;
                
                if(isset($cat['f_publish_cost'])) $cat_price = $cat['f_publish_cost'];
                if(isset($city['f_publish_cost'])) $city_price = $city['f_publish_cost'];
                
                if($item) {
                    if(!is_null($cat_price) && $cat_price <= $city_price) $est_price = $cat_price;
                    elseif(is_null($city_price) || !$city_price) $est_price = $cat_price;
					 
						  
                    else $est_price = $city_price;
					 
                }
					  
                else $est_price = $cat_price;
                
                if($est_price) $price = $est_price - $est_price * $this->userDiscount / 100;
            }
            
            return $price;
        }

        public function getPremiumPrice ( $categoryId, $item = false ) {
            $price = osc_get_preference('default_premium_cost', 'rupayments') - osc_get_preference('default_premium_cost', 'rupayments')  * $this->userDiscount / 100;
            
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_prices());
            $this->dao->where('fk_i_category_id', $categoryId);
            $result = $this->dao->get();
            
            if($item) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_region_prices());
                $this->dao->where('fk_s_region_id', $item['fk_i_city_id']);
                $this->dao->where('f_region_type', 'city');
                $result_city = $this->dao->get();   
                
                if($result_city) $city = $result_city->row(); 
            }
            
            if($result || $result_city) {
                $cat = $result->row(); $cat_price = null; $city_price = null;
                
                if(isset($cat['f_premium_cost'])) $cat_price = $cat['f_premium_cost'];
                if(isset($city['f_premium_cost'])) $city_price = $city['f_premium_cost'];
                
                if($item) {
                    if(!is_null($cat_price) && $cat_price <= $city_price) $est_price = $cat_price;
                    elseif(is_null($city_price) || !$city_price) $est_price = $cat_price;
					 
						  
                    else $est_price = $city_price;
					 
                }
					  
                else $est_price = $cat_price;
				 
                
                if($est_price) $price = $est_price - $est_price * $this->userDiscount / 100;
            }

            return $price;
        }
		
		public function getRenewPrice ( $categoryId, $item = false ) {
		    $price = osc_get_preference('default_renew_cost', 'rupayments') - osc_get_preference('default_renew_cost', 'rupayments')  * $this->userDiscount / 100;
            
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_prices());
            $this->dao->where('fk_i_category_id', $categoryId);
            $result = $this->dao->get();
            
            if($item) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_region_prices());
                $this->dao->where('fk_s_region_id', $item['fk_i_city_id']);
                $this->dao->where('f_region_type', 'city');
                $result_city = $this->dao->get();
                
                if($result_city) $city = $result_city->row();
            }
            
            if($result || $result_city) {
                $cat = $result->row(); $cat_price = null; $city_price = null;
                
                if(isset($cat['f_renew_cost'])) $cat_price = $cat['f_renew_cost'];
                if(isset($city['f_renew_cost'])) $city_price = $city['f_renew_cost'];
                
                if($item) {
                    if(!is_null($cat_price) && $cat_price <= $city_price) $est_price = $cat_price;
                    elseif(is_null($city_price) || !$city_price) $est_price = $cat_price;
					 
						  
                    else $est_price = $city_price;
					 
                }
					  
                else $est_price = $cat_price;
                
                if($est_price) $price = $est_price - $est_price * $this->userDiscount / 100;
            }
            
            return $price;
        }

        public function getWallet($userId) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_wallet());
            $this->dao->where('fk_i_user_id', $userId);
            $result = $this->dao->get();
            if($result) {
                $row = $result->row();
                $row['formatted_amount'] = (isset($row['i_amount'])?$row['i_amount']:0);
                return $row;
            }
            return false;
        }
	
        public function getUser_rupayments($useremail) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_rupayments_user());
            $this->dao->where('s_email', $useremail);
            $result = $this->dao->get();
            if($result) {
                $cat = $result->row();
                if(isset($cat['pk_i_id'])) {
                    return $cat["pk_i_id"];
                }
            }
           return array();
        }
	
        public function getUseremail_rupayments($userid) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_rupayments_user());
            $this->dao->where('pk_i_id', $userid);
            $result = $this->dao->get();
            if($result) {
                $cat = $result->row();
                if(isset($cat['s_email'])) {
                    return $cat["s_email"];
                }
            }
           return array();
        }

        public function getCategoriesPrices() {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_prices());
            $result = $this->dao->get();
            if($result) {
                return $result->result();
            }
            return array();
        }

        public function getTopPrice ( $categoryId, $item = false ) {
            $price = osc_get_preference('default_top_cost', 'rupayments') - osc_get_preference('default_top_cost', 'rupayments')  * $this->userDiscount / 100;
            
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_prices());
            $this->dao->where('fk_i_category_id', $categoryId);
            $result = $this->dao->get();
            
            if($item) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_region_prices());
                $this->dao->where('fk_s_region_id', $item['fk_i_city_id']);
                $this->dao->where('f_region_type', 'city');
                $result_city = $this->dao->get(); 
                
                if($result_city) $city = $result_city->row();
            }
            
            if($result || $result_city) {
                $cat = $result->row(); $cat_price = null; $city_price = null;
                
                if(isset($cat['f_top_cost'])) $cat_price = $cat['f_top_cost'];
                if(isset($city['f_top_cost'])) $city_price = $city['f_top_cost'];
                
                if($item) {
                    if(!is_null($cat_price) && $cat_price <= $city_price) $est_price = $cat_price;
                    elseif(is_null($city_price) || !$city_price) $est_price = $cat_price;
					 
						  
                    else $est_price = $city_price;
					 
                }
					  
                else $est_price = $cat_price;
	
                
                if($est_price) $price = $est_price - $est_price * $this->userDiscount / 100;
            }
            
            return $price;
        }


        public function getColorPrice ( $categoryId, $item = false ) {
            $price = osc_get_preference('default_color_cost', 'rupayments') - osc_get_preference('default_color_cost', 'rupayments')  * $this->userDiscount / 100;
            
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_prices());
            $this->dao->where('fk_i_category_id', $categoryId);
            $result = $this->dao->get();
            
            if($item) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_region_prices());
                $this->dao->where('fk_s_region_id', $item['fk_i_city_id']);
                $this->dao->where('f_region_type', 'city');
                $result_city = $this->dao->get();   
                
                if($result_city) $city = $result_city->row(); 
            }
            
            if($result || $result_city) {
                $cat = $result->row(); $cat_price = null; $city_price = null;
                
                if(isset($cat['f_color_cost'])) $cat_price = $cat['f_color_cost'];
                if(isset($city['f_color_cost'])) $city_price = $city['f_color_cost'];
                
                if($item) {
                    if(!is_null($cat_price) && $cat_price <= $city_price) $est_price = $cat_price;
                    elseif(is_null($city_price) || !$city_price) $est_price = $cat_price;
					 
						  
                    else $est_price = $city_price;
					 
                }
					  
                else $est_price = $cat_price;
				 
                
                if($est_price) $price = $est_price - $est_price * $this->userDiscount / 100;
            }
            
            return $price;
        }
        
        public function getPack3in1Price( $categoryId, $item = false) {
            $price = osc_get_preference('default_3_in_1_pack_cost', 'rupayments') - osc_get_preference('default_3_in_1_pack_cost', 'rupayments')  * $this->userDiscount / 100;
            
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_prices());
            $this->dao->where('fk_i_category_id', $categoryId);
            $result = $this->dao->get();
            
            if($item) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_region_prices());
                $this->dao->where('fk_s_region_id', $item['fk_i_city_id']);
                $this->dao->where('f_region_type', 'city');
                $result_city = $this->dao->get();   
                
                if($result_city) $city = $result_city->row(); 
            }
            
            if($result || $result_city) {
                $cat = $result->row(); $cat_price = null; $city_price = null;
                
                if(isset($cat['f_pack_cost'])) $cat_price = $cat['f_pack_cost'];
                if(isset($city['f_pack_cost'])) $city_price = $city['f_pack_cost'];
                
                if($item) {
                    if(!is_null($cat_price) && $cat_price <= $city_price) $est_price = $cat_price;
                    elseif(is_null($city_price) || !$city_price) $est_price = $cat_price;
					 
						  
                    else $est_price = $city_price;
					 
                }
					  
                else $est_price = $cat_price;
				
                
                if($est_price) $price = $est_price - $est_price * $this->userDiscount / 100;
            }
            
            return $price;
        }
        
        public function getImageShowPrice( $categoryId, $item = false) {
            $price = osc_get_preference('default_pay_per_show_image_cost', 'rupayments') - osc_get_preference('default_pay_per_show_image_cost', 'rupayments')  * $this->userDiscount / 100;
            
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_prices());
            $this->dao->where('fk_i_category_id', $categoryId);
            $result = $this->dao->get();
            
            if($item) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_region_prices());
                $this->dao->where('fk_s_region_id', $item['fk_i_city_id']);
                $this->dao->where('f_region_type', 'city');
                $result_city = $this->dao->get();   
                
                if($result_city) $city = $result_city->row(); 
            }
            
            if($result || $result_city) {
                $cat = $result->row(); $cat_price = null; $city_price = null;
                
                if(isset($cat['f_picture_cost'])) $cat_price = $cat['f_picture_cost'];
                if(isset($city['f_picture_cost'])) $city_price = $city['f_picture_cost'];
                
                if($item) {
                     if(!is_null($cat_price) && $cat_price <= $city_price) $est_price = $cat_price;
                    elseif(is_null($city_price) || !$city_price) $est_price = $cat_price;
					 
						  
                    else $est_price = $city_price;
					 
                }
					  
                else $est_price = $cat_price;
                
                if($est_price) $price = $est_price - $est_price * $this->userDiscount / 100;
            }
            
            return $price;
        }

        public function getCategoriesPolicy() {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_policy());
            $result = $this->dao->get();
            if($result) {
                return $result->result();
            }
            return array();
        }

        public function getPremiumWithColorPrice ( $categoryId ) {
            // Дефолтные установки
            $f_premium_cost = osc_get_preference('default_premium_cost', 'rupayments'); 
            $f_color_cost = osc_get_preference('default_color_cost', 'rupayments');
            $f_premium_color_discount = osc_get_preference('discount_for_premium_and_color', 'rupayments');
            
            // Уточнение установок, если в БД есть соответствующие значения
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_prices());
            $this->dao->where('fk_i_category_id', $categoryId);
            $result = $this->dao->get();
            if ( $result ) {
                $cat = $result->row();
                if ( isset ( $cat['f_premium_cost'] ) ) $f_premium_color_cost = $cat["f_premium_cost"]; 
                if ( isset ( $cat['f_color_cost'] ) ) $f_color_cost = $cat["f_color_cost"];
                if ( isset ( $cat['f_premium_color_discount'] ) ) $f_premium_color_discount = $cat["f_premium_color_discount"]; 
            }
            return ( $f_premium_cost + $f_color_cost - $f_premium_color_discount );
        }

        public function getPremiumWithColorDiscount ( $categoryId ) {
            // Дефолтные установки           
            $f_premium_color_discount = osc_get_preference('discount_for_premium_and_color', 'rupayments');
            
            // Уточнение установки, если в БД есть соответствующие значения
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_prices());
            $this->dao->where('fk_i_category_id', $categoryId);
            $result = $this->dao->get();
            if ( $result ) {
                $cat = $result->row(); 
                if ( isset ( $cat['f_premium_color_discount'] ) ) $f_premium_color_discount = $cat["f_premium_color_discount"]; 
            }
            return $f_premium_color_discount;
        }

     
        public function getLogs() {

            $this->dao->select('*') ;
            $this->dao->from($this->getTable_log());
            $result = $this->dao->get();
            if($result) {
                return $result->result();
            }
            return array();
        }
        
        public function getPaginationLogs ( $iStart, $iLimit ) {

            $this->dao->select('*') ;
            $this->dao->from($this->getTable_log());
            $this->dao->orderBy ( 'pk_i_id', 'DESC' ); 
            $this->dao->limit ( $iStart, $iLimit );
            $result = $this->dao->get();
            if($result) {
               return $result->result();
            }
            return array();
        }
        
        public function getUserLogs ( $logged_user_id ) {

            $this->dao->select('*') ;
            $this->dao->from($this->getTable_log());
            $this->dao->where('fk_i_user_id', $logged_user_id);
            $result = $this->dao->get();
            if($result) {
                return $result->result();
            }
            return array();
        }
        
        public function getUserPaginationLogs ( $logged_user_id, $iStart, $iLimit ) {

            $this->dao->select('*') ;
            $this->dao->from($this->getTable_log());
            $this->dao->where('fk_i_user_id', $logged_user_id);
            $this->dao->orderBy ( 'pk_i_id', 'ASC' ); 
            $this->dao->limit ( $iStart, $iLimit );
            $result = $this->dao->get();
            if($result) {
                return $result->result();
            }
            return array();
        }
        
        public function publishFeeIsPaid($itemId) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_publish());
            $this->dao->where('fk_i_item_id', $itemId);
            $result = $this->dao->get();
            $row = $result->row();
            if($row) {
                if($row['b_paid']==1) {
                    return true;
                } else {
                    return false;
                }
            }
            return false;
        }

        public function premiumFeeIsPaid($itemId) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_premium());
            $this->dao->where('fk_i_item_id', $itemId);
            $this->dao->where(sprintf("TIMESTAMPDIFF(DAY,dt_date,'%s') < %d", date('Y-m-d H:i:s'), osc_get_preference("premium_days", "rupayments")));
            $result = $this->dao->get();
            $row = $result->row();
            if(isset($row['dt_date'])) {
                return true;
            }
            return false;
        }
              
        public function colorFeeIsPaid ( $itemId ) {
            $this->dao->select('*') ;
            $this->dao->from ( $this->getTable_colorized() );
            $this->dao->where('fk_i_item_id', $itemId);
            $this->dao->where(sprintf("TIMESTAMPDIFF(DAY,dt_date,'%s') < %d", date('Y-m-d H:i:s'), osc_get_preference("color_days", "rupayments")));
            $result = $this->dao->get();
            $row = $result->row();

            if(isset($row['dt_date'])) {
                return true;
            }
            return false;
        }
        
	public function premiumFeeMark($itemId) {
            $this->dao->select('*');
            $this->dao->from($this->getTable_item());
            $this->dao->where('pk_i_id', $itemId);                           
            $result = $this->dao->get();
            $row = $result->row();
            if ($row) {
                if ($row['b_premium'] == 1) {
                    return true;
                } else {
                    return false;
                }
            }
            return false;
        }


        public function purgeExpired() {
            // Очистка Премиум
            $this->dao->select("fk_i_item_id");
            $this->dao->from($this->getTable_premium());
            $this->dao->where(sprintf("TIMESTAMPDIFF(DAY,dt_date,'%s') >= %d", date('Y-m-d H:i:s'), osc_get_preference("premium_days", "rupayments")));
            $result = $this->dao->get();
            if($result) {
                $items = $result->result();
                $mItem = new ItemActions(false);
                foreach($items as $item) {
                    $mItem->premium($item['fk_i_item_id'], false);
                    $this->premiumOff($item['fk_i_item_id']);
                }
            }
            
            // Очистка Цвета
            $this->dao->select("fk_i_item_id");
            $this->dao->from($this->getTable_colorized());
            $this->dao->where ( sprintf ( "TIMESTAMPDIFF(DAY,dt_date,'%s') >= %d", date('Y-m-d H:i:s'), osc_get_preference ( "color_days", "rupayments" ) ) );
            $result = $this->dao->get();
            if($result) {
                $items = $result->result();     
                foreach($items as $item) {
	            $this->dao->update ( $this->getTable_colorized(), array ( 'dt_date'=>"0000-00-00 00:00:00" ), array ( 'fk_i_item_id' => $item['fk_i_item_id'] ) );
                }
            }
        }
		
		public function uncolor ( $itemId ) {
		// Очистка Цвета
$this->dao->update($this->getTable_colorized(),array('dt_date'=>date("0000-00-00 00:00:00")),array('fk_i_item_id' => $itemId));
			}
			
		public function unpremium($itemId) {
				   // Очистка Премиум
            $this->dao->select("fk_i_item_id");
            $this->dao->from($this->getTable_premium());
            $this->dao->where('fk_i_item_id', $itemId);
            $result = $this->dao->get();
            if($result) {
                $items = $result->result();
                $mItem = new ItemActions(false);
                foreach($items as $item) {
                    $mItem->premium($item['fk_i_item_id'], false);
                    $this->premiumOff($item['fk_i_item_id']);
        }
		}
		}

        public function cronPremiumExpired ( $iDays ) {
            
            osc_get_preference('color_days',  'rupayments');
            
            $aAlertPremium = array();
            
            if ( osc_get_preference('premium_days', 'rupayments') > $iDays ) {
            
                $iDelta = 2; // Пределельное отклонение от срока
                $aAlertPremium = array();
                $this->dao->select("fk_i_item_id");
                $this->dao->from($this->getTable_premium());
                $this->dao->where ( sprintf ( "TIMESTAMPDIFF(HOUR,dt_date,'%s') > %d", date('Y-m-d H:i:s'), (osc_get_preference('premium_days', 'rupayments')-$iDays)*24 ) );
                $result = $this->dao->get();
                if($result) {
                    $items = $result->result();     
                    foreach($items as $item) {
                        $aAlertPremium[] = $item['fk_i_item_id'];
                    }
                }
            }
            return $aAlertPremium;
        }

       public function cronColorExpired ( $iDays ) {
            
            $aAlertColor = array();
            
            if ( osc_get_preference('color_days',  'rupayments') > $iDays ) {
            
                $iDelta = 2; // Пределельное отклонение от срока
                $this->dao->select("fk_i_item_id");
                $this->dao->from($this->getTable_colorized());
                $this->dao->where ( sprintf ( "TIMESTAMPDIFF(HOUR,dt_date,'%s') > %d", date('Y-m-d H:i:s'), (osc_get_preference('color_days',  'rupayments')-$iDays)*24 ) );
                $result = $this->dao->get();
                if($result) {
                    $items = $result->result();     
                    foreach($items as $item) {
                        $aAlertColor[] = $item['fk_i_item_id'];
                    }
                }
            }
            return $aAlertColor;
        }
		
		public function cronRenewExpired ( $iDays ) {
            
            $aAlertRenew = array();
            
                $this->dao->select("pk_i_id");
                $this->dao->from($this->getTable_item());
                $this->dao->where (sprintf("TIMESTAMPDIFF(HOUR,'%s',dt_expiration) <= %d", date('Y-m-d H:i:s'), $iDays*24));
			    $this->dao->where (sprintf("TIMESTAMPDIFF(HOUR,'%s',dt_expiration) >= %d", date('Y-m-d H:i:s'), $iDays*24-1));
                $result = $this->dao->get();
                if($result) {
                    $items = $result->result();     
                    foreach($items as $item) {
                        $aAlertRenew [] = $item['pk_i_id'];
                    }
                }
            return $aAlertRenew;
        }

        public function createItem($itemId, $paid = 0, $date = NULL, $wo1 = NULL) {
            if($date==NULL) { $date = date("Y-m-d H:i:s"); };
            $this->dao->insert($this->getTable_publish(), array('fk_i_item_id' => $itemId, 'dt_date' => $date, 'b_paid' => $paid, 'fk_i_payment_id' => $wo1));
        }


        /**
         * Create a record on the DB for the paypal transaction
         *
         * @param string $concept
         * @param string $code
         * @param float $amount
         * @param string $currency
         * @param string $email
         * @param integer $user
         * @param integer $item
         * @param string $product_type (publish fee, premium, pack and which category)
         * @param string $source
         * @return integer $last_id
         */
        public function saveLog ( $concept, $code, $amount, $currency, $email, $user, $item, $product_type, $source ) {

            // Корректируем коды типа услуги (для полноты отчета в логе) на случай, 
            // если платить за публикацию надо
            if ( $this->getIsPublishPaymentNeeded ( $item ) ) {
                if ( $product_type == "201" ) $product_type = "202";
                if ( $product_type == "301" ) $product_type = "302";
                if ( $product_type == "701" ) $product_type = "702";
                if ( $product_type == "711" ) $product_type = "712";
                if ( $product_type == "721" ) $product_type = "722";
                if ( $product_type == "731" ) $product_type = "732";
                if ( $product_type == "231" ) $product_type = "232";
            }
            
            $this->dao->insert($this->getTable_log(), array(
                's_concept' => $concept,
                'dt_date' => date("Y-m-d H:i:s"),
                's_code' => $code,
                'i_amount' => $amount,
                's_currency_code' => $currency,
                's_email' => $email,
                'fk_i_user_id' => $user,
                'fk_i_item_id' => $item,
                'i_product_type' => $product_type,
                's_source' => $source
                ));
            
            // Уведомляем юзера о платеже электронкой 
            if (  stristr ( $source, 'PAYPAL' ) || stristr ( $source, 'Skrill' ) || stristr ( $source, 'Payulatam' )) {
                $this->lastId = $this->dao->insertedId();
                $this->paypalPaymentComplited ( $item,  $product_type );
            }
            
            return $this->dao->insertedId();
        }
        
        public function insertPrice ( $category, $premium_fee, $renew, $img_fee, $top_fee, $color_fee, $publish_fee, $pack_fee ) {
            $this->dao->replace($this->getTable_prices(), array (
                                              'fk_i_category_id' => $category,
                                              'f_top_cost' => $top_fee,
                                              'f_color_cost' => $color_fee,
                                              'f_premium_cost' => $premium_fee,
                                              'f_pack_cost' => $pack_fee,
                                              'f_renew_cost' => $renew,											  
					                          'f_publish_cost' => $publish_fee,
                                              'f_picture_cost' => $img_fee
            ));
        }        
         
        public function insertPolicy ($num_free_ads, $free_unlimited_status) {
            
            foreach ($num_free_ads as $cat_id => $items) {
                foreach($items as $user_group_id => $data) {
                    $this->dao->select('*') ;
                    $this->dao->from($this->getTable_policy());
                    $this->dao->where('i_category_id', $cat_id);
                    $this->dao->where('i_user_group_id', $user_group_id);
                    
                    $result = $this->dao->get();
                    
                    if($result->numRows()) {
                        $this->dao->update(
                                    $this->getTable_policy(),
                                    array('i_num_free_ads' => $num_free_ads[$cat_id][$user_group_id], 'i_free_unlimited_status' => $free_unlimited_status[$cat_id][$user_group_id]),
                                    array('i_category_id' => $cat_id, 'i_user_group_id' => $user_group_id) 
                        );
                    }
                    else {
                        $this->dao->insert(
                                    $this->getTable_policy(), 
                                    array(
                                        'i_category_id' => $cat_id,
                                        'i_user_group_id' => $user_group_id,
                                        'i_num_free_ads' => $num_free_ads[$cat_id][$user_group_id],
                                        'i_free_unlimited_status' => $free_unlimited_status[$cat_id][$user_group_id]
                                    )
                        );
                    }
                } 			
            }  
        }        
          
	public function setTopItem($itemId){

            $this->dao->update($this->getTable_item(),array('dt_pub_date'=>date("Y-m-d H:i:s")),array('pk_i_id' => $itemId));
        }


        public function setColor ( $itemId ){
            
            // Контроль актуальности дат в БД 
            $iMktimeNow = mktime ( date('H'), date('i'), date('s'), date('m'), date('d'), date('Y') );
            $iMktimeMinActual = $iMktimeNow - 3600*24*osc_get_preference ( 'color_days', 'rupayments' );
            
            // Is Color 
            $this->dao->select('UNIX_TIMESTAMP(dt_date)') ;
            $this->dao->from ( $this->getTable_colorized() );
            $this->dao->where('fk_i_item_id', $itemId);
            $result = $this->dao->get();
            $row = $result->row();

            if ( isset ( $row['UNIX_TIMESTAMP(dt_date)'] ) || $this->get_class_color($itemId) == "0000-00-00 00:00:00" ) {

                // Проверяем актуальность даты 
                if ( $iMktimeMinActual < $row['UNIX_TIMESTAMP(dt_date)'] ) {
                    $iMktime = $row['UNIX_TIMESTAMP(dt_date)'] + 3600*24*osc_get_preference ( 'color_days', 'rupayments' );       
                    $this->dao->update ( $this->getTable_colorized(), array ( 'dt_date' => date ( 'Y-m-d H:i:s', $iMktime ) ), array ( 'fk_i_item_id' => $itemId ) );
                }
                else $this->dao->update ( $this->getTable_colorized(), array ( 'dt_date' => date ( 'Y-m-d H:i:s' ) ), array ( 'fk_i_item_id' => $itemId ) );
            }
            else { 
                $this->dao->insert($this->getTable_colorized(), array ('dt_date'=>date ( "Y-m-d H:i:s" ) , 'fk_i_item_id' => $itemId ));
            }
            
        }
		
		public function setRenew ( $itemId ) {
			
        $item = Item::newInstance()->findByPrimaryKey($itemId);
        if(isset($item['fk_i_category_id'])) {
            $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']);
            if(isset($category['i_expiration_days'])) {
			$iMktimeNow = mktime ( date('H'), date('i'), date('s'), date('m'), date('d'), date('Y') );
			$this->dao->select('UNIX_TIMESTAMP(dt_expiration)') ;
            $this->dao->from ( $this->getTable_item() );
            $this->dao->where('pk_i_id', $itemId);
            $result = $this->dao->get();
            $row = $result->row();
                if($category['i_expiration_days']==0) {
                    Item::newInstance()->update(array('dt_expiration' => "9999-12-31 23:59:59"), array('pk_i_id' => $itemId ));
                } else if($iMktimeNow < $row['UNIX_TIMESTAMP(dt_expiration)']) {
					$iMktime = $row['UNIX_TIMESTAMP(dt_expiration)'] + 3600*24*$category['i_expiration_days'];
					$this->dao->update ( $this->getTable_item(), array ( 'dt_expiration' => date ( 'Y-m-d H:i:s', $iMktime ) ), array ( 'pk_i_id' => $itemId ) );
                } else {
					$iMktime = $iMktimeNow + 3600*24*$category['i_expiration_days'];
					$this->dao->update ( $this->getTable_item(), array ( 'dt_expiration' => date ( 'Y-m-d H:i:s', $iMktime  ) ), array ( 'pk_i_id' => $itemId ) );
				}
            }
            }
    } 

        public function payPublishFee($itemId, $paymentId) {
            $paid = $this->getPublishData($itemId);
            if(empty($paid)) {
                $this->createItem($itemId, 1, date("Y-m-d H:i:s"), $paymentId);
            } else {
                $this->dao->update($this->getTable_publish(), array('b_paid' => 1, 'dt_date' => date("Y-m-d H:i:s"), 'fk_i_payment_id' => $paymentId), array('fk_i_item_id' => $itemId));
            }
            $mItems = new ItemActions(false);
            $mItems->enable($itemId);
        }

        public function payPremiumFee($itemId, $paymentId/*, $pack3in1 = false*/) {
            
            // Контроль актуальности дат в БД 
            $iMktimeNow = mktime ( date('H'), date('i'), date('s'), date('m'), date('d'), date('Y') );
            
//            if($pack3in1) {
//                $iMktimeMinActual = $iMktimeNow - 3600*24*osc_get_preference ( '3_in_1_pack_days', 'rupayments' );
//            }
//            else {
                $iMktimeMinActual = $iMktimeNow - 3600*24*osc_get_preference ( 'premium_days', 'rupayments' );
//            }
            
            
            // Is Premium
            $this->dao->select('UNIX_TIMESTAMP(dt_date)') ;
            $this->dao->from($this->getTable_premium());
            $this->dao->where('fk_i_item_id', $itemId);
            $result = $this->dao->get();
            $row = $result->row();

            if ( isset ( $row['UNIX_TIMESTAMP(dt_date)'] ) ) {

                // Проверяем актуальность даты 
                if ( $iMktimeMinActual < $row['UNIX_TIMESTAMP(dt_date)'] ) { 
//                    if($pack3in1) {
//                        $iMktime = $row['UNIX_TIMESTAMP(dt_date)'] + 3600*24*osc_get_preference ( '3_in_1_pack_days', 'rupayments' ); 
//                    }
//                    else {
                        $iMktime = $row['UNIX_TIMESTAMP(dt_date)'] + 3600*24*osc_get_preference ( 'premium_days', 'rupayments' ); 
//                    }
                          
                    $this->dao->update($this->getTable_premium(), array ( 'dt_date' => date ( 'Y-m-d H:i:s', $iMktime ), 'fk_i_payment_id' => $paymentId ), array ( 'fk_i_item_id' => $itemId ) );
                }
                else $this->dao->update($this->getTable_premium(), array ( 'dt_date' => date ( 'Y-m-d H:i:s' ), 'fk_i_payment_id' => $paymentId ), array ( 'fk_i_item_id' => $itemId ) );
            } 
            else {
                $this->dao->insert($this->getTable_premium(), array('dt_date' => date("Y-m-d H:i:s"), 'fk_i_payment_id' => $paymentId, 'fk_i_item_id' => $itemId));
            }
            
            $mItem = new ItemActions(false);
            $mItem->premium($itemId, true);
        }

        public function payPremiumWithColorFee ( $itemId, $paymentId ) {

            // Is Published
            $paid = $this->getPublishData($itemId);
            if(empty($paid)) {
                $this->createItem($itemId, 1, date("Y-m-d H:i:s"), $paymentId);
            } else {
                $this->dao->update($this->getTable_publish(), array('b_paid' => 1, 'dt_date' => date("Y-m-d H:i:s"), 'fk_i_payment_id' => $paymentId), array('fk_i_item_id' => $itemId));
            }
            $mItems = new ItemActions(false);
            $mItems->enable($itemId);
            
            // Контроль актуальности дат в БД 
            $iMktimeNow = mktime ( date('H'), date('i'), date('s'), date('m'), date('d'), date('Y') );
            $iMktimeMinActual = $iMktimeNow - 3600*24*osc_get_preference ( 'color_days', 'rupayments' );
            
          // Is Color 
            $this->dao->select('UNIX_TIMESTAMP(dt_date)') ;
            $this->dao->from ( $this->getTable_colorized() );
            $this->dao->where('fk_i_item_id', $itemId);  
            $result = $this->dao->get();
            $row = $result->row();

            if ( isset ( $row['UNIX_TIMESTAMP(dt_date)'] ) || $this->get_class_color($itemId) == "0000-00-00 00:00:00") {

                // Проверяем актуальность даты 
                if ( $iMktimeMinActual < $row['UNIX_TIMESTAMP(dt_date)'] ) {
                    $iMktime = $row['UNIX_TIMESTAMP(dt_date)'] + 3600*24*osc_get_preference ( 'color_days', 'rupayments' );       
                    $this->dao->update ( $this->getTable_colorized(), array ( 'dt_date' => date ( 'Y-m-d H:i:s', $iMktime ) ), array ( 'fk_i_item_id' => $itemId ) );
                }
                else $this->dao->update ( $this->getTable_colorized(), array ( 'dt_date' => date ( 'Y-m-d H:i:s' ) ), array ( 'fk_i_item_id' => $itemId ) );
            }
            else { 
                $this->dao->insert($this->getTable_colorized(), array ('dt_date'=>date ( "Y-m-d H:i:s" ) , 'fk_i_item_id' => $itemId ));
            }
            
            // Контроль актуальности дат в БД 
            $iMktimeMinActual = $iMktimeNow - 3600*24*osc_get_preference ( 'premium_days', 'rupayments' );
            
            // Is Premium
            $this->dao->select('UNIX_TIMESTAMP(dt_date)') ;
            $this->dao->from($this->getTable_premium());
            $this->dao->where('fk_i_item_id', $itemId);
            $result = $this->dao->get();
            $row = $result->row();

            if ( isset ( $row['UNIX_TIMESTAMP(dt_date)'] ) ) {

                // Проверяем актуальность даты 
                if ( $iMktimeMinActual < $row['UNIX_TIMESTAMP(dt_date)'] ) { 
                    $iMktime = $row['UNIX_TIMESTAMP(dt_date)'] + 3600*24*osc_get_preference ( 'premium_days', 'rupayments' );       
                    $this->dao->update($this->getTable_premium(), array ( 'dt_date' => date ( 'Y-m-d H:i:s', $iMktime ), 'fk_i_payment_id' => $paymentId ), array ( 'fk_i_item_id' => $itemId ) );
                }
                else $this->dao->update($this->getTable_premium(), array ( 'dt_date' => date ( 'Y-m-d H:i:s' ), 'fk_i_payment_id' => $paymentId ), array ( 'fk_i_item_id' => $itemId ) );
            } 
            else {
                $this->dao->insert($this->getTable_premium(), array('dt_date' => date("Y-m-d H:i:s"), 'fk_i_payment_id' => $paymentId, 'fk_i_item_id' => $itemId));
            }
            
            $mItem = new ItemActions(false);
            $mItem->premium($itemId, true);
        }

        public function addWallet($user, $amount) {
            //$amount = (int)($amount);
            //$amount = round($amount,10);
            $wallet = $this->getWallet($user);
            if(isset($wallet['i_amount'])) {
                $this->dao->update($this->getTable_wallet(), array('i_amount' => bcadd($amount,$wallet['i_amount'],8)), array('fk_i_user_id' => $user));
            } else {
                $this->dao->insert($this->getTable_wallet(), array('fk_i_user_id' => $user, 'i_amount' => $amount));
            }
            return true;
        }
		
		public function addWalletReg($user, $regbonus) {
		rupayments_regbonus_email($user, $regbonus);
	    $this->dao->insert($this->getTable_wallet(), array('fk_i_user_id' => $user, 'i_amount' => $regbonus));
	    	 
        }

        /**
        * Учитываем скидку при оплате сразу подсветки и премиум размещения
        * 
        */
        public function calculatePrice ( $iProductType, $iCategoryId, $item) {
            
            // Плата за публикацию установлена
            if ( $this->isPublishPaymentNeeded ( $item ) ) {
                
                if ( $iProductType == '101' ) { 
                    return $this->getPublishPrice ( $iCategoryId, $item );
                }
                else if ( $iProductType == '401' ) {
                    return $this->getTopPrice ( $iCategoryId, $item );
                }
				else if ( $iProductType == '411' ) {
                    return $this->getRenewPrice ( $iCategoryId, $item );
                }
                else if ( $iProductType == '201' ) { 
                    return ( $this->getPublishPrice ( $iCategoryId, $item ) + $this->getPremiumPrice ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '231' ) { 
                    return ( $this->getPublishPrice ( $iCategoryId, $item ) + $this->getPremiumPrice ( $iCategoryId, $item ) + $this->getColorPrice ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '301' ) { 
                    return ( $this->getPublishPrice ( $iCategoryId, $item ) + $this->getColorPrice ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '701' ) { 
                    return ( $this->getPublishPrice ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '711' ) { 
                    return ( $this->getPublishPrice ( $iCategoryId, $item ) + $this->getPremiumPrice ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '721' ) { 
                    return ( $this->getPublishPrice ( $iCategoryId, $item ) + $this->getColorPrice ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '731' ) { 
                    return ( $this->getPublishPrice ( $iCategoryId, $item ) + $this->getPremiumPrice ( $iCategoryId, $item ) + $this->getColorPrice ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '801' ) { 
                    return ( $this->getPublishPrice ( $iCategoryId, $item ) + $this->getPack3in1Price ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '811' ) { 
                    return ( $this->getPublishPrice ( $iCategoryId, $item ) + $this->getPack3in1Price ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item ) );
                }
            }
            // Плата за публикацию не установлена 
            else {
                
                if ( $iProductType == '101' ) { 
                    return 0;
                }
                else if ( $iProductType == '401' ) {
                    return $this->getTopPrice ( $iCategoryId, $item );
                }
				else if ( $iProductType == '411' ) {
                    return $this->getRenewPrice ( $iCategoryId, $item );
                }
                else if ( $iProductType == '201' ) { 
                    return $this->getPremiumPrice ( $iCategoryId, $item );
                }
                else if ( $iProductType == '231' ) { 
                    return ( $this->getPremiumPrice ( $iCategoryId, $item ) + $this->getColorPrice ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '301' ) { 
                    return $this->getColorPrice ( $iCategoryId, $item );
                }
                else if ( $iProductType == '701' ) { 
                    return ( $this->getImageShowPrice ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '711' ) { 
                    return ( $this->getPremiumPrice ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '721' ) { 
                    return ( $this->getColorPrice ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '731' ) { 
                    return ( $this->getPremiumPrice ( $iCategoryId, $item ) + $this->getColorPrice ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item ) );
                }
                else if ( $iProductType == '801' ) { 
                    return ( $this->getPack3in1Price ( $iCategoryId, $item ) );
                }
                 else if ( $iProductType == '811' ) { 
                    return ( $this->getPack3in1Price ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item ) );
                }
            } 
        }

        /**
        * Унифицируем лэйблы пунктов выбора цвет - премиум - ( цвет + премиум - дискаункт )
        * 
        */
        public function printPriceStr ( $item, $iProductType ) {
                                  
            $iCategoryId = $item['fk_i_category_id'];
            $iPublishPrice = $this->getPublishPrice ( $iCategoryId, $item ); 
			$category = Category::newInstance()->findByPrimaryKey($iCategoryId);
            // Нужно ли платить за публикацию ( category_fee )?
            
            // Плата установлена
            if ( $this->isPublishPaymentNeeded ( $item ) ) {  
                if ( $iProductType == '101' ) {
                    $sPriceStr = $iPublishPrice." ".osc_get_preference('currency', 'rupayments');
                    print $sPriceStr;
                }
                else if ( $iProductType == '201' ) {  
                    $iPrice = $iPublishPrice + $this->getPremiumPrice ( $iCategoryId, $item );
                    $sPriceStr = $iPublishPrice." + ".$this->getPremiumPrice ( $iCategoryId, $item )." = ".$iPrice;
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments"));
                }
                else if ( $iProductType == '301' ) {
                    $iPrice = $iPublishPrice + $this->getColorPrice ( $iCategoryId, $item );
                    $sPriceStr = $iPublishPrice." + ".$this->getColorPrice ( $iCategoryId, $item )." = ".$iPrice;
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("color_days", "rupayments"));
                }
                else if ( $iProductType == '701' ) {
                    $iPrice = $iPublishPrice + $this->getImageShowPrice ( $iCategoryId, $item );
                    $sPriceStr = $iPublishPrice." + ".$this->getImageShowPrice ( $iCategoryId, $item )." = ".$iPrice;
                    print $sPriceStr.osc_get_preference('currency', 'rupayments');
                }
                else if ( $iProductType == '711' ) {
                    $iPrice = $iPublishPrice + $this->getPremiumPrice ( $iCategoryId, $item ) +  $this->getImageShowPrice ( $iCategoryId, $item );
                    $sPriceStr = $iPublishPrice." + ". $this->getPremiumPrice ( $iCategoryId, $item ) ." + ".$this->getImageShowPrice ( $iCategoryId, $item )." = ".$iPrice;
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments"));
                }
                else if ( $iProductType == '721' ) {
                    $iPrice = $iPublishPrice + $this->getColorPrice ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item );
                    $sPriceStr = $iPublishPrice." + ". $this->getColorPrice ( $iCategoryId, $item ) . " + ".$this->getImageShowPrice ( $iCategoryId, $item )." = ".$iPrice;
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("color_days", "rupayments"));
                }
                else if ( $iProductType == '731' ) {
                    $iPrice = $iPublishPrice + $this->getPremiumPrice ( $iCategoryId, $item ) + $this->getColorPrice ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item );
                    $sPriceStr = $iPublishPrice." + ".$this->getPremiumPrice ( $iCategoryId, $item )." + ".$this->getColorPrice ( $iCategoryId, $item )." + ".$this->getImageShowPrice ( $iCategoryId, $item )." = ".$iPrice;
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments"));
                }
                else if ( $iProductType == '801' ) {
                    $iPrice = $iPublishPrice + $this->getPack3in1Price ( $iCategoryId, $item );
                    $sPriceStr = $iPublishPrice." + ".$this->getPack3in1Price ( $iCategoryId, $item )." = ".$iPrice;
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("3_in_1_pack_days", "rupayments"));
                }
                else if ( $iProductType == '811' ) {
                    $iPrice = $iPublishPrice + $this->getPack3in1Price ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item );
                    $sPriceStr = $iPublishPrice." + ".$this->getImageShowPrice ( $iCategoryId, $item )." + ".$this->getPack3in1Price ( $iCategoryId, $item )." = ".$iPrice;
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("3_in_1_pack_days", "rupayments"));
                }
                else if ( $iProductType == '231' ) { 
                        $iPrice = $iPublishPrice + $this->getColorPrice ( $iCategoryId, $item ) + $this->getPremiumPrice ( $iCategoryId, $item );
                        $sPriceStr = $iPublishPrice." + ".$this->getColorPrice ( $iCategoryId, $item )." + ".$this->getPremiumPrice ( $iCategoryId, $item )." = ".$iPrice;
                        
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments"));   
                }
                else if ( $iProductType == '401' ) { 
                    $sPriceStr = $this->getTopPrice ( $iCategoryId, $item )." ".osc_get_preference('currency', 'rupayments');
                    print $sPriceStr;
                }
				else if ( $iProductType == '411' ) { 
                    $sPriceStr = $this->getRenewPrice ( $iCategoryId, $item );
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), $category['i_expiration_days'] );
                }

            }
            // За публикацию платить не надо
            else {                               
                if ( $iProductType == '101' ) {
                    $sPriceStr = "0".osc_get_preference('currency', 'rupayments');
                    print $sPriceStr;
                }
                else if ( $iProductType == '201' ) {                               
                    $sPriceStr = $this->getPremiumPrice ( $iCategoryId, $item );
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments") );
                }
                else if ( $iProductType == '301' ) {                             
                    $sPriceStr = $this->getColorPrice ( $iCategoryId, $item );
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("color_days", "rupayments") );
                }
                else if ( $iProductType == '701' ) {
                    $sPriceStr = $this->getImageShowPrice ( $iCategoryId, $item );
                    print $sPriceStr.osc_get_preference('currency', 'rupayments');
                }
                else if ( $iProductType == '711' ) {
                    $iPrice = $this->getPremiumPrice ( $iCategoryId, $item ) +  $this->getImageShowPrice ( $iCategoryId, $item );
                    $sPriceStr = $this->getPremiumPrice ( $iCategoryId, $item ) ." + ".$this->getImageShowPrice ( $iCategoryId, $item )." = ".$iPrice;
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments"));
                }
                else if ( $iProductType == '721' ) {
                    $iPrice = $this->getColorPrice ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item );
                    $sPriceStr = $this->getColorPrice ( $iCategoryId, $item ) . " + ".$this->getImageShowPrice ( $iCategoryId, $item )." = ".$iPrice;
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("color_days", "rupayments"));
                }
                else if ( $iProductType == '731' ) {
                    $iPrice = $this->getPremiumPrice ( $iCategoryId, $item ) + $this->getColorPrice ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item );
                    $sPriceStr = $this->getPremiumPrice ( $iCategoryId, $item )." + ".$this->getColorPrice ( $iCategoryId, $item )." + ".$this->getImageShowPrice ( $iCategoryId, $item )." = ".$iPrice;
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments"));
                }
                else if ( $iProductType == '801' ) {
                    $sPriceStr = $this->getPack3in1Price ( $iCategoryId, $item );
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("3_in_1_pack_days", "rupayments"));
                }
                else if ( $iProductType == '811' ) {
                    $iPrice = $this->getPack3in1Price ( $iCategoryId, $item ) + $this->getImageShowPrice ( $iCategoryId, $item );
                    $sPriceStr = $this->getImageShowPrice ( $iCategoryId, $item )." + ".$this->getPack3in1Price ( $iCategoryId, $item )." = ".$iPrice;
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("3_in_1_pack_days", "rupayments"));
                }
                else if ( $iProductType == '231' ) {
                    $iPrice = $this->getColorPrice ( $iCategoryId, $item ) + $this->getPremiumPrice ( $iCategoryId, $item );
                    $sPriceStr = $this->getColorPrice ( $iCategoryId, $item )." + ".$this->getPremiumPrice ( $iCategoryId, $item )." = ".$iPrice;
                    
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments") );   
                }
                else if ( $iProductType == '401' ) { 
                    $sPriceStr = $this->getTopPrice ( $iCategoryId, $item )." ".osc_get_preference('currency', 'rupayments');
                    print $sPriceStr;
                }
				else if ( $iProductType == '411' ) { 
                    $sPriceStr = $this->getRenewPrice ( $iCategoryId, $item );
                    print $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), $category['i_expiration_days'] );
                }

            }
        }
         
        public function printPriceLable ( $item, $iProductType ) {
            
            $iCategoryId = $item['fk_i_category_id'];
            
            // Нужно ли платить за публикацию ( category_fee )?
            
            // Плата установлена
            if ( $this->isPublishPaymentNeeded ( $item ) && osc_get_preference('pay_per_post', 'rupayments') ) {  
                if ( $iProductType == '101' ) {
                    _e('Publish item', 'rupayments');
                }
                else if ( $iProductType == '201' ) {  
                    _e('Publish and Mark as Premium', 'rupayments'); 
                }
                else if ( $iProductType == '301' ) {
                    _e('Publish and Highlight', 'rupayments'); 
                }
                else if ( $iProductType == '701' ) {
                    _e('Publish and activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '711' ) {
                    _e('Publish, Mark as Premium and activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '721' ) {
                    _e('Publish, Highlight item and activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '731' ) {
                    _e('Publish, Mark as Premium, Highlight item and activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '801' ) {
                    _e('Publish and apply: Pack 3-in-1', 'rupayments'); 
                }
                else if ( $iProductType == '811' ) {
                    _e('Publish, activate Show Image and apply: Pack 3-in-1', 'rupayments'); 
                }
                else if ( $iProductType == '231' ) { 
                    _e('Publish and Highlight and mark as Premium', 'rupayments');
                }
                else if ( $iProductType == '401' ) { 
                    _e('Move to Top', 'rupayments');
                }
				else if ( $iProductType == '411' ) { 
                    _e('Renew item', 'rupayments');
                }

            }
            // За публикацию платить не надо
            else {                               
                if ( $iProductType == '101' ) {
                    _e('Ad is published', 'rupayments');
                }
                else if ( $iProductType == '201' ) {                               
                    _e('Mark as Premium', 'rupayments');
                }
                else if ( $iProductType == '301' ) {                             
                    _e('Highlight', 'rupayments');
                }
                else if ( $iProductType == '701' ) {
                    _e('Activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '711' ) {
                    _e('Mark as Premium and Activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '721' ) {
                    _e('Highlight item and Activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '731' ) {
                    _e('Mark as Premium, Highlight item and activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '801' ) {
                    _e('Apply: Pack 3-in-1', 'rupayments'); 
                }
                else if ( $iProductType == '811' ) {
                    _e('Activate Show Image and apply: Pack 3-in-1', 'rupayments'); 
                }
                else if ( $iProductType == '231' ) {
                    _e('Highlight and mark as Premium', 'rupayments');
                }
                else if ( $iProductType == '401' ) { 
                    _e('Move to Top', 'rupayments');
                }
				else if ( $iProductType == '411' ) { 
                    _e('Renew item', 'rupayments');
                }

            }
        }
         
        public function isPublishPaymentNeeded ( $item ) {
            
            // Нужно ли платить за публикацию ( category_fee )?
            $iCategoryId = $item['fk_i_category_id'];
            $iPublishPrice = $this->getPublishPrice ( $iCategoryId, $item );
			$sEmail = $item['s_contact_email'];
			$iPolitic = $this->policyExecution ( $iCategoryId , $sEmail );
            
            $bIsNeedToPay = false;                                        
            if ( osc_get_preference ( 'pay_per_post', 'rupayments' ) == '1' && $iPublishPrice && !$this->publishFeeIsPaid ( $item['pk_i_id'] ) && !$iPolitic ) {
                $bIsNeedToPay = true; // 
                // сохраняем результат TRUE до следующего определения цены
                $this->rememberIsPublishPaymentNeeded ( $item['pk_i_id'] , TRUE);
            }
            if ( !$iPublishPrice ) { 
                $bIsNeedToPay = false;
                // сохраняем результат FALSE до следующего определения цены
                $this->rememberIsPublishPaymentNeeded ( $item['pk_i_id'] , FALSE );
            }
            
            return $bIsNeedToPay;
        }
         
        public function rememberIsPublishPaymentNeeded ( $itemId, $bVar ) {
            
            $this->dao->replace($this->getTable_is_publish_payment_needed(), array (
                                              'fk_i_item_id' => $itemId,
                                              'b_is_needed' => $bVar
            ));
        }
          
        public function getIsPublishPaymentNeeded ($itemId) {
            if ( $itemId ) {
                $this->dao->select('*');
                $this->dao->from($this->getTable_is_publish_payment_needed());
                $this->dao->where('fk_i_item_id', $itemId);                           
                $result = $this->dao->get();
                if ($result) {
		    $row = @$result->row();
                    if ( @$row['b_is_needed'] == TRUE ) {
                        return true;
                    } else {
                       return false;
                    }
                }
                return false;
            }
            else return false;
        }
          
        public function paypalPaymentComplited ( $itemId ,  $sProductType ) {
            
              // Уведомляем юзера о событии
              $item = Item::newInstance()->findByPrimaryKey ( $itemId ); 
              rupayments_send_email ( $item, osc_user(), 'offer', $sProductType );
        
        }
         
        public function setCronEmailFilter ( $itemId, $bVar ) {
 
            $this->dao->replace($this->getTable_cron_email_filter (), array (
                                              'fk_i_item_id' => $itemId,
                                              'dt_date' => date('Y-m-d H:i:s'),
                                              'b_is_sent' => $bVar
            ));
        }
         
        public function getCronEmailFilter ( $itemId, $product_type ) {

            $iDelta  = osc_get_preference("days_before_deadline_for_sending_email", "rupayments")*24;
            
                
            $sDatePremium = sprintf ( "TIMESTAMPDIFF(HOUR,dt_date,'%s')", date('Y-m-d H:i:s') );
            $sDateColor = sprintf("TIMESTAMPDIFF(HOUR,dt_date,'%s')", date('Y-m-d H:i:s'));
			$sDateRenew = sprintf("TIMESTAMPDIFF(HOUR,'%s',dt_expiration)", date('Y-m-d H:i:s'));
            if (  $product_type == "201") {
                // Премиум
                $this->dao->select( $sDatePremium );
                $this->dao->from($this->getTable_premium());
                $this->dao->where( 'fk_i_item_id', $itemId );
                $result = $this->dao->get();
                $row = $result->row();
                if($row) {
                    $aValues = array_values ( $row );
                    $iDelta = $aValues[0];
                }
            }
            
              if (  $product_type == "301") {
                // Цвета
                $this->dao->select( $sDateColor );
                $this->dao->from($this->getTable_colorized());
                $this->dao->where('fk_i_item_id', $itemId);
                $result = $this->dao->get();
                $row = $result->row();
                if($row) {
                    $aValues = array_values ( $row );
                    $iDelta = $aValues[0];
                }
            }
			
			if (  $product_type == "411") {
                $this->dao->select( $sDateRenew );
                $this->dao->from($this->getTable_item());
                $this->dao->where('pk_i_id', $itemId);
				$this->dao->where('dt_expiration' < '9999-12-31 23:59:59', $itemId);
				$this->dao->where('dt_expiration' > date('Y-m-d H:i:s'), $itemId);
                $result = $this->dao->get();
                $row = $result->row();
                if($row) {
                    $aValues = array_values ( $row );
                    $iDelta = $aValues[0];
                }
            }
          
            $this->dao->select('*');
            $this->dao->from($this->getTable_cron_email_filter ());
            $this->dao->where( sprintf("fk_i_item_id='%d' AND b_is_sent='%d' AND TIMESTAMPDIFF(HOUR,dt_date,'%s') < %d ", $itemId, 1, date('Y-m-d H:i:s'), $iDelta ) );                          
            $result = $this->dao->get();
            $row = $result->row();
            if ($row) {
                if ( $row['b_is_sent'] == 1 ) {
                    return true;
                } else {
                    return false;
                }
            }
            return false;
        } 
         
        public function printDaysStr ( $item, $product_type ) {
 
            $iDelta  = 0;
            $iDeltaPremium = 0;
            $iDeltaColor = 0;
			$iDeltaRenew = 0;
            
            $sDatePack3in1 = sprintf ( "TIMESTAMPDIFF(MINUTE,dt_date_expires,'%s')", date ( 'Y-m-d H:i:s') );     
            $sDatePremium = sprintf ( "TIMESTAMPDIFF(MINUTE,dt_date,'%s')", date ( 'Y-m-d H:i:s' ) ); 
            $sDateColor = sprintf ( "TIMESTAMPDIFF(MINUTE,dt_date,'%s')", date ( 'Y-m-d H:i:s') );
            $sDateRenew = sprintf ( "TIMESTAMPDIFF(MINUTE,'%s',dt_expiration)", date ( 'Y-m-d H:i:s') );
            $category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']); 			
            
            if (  $product_type == "201") {
                // Премиум
                $this->dao->select($sDatePremium);
                $this->dao->from($this->getTable_premium());
                $this->dao->where( 'fk_i_item_id', $item['pk_i_id'] );
                $result = $this->dao->get();
                $row = $result->row();
                if($row) {
                    $aValues = array_values ( $row );
                    $iDelta = $iPremiumAllMinutes = osc_get_preference('premium_days', 'rupayments')*24*60 - $aValues[0];
                    $this->iPremiumDays = floor($iPremiumAllMinutes/(24*60));
                    $this->iPremiumHours = floor(($iPremiumAllMinutes - $this->iPremiumDays*24*60)/60);
                    $this->iPremiumMinutes = $iPremiumAllMinutes - $this->iPremiumHours*60 - $this->iPremiumDays*24*60;
                    
                }
            }

            if (  $product_type == "301") {
                // Цвета
                $this->dao->select($sDateColor);
                $this->dao->from($this->getTable_colorized());
                $this->dao->where( 'fk_i_item_id', $item['pk_i_id'] );
                $result = $this->dao->get();
                $row = $result->row();

                if($row) {
                    $aValues = array_values ( $row );
                    $iDelta = $iColorAllMinutes = osc_get_preference('color_days', 'rupayments')*24*60 - $aValues[0];
                    $this->iColorDays = floor($iColorAllMinutes/(24*60));
                    $this->iColorHours = floor(($iColorAllMinutes - $this->iColorDays*24*60)/60);
                    $this->iColorMinutes = $iColorAllMinutes - $this->iColorHours*60 - $this->iColorDays*24*60;
                    
                }
            }
			
			if (  $product_type == "411") {
                // Цвета
                $this->dao->select($sDateRenew);
                $this->dao->from($this->getTable_item());
                $this->dao->where( 'pk_i_id', $item['pk_i_id'] );
                $result = $this->dao->get();
                $row = $result->row();

                if($row) {
                    $aValues = array_values ( $row );
                    $iDelta = $iRenewAllMinutes = $aValues[0];
                    $this->iRenewDays = floor($iRenewAllMinutes/(24*60));
                    $this->iRenewHours = floor(($iRenewAllMinutes - $this->iRenewDays*24*60)/60);
                    $this->iRenewMinutes = $iRenewAllMinutes - $this->iRenewHours*60 - $this->iRenewDays*24*60;
                    
                }
            }
            if (  $product_type == "801") {
                // Pack 3-in-1
                $this->dao->select($sDatePack3in1);
                $this->dao->from($this->getTable_pack3in1());
                $this->dao->where( 'fk_i_item_id', $item['pk_i_id'] );
                $result = $this->dao->get();
                $row = $result->row();
                if($row) {
                    $aValues = array_values ( $row );
                    $iDelta = $iPack3in1AllMinutes = osc_get_preference('3_in_1_pack_days', 'rupayments')*24*60 - $aValues[0] - osc_get_preference('3_in_1_pack_days', 'rupayments')*24*60;
                    $this->iPack3in1Days = floor($iPack3in1AllMinutes/(24*60));
                    $this->iPack3in1Hours = floor(($iPack3in1AllMinutes - $this->iPack3in1Days*24*60)/60);
                    $this->iPack3in1Minutes = $iPack3in1AllMinutes - $this->iPack3in1Hours*60 - $this->iPack3in1Days*24*60;
                    
                }
            }
            
            if ( $iDelta ) return $iDelta;
        }
        
        public function isPublishingAllAddsForFree ( $categoryId ) {
        
            if ( $categoryId ) {
                if ( osc_get_preference('pay_per_post', 'rupayments') == 1 && osc_get_preference('default_publish_cost', 'rupayments') > 0 ) {
                    return false; 
                }
            
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_prices());
                $this->dao->where ( 'fk_i_category_id', $categoryId );
                $result = $this->dao->get();
                if ( $result ) {
                    $cat = $result->row();
                    if ( isset ( $cat['f_publish_cost'] ) ) {
                        if ( $cat['f_publish_cost'] > 0 ) return false; 
                    }
                }
           
                return true;
            }
            else return false; 
        }
 
        public function policyExecution ( $categoryId, $sEmail ) {
            
            if ( $this->isPublishingAllAddsForFree ( $categoryId ) ) {
                
                return true;
            }
            else {
                $this->howManyAddsPossible ( $categoryId );
                // Допускается любое количество б/п объявлений
                if ( $this->i_add_type == 1 ) { 
                    return true;
                }
                else if ( $this->i_add_type == 2 ) {
                    
                    // Количество б/п объявлений = 0
                    if (  !$this->i_num_wof_adds ) return false;
                    // Количество б/п объявлений > 0
                    if (  $this->i_num_wof_adds >= $this->howManyAddsExist ( $categoryId, $sEmail ) ) return true;
                    else return false;
                }
                else return false;
            } 
        }
 
        public function howManyAddsPossible ( $categoryId ) {
            
            $this->i_add_type = 0;
            $this->i_num_wof_adds = 0;
            
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_policy());
            $this->dao->where ( 'i_category_id', $categoryId );
            $this->dao->where ( 'i_user_group_id', $this->userGroupId );
            $result = $this->dao->get();
            
            if($result->numRows()) {
                
                $cat = $result->result(); //row();
                
                if($cat[0]['i_free_unlimited_status']) {
                    $this->i_add_type = 1;
                }
                else {
                    $this->i_add_type = 2;
                    $this->i_num_wof_adds = $cat[0]['i_num_free_ads'];
                }
            }
        }
      
        public function howManyAddsExist ( $categoryId, $sEmail ) {
            
            $this->dao->select('`pk_i_id`'); 
            $this->dao->from($this->getTable_item());
            $this->dao->where ( 's_contact_email', $sEmail );
            $this->dao->where ( 'fk_i_category_id', $categoryId );
            $result = $this->dao->get();
            
            if($result) {
                
                return count ( $result->result() );
            }
            else return 0;
        }
        
        public function saveTransactionId ( $transaction_id, $sItemEmail, $fAmount, $sProductType, $iItemId ) {
            
            $this->dao->insert($this->getTable_skrill(), array(
                'dt_date' => date("Y-m-d H:i:s"),
                'f_amount' => $fAmount,
                's_currency_code' => osc_get_preference('currency', 'rupayments'),
                's_email' => $sItemEmail,
                's_transaction_id' => $transaction_id,
                'fk_i_item_id' => $iItemId,
                'i_product_type' => $sProductType
                ));
        }
 
        public function getTransaction ( $transaction_id ) {
            
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_skrill());
            $this->dao->where ( 's_transaction_id', $transaction_id );
            $result = $this->dao->get();
                 
            if ( $result ) {
                $cat = $result->row();
                if ( count ( $cat ) > 5 ) { // isset ( $cat['f_amount'] )
                   return $cat; 
                }
                else return false;  
            }
            else return false; 
        }
 
        public function cleanTransactions () {
            
            $this->dao->delete ( $this->getTable_skrill(), sprintf ( "TIMESTAMPDIFF ( MINUTE, dt_date, '%s' ) > %d", date ( 'Y-m-d H:i:s' ), 7200 ) );

        }
 
        public function isTransactionMade ( $sTransactionId ) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_log());
            $this->dao->where('s_code', $sTransactionId);
            $result = $this->dao->get();
            if($result) {
                return $result->row();
            }
            return false;    
        }
		
  // FOR FORM
  
         public function policyExecutionform ( $categoryId, $sEmail ) {
            
            if ( $this->isPublishingAllAddsForFree ( $categoryId ) ) {
                
                return true;
            }
            else {
                $this->howManyAddsPossible ( $categoryId );
                // Допускается любое количество б/п объявлений
                if ( $this->i_add_type == 1 ) { 
                    return true;
                }
                else if ( $this->i_add_type == 2 ) {
                    
                    // Количество б/п объявлений = 0
                    if (  !$this->i_num_wof_adds ) return false;
                    // Количество б/п объявлений > 0
                    if (  $this->i_num_wof_adds > $this->howManyAddsExist ( $categoryId, $sEmail ) ) return true;
                    else return false;
                }
                else return false;
            } 
        }
		
		public function printPriceLableform ( $categoryId, $iProductType, $sEmail, $item = false ) {
            
            
            // Плата установлена
            if ( $this->isPublishPaymentNeededform ( $categoryId, $sEmail, $item ) ) {  
                if ( $iProductType == '101' ) {
                    return __('Publish item', 'rupayments');
                }
                else if ( $iProductType == '201' ) {  
                    return __('Publish and Mark as Premium', 'rupayments'); 
                }
                else if ( $iProductType == '301' ) {
                    return __('Publish and Highlight item', 'rupayments'); 
                }
                else if ( $iProductType == '701' ) {
                    return __('Publish and activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '711' ) {
                    return __('Publish, Mark as Premium and activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '721' ) {
                    return __('Publish, Highlight item and activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '731' ) {
                    return __('Publish, Mark as Premium, Highlight item and activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '801' ) {
                    return __('Publish and apply: Pack 3-in-1', 'rupayments'); 
                }
                else if ( $iProductType == '811' ) {
                    return __('Publish, activate Show Image and apply: Pack 3-in-1', 'rupayments'); 
                }
                else if ( $iProductType == '231' ) { 
                    return __('Publish and Highlight and mark as Premium', 'rupayments');
                }
                else if ( $iProductType == '401' ) { 
                    return __('Move to Top', 'rupayments');
                }

            }
            // За публикацию платить не надо
            else {                               
                if ( $iProductType == '201' ) {                               
                    return __('Mark as Premium', 'rupayments');
                }
                else if ( $iProductType == '301' ) {                             
                    return __('Highlight item', 'rupayments');
                }
                else if ( $iProductType == '701' ) {
                    return __('Activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '711' ) {
                    return __('Mark as Premium and Activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '721' ) {
                    return __('Highlight item and Activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '731' ) {
                    return __('Mark as Premium, Highlight item and activate Show Image', 'rupayments'); 
                }
                else if ( $iProductType == '801' ) {
                    return __('Apply: Pack 3-in-1', 'rupayments'); 
                }
                else if ( $iProductType == '811' ) {
                    return __('Activate Show Image and apply: Pack 3-in-1', 'rupayments'); 
                }
                else if ( $iProductType == '231' ) { 
                    return __('Highlight and mark as Premium', 'rupayments');
                }
                else if ( $iProductType == '401' ) { 
                    return __('Move to Top', 'rupayments');
                }

            }
        }
		
		public function isPublishPaymentNeededform ( $categoryId, $sEmail = null, $item = false ) {

            $iPublishPrice = $this->getPublishPrice ( $categoryId, $item );
			$iPolitic = $this->policyExecutionform ( $categoryId , $sEmail, $this->userGroupId ); 
            
            $bIsNeedToPay = false;                                        
            if ( osc_get_preference ( 'pay_per_post', 'rupayments' ) == '1' && $iPublishPrice  && !$iPolitic ) {
                $bIsNeedToPay = true; // 

            }
            
            if ( !$iPublishPrice ) { 
                $bIsNeedToPay = false;

            }
            
            return $bIsNeedToPay;
        }
		
		public function isPublishPaymentNeedednext ( $item ) {
            
            $iCategoryId = $item['fk_i_category_id'];
            $iPublishPrice = $this->getPublishPrice ( $iCategoryId, $item );
			$sEmail = $item['s_contact_email'];
			$iPolitic = $this->policyExecution ( $iCategoryId , $sEmail );
                                     
            if ( osc_get_preference ( 'pay_per_post', 'rupayments' ) == '1' && $iPublishPrice && !$this->publishFeeIsPaid ( $item['pk_i_id'] ) && !$iPolitic ) {
                // сохраняем результат TRUE до следующего определения цены
                $this->rememberIsPublishPaymentNeeded ( $item['pk_i_id'] , TRUE);
            }
            if ( !$iPublishPrice ) { 
                // сохраняем результат FALSE до следующего определения цены
                $this->rememberIsPublishPaymentNeeded ( $item['pk_i_id'] , FALSE );
            }
            
        }
		
		      public function printPriceStrform ( $categoryId, $iProductType, $sEmail, $item = false ) {
                                  
                    $iPublishPrice = $this->getPublishPrice ( $categoryId, $item ); 
                    // Нужно ли платить за публикацию ( category_fee )?
                    
                    // Плата установлена
                    if ( $this->isPublishPaymentNeededform ( $categoryId, $sEmail, $item ) ) {  
                        if ( $iProductType == '101' ) {
                            $sPriceStr = $iPublishPrice." ".osc_get_preference('currency', 'rupayments');
                            return $sPriceStr;
                        }
                        else if ( $iProductType == '201' ) {  
                            $iPrice = $iPublishPrice + $this->getPremiumPrice ( $categoryId, $item );
                            $sPriceStr = $iPublishPrice." + ".$this->getPremiumPrice ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments"));
                        }
                        else if ( $iProductType == '301' ) {
                            $iPrice = $iPublishPrice + $this->getColorPrice ( $categoryId, $item );
                            $sPriceStr = $iPublishPrice." + ".$this->getColorPrice ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("color_days", "rupayments"));
                        }
                        else if ( $iProductType == '701' ) {
                            $iPrice = $iPublishPrice + $this->getImageShowPrice ( $categoryId, $item );
                            $sPriceStr = $iPublishPrice." + ".$this->getImageShowPrice ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments');
                        }
                        else if ( $iProductType == '711' ) {
                            $iPrice = $iPublishPrice + $this->getPremiumPrice ( $categoryId, $item ) +  $this->getImageShowPrice ( $categoryId, $item );
                            $sPriceStr = $iPublishPrice." + ". $this->getPremiumPrice ( $categoryId, $item ) ." + ".$this->getImageShowPrice ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments"));
                        }
                        else if ( $iProductType == '721' ) {
                            $iPrice = $iPublishPrice + $this->getColorPrice ( $categoryId ) + $this->getImageShowPrice ( $categoryId, $item );
                            $sPriceStr = $iPublishPrice." + ". $this->getColorPrice ( $categoryId ) . " + ".$this->getImageShowPrice ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("color_days", "rupayments"));
                        }
                        else if ( $iProductType == '731' ) {
                            $iPrice = $iPublishPrice + $this->getPremiumPrice ( $categoryId, $item ) + $this->getColorPrice ( $categoryId, $item ) + $this->getImageShowPrice ( $categoryId, $item );
                            $sPriceStr = $iPublishPrice." + ".$this->getPremiumPrice ( $categoryId, $item )." + ".$this->getColorPrice ( $categoryId, $item )." + ".$this->getImageShowPrice ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments"));
                        }
                        else if ( $iProductType == '801' ) {
                            $iPrice = $iPublishPrice + $this->getPack3in1Price ( $categoryId, $item );
                            $sPriceStr = $iPublishPrice." + ".$this->getPack3in1Price ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("3_in_1_pack_days", "rupayments"));
                        }
                        else if ( $iProductType == '811' ) {
                            $iPrice = $iPublishPrice + $this->getPack3in1Price ( $categoryId, $item ) + $this->getImageShowPrice ( $categoryId, $item );
                            $sPriceStr = $iPublishPrice." + ".$this->getImageShowPrice ( $categoryId, $item )." + ".$this->getPack3in1Price ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("3_in_1_pack_days", "rupayments"));
                        }
                        else if ( $iProductType == '231' ) { 
                            $iPrice = $iPublishPrice + $this->getColorPrice ( $categoryId, $item ) + $this->getPremiumPrice ( $categoryId, $item );
                            $sPriceStr = $iPublishPrice." + ".$this->getColorPrice ( $categoryId, $item )." + ".$this->getPremiumPrice ( $categoryId, $item )." = ".$iPrice;
                            
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments"));   
                        }
                        else if ( $iProductType == '401' ) { 
                            $sPriceStr = $this->getTopPrice ( $categoryId, $item )." ".osc_get_preference('currency', 'rupayments');
                            return $sPriceStr;
                        }
        
                    }
                    // За публикацию платить не надо
                    else {                               
                   if ( $iProductType == '201' ) {                               
                            $sPriceStr = $this->getPremiumPrice ( $categoryId, $item );
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments") );
                        }
                        else if ( $iProductType == '301' ) {                             
                            $sPriceStr = $this->getColorPrice ( $categoryId, $item );
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("color_days", "rupayments") );
                        }
                        else if ( $iProductType == '701' ) {
                            $sPriceStr = $this->getImageShowPrice ( $categoryId, $item );
                            return $sPriceStr.osc_get_preference('currency', 'rupayments');
                        }
                        else if ( $iProductType == '711' ) {
                            $iPrice = $this->getPremiumPrice ( $categoryId, $item ) +  $this->getImageShowPrice ( $categoryId, $item );
                            $sPriceStr = $this->getPremiumPrice ( $categoryId, $item ) ." + ".$this->getImageShowPrice ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments"));
                        }
                        else if ( $iProductType == '721' ) {
                            $iPrice = $this->getColorPrice ( $categoryId, $item ) + $this->getImageShowPrice ( $categoryId, $item );
                            $sPriceStr = $this->getColorPrice ( $categoryId, $item ) . " + ".$this->getImageShowPrice ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("color_days", "rupayments"));
                        }
                        else if ( $iProductType == '731' ) {
                            $iPrice = $this->getPremiumPrice ( $categoryId, $item ) + $this->getColorPrice ( $categoryId, $item ) + $this->getImageShowPrice ( $categoryId, $item );
                            $sPriceStr = $this->getPremiumPrice ( $categoryId, $item )." + ".$this->getColorPrice ( $categoryId, $item )." + ".$this->getImageShowPrice ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments"));
                        }
                        else if ( $iProductType == '801' ) {
                            $sPriceStr = $this->getPack3in1Price ( $categoryId, $item );
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("3_in_1_pack_days", "rupayments"));
                        }
                        else if ( $iProductType == '811' ) {
                            $iPrice = $this->getPack3in1Price ( $categoryId, $item ) + $this->getImageShowPrice ( $categoryId, $item );
                            $sPriceStr = $this->getImageShowPrice ( $categoryId, $item )." + ".$this->getPack3in1Price ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("3_in_1_pack_days", "rupayments"));
                        }
                        else if ( $iProductType == '231' ) {  
                            $iPrice = $this->getColorPrice ( $categoryId, $item ) + $this->getPremiumPrice ( $categoryId, $item );
                            $sPriceStr = $this->getColorPrice ( $categoryId, $item )." + ".$this->getPremiumPrice ( $categoryId, $item )." = ".$iPrice;
                            return $sPriceStr.osc_get_preference('currency', 'rupayments').", ".sprintf(__('duration %d days', 'rupayments'), osc_get_preference("premium_days", "rupayments") );   
                        }
                        else if ( $iProductType == '401' ) { 
                            $sPriceStr = $this->getTopPrice ( $categoryId, $item )." ".osc_get_preference('currency', 'rupayments');
                            return $sPriceStr;
                        }
        
                    }
            }
        
        /*
        ** UPD. v. 3.6.2
        */
        public function setImageShow ($itemId, $status = false){
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_image_show());
            $this->dao->where('fk_i_item_id', $itemId);
            
            $result = $this->dao->get();
            
            if($result->numRows() && $status == 1) {
                $imgShow = $result->result();
                
                if(!$imgShow[0]['f_status']) $this->dao->update($this->getTable_image_show(), array ( 'f_status' => 1, 'dt_date' => date('Y-m-d H:i:s')), array('fk_i_item_id' => $itemId));
            
            }
            else {
                $this->dao->insert($this->getTable_image_show(), array('f_status' => $status, 'dt_date'=> date("Y-m-d H:i:s"), 'fk_i_item_id' => $itemId));
            }
        }
        
        public function checkShowImage($itemId = false) {
            if(!osc_get_preference('pay_per_show_image_status', 'rupayments')) return TRUE;
            
            $this->dao->select('f_status');
            $this->dao->from($this->getTable_image_show());
            $this->dao->where('fk_i_item_id', (int)$itemId);
            $result = $this->dao->get();
            
            if($result->numRows() == 1) {
                $imgShow = $result->result();
            
                if($imgShow[0]['f_status']) return TRUE; 
                
                return FALSE;
            }
            
            return TRUE;
        }
        
        public function checkPack3in1($itemId) {
            $this->dao->select('*');
            $this->dao->from($this->getTable_pack3in1());
            $this->dao->where('fk_i_item_id', $itemId);
            $result = $this->dao->get();
            
            if($result->numRows() == 1) {
                $packExpire = $result->result();
                
                $date_expired = new DateTime($packExpire[0]['dt_date_expires']);
                $cur_date = new DateTime(date('Y-m-d H:i:s', time()));
                $interval = $date_expired->diff($cur_date);
                $interval->format('%a');
                
                if($interval->format('%a') <= 0) {
                    $this->dao->delete($this->getTable_pack3in1(), array('fk_i_item_id' => $itemId));
                    
                    return FALSE;
                }
                
                return 'active';
            }
            
            return FALSE;
        }
        
        public function getPack3in1($itemId) {
            $this->dao->select('*');
            $this->dao->from($this->getTable_pack3in1());
            $this->dao->where('fk_i_item_id', $itemId);
            $result = $this->dao->get();
            
            if($result->numRows() == 1) {
                $result = $result->result();
                
                return $result[0];
            }
            
            return FALSE;
        }
        
        public function setPack3in1($itemId, $payment_id) {
            $this->payPremiumFee($itemId, $payment_id);
            $this->setColor($itemId);
            
            if($this->checkPack3in1($itemId)) {
                $getPack = $this->getPack3in1($itemId);
                
                if($this->checkPack3in1($itemId) == 'active') $cur_date = $getPack['dt_date_expires'];
                    else $cur_date = date('Y-m-d H:i:s', time());
                    
                $date = new DateTime($cur_date);
                $date->add(new DateInterval('P' . osc_get_preference ( '3_in_1_pack_days', 'rupayments' ) . 'D'));
                $date_expired = $date->format('Y-m-d H:i:s');
                
                $this->dao->update($this->getTable_pack3in1(), array ( 'd_date_top' => date('Y-m-d', time()), 'dt_date_expires' => $date_expired ), array('fk_i_item_id' => $itemId));
            }
            else {
                $date = new DateTime(date('Y-m-d H:i:s', time()));
                $date->add(new DateInterval('P' . osc_get_preference ( '3_in_1_pack_days', 'rupayments' ) . 'D'));
                $date_expired = $date->format('Y-m-d H:i:s');
                
                $this->dao->insert($this->getTable_pack3in1(), array('fk_i_item_id' => $itemId, 'd_date_top' => date('Y-m-d', time()), 'dt_date_expires' => $date_expired, 'fk_i_payment_id' => $payment_id));
            }
        }
        
        public function setCronPack3in1Top() {
            if(osc_get_preference('3_in_1_pack_status', 'rupayments')) {
                $this->dao->select('*');
                $this->dao->from($this->getTable_pack3in1());
                
                $result = $this->dao->get();
                
                if($result->numRows() >= 1) {
                    $result = $result->result();
                    
                    foreach($result as $item) {
                        if($this->checkPack3in1($item['fk_i_item_id']) == 'active') {
                            $lastTopDate = new DateTime($item['d_date_top']);
                            $cur_date = new DateTime(date('Y-m-d', time()));
                            $interval = $lastTopDate->diff($cur_date);
                            
                            if($interval->format('%a') > 0) {
                                $this->setTopItem($item['fk_i_item_id']);
                                $this->dao->update($this->getTable_pack3in1(), array ( 'd_date_top' => date('Y-m-d', time()) ), array('fk_i_item_id' => $item['fk_i_item_id']));
                            }
                        }
                    }
                }
            }
  
            return FALSE;
        }
        
        public function getRegionPrices($id, $type) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_region_prices());
            $this->dao->where('fk_s_region_id', $id);
            $this->dao->where('f_region_type', $type);
            
            $result = $this->dao->get();
            
            if($result->numRows()) {
                $result = $result->result();
                return $result[0];
            }
            
            return FALSE;
        }
        
        public function setRegionPrices($pub, $renew, $img, $premium, $top, $color, $pack) {
            foreach($pub as $type => $arr) {
                foreach($arr as $id => $cost) {
                    $this->dao->replace($this->getTable_region_prices(), 
                                        array (
                                            'fk_s_region_id' => $id,
                                            'f_region_type' => $type,
                                            'f_top_cost' => $top[$type][$id],
                                            'f_color_cost' => $color[$type][$id],
                                            'f_premium_cost' => $premium[$type][$id],
                                            'f_pack_cost' => $pack[$type][$id],											  
                                            'f_publish_cost' => $pub[$type][$id],
                                            'f_renew_cost' => $renew[$type][$id],
                                            'f_picture_cost' => $img[$type][$id]
                                        )
                    );
                }
            }
        }
        
        public function getRegions() {
            $countries = Country::newInstance()->listAll();
    
            if($countries) {
                foreach($countries as $i => $country) {
                    $countries[$i]['prices'] = $this->getRegionPrices(strtolower($country['pk_c_code']), 'country');
                    
                    $regions = Region::newInstance()->getByCountry($country['pk_c_code']);
                    
                    if($regions) {
                        $countries[$i]['regions'] = $regions;
                    
                        foreach($regions as $k => $region) {
                            $countries[$i]['regions'][$k]['prices'] = $this->getRegionPrices($region['pk_i_id'], 'region');
                            
                            $cities = City::newInstance()->getByRegion($region['pk_i_id']);
                            $countries[$i]['regions'][$k]['cities'] = $cities;
                            
                            if($cities) {
                                foreach($cities as $j => $city) {
                                    $countries[$i]['regions'][$k]['cities'][$j]['prices'] = $this->getRegionPrices($city['pk_i_id'], 'city');
                                }
                            }
                        }
                    }
                }
            }
            
            return $countries;
        }
        
        public function getPack($pack_id) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_packs());
            $this->dao->where('fk_i_pack_id', $pack_id);
            
            $result = $this->dao->get();
            
            if($result) {
                $result = $result->result();
                return $result[0];
            }
            
            return FALSE;
        }
        
        public function getPacks() {
            $this->dao->select();
            $this->dao->from($this->getTable_packs());
            
            $result = $this->dao->get();
            
            if($result) return $result->result();
            
            return FALSE;
        }
        
        public function setPacks() {
            $countPacks = count(Params::getParam('pack_name'));
            $id = Params::getParam('pack_id');
            $title = Params::getParam('pack_name');
            $description = Params::getParam('pack_desc');
            $color = Params::getParam('pack_color');
            $amount = Params::getParam('pack_amount');
            $bonus = Params::getParam('pack_bonus');
            
            for($i = 0; $i < $countPacks; $i++) {          
                if(!$id[$i]) 
                    $result = $this->dao->insert(
                                    $this->getTable_packs(), 
                                    array(
                                        'f_pack_title' => $title[$i],
                                        'f_pack_description' => $description[$i],
                                        'f_pack_color' => $color[$i],
                                        'f_pack_amount' => $amount[$i],
                                        'f_pack_bonus' => $bonus[$i]
                                    )
                                );
                else
                    $result = $this->dao->update(
                            $this->getTable_packs(),
                            array('f_pack_title' => $title[$i], 'f_pack_description' => $description[$i], 'f_pack_color' => $color[$i], 'f_pack_amount' => $amount[$i], 'f_pack_bonus' => $bonus[$i]),
                            array('fk_i_pack_id' => $id[$i]) 
                        );   
            }
            
            return $result;
        }
        
        public function deletePack($id) {
            $result = $this->dao->delete($this->getTable_packs(), array('fk_i_pack_id' => $id));
            
            return $result;
        }
        
        public function getUserGroup($group_id) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_user_groups());
            $this->dao->where('fk_i_group_id', $group_id);
            
            $result = $this->dao->get();
            
            if($result) {
                $result = $result->result();
                return $result[0];
            }
            
            return FALSE;
        }
        
        public function getUserGroups() { 
            $this->dao->select();
            $this->dao->from($this->getTable_user_groups());
            
            $result = $this->dao->get();
            
            if($result) return $result->result();
            
            return FALSE;
        }
        
        public function setUserGroups() {
            $countGroups = count(Params::getParam('group_name'));
            $id = Params::getParam('group_id');
            $title = Params::getParam('group_name');
            $description = Params::getParam('group_desc');
            $color = Params::getParam('group_color');
            $fee = Params::getParam('group_fee');
            $discount = Params::getParam('group_discount');
            $period = Params::getParam('group_period');
            
            for($i = 0; $i < $countGroups; $i++) {          
                if(!$id[$i]) 
                    $result = $this->dao->insert(
                                    $this->getTable_user_groups(), 
                                    array(
                                        'f_group_title' => $title[$i],
                                        'f_group_description' => $description[$i],
                                        'f_group_color' => $color[$i],
                                        'f_group_price' => $fee[$i],
                                        'f_group_discount' => $discount[$i],
                                        'f_group_period' => $period[$i]
                                    )
                                );
                else
                    $result = $this->dao->update(
                            $this->getTable_user_groups(),
                            array('f_group_title' => $title[$i], 'f_group_description' => $description[$i], 'f_group_color' => $color[$i], 'f_group_price' => $fee[$i], 'f_group_discount' => $discount[$i], 'f_group_period' => $period[$i]),
                            array('fk_i_group_id' => $id[$i]) 
                        );   
            }
            
            return $result;
        }
        
        public function deleteUserGroup($id) {
            $result = $this->dao->delete($this->getTable_user_groups(), array('fk_i_group_id' => $id));
            
            return $result;
        }
        
        public function cronMembershipExpired($iDays){          
            $aAlertMembership = array();
            
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_user_memberships());
            $this->dao->where('f_date_expired > NOW()');
            
            $result = $this->dao->get();
            
            if($result->numRows()) {
                $result = $result->result();
                $cur_date = new DateTime(date('Y-m-d H:i:s', time()));
                
                foreach($result as $item) {
                    $date_expired = new DateTime($item['f_date_expired']);
                    $interval = $date_expired->diff($cur_date);
                    
                    if($interval->format('%a') <= $iDays) {
                        $aAlertMembership[] = $item;
                    }
                }
                
                return $aAlertMembership;
            }
            
            return FALSE;
        }
        
        public function getUserMembership($user_id) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_user_memberships());
            $this->dao->where('f_user_id', $user_id);
            $this->dao->where('f_date_expired > NOW()');
            
            $result = $this->dao->get();
            
            if($result->numRows()) {
                $result = $result->result();
                return $result[0];
            }
            
            return FALSE;
        }
        
        public function setUserMembership($group_id, $user_id) {
            
            $checkUserMembership = $this->getUserMembership($user_id);
            $getUserGroup = $this->getUserGroup($group_id);
            
            if($checkUserMembership) {
                $date = new DateTime($checkUserMembership['f_date_expired']);
                $date->add(new DateInterval('P' . $getUserGroup['f_group_period'] . 'D'));
                $date_expired = $date->format('Y-m-d H:i:s');
                
                $result = $this->dao->update(
                                    $this->getTable_user_memberships(),
                                    array('f_group_title' => $getUserGroup['f_group_title'], 'f_group_discount' => $getUserGroup['f_group_discount'], 'f_date_expired' => $date_expired),
                                    array('f_user_id' => $user_id) 
                                );
            }
            else {
                $date_expired = date('Y-m-d H:i:s', time() + 60*60*24*$getUserGroup['f_group_period']);
                $result = $this->dao->insert(
                                    $this->getTable_user_memberships(), 
                                    array(
                                        'f_user_id' => $user_id,
                                        'f_group_id' => $group_id,
                                        'f_group_title' => $getUserGroup['f_group_title'],
                                        'f_group_discount' => $getUserGroup['f_group_discount'],
                                        'f_date_activated' => date('Y-m-d H:i:s'),
                                        'f_date_expired' => $date_expired
                                    )
                                );
            }
            
            return $result;
        }
        
        public function setCronUserBonus() {
            
            if(osc_get_preference('allow_periodbonus', 'rupayments')) {
                $start_date = new DateTime(osc_get_preference('periodbonus_start_date', 'rupayments'));
                $cur_date = new DateTime(date('Y-m-d', time()));
                $interval = $start_date->diff($cur_date);
                
                $period = osc_get_preference('period_value', 'rupayments');
                $bonus_amount = osc_get_preference('periodbonus_value', 'rupayments');
                $site_title = osc_page_title();
                $currency = osc_get_preference('currency', 'rupayments');
                
                $mail_title = $site_title . ' - Вы получили бонус!';
                $sEnd = '<p>Это автоматическое письмо, пожалуйста не отвечайте на него.</p><p>Спасибо</p>';
                
                if($interval->format('%a') % $period == 0 && osc_get_preference('periodbonus_last_accrual', 'rupayments') != date('Y-m-d', time())) {
                    
                    $this->dao->select();
                    $this->dao->from($this->getTable_rupayments_user());
                    $users = $this->dao->get();
                    
                    if($users) {
                        $users = $users->result();
                        
                        foreach($users as $user) {                     
                            $this->addWallet($user['pk_i_id'], $bonus_amount);
                            
                            $mail_text = "<p>Привет, {$user[s_name]}</p><p>Вы получили бонус {$bonus_amount} {$currency} в кошелёк. <p>Войдите и используйте его на сайте {$site_title}</p>" . $sEnd;
                            
                            $emailParams = array(
                                                'subject' => $mail_title,
                                                'to' => $user['s_email'],
                                                'to_name' => $user['s_name'],
                                                'body' => $mail_text
                                            );
                                            
                            osc_sendMail($emailParams);  
                        }
                    }
                    
                    osc_set_preference('periodbonus_last_accrual', date('Y-m-d', time()), 'rupayments', 'STRING');
                }
            }
        }
        
        static public function ajax_banners($resources = null) {
            if($resources==null) { $resources = osc_get_item_resources(); };
            $aImages = array();
            if( Session::newInstance()->_getForm('photos') != '' ) {
                $aImages = Session::newInstance()->_getForm('photos');
                if (isset($aImages['name'])) {
                    $aImages = $aImages['name'];
                } else {
                    $aImages = array();
                }
                Session::newInstance()->_drop('photos');
                Session::newInstance()->_dropKeepForm('photos');
            }

            ?>
            <div id="restricted-fine-uploader"></div>
            <div style="clear:both;"></div>
            <?php if(count($aImages)>0 || ($resources!=null && is_array($resources) && count($resources)>0)) { ?>
                <h3><?php _e('Images already uploaded');?></h3>
                <ul class="qq-upload-list">
                    <?php foreach($resources as $_r) {
                        $img = $_r['pk_i_id'].'.'.$_r['s_extension']; ?>
                        <li class=" qq-upload-success">
                            <span class="qq-upload-file"><?php echo $img; ?></span>
                            <a class="qq-upload-delete" href="#" photoid="<?php echo $_r['pk_i_id']; ?>" itemid="<?php echo $_r['fk_i_item_id']; ?>" photoname="<?php echo $_r['s_name']; ?>" photosecret="<?php echo Params::getParam('secret'); ?>" style="display: inline; cursor:pointer;"><?php _e('Delete'); ?></a>
                            <div class="ajax_preview_img"><img src="<?php echo osc_apply_filter('resource_path', osc_base_url().$_r['s_path']).$_r['pk_i_id'].'_thumbnail.'.$_r['s_extension']; ?>" alt="<?php echo osc_esc_html($img); ?>"></div>
                        </li>
                    <?php }; ?>
                    <?php foreach($aImages as $img){ ?>
                        <li class=" qq-upload-success">
                            <span class="qq-upload-file"><?php echo $img; $img = osc_esc_html($img); ?></span>
                            <a class="qq-upload-delete" href="#" ajaxfile="<?php echo $img; ?>" style="display: inline; cursor:pointer;"><?php _e('Delete'); ?></a>
                            <div class="ajax_preview_img"><img src="<?php echo osc_base_url(); ?>oc-content/uploads/temp/<?php echo $img; ?>" alt="<?php echo $img; ?>"></div>
                            <input type="hidden" name="ajax_photos[]" value="<?php echo $img; ?>">
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <div style="clear:both;"></div>
            <?php


            $aExt = explode(',',osc_allowed_extension());
            foreach($aExt as $key => $value) {
                $aExt[$key] = "'".$value."'";
            }

            $allowedExtensions = join(',', $aExt);
            $maxSize    = (int) osc_max_size_kb()*1024;
            $maxImages  = 1;
            ?>

            <script>
                $(document).ready(function() {

                    $('.qq-upload-delete').on('click', function(evt) {
                        evt.preventDefault();
                        var parent = $(this).parent()
                        var result = confirm('<?php echo osc_esc_js( __("This action can't be undone. Are you sure you want to continue?") ); ?>');
                        var urlrequest = '';
                        if($(this).attr('ajaxfile')!=undefined) {
                            urlrequest = 'ajax_photo='+$(this).attr('ajaxfile');
                        } else {
                            urlrequest = 'id='+$(this).attr('photoid')+'&item='+$(this).attr('itemid')+'&code='+$(this).attr('photoname')+'&secret='+$(this).attr('photosecret');
                        }
                        if(result) {
                            $.ajax({
                                type: "POST",
                                url: '<?php echo osc_base_url(true); ?>?page=ajax&action=delete_image&'+urlrequest,
                                dataType: 'json',
                                success: function(data){
                                    parent.remove();
                                }
                            });
                        }
                    });

                    $('#restricted-fine-uploader').on('click','.primary_image', function(event){
                        if(parseInt($("div.primary_image").index(this))>0){

                            var a_src   = $(this).parent().find('.ajax_preview_img img').attr('src');
                            var a_title = $(this).parent().find('.ajax_preview_img img').attr('alt');
                            var a_input = $(this).parent().find('input').attr('value');
                            // info
                            var a1 = $(this).parent().find('span.qq-upload-file').text();
                            var a2 = $(this).parent().find('span.qq-upload-size').text();

                            var li_first =  $('ul.qq-upload-list li').get(0);

                            var b_src   = $(li_first).find('.ajax_preview_img img').attr('src');
                            var b_title = $(li_first).find('.ajax_preview_img img').attr('alt');
                            var b_input = $(li_first).find('input').attr('value');
                            var b1      = $(li_first).find('span.qq-upload-file').text();
                            var b2      = $(li_first).find('span.qq-upload-size').text();

                            $(li_first).find('.ajax_preview_img img').attr('src', a_src);
                            $(li_first).find('.ajax_preview_img img').attr('alt', a_title);
                            $(li_first).find('input').attr('value', a_input);
                            $(li_first).find('span.qq-upload-file').text(a1);
                            $(li_first).find('span.qq-upload-size').text(a2);

                            $(this).parent().find('.ajax_preview_img img').attr('src', b_src);
                            $(this).parent().find('.ajax_preview_img img').attr('alt', b_title);
                            $(this).parent().find('input').attr('value', b_input);
                            $(this).parent().find('span.qq-upload-file').text(b1);
                            $(this).parent().find('span.qq-upload-file').text(b2);
                        }
                    });

                    $('#restricted-fine-uploader').on('click','.primary_image', function(event){
                        $(this).addClass('over primary');
                    });

                    $('#restricted-fine-uploader').on('mouseenter mouseleave','.primary_image', function(event){
                        if(event.type=='mouseenter') {
                            if(!$(this).hasClass('primary')) {
                                $(this).addClass('primary');
                            }
                        } else {
                            if(parseInt($("div.primary_image").index(this))>0){
                                $(this).removeClass('primary');
                            }
                        }
                    });


                    $('#restricted-fine-uploader').on('mouseenter mouseleave','li.qq-upload-success', function(event){
                        if(parseInt($("li.qq-upload-success").index(this))>0){

                            if(event.type=='mouseenter') {
                                $(this).find('div.primary_image').addClass('over');
                            } else {
                                $(this).find('div.primary_image').removeClass('over');
                            }
                        }
                    });

                    window.removed_images = 0;
                    $('#restricted-fine-uploader').on('click', 'a.qq-upload-delete', function(event) {
                        window.removed_images = window.removed_images+1;
                        $('#restricted-fine-uploader .flashmessage-error').remove();
                    });

                    $('#restricted-fine-uploader').fineUploader({
                        request: {
                            endpoint: '<?php echo osc_base_url(true)."?page=ajax&action=ajax_upload"; ?>'
                        },
                        multiple: true,
                        validation: {
                            allowedExtensions: [<?php echo $allowedExtensions; ?>],
                            sizeLimit: <?php echo $maxSize; ?>,
                            itemLimit: <?php echo $maxImages; ?>
                        },
                        messages: {
                            tooManyItemsError: '<?php echo osc_esc_js(__('Too many items ({netItems}) would be uploaded. Item limit is {itemLimit}.'));?>',
                            onLeave: '<?php echo osc_esc_js(__('The files are being uploaded, if you leave now the upload will be cancelled.'));?>',
                            typeError: '<?php echo osc_esc_js(__('{file} has an invalid extension. Valid extension(s): {extensions}.'));?>',
                            sizeError: '<?php echo osc_esc_js(__('{file} is too large, maximum file size is {sizeLimit}.'));?>',
                            emptyError: '<?php echo osc_esc_js(__('{file} is empty, please select files again without it.'));?>'
                        },
                        deleteFile: {
                            enabled: true,
                            method: "POST",
                            forceConfirm: false,
                            endpoint: '<?php echo osc_base_url(true)."?page=ajax&action=delete_ajax_upload"; ?>'
                        },
                        retry: {
                            showAutoRetryNote : true,
                            showButton: true
                        },
                        text: {
                            uploadButton: '<?php echo osc_esc_js(__('Click or Drop for upload images')); ?>',
                            waitingForResponse: '<?php echo osc_esc_js(__('Processing...')); ?>',
                            retryButton: '<?php echo osc_esc_js(__('Retry')); ?>',
                            cancelButton: '<?php echo osc_esc_js(__('Cancel')); ?>',
                            failUpload: '<?php echo osc_esc_js(__('Upload failed')); ?>',
                            deleteButton: '<?php echo osc_esc_js(__('Delete')); ?>',
                            deletingStatusText: '<?php echo osc_esc_js(__('Deleting...')); ?>',
                            formatProgress: '<?php echo osc_esc_js(__('{percent}% of {total_size}')); ?>'
                        }
                    }).on('error', function (event, id, name, errorReason, xhrOrXdr) {
                            $('#restricted-fine-uploader .flashmessage-error').remove();
                            $('#restricted-fine-uploader').append('<div class="flashmessage flashmessage-error">' + errorReason + '<a class="close" onclick="javascript:$(\'.flashmessage-error\').remove();" >X</a></div>');
                    }).on('statusChange', function(event, id, old_status, new_status) {
                        $(".alert.alert-error").remove();
                    }).on('complete', function(event, id, fileName, responseJSON) {
                        if (responseJSON.success) {
                            var new_id = id - removed_images;
                            var li = $('.qq-upload-list li')[new_id];
                            // @TOFIX @FIXME escape $responseJSON_uploadName below
                            // need a js function similar to osc_esc_js(osc_esc_html()) ?>
                            $(li).append('<div class="ajax_preview_img"><img src="<?php echo osc_base_url(); ?>oc-content/uploads/temp/'+responseJSON.uploadName+'" alt="' + responseJSON.uploadName + '"></div>');
                            $(li).append('<input type="hidden" name="ajax_photos[]" value="'+responseJSON.uploadName+'"></input>');
                        }
                    });
                });

            </script>
        <?php
        }
        
        public function checkUserBannerPay($bannerId, $userId) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_banners());
            $this->dao->where('fk_i_banner_id', $bannerId);
            $this->dao->where('i_user_id', $userId);
            
            $result = $this->dao->get();
            
            if($result->numRows()) {
                $result = $result->result();
                
                if($result[0]['i_banner_status'] == 3) return TRUE;
                
                return FALSE;
            }
            
            return FALSE;
        }
        
        public function setUserBannerPay($bannerId) {
            $this->dao->update(
                            $this->getTable_banners(),
                            array('i_banner_status' => 1),
                            array('fk_i_banner_id' => $bannerId) 
                        );
        }
        
        public function acceptBannerPublish($bannerId) {
            $checkBanner = $this->getBannerPublish($bannerId);
            
            if($checkBanner) {
                $result = $this->dao->update(
                            $this->getTable_banners(),
                            array('i_banner_status' => 3),
                            array('fk_i_banner_id' => $bannerId) 
                        );
                
                $user = User::newInstance()->findByPrimaryKey($checkBanner['i_user_id']);
                $item = array(
                            'pk_i_id' => $bannerId,
                            's_contact_name' => $user['s_name'],
                            's_contact_email' => $user['s_email']  
                            );
                
                rupayments_send_email ( $item, 0, 'alert', '902' );
                        
                return $result;
            }
            
            return FALSE;
        }
        
        public function rejectBannerPublish($bannerId) {
            $checkBanner = $this->getBannerPublish($bannerId);
            
            if($checkBanner) {
                $result = $this->dao->update(
                            $this->getTable_banners(),
                            array('i_banner_status' => 0),
                            array('fk_i_banner_id' => $bannerId) 
                        );
                        
                return $result;
            }
            
            return FALSE;
        }
        
        public function deleteBannerPublish($bannerId) {
            $checkBanner = $this->getBannerPublish($bannerId);
            
            if($checkBanner) {
                $result = $this->dao->delete($this->getTable_banners(), array('fk_i_banner_id' => $bannerId));
                
                $img = $checkBanner['s_banner_img'];
                $path = osc_plugins_path() . 'rupayments/banners/';
                @unlink($path . $img);
                
                return $result;
            }
            
            return FALSE;
        }
        
        public function getBannerPublish($bannerId) {
            $this->dao->select('*');
            $this->dao->from($this->getTable_banners());
            $this->dao->where('fk_i_banner_id', $bannerId);
            
            $result = $this->dao->get();
            
            if($result->numRows()) {
                $result = $result->result();
                return $result[0];
            }
            
            return FALSE;
        }
        
        public function getBannersPublish() {
            $this->dao->select('*');
            $this->dao->from($this->getTable_banners());
            $this->dao->orderBy('fk_i_banner_id DESC');
            
            $result = $this->dao->get();
            
            if($result->numRows()) {
                $result = $result->result(); $i = 0;
                
                foreach($result as $item) {
                    $banners[$i] = $item;
                    
                    switch($item['i_banner_status']) {
                        case 0 :
                            $banners[$i]['status'] = '<span class="alert alert-danger"><i class="mdi mdi-close-circle-outline"></i>' . __('Rejected', 'rupayments') . '</span>';
                        break;
                        
                        case 1 :
                            $banners[$i]['status'] = '<span class="alert alert-success"><i class="mdi mdi-check-all"></i>' . __('Active', 'rupayments') . '</span>';
                        break;
                        
                        case 3 :
                            $banners[$i]['status'] = '<span class="alert alert-info"><i class="mdi mdi-coin"></i>' . __('Pending Payment', 'rupayments') . '</span>';
                        break;
                        
                        case 4 :
                            $banners[$i]['status'] = '<span class="alert alert-default"><i class="mdi mdi-pause-circle-outline"></i>' . __('No Funding', 'rupayments') . '</span>';
                        break;
                        
                        default :
                            $banners[$i]['status'] = '<span class="alert alert-warning"><i class="mdi mdi-alert-outline"></i>' . __('Moderation', 'rupayments') . '</span>';
                        break;
                    }
                    
                    $i++;
                }
                
                return $banners;
            }
            
            return FALSE;
        }
        
        public function getUserBannerPublish($bannerId, $userId) {
            $this->dao->select('*');
            $this->dao->from($this->getTable_banners());
            $this->dao->where('fk_i_banner_id', $bannerId);
            $this->dao->where('i_user_id', $userId);
            
            $result = $this->dao->get();
            
            if($result->numRows()) {
                $result = $result->result();
                return $result[0];
            }
            
            return FALSE;
        }
        
        public function getUserBannersPublish($userId) {
            $this->dao->select('*') ;
            $this->dao->from($this->getTable_banners());
            $this->dao->where('i_user_id', $userId);
            
            $result = $this->dao->get();
                
            if($result->numRows()) {
                $result = $result->result(); $i = 0;
                
                foreach($result as $item) {
                    $banners[$i] = $item;
                    
                    switch($item['i_banner_status']) {
                        case 0 :
                            $banners[$i]['status'] = '<span class="alert alert-danger"><i class="mdi mdi-close-circle-outline"></i>' . __('Rejected', 'rupayments') . '</span>';
                        break;
                        
                        case 1 :
                            $banners[$i]['status'] = '<span class="alert alert-success"><i class="mdi mdi-check-all"></i>' . __('Active', 'rupayments') . '</span>';
                        break;
                        
                        case 3 :
                            $banners[$i]['status'] = '<span class="alert alert-info"><i class="mdi mdi-coin"></i>' . __('Pending Payment', 'rupayments') . '</span>';
                        break;
                        
                        case 4 :
                            $banners[$i]['status'] = '<span class="alert alert-default"><i class="mdi mdi-pause-circle-outline"></i>' . __('No Funding', 'rupayments') . '</span>';
                        break;
                        
                        default :
                            $banners[$i]['status'] = '<span class="alert alert-warning"><i class="mdi mdi-alert-outline"></i>' . __('Moderation', 'rupayments') . '</span>';
                        break;
                    }
                    
                    if(osc_rewrite_enabled()) {
                        $payLink = osc_base_url() .'rupayments/banner-pay/' . $item['fk_i_banner_id'];
                        $deleteLink = osc_base_url() .'rupayments/banner-delete/' . $item['fk_i_banner_id'];
                    }
                    else {
                        $payLink = osc_route_url('rupayments-banner-pay', array('bid' => $item['fk_i_banner_id']));
                        $deleteLink = osc_base_url(true) . '?page=custom&route=rupayments-user-banners&do=banner-delete&id=' . $item['fk_i_banner_id'];
                    }
                    
                    $banners[$i]['pay_link'] = $payLink;
                    $banners[$i]['delete_link'] = $deleteLink;
                    
                    $i++;
                }
                
                return $banners;
            }
            
            return FALSE;
        }
        
        public function deleteUserBannerPublish($bannerId, $userId) {
            $checkBanner = $this->getUserBannerPublish($bannerId, $userId);
            
            if($checkBanner) {
                $result = $this->dao->delete($this->getTable_banners(), array('fk_i_banner_id' => $bannerId));
                
                $img = $checkBanner['s_banner_img'];
                $path = osc_plugins_path() . 'rupayments/banners/';
                @unlink($path . $img);
                
                return $result;
            }
            
            return FALSE;
        }
        
        public function siteBannerPublish() {
            $bid = Params::getParam('bid');
            $user_id = osc_logged_user_id();
            $link = Params::getParam('banner_link');
            $budget = Params::getParam('banner_budget');
            
            $bannerSettings = $this->getBannerSettings($bid);
            $view_fee = $bannerSettings['f_bs_view_fee'] - $bannerSettings['f_bs_view_fee'] * $this->userDiscount / 100;
            $click_fee = $bannerSettings['f_bs_click_fee'] - $bannerSettings['f_bs_click_fee'] * $this->userDiscount / 100;
            
            $ajax_img = Params::getParam('ajax_photos');
            $img = Params::getFiles('photos');
            $path = osc_plugins_path() . 'rupayments/banners/';
            
            if(is_array($ajax_img)) {
                foreach($ajax_img as $photo) {
                    if(file_exists(osc_content_path().'uploads/temp/'.$photo)) {
                        $img['name'][]      = $photo;
                        $img['type'][]      = 'image/*';
                        $img['tmp_name'][]  = osc_content_path().'uploads/temp/'.$photo;
                        $img['error'][]     = UPLOAD_ERR_OK;
                        $img['size'][]      = 0;
                    }
                }
            }
            
            if(osc_copy($img['tmp_name'][0], $path)) {
                $this->dao->insert(
                            $this->getTable_banners(), 
                            array(
                                'i_bs_id' => $bid,
                                'i_user_id' => $user_id,
                                's_banner_img' => $ajax_img[0],
                                's_banner_link' => $link,
                                's_banner_view_fee' => $view_fee,
                                's_banner_click_fee' => $click_fee,
                                'i_banner_budget' => $budget
                            )
                        );
                $item = array(
                            'pk_i_id' => $bid
                        );
                        
                rupayments_send_email ( $item, 0, 'admin_send', '901' );
            }
        }
        
        public function siteBanner1() {
            $banner = $this->getBannerSettings(1);
            
            if($banner['f_bs_status']) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_banners());
                $this->dao->where('i_bs_id', 1);
                $this->dao->where('i_banner_status != 0');
                $this->dao->where('i_banner_status != 4');
                
                $result = $this->dao->get();
                
                if($result->numRows()) {
                    $result = $result->result();
                    
                    if($result[0]['i_banner_status'] == 1) {
                        $viewsFee = $result[0]['s_banner_view_fee'];
                        $views = $result[0]['i_banner_views'];
                        $spent = $result[0]['s_banner_spent']; $budget = $result[0]['i_banner_budget'];
                        
                        echo '<a id="site-banner" banner-id="' . $result[0]['fk_i_banner_id'] . '" href="' . $result[0]['s_banner_link'] . '" target="_blank">
                                <img src="' . osc_base_url() . 'oc-content/plugins/rupayments/banners/' . $result[0]['s_banner_img'] . '" />
                             </a>';
                             
                        $updViews = $views + 1; 
                        $updSpent = $spent + $viewsFee;
    
                        
                        if($updSpent >= $budget) {
                            $status = 4;
                            
                            $user = User::newInstance()->findByPrimaryKey($result[0]['i_user_id']);
                            $item = array(
                                        'pk_i_id' => $result[0]['fk_i_banner_id'],
                                        's_contact_name' => $user['s_name'],
                                        's_contact_email' => $user['s_email']  
                                        );
                            
                            rupayments_send_email ( $item, 0, 'alert', '903' );
                        }
                            else $status = 1;
                            
                        $this->dao->update(
                                $this->getTable_banners(),
                                array('i_banner_views' => $updViews, 's_banner_spent' => $updSpent, 'i_banner_status' => $status),
                                array('fk_i_banner_id' => $result[0]['fk_i_banner_id']) 
                            );  
                    }
                }
                else {
                    if(osc_is_web_user_logged_in()) {
                    	$link = osc_route_url('rupayments-banner-publish', array('bid' => 1));
                    } else {
                    	$link = osc_user_login_url();
                    }
                    require osc_plugins_path() . 'rupayments/user/default_banner_template.php';
                }
            }
        }
        
        public function siteBanner2() {
            $banner = $this->getBannerSettings(2);
            
            if($banner['f_bs_status']) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_banners());
                $this->dao->where('i_bs_id', 2);
                $this->dao->where('i_banner_status != 0');
                $this->dao->where('i_banner_status != 4');
                
                $result = $this->dao->get();
                
                if($result->numRows()) {
                    $result = $result->result();
                    
                    if($result[0]['i_banner_status'] == 1) {
                        $viewsFee = $result[0]['s_banner_view_fee'];
                        $views = $result[0]['i_banner_views'];
                        $spent = $result[0]['s_banner_spent']; $budget = $result[0]['i_banner_budget'];
                        
                        echo '<a id="site-banner" banner-id="' . $result[0]['fk_i_banner_id'] . '" href="' . $result[0]['s_banner_link'] . '" target="_blank">
                                <img src="' . osc_base_url() . 'oc-content/plugins/rupayments/banners/' . $result[0]['s_banner_img'] . '" />
                             </a>';
                             
                        $updViews = $views + 1; 
                        $updSpent = $spent + $viewsFee;
    
                        
                        if($updSpent >= $budget) {
                            $status = 4;
                            
                            $user = User::newInstance()->findByPrimaryKey($result[0]['i_user_id']);
                            $item = array(
                                        'pk_i_id' => $result[0]['fk_i_banner_id'],
                                        's_contact_name' => $user['s_name'],
                                        's_contact_email' => $user['s_email']  
                                        );
                            
                            rupayments_send_email ( $item, 0, 'alert', '903' );
                        }
                            else $status = 1;
                            
                        $this->dao->update(
                                $this->getTable_banners(),
                                array('i_banner_views' => $updViews, 's_banner_spent' => $updSpent, 'i_banner_status' => $status),
                                array('fk_i_banner_id' => $result[0]['fk_i_banner_id']) 
                            );  
                    }
                }
                else {
                    if(osc_is_web_user_logged_in()) {
                    	$link = osc_route_url('rupayments-banner-publish', array('bid' => 2));
                    } else {
                    	$link = osc_user_login_url();
                    }
                    require osc_plugins_path() . 'rupayments/user/default_banner_template.php';
                }
            }
        }
        
        public function siteBanner3() {
            $banner = $this->getBannerSettings(3);
            
            if($banner['f_bs_status']) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_banners());
                $this->dao->where('i_bs_id', 3);
                $this->dao->where('i_banner_status != 0');
                $this->dao->where('i_banner_status != 4');
                
                $result = $this->dao->get();
                
                if($result->numRows()) {
                    $result = $result->result();
                    
                    if($result[0]['i_banner_status'] == 1) {
                        $viewsFee = $result[0]['s_banner_view_fee'];
                        $views = $result[0]['i_banner_views'];
                        $spent = $result[0]['s_banner_spent']; $budget = $result[0]['i_banner_budget'];
                        
                        echo '<a id="site-banner" banner-id="' . $result[0]['fk_i_banner_id'] . '" href="' . $result[0]['s_banner_link'] . '" target="_blank">
                                <img src="' . osc_base_url() . 'oc-content/plugins/rupayments/banners/' . $result[0]['s_banner_img'] . '" />
                             </a>';
                             
                        $updViews = $views + 1; 
                        $updSpent = $spent + $viewsFee;
    
                        
                        if($updSpent >= $budget) {
                            $status = 4;
                            
                            $user = User::newInstance()->findByPrimaryKey($result[0]['i_user_id']);
                            $item = array(
                                        'pk_i_id' => $result[0]['fk_i_banner_id'],
                                        's_contact_name' => $user['s_name'],
                                        's_contact_email' => $user['s_email']  
                                        );
                            
                            rupayments_send_email ( $item, 0, 'alert', '903' );
                        }
                            else $status = 1;
                            
                        $this->dao->update(
                                $this->getTable_banners(),
                                array('i_banner_views' => $updViews, 's_banner_spent' => $updSpent, 'i_banner_status' => $status),
                                array('fk_i_banner_id' => $result[0]['fk_i_banner_id']) 
                            );  
                    }
                }
                else {
                    if(osc_is_web_user_logged_in()) {
                    	$link = osc_route_url('rupayments-banner-publish', array('bid' => 3));
                    } else {
                    	$link = osc_user_login_url();
                    }
                    require osc_plugins_path() . 'rupayments/user/default_banner_template.php';
                }
            }
        }
        
        public function siteBanner4() {
            $banner = $this->getBannerSettings(4);
            
            if($banner['f_bs_status']) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_banners());
                $this->dao->where('i_bs_id', 4);
                $this->dao->where('i_banner_status != 0');
                $this->dao->where('i_banner_status != 4');
                
                $result = $this->dao->get();
                
                if($result->numRows()) {
                    $result = $result->result();
                    
                    if($result[0]['i_banner_status'] == 1) {
                        $viewsFee = $result[0]['s_banner_view_fee'];
                        $views = $result[0]['i_banner_views'];
                        $spent = $result[0]['s_banner_spent']; $budget = $result[0]['i_banner_budget'];
                        
                        echo '<a id="site-banner" banner-id="' . $result[0]['fk_i_banner_id'] . '" href="' . $result[0]['s_banner_link'] . '" target="_blank">
                                <img src="' . osc_base_url() . 'oc-content/plugins/rupayments/banners/' . $result[0]['s_banner_img'] . '" />
                             </a>';
                             
                        $updViews = $views + 1; 
                        $updSpent = $spent + $viewsFee;
    
                        
                        if($updSpent >= $budget) {
                            $status = 4;
                            
                            $user = User::newInstance()->findByPrimaryKey($result[0]['i_user_id']);
                            $item = array(
                                        'pk_i_id' => $result[0]['fk_i_banner_id'],
                                        's_contact_name' => $user['s_name'],
                                        's_contact_email' => $user['s_email']  
                                        );
                            
                            rupayments_send_email ( $item, 0, 'alert', '903' );
                        }
                            else $status = 1;
                            
                        $this->dao->update(
                                $this->getTable_banners(),
                                array('i_banner_views' => $updViews, 's_banner_spent' => $updSpent, 'i_banner_status' => $status),
                                array('fk_i_banner_id' => $result[0]['fk_i_banner_id']) 
                            );  
                    }
                }
                else {
                    if(osc_is_web_user_logged_in()) {
                    	$link = osc_route_url('rupayments-banner-publish', array('bid' => 4));
                    } else {
                    	$link = osc_user_login_url();
                    }
                    require osc_plugins_path() . 'rupayments/user/default_banner_template.php';
                }
            }
        }
        
        public function siteBanner5() {
            $banner = $this->getBannerSettings(5);
            
            if($banner['f_bs_status']) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_banners());
                $this->dao->where('i_bs_id', 5);
                $this->dao->where('i_banner_status != 0');
                $this->dao->where('i_banner_status != 4');
                
                $result = $this->dao->get();
                
                if($result->numRows()) {
                    $result = $result->result();
                    
                    if($result[0]['i_banner_status'] == 1) {
                        $viewsFee = $result[0]['s_banner_view_fee'];
                        $views = $result[0]['i_banner_views'];
                        $spent = $result[0]['s_banner_spent']; $budget = $result[0]['i_banner_budget'];
                        
                        echo '<a id="site-banner" banner-id="' . $result[0]['fk_i_banner_id'] . '" href="' . $result[0]['s_banner_link'] . '" target="_blank">
                                <img src="' . osc_base_url() . 'oc-content/plugins/rupayments/banners/' . $result[0]['s_banner_img'] . '" />
                             </a>';
                             
                        $updViews = $views + 1; 
                        $updSpent = $spent + $viewsFee;
    
                        
                        if($updSpent >= $budget) {
                            $status = 4;
                            
                            $user = User::newInstance()->findByPrimaryKey($result[0]['i_user_id']);
                            $item = array(
                                        'pk_i_id' => $result[0]['fk_i_banner_id'],
                                        's_contact_name' => $user['s_name'],
                                        's_contact_email' => $user['s_email']  
                                        );
                            
                            rupayments_send_email ( $item, 0, 'alert', '903' );
                        }
                            else $status = 1;
                            
                        $this->dao->update(
                                $this->getTable_banners(),
                                array('i_banner_views' => $updViews, 's_banner_spent' => $updSpent, 'i_banner_status' => $status),
                                array('fk_i_banner_id' => $result[0]['fk_i_banner_id']) 
                            );  
                    }
                }
                else {
                    if(osc_is_web_user_logged_in()) {
                    	$link = osc_route_url('rupayments-banner-publish', array('bid' => 5));
                    } else {
                    	$link = osc_user_login_url();
                    }
                    require osc_plugins_path() . 'rupayments/user/default_banner_template.php';
                }
            }
        }
        
        public function siteBanner6() {
            $banner = $this->getBannerSettings(6);
            
            if($banner['f_bs_status']) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_banners());
                $this->dao->where('i_bs_id', 6);
                $this->dao->where('i_banner_status != 0');
                $this->dao->where('i_banner_status != 4');
                
                $result = $this->dao->get();
                
                if($result->numRows()) {
                    $result = $result->result();
                    
                    if($result[0]['i_banner_status'] == 1) {
                        $viewsFee = $result[0]['s_banner_view_fee'];
                        $views = $result[0]['i_banner_views'];
                        $spent = $result[0]['s_banner_spent']; $budget = $result[0]['i_banner_budget'];
                        
                        echo '<a id="site-banner" banner-id="' . $result[0]['fk_i_banner_id'] . '" href="' . $result[0]['s_banner_link'] . '" target="_blank">
                                <img src="' . osc_base_url() . 'oc-content/plugins/rupayments/banners/' . $result[0]['s_banner_img'] . '" />
                             </a>';
                             
                        $updViews = $views + 1; 
                        $updSpent = $spent + $viewsFee;
    
                        
                        if($updSpent >= $budget) {
                            $status = 4;
                            
                            $user = User::newInstance()->findByPrimaryKey($result[0]['i_user_id']);
                            $item = array(
                                        'pk_i_id' => $result[0]['fk_i_banner_id'],
                                        's_contact_name' => $user['s_name'],
                                        's_contact_email' => $user['s_email']  
                                        );
                            
                            rupayments_send_email ( $item, 0, 'alert', '903' );
                        }
                            else $status = 1;
                            
                        $this->dao->update(
                                $this->getTable_banners(),
                                array('i_banner_views' => $updViews, 's_banner_spent' => $updSpent, 'i_banner_status' => $status),
                                array('fk_i_banner_id' => $result[0]['fk_i_banner_id']) 
                            );  
                    }
                }
                else {
                    if(osc_is_web_user_logged_in()) {
                    	$link = osc_route_url('rupayments-banner-publish', array('bid' => 6));
                    } else {
                    	$link = osc_user_login_url();
                    }
                    require osc_plugins_path() . 'rupayments/user/default_banner_template.php';
                }
            }
        }
        
        public function siteBanner7() {
            $banner = $this->getBannerSettings(7);
            
            if($banner['f_bs_status']) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_banners());
                $this->dao->where('i_bs_id', 7);
                $this->dao->where('i_banner_status != 0');
                $this->dao->where('i_banner_status != 4');
                
                $result = $this->dao->get();
                
                if($result->numRows()) {
                    $result = $result->result();
                    
                    if($result[0]['i_banner_status'] == 1) {
                        $viewsFee = $result[0]['s_banner_view_fee'];
                        $views = $result[0]['i_banner_views'];
                        $spent = $result[0]['s_banner_spent']; $budget = $result[0]['i_banner_budget'];
                        
                        echo '<a id="site-banner" banner-id="' . $result[0]['fk_i_banner_id'] . '" href="' . $result[0]['s_banner_link'] . '" target="_blank">
                                <img src="' . osc_base_url() . 'oc-content/plugins/rupayments/banners/' . $result[0]['s_banner_img'] . '" />
                             </a>';
                             
                        $updViews = $views + 1; 
                        $updSpent = $spent + $viewsFee;
    
                        
                        if($updSpent >= $budget) {
                            $status = 4;
                            
                            $user = User::newInstance()->findByPrimaryKey($result[0]['i_user_id']);
                            $item = array(
                                        'pk_i_id' => $result[0]['fk_i_banner_id'],
                                        's_contact_name' => $user['s_name'],
                                        's_contact_email' => $user['s_email']  
                                        );
                            
                            rupayments_send_email ( $item, 0, 'alert', '903' );
                        }
                            else $status = 1;
                            
                        $this->dao->update(
                                $this->getTable_banners(),
                                array('i_banner_views' => $updViews, 's_banner_spent' => $updSpent, 'i_banner_status' => $status),
                                array('fk_i_banner_id' => $result[0]['fk_i_banner_id']) 
                            );  
                    }
                }
                else {
                    if(osc_is_web_user_logged_in()) {
                    	$link = osc_route_url('rupayments-banner-publish', array('bid' => 7));
                    } else {
                    	$link = osc_user_login_url();
                    }
                    require osc_plugins_path() . 'rupayments/user/default_banner_template.php';
                }
            }
        }
        
        public function siteBanner8() {
            $banner = $this->getBannerSettings(8);
            
            if($banner['f_bs_status']) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_banners());
                $this->dao->where('i_bs_id', 8);
                $this->dao->where('i_banner_status != 0');
                $this->dao->where('i_banner_status != 4');
                
                $result = $this->dao->get();
                
                if($result->numRows()) {
                    $result = $result->result();
                    
                    if($result[0]['i_banner_status'] == 1) {
                        $viewsFee = $result[0]['s_banner_view_fee'];
                        $views = $result[0]['i_banner_views'];
                        $spent = $result[0]['s_banner_spent']; $budget = $result[0]['i_banner_budget'];
                        
                        echo '<a id="site-banner" banner-id="' . $result[0]['fk_i_banner_id'] . '" href="' . $result[0]['s_banner_link'] . '" target="_blank">
                                <img src="' . osc_base_url() . 'oc-content/plugins/rupayments/banners/' . $result[0]['s_banner_img'] . '" />
                             </a>';
                             
                        $updViews = $views + 1; 
                        $updSpent = $spent + $viewsFee;
    
                        
                        if($updSpent >= $budget) {
                            $status = 4;
                            
                            $user = User::newInstance()->findByPrimaryKey($result[0]['i_user_id']);
                            $item = array(
                                        'pk_i_id' => $result[0]['fk_i_banner_id'],
                                        's_contact_name' => $user['s_name'],
                                        's_contact_email' => $user['s_email']  
                                        );
                            
                            rupayments_send_email ( $item, 0, 'alert', '903' );
                        }
                            else $status = 1;
                            
                        $this->dao->update(
                                $this->getTable_banners(),
                                array('i_banner_views' => $updViews, 's_banner_spent' => $updSpent, 'i_banner_status' => $status),
                                array('fk_i_banner_id' => $result[0]['fk_i_banner_id']) 
                            );  
                    }
                }
                else {
                    if(osc_is_web_user_logged_in()) {
                    	$link = osc_route_url('rupayments-banner-publish', array('bid' => 8));
                    } else {
                    	$link = osc_user_login_url();
                    }
                    require osc_plugins_path() . 'rupayments/user/default_banner_template.php';
                }
            }
        }
        
        public function siteBanner9() {
            $banner = $this->getBannerSettings(9);
            
            if($banner['f_bs_status']) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_banners());
                $this->dao->where('i_bs_id', 9);
                $this->dao->where('i_banner_status != 0');
                $this->dao->where('i_banner_status != 4');
                
                $result = $this->dao->get();
                
                if($result->numRows()) {
                    $result = $result->result();
                    
                    if($result[0]['i_banner_status'] == 1) {
                        $viewsFee = $result[0]['s_banner_view_fee'];
                        $views = $result[0]['i_banner_views'];
                        $spent = $result[0]['s_banner_spent']; $budget = $result[0]['i_banner_budget'];
                        
                        echo '<a id="site-banner" banner-id="' . $result[0]['fk_i_banner_id'] . '" href="' . $result[0]['s_banner_link'] . '" target="_blank">
                                <img src="' . osc_base_url() . 'oc-content/plugins/rupayments/banners/' . $result[0]['s_banner_img'] . '" />
                             </a>';
                             
                        $updViews = $views + 1; 
                        $updSpent = $spent + $viewsFee;
    
                        
                        if($updSpent >= $budget) {
                            $status = 4;
                            
                            $user = User::newInstance()->findByPrimaryKey($result[0]['i_user_id']);
                            $item = array(
                                        'pk_i_id' => $result[0]['fk_i_banner_id'],
                                        's_contact_name' => $user['s_name'],
                                        's_contact_email' => $user['s_email']  
                                        );
                            
                            rupayments_send_email ( $item, 0, 'alert', '903' );
                        }
                            else $status = 1;
                            
                        $this->dao->update(
                                $this->getTable_banners(),
                                array('i_banner_views' => $updViews, 's_banner_spent' => $updSpent, 'i_banner_status' => $status),
                                array('fk_i_banner_id' => $result[0]['fk_i_banner_id']) 
                            );  
                    }
                }
                else {
                    if(osc_is_web_user_logged_in()) {
                    	$link = osc_route_url('rupayments-banner-publish', array('bid' => 9));
                    } else {
                    	$link = osc_user_login_url();
                    }
                    require osc_plugins_path() . 'rupayments/user/default_banner_template.php';
                }
            }
        }
        
        public function siteBanner10() {
            $banner = $this->getBannerSettings(10);
            
            if($banner['f_bs_status']) {
                $this->dao->select('*') ;
                $this->dao->from($this->getTable_banners());
                $this->dao->where('i_bs_id', 10);
                $this->dao->where('i_banner_status != 0');
                $this->dao->where('i_banner_status != 4');
                
                $result = $this->dao->get();
                
                if($result->numRows()) {
                    $result = $result->result();
                    
                    if($result[0]['i_banner_status'] == 1) {
                        $viewsFee = $result[0]['s_banner_view_fee'];
                        $views = $result[0]['i_banner_views'];
                        $spent = $result[0]['s_banner_spent']; $budget = $result[0]['i_banner_budget'];
                        
                        echo '<a id="site-banner" banner-id="' . $result[0]['fk_i_banner_id'] . '" href="' . $result[0]['s_banner_link'] . '" target="_blank">
                                <img src="' . osc_base_url() . 'oc-content/plugins/rupayments/banners/' . $result[0]['s_banner_img'] . '" />
                             </a>';
                             
                        $updViews = $views + 1; 
                        $updSpent = $spent + $viewsFee;
    
                        
                        if($updSpent >= $budget) {
                            $status = 4;
                            
                            $user = User::newInstance()->findByPrimaryKey($result[0]['i_user_id']);
                            $item = array(
                                        'pk_i_id' => $result[0]['fk_i_banner_id'],
                                        's_contact_name' => $user['s_name'],
                                        's_contact_email' => $user['s_email']  
                                        );
                            
                            rupayments_send_email ( $item, 0, 'alert', '903' );
                        }
                            else $status = 1;
                            
                        $this->dao->update(
                                $this->getTable_banners(),
                                array('i_banner_views' => $updViews, 's_banner_spent' => $updSpent, 'i_banner_status' => $status),
                                array('fk_i_banner_id' => $result[0]['fk_i_banner_id']) 
                            );  
                    }
                }
                else {
                    if(osc_is_web_user_logged_in()) {
                    	$link = osc_route_url('rupayments-banner-publish', array('bid' => 10));
                    } else {
                    	$link = osc_user_login_url();
                    }
                    require osc_plugins_path() . 'rupayments/user/default_banner_template.php';
                }
            }
        }
        
        public function checkBannersActive() {
            $this->dao->select('*');
            $this->dao->from($this->getTable_banner_settings());
            $this->dao->where('f_bs_status', 1);
            
            $result = $this->dao->get();
            
            if($result->numRows()) return TRUE;
            
            return FALSE;
        }
        
        public function getBannerSettings($bannerId) {
            $this->dao->select('*');
            $this->dao->from($this->getTable_banner_settings());
            $this->dao->where('fk_i_bs_id', $bannerId);
            
            $result = $this->dao->get();
            
            if($result->numRows()) {
                $result = $result->result();
                return $result[0];
            }
            
            return FALSE;
        }
        
        public function getBannersSettings() {
            $this->dao->select('*');
            $this->dao->from($this->getTable_banner_settings());
            
            $result = $this->dao->get();
            
            if($result) return $result->result();
            
            return FALSE;
        }
        
        public function updateBannersSettings() {
            $countBannerSettigs = count(Params::getParam('banner_id'));
            $id = Params::getParam('banner_id');
            $title = Params::getParam('banner_name');
            $view_fee = Params::getParam('banner_view_fee');
            $click_fee = Params::getParam('banner_click_fee');
            $status = Params::getParam('banner_status');
            
            for($i = 0; $i < $countBannerSettigs; $i++) {
                $result = $this->dao->update(
                            $this->getTable_banner_settings(),
                            array('fk_bs_title' => $title[$i], 'f_bs_view_fee' => $view_fee[$i], 'f_bs_click_fee' => $click_fee[$i], 'f_bs_status' => $status[$i]),
                            array('fk_i_bs_id' => $id[$i]) 
                        ); 
            }
            
            return $result;
        }
        
        public function checkEbuyPay($itemId, $userId) {
            $this->dao->select('*');
            $this->dao->from($this->getTable_ebuy_deals());
            $this->dao->where('i_item_id', $itemId);
            $this->dao->where('i_deal_status != 4');  
            $this->dao->where('i_deal_status != 0');  
            
            $result = $this->dao->get();
            
            if($result->numRows()) return FALSE;
            
            return TRUE;
        }
        
        public function setEbuyDealPay($itemId, $userId) {
            $ebuyItem = $this->getEbuyItem($itemId, true);
            
            $result = $this->dao->insert(
                            $this->getTable_ebuy_deals(), 
                            array(
                                'i_item_id' => $ebuyItem['i_item_id'],
                                'i_seller_id' => $ebuyItem['i_user_id'],
                                'i_buyer_id' => $userId,
                                's_item_price' => $ebuyItem['s_item_price'],
                                's_item_currency' => $ebuyItem['s_item_currency'],
                                'dt_deal_date' => date('Y-m-d H:i:s')
                            )
                        );
            if($result) {
                $itemAction = new ItemActions();
                $itemAction->disable($ebuyItem['i_item_id']);
                
                $user = User::newInstance()->findByPrimaryKey($userId);
                $item = array(
                            'pk_i_id' => $ebuyItem['i_item_id'],
                            's_contact_name' => $user['s_name'],
                            's_contact_email' => $user['s_email']  
                            );
                
                rupayments_send_email ( $item, 0, 'alert', '1001' );
                rupayments_send_email ( $item, 0, 'admin_send', '1001' );
            }
        }
        
        public function getEbuyItem($itemId, $whereId = false) {
            $this->dao->select('*');
            $this->dao->from($this->getTable_ebuy());
            
            if($whereId) {
                $this->dao->where('fk_i_ebuy_id', $itemId);
            }
            else {
                $this->dao->where('i_item_id', $itemId);
            }
            
            $result = $this->dao->get();
            
            if($result->numRows()) {
                $result = $result->result();
                return $result[0];
            }
            
            return FALSE;
        }
        
        public function getEbuyDeal($itemId) {
            $this->dao->select('*');
            $this->dao->from($this->getTable_ebuy_deals());
            $this->dao->where('fk_i_edeal_id', $itemId);
            
            $result = $this->dao->get();
            
            if($result) {
                $result = $result->result();
                return $result[0];
            }
            
            return FALSE;
        }
        
        public function getEbuyDeals() { 
            $this->dao->select('u.s_name, id.s_title, i.s_contact_name, d.*');
            $this->dao->from($this->getTable_ebuy_deals() . ' d');
            $this->dao->join($this->getTable_item() . ' i', 'i.pk_i_id = d.i_item_id ', 'LEFT');
            $this->dao->join($this->getTable_item_description() . ' id', 'id.fk_i_item_id = d.i_item_id', 'LEFT');
            $this->dao->join($this->getTable_rupayments_user() . ' u', 'u.pk_i_id = d.i_buyer_id ', 'LEFT');
            $this->dao->orderBy('d.fk_i_edeal_id', 'DESC');
            
            $result = $this->dao->get(); $deals = array();
            
            if($result->numRows()) {
                $result = $result->result(); $i = 0;
                
                foreach($result as $item) {
                    $deals[$i] = $item;
                    
                    switch($item['i_payment_status']) {
                        case 0 :
                            $deals[$i]['p_status'] = '<span class="alert alert-info alert-padd-10px">' . __('Returned to Buyer', 'rupayments') . '</span>';
                        break;
                        
                        case 1 :
                            $deals[$i]['p_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Credited to Seller', 'rupayments') . '</span>';
                        break;
                        
                        case 3 :
                            if($item['i_deal_status'] == 0 || $item['i_deal_status'] == 4) {
                                $deals[$i]['p_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Withdrawn to Buyer', 'rupayments') . '</span>';
                            }
                            else {
                                $deals[$i]['p_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Withdrawn to Seller', 'rupayments') . '</span>';
                            }
                        break;
                        
                        case 4 :
                            if($item['i_deal_status'] == 0 || $item['i_deal_status'] == 4) {
                                $deals[$i]['p_status'] = '<span class="alert alert-warning alert-padd-10px">' . __('Ordered Withdrawal to Buyer', 'rupayments') . '</span>';
                            }
                            else {
                                $deals[$i]['p_status'] = '<span class="alert alert-warning alert-padd-10px">' . __('Ordered Withdrawal to Seller', 'rupayments') . '</span>';
                            } 
                            
                        break;
                        
                        case 5 :
                            $deals[$i]['p_status'] = '<span class="alert alert-danger alert-padd-10px">' . __('Returned to Seller', 'rupayments') . '</span>';
                        break;
                        
                        default :
                            $deals[$i]['p_status'] = '<span class="alert alert-default alert-padd-10px">' . __('Money Holded', 'rupayments') . '</span>';
                        break;
                    }
                    
                    switch($item['i_deal_status']) {
                        case 0 :
                            $deals[$i]['d_status'] = '<span class="alert alert-danger alert-padd-10px">' . __('Сanceled by Seller', 'rupayments') . '</span>';
                        break;
                        
                        case 1 :
                            $deals[$i]['d_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Deal Success', 'rupayments') . '</span>';
                        break;
                        
                        case 3 :
                            $deals[$i]['d_status'] = '<span class="alert alert-info alert-padd-10px">' . __('Awaiting Shipment', 'rupayments') . '</span>';
                        break;
                        
                        case 4 :
                            $deals[$i]['d_status'] = '<span class="alert alert-danger alert-padd-10px">' . __('Сanceled by Admin', 'rupayments') . '</span>';
                        break;
                        
                        case 5 :
                            $deals[$i]['d_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Accepted by Admin', 'rupayments') . '</span>';
                        break;
                        
                        default :
                            $deals[$i]['d_status'] = '<span class="alert alert-warning alert-padd-10px">' . __('In processing', 'rupayments') . '</span>';
                        break;
                    }
                    
                    $i++;
                }
                
                return $deals;
            }
            
            return FALSE;
        }
        
        public function getEbuyBuyList($userId) {           
            $this->dao->select('u.s_name, i.s_title, d.*');
            $this->dao->from($this->getTable_ebuy_deals() . ' d');
            $this->dao->join($this->getTable_rupayments_user() . ' u', 'u.pk_i_id = d.i_seller_id ', 'LEFT');
            $this->dao->join($this->getTable_item_description() . ' i', 'i.fk_i_item_id = d.i_item_id', 'LEFT');
            $this->dao->where('i_buyer_id', $userId);
            $this->dao->orderBy('d.fk_i_edeal_id', 'DESC');
            
            $result = $this->dao->get();
            $deals = array();
            
            if($result->numRows()) {
                $result = $result->result(); $i = 0;
                
                foreach($result as $item) {
                    $deals[$i] = $item;
                    
                    switch($item['i_payment_status']) {
                        case 0 :
                            $deals[$i]['p_status'] = '<span class="alert alert-info alert-padd-10px">' . __('Money Returned', 'rupayments') . '</span>';
                        break;
                        
                        case 1 :
                            $deals[$i]['p_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Credited to Seller', 'rupayments') . '</span>';
                        break;
                        
                        case 3 :
                            if($item['i_deal_status'] == 0 || $item['i_deal_status'] == 4) {
                                $deals[$i]['p_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Withdrawn', 'rupayments') . '</span>';
                            }
                            else {
                                $deals[$i]['p_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Credited to Seller', 'rupayments') . '</span>';
                            }
                        break;
                        
                        case 4 :
                            if($item['i_deal_status'] == 0 || $item['i_deal_status'] == 4) {
                                $deals[$i]['p_status'] = '<span class="alert alert-warning alert-padd-10px">' . __('Ordered Withdrawal', 'rupayments') . '</span>';
                            }
                            else {
                                $deals[$i]['p_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Credited to Seller', 'rupayments') . '</span>';
                            } 
                            
                        break;
                        
                        case 5 :
                            $deals[$i]['p_status'] = '<span class="alert alert-danger alert-padd-10px">' . __('Returned to Seller', 'rupayments') . '</span>';
                        break;
                        
                        default :
                            $deals[$i]['p_status'] = '<span class="alert alert-default alert-padd-10px">' . __('Money Holded', 'rupayments') . '</span>';
                        break;
                    }
                    
                    switch($item['i_deal_status']) {
                        case 0 :
                            $deals[$i]['d_status'] = '<span class="alert alert-danger alert-padd-10px">' . __('Сanceled by Seller', 'rupayments') . '</span>';
                        break;
                        
                        case 1 :
                            $deals[$i]['d_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Deal Success', 'rupayments') . '</span>';
                        break;
                        
                        case 3 :
                            $deals[$i]['d_status'] = '<span class="alert alert-info alert-padd-10px">' . __('Awaiting Shipment', 'rupayments') . '</span>';
                        break;
                        
                        case 4 :
                            $deals[$i]['d_status'] = '<span class="alert alert-danger alert-padd-10px">' . __('Сanceled by Admin', 'rupayments') . '</span>';
                        break;
                        
                        case 5 :
                            $deals[$i]['d_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Accepted by Admin', 'rupayments') . '</span>';
                        break;
                        
                        default :
                            $deals[$i]['d_status'] = '<span class="alert alert-warning alert-padd-10px">' . __('In processing', 'rupayments') . '</span>';
                        break;
                    }
                    
                    $i++;
                }
                
                return $deals;
            }
            
            return FALSE;
        }
        
        public function getEbuySellList($userId) {
            $this->dao->select('u.s_name, i.s_title, d.*');
            $this->dao->from($this->getTable_ebuy_deals() . ' d');
            $this->dao->join($this->getTable_rupayments_user() . ' u', 'u.pk_i_id = d.i_buyer_id ', 'LEFT');
            $this->dao->join($this->getTable_item_description() . ' i', 'i.fk_i_item_id = d.i_item_id', 'LEFT');
            $this->dao->where('i_seller_id', $userId);
            $this->dao->orderBy('d.fk_i_edeal_id', 'DESC');
            
            $result = $this->dao->get();
            $deals = array();
            
            if($result) {
                $result = $result->result(); $i = 0;
                
                foreach($result as $item) {
                    $deals[$i] = $item;
                    
                    switch($item['i_payment_status']) {
                        case 0 :
                            $deals[$i]['p_status'] = '<span class="alert alert-info alert-padd-10px">' . __('Returned to Buyer', 'rupayments') . '</span>';
                        break;
                        
                        case 1 :
                            $deals[$i]['p_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Money Credited', 'rupayments') . '</span>';
                        break;
                        
                        case 3 :
                            if($item['i_deal_status'] == 1 || $item['i_deal_status'] == 5) {
                                $deals[$i]['p_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Withdrawn', 'rupayments') . '</span>';
                            }
                            else {
                                $deals[$i]['p_status'] = '<span class="alert alert-info alert-padd-10px">' . __('Returned to Buyer', 'rupayments') . '</span>';
                            }
                        break;
                        
                        case 4 :
                            if($item['i_deal_status'] == 1 || $item['i_deal_status'] == 5) {
                                $deals[$i]['p_status'] = '<span class="alert alert-warning alert-padd-10px">' . __('Ordered Withdrawal', 'rupayments') . '</span>';
                            }
                            else {
                                $deals[$i]['p_status'] = '<span class="alert alert-info alert-padd-10px">' . __('Returned to Buyer', 'rupayments') . '</span>';
                            } 
                        break;
                        
                        case 5 :
                            $deals[$i]['p_status'] = '<span class="alert alert-danger alert-padd-10px">' . __('Returned', 'rupayments') . '</span>';
                        break;
                        
                        default :
                            $deals[$i]['p_status'] = '<span class="alert alert-default alert-padd-10px">' . __('Money Holded', 'rupayments') . '</span>';
                        break;
                    }
                    
                    switch($item['i_deal_status']) {
                        case 0 :
                            $deals[$i]['d_status'] = '<span class="alert alert-danger alert-padd-10px">' . __('Сanceled by Seller', 'rupayments') . '</span>';
                        break;
                        
                        case 1 :
                            $deals[$i]['d_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Deal Success', 'rupayments') . '</span>';
                        break;
                        
                        case 3 :
                            $deals[$i]['d_status'] = '<span class="alert alert-info alert-padd-10px">' . __('Awaiting Shipment', 'rupayments') . '</span>';
                        break;
                        
                        case 4 :
                            $deals[$i]['d_status'] = '<span class="alert alert-danger alert-padd-10px">' . __('Сanceled by Admin', 'rupayments') . '</span>';
                        break;
                        
                        case 5 :
                            $deals[$i]['d_status'] = '<span class="alert alert-success alert-padd-10px">' . __('Accepted by Admin', 'rupayments') . '</span>';
                        break;
                        
                        default :
                            $deals[$i]['d_status'] = '<span class="alert alert-warning alert-padd-10px">' . __('In processing', 'rupayments') . '</span>';
                        break;
                    }
                    
                    $i++;
                }
                
                return $deals;
            }
            
            return FALSE;
        }
        
        public function checkUserEbuyChangeStatus($dealId, $status, $userId) {
            $this->dao->select('*');
            $this->dao->from($this->getTable_ebuy_deals());
            $this->dao->where('fk_i_edeal_id', $dealId);
            
            switch($status) {
                
                case 'deal-accept' :
                    $this->dao->where('i_buyer_id', $userId);
                    $result = $this->dao->get();
                    
                    if($result->numRows() == 1) {
                        $result = $result->result();
                        
                        if($result[0]['i_deal_status'] == 3) return TRUE;
                        
                        return FALSE;
                    }
                    
                    return FALSE;
                break;
                
                case 'deal-shipment' :
                    $this->dao->where('i_seller_id', $userId);
                    $result = $this->dao->get();
                    
                    if($result->numRows() == 1) {
                        $result = $result->result();
                        
                        if($result[0]['i_deal_status'] == 2) return TRUE;
                        
                        return FALSE;
                    }
                    
                    return FALSE;
                break;
                
                case 'deal-withdraw-buyer' :
                    $this->dao->where('i_buyer_id', $userId);
                    $result = $this->dao->get();
                    
                    if($result->numRows() == 1) {
                        $result = $result->result();
                        
                        if($result[0]['i_deal_status'] == 0 || $result[0]['i_deal_status'] == 4) return TRUE;
                        
                        return FALSE;
                    }
                    
                    return FALSE;
                break;
                
                case 'deal-withdraw-seller' :
                    $this->dao->where('i_seller_id', $userId);
                    $result = $this->dao->get();
                    
                    if($result->numRows() == 1) {
                        $result = $result->result();
                        
                        if($result[0]['i_deal_status'] == 1 || $result[0]['i_deal_status'] == 5) return TRUE;
                        
                        return FALSE;
                    }
                    
                    return FALSE;
                break;
                
                case 'deal-cancel' :
                    $this->dao->where('i_seller_id', $userId);
                    $result = $this->dao->get();
                    
                    if($result->numRows() == 1) {
                        $result = $result->result();
                        
                        if($result[0]['i_deal_status'] == 2) return TRUE;
                        
                        return FALSE;
                    }
                    
                    return FALSE;
                break;
                
                default: 
                    return FALSE;
                break;
            }
            
            $result = $this->dao->get();
            
            if($result) {
                $result = $result->result();
                return $result[0];
            }
        }
        
        public function changeUserEbuyDealStatus($dealId, $status, $userId) {
            $checkChangeStatus = $this->checkUserEbuyChangeStatus($dealId, $status, $userId);
            
            if(!$checkChangeStatus) return FALSE;
            
            switch($status) {
                
                case 'deal-accept' :
                    $this->dao->update(
                                $this->getTable_ebuy_deals(),
                                array('i_payment_status' => 1, 'i_deal_status' => 1),
                                array('fk_i_edeal_id' => $dealId) 
                            );
                    
                break;
                
                case 'deal-shipment' :
                    $this->dao->update(
                                $this->getTable_ebuy_deals(),
                                array('i_deal_status' => 3),
                                array('fk_i_edeal_id' => $dealId) 
                            );
                break;
                
                case 'deal-withdraw-buyer' :
                    $this->dao->update(
                                $this->getTable_ebuy_deals(),
                                array('i_payment_status' => 4),
                                array('fk_i_edeal_id' => $dealId) 
                            );
                break;
                
                case 'deal-withdraw-seller' :
                    $this->dao->update(
                                $this->getTable_ebuy_deals(),
                                array('i_payment_status' => 4),
                                array('fk_i_edeal_id' => $dealId) 
                            );
                break;
                
                case 'deal-cancel' :
                    $this->dao->update(
                                $this->getTable_ebuy_deals(),
                                array('i_payment_status' => 0, 'i_deal_status' => 0),
                                array('fk_i_edeal_id' => $dealId) 
                            );
                            
                    $ebuyItem = $this->getEbuyDeal($dealId);
                    
                    $itemAction = new ItemActions();
                    $itemAction->enable($ebuyItem['i_item_id']);
                break;
                
                default: 
                    return FALSE;
                break;
            }
            
            return TRUE;
        }
        
        public function changeEbuyDealStatus($dealId, $status, $admin = false) {
            if(!$admin) return FALSE;
            
            switch($status) {
                
                case 'deal-accept' :
                    $this->dao->update(
                                $this->getTable_ebuy_deals(),
                                array('i_payment_status' => 1, 'i_deal_status' => 5),
                                array('fk_i_edeal_id' => $dealId) 
                            );
                            
                    $ebuyItem = $this->getEbuyDeal($dealId);
                    $itemAction = new ItemActions();
                    $itemAction->disable($ebuyItem['i_item_id']);
                    
                break;
                
                case 'deal-withdrawn' :
                    $this->dao->update(
                                $this->getTable_ebuy_deals(),
                                array('i_payment_status' => 3),
                                array('fk_i_edeal_id' => $dealId) 
                            );
                break;
                
                case 'deal-cancel' :
                    $this->dao->update(
                                $this->getTable_ebuy_deals(),
                                array('i_payment_status' => 0, 'i_deal_status' => 4),
                                array('fk_i_edeal_id' => $dealId) 
                            );
                            
                    $ebuyItem = $this->getEbuyDeal($dealId);
                    $itemAction = new ItemActions();
                    $itemAction->enable($ebuyItem['i_item_id']);
                break;
                
                default: 
                    return FALSE;
                break;
            }
            
            return TRUE;
        }
        
        public function setEbuyItem($itemId, $itemPrice = 0, $itemCurrency) {
            $userId = osc_logged_user_id();
            $itemPrice = substr($itemPrice, 0, strlen($itemPrice) - 6);
            
            $checkEbuyItem = $this->getEbuyItem($itemId);
            
            if($checkEbuyItem)  
                $this->dao->update(
                                $this->getTable_ebuy(),
                                array('s_item_price' => $itemPrice, 's_item_currency' => $itemCurrency, 'i_status' => Params::getParam('enable_sale')),
                                array('i_item_id' => $itemId) 
                            );
            else 
                $this->dao->insert( 
                                $this->getTable_ebuy(), 
                                array(
                                    'i_item_id' => $itemId,
                                    'i_user_id' => $userId,
                                    's_item_price' => $itemPrice,
                                    's_item_currency' => $itemCurrency,
                                    'i_status' => Params::getParam('enable_sale')
                                )
                            );
        }
    }
?>