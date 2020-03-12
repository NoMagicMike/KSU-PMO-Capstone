-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 12, 2020 at 09:49 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `KSUPMO`
--
CREATE DATABASE IF NOT EXISTS `KSUPMO` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `KSUPMO`;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(11) NOT NULL,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin DEFAULT NULL,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `settings_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `export_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `template_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `template_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"pmo\",\"table\":\"User\"},{\"db\":\"pmo\",\"table\":\"users\"},{\"db\":\"pmo\",\"table\":\"project\"},{\"db\":\"pmo\",\"table\":\"Affiliate\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin DEFAULT NULL,
  `data_sql` longtext COLLATE utf8_bin DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2020-03-12 20:49:15', '{\"Console\\/Mode\":\"collapse\",\"NavigationWidth\":254}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `pmo`
--
CREATE DATABASE IF NOT EXISTS `pmo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pmo`;

-- --------------------------------------------------------

--
-- Table structure for table `Affiliate`
--

CREATE TABLE `Affiliate` (
  `affiliate_id` bigint(20) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `affiliation_group` varchar(45) NOT NULL,
  `description` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Contractor`
--

CREATE TABLE `Contractor` (
  `contract_start_date` date NOT NULL,
  `contract_end_date` date NOT NULL,
  `affiliate_id` bigint(20) NOT NULL,
  `job_title` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Email_Contact`
--

CREATE TABLE `Email_Contact` (
  `email_id` bigint(20) NOT NULL,
  `affiliate_id` bigint(20) NOT NULL,
  `email_address` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Faculty`
--

CREATE TABLE `Faculty` (
  `department` varchar(45) NOT NULL,
  `affiliate_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Phone_Contact`
--

CREATE TABLE `Phone_Contact` (
  `phone_id` bigint(20) NOT NULL,
  `carrier` varchar(45) NOT NULL,
  `affiliate_id` bigint(20) NOT NULL,
  `phone_number` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `project_title` varchar(100) NOT NULL,
  `department` varchar(45) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `priority_level` varchar(10) NOT NULL,
  `funded` enum('yes','no','n/a') NOT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `project_description` varchar(600) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_title`, `department`, `start_date`, `end_date`, `priority_level`, `funded`, `total_cost`, `project_description`) VALUES
(1, 'Testing Update', 'Analytics and Data Science', '2018-12-11', '2020-03-04', 'Low', 'n/a', '12414.54', 'Stuff happened'),
(2, 'More Things', 'Computer Science', '2013-08-11', '2021-12-09', 'Medium', 'yes', '2132.87', 'They are working'),
(3, 'Jobin', 'Information Technology', '2020-01-02', '2023-03-01', 'High', 'n/a', '414.00', 'I dont know'),
(4, 'Another One', 'Software Engineering and Game Development', '2018-08-12', '2021-02-02', 'Low', 'n/a', '42343.00', 'Put words here'),
(5, 'Your Mom', 'Information Technology', '2011-09-21', '2022-05-16', 'Medium', 'yes', '432.00', 'tv is loud'),
(6, 'Things and Stuff', 'Computer Science', '2019-05-14', '2020-03-12', 'Medium', 'yes', '58778.00', 'Its important'),
(7, 'Pointless Words', 'Information Technology', '2019-05-25', '2019-07-19', 'Medium', 'yes', '43234.00', 'dead kennedys'),
(8, 'Good God', 'Information Technology', '2018-09-19', '2021-08-18', 'Low', 'n/a', '0.00', 'Whats happening'),
(9, 'Always Ready', 'Software Engineering and Game Development', '2018-03-02', '2025-08-12', 'Low', 'n/a', '0.00', 'Good for you'),
(10, 'Last One', 'Software Engineering and Game Development', '2018-04-12', '2020-07-09', 'High', 'yes', '343255.00', 'free labor'),
(11, 'One More', 'Information Technology', '2012-09-09', '2020-09-09', 'Medium', 'n/a', '545443.00', 'Thats it'),
(12, 'Test', 'Computer Science', '1983-07-01', '2020-09-09', 'Medium', 'n/a', '0.00', 'it worked');

-- --------------------------------------------------------

--
-- Table structure for table `Sponsor`
--

CREATE TABLE `Sponsor` (
  `company_name` varchar(45) NOT NULL,
  `affiliate_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `user_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `username`, `password`, `created_at`, `user_admin`) VALUES
(16, 'admin', 'password', '2020-03-11 10:33:40', 1),
(17, 'admin2', '$2y$10$mGoNr4lxpjP7a5UjJI3Ynefrnt8pDXMmqKpWVSno4h/lQx62bpt0y', '2020-03-11 10:49:26', 0),
(18, 'admin3', '$2y$10$CmC9IbvSBNkwlDLjvTiV8.vPWSjT4iISE.spafrOWfQ1TMGjF4axy', '2020-03-11 11:03:48', 0),
(19, 'standard', '$2y$10$iHsylgr0uL0XdMgknK5Fo.y4SsVGxOAd4Jt8obMgyjItc2wb7fYuS', '2020-03-11 11:06:58', 0),
(20, 'admin4', '$2y$10$6raTMnsjc4wRhLJ2fBMeCOdmq9xfjEFF.TM9GikXj9s1uC1/8ZE76', '2020-03-11 11:07:34', 0),
(21, 'TestingTesting', '$2y$10$tqtenbgl5xvUxIQOnyVcgexmxWLwFRraARYxsrYr6ecLK2kW7JzbK', '2020-03-11 11:14:59', 1),
(22, 'zzzzzzz', '$2y$10$OV3ysTkQ2YkBs1lKExGQe.3U/ozFFE.alDwSzQxiS8ebqqcYr8/UW', '2020-03-11 11:20:28', 1),
(23, 'admin11', '$2y$10$dTmGXQygWaK59zM7mUjZCuAGB9PWqkJu.cCLaSfQRB3KAeOHgAvCO', '2020-03-11 12:02:19', 1),
(24, 'admin12', '$2y$10$aHm5jyaDVR1Qff4OTyj3TOVkTQ98mvOZd1yHoMcsFryQVEOPeNIYW', '2020-03-11 12:13:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `user_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `user_admin`) VALUES
(1, 'admin', '$2y$10$pg4yRSogbx4F0EnzRIBcL.ykBTURGUpBkjesH1W7c1qAbLYuwb4su', '2020-03-08 19:08:25', 0),
(2, 'bob2', '$2y$10$CaR3IOQ4SxpLBL.4GONQreUL58pao.wcFFGPKvF2MTfxoPTbtYPmi', '2020-03-10 17:44:50', 1),
(3, 'peepee', '$2y$10$W0gBnTWv45tf86FowIfpE.Bp2rO4Efb7e1iV6x5NHOE/.bpNlgBdC', '2020-03-10 17:46:36', 0),
(4, 'poopoo', '$2y$10$GZT3NKXxqdw/bMUB6O5gruoD.sri9k60BQCpq8HDZlWilp9fWkr/6', '2020-03-10 17:46:58', 0),
(5, 'poopoo2', '$2y$10$pt.8BPeij4jKufXcmKbafeUMSpzEGMTCxAS/lnX4sx/w90TM0xUp2', '2020-03-10 17:47:42', 0),
(6, 'jeff', '$2y$10$eVJwUC8lo6xKk9wnZZLiweTbJg2bzK7/uRu/7w7J5sgWbMkYkp5ym', '2020-03-10 17:49:28', 0),
(7, 'peeper', '$2y$10$/rSCO9FxCOczQG1EbC4iwu6zTyJm2fKecCjmr4g16bxh3VROUZVdi', '2020-03-10 17:50:45', 0),
(8, 'matt', '$2y$10$hdySnEcBVmolL1Eicx2qmO.S9uOrMbleUtO.N0GAbFl260Cv0PZJG', '2020-03-10 17:54:56', 0),
(9, 'mike', '$2y$10$LPaKbgk6C6Se1ExdAxpVseum5iYSDZmhmhcFIZpTedtU6E3FGf6B.', '2020-03-10 17:57:24', 0),
(10, 'mike2', '$2y$10$ZwzoZRO8iSSbbgxsF4rQaus86CCiVWpAGsZKmDc3Zextep9fcOf8W', '2020-03-10 17:57:34', 1),
(11, 'connor_god', '$2y$10$JcY7uFhQ6EAyyBxsUIoZd.MSgY4Iuwr6hRZkSaOnpI8v7pH6ciEei', '2020-03-10 17:57:49', 1),
(12, 'doesitwork', '$2y$10$XMpGENIuGdwmhNYdEDYcxeh.o.Zk4gD1lLceGmwniWGWlCkSdtGVW', '2020-03-10 17:59:06', 1),
(13, 'admin2', '$2y$10$.Qr9voRNrNnKKS4YPFZuZO0tGlAtTKDUoa6m73pXjb0MO8lMK2ZRe', '2020-03-10 19:00:01', 1),
(14, 'standard', '$2y$10$1cr4eSBngS6g9etqHy8K4uqDnbTQMTC.kDNweZ5tAI8DE136p4s.S', '2020-03-10 21:33:45', 0),
(15, 'adminz', '$2y$10$FSDYUC9G0MXAgB3fLfE8kuL/aaEo9pUVM06f.wrKBgIk6RZq/omPK', '2020-03-11 09:38:28', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Affiliate`
--
ALTER TABLE `Affiliate`
  ADD PRIMARY KEY (`affiliate_id`);

--
-- Indexes for table `Contractor`
--
ALTER TABLE `Contractor`
  ADD KEY `fkIdx_58` (`affiliate_id`);

--
-- Indexes for table `Email_Contact`
--
ALTER TABLE `Email_Contact`
  ADD PRIMARY KEY (`email_id`),
  ADD KEY `fkIdx_31` (`affiliate_id`);

--
-- Indexes for table `Faculty`
--
ALTER TABLE `Faculty`
  ADD KEY `fkIdx_77` (`affiliate_id`);

--
-- Indexes for table `Phone_Contact`
--
ALTER TABLE `Phone_Contact`
  ADD PRIMARY KEY (`phone_id`),
  ADD KEY `fkIdx_38` (`affiliate_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `Sponsor`
--
ALTER TABLE `Sponsor`
  ADD KEY `fkIdx_43` (`affiliate_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Affiliate`
--
ALTER TABLE `Affiliate`
  MODIFY `affiliate_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Email_Contact`
--
ALTER TABLE `Email_Contact`
  MODIFY `email_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Phone_Contact`
--
ALTER TABLE `Phone_Contact`
  MODIFY `phone_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Contractor`
--
ALTER TABLE `Contractor`
  ADD CONSTRAINT `FK_58` FOREIGN KEY (`affiliate_id`) REFERENCES `Affiliate` (`affiliate_id`);

--
-- Constraints for table `Email_Contact`
--
ALTER TABLE `Email_Contact`
  ADD CONSTRAINT `FK_31` FOREIGN KEY (`affiliate_id`) REFERENCES `Affiliate` (`affiliate_id`);

--
-- Constraints for table `Faculty`
--
ALTER TABLE `Faculty`
  ADD CONSTRAINT `FK_77` FOREIGN KEY (`affiliate_id`) REFERENCES `Affiliate` (`affiliate_id`);

--
-- Constraints for table `Phone_Contact`
--
ALTER TABLE `Phone_Contact`
  ADD CONSTRAINT `FK_38` FOREIGN KEY (`affiliate_id`) REFERENCES `Affiliate` (`affiliate_id`);

--
-- Constraints for table `Sponsor`
--
ALTER TABLE `Sponsor`
  ADD CONSTRAINT `FK_43` FOREIGN KEY (`affiliate_id`) REFERENCES `Affiliate` (`affiliate_id`);
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
