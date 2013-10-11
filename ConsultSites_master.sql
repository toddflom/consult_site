-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 11, 2013 at 11:15 AM
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
  `title` text NOT NULL,
  `article_url` varchar(255) NOT NULL,
  `person_id` int(11) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `article`
--

INSERT INTO `article` VALUES(1, '<p>AdAge</p>', 'Learnings from boom in online classes', 'http://adage.com/article/digitalnext/marketers-learn-boom-online-college-classes/239077/', 1, 0);
INSERT INTO `article` VALUES(2, '<p>World of Business Ideas<br></p>', 'It isnâ€™t dead, youâ€™re just being lazy', 'http://www.wobi.com/blog/global-trends/it-isnâ€™t-dead-youâ€™re-just-being-lazy', 1, 1);
INSERT INTO `article` VALUES(3, '<p>Huffington Post</p>', 'Hereâ€™s to Longer Goodbyes', 'http://www.huffingtonpost.com/mike-lescarbeau/gratitude-after-leukemia_b_3575702.html', 2, 1);
INSERT INTO `article` VALUES(4, 'AdAge', 'Supporting The New Four-Year Career', 'http://adage.com/article/digitalnext/supporting-year-career/238434/', 1, 0);
INSERT INTO `article` VALUES(5, 'AdWeek', '6 Questions with Dave Damman', 'http://www.adweek.com/video/advertising-branding/six-questions-dave-damman-141427', 3, 0);
INSERT INTO `article` VALUES(6, '<p>CNBC</p>', 'Stacy Janicki on Facebook filters', 'http://www.themplsegotist.com/news/local/2013/june/3/meddlin-monday-carmichaels-stacy-janicki-speaks-out-about-facebook', 4, 0);
INSERT INTO `article` VALUES(7, 'Fast Company', 'Steve Knapp gives insight on innovation', 'http://www.fastcompany.com', 5, 0);
INSERT INTO `article` VALUES(8, 'New York Times', 'Stacy Janicki comments on Facebook''s hate speech policy.', 'http://www.nytimes.com/2013/05/29/business/media/facebook-says-it-failed-to-stop-misogynous-pages.html?_r=0', 4, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `client_project`
--

INSERT INTO `client_project` VALUES(1, '<p>Tempur-Pedic<br></p>', 'source/logos/tempur-pedic_logo.gif', '<p>You are how you sleep.<br></p>', '<p>Tempur-Pedic knows that when you get a great nightâ€™s sleep, the world notices. And when you donâ€™t? Well, the world notices that, too.</p>', '<a href=\\"http://carmichaellynch.com/category/tempur-pedic/\\" target=\\"_blank\\" >Learn More</a>');
INSERT INTO `client_project` VALUES(2, 'Subaru', 'source/logos/Subaru_logo.png', 'Love. It''s what makes a Subaru ', 'A portrait of the artist as a young Subaru owner. In this commercial, a surprise gift awakens a man''s passion to capture the beauty he sees from the driver''s seat of his Symmetrical All-Wheel Drive Outback.', '<a target="_blank" href="http://carmichaellynch.com/category/subaru/">Learn More</a>');
INSERT INTO `client_project` VALUES(3, 'American Standard', 'source/logos/American Standard_logo.png', 'Celebrate the Indoors.', 'What people do in the privacy of their own home is a scream in this new spot . Put on your monster mask, and join us for a new campaign created to celebrate the indoors. It’s where some of life’s best moments happen.', '<a target="_blank" href="http://carmichaellynch.com/category/american-standard/">Learn More</a>');
INSERT INTO `client_project` VALUES(4, 'Mattel', 'source/logos/Mattel Logo No Box-709512_logo.png', 'Play with Barbie.', 'Donec sollicitudin molestie malesuada. Cras ultricies ligula sed magna dictum porta. Proin eget tortor risus.', '<a target="_blank" href="#">Learn More</a>');
INSERT INTO `client_project` VALUES(5, '<p>Jack Linkâ€™s</p>', 'source/logos/jack-links_logo.png', '<p>Messinâ€™ with Sasquatch</p>', '<p>Let sleeping Sasquatch lie. Thatâ€™s the obvious moral behind this new Jack Linkâ€™s spot in which three hapless coworkers decide to employ one of the greatest party pranks of all time on He-Who-Should-Not-Be-Messed-With. Watch and learn, human.</p>', '<a href=\\"http://carmichaellynch.com/category/jack-links/\\" target=\\"_blank\\" >Learn More</a>');

-- --------------------------------------------------------

--
-- Table structure for table `greeting`
--

CREATE TABLE `greeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `copy` text NOT NULL,
  `signatureImg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `greeting`
--

INSERT INTO `greeting` VALUES(1, '<p>Hi Danielle,<br><br>Lorem ipsum dolor sit ameâ€™t, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim venxercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br></p>', 'assets/images/signature.png');

-- --------------------------------------------------------

--
-- Table structure for table `news_item`
--

CREATE TABLE `news_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(255) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `article_title` varchar(255) NOT NULL,
  `copy` text NOT NULL,
  `article_url` varchar(255) NOT NULL,
  `pdf_url` varchar(255) NOT NULL,
  `thumbnail_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `news_item`
--

INSERT INTO `news_item` VALUES(1, '<p>Wall Street Journal</p>', 1, '<p>Subaru on track for 6 straight years of record-breaking sales.<br></p>', '<p>Surging U.S. demand for some Subaru vehicles could lead to dealer shortages if trends continue, the chief executive of the Japanese auto maker said on Thursday.</p>', '<a href=\\"<a href=\\\\\\"<a href=\\\\\\\\\\\\\\"<a href=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"<a href=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"<a href=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"<a href=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\', '<a href=\\"<a href=\\\\\\"<a href=\\\\\\\\\\\\\\"<a href=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"<a href=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"<a href=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"<a href=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\', 'source/news images/Wall-Street-Journal-article_thumb.jpg');
INSERT INTO `news_item` VALUES(2, '<p>New York Times</p>', 1, '<p>Awesome Jack Linkâ€™s media integration with Seth Meyerâ€™s The Awesomes<br></p>', '<p>MOST of the news about Hulu recently has focused on whether the popular video streaming site would be sold. Last week, the owners of Hulu&nbsp;â€” 21st Century Fox, the Walt Disney Company and NBCUniversal&nbsp;â€” provided a reprieve.</p>', '<a href=\\"<a href=\\\\\\"<a href=\\\\\\\\\\\\\\"<a href=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"http://www.nytimes.com/2013/07/19/business/media/instead-of-a-sale-hulu-concentrates-on-the-awesomes.html\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\" target=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"_blank\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\" >Learn More</a>\\\\\\\\\\\\\\" t', '<a href=\\"<a href=\\\\\\"<a href=\\\\\\\\\\\\\\"<a href=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"undefined\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\" target=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"_blank\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\" >null</a>\\\\\\\\\\\\\\" target=\\\\\\\\\\\\\\"_blank\\\\\\\\\\\\\\" >Download PDF</a>\\\\\\" target=\\\\\\"_blank\\\\\\" >Download PDF</a>\\" target=\\"', 'source/news images/New-York-Times-article_thumb.jpg');
INSERT INTO `news_item` VALUES(3, '<p>AdWeek</p>', 1, '<p>Steak â€™n Shakeâ€™s new spot is named Ad Of The Day</p>', '<p>Carmichael Lynchâ€™s new campaign for Steak â€™n Shake is a triumph of hair, sound and costumes.</p>', '<a href=\\"<a href=\\\\\\"http://www.adweek.com/news/advertising-branding/ad-day-great-hair-and-sound-drive-steak-n-shake-ads-151666\\\\\\" target=\\\\\\"_blank\\\\\\" >Learn More</a>\\" target=\\"_blank\\" >Learn More</a>', '<a href=\\"<a href=\\\\\\"source/pdfs/fake_document.pdf\\\\\\" target=\\\\\\"_blank\\\\\\" >Download PDF</a>\\" target=\\"_blank\\" >Download PDF</a>', 'source/news images/Ad-Week-article-thumb.jpg');
INSERT INTO `news_item` VALUES(4, '<p>AdWeek</p>', 0, '<p>Carmichael Lynch Gets Tempur-Pedic Media Follows win of creative work</p>', '<p>Tempur-Pedic expanded its relationship with Carmichael Lynch, giving the Minneapolis agency responsibility for media planning, buying and analytics.</p>', '<a href=\\"<a href=\\\\\\"http://www.adweek.com/news/advertising-branding/carmichael-lynch-gets-tempur-pedic-media-149469\\\\\\" target=\\\\\\"_blank\\\\\\" >Learn More</a>\\" target=\\"_blank\\" >Learn More</a>', '<a href=\\"<a href=\\\\\\"undefined\\\\\\" target=\\\\\\"_blank\\\\\\" >null</a>\\" target=\\"_blank\\" >Download PDF</a>', 'source/news images/Ad-Week-Tempur-Pedic-article_thumb.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` VALUES(1, 'Marcus Fischer', 'source/people images/Marcus_Fischer_circleThumb.png');
INSERT INTO `person` VALUES(2, 'Mike Lescarbeau', 'source/people images/Mike_Lescarbeau_circleThumb.png');
INSERT INTO `person` VALUES(3, '<p>Dave Damman</p>', 'source/people images/Dave_Damman_circleThumb.png');
INSERT INTO `person` VALUES(4, 'Stacy Janicki', 'source/people images/Stacy_Janicki_circleThumb.png');
INSERT INTO `person` VALUES(5, 'Steve Knapp', 'source/people images/Steve_Knapp_circleThumb.png');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `clientproj_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumbnail_url` varchar(255) NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `sortorder` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` VALUES(1, 3, 'Movie Marathons', 'source/project images/American-Standard-Movie-Marathons_thumb.jpg', '73243530', 'NULL', 1, 0);
INSERT INTO `project` VALUES(2, 4, 'Barbie', 'source/project images/Barbie_thumb.jpg', 'NULL', 'source/project images/Barbie Ad.jpg', 1, 0);
INSERT INTO `project` VALUES(3, 2, 'Nature Painting', 'source/project images/Subaru-Nature-Painting_thumb.jpg', '66733042', '', 1, 0);
INSERT INTO `project` VALUES(4, 5, 'All Dolled Up', 'source/project images/Jack-Links-All-Dolled-Up_thumb.jpg', '66171596', NULL, 1, 0);
INSERT INTO `project` VALUES(5, 1, 'Bear', '', '65739725', NULL, 0, 0);
INSERT INTO `project` VALUES(6, 1, 'Cloud', '', '72111862', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(80) NOT NULL,
  `user_pass` varchar(48) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, 'admin', '6d39f343158b37aabdc345d69e2f3510761b4dc4b6423ed');

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

INSERT INTO `user_login` VALUES(1, 'visitor', 'pword');
