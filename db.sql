-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2015 at 07:22 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `3rd year individual project`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE IF NOT EXISTS `assignments` (
  `AssignmentID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseID` int(11) NOT NULL,
  `AssignmentName` varchar(100) NOT NULL,
  `Description` varchar(500) NOT NULL,
  PRIMARY KEY (`AssignmentID`),
  KEY `CourseID` (`CourseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`AssignmentID`, `CourseID`, `AssignmentName`, `Description`) VALUES
(4, 2, 'Question 1', ''),
(5, 2, 'Question 2', ''),
(6, 3, 'Question 1', ''),
(7, 3, 'Question 2', ''),
(8, 3, 'Question 2', ''),
(9, 3, 'Question 3', ''),
(102, 35, 'Coursework 1', 'Just checking m8'),
(103, 35, 'Coursework 2', 'A short description');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `CourseID` int(11) NOT NULL AUTO_INCREMENT,
  `Course` varchar(100) NOT NULL,
  `EnrollKey` varchar(50) NOT NULL,
  PRIMARY KEY (`CourseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`CourseID`, `Course`, `EnrollKey`) VALUES
(2, 'Basic C Programming 102', ''),
(3, 'Basic C Programming 105', ''),
(5, 'Basic C Programming 202', ''),
(33, 'Dummy course', ''),
(34, 'Dummy course', ''),
(35, 'Basic C Programming 101', '101'),
(36, 'Operating Systems', 'OS');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE IF NOT EXISTS `enrollments` (
  `Username` varchar(65) NOT NULL DEFAULT '',
  `CourseID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Username`,`CourseID`),
  KEY `Course must exist` (`CourseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`Username`, `CourseID`) VALUES
('Admin', 2),
('Jon', 2),
('Admin', 3),
('Jon', 5),
('Admin', 35),
('Jon', 35),
('Admin', 36);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `Username` varchar(50) NOT NULL,
  `TestCaseID` int(11) NOT NULL,
  `Filename` varchar(25) NOT NULL,
  `RealFilename` varchar(100) NOT NULL,
  `Directory` varchar(150) NOT NULL,
  PRIMARY KEY (`Username`,`TestCaseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`Username`, `TestCaseID`, `Filename`, `RealFilename`, `Directory`) VALUES
('Jon', 18, 'RQXyVVCIt4kEzeKDT2Ej.c', 'strToUpper.c', 'uploads'),
('Jon', 28, 'ugeuJCmBZo7INBSiIJLc.c', 'userfile.c', 'uploads'),
('Jon', 31, 'XmekbVsrwBhf90ELLC62.c', 'userfile.c', 'uploads'),
('Jon', 32, '7h5Rd0qbXsmMAZ1Ng7no.c', 'userfile.c', 'uploads'),
('Jon', 33, 'J3289Y5HaFBrnA5qo7se.c', 'userfile.c', 'uploads'),
('NewUser', 18, 'dnIQF9JrF0WCCOs5j1Kl.c', 'strToUpper.c', 'uploads'),
('NewUser', 28, 'risUIrgMrS4OIwA9m9Lm.c', 'shell.c', 'uploads'),
('User1', 18, 'F6bQadtC8FfCynNlgiak.c', 'strToUpper.c', 'uploads'),
('User1', 28, 'PfSyWqZPu5ycph9NJZbM.c', '', 'uploads'),
('User2', 18, '8cCjvgTesGawyLDzhSv3.c', 'strToUpper.c', 'uploads'),
('User2', 33, 'nkfNOgM9jvN4s700skNo.c', 'strToUpper.c', 'uploads');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `Username` varchar(50) NOT NULL,
  `TestCaseID` int(11) NOT NULL,
  `Grade` float NOT NULL DEFAULT '0',
  `Comments` varchar(5000) NOT NULL,
  PRIMARY KEY (`Username`,`TestCaseID`),
  KEY `Username` (`Username`),
  KEY `TestCaseID` (`TestCaseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`Username`, `TestCaseID`, `Grade`, `Comments`) VALUES
('Jon', 18, 100, 'AS<br />\nOOOP<br />\nDEUH<br />\nMEH<br />\nLOOL<br />\nMFEKJ<br />\nQWOIFN<br />\n.D.D.D.D.DJFOQWJF<br />\nQWOIFN<br />\nLine 1: no copyright notice found<br />\r\nLine 11: horizontal tab used<br />\r\nLine 12: horizontal tab used<br />\r\nLine 13: horizontal tab used<br />\r\nLine 14: horizontal tab used<br />\r\nLine 15: horizontal tab used<br />\r\nLine 16: horizontal tab used<br />\r\nLine 17: horizontal tab used<br />\r\nLine 18: horizontal tab used<br />\r\nLine 19: horizontal tab used<br />\r\nLine 23: too many consecutive empty lines<br />\r\nLine 30: trailing empty line(s)<br />\r\n'),
('Jon', 28, 25, ''),
('Jon', 32, 0, ''),
('Jon', 33, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `testcases`
--

CREATE TABLE IF NOT EXISTS `testcases` (
  `TestCaseID` int(11) NOT NULL AUTO_INCREMENT,
  `AssignmentID` int(11) NOT NULL,
  `TestCaseName` varchar(200) NOT NULL,
  `Description` varchar(500) NOT NULL,
  PRIMARY KEY (`TestCaseID`),
  KEY `AssignmentID` (`AssignmentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `testcases`
--

INSERT INTO `testcases` (`TestCaseID`, `AssignmentID`, `TestCaseName`, `Description`) VALUES
(18, 102, 'Question 1 - strToUpper', ''),
(22, 102, 'Question 3 - isPalindrome', ''),
(28, 102, 'Question 2 - strToLower', ''),
(32, 103, 'Question 1 - Simple Addition', 'Write a program that adds comma separated values eg. 1,4,5,10 = 20'),
(33, 4, 'Nothin', '');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `TestID` int(11) NOT NULL AUTO_INCREMENT,
  `TestCaseID` int(11) NOT NULL,
  `Input` varchar(200) NOT NULL,
  `Output` varchar(200) NOT NULL,
  PRIMARY KEY (`TestID`),
  KEY `TestCaseID` (`TestCaseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`TestID`, `TestCaseID`, `Input`, `Output`) VALUES
(3, 18, 'as', 'AS'),
(4, 18, 'ooop', 'OOOP'),
(5, 18, 'deuh', 'DEUH'),
(6, 18, 'meh', 'MEH'),
(25, 18, 'lool', 'LOOL'),
(26, 18, 'mfekj', 'MFEKJ'),
(27, 18, 'QWOIFN', 'QWOIFN'),
(28, 18, '.d.d.d.d.djfoqwjf', '.D.D.D.D.DJFOQWJF'),
(29, 18, 'QWOIFN', 'QWOIFN'),
(30, 28, 'olodinbg', 'olodinbg'),
(31, 28, 'OLDAD', 'oldad'),
(32, 28, 'mkaER', 'mkaer'),
(33, 28, 'mkaER', 'mkaer'),
(34, 32, '1,2,3,4', '10'),
(35, 32, '', ''),
(36, 32, '1', '1'),
(37, 33, 'vd', 'vd'),
(38, 32, '24,10000000, 0.3', '10000024.3');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `UploadID` int(25) NOT NULL AUTO_INCREMENT,
  `Username` varchar(65) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `Directory` varchar(32) NOT NULL,
  `Filename` varchar(35) NOT NULL,
  PRIMARY KEY (`UploadID`),
  KEY `Username` (`Username`),
  KEY `CourseID` (`CourseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`UploadID`, `Username`, `CourseID`, `Directory`, `Filename`) VALUES
(8, 'Jon', 2, '/uploads', 'coursework2'),
(9, 'Jon', 3, '/uploads', 'coursework3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `Username` varchar(65) NOT NULL,
  `fName` varchar(35) NOT NULL,
  `lName` varchar(35) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Username`, `fName`, `lName`, `Password`, `Email`, `Admin`) VALUES
('Admin', 'Ryan', 'Johnstone', '$2y$10$KbFL0LbJT0CdKkL906mOouyPoMQ.eHEfPPzeDwjNKCAtx3pwO1eMm', 'admin@soucecode.com', 1),
('admins', 'Ryan', 'Johns', '$2y$10$/5Z4WZrnZQjC.vQSgUoqrep5mqBD8JVC5nGtfjkXUrNrXYyW8YhYK', 'admin@soucecode.com', 1),
('Jon', 'Jon', 'Bentley', '$2y$10$KbFL0LbJT0CdKkL906mOouyPoMQ.eHEfPPzeDwjNKCAtx3pwO1eMm', 'me@exmaple.com', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `Assignment course must exist in courses` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `Course must exist` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `User must exist` FOREIGN KEY (`Username`) REFERENCES `users` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grade for user that exists` FOREIGN KEY (`Username`) REFERENCES `users` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `test case must exist` FOREIGN KEY (`TestCaseID`) REFERENCES `testcases` (`TestCaseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `testcases`
--
ALTER TABLE `testcases`
  ADD CONSTRAINT `test belongs to an assignment` FOREIGN KEY (`AssignmentID`) REFERENCES `assignments` (`AssignmentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests are a part of a test case` FOREIGN KEY (`TestCaseID`) REFERENCES `testcases` (`TestCaseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `File must belong to a user` FOREIGN KEY (`Username`) REFERENCES `users` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Upload must part of a course` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
