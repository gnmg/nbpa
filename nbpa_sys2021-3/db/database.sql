SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `t_apply_points` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `regist_apply_no` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL,
  `point` int(11) NOT NULL DEFAULT '0',
  `stage` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `regist_apply_no` (`regist_apply_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `t_judge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT 'judge name',
  `quota` int(11) NOT NULL DEFAULT '10' COMMENT 'quota of points',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `t_manager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `mgr_name` varchar(40) DEFAULT NULL COMMENT 'Name',
  `mgr_username` varchar(40) NOT NULL COMMENT 'login name',
  `mgr_password` varchar(80) NOT NULL COMMENT 'login password',
  `mgr_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Normal, 1:Administrator',
  `mgr_acl` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'ACL',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `t_member_regist` (
  `member_regist_no` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(30) NOT NULL,
  `mail` varchar(80) NOT NULL,
  `mail_chk` varchar(80) NOT NULL,
  `name_s` varchar(80) NOT NULL,
  `name_m` varchar(80) NOT NULL,
  `furigana_s` varchar(80) DEFAULT NULL,
  `furigana_m` varchar(80) DEFAULT NULL,
  `zipcode1` varchar(80) DEFAULT NULL,
  `zipcode2` varchar(80) DEFAULT NULL,
  `pref` smallint(6) DEFAULT NULL,
  `city` varchar(80) DEFAULT NULL,
  `adno` varchar(80) DEFAULT NULL,
  `apname` varchar(80) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `mb_tel` varchar(20) DEFAULT NULL,
  `password` varchar(80) NOT NULL,
  `password_chk` varchar(80) NOT NULL,
  `birth` varchar(10) DEFAULT NULL,
  `sex` smallint(6) DEFAULT NULL,
  `complete_flag` varchar(80) DEFAULT NULL,
  `entry_date` datetime DEFAULT NULL,
  `revision_date` datetime DEFAULT NULL,
  `rome_first` varchar(80) DEFAULT NULL,
  `rome_last` varchar(80) DEFAULT NULL,
  `high_school_flag` varchar(80) DEFAULT NULL,
  `enquete1` varchar(80) DEFAULT NULL,
  `enquete2` varchar(80) DEFAULT NULL,
  `enq_txt` varchar(256) DEFAULT NULL,
  `status` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`member_regist_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `t_paydollar_datafeed` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_regist_no` int(11) NOT NULL COMMENT 'Member Regist Number',
  `pd_prc` int(11) DEFAULT NULL COMMENT 'Return bank host status code (primary)',
  `pd_src` int(11) DEFAULT NULL COMMENT 'Return bank host status code (secondary)',
  `pd_ord` varchar(40) DEFAULT NULL COMMENT 'Bank Reference Number',
  `pd_ref` text COMMENT 'Merchant Order Reference Number',
  `pd_payref` bigint(20) DEFAULT NULL COMMENT 'PayDollar Payment Reference Number',
  `pd_successcode` int(11) DEFAULT NULL COMMENT '0:succeeded, 1:failure, Other:error',
  `pd_amt` varchar(20) DEFAULT NULL COMMENT 'Transaction Amount',
  `pd_cur` varchar(3) DEFAULT NULL COMMENT 'Transaction Currency',
  `pd_holder` text COMMENT 'The Holder Name of the Payment Account',
  `pd_auth_id` text COMMENT 'Approval Code',
  `pd_alert_code` text COMMENT 'The Alert Code',
  `pd_remark` text COMMENT 'A remark field',
  `pd_eci` varchar(2) DEFAULT NULL COMMENT 'ECI value (3D)',
  `pd_payer_auth` varchar(1) DEFAULT NULL COMMENT 'Payer Authentication Status',
  `pd_source_ip` varchar(15) DEFAULT NULL COMMENT 'IP address of payer',
  `pd_ip_country` varchar(3) DEFAULT NULL COMMENT 'Country of payer',
  `pd_pay_method` varchar(10) DEFAULT NULL COMMENT 'Payment method',
  `pd_tx_time` text COMMENT 'Transaction time',
  `pd_pan_first4` varchar(4) DEFAULT NULL COMMENT 'First 4 digit of card',
  `pd_pan_last4` varchar(4) DEFAULT NULL COMMENT 'Last 4 digit of card',
  `pd_card_issuing_country` varchar(3) DEFAULT NULL COMMENT 'Card Issuing Country Code',
  `pd_channel_type` varchar(3) DEFAULT NULL COMMENT 'Channel Type',
  `pd_merchant_id` int(11) DEFAULT NULL COMMENT 'The merchant Id of transaction',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_pd1` (`member_regist_no`,`pd_successcode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `t_payment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_regist_no` int(11) NOT NULL COMMENT 'Member Regist Number',
  `ref_no` text COMMENT 'Merchant Order Reference Number',
  `tx_no` text COMMENT 'Transaction Number',
  `kind` tinyint(4) NOT NULL COMMENT '1:PayDollar, 2:PayPal',
  `result_code` int(11) DEFAULT NULL COMMENT '0:succeeded, Other:failure',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_payment` (`member_regist_no`,`result_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `t_paypal_ipn` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_regist_no` int(11) NOT NULL COMMENT 'Member Regist Number',
  `payment_status` varchar(20) DEFAULT NULL COMMENT 'Payment Status',
  `invoice` varchar(40) DEFAULT NULL COMMENT 'Invoice Number',
  `ipn` text COMMENT 'IPN',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ipn` (`member_regist_no`,`payment_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `t_regist_apply` (
  `regist_apply_no` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(30) NOT NULL,
  `apply_genre` int(11) NOT NULL,
  `apply_image` text,
  `pay_status` int(11) DEFAULT NULL,
  `member_regist_no` varchar(80) DEFAULT NULL,
  `entry_date` datetime DEFAULT NULL,
  `revision_date` datetime DEFAULT NULL,
  `apply_status` int(11) DEFAULT '2',
  `image_title` text NOT NULL,
  `image_comment` varchar(160) DEFAULT NULL,
  `unique_id` varchar(80) DEFAULT NULL,
  `settle_method` int(11) DEFAULT NULL,
  `judge_status` int(11) DEFAULT '0',
  `highres_photo_status` int(1) DEFAULT '0',
  `highres_photo_name` text,
  `raw_file` text,
  `photo_place` varchar(128) DEFAULT NULL,
  `camera` varchar(64) DEFAULT NULL,
  `lens` varchar(64) DEFAULT NULL,
  `ss` varchar(32) DEFAULT NULL,
  `f_num` varchar(16) DEFAULT NULL,
  `iso` varchar(32) DEFAULT NULL,
  `flash` varchar(64) DEFAULT NULL,
  `tripod` varchar(64) DEFAULT NULL,
  `photo_comment` text,
  `animal_name` varchar(160) DEFAULT NULL,
  `change_comment` text,
  `staff_comment` text,
  PRIMARY KEY (`regist_apply_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `t_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settings_key` varchar(16) NOT NULL,
  `settings_val` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
