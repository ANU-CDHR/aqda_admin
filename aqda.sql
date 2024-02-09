

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aqda`
--

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

CREATE TABLE `api` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(39) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_token` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `allowance` tinyint(3) DEFAULT '0',
  `allowance_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('SysAdmin', '1', 1625797898),
('SysEditor', '2', 1625805375),
('SysEditor', '3', 1626831535),
('SysEditor', '4', 1626831627),
('SysEditor', '5', 1626832502),
('SysEditor', '6', 1626832624);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('publishInterview', 2, 'Publish Interview', 'canPublishInterview', NULL, 1625799151, 1625799451),
('SysAdmin', 1, 'System Administrator', NULL, NULL, 1625797898, 1625799509),
('SysEditor', 1, 'System Editor can edit and create.', NULL, NULL, 1625798997, 1625799026);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('SysAdmin', 'publishInterview'),
('SysAdmin', 'SysEditor');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('canPublishInterview', 0x4f3a33323a22636f6d6d6f6e5c726261635c5075626c697368696e7465727669657752756c65223a333a7b733a343a226e616d65223b733a31393a2263616e5075626c697368496e74657276696577223b733a393a22637265617465644174223b4e3b733a393a22757064617465644174223b693a313632353739393434313b7d, 1625799429, 1625799441);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `code` char(2) NOT NULL,
  `name` char(52) NOT NULL,
  `population` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`code`, `name`, `population`) VALUES
('AU', 'Australia', 18886000),
('BR', 'Brazil', 170115000),
('CA', 'Canada', 1147000),
('CN', 'China', 1277558000),
('DE', 'Germany', 82164700),
('FR', 'France', 59225700),
('GB', 'United Kingdom', 59623400),
('IN', 'India', 1013662000),
('RU', 'Russia', 146934000),
('US', 'United States', 278357000);

-- --------------------------------------------------------

--
-- Table structure for table `format`
--

CREATE TABLE `format` (
  `id` int(3) NOT NULL,
  `value` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `format`
--

INSERT INTO `format` (`id`, `value`) VALUES
(1, 'JPEG2000'),
(2, 'MPEG4'),
(3, 'MP3'),
(4, 'WAV');

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `id` int(2) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `name`) VALUES
(1, 'Female'),
(2, 'Male'),
(3, 'Non-binary');

-- --------------------------------------------------------

--
-- Table structure for table `interview`
--

CREATE TABLE `interview` (
  `id` int(11) NOT NULL,
  `intervieweeLocation` varchar(300) NOT NULL,
  `date` date NOT NULL,
  `escapeCountry` varchar(30) NOT NULL,
  `transgender` int(1) DEFAULT '0',
  `intervieweeId` int(11) NOT NULL,
  `interviewerId` int(11) NOT NULL,
  `isCitizen` int(1) DEFAULT '0',
  `pseudonym` int(1) NOT NULL DEFAULT '0',
  `videoDistortion` int(1) NOT NULL DEFAULT '0',
  `voiceChange` int(1) NOT NULL DEFAULT '0',
  `contextual` text,
  `refugeeCamp` int(1) DEFAULT '0',
  `published` int(1) NOT NULL DEFAULT '0',
  `createUserId` int(11) NOT NULL DEFAULT '1',
  `imageFile` varchar(100) DEFAULT NULL,
  `accessionName` varchar(100) DEFAULT NULL,
  `migrationId` int(3) NOT NULL,
  `lat` varchar(50) NOT NULL,
  `lng` varchar(50) NOT NULL,
  `genderId` int(2) DEFAULT NULL,
  `narratorNameD` varchar(100) DEFAULT NULL,
  `docLink` varchar(500) DEFAULT NULL,
  `languageId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

---------------------------------------------

--
-- Table structure for table `interviewee`
--

CREATE TABLE `interviewee` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `birthYear` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `interviewer`
--

CREATE TABLE `interviewer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `bio` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `interviewgender`
--

CREATE TABLE `interviewgender` (
  `interviewId` int(11) NOT NULL,
  `genderId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Table structure for table `interviewpron`
--

CREATE TABLE `interviewpron` (
  `interviewId` int(11) NOT NULL,
  `pronounsId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `interviewsexo`
--

CREATE TABLE `interviewsexo` (
  `interviewId` int(11) NOT NULL,
  `sexoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`) VALUES
(1, 'English'),
(2, 'Russian'),
(3, 'Spanish');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('Da\\User\\Migration\\m000000_000001_create_user_table', 1625796223),
('Da\\User\\Migration\\m000000_000002_create_profile_table', 1625796223),
('Da\\User\\Migration\\m000000_000003_create_social_account_table', 1625796223),
('Da\\User\\Migration\\m000000_000004_create_token_table', 1625796223),
('Da\\User\\Migration\\m000000_000005_add_last_login_at', 1625796223),
('Da\\User\\Migration\\m000000_000006_add_two_factor_fields', 1625796223),
('Da\\User\\Migration\\m000000_000007_enable_password_expiration', 1625796223),
('Da\\User\\Migration\\m000000_000008_add_last_login_ip', 1625796224),
('Da\\User\\Migration\\m000000_000009_add_gdpr_consent_fields', 1625796224),
('m000000_000000_base', 1618187067),
('m130524_201442_init', 1618187071),
('m140506_102106_rbac_init', 1625797397),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1625797397),
('m180523_151638_rbac_updates_indexes_without_prefix', 1625797397),
('m190124_110200_add_verification_token_column_to_user_table', 1618187071),
('m190525_131624_api', 1627450004),
('m200409_110543_rbac_update_mssql_trigger', 1625797397);

-- --------------------------------------------------------

--
-- Table structure for table `migrationStatus`
--

CREATE TABLE `migrationStatus` (
  `id` int(3) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrationStatus`
--

INSERT INTO `migrationStatus` (`id`, `name`) VALUES
(1, 'Asylum seeker'),
(2, 'Refugee'),
(3, 'Migrant');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `pronouns`
--

CREATE TABLE `pronouns` (
  `id` int(3) NOT NULL,
  `value` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pronouns`
--

INSERT INTO `pronouns` (`id`, `value`) VALUES
(1, 'She/Her/Hers'),
(2, 'He/Him/His'),
(5, 'They/Them/Their');

-- --------------------------------------------------------

--
-- Table structure for table `publishMedia`
--

CREATE TABLE `publishMedia` (
  `id` int(11) NOT NULL,
  `accessName` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `accessionDate` date DEFAULT NULL,
  `youtubeUrl` varchar(255) DEFAULT NULL,
  `interviewId` int(11) NOT NULL,
  `mediaType` int(11) NOT NULL DEFAULT '1',
  `size` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `youtubeDes` text,
  `lengthText` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `sexualOrientation`
--

CREATE TABLE `sexualOrientation` (
  `id` int(3) NOT NULL,
  `value` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sexualOrientation`
--

INSERT INTO `sexualOrientation` (`id`, `value`) VALUES
(1, 'Lesbian'),
(2, 'Gay'),
(3, 'Bisexual'),
(4, 'Transgender'),
(5, 'Intersex'),
(6, 'Queer');

-- --------------------------------------------------------

--
-- Table structure for table `social_account`
--

CREATE TABLE `social_account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `accessName` varchar(100) NOT NULL,
  `storageType` int(1) NOT NULL,
  `size` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `equipment` varchar(300) DEFAULT NULL,
  `uncompressedSize` int(11) DEFAULT NULL,
  `noOfFiles` int(5) DEFAULT NULL,
  `fileName` varchar(255) DEFAULT NULL,
  `mediaId` int(11) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `lengthText` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `storageformat`
--

CREATE TABLE `storageformat` (
  `storageId` int(11) NOT NULL,
  `formatId` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `transcription`
--

CREATE TABLE `transcription` (
  `id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `segmentTitle` varchar(500) DEFAULT NULL,
  `partialTranscription` text NOT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `subject` varchar(500) DEFAULT NULL,
  `synopsis` text,
  `gps` varchar(255) DEFAULT NULL,
  `mediaId` int(11) NOT NULL,
  `timestampText` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `confirmed_at` int(11) DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `last_login_at` int(11) DEFAULT NULL,
  `last_login_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_tf_key` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_tf_enabled` tinyint(1) DEFAULT '0',
  `password_changed_at` int(11) DEFAULT NULL,
  `gdpr_consent` tinyint(1) DEFAULT '0',
  `gdpr_consent_date` int(11) DEFAULT NULL,
  `gdpr_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `user0`
--

CREATE TABLE `user0` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_api_user` (`user_id`,`user_ip`,`access_token`),
  ADD KEY `idx_api_status` (`status`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `format`
--
ALTER TABLE `format`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interview`
--
ALTER TABLE `interview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `intervieweeId` (`intervieweeId`),
  ADD KEY `interviewerId` (`interviewerId`),
  ADD KEY `migrationId` (`migrationId`),
  ADD KEY `genderId` (`genderId`),
  ADD KEY `interview_ibfk_5` (`createUserId`),
  ADD KEY `languageId` (`languageId`);

--
-- Indexes for table `interviewee`
--
ALTER TABLE `interviewee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interviewer`
--
ALTER TABLE `interviewer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interviewgender`
--
ALTER TABLE `interviewgender`
  ADD PRIMARY KEY (`interviewId`,`genderId`),
  ADD KEY `genderId` (`genderId`);

--
-- Indexes for table `interviewpron`
--
ALTER TABLE `interviewpron`
  ADD PRIMARY KEY (`interviewId`,`pronounsId`),
  ADD KEY `pronounsId` (`pronounsId`);

--
-- Indexes for table `interviewsexo`
--
ALTER TABLE `interviewsexo`
  ADD PRIMARY KEY (`interviewId`,`sexoId`),
  ADD KEY `sexoId` (`sexoId`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `migrationStatus`
--
ALTER TABLE `migrationStatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `pronouns`
--
ALTER TABLE `pronouns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publishMedia`
--
ALTER TABLE `publishMedia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interviewId` (`interviewId`);

--
-- Indexes for table `sexualOrientation`
--
ALTER TABLE `sexualOrientation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_account`
--
ALTER TABLE `social_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_social_account_provider_client_id` (`provider`,`client_id`),
  ADD UNIQUE KEY `idx_social_account_code` (`code`),
  ADD KEY `fk_social_account_user` (`user_id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mediaId` (`mediaId`);

--
-- Indexes for table `storageformat`
--
ALTER TABLE `storageformat`
  ADD PRIMARY KEY (`storageId`,`formatId`),
  ADD KEY `formatId` (`formatId`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD UNIQUE KEY `idx_token_user_id_code_type` (`user_id`,`code`,`type`);

--
-- Indexes for table `transcription`
--
ALTER TABLE `transcription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mediaId` (`mediaId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_user_username` (`username`),
  ADD UNIQUE KEY `idx_user_email` (`email`);

--
-- Indexes for table `user0`
--
ALTER TABLE `user0`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api`
--
ALTER TABLE `api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `format`
--
ALTER TABLE `format`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `interview`
--
ALTER TABLE `interview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `interviewee`
--
ALTER TABLE `interviewee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `interviewer`
--
ALTER TABLE `interviewer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrationStatus`
--
ALTER TABLE `migrationStatus`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pronouns`
--
ALTER TABLE `pronouns`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `publishMedia`
--
ALTER TABLE `publishMedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sexualOrientation`
--
ALTER TABLE `sexualOrientation`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `social_account`
--
ALTER TABLE `social_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transcription`
--
ALTER TABLE `transcription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=929;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user0`
--
ALTER TABLE `user0`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `interview`
--
ALTER TABLE `interview`
  ADD CONSTRAINT `interview_ibfk_1` FOREIGN KEY (`intervieweeId`) REFERENCES `interviewee` (`id`),
  ADD CONSTRAINT `interview_ibfk_2` FOREIGN KEY (`interviewerId`) REFERENCES `interviewer` (`id`),
  ADD CONSTRAINT `interview_ibfk_3` FOREIGN KEY (`migrationId`) REFERENCES `migrationStatus` (`id`),
  ADD CONSTRAINT `interview_ibfk_4` FOREIGN KEY (`genderId`) REFERENCES `gender` (`id`),
  ADD CONSTRAINT `interview_ibfk_5` FOREIGN KEY (`createUserId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `interview_ibfk_6` FOREIGN KEY (`languageId`) REFERENCES `language` (`id`);

--
-- Constraints for table `interviewgender`
--
ALTER TABLE `interviewgender`
  ADD CONSTRAINT `interviewgender_ibfk_1` FOREIGN KEY (`interviewId`) REFERENCES `interview` (`id`),
  ADD CONSTRAINT `interviewgender_ibfk_2` FOREIGN KEY (`genderId`) REFERENCES `gender` (`id`);

--
-- Constraints for table `interviewpron`
--
ALTER TABLE `interviewpron`
  ADD CONSTRAINT `interviewpron_ibfk_1` FOREIGN KEY (`interviewId`) REFERENCES `interview` (`id`),
  ADD CONSTRAINT `interviewpron_ibfk_2` FOREIGN KEY (`pronounsId`) REFERENCES `pronouns` (`id`);

--
-- Constraints for table `interviewsexo`
--
ALTER TABLE `interviewsexo`
  ADD CONSTRAINT `interviewsexo_ibfk_1` FOREIGN KEY (`interviewId`) REFERENCES `interview` (`id`),
  ADD CONSTRAINT `interviewsexo_ibfk_2` FOREIGN KEY (`sexoId`) REFERENCES `sexualOrientation` (`id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_profile_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `publishMedia`
--
ALTER TABLE `publishMedia`
  ADD CONSTRAINT `publishmedia_ibfk_1` FOREIGN KEY (`interviewId`) REFERENCES `interview` (`id`);

--
-- Constraints for table `social_account`
--
ALTER TABLE `social_account`
  ADD CONSTRAINT `fk_social_account_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `storage`
--
ALTER TABLE `storage`
  ADD CONSTRAINT `storage_ibfk_1` FOREIGN KEY (`mediaId`) REFERENCES `publishMedia` (`id`);

--
-- Constraints for table `storageformat`
--
ALTER TABLE `storageformat`
  ADD CONSTRAINT `storageformat_ibfk_1` FOREIGN KEY (`storageId`) REFERENCES `storage` (`id`),
  ADD CONSTRAINT `storageformat_ibfk_2` FOREIGN KEY (`formatId`) REFERENCES `format` (`id`);

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `fk_token_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transcription`
--
ALTER TABLE `transcription`
  ADD CONSTRAINT `transcription_ibfk_1` FOREIGN KEY (`mediaId`) REFERENCES `publishMedia` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
