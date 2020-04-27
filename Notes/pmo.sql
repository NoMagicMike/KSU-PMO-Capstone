-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 21, 2020 at 02:37 AM
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
-- Table structure for table `capstone_project`
--

CREATE TABLE `capstone_project` (
  `degree_level` tinyint(1) NOT NULL,
  `skills_needed` varchar(600) NOT NULL,
  `milestone_1` varchar(600) NOT NULL,
  `milestone_2` varchar(600) NOT NULL,
  `final_deliverables` varchar(600) NOT NULL,
  `student_benefits` varchar(600) NOT NULL,
  `sponsor_benefits` varchar(600) NOT NULL,
  `company_provides` varchar(600) NOT NULL,
  `nda_or_mou` tinyint(1) NOT NULL,
  `company_retain` tinyint(1) NOT NULL,
  `work_on_site` tinyint(1) NOT NULL,
  `work_sponsor_site` tinyint(1) NOT NULL,
  `on_campus_present` tinyint(1) NOT NULL,
  `virtual_present` tinyint(1) NOT NULL,
  `num_of_teams` tinyint(1) NOT NULL,
  `availability` varchar(600) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `capstone_project`
--

INSERT INTO `capstone_project` (`degree_level`, `skills_needed`, `milestone_1`, `milestone_2`, `final_deliverables`, `student_benefits`, `sponsor_benefits`, `company_provides`, `nda_or_mou`, `company_retain`, `work_on_site`, `work_sponsor_site`, `on_campus_present`, `virtual_present`, `num_of_teams`, `availability`, `project_id`) VALUES
(0, 'stuff, things, more stuff', 'first things', 'second things', 'last things', 'you learn', 'stuff is made', 'good advice', 0, 1, 0, 0, 1, 0, 3, 'monday through friday 9-5', 105),
(0, 'computer, time management', 'the beginning', 'the middle', 'the end', 'they get smarter', 'they get free help', 'guidance', 0, 1, 0, 0, 1, 0, 2, 'anything via cell', 106);

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
(333, '2020-04-08', '2020-05-31', 'QA tester'),
(334, '2020-04-08', '2020-04-30', 'Developer'),
(335, '2020-04-30', '2020-05-31', 'Network Engineer'),
(339, '2020-04-23', '2020-04-29', 'developer'),
(340, '2020-04-30', '2020-04-30', 'computer engineer');

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
('123 fake road, Marietta GA 30068', '30000.00', '4276.00', 107),
('456 made up ln. Atlanta Ga 30135', '2300000.00', '42332.00', 108);

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
(316, 'Software Engineering and Game Development', 'Assistant'),
(317, 'Computer Science', 'Coordinator'),
(324, 'Computer Science', 'Professor'),
(329, 'Information Technology', 'Professor'),
(330, 'Computer Science', 'Professor'),
(337, 'Software Engineering and Game Development', 'Student Rep.'),
(342, 'Computer Science', 'Student rep'),
(347, 'Information Technology', 'Student rep. '),
(348, 'Information Technology', 'Helper '),
(351, 'Computer Science', 'Assistant');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `project_category` varchar(45) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `project_title` varchar(100) NOT NULL,
  `ksu_department` varchar(45) NOT NULL,
  `priority_level` varchar(10) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `funded` enum('Yes','No','N/A') NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `description` varchar(600) NOT NULL,
  `approval` enum('Approved','Disapproved','Pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_category`, `organization_name`, `project_title`, `ksu_department`, `priority_level`, `start_date`, `end_date`, `funded`, `total_cost`, `description`, `approval`) VALUES
(105, 'Capstone', 'KSU ', 'PMO Website', 'Information Technology', 'Low', '2020-04-01', '2020-04-30', 'N/A', '0.00', 'Make a site for managing projects.', 'Approved'),
(106, 'Capstone', 'KSU ', 'AI for organizing Capstone Project Requests', 'Computer Science', 'Low', '2020-04-03', '2020-05-28', 'No', '4233.66', 'Make AI stuff with Python', 'Approved'),
(107, 'Contract for Hire', 'CDC', 'Virus Tracking System', 'Computer Science', 'High', '2020-04-08', '2020-05-31', 'Yes', '34276.00', 'Build a system that tracks the spread and stats of a virus', 'Approved'),
(108, 'Contract for Hire', 'Fake Startup Inc.', 'AI Robot', 'Computer Science', 'Medium', '2020-04-01', '2020-04-30', 'Yes', '2342332.00', 'Built a robot', 'Approved'),
(109, 'Research', 'National Wildlife Association ', 'Software for Animal stuff', 'Information Technology', 'Medium', '2020-04-15', '2020-04-30', 'Yes', '23432.00', 'struggling to come up with stuff', 'Approved'),
(110, 'Research', 'Big Bytes Inc.', 'Computing Things ', 'Software Engineering and Game Development', 'High', '2020-04-29', '2020-04-30', 'N/A', '0.00', 'Make computers do stuff', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `project_file`
--

CREATE TABLE `project_file` (
  `file_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(45) NOT NULL,
  `file_path` varchar(100) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_file`
--

INSERT INTO `project_file` (`file_id`, `file_name`, `file_path`, `project_id`) VALUES
(20, 'Project Plan Document.docx', '/Applications/XAMPP/xamppfiles/htdocs/uploads/Project Plan Document.docx', 106),
(21, 'BurndownChart.xlsx', '/Applications/XAMPP/xamppfiles/htdocs/uploads/BurndownChart.xlsx', 106),
(23, 'W13.docx', '/Applications/XAMPP/xamppfiles/htdocs/uploads/W13.docx', 105);

-- --------------------------------------------------------

--
-- Table structure for table `project_participant`
--

CREATE TABLE `project_participant` (
  `participant_id` bigint(20) UNSIGNED NOT NULL,
  `participant_category` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `participant_org` varchar(100) NOT NULL,
  `email` varchar(320) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_participant`
--

INSERT INTO `project_participant` (`participant_id`, `participant_category`, `last_name`, `first_name`, `participant_org`, `email`, `phone`, `project_id`) VALUES
(315, 'Sponsor', 'Tatum', 'Dawn', 'KSU', 'd.t@yahoo.com', '4709123456', 105),
(316, 'Faculty', 'smith', 'jane', 'KSU', 'j.s@gmail.com', '6789356712', 105),
(317, 'Faculty', 'jones', 'john', 'KSU', 'j.j@yahoo.com', '4049990234', 105),
(318, 'Student', 'mike ', 'kilinic', 'KSU', 'm.k@yahoo.com', '4049998888', 105),
(319, 'Student', 'jason', 'hazenfield', 'KSU', 'j.h@gmail.com', '6789234567', 105),
(320, 'Student', 'avery ', 'brown', 'KSU', 'a.b@yahoo.com', '4702332233', 105),
(321, 'Student', 'hanah ', 'fasial', 'KSU', 'h.f@gmail.com', '6789992376', 105),
(322, 'Student', 'shravan ', 'raul', 'KSU', 's.r@yahoo.com', '5647823456', 105),
(323, 'Sponsor', 'johnson', 'Maria', 'KSU', 'm.j@yahoo.com', '4042234323', 106),
(324, 'Faculty', 'boone', 'Richard', 'KSU', 'r.b@gmail.com', '4047895673', 106),
(325, 'Student', 'king', 'chris', 'ksu', 'c.k@gmail.com', '4047896149', 106),
(326, 'Student', 'jackson', 'sherry', 'ksu', 's.j@yahoo.com', '6789992345', 106),
(327, 'Student', 'brown', 'george', 'ksu', 'g.b@yahoo.com', '4044440404', 106),
(328, 'Sponsor', 'Slater', 'Josh', 'CDC', 'j.s@gmail.com', '4049998888', 107),
(329, 'Faculty', 'bush', 'barbra', 'KSU', 'b.b@gmail.com', '4045556666', 107),
(330, 'Faculty', 'smith', 'bob', 'KSU', 'b.s@yahoo.com', '4046667777', 107),
(331, 'Student', 'gonzalez', 'juan', 'KSU', 'j.g@gmail.com', '4550009999', 107),
(332, 'Student', 'dover', 'sam', 'KSU', 's.d@yahoo.com', '4041112345', 107),
(333, 'Contractor', 'brown', 'carol', 'CDC', 'c.b@gmail.com', '4345556789', 107),
(334, 'Contractor', 'green', 'matt', 'CDC', 'm.g@yahoo.com', '5556667777', 107),
(335, 'Contractor', 'powers', 'austin', 'Big Bytes Inc.', 'a.p@gmail.com', '6545678987', 107),
(336, 'Sponsor', 'black', 'seth', 'Fake Startup Inc.', 's.b@yahoo.com', '1234567890', 108),
(337, 'Faculty', 'bowden', 'marilyn', 'ksu', 'm.b@gmail.com', '3334445667', 108),
(338, 'Student', 'lane', 'wayne', 'ksu', 'w.l@yahoo.com', '3456765456', 108),
(339, 'Contractor', 'dude', 'guy', 'Fake Startup Inc.', 'g.d@yahoo.com', '2343234323', 108),
(340, 'Contractor', 'mann', 'james', 'Fake Startup Inc.', 'j.m@gmail.com', '6784557654', 108),
(341, 'Sponsor', 'Fox', 'Redd', 'NWA', 'r.f@yahoo.com', '4565791034', 109),
(342, 'Faculty', 'thompson', 'rachel', 'KSU', 'r.t@gmail.com', '2343454567', 109),
(343, 'Student', 'turner', 'jim', 'KSU', 'j.t@gmail.com', '6545654565', 109),
(344, 'Student', 'pitt', 'mark', 'KSU', 'm.p@yahoo.com', '4567784104', 109),
(345, 'Student', 'joplin', 'frank', 'KSU', 'f.j@gmail.com', '6545132195', 109),
(346, 'Sponsor', 'davis', 'ron', 'Big Bytes Inc.', 'r.d@gmail.com', '9874561239', 110),
(347, 'Faculty', 'kelly', 'jane', 'KSU', 'j.k@yahoo.com', '8274619034', 110),
(348, 'Staff', 'green', 'jimbo', 'KSU', 'j.g@gmail.com', '9293949596', 110),
(349, 'Student', 'hogan', 'hulk', 'KSU', 'h.h@yahoo.com', '5676234567', 110),
(350, 'Student', 'johnson', 'dwayne', 'KSU', 'd.j@gmail.com', '5821349564', 110),
(351, 'Staff', 'buris', 'bill', 'KSU', 'b.b@gmail.com', '8382818586', 105);

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
('calculations', 110),
('Animals', 109);

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
(318, 'Information Technology (BS)', 'Bachelor of Science'),
(319, 'Information Technology (BS)', 'Bachelor of Science'),
(320, 'Information Technology (BS)', 'Bachelor of Science'),
(321, 'Information Technology (BS)', 'Bachelor of Science'),
(322, 'Information Technology (BS)', 'Bachelor of Science'),
(325, 'Software Engineering', 'Bachelor of Science'),
(326, 'Software Engineering', 'Bachelor of Science'),
(327, 'Software Engineering', 'Bachelor of Science'),
(331, 'Analytics and Data Science', 'Doctor of Philosophy'),
(332, 'Applied Computer Science', 'Doctor of Philosophy'),
(338, 'Analytics and Data Science', 'Doctor of Philosophy'),
(343, 'Analytics and Data Science', 'Doctor of Philosophy'),
(344, 'Computer Science', 'Master of Science'),
(345, 'Information Technology (BS)', 'Master of Science'),
(349, 'Computer Game Design and Development', 'Bachelor of Science'),
(350, 'Software Engineering', 'Master of Science');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT current_timestamp(),
  `user_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `created_at`, `user_admin`) VALUES
(37, 'admin', '$2y$10$nxfGG7ibcxOskO7Ip5jwEuF/mSosDBkyL0VnCs/q3xN4pgfH0sWAW', '2020-03-29 15:46:23', 1),
(38, 'standard', '$2y$10$sOYxPR76ijukg7TRstl3E.4bOVPIyfp.KszcqydRUEizv5qS1F2Vi', '2020-03-29 16:45:48', 0),
(41, 'admin2', '$2y$10$beuYUTTao7rwkhtkvKF.8OsxDBI0HAd8VCeF6ei7/0NpOJsB9UKSm', '2020-03-29 17:05:50', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `capstone_project`
--
ALTER TABLE `capstone_project`
  ADD KEY `fkIdx_853` (`project_id`);

--
-- Indexes for table `contractor`
--
ALTER TABLE `contractor`
  ADD KEY `fkIdx_703` (`participant_id`);

--
-- Indexes for table `contract_for_hire`
--
ALTER TABLE `contract_for_hire`
  ADD KEY `fkIdx_859` (`project_id`);

--
-- Indexes for table `faculty_and_staff`
--
ALTER TABLE `faculty_and_staff`
  ADD KEY `fkIdx_697` (`participant_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_file`
--
ALTER TABLE `project_file`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `project_file_pk_fk` (`project_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `project_file`
--
ALTER TABLE `project_file`
  MODIFY `file_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `project_participant`
--
ALTER TABLE `project_participant`
  MODIFY `participant_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=396;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `capstone_project`
--
ALTER TABLE `capstone_project`
  ADD CONSTRAINT `FK_853` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contractor`
--
ALTER TABLE `contractor`
  ADD CONSTRAINT `FK_703` FOREIGN KEY (`participant_id`) REFERENCES `project_participant` (`participant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contract_for_hire`
--
ALTER TABLE `contract_for_hire`
  ADD CONSTRAINT `FK_859` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faculty_and_staff`
--
ALTER TABLE `faculty_and_staff`
  ADD CONSTRAINT `FK_697` FOREIGN KEY (`participant_id`) REFERENCES `project_participant` (`participant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_file`
--
ALTER TABLE `project_file`
  ADD CONSTRAINT `project_file_pk_fk` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_participant`
--
ALTER TABLE `project_participant`
  ADD CONSTRAINT `FK_805` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `research_project`
--
ALTER TABLE `research_project`
  ADD CONSTRAINT `FK_850` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_780` FOREIGN KEY (`participant_id`) REFERENCES `project_participant` (`participant_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
