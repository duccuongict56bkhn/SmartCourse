-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 16, 2014 at 01:48 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `studyhub`
--
CREATE DATABASE IF NOT EXISTS `studyhub` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `studyhub`;

-- --------------------------------------------------------

--
-- Table structure for table `sm_courses`
--

CREATE TABLE IF NOT EXISTS `sm_courses` (
  `cat_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL AUTO_INCREMENT,
  `course_code` varchar(10) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `course_alias` varchar(100) CHARACTER SET utf32 NOT NULL COMMENT 'Alias to create a folder for course in PHP',
  `course_type` varchar(10) NOT NULL COMMENT '1 - Self-study; 2 - Period course',
  `course_desc` text COMMENT 'For storing a large number of texts, should use this TEXT',
  `start_date` datetime DEFAULT NULL,
  `length` int(5) DEFAULT NULL COMMENT 'The length of the course in weeks',
  `course_avatar` varchar(500) DEFAULT 'images/courses/css-thumbnail.png',
  `course_cover` varchar(1000) NOT NULL,
  `school` varchar(255) NOT NULL,
  PRIMARY KEY (`course_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Courses that are currently available in the system' AUTO_INCREMENT=31 ;

--
-- Dumping data for table `sm_courses`
--

INSERT INTO `sm_courses` (`cat_id`, `course_id`, `course_code`, `course_title`, `course_alias`, `course_type`, `course_desc`, `start_date`, `length`, `course_avatar`, `course_cover`, `school`) VALUES
(1, 19, 'CS2250', 'Fundamentals to Databases', 'dbstanford', '2', '"Introduction to Databases" had a very successful public offering in fall 2011, as one of Stanford''s inaugural three massive open online courses. Since then, the course materials have been improved and expanded, and we''re excited to be launching a second public offering of the course in winter 2013. The course includes video lectures and demos with in-video quizzes to check understanding, in-depth standalone quizzes, a wide variety of automatically-checked interactive programming exercises, midterm and final exams, a discussion forum, optional additional exercises with solutions, and pointers to readings and resources. Taught by Professor Jennifer Widom, the curriculum draws from Stanford''s popular Introduction to Databases course', '2014-02-01 12:30:00', 20, 'images/courses/database-thumbnail.png', '', 'Stanford University'),
(1, 29, 'IT3258E', 'Fundamentals of Cryptography', 'crypto-010', '2', 'Some description for Fundamentals of Cryptography', '2014-03-12 00:00:00', 14, 'images/courses/css-thumbnail.png', '', 'UC Berkeley'),
(9, 30, '6.041x', 'Introduction to Probability', 'introprob', '2', 'Some description for Introduction to Probability', '2014-04-01 00:00:00', 12, 'images/courses/css-thumbnail.png', '', 'HUST');

-- --------------------------------------------------------

--
-- Table structure for table `sm_course_announcements`
--

CREATE TABLE IF NOT EXISTS `sm_course_announcements` (
  `user_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `anno_id` int(10) NOT NULL,
  `anno_title` varchar(255) NOT NULL,
  `anno_content` text NOT NULL,
  `create_date` int(15) NOT NULL COMMENT 'The time annoucement is made',
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `anno_type` int(3) NOT NULL DEFAULT '1' COMMENT '1 - Normal; 2 - Important; 3 - Urgent',
  PRIMARY KEY (`user_id`,`course_id`,`anno_id`),
  KEY `sm_course_announcements_fk2` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sm_course_announcements`
--

INSERT INTO `sm_course_announcements` (`user_id`, `course_id`, `anno_id`, `anno_title`, `anno_content`, `create_date`, `valid_from`, `valid_to`, `anno_type`) VALUES
(20, 19, 2, 'Tested 3', 'Bootstrap Image Gallery is a complete gallery solution for bootstrap. After you include the needed files in your page, you get a grid of images which open in modal windows. The gallery can also optionally go into fullscreen mode. Note that there is now an improved version of this plugin which drops the Bootstrap requirement, so you can use it in any project.', 1298902753, '2014-05-13', '2014-05-11', 1),
(20, 19, 3, 'Lorem Announcement', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', 1398902853, '2014-05-14', '2014-05-28', 2),
(20, 19, 5, 'Create announcement from form', 'This announcement is created through form', 1400180212, '2014-05-13', '2014-05-19', 2),
(20, 19, 7, 'Create announcement from form', 'This announcement is created through form', 1400180297, '2014-05-13', '2014-05-19', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sm_course_cat`
--

CREATE TABLE IF NOT EXISTS `sm_course_cat` (
  `cat_id` int(10) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(100) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Course catagories' AUTO_INCREMENT=10 ;

--
-- Dumping data for table `sm_course_cat`
--

INSERT INTO `sm_course_cat` (`cat_id`, `cat_title`) VALUES
(1, 'Computer Science: Systems & Security'),
(2, 'Computer Science: Software Engineering'),
(3, 'Computer Science: Networks'),
(4, 'Physics'),
(5, 'Chemistry'),
(6, 'Humanity'),
(7, 'Economics and Finance'),
(8, 'Biomedical Engineering'),
(9, 'Mathematics');

-- --------------------------------------------------------

--
-- Table structure for table `sm_create_course`
--

CREATE TABLE IF NOT EXISTS `sm_create_course` (
  `user_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `create_date` int(15) NOT NULL,
  PRIMARY KEY (`user_id`,`course_id`),
  KEY `sm_create_course_ibfk_2` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Store information for the creation of courses by teachers';

--
-- Dumping data for table `sm_create_course`
--

INSERT INTO `sm_create_course` (`user_id`, `course_id`, `create_date`) VALUES
(20, 19, 1399113079),
(20, 29, 1399868787),
(20, 30, 1399875099);

-- --------------------------------------------------------

--
-- Table structure for table `sm_do_exercise`
--

CREATE TABLE IF NOT EXISTS `sm_do_exercise` (
  `user_id` int(10) NOT NULL,
  `exercise_id` int(10) NOT NULL,
  `answer_mul` char(2) NOT NULL,
  `answer_text` text NOT NULL,
  `attempt_made` int(5) NOT NULL,
  `attempt_timestamp` int(15) NOT NULL,
  PRIMARY KEY (`user_id`,`exercise_id`),
  KEY `sm_do_exercise_exercise_id_fk` (`exercise_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sm_enroll_course`
--

CREATE TABLE IF NOT EXISTS `sm_enroll_course` (
  `user_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `enroll_date` int(15) NOT NULL,
  `unenroll_date` date DEFAULT NULL,
  `result` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`course_id`),
  KEY `user_id` (`user_id`),
  KEY `sm_enroll_course_ibfk_2` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sm_exercises`
--

CREATE TABLE IF NOT EXISTS `sm_exercises` (
  `unit_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `exercise_id` int(10) NOT NULL,
  `exercise_title` varchar(255) NOT NULL,
  `question` text NOT NULL,
  `question_type` int(2) NOT NULL COMMENT '1 - Multiple choice; 2 - Written',
  `multi_one` text,
  `multi_two` text,
  `multi_three` text,
  `multi_four` text,
  `correct_answer` varchar(10000) NOT NULL,
  `attempt_limit` int(5) NOT NULL COMMENT 'Limit the false attempt that user can make on this question',
  `score` int(10) NOT NULL COMMENT 'The score for a correct answer',
  PRIMARY KEY (`unit_id`,`course_id`,`exercise_id`),
  KEY `unit_id` (`unit_id`),
  KEY `sm_exercise_course_id_fk` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sm_exercises`
--

INSERT INTO `sm_exercises` (`unit_id`, `course_id`, `exercise_id`, `exercise_title`, `question`, `question_type`, `multi_one`, `multi_two`, `multi_three`, `multi_four`, `correct_answer`, `attempt_limit`, `score`) VALUES
(3, 19, 1, 'Question 1', '<p>We''re interested in well-formed XML that satisfies the following conditions:</p><p></p><ul><li>It has root element "tasklist"</li><li>The root element has three "task" elements</li><li>Each of the "task" subelements has an attribute named "name"<br></li><li>The values of the "name" attributes for the 3 tasks are "eat", "drink", and "play"</li></ul>Select, from the choices below, the well-formed XML that meets the above requirements.<div><span style="font-style: italic;">Code A</span><br><p></p><p></p><pre style="padding: 10px; margin-bottom: 10.5px; line-height: 21px; border-color: rgba(0, 0, 0, 0.14902);">&lt;tasklist&gt;\r\n  &lt;task name="eat"&gt;\r\n  &lt;task name="drink"&gt;\r\n  &lt;task name="play"&gt;\r\n&lt;/tasklist&gt;</pre><p><span style="font-style: italic;">Code B</span></p><pre style="padding: 10px; margin-bottom: 10.5px; line-height: 21px; border-color: rgba(0, 0, 0, 0.14902);">&lt;tasklist&gt;\r\n  &lt;task name=eat/&gt;\r\n  &lt;task name=drink/&gt;\r\n  &lt;task name=play/&gt;\r\n&lt;/tasklist&gt;</pre><p><span style="font-style: italic;">Code C</span></p><pre style="padding: 10px; margin-bottom: 10.5px; line-height: 21px; border-color: rgba(0, 0, 0, 0.14902);">&lt;tasklist&gt;\r\n  &lt;task name="eat"&gt;&lt;/task&gt;\r\n  &lt;task name="drink"&gt;&lt;/task&gt;\r\n  &lt;task name="play"&gt;&lt;/task&gt;\r\n&lt;/tasklist&gt;</pre><p><span style="font-style: italic;">Code D</span></p><pre style="padding: 10px; margin-bottom: 10.5px; line-height: 21px; border-color: rgba(0, 0, 0, 0.14902);">&lt;tasklist&gt;\r\n  &lt;task name="eat"/&gt;\r\n&lt;/tasklist&gt;\r\n&lt;tasklist&gt;\r\n  &lt;task name="drink"/&gt;\r\n&lt;/tasklist&gt;\r\n&lt;tasklist&gt;\r\n  &lt;task name="play"/&gt;\r\n&lt;/tasklist&gt;</pre></div>', 1, 'Code A', 'Code B', 'Code C', 'Code D', 'C', 100, 10),
(3, 19, 2, 'Question 2', '<p>An XML Document contain the following portion:</p><pre style="padding: 10px; margin-bottom: 10.5px; line-height: 21px; border-color: rgba(0, 0, 0, 0.14902);"><font color="blue">     &lt;INFO&gt;\r\n         &lt;ADDR&gt;101 Maple St.&lt;/ADDR&gt;\r\n         &lt;PHONE&gt;555-1212&lt;/PHONE&gt;\r\n         &lt;PHONE&gt;555-4567&lt;/PHONE&gt;\r\n     &lt;/INFO&gt;</font></pre><p>Which of the following could be the INFO element specification in a DTD that the document match</p>', 1, '<!ELEMENT INFO (ADDR,PHONE?)>', '<!ELEMENT INFO (#PCDATA)>', '<!ELEMENT INFO (ADDR,PHONE*,MANAGER?)>', '<!ELEMENT INFO (ADDR*,PHONE+,MANAGER)>', 'D', 100, 10);

-- --------------------------------------------------------

--
-- Table structure for table `sm_html`
--

CREATE TABLE IF NOT EXISTS `sm_html` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sm_html`
--

INSERT INTO `sm_html` (`id`, `content`) VALUES
(1, '<h1 class="panel-title">Panel title</h1>'),
(2, '<h1 class="panel-title">Panel title</h1>'),
(3, '<h1 class="panel-title">Panel title</h1>'),
(5, '<p><span style="font-weight: bold;">Title</span></p><p>List</p><p></p><ul><li><span style="line-height: 1.42857143;">Item 1</span><br></li><li><span style="line-height: 1.42857143;">Item 2</span><br></li><li><span style="line-height: 1.42857143;">Item 3</span><br></li></ul><p></p><p><span style="font-style: italic;">End of list</span></p>');

-- --------------------------------------------------------

--
-- Table structure for table `sm_rate_course`
--

CREATE TABLE IF NOT EXISTS `sm_rate_course` (
  `user_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `rate_time` date NOT NULL,
  `rate_no` int(1) NOT NULL,
  PRIMARY KEY (`user_id`,`course_id`),
  KEY `sm_rate_course_ibfk_2` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Store information for the rating of courses by students and teachers';

-- --------------------------------------------------------

--
-- Table structure for table `sm_units`
--

CREATE TABLE IF NOT EXISTS `sm_units` (
  `unit_id` int(10) NOT NULL,
  `vid_id` int(11) NOT NULL,
  `unit_name` text,
  `vid_type` char(1) NOT NULL,
  `vid_title` varchar(255) NOT NULL,
  `vid_link` varchar(255) NOT NULL,
  `vid_length` int(15) NOT NULL,
  `unit_slides` varchar(500) NOT NULL,
  `course_id` int(10) NOT NULL,
  PRIMARY KEY (`unit_id`,`vid_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sm_units`
--

INSERT INTO `sm_units` (`unit_id`, `vid_id`, `unit_name`, `vid_type`, `vid_title`, `vid_link`, `vid_length`, `unit_slides`, `course_id`) VALUES
(1, 1, 'Introduction to the course', 'W', 'Introduction to Databases', 'http://www.youtube.com/watch?v=D-k-h0GuFmE', 834, '', 19),
(2, 1, 'Relational Model', 'W', 'The Relational Model', 'http://www.youtube.com/watch?v=spQ7IFksP9g', 529, '', 19),
(2, 2, 'Relational Model', 'W', 'Querying relational databases', 'https://www.youtube.com/watch?v=nf1-h2GpEGc', 380, '', 19),
(3, 1, 'XML Data', 'W', 'Well-formed XML', 'https://www.youtube.com/watch?v=x8kMELlNaYg', 797, '', 19),
(3, 2, 'XML Data', 'W', 'DTDs, IDS and IDREFs', 'https://www.youtube.com/watch?v=-Wft5dD-1ig', 1080, '', 19),
(3, 3, 'XML Data', 'W', 'XML Schema', 'https://www.youtube.com/watch?v=YkAZlQgPXG4', 788, '', 19),
(4, 1, 'JSON Data', 'W', 'Introduction to JSON', 'https://www.youtube.com/watch?v=JwSWIC6fJ5Q', 635, '', 19),
(4, 2, 'JSON Data', 'W', 'JSON Demo', 'https://www.youtube.com/watch?v=TjZLdJvm3to', 1336, '', 19),
(5, 1, 'Relational Algebra', 'W', 'Select, Project, Join', 'https://www.youtube.com/watch?v=tii7xcFilOA', 1084, '', 19),
(5, 2, 'Relational Algebra', 'W', 'Set operators, renaming, notation', 'https://www.youtube.com/watch?v=GkBf2dZAES0', 1183, '', 19),
(6, 1, 'SQL', 'W', 'Introduction to SQL', 'https://www.youtube.com/watch?v=wxFmiRwXcQY', 271, '', 19),
(6, 2, 'SQL', 'W', 'Basic SELECT Statement', 'https://www.youtube.com/watch?v=XtNwJg2aL7k', 596, '', 19),
(6, 3, 'SQL', 'W', 'Table variables and Set operators', 'https://www.youtube.com/watch?v=thcqxTlSAmw ', 632, '', 19),
(6, 4, 'SQL', 'W', 'Subqueries in WHERE clause', 'https://www.youtube.com/watch?v=IJPXosPGLTU', 1213, '', 19),
(6, 5, 'SQL', 'W', 'Subqueries in FROM and SELECT', 'https://www.youtube.com/watch?v=8OCAxk1Rybg', 481, '', 19),
(6, 6, 'SQL', 'W', 'The JOIN family of operators', 'https://www.youtube.com/watch?v=oXd4mTA86MI', 1499, '', 19),
(6, 7, 'SQL', 'W', 'Aggregations', 'https://www.youtube.com/watch?v=iR-QQjpBg68', 1517, '', 19),
(6, 8, 'SQL', 'W', 'NULL values', 'https://www.youtube.com/watch?v=-oH4h6asJYs', 324, '', 19),
(6, 9, 'SQL', 'W', 'Data modification statements', 'https://www.youtube.com/watch?v=Hb6K1uucuSg', 873, '', 19);

-- --------------------------------------------------------

--
-- Table structure for table `sm_users`
--

CREATE TABLE IF NOT EXISTS `sm_users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` char(1) NOT NULL DEFAULT '1' COMMENT 'Check in list:0 - admin/1 - student/2 - teacher/3 - staff/4 - dummy',
  `email` varchar(255) NOT NULL,
  `display_name` varchar(100) DEFAULT 'username',
  `birthday` date DEFAULT NULL,
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `first_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `bio` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/avatars/default_avatar.png',
  `time` int(11) NOT NULL,
  `confirmed` int(11) NOT NULL DEFAULT '0',
  `generated_string` varchar(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Store user''s credentials, used to login, create new user' AUTO_INCREMENT=21 ;

--
-- Dumping data for table `sm_users`
--

INSERT INTO `sm_users` (`user_id`, `username`, `password`, `role`, `email`, `display_name`, `birthday`, `join_date`, `first_name`, `last_name`, `gender`, `bio`, `email_code`, `avatar`, `time`, `confirmed`, `generated_string`, `ip`) VALUES
(13, 'tuanhm', '$2y$12$396456118153560ad36a9uV8h8l4lSJYTxtZVuEapCjYfkpw7dhgm', '1', 'tuanhm@example.com', 'Minh Tuan', '0000-00-00', '2014-04-25 15:03:01', '', '', '', '', 'code_53560ad36a9918.88085225', 'images/avatars/default_avatar.png', 1398147795, 1, '0', '127.0.0.1'),
(14, 'vinhpt', '$2y$12$294838118253560cd76a9uxaHmxYJc0mhIbn04DJ68tAcHP1ZJtfW', '1', 'vinhpt@example.com', NULL, '0000-00-00', '2014-04-25 15:03:01', '', '', '', '', 'code_53560cd76a9916.79158021', 'images/avatars/default_avatar.png', 1398148311, 1, '0', '127.0.0.1'),
(15, 'cuongdd', '$2y$12$88767320953561127a000eYbQL3uo4pkb1luUjqhMlHcv95Bg.YTu', '1', 'cuongdd@example.com', 'Dao Duc Cuong', '1993-05-09', '2014-04-25 15:03:01', 'Cuong', 'Dao Duc', 'Male', 'Another update', 'code_53561127a000f8.58403816', 'images/avatars/default_avatar.png', 1398149415, 1, '0', '127.0.0.1'),
(16, 'haidd', '$2y$12$25660897285356842d4a3OmrwzdmdME8a1O0JauwsmL2vazc4DiEi', '1', 'haidd@example.com', NULL, '0000-00-00', '2014-04-25 15:03:01', '', '', '', '', 'code_5356842d4a3401.53899016', 'images/avatars/default_avatar.png', 1398178861, 0, '0', '::1'),
(17, 'duccuongict56bkhn', '$2y$12$324873160535a75cb705cO3sp7o/ZaGT33n3OAQbue4p9yGaAzLti', '1', 'duccuong5199@gmail.com', NULL, '0000-00-00', '2014-04-25 15:03:01', 'Duc Cuong', 'Dao', 'Male', 'Another account', 'code_535a75cb6fcc48.61027433', 'images/avatars/default_avatar.png', 1398437323, 1, '0', '::1'),
(18, 'davidb', '$2y$12$723271988535db41f6f0fuqiEygJEmsIfCR8zOfMn..ntiIjf/vKG', '2', 'davidb@example.com', 'David Black-Schaffer', NULL, '2014-04-28 01:51:27', 'David', 'Black-Shaffer', 'Male', 'Assistant Professor in Department of Information Technology - Uppsala University', 'code_535db41f6f0d12.26496647', 'images/avatars/davbl791.jpg', 1398649887, 1, '0', '::1'),
(19, 'andersb', '$2y$12$1045017269535e6f4396dOwNjU357wXSOTpoeAeOmV4kMD4ZuJhxy', '2', 'andersb@example.com', 'Anders Berglund', NULL, '2014-04-28 15:09:55', '', '', '', '', 'code_535e6f4396db15.06762459', 'images/avatars/default_avatar.png', 1398697795, 1, '0', '::1'),
(20, 'jennifer', '$2y$12$22341414525364c3c0ea2eTT3ydjdYsHC5o6Lxg9zuLRCRhXwPYd2', '2', 'widom@cs.stanford.edu', 'Jennifer Widom', NULL, '2014-05-03 10:24:01', 'Jennifer', 'Widom', 'Female', 'Jenifer Widom is the Fletcher Jones Professor and Chair of the Computer Science Department at Stanford University. She received her Bachelors degree from the Indiana University School of Music in 1982 and her Computer Science Ph.D. from Cornell University in 1987. She was a Research Staff Member at the IBM Almaden Research Center before joining the Stanford faculty in 1993. Her research interests span many aspects of nontraditional data management. She is an ACM Fellow and a member of the National Academy of Engineering and the American Academy of Arts & Sciences; she received the ACM SIGMOD Edgar F. Codd Innovations Award in 2007 and was a Guggenheim Fellow in 2000; she has served on a variety of program committees, advisory boards, and editorial boards.', 'code_5364c3c0e71fe2.76402301', 'images/avatars/jennifer.jpg', 1399112640, 1, '0', '::1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sm_courses`
--
ALTER TABLE `sm_courses`
  ADD CONSTRAINT `sm_courses_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `sm_course_cat` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sm_course_announcements`
--
ALTER TABLE `sm_course_announcements`
  ADD CONSTRAINT `sm_course_announcements_fk1` FOREIGN KEY (`user_id`) REFERENCES `sm_users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sm_course_announcements_fk2` FOREIGN KEY (`course_id`) REFERENCES `sm_courses` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sm_create_course`
--
ALTER TABLE `sm_create_course`
  ADD CONSTRAINT `sm_create_course_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sm_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sm_create_course_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `sm_courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sm_do_exercise`
--
ALTER TABLE `sm_do_exercise`
  ADD CONSTRAINT `sm_do_exercise_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `sm_users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sm_enroll_course`
--
ALTER TABLE `sm_enroll_course`
  ADD CONSTRAINT `sm_enroll_course_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sm_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sm_enroll_course_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `sm_courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sm_exercises`
--
ALTER TABLE `sm_exercises`
  ADD CONSTRAINT `sm_exercise_course_id_fk` FOREIGN KEY (`course_id`) REFERENCES `sm_courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sm_units_unit_id_fk` FOREIGN KEY (`unit_id`) REFERENCES `sm_units` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sm_rate_course`
--
ALTER TABLE `sm_rate_course`
  ADD CONSTRAINT `sm_rate_course_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sm_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sm_rate_course_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `sm_courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sm_units`
--
ALTER TABLE `sm_units`
  ADD CONSTRAINT `sm_units_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `sm_courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
