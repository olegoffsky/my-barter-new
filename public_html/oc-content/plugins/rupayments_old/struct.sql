CREATE TABLE IF NOT EXISTS `/*TABLE_PREFIX*/t_rupayments_banners` (
  `fk_i_banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_bs_id` tinyint(3) unsigned NOT NULL,
  `i_user_id` int(11) NOT NULL,
  `s_banner_img` varchar(255) NOT NULL,
  `s_banner_link` varchar(255) NOT NULL,
  `s_banner_view_fee` varchar(25) NOT NULL,
  `s_banner_click_fee` varchar(25) NOT NULL,
  `i_banner_views` varchar(25) NOT NULL DEFAULT '0',
  `i_banner_clicks` int(11) unsigned NOT NULL DEFAULT '0',
  `s_banner_spent` varchar(25) NOT NULL DEFAULT '0',
  `i_banner_budget` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `s_banner_comment` varchar(255) NOT NULL,
  `i_banner_status` tinyint(1) unsigned NOT NULL DEFAULT '2',
  PRIMARY KEY (`fk_i_banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `/*TABLE_PREFIX*/t_rupayments_ebuy` (
  `fk_i_ebuy_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `i_item_id` int(11) unsigned NOT NULL,
  `i_user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `s_item_price` varchar(25) NOT NULL DEFAULT '0',
  `s_item_currency` varchar(5) NOT NULL,
  `i_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fk_i_ebuy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `/*TABLE_PREFIX*/t_rupayments_ebuy_deals` (
  `fk_i_edeal_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_item_id` int(11) NOT NULL,
  `i_seller_id` int(11) NOT NULL,
  `i_buyer_id` int(11) NOT NULL,
  `s_item_price` varchar(25) NOT NULL,
  `s_item_currency` varchar(5) NOT NULL,
  `i_payment_status` tinyint(1) NOT NULL DEFAULT '2',
  `i_deal_status` tinyint(1) NOT NULL DEFAULT '2',
  `dt_deal_date` datetime NOT NULL,
  PRIMARY KEY (`fk_i_edeal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `/*TABLE_PREFIX*/t_rupayments_image_show` (
  `fk_i_item_id` int(11) unsigned NOT NULL,
  `f_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `dt_date` datetime NOT NULL,
  PRIMARY KEY (`fk_i_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `/*TABLE_PREFIX*/t_rupayments_top` (
  `fk_i_item_id` int(11) NOT NULL,
  `d_date_top` date NOT NULL,
  `dt_date_expires` datetime NOT NULL,
  `fk_i_payment_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`fk_i_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `/*TABLE_PREFIX*/t_rupayments_banner_settings` (
  `fk_i_bs_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `fk_bs_title` varchar(255) NOT NULL,
  `f_bs_code` varchar(255) NOT NULL,
  `f_bs_view_fee` varchar(25) NOT NULL DEFAULT '0',
  `f_bs_click_fee` varchar(25) NOT NULL DEFAULT '0',
  `f_bs_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fk_i_bs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_rupayments_log (
    pk_i_id INT NOT NULL AUTO_INCREMENT ,
    s_concept VARCHAR( 200 ) NOT NULL ,
    dt_date DATETIME NOT NULL ,
    s_code VARCHAR( 255 ) NOT NULL ,
    f_amount FLOAT NOT NULL ,
    i_amount DECIMAL(32,8) NOT NULL DEFAULT 0.00000000,
    s_currency_code VARCHAR( 3 ) NULL ,
    s_email VARCHAR( 200 ) NULL ,
    fk_i_user_id INT NULL ,
    fk_i_item_id INT NULL ,
    s_source VARCHAR( 10 ) NOT NULL,
    i_product_type VARCHAR( 15 ) NOT NULL,

    PRIMARY KEY(pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE IF NOT EXISTS `/*TABLE_PREFIX*/t_rupayments_packs` (
  `fk_i_pack_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `f_pack_title` varchar(255) NOT NULL,
  `f_pack_description` varchar(255) NOT NULL,
  `f_pack_color` varchar(7) NOT NULL,
  `f_pack_amount` smallint(5) unsigned NOT NULL DEFAULT '0',
  `f_pack_bonus` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fk_i_pack_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_rupayments_wallet (
    fk_i_user_id INT UNSIGNED NOT NULL,
    i_amount DECIMAL(32,8) NOT NULL DEFAULT '0.00000000',


        PRIMARY KEY (fk_i_user_id),
        FOREIGN KEY (fk_i_user_id) REFERENCES /*TABLE_PREFIX*/t_user (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_rupayments_premium (
    fk_i_item_id INT UNSIGNED NOT NULL,
    dt_date DATETIME NOT NULL ,
    s_keyword VARCHAR(250) NULL ,
    fk_i_payment_id INT NOT NULL,

        PRIMARY KEY (fk_i_item_id),
        FOREIGN KEY (fk_i_item_id) REFERENCES /*TABLE_PREFIX*/t_item (pk_i_id),
        FOREIGN KEY (fk_i_payment_id) REFERENCES /*TABLE_PREFIX*/t_rupayments_log (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_rupayments_prices (
    `fk_i_category_id` int(10) unsigned NOT NULL,
    `f_top_cost` float DEFAULT NULL,
    `f_color_cost` float DEFAULT NULL,
    `f_premium_cost` float DEFAULT NULL,
    `f_pack_cost` float DEFAULT NULL,
    `f_publish_cost` float DEFAULT NULL,
    `f_renew_cost` float DEFAULT NULL,
    `f_picture_cost` float DEFAULT NULL,    

    PRIMARY KEY (fk_i_category_id),
    FOREIGN KEY (fk_i_category_id) REFERENCES /*TABLE_PREFIX*/t_category (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_rupayments_publish (
    fk_i_item_id INT UNSIGNED NOT NULL,
    dt_date DATETIME NOT NULL ,
    b_paid BOOLEAN NOT NULL DEFAULT FALSE,
    s_keyword VARCHAR(250) NULL ,
    fk_i_payment_id INT NULL,

        PRIMARY KEY (fk_i_item_id),
        FOREIGN KEY (fk_i_item_id) REFERENCES /*TABLE_PREFIX*/t_item (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE IF NOT EXISTS `/*TABLE_PREFIX*/t_rupayments_region_prices` (
  `fk_s_region_id` varchar(11) NOT NULL,
  `f_region_type` varchar(10) NOT NULL,
  `f_top_cost` float NOT NULL DEFAULT '0',
  `f_color_cost` float NOT NULL DEFAULT '0',
  `f_premium_cost` float NOT NULL DEFAULT '0',
  `f_pack_cost` float NOT NULL DEFAULT '0',
  `f_publish_cost` float NOT NULL DEFAULT '0',
  `f_renew_cost` float NOT NULL DEFAULT '0',
  `f_picture_cost` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`fk_s_region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_rupayments_is_publish_payment_needed (
    fk_i_item_id INT UNSIGNED NOT NULL,
    b_is_needed BOOLEAN NOT NULL DEFAULT TRUE,

        PRIMARY KEY (fk_i_item_id),
        FOREIGN KEY (fk_i_item_id) REFERENCES /*TABLE_PREFIX*/t_item (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_rupayments_cron_email_filter (
    fk_i_item_id INT UNSIGNED NOT NULL,
    dt_date DATETIME NOT NULL,
    b_is_sent BOOLEAN NOT NULL DEFAULT FALSE,

        PRIMARY KEY (fk_i_item_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_rupayments_policy (
    `fk_policy_id` int(11) NOT NULL AUTO_INCREMENT,
    `i_category_id` int(11) NOT NULL,
    `i_user_group_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `i_num_free_ads` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `i_free_unlimited_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (`fk_policy_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI' AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_rupayments_skrill (
    dt_date DATETIME NOT NULL ,
    f_amount FLOAT NOT NULL ,
    s_currency_code VARCHAR( 3 ) NULL ,
    s_email VARCHAR( 200 ) NULL ,
    s_transaction_id VARCHAR( 200 ) NULL ,
    fk_i_item_id INT(10) NULL ,
    i_product_type VARCHAR( 15 ) NULL
                        
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE IF NOT EXISTS `/*TABLE_PREFIX*/t_rupayments_user_groups` (
  `fk_i_group_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `f_group_title` varchar(255) NOT NULL,
  `f_group_description` varchar(255) NOT NULL,
  `f_group_color` varchar(7) NOT NULL,
  `f_group_price` smallint(5) unsigned NOT NULL DEFAULT '0',
  `f_group_discount` smallint(5) unsigned NOT NULL DEFAULT '0',
  `f_group_period` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fk_i_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `/*TABLE_PREFIX*/t_rupayments_user_groups_membership` (
  `fk_i_ugm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `f_user_id` int(10) unsigned NOT NULL,
  `f_group_id` tinyint(3) unsigned NOT NULL,
  `f_group_title` varchar(255) NOT NULL,
  `f_group_discount` smallint(5) unsigned NOT NULL,
  `f_date_activated` datetime NOT NULL,
  `f_date_expired` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`fk_i_ugm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS  oc_t_rupayments_bitcoin (
    ai INT(11) NOT NULL AUTO_INCREMENT ,
    uid INT(11) NOT NULL ,
    sum DOUBLE NOT NULL ,
	trans_id VARCHAR( 128 ) NOT NULL ,
    curr DOUBLE NOT NULL ,
    var1 VARCHAR( 128 ) NOT NULL ,
    var2 VARCHAR( 128 ) NOT NULL ,
    time INT(11) NOT NULL ,
	ok TINYINT(1) NOT NULL,
	
	PRIMARY KEY(ai)                       
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';                                                                      

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_rupayments_colorized (
    fk_i_item_id INT UNSIGNED NOT NULL,
    dt_date DATETIME NOT NULL ,

        PRIMARY KEY (fk_i_item_id),
		FOREIGN KEY (fk_i_item_id) REFERENCES /*TABLE_PREFIX*/t_item (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';