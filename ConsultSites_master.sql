-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2013 at 04:58 PM
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
  `copy` varchar(1020) NOT NULL,
  `cta_url` varchar(255) NOT NULL,
  PRIMARY KEY (`clientproj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `client_project`
--


-- --------------------------------------------------------

--
-- Table structure for table `greeting`
--

CREATE TABLE `greeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `copy` varchar(2040) NOT NULL,
  `signatureImg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `greeting`
--


-- --------------------------------------------------------

--
-- Table structure for table `news_item`
--

CREATE TABLE `news_item` (
  `id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `on_front_page` tinyint(1) NOT NULL DEFAULT '0',
  `article_title` varchar(255) NOT NULL,
  `copy` varchar(510) NOT NULL,
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
  `video_url` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `isonfront` tinyint(1) NOT NULL DEFAULT '0',
  `sortorder` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--


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

INSERT INTO `user_login` VALUES(1, 'consultant', 'fakepassword');
