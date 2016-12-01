/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `jf_claim_management` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `jf_claim_management`;

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` (`id`, `name`) VALUES
	(1, 'Canada'),
	(2, 'United States');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `name`, `description`) VALUES
	(1, 'admin', 'Administrator'),
	(2, 'eacmanager', 'EAC Manager'),
	(3, 'callcenteragent', 'Call Centre Agent'),
	(4, 'casemamager', 'Case Manager'),
	(5, 'caseexaminer', 'Claims Examiner'),
	(6, 'claimsmanager', 'Claims Manager'),
	(7, 'accountant', 'Accountant');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `provider` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `address` text,
  `postcode` int(8) DEFAULT NULL,
  `discount` int(10) DEFAULT NULL,
  `contact_person` varchar(20) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ppo_codes` varchar(20) DEFAULT NULL,
  `services` varchar(200) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lng` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `provider` DISABLE KEYS */;
INSERT INTO `provider` (`id`, `name`, `address`, `postcode`, `discount`, `contact_person`, `phone_no`, `email`, `ppo_codes`, `services`, `lat`, `lng`, `created`) VALUES
	(7, 'bhawan', 'gangotri garden, jaipur', 302015, 10, '21321', '32132', 'g8bhawani@gmail.com', '1', '321', '26.8726731', '75.7788451', NULL),
	(8, 'bhawan', 'sodala, jaipur', 302011, 10, '21321', '32132', 'g8bhawani@gmail.com', '1', '321', '26.9064744', '75.7728014', NULL);
/*!40000 ALTER TABLE `provider` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_province_country` (`country_id`),
  CONSTRAINT `FK_province_country` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `province` DISABLE KEYS */;
INSERT INTO `province` (`id`, `country_id`, `name`) VALUES
	(1, 2, 'Alberta'),
	(2, 2, 'British Columbia'),
	(3, 1, 'British Columbia'),
	(4, 1, 'British Columbia'),
	(5, 1, 'British Columbia');
/*!40000 ALTER TABLE `province` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
	(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', NULL, NULL, NULL, NULL, 1268889823, 1480590505, 1, 'Admin', 'istrator', NULL, '2132132132'),
	(2, '192.168.1.29', 'a@xx.com', '$2y$08$gnsbXPmHtU7SBQko94uf9.VVVzzFhd12fYK3n1FMx4lL8yDPzMvvm', NULL, 'a@xx.com', NULL, NULL, NULL, NULL, 1479881420, 1480055689, 1, 'nn123', 'bb123', NULL, '123131'),
	(5, '192.168.1.29', 'paytm123e@gmail.com', '$2y$08$p84W1BzwM7WslS9PgioW5elSODLU0E0N/p8Q2uyNzOFeHxD48AW3q', NULL, 'paytm123e@gmail.com', NULL, NULL, NULL, NULL, 1479977418, NULL, 1, 'bhawani', 'bb', NULL, '231321322');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
	(51, 1, 1),
	(52, 1, 2),
	(53, 1, 3),
	(54, 1, 4),
	(55, 1, 5),
	(56, 1, 6),
	(57, 1, 7),
	(58, 2, 7),
	(50, 5, 2);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
