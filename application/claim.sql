CREATE TABLE `active` (
  `active_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `claim_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `log` text NOT NULL,
  `query` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `api_login_try` (
  `try_id` int(11) NOT NULL,
  `tm` bigint(20) NOT NULL,
  `api_id` varchar(64) NOT NULL,
  `policy` varchar(32) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `case` (
  `id` int(11) NOT NULL,
  `case_no` varchar(64) NOT NULL,
  `claim_no` varchar(64) NOT NULL,
  `created_by` int(11) NOT NULL,
  `street_no` varchar(10) DEFAULT NULL,
  `street_name` varchar(30) DEFAULT NULL,
  `suite_number` varchar(16) NOT NULL,
  `city` varchar(40) DEFAULT NULL,
  `province` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `country2` varchar(40) DEFAULT NULL,
  `post_code` varchar(10) DEFAULT NULL,
  `assign_to` int(11) NOT NULL DEFAULT '0' COMMENT 'this field is relaetd to follow up process',
  `reason` varchar(30) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` tinytext,
  `manager_summary` text NOT NULL,
  `place_of_call` varchar(255) NOT NULL,
  `incident_date` date NOT NULL,
  `relations` varchar(40) DEFAULT NULL,
  `diagnosis` varchar(40) DEFAULT NULL,
  `treatment` varchar(40) DEFAULT NULL,
  `third_party_recovery` enum('Y','N') NOT NULL DEFAULT 'N',
  `medical_notes` text,
  `policy_no` varchar(20) DEFAULT NULL,
  `product_short` varchar(16) NOT NULL,
  `totaldays` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `policy_info` text,
  `departure_date` date NOT NULL,
  `insured_firstname` varchar(50) DEFAULT NULL,
  `insured_lastname` varchar(50) DEFAULT NULL,
  `insured_address` tinytext,
  `dob` date DEFAULT NULL,
  `gender` varchar(8) NOT NULL,
  `case_manager` int(10) NOT NULL COMMENT 'This field is refer here to transfer case manager field',
  `init_manager` int(11) NOT NULL,
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
  `outpatient_provider` tinytext NOT NULL,
  `outpatient_federal_tax` varchar(128) NOT NULL,
  `outpatient_facility` tinytext NOT NULL,
  `outpatient_physician` tinytext NOT NULL,
  `outpatient_address1` tinytext NOT NULL,
  `outpatient_address2` tinytext NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

CREATE TABLE `case_claim_master` (
  `id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `case_file` (
  `id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL DEFAULT '0',
  `case_no` varchar(64) NOT NULL DEFAULT '',
  `doc_type` varchar(32) NOT NULL DEFAULT '',
  `filename` char(64) NOT NULL DEFAULT '' COMMENT 'File Name for showing',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT 'Download URL',
  `notes` text,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `claim` (
  `id` int(11) NOT NULL,
  `claim_no` varchar(64) NOT NULL,
  `eclaim_no` varchar(16) NOT NULL DEFAULT '',
  `assign_to` int(11) NOT NULL DEFAULT '0',
  `claim_date` date DEFAULT NULL,
  `apply_date` date DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `insured_first_name` varchar(45) DEFAULT NULL,
  `insured_last_name` varchar(30) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `personal_id` varchar(40) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `policy_no` varchar(40) DEFAULT NULL,
  `package` varchar(32) NOT NULL DEFAULT 'Medical',
  `totaldays` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `reserve_amount` float NOT NULL DEFAULT '0',
  `sum_insured` int(11) NOT NULL DEFAULT '0',
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
  `reason` varchar(50) NOT NULL DEFAULT 'A',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

DELIMITER $$
CREATE TRIGGER `claimStatusChange` AFTER UPDATE ON `claim` FOR EACH ROW BEGIN
 IF NEW.status != OLD.status THEN
  INSERT INTO claim_status_change (claim_id, status, update_time) values (NEW.id, NEW.status, NOW());
 END IF;
END
$$
DELIMITER ;

CREATE TABLE `claim_status_change` (
  `id` int(11) NOT NULL,
  `claim_id` int(11) NOT NULL,
  `status` varchar(20) CHARACTER SET latin1 NOT NULL,
  `update_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `short_code` varchar(10) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `order_by` int(11) NOT NULL DEFAULT '1000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `currency` (
  `name` char(3) CHARACTER SET latin1 NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `orderby` int(11) NOT NULL DEFAULT '100000',
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=armscii8;

CREATE TABLE `currency_exchange` (
  `name` char(3) NOT NULL,
  `dt` date NOT NULL,
  `rate` float NOT NULL,
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `diagnosis` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

CREATE TABLE `eclaim` (
  `id` int(11) NOT NULL,
  `eclaim_no` varchar(64) DEFAULT '',
  `processed_by` int(11) NOT NULL DEFAULT '0' COMMENT 'user id for procesed user',
  `claim_no` varchar(64) DEFAULT '',
  `case_no` varchar(16) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `lang` char(2) NOT NULL DEFAULT 'en' COMMENT 'en fr zh',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPRESSED;

CREATE TABLE `eclaim_file` (
  `id` int(11) NOT NULL,
  `eclaim_id` int(11) DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  `path` varchar(255) DEFAULT '',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `expenses_claimed` (
  `id` int(11) NOT NULL,
  `claim_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `claim_no` varchar(50) DEFAULT NULL,
  `claim_item_no` varchar(50) DEFAULT NULL,
  `case_no` varchar(50) DEFAULT NULL,
  `claim_date` date DEFAULT NULL,
  `cellular` varchar(50) DEFAULT NULL,
  `invoice` varchar(50) DEFAULT NULL,
  `provider_name` tinytext CHARACTER SET utf8,
  `provider_type` tinyint(4) NOT NULL DEFAULT '0',
  `expenses_provider_id` int(11) NOT NULL,
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
  `reason_other` varchar(255) NOT NULL,
  `amount_claimed` decimal(20,2) DEFAULT '0.00',
  `amount_claimed_org` decimal(20,2) NOT NULL DEFAULT '0.00',
  `other_reimbursed_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amt_deductible` float DEFAULT '0',
  `amt_insured` float DEFAULT '0',
  `amt_received` float DEFAULT '0',
  `amt_payable` float DEFAULT '0',
  `amt_exceptional` float DEFAULT '0',
  `currency` char(3) DEFAULT NULL,
  `currency_rate` float DEFAULT '0',
  `payee` int(11) NOT NULL DEFAULT '0',
  `third_party_payee` int(11) NOT NULL DEFAULT '0',
  `comment` text,
  `recovery_name` varchar(128) NOT NULL,
  `recovery_amt` float NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `pay_date` date NOT NULL,
  `cheque` varchar(255) CHARACTER SET utf8 NOT NULL,
  `finalize_date` date DEFAULT '2000-01-01',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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

CREATE TABLE `expenses_provider` (
  `id` int(11) NOT NULL,
  `claim_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `name` varchar(128) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(64) NOT NULL,
  `province` varchar(64) NOT NULL,
  `country` varchar(64) NOT NULL,
  `postcode` varchar(16) NOT NULL,
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `intake_form` (
  `id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL COMMENT 'case_id stand for case or claim id, depends on "type" field ''CASE'' or ''CLAIM''',
  `created_by` int(11) NOT NULL,
  `notes` text,
  `docs` text,
  `type` enum('CASE','CLAIM','CASE_CHANGE') NOT NULL DEFAULT 'CASE',
  `created` datetime NOT NULL,
  `phonefile` varchar(128) NOT NULL,
  `followup` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `logs` (
  `id` int(10) NOT NULL,
  `claim_id` int(10) DEFAULT NULL,
  `claim_item_id` int(10) DEFAULT NULL,
  `payee` varchar(100) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `bank_name` varchar(50) DEFAULT NULL,
  `account` varchar(50) DEFAULT NULL,
  `to_val` float DEFAULT NULL,
  `from_val` float DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `mytask` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `task_no` varchar(20) NOT NULL,
  `category` varchar(20) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time NOT NULL,
  `completion_date` date DEFAULT NULL,
  `type` enum('CLAIM','CASE') DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `user_type` varchar(20) DEFAULT NULL,
  `status` varchar(16) NOT NULL,
  `created` datetime DEFAULT NULL,
  `finished` tinyint(1) NOT NULL,
  `notes` text NOT NULL,
  `logs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `payees` (
  `id` int(11) NOT NULL,
  `claim_id` int(11) DEFAULT NULL,
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

CREATE TABLE `phone_action` (
  `phone_action_id` int(11) NOT NULL,
  `agent` varchar(32) CHARACTER SET latin1 NOT NULL,
  `user_id` int(11) NOT NULL,
  `active` varchar(16) CHARACTER SET latin1 NOT NULL,
  `stm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `etm` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `slength` int(11) NOT NULL DEFAULT '0' COMMENT 'period in seconds',
  `processed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `phone_agent` (
  `phone_agent_id` int(11) NOT NULL,
  `dt` varchar(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pause` int(11) NOT NULL,
  `break` int(11) NOT NULL,
  `incall` int(11) NOT NULL,
  `outcall` int(11) NOT NULL,
  `waiting` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `phone_call` (
  `id` int(11) NOT NULL,
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `phone_records` (
  `phone_id` varchar(64) NOT NULL,
  `queue` varchar(64) NOT NULL,
  `event_tm` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `newcall` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `answer` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hangup` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `agent` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `caller_id_number` varchar(32) NOT NULL,
  `direction` varchar(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `phone_ring` (
  `phone_id` varchar(64) NOT NULL,
  `event_tm` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `agent` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `queue` varchar(32) NOT NULL,
  `caller_id_number` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `policies` (
  `policy_no` varchar(20) NOT NULL,
  `note` text NOT NULL,
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `product` (
  `product_short` varchar(16) NOT NULL COMMENT 'short name',
  `calculate` tinyint(4) NOT NULL COMMENT '1 means has program to calculate premium',
  `commission` decimal(10,2) NOT NULL COMMENT '50 means 50%',
  `min_premium` decimal(10,2) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `commission_max_limit` int(11) NOT NULL DEFAULT '100000',
  `commission_max_days` int(11) NOT NULL DEFAULT '3650',
  `qoute_pre` varchar(8) NOT NULL,
  `plan_pre` varchar(8) NOT NULL,
  `up_insuer` varchar(255) NOT NULL COMMENT 'Original Product come from',
  `up_pay_rate` decimal(10,3) NOT NULL,
  `prepare_rate` decimal(10,2) NOT NULL,
  `merchent_id` varchar(64) NOT NULL,
  `apikey` varchar(64) NOT NULL,
  `currency` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `provider` (
  `id` int(10) NOT NULL,
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

CREATE TABLE `province` (
  `id` int(11) NOT NULL,
  `country_id` int(10) NOT NULL DEFAULT '0',
  `country_short_code` varchar(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `short_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reason2s` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reasons` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `relations` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `schedule` (
  `id` int(11) UNSIGNED NOT NULL,
  `employee_id` int(11) UNSIGNED NOT NULL,
  `schedule` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `sphone` varchar(16) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `start_tm` datetime NOT NULL,
  `shour` tinyint(4) NOT NULL,
  `hours` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `country_id` int(11) DEFAULT '1',
  `code` varchar(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `template` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `description` longtext NOT NULL,
  `type` enum('claim','case','eac') DEFAULT NULL COMMENT '''claim-claim manager'',''case-case manager'',''emc-emc user''',
  `sname` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `groups` text NOT NULL,
  `products` text NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT '0',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `title` varchar(64) NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `shift` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_product` (
  `user_group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_short` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `word_comments` (
  `id` int(10) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `content` text,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `active`
  ADD PRIMARY KEY (`active_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `claim_id` (`claim_id`),
  ADD KEY `case_id` (`case_id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `type` (`type`);

ALTER TABLE `api_login`
  ADD PRIMARY KEY (`api_id`);

ALTER TABLE `api_login_try`
  ADD PRIMARY KEY (`try_id`),
  ADD KEY `tm` (`tm`);

ALTER TABLE `case`
  ADD UNIQUE KEY `case_no` (`case_no`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `case_claim_master`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `case_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_file_case_id` (`case_id`);

ALTER TABLE `claim`
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `claim_status_change`
  ADD PRIMARY KEY (`id`),
  ADD KEY `claim_id` (`claim_id`);

ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `currency`
  ADD PRIMARY KEY (`name`);

ALTER TABLE `currency_exchange`
  ADD PRIMARY KEY (`name`,`dt`);

ALTER TABLE `diagnosis`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `eclaim`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `case_no` (`case_no`);

ALTER TABLE `eclaim_file`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `expenses_claimed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_payees_claim` (`claim_id`);

ALTER TABLE `expenses_provider`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `intake_form`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mytask`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `payees`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `phone_action`
  ADD PRIMARY KEY (`phone_action_id`);

ALTER TABLE `phone_agent`
  ADD PRIMARY KEY (`phone_agent_id`),
  ADD UNIQUE KEY `dt_agt` (`dt`,`user_id`);

ALTER TABLE `phone_call`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `phone_records`
  ADD PRIMARY KEY (`phone_id`);

ALTER TABLE `policies`
  ADD PRIMARY KEY (`policy_no`);

ALTER TABLE `product`
  ADD PRIMARY KEY (`product_short`);

ALTER TABLE `provider`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `province`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_province_country` (`country_id`);

ALTER TABLE `reasons`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `relations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

ALTER TABLE `user_product`
  ADD PRIMARY KEY (`user_group_id`);

ALTER TABLE `word_comments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `active`
  MODIFY `active_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17760;
ALTER TABLE `api_login_try`
  MODIFY `try_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=799;
ALTER TABLE `case`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=703;
ALTER TABLE `case_claim_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=705;
ALTER TABLE `case_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
ALTER TABLE `claim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=705;
ALTER TABLE `claim_status_change`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
ALTER TABLE `diagnosis`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71828;
ALTER TABLE `eclaim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=531;
ALTER TABLE `eclaim_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2183;
ALTER TABLE `expenses_claimed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=510;
ALTER TABLE `expenses_provider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
ALTER TABLE `intake_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `logs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `mytask`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=489;
ALTER TABLE `payees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=558;
ALTER TABLE `phone_action`
  MODIFY `phone_action_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `phone_agent`
  MODIFY `phone_agent_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `phone_call`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8151;
ALTER TABLE `provider`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
ALTER TABLE `province`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;
ALTER TABLE `reasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
ALTER TABLE `relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
ALTER TABLE `schedule`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4121;
ALTER TABLE `template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;
ALTER TABLE `user_product`
  MODIFY `user_group_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `word_comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
ALTER TABLE `case`
  ADD CONSTRAINT `case_ibfk_1` FOREIGN KEY (`id`) REFERENCES `case_claim_master` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE `claim`
  ADD CONSTRAINT `claim_ibfk_1` FOREIGN KEY (`id`) REFERENCES `case_claim_master` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 2026-08-29
CREATE TABLE block_customer(
  block_customer_id int NOT NULL AUTO_INCREMENT,
  `status` TINYINT NOT NULL DEFAULT 0 COMMENT '0:OK, 1:Warrning, 2:Blocked',
  firstname varchar(50) NOT NULL DEFAULT '',
  lastname varchar(50) NOT NULL DEFAULT '',
  birthday date DEFAULT NULL,
  policies TEXT,
  notes TEXT,
  PRIMARY KEY (block_customer_id) 
)ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE INDEX idx_block_customer_firstname ON block_customer (firstname);
CREATE INDEX idx_block_customer_lastname ON block_customer (lastname);
CREATE INDEX idx_block_customer_birthday ON block_customer (birthday);
