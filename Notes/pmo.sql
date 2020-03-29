-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 29, 2020 at 11:53 PM
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
-- Database: `pmo`
--

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
-- Table structure for table `capstone_project`
--

CREATE TABLE `capstone_project` (
  `skills_needed` varchar(600) NOT NULL,
  `milestone_1` varchar(600) NOT NULL,
  `milestone_2` varchar(600) NOT NULL,
  `final_deliverables` varchar(600) NOT NULL,
  `student_benefits` varchar(600) NOT NULL,
  `sponsor_benefits` varchar(600) NOT NULL,
  `company_provides` varchar(600) NOT NULL,
  `nda_or_mou` char(1) NOT NULL,
  `company_retain` char(1) NOT NULL,
  `work_on_site` char(1) NOT NULL,
  `work_sponsor_site` char(1) NOT NULL,
  `on_campus_present` char(1) NOT NULL,
  `virtual_present` char(1) NOT NULL,
  `num_of_teams` tinyint(1) NOT NULL,
  `availability` varchar(600) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `capstone_project`
--

INSERT INTO `capstone_project` (`skills_needed`, `milestone_1`, `milestone_2`, `final_deliverables`, `student_benefits`, `sponsor_benefits`, `company_provides`, `nda_or_mou`, `company_retain`, `work_on_site`, `work_sponsor_site`, `on_campus_present`, `virtual_present`, `num_of_teams`, `availability`, `project_id`) VALUES
('Programming, database, management, design', 'Build database', 'Build frontend', 'Finished product', 'You will learn something', 'We will get free work done', 'nothing, you do it', '0', '1', '0', '1', '1', '0', 3, 'Anythime call or email', 1),
('computer skills', 'type stuff', 'run programs', 'test and fix bugs', 'practice with programming', 'free software we might not use', 'vague guidance', '1', '1', '1', '1', '1', '1', 1, 'sometimes i may be', 5),
('everything', 'Testing MS1', 'Testing MS2', 'The project ', 'Learn about tech', 'free labor', 'spirtual guidence', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 3, 'All day lmao', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contractor`
--

CREATE TABLE `contractor` (
  `participant_id` bigint(20) UNSIGNED NOT NULL,
  `contract_start_date` date NOT NULL,
  `contract_end_date` date NOT NULL,
  `title` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contractor`
--

INSERT INTO `contractor` (`participant_id`, `contract_start_date`, `contract_end_date`, `title`) VALUES
(4, '2020-03-25', '2020-03-31', 'QA Tester');

-- --------------------------------------------------------

--
-- Table structure for table `contract_for_hire`
--

CREATE TABLE `contract_for_hire` (
  `company_address` varchar(600) NOT NULL,
  `first_payment_amt` decimal(10,2) NOT NULL,
  `second_payment_amt` decimal(10,2) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contract_for_hire`
--

INSERT INTO `contract_for_hire` (`company_address`, `first_payment_amt`, `second_payment_amt`, `project_id`) VALUES
('123 made up ln. Marietta, Ga 30068', '34543.50', '645.56', 3),
('456 fake blvd. Douglasville, GA 30135', '5445.54', '2323.87', 6);

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
-- Table structure for table `faculty_and_staff`
--

CREATE TABLE `faculty_and_staff` (
  `participant_id` bigint(20) UNSIGNED NOT NULL,
  `department` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty_and_staff`
--

INSERT INTO `faculty_and_staff` (`participant_id`, `department`, `title`) VALUES
(2, 'Information Technology', 'Professor'),
(3, 'Computer Science', 'Department Head');

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
(1, 'Testing Update 2', 'Analytics and Data Science', '2018-12-11', '2020-03-04', 'High', 'n/a', '12414.54', 'Stuff happened'),
(2, 'More Things', 'Computer Science', '2013-08-11', '2021-12-09', 'Medium', 'yes', '2132.87', 'They are working'),
(3, 'Jobin', 'Information Technology', '2020-01-02', '2023-03-01', 'High', 'n/a', '414.00', 'I dont know'),
(4, 'Another One', 'Software Engineering and Game Development', '2018-08-12', '2021-02-02', 'Low', 'n/a', '42343.00', 'Put words here'),
(6, 'Things and Stuff', 'Computer Science', '2019-05-14', '2020-03-12', 'Medium', 'yes', '58778.00', 'Its important'),
(7, 'Pointless Words', 'Information Technology', '2019-05-25', '2019-07-19', 'Medium', 'yes', '43234.00', 'dead kennedys'),
(8, 'Good God', 'Information Technology', '2018-09-19', '2021-08-18', 'Low', 'n/a', '0.00', 'Whats happening'),
(9, 'Always Ready', 'Software Engineering and Game Development', '2018-03-02', '2025-08-12', 'Low', 'n/a', '0.00', 'Good for you'),
(10, 'Last One', 'Software Engineering and Game Development', '2018-04-12', '2020-07-09', 'High', 'yes', '343255.00', 'free labor'),
(11, 'One More', 'Information Technology', '2012-09-09', '2020-09-09', 'Medium', 'n/a', '545443.00', 'Thats it'),
(12, 'Test', 'Computer Science', '1983-07-01', '2020-09-09', 'Medium', 'n/a', '0.00', 'it worked');

-- --------------------------------------------------------

--
-- Table structure for table `project_participant`
--

CREATE TABLE `project_participant` (
  `participant_id` bigint(20) UNSIGNED NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `participant_category` varchar(45) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `email` varchar(320) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_participant`
--

INSERT INTO `project_participant` (`participant_id`, `last_name`, `first_name`, `participant_category`, `organization_name`, `email`, `phone`, `project_id`) VALUES
(1, 'Smith', 'John', 'Student', 'KSU', 'j.s@gmail.com', '4708092691', 1),
(2, 'Jones', 'Mark', 'Faculty', 'KSU', 'm.j@gmail.com', '770-947-2984', 5),
(3, 'Thompson', 'Tom', 'Staff', 'KSU', 't.t@yahoo.com', '404-445-5676', 3),
(4, 'brown', 'Abe', 'Contractor', 'Big Bytes Inc.', 'a.b@gmail.com', '678-938-0572', 3),
(5, 'Carter', 'Jack', 'Sponsor', 'Initech', 'j.c@gmail.com', '222-222-2222', 6),
(6, 'erkel', 'steve', 'Student', 'KSU', 's.e@yahoo.com', '4444444444', 4),
(7, 'forsyth', 'carl', 'Sponsor', 'KSU', 'c.f@gmail.com', '8888888888', 7);

-- --------------------------------------------------------

--
-- Table structure for table `research_project`
--

CREATE TABLE `research_project` (
  `topic` varchar(600) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `research_project`
--

INSERT INTO `research_project` (`topic`, `project_id`) VALUES
('Embedded Devices', 4),
('Snoop Reference', 7);

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
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `participant_id` bigint(20) UNSIGNED NOT NULL,
  `major` varchar(45) NOT NULL,
  `degree_level` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`participant_id`, `major`, `degree_level`) VALUES
(1, 'Computer Science', 'Masters of Science'),
(6, 'Information Technology', 'Bachelors of Science');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_file`
--

CREATE TABLE `tbl_file` (
  `id` int(11) NOT NULL,
  `name` varchar(12) NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `user_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `created_at`, `user_admin`) VALUES
(37, 'admin', '$2y$10$nxfGG7ibcxOskO7Ip5jwEuF/mSosDBkyL0VnCs/q3xN4pgfH0sWAW', '2020-03-29 15:46:23', 1),
(38, 'standard', '$2y$10$sOYxPR76ijukg7TRstl3E.4bOVPIyfp.KszcqydRUEizv5qS1F2Vi', '2020-03-29 16:45:48', 0),
(41, 'admin2', '$2y$10$beuYUTTao7rwkhtkvKF.8OsxDBI0HAd8VCeF6ei7/0NpOJsB9UKSm', '2020-03-29 17:05:50', 1);

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
(15, 'adminz', '$2y$10$FSDYUC9G0MXAgB3fLfE8kuL/aaEo9pUVM06f.wrKBgIk6RZq/omPK', '2020-03-11 09:38:28', 1),
(16, 'mikey', '$2y$10$5BoKWt8EWtBQZlhRMbbCxuTNktzoI7wgJl3CAz0e4LCYbd4gAmuoO', '2020-03-12 17:40:26', 0),
(17, 'mikey2', '$2y$10$knvrhYsaiJpLazF1io80gexAkh7DFDuI7PnjXlH35e3h25V3SXGc2', '2020-03-12 17:40:49', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Affiliate`
--
ALTER TABLE `Affiliate`
  ADD PRIMARY KEY (`affiliate_id`);

--
-- Indexes for table `capstone_project`
--
ALTER TABLE `capstone_project`
  ADD KEY `fkIdx_853` (`project_id`);

--
-- Indexes for table `contract_for_hire`
--
ALTER TABLE `contract_for_hire`
  ADD KEY `fkIdx_859` (`project_id`);

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
-- Indexes for table `faculty_and_staff`
--
ALTER TABLE `faculty_and_staff`
  ADD KEY `fkIdx_697` (`participant_id`);

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
-- Indexes for table `project_participant`
--
ALTER TABLE `project_participant`
  ADD PRIMARY KEY (`participant_id`),
  ADD KEY `fkIdx_805` (`project_id`);

--
-- Indexes for table `research_project`
--
ALTER TABLE `research_project`
  ADD KEY `fkIdx_850` (`project_id`);

--
-- Indexes for table `Sponsor`
--
ALTER TABLE `Sponsor`
  ADD KEY `fkIdx_43` (`affiliate_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD KEY `fkIdx_780` (`participant_id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
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
  MODIFY `project_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `project_participant`
--
ALTER TABLE `project_participant`
  MODIFY `participant_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contract_for_hire`
--
ALTER TABLE `contract_for_hire`
  ADD CONSTRAINT `FK_859` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `faculty_and_staff`
--
ALTER TABLE `faculty_and_staff`
  ADD CONSTRAINT `FK_697` FOREIGN KEY (`participant_id`) REFERENCES `project_participant` (`participant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Phone_Contact`
--
ALTER TABLE `Phone_Contact`
  ADD CONSTRAINT `FK_38` FOREIGN KEY (`affiliate_id`) REFERENCES `Affiliate` (`affiliate_id`);

--
-- Constraints for table `research_project`
--
ALTER TABLE `research_project`
  ADD CONSTRAINT `FK_850` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Sponsor`
--
ALTER TABLE `Sponsor`
  ADD CONSTRAINT `FK_43` FOREIGN KEY (`affiliate_id`) REFERENCES `Affiliate` (`affiliate_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_780` FOREIGN KEY (`participant_id`) REFERENCES `project_participant` (`participant_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
