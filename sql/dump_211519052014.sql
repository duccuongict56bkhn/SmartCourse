-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 19, 2014 at 02:15 PM
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

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fnc_course_wload`(course_id INT) RETURNS decimal(10,0)
    READS SQL DATA
BEGIN

DECLARE v_wload INT(10);

SELECT SUM(`sm_exercises`.`score`) INTO v_wload
FROM `sm_exercises`
WHERE `sm_exercises`.`course_id` = course_id;

RETURN v_wload;

END$$

DELIMITER ;

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
(1, 19, 'CS2250', 'Fundamentals of Databases', 'dbstanford', '2', '"Introduction to Databases" had a very successful public offering in fall 2011, as one of Stanford''s inaugural three massive open online courses. Since then, the course materials have been improved and expanded, and we''re excited to be launching a second public offering of the course in winter 2013. The course includes video lectures and demos with in-video quizzes to check understanding, in-depth standalone quizzes, a wide variety of automatically-checked interactive programming exercises, midterm and final exams, a discussion forum, optional additional exercises with solutions, and pointers to readings and resources. Taught by Professor Jennifer Widom, the curriculum draws from Stanford''s popular Introduction to Databases course', '2014-02-01 12:30:00', 20, 'images/courses/database-thumbnail.png', '', 'Stanford University'),
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
(20, 19, 7, 'Create announcement from form', 'This announcement is created through form', 1400180297, '2014-05-13', '2014-05-19', 2),
(20, 19, 8, 'Tested announcement', 'Bugs everywhere', 1400385660, '2014-05-07', '2014-05-05', 3);

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
  `course_id` int(10) NOT NULL,
  `unit_id` int(10) NOT NULL,
  `exercise_id` int(10) NOT NULL,
  `answer_mul` char(2) DEFAULT NULL,
  `answer_text` text,
  `attempt_made` int(5) NOT NULL,
  `attempt_timestamp` int(15) NOT NULL,
  `status` int(5) NOT NULL COMMENT '1 - not submitted, 2 - pending, 3 - accepted, 4 - rejected',
  `score` int(10) DEFAULT NULL,
  `approved` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`exercise_id`,`course_id`,`unit_id`,`attempt_made`),
  KEY `sm_do_exercise_exercise_id_fk` (`exercise_id`),
  KEY `sm_do_exercise_course_id_fk` (`course_id`),
  KEY `sm_do_exercise_unit_id_fk` (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sm_do_exercise`
--

INSERT INTO `sm_do_exercise` (`user_id`, `course_id`, `unit_id`, `exercise_id`, `answer_mul`, `answer_text`, `attempt_made`, `attempt_timestamp`, `status`, `score`, `approved`) VALUES
(14, 19, 3, 1, 'B', '', 1, 1400400702, 4, NULL, NULL),
(14, 19, 3, 1, 'C', '', 2, 1400400706, 3, NULL, NULL),
(14, 19, 3, 1, 'B', '', 3, 1400403023, 4, NULL, NULL),
(14, 19, 3, 1, 'C', '', 4, 1400403027, 3, 10, 'Y'),
(14, 19, 3, 2, '', 'This is my demo answer for this question', 1, 1400403059, 2, NULL, NULL),
(14, 19, 3, 2, '', 'Another demo answer for this exercises', 2, 1400403113, 2, NULL, NULL),
(14, 19, 3, 2, '', 'Another demo answer for this exercises\r\nAnother demo answer for this exercises\r\nAnother demo answer for this exercises\r\nAnother demo answer for this exercises\r\nAnother demo answer for this exercises\r\nAnother demo answer for this exercises\r\nAnother demo answer for this exercises\r\nAnother demo answer for this exercisesAnother demo answer for this exercisesAnother demo answer for this exercisesAnother demo answer for this exercisesAnother demo answer for this exercises', 3, 1400403113, 2, NULL, NULL),
(14, 19, 5, 2, 'B', '', 3, 1400401073, 3, 20, NULL),
(14, 19, 5, 3, 'D', '', 1, 1400401110, 4, NULL, NULL),
(14, 19, 5, 3, 'C', '', 2, 1400401113, 3, 20, NULL),
(14, 19, 5, 3, 'C', '', 3, 1400401327, 3, 20, 'Y'),
(15, 19, 5, 1, '', 'My answers are as following:\nQuestion 1: SELECT * FROM ....', 1, 1400403307, 2, NULL, NULL),
(15, 19, 5, 1, '', 'Changed answers are:\nQuestion 1: SELECT * FROM ....\nQuestion 2: SELECT FUCK FROM', 2, 1400403343, 2, NULL, NULL),
(15, 19, 5, 2, 'A', '', 1, 1400393147, 4, NULL, NULL),
(15, 19, 5, 2, 'C', '', 2, 1400409528, 4, NULL, NULL),
(15, 19, 5, 2, 'B', '', 3, 1400409532, 3, 20, 'Y'),
(15, 19, 5, 3, 'C', '', 1, 1400409610, 3, 20, 'Y'),
(20, 19, 3, 1, 'C', '', 1, 1400466604, 3, 10, 'Y'),
(20, 19, 3, 2, '', 'rtshdtyjyuykwr  dfgfghfghgfhfg', 1, 1400466626, 2, NULL, NULL),
(20, 19, 5, 2, 'A', NULL, 1, 1400388317, 4, NULL, NULL),
(20, 19, 5, 2, 'B', '', 2, 1400388317, 4, NULL, NULL),
(20, 19, 5, 3, 'C', '', 1, 1400390508, 3, 20, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `sm_enroll_course`
--

CREATE TABLE IF NOT EXISTS `sm_enroll_course` (
  `user_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `enroll_date` int(15) NOT NULL,
  `unenroll_date` int(15) DEFAULT NULL,
  `result` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`course_id`),
  KEY `user_id` (`user_id`),
  KEY `sm_enroll_course_ibfk_2` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sm_enroll_course`
--

INSERT INTO `sm_enroll_course` (`user_id`, `course_id`, `enroll_date`, `unenroll_date`, `result`) VALUES
(13, 19, 1400427652, NULL, NULL),
(14, 19, 1400399650, NULL, NULL),
(15, 19, 1400392653, NULL, NULL),
(15, 29, 1400409264, NULL, NULL);

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
(3, 19, 1, 'Question 1', '<h3>Question 1</h3><p>We''re interested in well-formed XML that satisfies the following conditions:</p><p></p><ul><li>It has root element "tasklist"</li><li>The root element has three "task" elements</li><li>Each of the "task" subelements has an attribute named "name"<br></li><li>The values of the "name" attributes for the 3 tasks are "eat", "drink", and "play"</li></ul>Select, from the choices below, the well-formed XML that meets the above requirements.<div><span style="font-style: italic;">Code A</span><br><p></p><p></p><pre style="padding: 10px; margin-bottom: 10.5px; line-height: 21px; border-color: rgba(0, 0, 0, 0.14902);">&lt;tasklist&gt;\n  &lt;task name="eat"&gt;\n  &lt;task name="drink"&gt;\n  &lt;task name="play"&gt;\n&lt;/tasklist&gt;</pre><p><span style="font-style: italic;">Code B</span></p><pre style="padding: 10px; margin-bottom: 10.5px; line-height: 21px; border-color: rgba(0, 0, 0, 0.14902);">&lt;tasklist&gt;\n  &lt;task name=eat/&gt;\n  &lt;task name=drink/&gt;\n  &lt;task name=play/&gt;\n&lt;/tasklist&gt;</pre><p><span style="font-style: italic;">Code C</span></p><pre style="padding: 10px; margin-bottom: 10.5px; line-height: 21px; border-color: rgba(0, 0, 0, 0.14902);">&lt;tasklist&gt;\n  &lt;task name="eat"&gt;&lt;/task&gt;\n  &lt;task name="drink"&gt;&lt;/task&gt;\n  &lt;task name="play"&gt;&lt;/task&gt;\n&lt;/tasklist&gt;</pre><p><span style="font-style: italic;">Code D</span></p><pre style="padding: 10px; margin-bottom: 10.5px; line-height: 21px; border-color: rgba(0, 0, 0, 0.14902);">&lt;tasklist&gt;\n  &lt;task name="eat"/&gt;\n&lt;/tasklist&gt;\n&lt;tasklist&gt;\n  &lt;task name="drink"/&gt;\n&lt;/tasklist&gt;\n&lt;tasklist&gt;\n  &lt;task name="play"/&gt;\n&lt;/tasklist&gt;</pre></div>', 1, 'Code A', 'Code B', 'Code C', 'Code D', 'C', 100, 10),
(3, 19, 2, 'DTD Exercises', '<div class="course-quiz-preamble" style="padding: 20px; margin-top: 10px; color: rgb(51, 51, 51); line-height: 21px;"><b>Instructions:</b>&nbsp;For each question, you are to write a DTD that validates against the corresponding XML data set. Each question has a "Validate" button that let''s you test your DTD; behind the scenes it runs the&nbsp;<a href="http://xmlsoft.org/xmldtd.html" style="color: rgb(3, 103, 176);">xmllint</a>&nbsp;tool over the sample data set using your DTD.&nbsp;<br><br>You may perform these exercises as many times as you like, so we strongly encourage you to keep working with them until you complete the exercises with full credit.&nbsp;<br><br><b>NOTE: REMEMBER TO CLICK "Submit" WHEN YOU ARE DONE</b></div><h4 style="padding: 20px; margin-top: 10px; color: rgb(51, 51, 51); line-height: 21px;"><span style="font-weight: bold;">Question 1</span></h4><div class="course-quiz-preamble" style="padding: 20px; margin-top: 10px;"><div style="float: none; width: 981px;"><div dir="auto" class="course-quiz-question-text" style="color: rgb(51, 51, 51); line-height: 28px; padding-bottom: 10px;">In this question, you are to create a DTD for a small XML data set drawn from the Stanford course catalog. There are multiple departments, each with a department chair, some courses, and professors and/or lecturers who teach courses. The XML data is&nbsp;<a href="http://s3.amazonaws.com/spark-public/db/docs/courses-noID.xml" target="_blank" style="color: rgb(3, 103, 176);">here</a>.&nbsp;<br>Write a DTD for the XML data set.<br><b>Important:</b>&nbsp;Do not include&nbsp;<b>&lt;!DOCTYPE Course_Catalog [...]&gt;</b>&nbsp;in your DTD. Your DTD should start with&nbsp;<b>&lt;!ELEMENT Course_Catalog (Department*)&gt;</b>.</div><div dir="auto" class="course-quiz-question-text" style="padding-bottom: 10px;"><h4 style="padding-bottom: 10px;"><span style="color: rgb(51, 51, 51); line-height: 28px; font-weight: bold;">Question 2</span></h4><div dir="auto" class="course-quiz-question-text" style="padding-bottom: 10px;"><span style="color: rgb(51, 51, 51); line-height: 28px;">In this question, you are to create a DTD for a different version of the data set drawn from the Stanford course catalog. This version encodes the data using ID and IDREF(S) attributes. The XML data is here.</span></div><div dir="auto" class="course-quiz-question-text" style="padding-bottom: 10px;"><span style="color: rgb(51, 51, 51); line-height: 28px;">Write a DTD for the XML data set.<span style="font-weight: bold;">&nbsp;</span></span><span style="color: rgb(51, 51, 51); line-height: 28px;"><span style="font-weight: bold;">Hint:</span> You may want to use your DTD from the previous question as a starting point, since the structure is similar.&nbsp;</span><span style="color: rgb(51, 51, 51); line-height: 28px;">Important: Do not include &lt;!DOCTYPE Course_Catalog [...]&gt; in your DTD. Your DTD should start with &lt;!ELEMENT Course_Catalog (Department*)&gt;.</span></div></div></div></div><div class="course-quiz-honor-code" style="margin-top: 10px; padding: 15px; color: rgb(51, 51, 51); line-height: 21px;"><label class="checkbox" style="margin-bottom: 5px; min-height: 21px; width: auto;"></label></div>', 2, '', '', '', '', '', 10000, 100),
(5, 19, 1, 'Relational Algebra Exercise', '<p>In this assignment you are to write relational algebra queries over a small database, executed using our RA Workbench. Behind the scenes, the RA workbench translates relational algebra expressions into SQL queries over the database stored in SQLite. Since relational algebra symbols aren''t readily available on most keyboards, RA uses a special syntax described in our RA Relational Algebra Syntax guide.&nbsp;<br></p><p>We''ve created a small sample database to use for this assignment. It contains four relations:<br></p><p><a href="https://class.coursera.org/db/wiki/view?page=PizzaData" target="_blank" style="box-sizing: border-box; color: rgb(3, 103, 176); text-decoration: none; font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 21px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px;"></a></p><pre style="box-sizing: border-box; padding: 10px; border-top-left-radius: 4px; border-top-right-radius: 4px; border-bottom-right-radius: 4px; border-bottom-left-radius: 4px; display: block; margin: 0px 0px 10.5px; word-break: break-all; word-wrap: break-word; background-color: rgb(245, 245, 245); border: 1px solid rgba(0, 0, 0, 0.14902); orphans: auto; text-align: start; text-indent: 0px; widows: auto;"><span style="color: rgb(51, 51, 51); font-family: Monaco, Menlo, Consolas, ''Courier New'', monospace; font-size: 13px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 21px; text-transform: none; white-space: pre-wrap; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Person(name, age, gender)       // name is a key\n    Frequents(name, pizzeria)       // [name,pizzeria] is a key\n    Eats(name, pizza)               // [name,pizza] is a key\n    Serves(pizzeria, pizza, price)  // [pizzeria,pizza] is a key</span><span style="color: rgb(42, 55, 68); font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; white-space: normal;">\n</span></pre><p><span style="font-weight: bold;"></span></p><p><span style="font-weight: bold;"></span></p><span style="color: rgb(51, 51, 51); line-height: 21px;">Person</span><table style="background-color: rgb(255, 255, 255); border: 2px solid rgb(0, 0, 0); width: auto; color: rgb(51, 51, 51); line-height: 21px;"><tbody><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><th style="border: 1px solid rgb(0, 0, 0); padding: 3px;">name</th><th style="border: 1px solid rgb(0, 0, 0); padding: 3px;">age</th><th style="border: 1px solid rgb(0, 0, 0); padding: 3px;">gender</th></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Amy</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">16</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">female</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Ben</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">21</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">male</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Cal</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">33</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">male</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dan</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">13</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">male</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Eli</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">45</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">male</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Fay</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">21</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">female</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Gus</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">24</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">male</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Hil</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">30</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">female</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Ian</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">18</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">male<br></td></tr></tbody></table><br><span style="color: rgb(51, 51, 51); line-height: 21px;">Frequents</span><table style="background-color: rgb(255, 255, 255); border: 2px solid rgb(0, 0, 0); width: auto; color: rgb(51, 51, 51); line-height: 21px;"><tbody><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><th style="border: 1px solid rgb(0, 0, 0); padding: 3px;">name</th><th style="border: 1px solid rgb(0, 0, 0); padding: 3px;">pizzeria</th></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Amy</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Pizza Hut</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Ben</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Chicago Pizza</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Ben</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Pizza Hut</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Cal</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">New York Pizza</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Cal</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Straw Hat</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dan</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">New York Pizza</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dan</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Straw Hat</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Eli</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Chicago Pizza</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Eli</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Straw Hat</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Fay</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dominos</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Fay</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Little Caesars</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Gus</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Chicago Pizza</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Gus</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Pizza Hut</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Hil</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dominos</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Hil</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Pizza Hut</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Hil</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Straw Hat</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Ian</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dominos</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Ian</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">New York Pizza</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Ian</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Straw Hat</td></tr></tbody></table><p></p><p><span style="color: rgb(51, 51, 51); line-height: 21px;">Eats</span></p><table style="background-color: rgb(255, 255, 255); border: 2px solid rgb(0, 0, 0); width: auto; color: rgb(51, 51, 51); line-height: 21px;"><tbody><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><th style="border: 1px solid rgb(0, 0, 0); padding: 3px;">name</th><th style="border: 1px solid rgb(0, 0, 0); padding: 3px;">pizza</th></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Amy</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">mushroom</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Amy</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">pepperoni</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Ben</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">cheese</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Ben</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">pepperoni</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Cal</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">supreme</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dan</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">cheese</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dan</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">mushroom</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dan</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">pepperoni</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dan</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">sausage</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dan</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">supreme</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Eli</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">cheese</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Eli</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">supreme</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Fay</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">mushroom</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Gus</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">cheese</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Gus</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">mushroom</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Gus</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">supreme</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Hil</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">cheese</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Hil</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">supreme</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Ian</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">pepperoni</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Ian</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">supreme<br></td></tr></tbody></table><p><span style="font-weight: bold;"><br></span></p><p><span style="color: rgb(51, 51, 51); line-height: 21px;">Serves</span></p><table style="background-color: rgb(255, 255, 255); border: 2px solid rgb(0, 0, 0); width: auto; color: rgb(51, 51, 51); line-height: 21px;"><tbody><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><th style="border: 1px solid rgb(0, 0, 0); padding: 3px;">pizzeria</th><th style="border: 1px solid rgb(0, 0, 0); padding: 3px;">pizza</th><th style="border: 1px solid rgb(0, 0, 0); padding: 3px;">price</th></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Chicago Pizza</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">cheese</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">7.75</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Chicago Pizza</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">supreme</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">8.5</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dominos</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">cheese</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">9.75</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Dominos</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">mushroom</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">11</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Little Caesars</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">cheese</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">7</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Little Caesars</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">mushroom</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">9.25</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Little Caesars</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">pepperoni</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">9.75</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Little Caesars</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">sausage</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">9.5</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">New York Pizza</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">cheese</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">7</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">New York Pizza</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">pepperoni</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">8</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">New York Pizza</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">supreme</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">8.5</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Pizza Hut</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">cheese</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">9</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Pizza Hut</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">pepperoni</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">12</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Pizza Hut</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">sausage</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">12</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Pizza Hut</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">supreme</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">12</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Straw Hat</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">cheese</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">9.25</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Straw Hat</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">pepperoni</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">8</td></tr><tr style="border: 1px solid rgb(0, 0, 0); padding: 3px;"><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">Straw Hat</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">sausage</td><td style="border: 1px solid rgb(0, 0, 0); padding: 3px;">9.75<br></td></tr></tbody></table><p><span style="font-weight: bold;"><br></span></p><p><span style="font-weight: bold;">Instructions:</span> You are to write relational algebra expressions for the following queries over the pizza database. We strongly suggest that you work the queries out on paper first, using conventional relational algebra symbols.&nbsp;</p><p><span style="font-weight: bold;">Please Note:</span> You are to translate the English into an expression that computes the desired result over all possible databases. All we actually check is that your query gets the right answer on the small sample database. Thus, even if your solution is marked as correct, it is possible that your query does not correctly reflect the problem at hand. (For example, if we ask for a complex condition that requires accessing all of the tables, but over our small data set in the end the condition is satisfied only by Amy, then the query "\\project_{name} (\\select_{name=''Amy''} Person)" will be marked correct even though it doesn''t reflect the actual question.) Circumventing the system in this fashion will get you a high score on the exercises, but it won''t help you learn relational algebra. On the other hand, an incorrect attempt at a general solution is unlikely to produce the right answer, so you shouldn''t be led astray by our checking system.&nbsp;</p><p><span style="line-height: 1.42857143;">You may perform these exercises as many times as you like, so we strongly encourage you to keep working with them until you complete the exercises with full credit.&nbsp;</span><br></p><p><span style="line-height: 1.42857143; font-weight: bold;">NOTE: WRITE THE NUMBER OF EACH QUESTION IN YOUR ANSWER AND REMEMBER TO CLICK "Submit" WHEN YOU ARE DONE!&nbsp;</span><br></p><p>Please be patient as it does take time to check all of the exercises. Here are questions for the exercises&nbsp;</p><h4><span style="color: rgb(206, 0, 0);">Question 1:&nbsp;</span></h4><p>Find all pizzas eaten by at least one female over the age of 20.<br></p><h4 style="color: rgb(42, 55, 68);"><span style="color: rgb(206, 0, 0);">Question 2:&nbsp;</span></h4><p>Find the names of all females who eat at least one pizza served by Straw Hat. (Note: The pizza need not be eaten at Straw Hat.)&nbsp;</p><h4><span style="color: rgb(206, 0, 0);">Question 3:</span></h4><p>Find all pizzerias that serve at least one pizza for less than $10 that either Amy or Fay (or both) eat.<br></p><h4><span style="color: rgb(206, 0, 0);">Question 4:</span></h4><p>Find all pizzerias that serve at least one pizza for less than $10 that both Amy and Fay eat.<br></p><h4><span style="color: rgb(206, 0, 0);">Question 5:</span></h4><p>Find the names of all people who eat at least one pizza served by Dominos but who do not frequent Dominos.&nbsp;<br></p><h4><span style="color: rgb(206, 0, 0);">Question 6:</span></h4><p>Find all pizzas that are eaten only by people younger than 24, or that cost less than $10 everywhere they''re served.&nbsp;<br></p><h4><span style="color: rgb(206, 0, 0);">Question 7:</span></h4><p>Find the age of the oldest person (or people) who eat mushroom pizza.&nbsp;<br></p><h4><span style="color: rgb(206, 0, 0);">Question 8:</span></h4><p>Find all pizzerias that serve only pizzas eaten by people over 30.&nbsp;<br></p><h4><span style="color: rgb(206, 0, 0);">Question 9:</span></h4><p><span style="color: rgb(51, 51, 51); line-height: 28px; background-color: rgb(250, 250, 250);">Find all pizzerias that serve every pizza eaten by people over 30.&nbsp;</span><br style="color: rgb(51, 51, 51); line-height: 28px; background-color: rgb(250, 250, 250);"></p><p><br></p>', 2, '', '', '', '', '', 10000, 200),
(5, 19, 2, 'Relational Algebra Quiz 1', '<p>Suppose relation R(A,C) has the following tuples:<br></p><table border="2" style="background-color: rgb(250, 250, 250); color: rgb(51, 51, 51); line-height: 28px;"><tbody><tr><th>A</th><th>C</th></tr><tr><td>3</td><td>3</td></tr><tr><td>6</td><td>4</td></tr><tr><td>2</td><td>3</td></tr><tr><td>3</td><td>5</td></tr><tr><td>7</td><td>1</td></tr></tbody></table><p style="margin-bottom: 10.5px; font-size: 15px; color: rgb(51, 51, 51); line-height: 28px; background-color: rgb(250, 250, 250);">and relation S(B,C,D) has the following tuples:</p><table border="2" style="background-color: rgb(250, 250, 250); color: rgb(51, 51, 51); line-height: 28px;"><tbody><tr><th>B</th><th>C</th><th>D</th></tr><tr><td>5</td><td>1</td><td>6</td></tr><tr><td>1</td><td>5</td><td>8</td></tr><tr><td>4</td><td>3</td><td>9<br></td></tr></tbody></table><br><div>Compute the<span style="font-weight: bold;"> natural join of R and S</span>. Which of the following tuples is in the result? Assume each tuple has schema (A,B,C,D).<br></div>', 1, '(2, 3, 1, 6)', '(2, 4, 3, 9)', '(5, 1, 6, 4)', '(3, 5, 1, 6)', 'B', 100, 20),
(5, 19, 3, 'Relational Algebra Quiz 2', '<p><span style="color: rgb(51, 51, 51); line-height: 28px;">Suppose relation R(A,B) has the following tuples:</span></p><p style="margin-bottom: 10.5px; font-size: 15px; color: rgb(51, 51, 51); line-height: 28px;"></p><table border="2" style="color: rgb(51, 51, 51); line-height: 28px;"><tbody><tr><th>A</th><th>B</th></tr><tr><td>1</td><td>2</td></tr><tr><td>3</td><td>4</td></tr><tr><td>5</td><td>6</td></tr></tbody></table><p style="margin-bottom: 10.5px; font-size: 15px; color: rgb(51, 51, 51); line-height: 28px;">and relation S(B,C,D) has the following tuples:</p><p style="margin-bottom: 10.5px; font-size: 15px; color: rgb(51, 51, 51); line-height: 28px;"></p><table border="2" style="color: rgb(51, 51, 51); line-height: 28px;"><tbody><tr><th>B</th><th>C</th><th>D</th></tr><tr><td>2</td><td>4</td><td>6</td></tr><tr><td>4</td><td>6</td><td>8</td></tr><tr><td>4</td><td>7</td><td>9</td></tr></tbody></table><p style="margin-bottom: 10.5px; font-size: 15px; color: rgb(51, 51, 51); line-height: 28px;">Compute the theta-join of R and S with the condition R.A &lt; S.C AND R.B &lt; S.D. Which of the following tuples is in the result? Assume each tuple has schema (A, R.B, S.B, C, D).</p>', 1, '(1,2,2,6,8)', '(1,2,4,4,6)', '(3,4,5,7,9)', '(5,6,4,6,8)', 'C', 100, 20);

-- --------------------------------------------------------

--
-- Table structure for table `sm_messages`
--

CREATE TABLE IF NOT EXISTS `sm_messages` (
  `message_id` int(10) NOT NULL,
  `subject` varchar(500) DEFAULT NULL,
  `message` varchar(5000) NOT NULL,
  `message_type` int(5) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sm_messages`
--

INSERT INTO `sm_messages` (`message_id`, `subject`, `message`, `message_type`) VALUES
(1, 'Test message', 'From Jennifer to Tuan Hoang', 0),
(2, 'Another message', 'From Jennier to Vinh Pham Truong with love', 0),
(4, 'To CuongDD', 'Message 1', 0);

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
-- Table structure for table `sm_send_message`
--

CREATE TABLE IF NOT EXISTS `sm_send_message` (
  `sender_id` int(10) NOT NULL,
  `receiver_id` int(10) NOT NULL,
  `message_id` int(10) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `timestamp` int(15) NOT NULL,
  PRIMARY KEY (`sender_id`,`receiver_id`,`message_id`),
  KEY `sm_send_message_receiver_fk` (`receiver_id`),
  KEY `sm_send_message_message_fk` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sm_send_message`
--

INSERT INTO `sm_send_message` (`sender_id`, `receiver_id`, `message_id`, `status`, `timestamp`) VALUES
(20, 13, 1, 'pending', 1400436179),
(20, 14, 2, 'pending', 1400439105),
(20, 15, 4, 'pending', 1400439276);

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
  PRIMARY KEY (`unit_id`,`vid_id`,`course_id`),
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
(13, 'tuanhm', '$2y$12$396456118153560ad36a9uV8h8l4lSJYTxtZVuEapCjYfkpw7dhgm', '1', 'tuanhm@example.com', 'Minh Tuan', '0000-00-00', '2014-04-25 15:03:01', 'Tuan', 'Hoang Minh', 'Male', '', 'code_53560ad36a9918.88085225', 'images/avatars/default_avatar.png', 1398827795, 1, '0', '127.0.0.1'),
(14, 'vinhpt', '$2y$12$294838118253560cd76a9uxaHmxYJc0mhIbn04DJ68tAcHP1ZJtfW', '1', 'vinhpt@example.com', 'Pham Truong Vinh', '0000-00-00', '2014-04-25 15:03:01', 'Vinh', 'Pham Truong', '', '', 'code_53560cd76a9916.79158021', 'images/avatars/default_avatar.png', 1398148311, 1, '0', '127.0.0.1'),
(15, 'cuongdd', '$2y$12$88767320953561127a000eYbQL3uo4pkb1luUjqhMlHcv95Bg.YTu', '1', 'cuongdd@example.com', 'Dao Duc Cuong', '1993-05-09', '2014-04-25 15:03:01', 'Cuong', 'Dao Duc', 'Male', 'Another update', 'code_53561127a000f8.58403816', 'images/avatars/default_avatar.png', 1398939415, 1, '0', '127.0.0.1'),
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
  ADD CONSTRAINT `sm_do_exercise_course_id_fk` FOREIGN KEY (`course_id`) REFERENCES `sm_courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sm_do_exercise_unit_id_fk` FOREIGN KEY (`unit_id`) REFERENCES `sm_units` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sm_do_exercise_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `sm_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `sm_exercise_unit_id_fk` FOREIGN KEY (`unit_id`) REFERENCES `sm_units` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sm_rate_course`
--
ALTER TABLE `sm_rate_course`
  ADD CONSTRAINT `sm_rate_course_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sm_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sm_rate_course_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `sm_courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sm_send_message`
--
ALTER TABLE `sm_send_message`
  ADD CONSTRAINT `sm_send_message_message_fk` FOREIGN KEY (`message_id`) REFERENCES `sm_messages` (`message_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sm_send_message_receiver_fk` FOREIGN KEY (`receiver_id`) REFERENCES `sm_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sm_send_message_sender_fk` FOREIGN KEY (`sender_id`) REFERENCES `sm_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sm_units`
--
ALTER TABLE `sm_units`
  ADD CONSTRAINT `sm_units_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `sm_courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
