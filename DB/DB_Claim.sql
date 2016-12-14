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
  `assign_to` int(11) NOT NULL,
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
  `dob` date DEFAULT NULL,
  `case_manager` int(10) NOT NULL,
  `priority` varchar(10) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `case_no` (`case_no`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `case` DISABLE KEYS */;
INSERT INTO `case` (`id`, `case_no`, `created_by`, `street_no`, `street_name`, `city`, `province`, `country`, `country2`, `post_code`, `assign_to`, `reason`, `first_name`, `last_name`, `phone_number`, `email`, `relations`, `diagnosis`, `treatment`, `third_party_recovery`, `policy_no`, `insured_firstname`, `insured_lastname`, `dob`, `case_manager`, `priority`, `created`) VALUES
	(1, '0000001', 1, '123143', 'sodala1', 'jaipur', 'British Columbia', 'United States', 'Canada', '302015', 1, 'AD&D', 'bhawani', 'shankar', '424242424', 'developer@brsoftech.com', 'Father', 'test', 'sodala', 'Y', '99098908', 'bhawani', NULL, '2000-05-30', 2, 'Normal', '2016-12-02 11:39:34'),
	(2, '0000002', 1, '', '', '', '', '', '', '', 5, 'Roadside Assistance', 'nn123', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'Normal', '2016-12-06 07:13:43'),
	(3, '0000003', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'Normal', '2016-12-06 07:49:37'),
	(4, '0000004', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'Normal', '2016-12-06 07:51:53'),
	(5, '0000005', 1, '123143', 'sodala1', 'jaipur', 'British Columbia', 'United States', 'Canada', '302015', 1, 'AD&D', 'bhawani', 'shankar', '424242424', 'developer@brsoftech.com', 'Father', 'test', 'sodala', 'Y', '99098908', 'bhawani', NULL, '2000-05-30', 2, 'Normal', '2016-12-06 11:28:53'),
	(6, '0000006', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-07 14:15:42'),
	(7, '0000007', 1, '1231', 'sodala', 'jaipur', 'British Columbia', 'United States', 'United States', '21313', 2, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '', 'bhawani', NULL, '2000-05-30', 2, 'Normal', '2016-12-08 06:47:47'),
	(8, '0000008', 1, '1231', 'sodala', 'jaipur', 'British Columbia', 'United States', 'United States', '21313', 1, 'AD&D', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '2000-05-30', 2, 'Normal', '2016-12-08 06:56:05'),
	(9, '0000009', 1, '1231', 'sodala', 'jaipur', 'British Columbia', 'United States', 'United States', '21313', 2, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '2000-05-30', 2, 'HIGH', '2016-12-08 06:57:12'),
	(10, '0000010', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'nn123a', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'Normal', '2016-12-08 07:00:35'),
	(11, '0000011', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'Normal', '2016-12-08 07:01:49'),
	(12, '0000012', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:02:41'),
	(13, '0000013', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:03:39'),
	(14, '0000014', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:03:57'),
	(15, '0000015', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:04:06'),
	(16, '0000016', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:04:49'),
	(17, '0000017', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:05:09'),
	(18, '0000018', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:05:31'),
	(19, '0000019', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:06:02'),
	(20, '0000020', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:07:40'),
	(21, '0000021', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:07:58'),
	(22, '0000022', 1, '', '', '', '', '', '', '', 1, 'AD&D', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:09:13'),
	(23, '0000023', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:10:31'),
	(24, '0000024', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:10:53'),
	(25, '0000025', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:11:11'),
	(26, '0000026', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:11:37'),
	(27, '0000027', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:12:55'),
	(28, '0000028', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:13:07'),
	(29, '0000029', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:13:39'),
	(30, '0000030', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:15:36'),
	(31, '0000031', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:16:06'),
	(32, '0000032', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:16:13'),
	(33, '0000033', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:18:37'),
	(34, '0000034', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:19:25'),
	(35, '0000035', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:19:43'),
	(36, '0000036', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:20:10'),
	(37, '0000037', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:20:29'),
	(38, '0000038', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:27:49'),
	(39, '0000039', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:28:33'),
	(40, '0000040', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:29:42'),
	(41, '0000041', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:30:13'),
	(42, '0000042', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:31:15'),
	(43, '0000043', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:31:48'),
	(44, '0000044', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:32:09'),
	(45, '0000045', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:32:18'),
	(46, '0000046', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:35:15'),
	(47, '0000047', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:35:39'),
	(48, '0000048', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:35:51'),
	(49, '0000049', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:35:59'),
	(50, '0000050', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:36:09'),
	(51, '0000051', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:36:14'),
	(52, '0000052', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:37:08'),
	(53, '0000053', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:37:53'),
	(54, '0000054', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:38:09'),
	(55, '0000055', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:38:20'),
	(56, '0000056', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:38:29'),
	(57, '0000057', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:39:05'),
	(58, '0000058', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:39:11'),
	(59, '0000059', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:39:46'),
	(60, '0000060', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:40:20'),
	(61, '0000061', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:40:30'),
	(62, '0000062', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:40:37'),
	(63, '0000063', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:40:46'),
	(64, '0000064', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:40:53'),
	(65, '0000065', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:41:09'),
	(66, '0000066', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:41:17'),
	(67, '0000067', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:41:48'),
	(68, '0000068', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:41:55'),
	(69, '0000069', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:42:14'),
	(70, '0000070', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:42:22'),
	(71, '0000071', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:42:30'),
	(72, '0000072', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:42:41'),
	(73, '0000073', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:42:48'),
	(74, '0000074', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:43:03'),
	(75, '0000075', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:54:02'),
	(76, '0000076', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:54:27'),
	(77, '0000077', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'N', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-08 07:54:56'),
	(78, '0000078', 1, '1231', 'sodala', 'jaipur', 'British Columbia', 'United States', 'Canada', '302014', 2, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '2000-05-30', 2, 'Normal', '2016-12-09 06:11:42'),
	(79, '0000079', 1, '1231', 'sodala', 'us', 'British Columbia', 'United States', 'United States', '21313', 5, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '2000-05-30', 2, 'HIGH', '2016-12-09 06:12:49'),
	(80, '0000080', 1, '1231', 'sodala', 'us', 'British Columbia', 'United States', 'United States', '21313', 5, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '2000-05-30', 2, 'HIGH', '2016-12-09 06:14:12'),
	(81, '0000081', 1, '1231', 'sodala', 'jaipur', 'British Columbia', 'United States', 'United States', '21313', 2, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '2000-05-30', 2, 'Normal', '2016-12-09 06:19:41'),
	(82, '0000082', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'Y', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-09 07:42:29'),
	(83, '0000083', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'Y', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-09 07:49:32'),
	(84, '0000084', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'Y', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-09 07:51:27'),
	(85, '0000085', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'Y', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-09 07:53:40'),
	(86, '0000086', 1, '', '', '', '', '', '', '', 1, 'Assistance Only', 'bhawani', '', '', '', '', '', '', 'Y', '', '', NULL, '0000-00-00', 2, 'HIGH', '2016-12-09 07:54:09'),
	(87, '0000087', 1, '1231', 'sodala', 'jaipur', 'British Columbia', 'United States', 'United States', '21313', 1, 'AD&D', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'N', '99098908', 'bhawani', NULL, '2000-05-30', 2, 'Normal', '2016-12-13 07:48:23'),
	(88, '0000088', 1, 'sdfdsfdsf', 'sodala', 'jaipur', 'British Columbia', 'United States', 'United States', '21313', 2, 'Assistance Only', 'bhawani', 'bb', '424242424', 'developer@brsoftech.com', 'Sister', 'test', 'sodala', 'Y', '99098908', '21231', '56465', '2000-05-30', 2, 'HIGH', '2016-12-14 09:38:54');
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
	(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', NULL, NULL, NULL, NULL, 1268889823, 1481717306, 1, 'Admin', 'istrator', NULL, '2132132132'),
	(2, '192.168.1.29', 'a@xx.com', '$2y$08$gnsbXPmHtU7SBQko94uf9.VVVzzFhd12fYK3n1FMx4lL8yDPzMvvm', NULL, 'a@xx.com', NULL, NULL, NULL, NULL, 1479881420, 1480055689, 0, 'nn123a', 'bb123', NULL, '123131'),
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
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
	(61, 1, 1),
	(62, 1, 2),
	(63, 1, 3),
	(64, 1, 5),
	(65, 1, 6),
	(66, 1, 7),
	(59, 2, 4),
	(60, 2, 7),
	(50, 5, 2);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
