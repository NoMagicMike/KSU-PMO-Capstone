-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 09, 2020 at 01:47 AM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$pg4yRSogbx4F0EnzRIBcL.ykBTURGUpBkjesH1W7c1qAbLYuwb4su', '2020-03-08 19:08:25');

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
