--
-- Database: `claim`
--
CREATE TABLE `active` (
  `active_id` int NOT NULL,
  `user_id` int NOT NULL,
  `claim_id` int NOT NULL,
  `case_id` int NOT NULL,
  `plan_id` int NOT NULL,
  `type` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `query` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `api_login`
--

CREATE TABLE `api_login` (
  `api_id` varchar(64) NOT NULL,
  `token` varchar(32) NOT NULL,
  `policy` varchar(32) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `birthday` date NOT NULL,
  `ip` varchar(32) NOT NULL,
  `last_tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `api_login_try`
--

CREATE TABLE `api_login_try` (
  `try_id` int NOT NULL,
  `tm` bigint NOT NULL,
  `api_id` varchar(64) NOT NULL,
  `policy` varchar(32) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `case`
--

CREATE TABLE `case` (
  `id` int NOT NULL,
  `case_no` varchar(64) NOT NULL,
  `claim_no` varchar(64) NOT NULL,
  `created_by` int NOT NULL,
  `street_no` varchar(10) DEFAULT NULL,
  `street_name` varchar(30) DEFAULT NULL,
  `suite_number` varchar(16) NOT NULL,
  `city` varchar(40) DEFAULT NULL,
  `province` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `country2` varchar(40) DEFAULT NULL,
  `post_code` varchar(10) DEFAULT NULL,
  `assign_to` int NOT NULL DEFAULT '0' COMMENT 'this field is relaetd to follow up process',
  `reason` varchar(30) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `place_of_call` varchar(255) NOT NULL,
  `incident_date` date NOT NULL,
  `relations` varchar(40) DEFAULT NULL,
  `diagnosis` varchar(40) DEFAULT NULL,
  `treatment` varchar(40) DEFAULT NULL,
  `third_party_recovery` enum('Y','N') NOT NULL DEFAULT 'N',
  `medical_notes` text,
  `policy_no` varchar(20) DEFAULT NULL,
  `product_short` varchar(16) NOT NULL,
  `totaldays` int NOT NULL,
  `agent_id` int NOT NULL,
  `sum_insured` int NOT NULL DEFAULT '0',
  `policy_info` text,
  `departure_date` date NOT NULL,
  `insured_firstname` varchar(50) DEFAULT NULL,
  `insured_lastname` varchar(50) DEFAULT NULL,
  `insured_address` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(8) NOT NULL,
  `case_manager` int NOT NULL COMMENT 'This field is refer here to transfer case manager field',
  `init_manager` int NOT NULL,
  `init_reserve_amount` float NOT NULL,
  `reserve_amount` float DEFAULT NULL,
  `init_reserve_tm` datetime NOT NULL DEFAULT '1970-01-01 00:00:01',
  `reserve_update_tm` datetime NOT NULL DEFAULT '1970-01-01 00:00:01',
  `priority` varchar(10) NOT NULL,
  `status` enum('A','D','C') NOT NULL DEFAULT 'A' COMMENT 'C-closed, D-deactive, A-active, stand for case status active/inactive/close',
  `created` datetime NOT NULL,
  `doctor_first_name` varchar(128) NOT NULL,
  `doctor_last_name` varchar(128) NOT NULL,
  `doctor_country` varchar(128) NOT NULL,
  `doctor_province` varchar(128) NOT NULL,
  `doctor_address` varchar(255) NOT NULL,
  `doctor_city` varchar(128) NOT NULL,
  `doctor_post_code` varchar(64) NOT NULL,
  `doctor_phone` varchar(32) NOT NULL,
  `outpatient_provider` varchar(255) NOT NULL,
  `outpatient_federal_tax` varchar(128) NOT NULL,
  `outpatient_facility` varchar(255) NOT NULL,
  `outpatient_physician` varchar(255) NOT NULL,
  `outpatient_address1` varchar(255) NOT NULL,
  `outpatient_address2` varchar(255) NOT NULL,
  `outpatient_city` varchar(128) NOT NULL,
  `outpatient_province` varchar(128) NOT NULL,
  `outpatient_country` varchar(128) NOT NULL,
  `outpatient_post_code` varchar(64) NOT NULL,
  `outpatient_phone` varchar(32) NOT NULL,
  `outpatient_fax` varchar(32) NOT NULL,
  `addmission_date` date NOT NULL,
  `discharge_date` date NOT NULL,
  `room_number` varchar(32) NOT NULL,
  `account_number` varchar(64) NOT NULL,
  `hospital_charge` decimal(10,2) NOT NULL,
  `inpatient_currency` varchar(16) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `case_claim_master`
--

CREATE TABLE `case_claim_master` (
  `id` int NOT NULL,
  `name` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `claim`
--

CREATE TABLE `claim` (
  `id` int NOT NULL,
  `claim_no` varchar(64) NOT NULL,
  `eclaim_no` varchar(16) NOT NULL DEFAULT '',
  `assign_to` int NOT NULL DEFAULT '0',
  `claim_date` date DEFAULT NULL,
  `apply_date` date DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_by` int NOT NULL,
  `insured_first_name` varchar(45) DEFAULT NULL,
  `insured_last_name` varchar(30) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `personal_id` varchar(40) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `policy_no` varchar(40) DEFAULT NULL,
  `package` varchar(32) NOT NULL DEFAULT 'Medical',
  `totaldays` int NOT NULL,
  `agent_id` int NOT NULL,
  `reserve_amount` float NOT NULL DEFAULT '0',
  `sum_insured` int NOT NULL DEFAULT '0',
  `product_short` varchar(16) NOT NULL,
  `case_no` varchar(64) DEFAULT NULL,
  `policy_info` text,
  `school_name` varchar(100) DEFAULT NULL,
  `group_id` varchar(50) DEFAULT '0',
  `arrival_date` date DEFAULT NULL,
  `guardian_name` varchar(50) DEFAULT NULL,
  `guardian_phone` varchar(50) DEFAULT NULL,
  `suite_number` varchar(50) NOT NULL,
  `street_address` text,
  `city` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `post_code` varchar(15) NOT NULL DEFAULT 'N',
  `arrival_date_canada` date DEFAULT NULL,
  `contact_first_name` varchar(50) DEFAULT NULL,
  `contact_last_name` varchar(50) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(25) DEFAULT NULL,
  `cellular` varchar(20) DEFAULT NULL,
  `physician_name` varchar(100) DEFAULT NULL,
  `clinic_name` varchar(100) DEFAULT NULL,
  `physician_suite_number` varchar(50) NOT NULL,
  `physician_street_address` text NOT NULL,
  `physician_city` varchar(50) DEFAULT NULL,
  `physician_country` varchar(64) NOT NULL,
  `country` varchar(30) DEFAULT NULL,
  `physician_post_code` varchar(20) DEFAULT NULL,
  `physician_telephone` varchar(20) DEFAULT NULL,
  `physician_alt_telephone` varchar(20) DEFAULT NULL,
  `physician_name_canada` varchar(30) DEFAULT NULL,
  `clinic_name_canada` varchar(100) DEFAULT NULL,
  `physician_suite_number_canada` varchar(50) NOT NULL,
  `physician_street_address_canada` text,
  `physician_city_canada` varchar(50) DEFAULT NULL,
  `physician_post_code_canada` varchar(20) DEFAULT NULL,
  `physician_telephone_canada` varchar(20) DEFAULT NULL,
  `physician_alt_telephone_canada` varchar(20) DEFAULT NULL,
  `treatment_before` varchar(5) DEFAULT NULL,
  `travel_insurance_coverage_guardians` varchar(5) DEFAULT NULL,
  `other_insurance_coverage` varchar(5) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `employee_name` varchar(100) DEFAULT NULL,
  `employee_suite_number` varchar(50) NOT NULL,
  `employee_street_address` text,
  `employee_post_code` varchar(16) NOT NULL,
  `city_town` varchar(50) DEFAULT NULL,
  `country2` varchar(50) DEFAULT NULL,
  `employee_telephone` varchar(20) DEFAULT NULL,
  `medical_description` text,
  `date_symptoms` date DEFAULT NULL,
  `date_first_physician` date DEFAULT NULL,
  `medication_date_1` date DEFAULT NULL,
  `medication_1` varchar(50) DEFAULT NULL,
  `medication_date_2` date DEFAULT NULL,
  `medication_2` varchar(50) DEFAULT NULL,
  `medication_date_3` date DEFAULT NULL,
  `medication_3` varchar(50) DEFAULT NULL,
  `payment_type` varchar(20) DEFAULT NULL,
  `files` text,
  `status` varchar(20) NOT NULL DEFAULT 'A',
  `status2` varchar(16) NOT NULL DEFAULT 'Open',
  `is_complete` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'N- No, Y-Yes',
  `is_accepted` enum('N','Y') NOT NULL DEFAULT 'N',
  `reason` varchar(50) DEFAULT NULL,
  `denied_reason` varchar(50) NOT NULL,
  `notes` text NOT NULL,
  `diagnosis` varchar(255) NOT NULL,
  `priority` varchar(20) NOT NULL DEFAULT 'A',
  `created` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `exinfo_type` varchar(64) NOT NULL,
  `exinfo` text NOT NULL,
  `intnotes` text NOT NULL,
  `policy_note` text,
  `logs` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;

--
-- Triggers `claim`
--
DELIMITER $$
CREATE TRIGGER `claimStatusChange` AFTER UPDATE ON `claim` FOR EACH ROW BEGIN
 IF NEW.status != OLD.status THEN
  INSERT INTO claim_status_change (claim_id, status, update_time) values (NEW.id, NEW.status, NOW());
 END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `claim_status_change`
--

CREATE TABLE `claim_status_change` (
  `id` int NOT NULL,
  `claim_id` int NOT NULL,
  `status` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `update_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int NOT NULL,
  `name` varchar(64) NOT NULL,
  `short_code` varchar(10) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `order_by` int NOT NULL DEFAULT '1000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `name` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `orderby` int NOT NULL DEFAULT '100000',
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

-- --------------------------------------------------------

--
-- Table structure for table `currency_exchange`
--

CREATE TABLE `currency_exchange` (
  `name` char(3) NOT NULL,
  `dt` date NOT NULL,
  `rate` float NOT NULL,
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE `diagnosis` (
  `id` mediumint UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `eclaim`
--

CREATE TABLE `eclaim` (
  `id` int NOT NULL,
  `eclaim_no` varchar(64) DEFAULT '',
  `processed_by` int NOT NULL DEFAULT '0' COMMENT 'user id for procesed user',
  `claim_no` varchar(64) DEFAULT '',
  `case_no` varchar(16) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NULL DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `insured_first_name` varchar(45) DEFAULT '',
  `insured_last_name` varchar(30) DEFAULT '',
  `gender` varchar(6) DEFAULT '',
  `dob` date DEFAULT NULL,
  `policy_no` varchar(40) DEFAULT '',
  `product_short` varchar(16) NOT NULL,
  `school_name` varchar(100) DEFAULT '',
  `group_id` varchar(50) DEFAULT '',
  `arrival_date` date DEFAULT NULL,
  `guardian_name` varchar(50) DEFAULT '',
  `guardian_phone` varchar(50) DEFAULT '',
  `suite_number` varchar(50) NOT NULL DEFAULT '',
  `street_address` text,
  `city` varchar(50) DEFAULT '',
  `province` varchar(50) DEFAULT '',
  `telephone` varchar(30) DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `post_code` varchar(15) DEFAULT '',
  `arrival_date_canada` date DEFAULT NULL,
  `contact_first_name` varchar(50) DEFAULT '',
  `contact_last_name` varchar(50) DEFAULT '',
  `contact_email` varchar(100) DEFAULT '',
  `contact_phone` varchar(25) DEFAULT '',
  `cellular` varchar(20) DEFAULT '',
  `physician_name` varchar(100) DEFAULT '',
  `clinic_name` varchar(100) DEFAULT '',
  `physician_suite_number` varchar(50) NOT NULL DEFAULT '',
  `physician_street_address` text,
  `physician_city` varchar(50) DEFAULT '',
  `physician_country` varchar(64) DEFAULT '',
  `country` varchar(30) DEFAULT '',
  `physician_post_code` varchar(20) DEFAULT '',
  `physician_telephone` varchar(20) DEFAULT '',
  `physician_alt_telephone` varchar(20) DEFAULT '',
  `physician_name_canada` varchar(30) DEFAULT '',
  `clinic_name_canada` varchar(100) DEFAULT '',
  `physician_suite_number_canada` varchar(50) NOT NULL DEFAULT '',
  `physician_street_address_canada` text,
  `physician_city_canada` varchar(50) DEFAULT '',
  `physician_post_code_canada` varchar(20) DEFAULT '',
  `physician_telephone_canada` varchar(20) DEFAULT '',
  `physician_alt_telephone_canada` varchar(20) DEFAULT '',
  `treatment_before` varchar(5) DEFAULT '',
  `travel_insurance_coverage_guardians` varchar(5) DEFAULT '',
  `other_insurance_coverage` varchar(5) DEFAULT '',
  `full_name` varchar(100) DEFAULT '',
  `employee_name` varchar(100) DEFAULT '',
  `employee_suite_number` varchar(50) NOT NULL DEFAULT '',
  `employee_street_address` text,
  `employee_post_code` varchar(16) DEFAULT '',
  `city_town` varchar(50) DEFAULT '',
  `country2` varchar(50) DEFAULT '',
  `employee_telephone` varchar(20) DEFAULT '',
  `medical_description` text,
  `date_symptoms` date DEFAULT NULL,
  `date_first_physician` date DEFAULT NULL,
  `medication_date_1` date DEFAULT NULL,
  `medication_1` varchar(50) DEFAULT '',
  `medication_date_2` date DEFAULT NULL,
  `medication_2` varchar(50) DEFAULT '',
  `medication_date_3` date DEFAULT NULL,
  `medication_3` varchar(50) DEFAULT '',
  `payment_type` varchar(20) DEFAULT '',
  `reason` varchar(50) DEFAULT '',
  `notes` text,
  `diagnosis` text,
  `exinfo_type` varchar(64) DEFAULT '',
  `intnotes` text,
  `imgfile` text COMMENT 'json string for image list',
  `sign_name` varchar(64) DEFAULT '',
  `sign_image` text,
  `sign_image2` text,
  `payees_payment_type` varchar(32) DEFAULT '',
  `payees_payment_cheque_type` varchar(64) DEFAULT '',
  `payees_payee_name` varchar(64) DEFAULT '',
  `payees_address` text,
  `payees_city` varchar(64) DEFAULT '',
  `payees_province` varchar(128) DEFAULT '',
  `payees_country` varchar(128) DEFAULT '',
  `payees_postcode` varchar(16) DEFAULT '',
  `payees_email` varchar(128) DEFAULT NULL,
  `exinfo_depature_date` date DEFAULT NULL,
  `exinfo_return_date` date DEFAULT NULL,
  `exinfo_destination` text,
  `exinfo_other_medical_insurance` tinyint(1) NOT NULL DEFAULT '0',
  `exinfo_spouse_insurance` tinyint(1) NOT NULL DEFAULT '0',
  `exinfo_credit_card_insurance` tinyint(1) NOT NULL DEFAULT '0',
  `exinfo_group_insurance` tinyint(1) NOT NULL DEFAULT '0',
  `exinfo_other_insurance_name` varchar(128) DEFAULT '',
  `exinfo_other_insurance_policy` varchar(128) DEFAULT '',
  `exinfo_other_insurance_number` varchar(32) DEFAULT '',
  `exinfo_other_insurance_phone` varchar(16) DEFAULT '',
  `exinfo_spouse_insurance_name` varchar(128) DEFAULT '',
  `exinfo_spouse_insurance_policy` varchar(128) DEFAULT '',
  `exinfo_spouse_insurance_number` varchar(32) DEFAULT '',
  `exinfo_spouse_insurance_phone` varchar(16) DEFAULT '',
  `exinfo_spouse_name` varchar(64) DEFAULT '',
  `exinfo_spouse_dob` date DEFAULT NULL,
  `exinfo_credit_card_insurance_name` text,
  `exinfo_credit_card_number` varchar(16) DEFAULT '',
  `exinfo_credit_card_expire` varchar(8) DEFAULT '',
  `exinfo_credit_card_holder` varchar(128) DEFAULT '',
  `exinfo_group_insurance_company` text,
  `exinfo_group_insurance_policy` varchar(32) DEFAULT '',
  `exinfo_group_insurance_member` varchar(16) DEFAULT '',
  `exinfo_group_insurance_phone` varchar(16) DEFAULT '',
  `exinfo_loss_type` varchar(32) DEFAULT '',
  `exinfo_loss_describe` text,
  `exinfo_loss_date` date DEFAULT NULL,
  `exinfo_loss_report_to` varchar(8) DEFAULT '',
  `exinfo_loss_report_other` text,
  `expenses_claimed_service_description` text,
  `expenses_claimed_provider_name` text,
  `expenses_claimed_provider_address` text NOT NULL,
  `expenses_claimed_referencing_physician` text,
  `expenses_claimed_date_of_service` text,
  `expenses_claimed_amount_billed_org` decimal(10,2) NOT NULL DEFAULT '0.00',
  `expenses_claimed_currency` tinytext,
  `expenses_claimed_amount_client_paid_org` text,
  `expenses_claimed_amount_claimed_org` text,
  `expenses_claimed_other_reimbursed_amount` text,
  `exinfo_cancelled_date` date DEFAULT NULL,
  `exinfo_loss_reason` text,
  `exinfo_sickness` text,
  `exinfo_injury1_date` date DEFAULT NULL,
  `exinfo_physician_date` date DEFAULT NULL,
  `exinfo_injury_details` text,
  `exinfo_injury_date` date DEFAULT NULL,
  `exinfo_patient_name` text,
  `exinfo_death_date` date DEFAULT NULL,
  `exinfo_relation` text,
  `exinfo_death_describe` text,
  `exinfo_circumstances` text,
  `exinfo_occured_date` date DEFAULT NULL,
  `exinfo_other_reason` text,
  `exinfo_other_occurred_date` text,
  `exinfo_other_party_reimbursed_refunded` tinyint(1) NOT NULL DEFAULT '0',
  `exinfo_other_travel_insurance_explanation` text,
  `logs` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `eclaim_file`
--

CREATE TABLE `eclaim_file` (
  `id` int NOT NULL,
  `eclaim_id` int DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '',
  `path` varchar(255) DEFAULT '',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `expenses_claimed`
--

CREATE TABLE `expenses_claimed` (
  `id` int NOT NULL,
  `claim_id` int DEFAULT NULL,
  `created_by` int NOT NULL,
  `claim_no` varchar(50) DEFAULT NULL,
  `claim_item_no` varchar(50) DEFAULT NULL,
  `case_no` varchar(50) DEFAULT NULL,
  `claim_date` date DEFAULT NULL,
  `cellular` varchar(50) DEFAULT NULL,
  `invoice` varchar(50) DEFAULT NULL,
  `provider_name` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `provider_type` tinyint NOT NULL DEFAULT '0',
  `expenses_provider_id` int NOT NULL,
  `referencing_physician` varchar(50) DEFAULT NULL,
  `coverage_code` varchar(50) DEFAULT NULL,
  `icd10` varchar(20) NOT NULL,
  `diagnosis` varchar(50) DEFAULT NULL,
  `service_description` text,
  `date_of_service` date DEFAULT NULL,
  `amount_billed` decimal(20,2) DEFAULT '0.00',
  `amount_billed_org` decimal(20,2) NOT NULL DEFAULT '0.00',
  `amount_client_paid` decimal(20,2) DEFAULT '0.00',
  `amount_client_paid_org` decimal(20,2) NOT NULL DEFAULT '0.00',
  `pay_to` varchar(255) DEFAULT NULL,
  `reason` varchar(64) DEFAULT NULL,
  `reason_other` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `amount_claimed` decimal(20,2) DEFAULT '0.00',
  `amount_claimed_org` decimal(20,2) NOT NULL DEFAULT '0.00',
  `other_reimbursed_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amt_deductible` decimal(20,2) DEFAULT '0.00',
  `amt_insured` decimal(20,2) DEFAULT '0.00',
  `amt_received` decimal(20,2) DEFAULT '0.00',
  `amt_payable` decimal(20,2) DEFAULT '0.00',
  `amt_exceptional` decimal(20,2) DEFAULT '0.00',
  `currency` char(3) DEFAULT NULL,
  `currency_rate` float DEFAULT '0',
  `payee` int NOT NULL DEFAULT '0',
  `third_party_payee` int NOT NULL DEFAULT '0',
  `comment` text,
  `recovery_name` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `recovery_amt` float NOT NULL DEFAULT '0',
  `status` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `pay_date` date NOT NULL DEFAULT '1970-01-01',
  `cheque` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '',
  `finalize_date` date NOT NULL DEFAULT '1970-01-01',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Triggers `expenses_claimed`
--
DELIMITER $$
CREATE TRIGGER `insertIcd10` BEFORE INSERT ON `expenses_claimed` FOR EACH ROW BEGIN
 SET @var='Unknown';
 SELECT `code` FROM `diagnosis` WHERE `description`=NEW.diagnosis LIMIT 1 INTO @var;
 SET NEW.`icd10`=@var;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateIcd10` BEFORE UPDATE ON `expenses_claimed` FOR EACH ROW BEGIN
 IF NEW.diagnosis != OLD.diagnosis THEN
  SET @var='Unknown';
  SELECT `code` FROM `diagnosis` WHERE `description`=NEW.diagnosis LIMIT 1 INTO @var;
  SET NEW.`icd10`=@var;
 END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `expenses_provider`
--

CREATE TABLE `expenses_provider` (
  `id` int NOT NULL,
  `claim_id` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `name` varchar(128) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(64) NOT NULL,
  `province` varchar(64) NOT NULL,
  `country` varchar(64) NOT NULL,
  `postcode` varchar(16) NOT NULL,
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `intake_form`
--

CREATE TABLE `intake_form` (
  `id` int NOT NULL,
  `case_id` int NOT NULL COMMENT 'case_id stand for case or claim id, depends on "type" field ''CASE'' or ''CLAIM''',
  `created_by` int NOT NULL,
  `notes` text,
  `docs` text,
  `type` enum('CASE','CLAIM','CASE_CHANGE') NOT NULL DEFAULT 'CASE',
  `created` datetime NOT NULL,
  `phonefile` varchar(128) NOT NULL,
  `followup` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int NOT NULL,
  `claim_id` int DEFAULT NULL,
  `claim_item_id` int DEFAULT NULL,
  `payee` varchar(100) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `bank_name` varchar(50) DEFAULT NULL,
  `account` varchar(50) DEFAULT NULL,
  `to_val` float DEFAULT NULL,
  `from_val` float DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `maintain`
--

CREATE TABLE `maintain` (
  `maintain_id` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0: no ready, others ready to active, 1: in maitain (combain with start_time and end_time)',
  `active` tinyint NOT NULL DEFAULT '0' COMMENT '0: no, 1: yes maintain event is active',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `reason` text,
  `notes` varchar(255) DEFAULT NULL COMMENT 'For human read as notes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mytask`
--

CREATE TABLE `mytask` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `task_no` varchar(20) NOT NULL,
  `category` varchar(20) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time NOT NULL,
  `completion_date` date DEFAULT NULL,
  `type` enum('CLAIM','CASE') DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `user_type` varchar(20) DEFAULT NULL,
  `status` varchar(16) NOT NULL,
  `created` datetime DEFAULT NULL,
  `finished` tinyint(1) NOT NULL,
  `notes` text NOT NULL,
  `logs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payees`
--

CREATE TABLE `payees` (
  `id` int NOT NULL,
  `claim_id` int DEFAULT NULL,
  `payment_type` varchar(15) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `payee_name` varchar(50) DEFAULT NULL,
  `account_cheque` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(128) NOT NULL,
  `province` varchar(64) NOT NULL,
  `country` varchar(64) NOT NULL,
  `postcode` varchar(16) NOT NULL,
  `type` varchar(16) NOT NULL DEFAULT 'person' COMMENT 'person or company',
  `cheque` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_action`
--

CREATE TABLE `phone_action` (
  `phone_action_id` int NOT NULL,
  `agent` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_id` int NOT NULL,
  `active` varchar(16) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `stm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `etm` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `slength` int NOT NULL DEFAULT '0' COMMENT 'period in seconds',
  `processed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `phone_agent`
--

CREATE TABLE `phone_agent` (
  `phone_agent_id` int NOT NULL,
  `dt` varchar(16) NOT NULL,
  `user_id` int NOT NULL,
  `pause` int NOT NULL,
  `break` int NOT NULL,
  `incall` int NOT NULL,
  `outcall` int NOT NULL,
  `waiting` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_call`
--

CREATE TABLE `phone_call` (
  `id` int NOT NULL,
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_cron`
--

CREATE TABLE `phone_cron` (
  `phone_cron_id` int NOT NULL,
  `phone_id` varchar(64) NOT NULL,
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `src` varchar(255) NOT NULL,
  `dst` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_cron_last`
--

CREATE TABLE `phone_cron_last` (
  `dt` varchar(16) NOT NULL,
  `page` int NOT NULL,
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_records`
--

CREATE TABLE `phone_records` (
  `phone_id` varchar(64) NOT NULL,
  `queue` varchar(64) NOT NULL,
  `event_tm` timestamp NOT NULL DEFAULT '1970-01-01 05:00:00',
  `newcall` timestamp NOT NULL DEFAULT '1970-01-01 05:00:00',
  `answer` timestamp NOT NULL DEFAULT '1970-01-01 05:00:00',
  `hangup` timestamp NOT NULL DEFAULT '1970-01-01 05:00:00',
  `agent` varchar(64) NOT NULL,
  `user_id` int NOT NULL,
  `caller_id_number` varchar(32) NOT NULL,
  `direction` varchar(16) NOT NULL,
  `destination_number` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_ring`
--

CREATE TABLE `phone_ring` (
  `phone_id` varchar(64) NOT NULL,
  `event_tm` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `agent` varchar(64) NOT NULL,
  `user_id` int NOT NULL,
  `queue` varchar(32) NOT NULL,
  `caller_id_number` varchar(32) NOT NULL,
  `destination_number` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

CREATE TABLE `policies` (
  `policy_no` varchar(20) NOT NULL,
  `note` text NOT NULL,
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_short` varchar(16) NOT NULL COMMENT 'short name',
  `calculate` tinyint NOT NULL COMMENT '1 means has program to calculate premium',
  `commission` decimal(10,2) NOT NULL COMMENT '50 means 50%',
  `min_premium` decimal(10,2) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `commission_max_limit` int NOT NULL DEFAULT '100000',
  `commission_max_days` int NOT NULL DEFAULT '3650',
  `qoute_pre` varchar(8) NOT NULL,
  `plan_pre` varchar(8) NOT NULL,
  `up_insuer` varchar(255) NOT NULL COMMENT 'Original Product come from',
  `up_pay_rate` decimal(10,3) NOT NULL,
  `prepare_rate` decimal(10,2) NOT NULL,
  `merchent_id` varchar(64) NOT NULL,
  `apikey` varchar(64) NOT NULL,
  `currency` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE `provider` (
  `id` int NOT NULL,
  `status` varchar(16) NOT NULL DEFAULT 'Active',
  `name` varchar(100) DEFAULT NULL,
  `payeename` varchar(255) NOT NULL,
  `address` text,
  `city` varchar(128) NOT NULL,
  `province` varchar(128) NOT NULL,
  `country` varchar(128) NOT NULL,
  `postcode` varchar(16) DEFAULT NULL,
  `oaddress` varchar(128) NOT NULL,
  `ocity` varchar(64) NOT NULL,
  `oprovince` varchar(64) NOT NULL,
  `opostcode` varchar(16) NOT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `network_fee` decimal(10,2) NOT NULL,
  `contact_person` varchar(20) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ppo_codes` varchar(20) DEFAULT NULL,
  `services` varchar(200) DEFAULT NULL,
  `lat` float(11,8) DEFAULT NULL,
  `lng` float(11,8) DEFAULT NULL,
  `priority` tinyint(1) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `id` int NOT NULL,
  `country_id` int NOT NULL DEFAULT '0',
  `country_short_code` varchar(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `short_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `reason2s`
--

CREATE TABLE `reason2s` (
  `id` int NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `reasons`
--

CREATE TABLE `reasons` (
  `id` int NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `relations`
--

CREATE TABLE `relations` (
  `id` int NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int UNSIGNED NOT NULL,
  `employee_id` int UNSIGNED NOT NULL,
  `schedule` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `sphone` varchar(16) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `start_tm` datetime NOT NULL,
  `shour` tinyint NOT NULL,
  `hours` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL,
  `country_id` int DEFAULT '1',
  `code` varchar(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `id` int NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `description` longtext NOT NULL,
  `type` enum('claim','case','eac') DEFAULT NULL COMMENT '''claim-claim manager'',''case-case manager'',''emc-emc user''',
  `sname` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(1, 'Additional Information Requisition', '<html>\r\n   <body>\r\n		{otc_logo}\r\n		<p class=\"outer-text\">{current_date}</p>\r\n		<br />\r\n		<p><span class=\"outer-text\">{insured_name}</span><br />\r\n		<span class=\"outer-text\">{insured_address}</span><br />\r\n		<span class=\"outer-text\">{insured_address2}</span><br />\r\n		<span class=\"outer-text\">{insured_postcode}</span></p>\r\n\r\n		<p align=\"center\">Request for Additional Information</p>\r\n		<p>RE: Policy Number: {policy_no}</p>\r\n		<p>Case/Claim Number: {case_no}</p>\r\n		<p>Insured: <span class=\"outer-text\">{insured_name}</span></p>\r\n		<p>Coverage Period: {coverage_period}</p>\r\n		<p>Dear <span class=\"outer-text\">{pre_sex} {insured_lastname}</span>,</p>\r\n\r\n		<p class=\"outer-text area\">We acknowledge receipt of your {policy_full_name} claim. In order to assess your claim, please provide the following additional information:\r\n\r\n		 - Fully completed and signed claim form\r\n		 - Original itemized bills and receipts\r\n		 - Proof of arrival in Canada (copy of stamped passport)\r\n		 - Complete medical records, test results and referrals from your current medical providers\r\n		 - Complete medical records, test results and referrals from your home country\r\n		</p>\r\n\r\n		<p>Please submit the requested documents by <span class=\"outer-text\"></span></p>\r\n\r\n		<p>In order to expedite the adjudication of your claim, please ensure that all requested information <span class=\"outer-text\">is forwarded to the address shown below</span>. Upon receipt of the above information, your claim will be further reviewed.</p>\r\n\r\n		<p>Your prompt reply to the above will ensure that your claim is attended to with minimum delay. If you require further assistance or clarification, please contact <span class=\"outer-text\">905-707-3335</span>.</p>\r\n\r\n		<br/>\r\n		<p>Sincerely,</p>\r\n		<br/>\r\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\r\n		<p>Ontime Care Worldwide Inc.</p>   \r\n	</body>\r\n</html>', 'case', 'Additional');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(2, 'Additional Information Requisition', '<html>\r\n   <body>\r\n		{otc_logo}\r\n		<p class=\"outer-text\">{current_date}</p>\r\n		<br />\r\n		<p><span class=\"outer-text\">{insured_name}</span><br />\r\n		<span class=\"outer-text\">{insured_address}</span><br />\r\n		<span class=\"outer-text\">{insured_address2}</span><br />\r\n		<span class=\"outer-text\">{insured_postcode}</span></p>\r\n\r\n		<p align=\"center\">Request for Additional Information</p>\r\n		<p>RE: Policy Number: {policy_no}</p>\r\n		<p>Case/Claim Number: {claim_no} </p>\r\n		<p>Insured: <span class=\"outer-text\">{insured_name}</span> </p>\r\n		<p>Coverage Period: {coverage_period}</p>\r\n		<p>Dear <span class=\"outer-text\">{pre_sex} {insured_lastname}</span>,</p>\r\n\r\n		<p class=\"outer-text area\">We acknowledge receipt of your {policy_full_name} claim. In order to assess your claim, please provide the following additional information:\r\n\r\n		 - Fully completed and signed claim form\r\n		 - Original itemized bills and receipts\r\n		 - Proof of arrival in Canada (copy of stamped passport)\r\n		 - Complete medical records, test results and referrals from your current medical providers\r\n		 - Complete medical records, test results and referrals from your home country\r\n		</p>\r\n\r\n		<p>Please submit the requested documents by <span class=\"outer-text\"></span></p>\r\n\r\n		<p>In order to expedite the adjudication of your claim, please ensure that all requested information <span class=\"outer-text\">is forwarded to the address shown below</span>. Upon receipt of the above information, your claim will be further reviewed.</p>\r\n\r\n		<p>Your prompt reply to the above will ensure that your claim is attended to with minimum delay. If you require further assistance or clarification, please contact <span class=\"outer-text\">905-707-3335</span>.</p>\r\n\r\n		<br/>\r\n		<p>Sincerely,</p>\r\n		<br/>\r\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\r\n		<p>Ontime Care Worldwide Inc.</p>   \r\n	</body>\r\n</html>', 'claim', 'Additional');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(3, 'Appeal Response', '<html>\n   <body>\n		{otc_logo}\n		<p class=\"outer-text\">{current_date}</p>\n		<br />\n		<p><span class=\"outer-text\">{insured_name}</span><br />\n		<span class=\"outer-text\">{insured_address}</span><br />\n		<span class=\"outer-text\">{insured_address2}</span><br />\n		<span class=\"outer-text\">{insured_postcode}</span></p>\n\n		<p align=\"center\">Appeal Response</p>\n		<p>\n		RE: Policy Number: {policy_no}<br />\n		Case/Claim Number: <span class=\"outer-text\">{case_no}</span> <br />\n		Insured: <span class=\"outer-text\">{insured_name}</span> <br />\n		Coverage Period: {coverage_period}\n		</p>\n		<br/>\n		<p>Dear <span class=\"outer-text\">{pre_sex} {insured_lastname}</span>,</p>\n\n		<p>Thank you for your patience during the process of reviewing your appeal regarding your {policy_full_name} claim. We have undertaken a thorough review of your claim together with all the supporting documents, including the additional information provided.</p>\n\n		<p class=\"outer-text area\"></p>\n\n		<br/>\n		<p>Given the above, we are maintaining our initial decision of denial. We regret the outcome of this review was not more favorable. Should you have any questions, please do not hesitate to contact us at 905-707-3335.<i class=\"fa fa-remove template_item_remove\" onClick=\'template_item_remove_us()\'></i></p>\n\n		<p>Given the above, we are overturning our initial decision of denial. Please see attached explanation of benefits and reimbursement cheque. Should you have any questions, please do not hesitate to contact us at 905-707-3335<i class=\"fa fa-remove template_item_remove\" onClick=\'template_item_remove_us()\'></i></p>\n\n		<br/>\n		<p>Sincerely,</p>\n		<br/>\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\n		<p>Ontime Care Worldwide Inc.</p>   \n	</body>\n<script>\nfunction template_item_remove_us(e) {\n	e = e || window.event;\n    var targ = e.target || e.srcElement;\n\n	var mynode = targ.parentNode;\n	mynode.innerHTML = \'\';\n\n	$(\'.template_item_remove\').remove();\n}\n</script>\n</html>', 'case', 'Appeal');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(4, 'Appeal Response', '<html>\n   <body>\n		{otc_logo}\n		<p class=\"outer-text\">{current_date}</p>\n		<br />\n		<p><span class=\"outer-text\">{insured_name}</span><br />\n		<span class=\"outer-text\">{insured_address}</span><br />\n		<span class=\"outer-text\">{insured_address2}</span><br />\n		<span class=\"outer-text\">{insured_postcode}</span></p>\n\n		<p align=\"center\">Appeal Response</p>\n		<p>\n		RE: Policy Number: {policy_no}<br />\n		Case/Claim Number: <span class=\"outer-text\">{claim_no}</span><br />\n		Insured: <span class=\"outer-text\">{insured_name}</span> <br />\n		Coverage Period: {coverage_period}\n		</p>\n		<br/>\n		<p>Dear <span class=\"outer-text\">{pre_sex} {insured_lastname}</span>,</p>\n\n		<p>Thank you for your patience during the process of reviewing your appeal regarding your {policy_full_name} claim. We have undertaken a thorough review of your claim together with all the supporting documents, including the additional information provided.</p>\n\n		<p class=\"outer-text area\"></p>\n\n		<br/>\n		<p>Given the above, we are maintaining our initial decision of denial. We regret the outcome of this review was not more favorable. Should you have any questions, please do not hesitate to contact us at 905-707-3335.<i class=\"fa fa-remove template_item_remove\" onClick=\'template_item_remove_us()\'></i></p>\n\n		<p>Given the above, we are overturning our initial decision of denial. Please see attached explanation of benefits and reimbursement cheque. Should you have any questions, please do not hesitate to contact us at 905-707-3335<i class=\"fa fa-remove template_item_remove\" onClick=\'template_item_remove_us()\'></i></p>\n\n		<br/>\n		<p>Sincerely,</p>\n		<br/>\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\n		<p>Ontime Care Worldwide Inc.</p>   \n	</body>\n<script>\nfunction template_item_remove_us(e) {\n	e = e || window.event;\n    var targ = e.target || e.srcElement;\n\n	var mynode = targ.parentNode;\n	mynode.innerHTML = \'\';\n\n	$(\'.template_item_remove\').remove();\n}\n</script>\n</html>', 'claim', 'Appeal');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(5, 'Claim Closure Notice', '<html>\r\n   <body>\r\n		{otc_logo}\r\n		<p class=\"outer-text\">{current_date}</p>\r\n		<br />\r\n		<p><span class=\"outer-text\">{insured_name}</span><br />\r\n		<span class=\"outer-text\">{insured_address}</span><br />\r\n		<span class=\"outer-text\">{insured_address2}</span><br />\r\n		<span class=\"outer-text\">{insured_postcode}</span></p>\r\n\r\n		<p align=\"center\">Letter of Claim Closure Notice</p>\r\n		<p>\r\n		RE: Policy Number: {policy_no}<br />\r\n		Claim Number: {claim_no} <br />\r\n		<p>Insured Name: {insured_name} </p>\r\n		Coverage Period: {coverage_period}\r\n		</p>\r\n		<br/>\r\n		<p>Dear <span class=\"outer-text\">{pre_sex} {insured_lastname}</span>,</p>\r\n\r\n		<p>Our record indicates that you have opened a claim under your JF <B>{policy_full_name}</B>. <span class=\"outer-text area\">On , we sent you a letter requesting additional information needed to review your claim and have not yet received a response. Accordingly, we have now closed your claim file.</span></p>\r\n		\r\n		<p>Please note, however, that should the requested information be provided by <span class=\"outer-text\"></span>, we will re-open your claim to complete our review.</p>\r\n		\r\n		<p>Should you have any questions in this matter, you may call us at <span class=\"outer-text\">905-707-3335</span> or e-mail to <span class=\"outer-text\">general@otcww.com</span>.</p>\r\n\r\n		<br/>\r\n		<p>Sincerely,</p>\r\n		<br/>\r\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\r\n		<p>Ontime Care Worldwide Inc.</p>\r\n   </body>\r\n</html>', 'claim', 'Closure');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(6, 'Ongoing Care Notice', '<html>\r\n      <body>\r\n		{otc_logo}\r\n		<p class=\"outer-text\">{current_date}</p>\r\n		<br/>\r\n		<p><span class=\"outer-text\">{insured_name}</span><br />\r\n		<span class=\"outer-text\">{insured_address}</span><br />\r\n		<span class=\"outer-text\">{insured_address2}</span><br />\r\n		<span class=\"outer-text\">{insured_postcode}</span></p>\r\n\r\n		<p align=\"center\">Letter of Ongoing Care</p>\r\n		<p>\r\n		RE: Policy Number: {policy_no}<br />\r\n		Case/Calim Number: <span class=\"outer-text\">{case_no}</span> <br />\r\n		Insured: <span class=\"outer-text\">{insured_name}</span> <br />\r\n		Coverage Period: {coverage_period}\r\n		</p>\r\n		<br/>\r\n		<p>Dear <span class=\"outer-text\">{pre_sex} {insured_lastname}</span>,</p>\r\n		<br/>\r\n\r\n		<p>I am writing to confirm that your JF <B>{policy_full_name}</B> will not cover you for any further medical services rendered in relation to \r\n		<span class=\"outer-text area\">stabbing or any related conditions.\r\nsince we consider that your medical emergency for these conditions ended.  Ongoing care exclusion applies after the initial treatment is over.</span></p>\r\n\r\n		<br/>\r\n		<p>Please find the following eligibility requirements and exclusions in our policy wording:</p>\r\n\r\n		<p class=\"outer-text\">3. Limitation of Benefits</p>\r\n\r\n		<p class=\"outer-text area\">Once you are deemed medically stable to return to your country of origin (with or without a medical escort) in the opinion of Ontime Care or by virtue of discharge from hospital, your emergency is considered to have ended, whereupon any further consultation, treatment, recurrence or complication related to the emergency will no longer be eligible for coverage under this policy.</p>\r\n\r\n		<p>Your prompt attention is appreciated to ensure the processing of your case. Should you have any questions, please do not hesitate to contact us at <span class=\"outer-text\">905-707-9555</span> or toll free at 1-888-988-3268.</p>\r\n\r\n		<br/>\r\n		<p>Sincerely,</p>\r\n		<br/>\r\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\r\n		<p>Ontime Care Worldwide Inc.</p>\r\n   </body>\r\n</html>', 'case', 'OngoingCare');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(7, 'Ongoing Care Notice', '<html>\r\n      <body>\r\n		{otc_logo}\r\n		<p class=\"outer-text\">{current_date}</p>\r\n		<br/>\r\n		<p><span class=\"outer-text\">{insured_name}</span><br />\r\n		<span class=\"outer-text\">{insured_address}</span><br />\r\n		<span class=\"outer-text\">{insured_address2}</span><br />\r\n		<span class=\"outer-text\">{insured_postcode}</span></p>\r\n\r\n		<p align=\"center\">Letter of Ongoing Care</p>\r\n		<p>\r\n		RE: Policy Number: {policy_no}<br />\r\n		Case/Claim Number: <span class=\"outer-text\">{claim_no}</span> <br />\r\n		Insured: <span class=\"outer-text\">{insured_name}</span> <br />\r\n		Coverage Period: {coverage_period}\r\n		</p>\r\n		<br/>\r\n		<p>Dear <span class=\"outer-text\">{pre_sex} {insured_lastname}</span>,</p>\r\n		<br/>\r\n\r\n		<p>I am writing to confirm that your JF <B>{policy_full_name}</B> Policy will not cover you for any further medical services rendered in relation to <span class=\"outer-text area\">stabbing or any related conditions. \r\nsince we consider that your medical emergency for these conditions ended.  Ongoing care exclusion applies after the initial treatment is over.</span></p>\r\n\r\n		<p>Please find the following eligibility requirements and exclusions in our policy wording:</p>\r\n		<br/>\r\n\r\n		<p class=\"outer-text\">3. Limitation of Benefits</p>\r\n\r\n		<p><span class=\"outer-text area\">Once you are deemed medically stable to return to your country of origin (with or without a medical escort) in the opinion of Ontime Care or by virtue of discharge from hospital, your emergency is considered to have ended, whereupon any further consultation, treatment, recurrence or complication related to the emergency will no longer be eligible for coverage under this policy.</span></p>\r\n\r\n		<p>Please note that this does not alter your coverage for emergency treatment that you have already received, nor for any unrelated acute illness or injury. This claim is reviewed without prejudice.</p>\r\n\r\n		<p>Your prompt attention is appreciated to ensure the processing of your case. Should you have any questions, please do not hesitate to contact us at <span class=\"outer-text\">905-707-9555</span> or toll free at <span class=\"outer-text\">1-888-988-3268</span>.</p>\r\n\r\n		<br/>\r\n		<p>Sincerely,</p>\r\n		<br/>\r\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\r\n		<p>Ontime Care Worldwide Inc.</p>\r\n   </body>\r\n</html>', 'claim', 'OngoingCare');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(8, 'Co-ordination of Benefits', '<html>\n      <body>\n		{otc_logo}\n		<p class=\"outer-text\">{current_date}</p>\n		<br />\n		<p><span class=\"outer-text\">{insured_name}</span><br />\n		<span class=\"outer-text\">{insured_address}</span><br />\n		<span class=\"outer-text\">{insured_address2}</span><br />\n		<span class=\"outer-text\">{insured_postcode}</span></p>\n\n		<p align=\"center\">Letter of Co-ordination of Benefits</p>\n		<p>\n		RE: Policy Number: {policy_no}<br />\n		Case/Claim Number: <span class=\"outer-text\">{claim_no}</span> <br />\n		Insured: <span class=\"outer-text\">{insured_name}</span> <br />\n		Coverage Period: {coverage_period}\n		</p>\n		<br/>\n		<p>Dear <span class=\"outer-text\">{pre_sex} {insured_lastname}</span>,</p>\n\n		<p>We acknowledge receipt of your {policy_full_name} claim. <span class=\"outer-text area\">As per your policy, your visitor medical plan is a secondary payer plan when an accident occurs. Please find the following provision in the policy wording:  </span></p>\n\n		<p class=\"outer-text area\">Section X General Provisions\n\n2. Other Insurance\n\nThis insurance is a second payer plan. For any loss or damage insured by, or for any claim payable under any other liability, group or individual basic or extended health insurance plan, or contracts including any private or provincial or territorial auto insurance plan providing hospital, medical, or therapeutic coverage, or any other insurance in force concurrently herewith, amounts payable hereunder are limited to those covered benefits incurred outside your country of origin that are in excess of the amounts for which you are insured under such other coverage.</p>\n\n		<br />\n		<p class=\"outer-text area\">We advise that you contact your auto insurance company to open a claim. If the claim is denied, you may then submit your claim to Ontime Care Worldwide Inc. and include a denial letter from your other insurance, original receipts, medical records and doctor’s notes. Kindly make copies of the documents for your records.</p>\n\n		<p>Your prompt attention is appreciated to ensure the processing of your case. Should you have any questions, please do not hesitate to contact us at <span class=\"outer-text\">905-707-9555</span> or toll free at <span class=\"outer-text\">1-888-988-3268</span></p>\n\n		<br/>\n		<p>Sincerely,</p>\n		<br/>\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\n		<p>Ontime Care Worldwide Inc.</p>\n   </body>\n</html>', 'claim', 'COB');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(9, 'Denial Notice (Individual)', '<html>\n   <body>\n		{otc_logo}\n		<p class=\"outer-text\">{current_date}</p>\n		<br/>\n		<p><span class=\"outer-text\">{insured_name}</span><br />\n		<span class=\"outer-text\">{insured_address}</span><br />\n		<span class=\"outer-text\">{insured_address2}</span><br />\n		<span class=\"outer-text\">{insured_postcode}</span></p>\n\n		<p align=\"center\">Letter of Denial Notice</p>\n		<p>\n		RE: Policy Number: {policy_no}<br />\n		Case/Claim Number: <span class=\"outer-text\">{claim_no}</span> <br />\n		Insured: <span class=\"outer-text\">{insured_name}</span> <br />\n		Coverage Period: {coverage_period}\n		</p>\n		<br/>\n		<p>Dear <span class=\"outer-text\">{pre_sex} {insured_lastname}</span>,</p>\n		<hr />\n		\n		<p>We acknowledge receipt of your JF <B>{policy_full_name}</B> claim.</p>\n		<br/>\n		<p>As you will find in the policy wording, eligible expenses for reimbursement do not include coverage for:<i class=\"fa fa-remove template_item_remove\" onClick=\'template_item_remove_us()\'></i></p>\n\n		<p>As you will find in the policy wording, this claim is not eligible for reimbursement as it does not meet the condition of benefit listed below:<i class=\"fa fa-remove template_item_remove\" onClick=\'template_item_remove_us()\'></i></p>\n\n		<p class=\"outer-text area\"></p>\n		\n		<br/>\n		<p><span class=\"outer-text area\">As such, we are unable to provide payment for the expenses that you incurred as your symptoms manifested during the waiting period. If you have any questions, please contact us at 905-707-3335</span></p>\n\n		<br/>\n		<p>Sincerely,</p>\n		<br/>\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\n		<p>Ontime Care Worldwide Inc.</p>\n<script>\nfunction template_item_remove_us(e) {\n	e = e || window.event;\n    var targ = e.target || e.srcElement;\n\n	var mynode = targ.parentNode;\n	mynode.innerHTML = \'\';\n\n	$(\'.template_item_remove\').remove();\n}\n</script>\n   </body>\n</html>', 'claim', 'Denial');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(10, 'Denial Notice (Medical provider)', '<html>\n      <body>\n		{otc_logo}\n		<p class=\"outer-text\">{current_date}</p>\n		<br />\n		<p><span class=\"outer-text\">{medical_privider_name}</span><br />\n		<span class=\"outer-text\">{medical_privider_address}</span><br />\n		<span class=\"outer-text\">{medical_privider_address2}</span><br />\n		<span class=\"outer-text\">{medical_privider_postcode}</span></p>\n\n		<p align=\"center\">Letter of Denial Notice</p>\n		<p>\n		RE: Policy Number: {policy_no}<br />\n		Case/Claim Number: <span class=\"outer-text\">{claim_no}</span> <br />\n		Insured: <span class=\"outer-text\">{insured_name}</span> <br />\n		Coverage Period: {coverage_period}\n		</p>\n		<br />\n\n		<p>To whom it may concern,</p>\n		<hr />\n\n		<p>After completing a thorough review of the claim submitted for the above insured, we have come to a decision that the claim is to be denied. <span class=\"outer-text area\">The reasoning for the decision is due to the fact that </span></p>\n\n		<p>Kindly send the total medical expenses directly to the patient as we cannot honour the claim. If you require any further information or details, please do not hesitate to contact us at <span class=\"outer-text\">905-707-3335</span>.</p>\n\n		<br/>\n		<p>Sincerely,</p>\n		<br/>\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\n		<p>Ontime Care Worldwide Inc.</p>\n   </body>\n</html>', 'claim', 'Denial');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(11, 'Explanation of Benefit', '<html>\n   <body>\n        {otc_logo}\n        <p class=\"outer-text\">{current_date}</p>\n        <br />\n        <p><span class=\"outer-text\">{payee_name}</span><br />\n        <span class=\"outer-text\">{payee_address1}</span><br />\n        <span class=\"outer-text\">{payee_address2}</span><br />\n        <span class=\"outer-text\">{payee_postcode}</span></p>\n\n        <p align=\"center\">Letter of Explanation of Benefit</p>\n        <p>\n        Policy Number: {policy_no}<br/>\n        Case/Claim Number: {claim_no}<br />\n        Insured: <span class=\"outer-text\">{insured_name}</span> <br /> \n        Coverage Period: <span class=\"outer-text\">{coverage_period}</span>\n        </p>\n\n        <p>To whom it may concern,</p>\n        <p>The following is our Explanation of Benefits detailing the expenses submitted as a claim under this policy. </p>\n\n        <div class=\"claim-items\">\n            <table style=\"margin-bottom: 14px;\" width=\"100%\" border=\"1\">\n                <thead>\n                    <tr>\n                        <th>Service Description</th>\n                        <th>Date of Service</th>\n                        <th>Claim Amount</th>\n                        <th>Payable Amount</th>\n                        <th>Claim Notes</th>\n                    </tr>\n                </thead>\n                <tbody>\n                    <tr>\n                        <td></td><td></td><td></td><td></td><td></td>\n                    </tr>\n                    <tr>\n                        <td></td><th>Totals:</th><td></td><td></td><td></td>\n                    </tr>\n                </tbody>\n            </table>\n        </div>\n\n        <p>Should you have any questions in this matter, you may call us at <span class=\"outer-text\">905-707-1512</span> or toll free at <span class=\"outer-text\">1-877-832-5541</span></p>\n        <p>This claim is paid on a \'without prejudice\' basis. Additional information may be required for further claims.</p>\n\n        <br/>\n        <p>Sincerely,</p>\n        <br/>\n        <p>For and on behalf of</p>\n        <p><span class=\"outer-text\">Authorized Representative</span></p>\n        <p>Ontime Care Worldwide Inc.</p>\n   </body>\n</html>', 'claim', 'EOB');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(12, 'Policy Cancelation Notice', '<html>\n   \n   <body>\n		{otc_logo}\n		<p class=\"outer-text\">{current_date}</p>\n		<p class=\"outer-text\">{insured_name}</p>\n		<p class=\"outer-text\">{insured_address}</p>\n\n		<p align=\"center\">Letter of Co-ordination of Benefits </p>\n		<p>Dear {insured_lastname},</p>\n		<p>Re: Policy Number: {policy_no}, Case Number: <span class=\"outer-text\">{case_no}</span> <br/> Coverage Period: <span class=\"outer-text\">{coverage_period}</span></p>\n\n		<p>We acknowledge receipt of your <span class=\"select-product\">JF Royal Visitor Medical Insurance case</span> underwritten by <span class=\"outer-text\">Berkley Canada</span>. As per our conversation, your visitor medical plan is a secondary payer plan when an accident occurs. Please find the following provision in the policy wording:</p>\n\n		<p>Please find the following eligibility requirements and exclusion in our policy wording:</p>\n\n\n		<p class=\"outer-text area\">2. Other Insurance <br/>\n\n		This insurance is a second payer plan. For any loss or damage insured by, or for any claim payable under any other liability, group or individual basic or extended health insurance plan, or contracts including any private or provincial or territorial auto insurance plan providing hospital, medical, or therapeutic coverage, or any other insurance in force concurrently herewith, amounts payable hereunder are limited to those covered benefits incurred outside your country of origin that are in excess of the amounts for which you are insured under such other coverage.</p>\n\n		<p>Your prompt attention is appreciated to ensure the processing of your case. Should you have any questions, please do not hesitate to contact us at <span class=\"outer-text\">905-707-9555</span> or toll free at <span class=\"outer-text\">1-888-988-3268</span>.</p>\n		\n		<p>For and on behalf of<br/>Ontime Care Worldwide</p>\n		<p><span class=\"outer-text\">{casemanager_name}</span><br/>Case Manager</p>\n   </body>\n</html>', 'case', '');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(13, 'Release of Medical Records Notice (Medical provider)', '<html>\n    <body>\n		{otc_logo}\n		<p class=\"outer-text\">{current_date}</p>\n		<br />\n		<p><span class=\"outer-text\">{medical_privider_name}</span><br />\n		<span class=\"outer-text\">{medical_privider_address}</span><br />\n		<span class=\"outer-text\">{medical_privider_address2}</span><br />\n		<span class=\"outer-text\">{medical_privider_postcode}</span></p>\n\n		<p align=\"center\">Release of Medical Records Request</p>\n		<p>\n		RE: Policy Number: {policy_no}<br />\n		Case/Claim Number: <span class=\"outer-text\">{case_no}</span> <br />\n		Insured: <span class=\"outer-text\">{insured_name}</span> <br />\n		Coverage Period: {coverage_period}\n		</p>\n		<hr />\n\n		<p><span class=\"outer-text\">To whom it may concern</span>:</p>\n		<br />\n		<p class=\"outer-text area\" >Ontime Care Worldwide Inc. is the plan administrator for the above insured with a {policy_full_name}. In order to process the case, Ontime Care is obliged to collect and retain certain personal and/or health information about this patient in connection with their insurance coverage. This information will be used only to assess and determine if the claim is payable and will be handled in accordance with the appropriate privacy legislation.\n\n		Attached please find the insured’s completed Consent to Release Information Form providing the necessary authorization and consent. Accordingly, we ask that you provide us with the requested medical records by fax to: xxxxxxx</p>\n\n		<br />\n		<p>Should you have any questions in this matter, you may call us at <span class=\"outer-text\">905-707-3335</span>. Thank you for your co-operation in this matter.</p>\n\n		<br/>\n		<p>Sincerely,</p>\n		<br/>\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\n		<p>Ontime Care Worldwide Inc.</p>\n	</body>\n</html>', 'case', 'ReleaseMR');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(14, 'Repatriation Notice', '<html>\n   <body>\n		{otc_logo}\n		<p class=\"outer-text\">{current_date}</p>\n		<br/>\n		<p><span class=\"outer-text\">{insured_name}</span><br />\n		<span class=\"outer-text\">{insured_address}</span><br />\n		<span class=\"outer-text\">{insured_address2}</span><br />\n		<span class=\"outer-text\">{insured_postcode}</span></p>\n\n		<p align=\"center\">Repatriation Notice </p>\n		<p>\n		RE: Policy Number: <span class=\"outer-text\">{policy_no}</span><br />\n		Case/Claim Number: <span class=\"outer-text\">{case_no}</span> <br />\n		Insured: <span class=\"outer-text\">{insured_name}</span> <br />\n		Coverage Period: <span class=\"outer-text\">{coverage_period}</span>\n		</p>\n		<br/>\n\n		<p>Dear <span class=\"outer-text\">{pre_sex} {insured_lastname}</span>,</p>\n		<br/>\n		<p class=\"outer-text area\">This letter serves as your official notification that Ontime Care Worldwide Inc., on behalf of the insurer is offering a one-way economy ticket to your country of origin where you can seek the necessary medical treatment. We ask you to inform us of your decision as soon as possible. If the repatriation offer is accepted, please provide a fit to travel document signed by your treating physician. If you choose to decline the offer, kindly note that the insurer be released from any further liability</p>\n\n		<p class=\"outer-text area\">Please find the following provisions in the policy wording:\n\n		7. Transfer or Medical Repatriation\n		During an emergency (whether prior to admission, during a covered hospitalization or after your release from hospital), the Assistance Company reserves the right to:\n		a) transfer you to one of its preferred health care providers, and/or\n		b) return you to your country of origin, for medical treatment of your sickness or injury without danger to your life or health. If you choose to decline the transfer or return when declared medically stable by the Assistance Company, the Insurer will be released from any liability for expenses incurred for such sickness or injury after the proposed date of transfer or return. The Assistance Company will make every provision for your medical condition when choosing and arranging the mode of	your transfer or return and, in the case of a transfer, when choosing the hospital. \n\n		3. Limitation of Benefits:\n		Once you are deemed medically stable to return to your country of origin in this case to Canada (with or without a medical escort) in the opinion of Ontime Care Worldwide Inc. or by virtue of discharge from hospital, your emergency is considered to have ended, whereupon any further consultation, treatment, recurrence or complication related to the emergency will no longer be eligible for coverage under this policy.\n		</p>\n\n		\n		<p>Should you have any questions, please do not hesitate to contact us at <span class=\"outer-text\">905-707-9555</span> or toll free at <span class=\"outer-text\">1-888-988-3268</span>.</p>\n		\n		<br/>\n		<p>Sincerely,</p>\n		<br/>\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\n		<p>Ontime Care Worldwide Inc.</p>\n   </body>\n</html>', 'case', '');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(15, 'Release of Medical Records Notice (Medical provider)', '<html>\n    <body>\n		{otc_logo}\n		<p class=\"outer-text\">{current_date}</p>\n		<br />\n		<p><span class=\"outer-text\">{medical_privider_name}</span><br />\n		<span class=\"outer-text\">{medical_privider_address}</span><br />\n		<span class=\"outer-text\">{medical_privider_address2}</span><br />\n		<span class=\"outer-text\">{medical_privider_postcode}</span></p>\n\n		<p align=\"center\">Release of Medical Records Request</p>\n		<p>\n		RE: Policy Number: {policy_no}<br />\n		Case/Claim Number: <span class=\"outer-text\">{claim_no}</span> <br />\n		Insured: <span class=\"outer-text\">{insured_name}</span> <br />\n		Coverage Period: {coverage_period}\n		</p>\n		<hr />\n\n		<p><span class=\"outer-text\">To whom it may concern</span>:</p>\n		<br />\n		<p class=\"outer-text area\" >Ontime Care Worldwide Inc. is the plan administrator for the above insured with a {policy_full_name}. In order to process the case, Ontime Care is obliged to collect and retain certain personal and/or health information about this patient in connection with their insurance coverage. This information will be used only to assess and determine if the claim is payable and will be handled in accordance with the appropriate privacy legislation.\n\n		Attached please find the insured’s completed Consent to Release Information Form providing the necessary authorization and consent. Accordingly, we ask that you provide us with the requested medical records by fax to: xxxxxxx</p>\n\n		<br />\n		<p>Should you have any questions in this matter, you may call us at <span class=\"outer-text\">905-707-3335</span>. Thank you for your co-operation in this matter.</p>\n\n		<br/>\n		<p>Sincerely,</p>\n		<br/>\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\n		<p>Ontime Care Worldwide Inc.</p>\n	</body>\n</html>', 'claim', 'ReleaseMR');
INSERT INTO `template` (`id`, `name`, `description`, `type`, `sname`) VALUES(16, 'Co-ordination of Benefits', '<html>\n      <body>\n		{otc_logo}\n		<p class=\"outer-text\">{current_date}</p>\n		<br />\n		<p><span class=\"outer-text\">{insured_name}</span><br />\n		<span class=\"outer-text\">{insured_address}</span><br />\n		<span class=\"outer-text\">{insured_address2}</span><br />\n		<span class=\"outer-text\">{insured_postcode}</span></p>\n\n		<p align=\"center\">Letter of Co-ordination of Benefits</p>\n		<p>\n		RE: Policy Number: {policy_no}<br />\n		Case/Claim Number: <span class=\"outer-text\">{claim_no}</span> <br />\n		Insured: <span class=\"outer-text\">{insured_name}</span> <br />\n		Coverage Period: {coverage_period}\n		</p>\n		<br/>\n		<p>Dear <span class=\"outer-text\">{pre_sex} {insured_lastname}</span>,</p>\n\n		<p>We acknowledge receipt of your {policy_full_name} case. <span class=\"outer-text area\">As per your policy, your visitor medical plan is a secondary payer plan when an accident occurs. Please find the following provision in the policy wording:  </span></p>\n\n		<p class=\"outer-text area\">Section X General Provisions\n\n2. Other Insurance\n\nThis insurance is a second payer plan. For any loss or damage insured by, or for any claim payable under any other liability, group or individual basic or extended health insurance plan, or contracts including any private or provincial or territorial auto insurance plan providing hospital, medical, or therapeutic coverage, or any other insurance in force concurrently herewith, amounts payable hereunder are limited to those covered benefits incurred outside your country of origin that are in excess of the amounts for which you are insured under such other coverage.</p>\n\n		<br />\n		<p class=\"outer-text area\">We advise that you contact your auto insurance company to open a claim. If the claim is denied, you may then submit your claim to Ontime Care Worldwide Inc. and include a denial letter from your other insurance, original receipts, medical records and doctor’s notes. Kindly make copies of the documents for your records.</p>\n\n		<p>Your prompt attention is appreciated to ensure the processing of your case. Should you have any questions, please do not hesitate to contact us at <span class=\"outer-text\">905-707-9555</span> or toll free at <span class=\"outer-text\">1-888-988-3268</span></p>\n\n		<br/>\n		<p>Sincerely,</p>\n		<br/>\n		<p><span class=\"outer-text\">Authorized Representative</span></p>\n		<p>Ontime Care Worldwide Inc.</p>\n   </body>\n</html>', 'case', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `groups` text NOT NULL,
  `products` text NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int UNSIGNED NOT NULL,
  `last_login` int UNSIGNED DEFAULT NULL,
  `active` tinyint UNSIGNED DEFAULT '0',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `title` varchar(64) NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `shift` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `group_id` mediumint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `user_product`
--

CREATE TABLE `user_product` (
  `user_group_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_short` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `word_comments`
--

CREATE TABLE `word_comments` (
  `id` int NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `content` text,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active`
--
ALTER TABLE `active`
  ADD PRIMARY KEY (`active_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `claim_id` (`claim_id`),
  ADD KEY `case_id` (`case_id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `api_login`
--
ALTER TABLE `api_login`
  ADD PRIMARY KEY (`api_id`);

--
-- Indexes for table `api_login_try`
--
ALTER TABLE `api_login_try`
  ADD PRIMARY KEY (`try_id`),
  ADD KEY `tm` (`tm`);

--
-- Indexes for table `case`
--
ALTER TABLE `case`
  ADD UNIQUE KEY `case_no` (`case_no`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `case_claim_master`
--
ALTER TABLE `case_claim_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `claim`
--
ALTER TABLE `claim`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `insured_first_name` (`insured_first_name`),
  ADD KEY `insured_last_name` (`insured_last_name`),
  ADD KEY `dob` (`dob`),
  ADD KEY `created` (`created`),
  ADD KEY `status2` (`status2`);

--
-- Indexes for table `claim_status_change`
--
ALTER TABLE `claim_status_change`
  ADD PRIMARY KEY (`id`),
  ADD KEY `claim_id` (`claim_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `currency_exchange`
--
ALTER TABLE `currency_exchange`
  ADD PRIMARY KEY (`name`,`dt`);

--
-- Indexes for table `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eclaim`
--
ALTER TABLE `eclaim`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `case_no` (`case_no`);

--
-- Indexes for table `eclaim_file`
--
ALTER TABLE `eclaim_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses_claimed`
--
ALTER TABLE `expenses_claimed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_payees_claim` (`claim_id`),
  ADD KEY `status` (`status`),
  ADD KEY `finalize_date` (`finalize_date`);

--
-- Indexes for table `expenses_provider`
--
ALTER TABLE `expenses_provider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `intake_form`
--
ALTER TABLE `intake_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintain`
--
ALTER TABLE `maintain`
  ADD PRIMARY KEY (`maintain_id`);

--
-- Indexes for table `mytask`
--
ALTER TABLE `mytask`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payees`
--
ALTER TABLE `payees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_action`
--
ALTER TABLE `phone_action`
  ADD PRIMARY KEY (`phone_action_id`),
  ADD KEY `agent` (`agent`),
  ADD KEY `active` (`active`),
  ADD KEY `stm` (`stm`);

--
-- Indexes for table `phone_agent`
--
ALTER TABLE `phone_agent`
  ADD PRIMARY KEY (`phone_agent_id`),
  ADD UNIQUE KEY `dt_agt` (`dt`,`user_id`);

--
-- Indexes for table `phone_call`
--
ALTER TABLE `phone_call`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_cron`
--
ALTER TABLE `phone_cron`
  ADD PRIMARY KEY (`phone_cron_id`),
  ADD UNIQUE KEY `phone_id` (`phone_id`);

--
-- Indexes for table `phone_records`
--
ALTER TABLE `phone_records`
  ADD PRIMARY KEY (`phone_id`),
  ADD KEY `newcall` (`newcall`),
  ADD KEY `event_tm` (`event_tm`),
  ADD KEY `agent` (`agent`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `phone_ring`
--
ALTER TABLE `phone_ring`
  ADD KEY `phone_id` (`phone_id`),
  ADD KEY `event_tm` (`event_tm`),
  ADD KEY `agent` (`agent`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `queue` (`queue`);

--
-- Indexes for table `policies`
--
ALTER TABLE `policies`
  ADD PRIMARY KEY (`policy_no`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_short`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_province_country` (`country_id`);

--
-- Indexes for table `reasons`
--
ALTER TABLE `reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relations`
--
ALTER TABLE `relations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `user_product`
--
ALTER TABLE `user_product`
  ADD PRIMARY KEY (`user_group_id`);

--
-- Indexes for table `word_comments`
--
ALTER TABLE `word_comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `active`
--
ALTER TABLE `active`
  MODIFY `active_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `api_login_try`
--
ALTER TABLE `api_login_try`
  MODIFY `try_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_claim_master`
--
ALTER TABLE `case_claim_master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `claim_status_change`
--
ALTER TABLE `claim_status_change`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diagnosis`
--
ALTER TABLE `diagnosis`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eclaim`
--
ALTER TABLE `eclaim`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eclaim_file`
--
ALTER TABLE `eclaim_file`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses_claimed`
--
ALTER TABLE `expenses_claimed`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses_provider`
--
ALTER TABLE `expenses_provider`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intake_form`
--
ALTER TABLE `intake_form`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintain`
--
ALTER TABLE `maintain`
  MODIFY `maintain_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mytask`
--
ALTER TABLE `mytask`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payees`
--
ALTER TABLE `payees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_action`
--
ALTER TABLE `phone_action`
  MODIFY `phone_action_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_agent`
--
ALTER TABLE `phone_agent`
  MODIFY `phone_agent_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_call`
--
ALTER TABLE `phone_call`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_cron`
--
ALTER TABLE `phone_cron`
  MODIFY `phone_cron_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reasons`
--
ALTER TABLE `reasons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `relations`
--
ALTER TABLE `relations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_product`
--
ALTER TABLE `user_product`
  MODIFY `user_group_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `word_comments`
--
ALTER TABLE `word_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Add Case Upload File
CREATE TABLE case_file (
  id INT NOT NULL AUTO_INCREMENT,
  case_id INT NOT NULL DEFAULT 0,
  `case_no` varchar(64) NOT NULL DEFAULT '',
  `doc_type` varchar(32) NOT NULL DEFAULT '',
  `filename` char(64) NOT NULL DEFAULT '' COMMENT 'File Name for showing',
  `url` varchar(8) NOT NULL DEFAULT '' COMMENT 'Download URL',
  notes TEXT,
  update_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  user_id INT NOT NULL DEFAULT 0,
 PRIMARY KEY (id) );
CREATE INDEX case_file_case_id ON case_file (case_id);