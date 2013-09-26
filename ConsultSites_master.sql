-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 26, 2013 at 04:58 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ConsultSites_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `article_url` varchar(255) NOT NULL,
  `person_id` int(11) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `article`
--


-- --------------------------------------------------------

--
-- Table structure for table `client_project`
--

CREATE TABLE `client_project` (
  `clientproj_id` int(11) NOT NULL AUTO_INCREMENT,
  `client` varchar(255) NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  `tagline` varchar(255) NOT NULL,
  `copy` text NOT NULL,
  `cta_url` varchar(255) NOT NULL,
  PRIMARY KEY (`clientproj_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `client_project`
--

INSERT INTO `client_project` VALUES(1, 'Tempur-Pedic', 'imgupload/Tempur-Pedic_logo.png', 'You are how you sleep.', 'Tempur-Pedic knows that when you get a great night’s sleep, the world notices. \r\nAnd when you don’t? Well, the world notices that, too.', 'http://carmichaellynch.com/category/tempur-pedic/');
INSERT INTO `client_project` VALUES(2, 'Subaru', 'imgupload/Subaru_logo.png', 'Love. It’s what makes a Subaru ', 'A portrait of the artist as a young Subaru owner. In this commercial, a surprise gift awakens a man’s passion to capture the beauty he sees from the driver’s seat of his Symmetrical All-Wheel Drive Outback.', 'http://carmichaellynch.com/category/subaru/');
INSERT INTO `client_project` VALUES(3, 'American Standard', 'imgupload/American Standard_logo.png', 'Celebrate the Indoors.', 'What people do in the privacy of their own home is a scream in this new spot . Put on your monster mask, and join us for a new campaign created to celebrate the indoors. It’s where some of life’s best moments happen.', 'http://carmichaellynch.com/category/american-standard/');
INSERT INTO `client_project` VALUES(4, 'Mattel', 'imgupload/Mattel Logo No Box-709512_logo.png', 'Play with Barbie.', 'Donec sollicitudin molestie malesuada. Cras ultricies ligula sed magna dictum porta. Proin eget tortor risus.', '#');
INSERT INTO `client_project` VALUES(5, 'Jack Link’s', 'imgupload/jack-links_logo.png', 'Messin’ with Sasquatch', 'Let sleeping Sasquatch lie. That’s the obvious moral behind this new Jack Link’s spot in which three hapless coworkers decide to employ one of the greatest party pranks of all time on He-Who-Should-Not-Be-Messed-With. Watch and learn, human.', 'http://carmichaellynch.com/category/jack-links/');

-- --------------------------------------------------------

--
-- Table structure for table `greeting`
--

CREATE TABLE `greeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `copy` text NOT NULL,
  `signatureImg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `greeting`
--

INSERT INTO `greeting` VALUES(1, 'Hi Danielle,<br/><br/>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'imgupload/signature.png');

-- --------------------------------------------------------

--
-- Table structure for table `news_item`
--

CREATE TABLE `news_item` (
  `id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `article_title` varchar(255) NOT NULL,
  `copy` text NOT NULL,
  `article_url` varchar(255) NOT NULL,
  `thumbnail_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news_item`
--


-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--


-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `clientproj_id` int(11) NOT NULL,
  `thumbnail_url` varchar(255) NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `sortorder` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` VALUES(3, 'imgupload/American-Standard-Movie-Marathons_thumb.jpg', '73243530', 'NULL', 1, 0);
INSERT INTO `project` VALUES(4, 'imgupload/Barbie_thumb.jpg', 'NULL', 'imgupload/Barbie Ad.jpg', 1, 0);
INSERT INTO `project` VALUES(2, 'imgupload/Subaru-Nature-Painting_thumb.jpg', '66733042', NULL, 1, 0);
INSERT INTO `project` VALUES(5, 'imgupload/Jack-Links-All-Dolled-Up_thumb.jpg', '66171596', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` VALUES(1, '', '');
