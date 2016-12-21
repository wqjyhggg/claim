/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `jf_claim_management` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `jf_claim_management`;

CREATE TABLE IF NOT EXISTS `case` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_no` varchar(64) NOT NULL,
  `created_by` int(11) NOT NULL,
  `street_no` varchar(10) DEFAULT NULL,
  `street_name` varchar(30) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `province` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `country2` varchar(40) DEFAULT NULL,
  `post_code` varchar(10) DEFAULT NULL,
  `assign_to` int(11) NOT NULL DEFAULT '0',
  `follow_up_to` int(11) NOT NULL DEFAULT '0',
  `reason` varchar(30) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `relations` varchar(40) DEFAULT NULL,
  `diagnosis` varchar(40) DEFAULT NULL,
  `treatment` varchar(40) DEFAULT NULL,
  `third_party_recovery` enum('Y','N') NOT NULL DEFAULT 'N',
  `policy_no` varchar(20) DEFAULT NULL,
  `insured_firstname` varchar(50) DEFAULT NULL,
  `insured_lastname` varchar(50) DEFAULT NULL,
  `insured_address` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `case_manager` int(10) NOT NULL,
  `priority` varchar(10) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0-deactive, 1-active, stand for case status active/inactive',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `case_no` (`case_no`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `case` DISABLE KEYS */;
INSERT INTO `case` (`id`, `case_no`, `created_by`, `street_no`, `street_name`, `city`, `province`, `country`, `country2`, `post_code`, `assign_to`, `follow_up_to`, `reason`, `first_name`, `last_name`, `phone_number`, `email`, `relations`, `diagnosis`, `treatment`, `third_party_recovery`, `policy_no`, `insured_firstname`, `insured_lastname`, `insured_address`, `dob`, `case_manager`, `priority`, `status`, `created`) VALUES
	(5, '0000005', 1, '123143', 'sodala1', 'jaipur', 'British Columbia', 'United States', 'Canada', '302015', 2, 0, 'AD&D', 'bhawani', 'shankar', '424242424', 'developer@brsoftech.com', 'Father', 'test', 'sodala', 'Y', '99098908', 'bhawani', NULL, '1341 Goldhawk Trail\r\nOakville, ON\r\nL6M 3Y5', '2000-05-30', 2, 'Normal', '0', '2016-12-06 11:28:53'),
	(7, '0000007', 1, '1231', 'sodala', 'jaipur', 'British Columbia', 'United States', 'United States', '21313', 5, 0, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '', 'bhawani', NULL, '1341 Goldhawk Trail\r\nOakville, ON\r\nL6M 3Y5', '2000-05-30', 2, 'Normal', '1', '2016-12-08 06:47:47'),
	(8, '0000008', 1, '1231', 'sodala', 'jaipur', 'British Columbia', 'United States', 'United States', '21313', 6, 0, 'AD&D', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '1341 Goldhawk Trail\r\nOakville, ON\r\nL6M 3Y5', '2000-05-30', 2, 'Normal', '1', '2016-12-08 06:56:05'),
	(9, '0000009', 1, '1231', 'sodala', 'jaipur', 'British Columbia', 'United States', 'United States', '21313', 2, 0, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '1341 Goldhawk Trail\r\nOakville, ON\r\nL6M 3Y5', '2000-05-30', 2, 'HIGH', '1', '2016-12-08 06:57:12'),
	(78, '0000078', 1, '1231', 'sodala', 'jaipur', 'British Columbia', 'United States', 'Canada', '302014', 5, 0, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '1341 Goldhawk Trail\r\nOakville, ON\r\nL6M 3Y5', '2000-05-30', 2, 'Normal', '1', '2016-12-09 06:11:42'),
	(79, '0000079', 1, '1231', 'sodala', 'us', 'British Columbia', 'United States', 'United States', '21313', 5, 0, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '1341 Goldhawk Trail\r\nOakville, ON\r\nL6M 3Y5', '2000-05-30', 2, 'HIGH', '1', '2016-12-09 06:12:49'),
	(80, '0000080', 1, '1231', 'sodala', 'us', 'British Columbia', 'United States', 'United States', '21313', 6, 0, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '1341 Goldhawk Trail\r\nOakville, ON\r\nL6M 3Y5', '2000-05-30', 2, 'HIGH', '1', '2016-12-09 06:14:12'),
	(81, '0000081', 1, '1231', 'sodala', 'jaipur', 'British Columbia', 'United States', 'United States', '21313', 6, 0, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '1341 Goldhawk Trail\r\nOakville, ON\r\nL6M 3Y5', '2000-05-30', 2, 'Normal', '1', '2016-12-09 06:19:41'),
	(87, '0000087', 1, '1231', 'sodala', 'jaipur', 'British Columbia', 'United States', 'United States', '21313', 0, 0, 'AD&D', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '1341 Goldhawk Trail\r\nOakville, ON\r\nL6M 3Y5', '2000-05-30', 2, 'Normal', '1', '2016-12-13 07:48:23'),
	(88, '0000088', 1, 'sdfdsfdsf', 'sodala', 'jaipur', 'British Columbia', 'United States', 'United States', '21313', 0, 0, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'Y', '99098908', '21231', '56465', '1341 Goldhawk Trail\r\nOakville, ON\r\nL6M 3Y5', '2000-05-30', 2, 'HIGH', '1', '2016-12-14 09:38:54');
/*!40000 ALTER TABLE `case` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `short_code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` (`id`, `name`, `short_code`) VALUES
	(1, 'Canada', 'CA'),
	(2, 'United States', 'US');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `intake_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `notes` text,
  `docs` text,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

/*!40000 ALTER TABLE `intake_form` DISABLE KEYS */;
INSERT INTO `intake_form` (`id`, `case_id`, `created_by`, `notes`, `docs`, `created`) VALUES
	(3, 22, 1, 'asdsadsadsad', 'adasdsad,sadsadsad', '2016-12-08 07:09:13'),
	(6, 78, 1, 'sdaadsadsad', '', '2016-12-09 06:11:43'),
	(7, 81, 1, 'sads da dsa dsadsad', '1455713701_quiz_game.jpg,1456201505_quiz_game.jpg,-1455713068_quiz_game1.jpg', '2016-12-09 06:19:41'),
	(8, 81, 1, ' dsad ad sad sad df gfdg fdg dfg dg', '1455885494_quiz_game.jpg', '2016-12-09 06:19:41'),
	(9, 81, 1, 's f ghjklkjhfgfhjklf gfgh fg fghf ghfgh', '1455713701_quiz_game1.jpg', '2016-12-09 06:19:42'),
	(10, 81, 1, NULL, '', '2016-12-09 06:19:42'),
	(11, 81, 1, NULL, '', '2016-12-09 06:43:36'),
	(12, 81, 1, NULL, '', '2016-12-09 06:45:03'),
	(13, 77, 1, 'yahoo', '-1455713068_quiz_game2.jpg,-1455713068_quiz_game3.jpg', '2016-12-09 06:48:16'),
	(14, 77, 1, 'aaaaaaaaaa', '-1455713068_quiz_game4.jpg,1455713701_quiz_game2.jpg', '2016-12-09 06:48:38'),
	(15, 82, 1, 'sdsadsad', '1455885494_quiz_game1.jpg,-1455713068_quiz_game5.jpg', '2016-12-09 07:42:30'),
	(16, 82, 1, 'afsadsad', '1456201505_quiz_game1.jpg', '2016-12-09 07:42:30'),
	(17, 83, 1, 'asdsadsadsad', '1455713701_quiz_game3.jpg,1455885494_quiz_game2.jpg,1463118497_quiz_game.jpg', '2016-12-09 07:49:32'),
	(18, 84, 1, 'sadsadsad', '-1455713068_quiz_game6.jpg,1455713701_quiz_game4.jpg,1455885494_quiz_game3.jpg', '2016-12-09 07:51:28'),
	(19, 85, 1, 'cdfdsfdsdsfdsf', '1455713701_quiz_game5.jpg,1463118497_quiz_game1.jpg,1455713701_quiz_game6.jpg', '2016-12-09 07:53:40'),
	(20, 86, 1, 'asdsad sad sad sadsa dsa dsad a', '-1455713068_quiz_game.jpg,-1455713068_quiz_game1.jpg', '2016-12-13 06:25:35'),
	(21, 86, 1, 'sadsadasdsad', '1455713701_quiz_game.jpg', '2016-12-13 06:54:33'),
	(22, 86, 1, 'sadsadsad', 'mozilla.pdf', '2016-12-13 07:33:28'),
	(23, 86, 1, 'saddsad', 'mozilla.pdf', '2016-12-13 07:34:05'),
	(24, 86, 1, 'saddsad', 'mozilla.pdf', '2016-12-13 07:34:10'),
	(25, 87, 1, 'sadasdsadsa dasd sad asdas d', '', '2016-12-13 07:48:23'),
	(26, 87, 1, 'asd asdsa sad sad sad', 'mozilla.pdf', '2016-12-13 07:48:23');
/*!40000 ALTER TABLE `intake_form` ENABLE KEYS */;

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
  `priority` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `provider` DISABLE KEYS */;
INSERT INTO `provider` (`id`, `name`, `address`, `postcode`, `discount`, `contact_person`, `phone_no`, `email`, `ppo_codes`, `services`, `lat`, `lng`, `priority`, `created`) VALUES
	(7, 'bhawan', 'gangotri garden, jaipur', 302015, 2, '21321', '32132', 'g8bhawani@gmail.com', '1', '321', '26.8726731', '75.7788451', 1, NULL),
	(8, 'bhawan', 'sodala, jaipur', 302011, 3, '21321', '32132', 'g8bhawani@gmail.com', '1', '321', '26.9064744', '75.7728014', 2, NULL),
	(9, 'Apolo hospital', 'sodala', 302015, 20, '1231231321', '32156421456', 'gf@bf.com', '2313', 'all', '26.9064744', '75.7728014', 3, NULL),
	(10, 'Apolo hospital', 'sodala', 302015, 10, '1231231321', '32156421456', 'gf@bf.com', '2313', 'all', '26.9064744', '75.7728014', 5, NULL);
/*!40000 ALTER TABLE `provider` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(16) NOT NULL,
  `short_code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_province_country` (`country_id`),
  CONSTRAINT `FK_province_country` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `province` DISABLE KEYS */;
INSERT INTO `province` (`id`, `country_id`, `name`, `short_code`) VALUES
	(1, 2, 'Alberta', 'AB'),
	(2, 2, 'British Columbia', 'BC'),
	(3, 1, 'Ontario', 'ON'),
	(4, 1, 'Quebec', 'QC'),
	(5, 1, 'British Columbia', 'BC');
/*!40000 ALTER TABLE `province` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `reasons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `reasons` DISABLE KEYS */;
INSERT INTO `reasons` (`id`, `name`) VALUES
	(1, 'AD&D'),
	(2, 'Assistance Only'),
	(3, 'Collision'),
	(4, 'Cost Containment'),
	(5, 'Dental'),
	(6, 'Flight Accident'),
	(7, 'General, Inpatient'),
	(8, 'Outpatient'),
	(9, 'Prescription Drug'),
	(10, 'Roadside Assistance'),
	(11, 'Trip Cancellation'),
	(12, 'Other');
/*!40000 ALTER TABLE `reasons` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `relations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `relations` DISABLE KEYS */;
INSERT INTO `relations` (`id`, `name`) VALUES
	(1, 'Brother'),
	(2, 'Sister'),
	(3, 'Mother'),
	(4, 'Father'),
	(5, 'Me');
/*!40000 ALTER TABLE `relations` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned NOT NULL,
  `schedule` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
INSERT INTO `schedule` (`id`, `employee_id`, `schedule`, `date`, `created`) VALUES
	(11, 2, '2pm-8pm', '2017-01-01', '2016-12-17 08:14:32'),
	(12, 2, '2pm-8pm', '2017-01-08', '2016-12-17 08:14:32'),
	(13, 2, '2pm-8pm', '2017-01-15', '2016-12-17 08:14:32'),
	(14, 2, '2pm-8pm', '2017-01-22', '2016-12-17 08:14:32'),
	(15, 2, '2pm-8pm', '2017-01-29', '2016-12-17 08:14:32'),
	(16, 6, '8am-2pm', '2017-01-01', '2016-12-17 08:14:34'),
	(17, 6, '8am-2pm', '2017-01-08', '2016-12-17 08:14:35'),
	(18, 6, '8am-2pm', '2017-01-15', '2016-12-17 08:14:35'),
	(19, 6, '8am-2pm', '2017-01-22', '2016-12-17 08:14:35'),
	(20, 6, '8am-2pm', '2017-01-29', '2016-12-17 08:14:35'),
	(21, 6, '8am-2pm', '2016-12-22', '2016-12-17 08:14:55'),
	(22, 2, '2pm-8pm', '2016-12-22', '2016-12-17 08:14:57'),
	(23, 6, '8am-2pm', '2016-12-18', '2016-12-17 08:15:18'),
	(24, 5, '8pm-8am', '2016-12-18', '2016-12-17 08:15:20'),
	(25, 2, '2pm-8pm', '2016-12-18', '2016-12-17 08:15:23'),
	(26, 6, '2pm-8pm', '2016-12-28', '2016-12-17 08:25:12'),
	(30, 6, '2pm-8pm', '2017-01-03', '2016-12-17 09:08:34'),
	(32, 6, '2pm-8pm', '2017-01-10', '2016-12-17 09:19:02'),
	(47, 5, '2pm-8pm', '2016-12-20', '2016-12-17 10:29:22'),
	(64, 6, '2pm-8pm', '2017-01-11', '2016-12-19 06:34:02'),
	(71, 6, '2pm-8pm', '2017-01-05', '2016-12-19 06:41:05'),
	(72, 6, '2pm-8pm', '2017-01-12', '2016-12-19 06:41:05'),
	(73, 6, '2pm-8pm', '2017-01-19', '2016-12-19 06:41:05'),
	(74, 6, '2pm-8pm', '2017-01-26', '2016-12-19 06:41:05'),
	(76, 6, '8am-2pm', '2016-12-19', '2016-12-19 07:25:01'),
	(77, 5, '2pm-8pm', '2016-12-19', '2016-12-19 07:25:04'),
	(78, 2, '8pm-8am', '2016-12-19', '2016-12-19 07:25:07'),
	(79, 6, '8pm-8am', '2016-12-26', '2016-12-19 07:26:39'),
	(81, 2, '2pm-8pm', '2016-12-26', '2016-12-19 07:26:47'),
	(88, 7, '8am-2pm', '2016-12-23', '2016-12-21 09:48:09'),
	(89, 7, '8am-2pm', '2016-12-30', '2016-12-21 09:48:09'),
	(90, 6, '2pm-8pm', '2016-12-23', '2016-12-21 09:48:12'),
	(91, 6, '2pm-8pm', '2016-12-30', '2016-12-21 09:48:12'),
	(94, 2, '8pm-8am', '2016-12-23', '2016-12-21 09:48:18'),
	(95, 2, '8pm-8am', '2016-12-30', '2016-12-21 09:48:18'),
	(106, 5, '8pm-8am', '2016-12-22', '2016-12-21 10:23:00'),
	(107, 5, '8pm-8am', '2016-12-23', '2016-12-21 10:23:00'),
	(108, 5, '8pm-8am', '2016-12-24', '2016-12-21 10:23:00'),
	(109, 5, '8pm-8am', '2016-12-25', '2016-12-21 10:23:00'),
	(110, 5, '8pm-8am', '2016-12-26', '2016-12-21 10:23:00'),
	(111, 5, '8pm-8am', '2016-12-27', '2016-12-21 10:23:00'),
	(112, 5, '8pm-8am', '2016-12-28', '2016-12-21 10:23:00'),
	(113, 5, '8pm-8am', '2016-12-29', '2016-12-21 10:23:00'),
	(114, 5, '8pm-8am', '2016-12-30', '2016-12-21 10:23:01'),
	(115, 5, '8pm-8am', '2016-12-31', '2016-12-21 10:23:01'),
	(148, 5, '8am-2pm', '2017-01-02', '2016-12-21 10:24:01'),
	(149, 5, '8am-2pm', '2017-01-03', '2016-12-21 10:24:03'),
	(150, 5, '8am-2pm', '2017-01-04', '2016-12-21 10:24:04'),
	(151, 5, '8am-2pm', '2017-01-05', '2016-12-21 10:24:05'),
	(152, 5, '8am-2pm', '2017-01-06', '2016-12-21 10:24:05'),
	(153, 5, '8am-2pm', '2017-01-07', '2016-12-21 10:24:06'),
	(154, 5, '8am-2pm', '2017-01-08', '2016-12-21 10:24:06'),
	(155, 5, '8am-2pm', '2017-01-09', '2016-12-21 10:24:07'),
	(156, 5, '8am-2pm', '2017-01-10', '2016-12-21 10:24:07'),
	(157, 5, '8am-2pm', '2017-01-11', '2016-12-21 10:24:07'),
	(158, 5, '8am-2pm', '2017-01-12', '2016-12-21 10:24:07'),
	(159, 5, '8am-2pm', '2017-01-13', '2016-12-21 10:24:07'),
	(160, 5, '8am-2pm', '2017-01-14', '2016-12-21 10:24:07'),
	(161, 5, '8am-2pm', '2017-01-15', '2016-12-21 10:24:07'),
	(162, 5, '8am-2pm', '2017-01-16', '2016-12-21 10:24:07'),
	(163, 5, '8am-2pm', '2017-01-17', '2016-12-21 10:24:08'),
	(164, 5, '8am-2pm', '2017-01-18', '2016-12-21 10:24:08'),
	(165, 5, '8am-2pm', '2017-01-19', '2016-12-21 10:24:09'),
	(166, 5, '8am-2pm', '2017-01-20', '2016-12-21 10:24:09'),
	(167, 5, '8am-2pm', '2017-01-21', '2016-12-21 10:24:09'),
	(168, 5, '8am-2pm', '2017-01-22', '2016-12-21 10:24:09'),
	(169, 5, '8am-2pm', '2017-01-23', '2016-12-21 10:24:09'),
	(170, 5, '8am-2pm', '2017-01-24', '2016-12-21 10:24:09'),
	(171, 5, '8am-2pm', '2017-01-25', '2016-12-21 10:24:10'),
	(172, 5, '8am-2pm', '2017-01-26', '2016-12-21 10:24:10'),
	(173, 5, '8am-2pm', '2017-01-27', '2016-12-21 10:24:10'),
	(174, 5, '8am-2pm', '2017-01-28', '2016-12-21 10:24:10'),
	(175, 5, '8am-2pm', '2017-01-29', '2016-12-21 10:24:10'),
	(176, 5, '8am-2pm', '2017-01-30', '2016-12-21 10:24:10'),
	(177, 5, '8am-2pm', '2017-01-31', '2016-12-21 10:24:10'),
	(178, 5, '2pm-8pm', '2017-02-01', '2016-12-21 10:26:21'),
	(179, 5, '2pm-8pm', '2017-02-02', '2016-12-21 10:26:21'),
	(180, 5, '2pm-8pm', '2017-02-03', '2016-12-21 10:26:21'),
	(181, 5, '2pm-8pm', '2017-02-04', '2016-12-21 10:26:21'),
	(182, 5, '2pm-8pm', '2017-02-05', '2016-12-21 10:26:21'),
	(183, 5, '2pm-8pm', '2017-02-06', '2016-12-21 10:26:21'),
	(184, 5, '2pm-8pm', '2017-02-07', '2016-12-21 10:26:22'),
	(185, 5, '2pm-8pm', '2017-02-08', '2016-12-21 10:26:22'),
	(186, 5, '2pm-8pm', '2017-02-09', '2016-12-21 10:26:22'),
	(187, 5, '2pm-8pm', '2017-02-10', '2016-12-21 10:26:22'),
	(188, 5, '2pm-8pm', '2017-02-11', '2016-12-21 10:26:22'),
	(189, 5, '2pm-8pm', '2017-02-12', '2016-12-21 10:26:22'),
	(190, 5, '2pm-8pm', '2017-02-13', '2016-12-21 10:26:22'),
	(191, 5, '2pm-8pm', '2017-02-14', '2016-12-21 10:26:22'),
	(192, 5, '2pm-8pm', '2017-02-15', '2016-12-21 10:26:22'),
	(193, 5, '2pm-8pm', '2017-02-16', '2016-12-21 10:26:22'),
	(194, 5, '2pm-8pm', '2017-02-17', '2016-12-21 10:26:22'),
	(195, 5, '2pm-8pm', '2017-02-18', '2016-12-21 10:26:22'),
	(196, 5, '2pm-8pm', '2017-02-19', '2016-12-21 10:26:22'),
	(197, 5, '2pm-8pm', '2017-02-20', '2016-12-21 10:26:22'),
	(198, 5, '2pm-8pm', '2017-02-21', '2016-12-21 10:26:22'),
	(199, 5, '2pm-8pm', '2017-02-22', '2016-12-21 10:26:22'),
	(200, 5, '2pm-8pm', '2017-02-23', '2016-12-21 10:26:22'),
	(201, 5, '2pm-8pm', '2017-02-24', '2016-12-21 10:26:22'),
	(202, 5, '2pm-8pm', '2017-02-25', '2016-12-21 10:26:22'),
	(203, 5, '2pm-8pm', '2017-02-26', '2016-12-21 10:26:22'),
	(204, 5, '2pm-8pm', '2017-02-27', '2016-12-21 10:26:22'),
	(205, 5, '2pm-8pm', '2017-02-28', '2016-12-21 10:26:22');
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `description` longtext NOT NULL,
  `type` enum('claim','case','emc') DEFAULT NULL COMMENT '''claim-claim manager'',''case-case manager'',''emc-emc user''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `template` DISABLE KEYS */;
INSERT INTO `template` (`id`, `name`, `description`, `type`) VALUES
	(1, 'Additional Information Requisition', '<html>\r\n   <body>\r\n		{otc_logo}\r\n		<p class="outer-text">{current_date}</p>\r\n		<p class="outer-text">{insured_name}</p>\r\n		<p class="outer-text">{insured_address}</p>\r\n\r\n		<p align="center">Letter of Additional Information Requisition</p>\r\n		<p>Dear Mr./Ms. {insured_lastname},</p>\r\n		<p>Re: Policy Number: {policy_no}, Case Number: <span class="outer-text">{case_no}</span> <br/> Coverage Period: {policy_coverage_info}</p>\r\n\r\n		<p>We refer to your recent insurance case. In order to process your case, please provide the following additional information.</p>\r\n\r\n		<p style="margin-left: 10px;"  class="outer-text area">\r\n		- Original itemized bills and receipts<br/>\r\n		- The attached claim must be completed and returned .<br/>\r\n		- The name, address and telephone number of your primary physician in Canada.<br/>\r\n		- The name, address and telephone number of your family physician in your country of origin.<br/>\r\n		- Proof of arrival in Canada (copy of stamped passport)<br/>\r\n		- The enclosed medical authorization form for medical provider must be completed and returned.<br/>\r\n		- Home GP record or physical exam reports<br/>\r\n		- Any other relevant medical records<br/>\r\n		</p>\r\n\r\n		<p>In order to expedite the adjudication of your case, please ensure that all requested information is forwarded to the assisting company shown below. Upon receipt of the above information, your case will be further reviewed.</p>\r\n		<p>Please email the requested documentations to <span class="outer-text">general@otcww.com</span></p>\r\n		<p>Your prompt reply to the above will ensure that your case is attended to with minimum delay, if you have any questions, please do not hesitate to contact us at <span class="outer-text">905-707-9555</span> or toll free at <span class="outer-text">1-888-988-3268</span>.</p>\r\n\r\n		<p>For and on behalf of<br/>Ontime Care Worldwide</p>\r\n		<p><span class="outer-text">{casemanager_name}</span><br/>Case Manager</p>\r\n   </body>\r\n</html>', 'case'),
	(2, 'Continuing Care Notice', '<html>\r\n      <body>\r\n		{otc_logo}\r\n		<p class="outer-text">{current_date}</p>\r\n		<p>\r\n			Mutluay Can<br/>\r\n			49 Mobile Drive<br/>\r\n			Toronto, ON<br/><br/>\r\n			M4A 1H5<br/>\r\n		</p>\r\n\r\n		<p align="center">Letter of Continuing Care</p>\r\n		<p>Dear Mr./Ms. {insured_lastname},</p>\r\n		<p>Re: Policy Number: {policy_no}, Case Number: {case_no} <br/> Coverage Period: {policy_coverage_info}</p>\r\n\r\n		<p>I am writing to confirm that your <span class="select-product">JF Elite Plus International Student</span> <span class="outer-text area">Policy will not cover you for any further complications related to stabbing or any related conditions since we consider that your medical emergency for these conditions ended.  Continuing care exclusion applies after the initial treatment is over.<br/>Please find the following provisions in the policy wording:.</span></p>\r\n\r\n		<p>Limitation of Benefits</p>\r\n\r\n		<p>Once you are deemed medically stable to return to your country of origin (with or without a medical escort) in the opinion of Ontime Care or by virtue of discharge from hospital, your emergency is considered to have ended, whereupon any further consultation, treatment, recurrence or complication related to the emergency will no longer be eligible for coverage under this policy.</p>\r\n		<p>Please note that this does not alter your coverage for emergency treatment that you have already received, nor for any unrelated acute illness or injury.</p>\r\n		<p>We reserve all rights and defenses of the policy and law. Neither this communication, nor our willingness to review any further information which you may provide , nor our further communication with you concerning this claim is intended as a waiver or abandonment of any right or defense, and should not be construed as such.</p>\r\n\r\n		<p>This letter is without prejudice to and is not a waiver of any of the Company’s rights and defenses, all of which are specifically reserved.</p>\r\n\r\n		<p>Should you have any questions, please do not hesitate to contact us at <span class="outer-text">905-707-9555</span> or toll free at <span class="outer-text">1-888-988-3268</span></p>\r\n\r\n		<p>For and on behalf of<br/>Ontime Care Worldwide</p>\r\n		<p>{casemanager_name}<br/>Case Manager</p>\r\n   </body>\r\n</html>', 'case'),
	(3, 'Policy Cancelation Notice', '<html>\r\n   \r\n   <body>\r\n		{otc_logo}\r\n		<p class="outer-text">{current_date}</p>\r\n		<p class="outer-text">{insured_name}</p>\r\n		<p class="outer-text">{insured_address}</p>\r\n\r\n		<p align="center">Letter of Co-ordination of Benefits </p>\r\n		<p>Dear Mr./Ms. {insured_lastname},</p>\r\n		<p>Re: Policy Number: {policy_no}, Case Number: <span class="outer-text">{case_no}</span> <br/> Coverage Period: {policy_coverage_info}</p>\r\n\r\n		<p>We acknowledge receipt of your <span class="select-product">JF Royal Visitor Medical Insurance case</span> underwritten by <span class="select-product-country">Berkley Canada</span>. As per our conversation, your visitor medical plan is a secondary payer plan when an accident occurs. Please find the following provision in the policy wording:</p>\r\n\r\n		<p>Please find the following eligibility requirements and exclusion in our policy wording:</p>\r\n\r\n\r\n		<p class="outer-text area">2. Other Insurance <br/>\r\n\r\n		This insurance is a second payer plan. For any loss or damage insured by, or for any claim payable under any other liability, group or individual basic or extended health insurance plan, or contracts including any private or provincial or territorial auto insurance plan providing hospital, medical, or therapeutic coverage, or any other insurance in force concurrently herewith, amounts payable hereunder are limited to those covered benefits incurred outside your country of origin that are in excess of the amounts for which you are insured under such other coverage.</p>\r\n\r\n		<p>Your prompt attention is appreciated to ensure the processing of your case. Should you have any questions, please do not hesitate to contact us at <span class="outer-text">905-707-9555</span> or toll free at <span class="outer-text">1-888-988-3268</span>.</p>\r\n		\r\n		<p>For and on behalf of<br/>Ontime Care Worldwide</p>\r\n		<p><span class="outer-text">{casemanager_name}</span><br/>Case Manager</p>\r\n   </body>\r\n</html>', 'case'),
	(4, 'Release of Medical Records Notice (Medical provider)', '<html>\r\n   \r\n   <body>\r\n		{otc_logo}\r\n		<p class="outer-text">{current_date}</p>\r\n		<p class="outer-text">\r\n			Can Mutluay<br/>\r\n			49 Mobile Drive<br/>\r\n			Toronto On<br/>\r\n			M4A 1H5<br/>\r\n		</p>\r\n\r\n		<p align="center">Letter of Release of Medical Records Notice </p>\r\n		<p>Dear Mr./Ms. {insured_lastname},</p>\r\n		<p>Our Policy Number: {policy_no}<br/> Our Case Number: {case_no}</p>\r\n\r\n		<p>Ontime Care Worldwide Inc. is the plan administrator for the above noted insured with a <span class="previous_product">JF Elite Plus Plan underwritten by Berkley Canada</span>. In order to process the case, Ontime Care is obliged to collect and retain certain personal and/or health information about this patient in connection with their insurance coverage. This information will be used only to assess and determine if the claim is payable and will be handled in accordance with the appropriate privacy legislation.</p>\r\n\r\n		<p>Attached please find the insured’s completed Consent to Release Information Form providing the necessary authorization and consent. Accordingly, we ask that you provide us with the requested medical records.</p>\r\n\r\n		<p>Should you have any questions in this matter, you may call us at <span class="outer-text">905-707-9555</span> or toll free at <span class="outer-text">1-888-988-3268</span>. Thank you for your co-operation in this matter. </p>\r\n\r\n		\r\n		<p>For and on behalf of<br/>Ontime Care Worldwide</p>\r\n		<p><span  class="outer-text">{casemanager_name}</span><br/>Case Manager</p>\r\n   </body>\r\n</html>', 'case'),
	(5, 'Repatriation Notice', '<html>\r\n  \r\n   <body>\r\n		{otc_logo}\r\n		<p class="outer-text">{current_date}</p>\r\n		<p class="outer-text">{insured_name}</p>\r\n		<p class="outer-text">{insured_address}</p>\r\n\r\n		<p align="center">Letter of Repatriation Notice </p>\r\n		<p>Dear Mr./Ms. {insured_lastname},</p>\r\n		<p>Re: Policy Number: {policy_no}, Case Number: <span class="outer-text">{case_no}</span> <br/> Coverage Period: {policy_coverage_info}</p>\r\n\r\n		<p>This letter is to inform you that we have come to a decision based on the medical notes submitted to offer you a one-way economy flight ticket to your home country. Your policy will terminate five days from the day you were informed if you do not accept the offer.</p>\r\n\r\n		<p>Please find the following provisions in the policy wording:</p>\r\n\r\n		<p align="outer-text area">"If you choose to decline the transfer or return when declared medically stable by the Assistance Company, the Insurer will be released from any liability for expenses incurred for such sickness or injury after the proposed date of transfer or return. The Assistance Company will make every provision for your medical condition when choosing and arranging the mode of your transfer or return" \r\n		<br/>\r\n		<br/>\r\n		Limitation of Benefits\r\n		<br/>\r\n		<br/>\r\n\r\n		Once you are deemed medically stable to return to your country of origin (with or without a medical escort) in the opinion of the Assistance Company or, your emergency is considered to have ended, whereupon any further consultation, treatment, recurrence or complication related to the emergency will no longer be eligible for coverage under this policy</p>\r\n\r\n		<p>Your prompt attention is appreciated to ensure the processing of your case. Should you have any questions, please do not hesitate to contact us at <span class="outer-text">905-707-9555</span> or toll free at <span class="outer-text">1-888-988-3268</span>.</p>\r\n		\r\n		<p>For and on behalf of<br/>Ontime Care Worldwide</p>\r\n		<p><span class="outer-text">{casemanager_name}</span><br/>Case Manager</p>\r\n   </body>\r\n\r\n</html>', 'case');
/*!40000 ALTER TABLE `template` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
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
  `shift` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `parent_id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `shift`) VALUES
	(1, 0, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', NULL, NULL, NULL, NULL, 1268889823, 1482295178, 1, 'Admin', 'istrator', NULL, '2132132132', ''),
	(2, 1, '192.168.1.29', 'a@xx.com', '$2y$08$gnsbXPmHtU7SBQko94uf9.VVVzzFhd12fYK3n1FMx4lL8yDPzMvvm', NULL, 'a@xx.com', NULL, NULL, NULL, NULL, 1479881420, 1480055689, 1, 'nn123a', 'bb123', NULL, '123131', '2pm-8pm'),
	(5, 1, '192.168.1.29', 'paytm123e@gmail.com', '$2y$08$p84W1BzwM7WslS9PgioW5elSODLU0E0N/p8Q2uyNzOFeHxD48AW3q', NULL, 'paytm123e@gmail.com', NULL, NULL, NULL, NULL, 1479977418, NULL, 1, 'bhawani', 'bb', NULL, '231321322', '2pm-8pm'),
	(6, 1, '192.168.1.29', 'g8bhawani@gmail.com', '$2y$08$Bm7PbyWf99OzJpfeICUmU.9/8/OU68KK/uvBtblO4hkAGfz799nUG', NULL, 'g8bhawani@gmail.com', NULL, NULL, NULL, NULL, 1481794884, NULL, 1, 'istra', 'istrator', NULL, '231564645', '8pm-8am'),
	(7, 1, '192.168.1.29', 'jack.salli@gmail.com', '$2y$08$a9mqZV7Yz/NsUNYtL2HmF.pwR0DmCeuzJ1s41AbYlCMCb/KmveH4S', NULL, 'jack.salli@gmail.com', NULL, NULL, NULL, NULL, 1482300501, NULL, 1, 'jack', 'sali', NULL, '12345678', '8am-2pm');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
	(99, 1, 1),
	(100, 1, 2),
	(101, 1, 3),
	(102, 1, 4),
	(103, 1, 5),
	(104, 1, 6),
	(105, 1, 7),
	(96, 2, 2),
	(97, 2, 4),
	(98, 2, 7),
	(108, 5, 2),
	(94, 6, 2),
	(93, 7, 2);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
