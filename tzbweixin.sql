-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 07 月 05 日 01:47
-- 服务器版本: 5.5.37
-- PHP 版本: 5.3.10-1ubuntu3.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `tzbweixin`
--

-- --------------------------------------------------------

--
-- 表的结构 `CategoryAssocContent`
--

CREATE TABLE IF NOT EXISTS `CategoryAssocContent` (
  `CATEGORYASSOCID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CATEGORYID` int(11) NOT NULL,
  `CONTENTID` int(11) NOT NULL,
  PRIMARY KEY (`CATEGORYASSOCID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `CategoryAssocContent`
--

INSERT INTO `CategoryAssocContent` (`CATEGORYASSOCID`, `CATEGORYID`, `CONTENTID`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `Content`
--

CREATE TABLE IF NOT EXISTS `Content` (
  `CONTENTID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `Author` varchar(50) NOT NULL,
  `Content` text NOT NULL,
  `AddTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CONTENTID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `Content`
--

INSERT INTO `Content` (`CONTENTID`, `Title`, `Author`, `Content`, `AddTime`) VALUES
(1, '你好', '我', '哈哈哈', '0000-00-00 00:00:00'),
(2, 'dasd', 'asdsa', '<p>这里我可以写一些输入提示</p>', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `ContentCategory`
--

CREATE TABLE IF NOT EXISTS `ContentCategory` (
  `CATEGORYID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(50) NOT NULL,
  PRIMARY KEY (`CATEGORYID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ContentCategory`
--

INSERT INTO `ContentCategory` (`CATEGORYID`, `CategoryName`) VALUES
(1, 'hehe'),
(2, 'haha');

-- --------------------------------------------------------

--
-- 表的结构 `Knowledge`
--

CREATE TABLE IF NOT EXISTS `Knowledge` (
  `KNOWID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Question` text NOT NULL,
  `Answer` text NOT NULL,
  PRIMARY KEY (`KNOWID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `Knowledge`
--

INSERT INTO `Knowledge` (`KNOWID`, `Question`, `Answer`) VALUES
(1, 'asd', 'das'),
(2, 'cbv', 'a1'),
(4, 'asd', 'q'),
(5, '你大爷', '我孙子');

-- --------------------------------------------------------

--
-- 表的结构 `Session`
--

CREATE TABLE IF NOT EXISTS `Session` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `Session`
--

INSERT INTO `Session` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('62497018ec1a7fb1e77d68c792822506', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36', 1404495465, 'a:4:{s:9:"user_data";s:0:"";s:3:"UID";s:1:"3";s:8:"UserName";s:4:"test";s:8:"LoggedIn";b:1;}'),
('6b345db961fee60c5161df61610d6a1d', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36', 1404492636, 'a:4:{s:9:"user_data";s:0:"";s:3:"UID";s:1:"3";s:8:"UserName";s:4:"test";s:8:"LoggedIn";b:1;}');

-- --------------------------------------------------------

--
-- 表的结构 `Stat`
--

CREATE TABLE IF NOT EXISTS `Stat` (
  `STATID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `VisitFakeID` varchar(32) NOT NULL,
  `VisitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`STATID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `Stat`
--

INSERT INTO `Stat` (`STATID`, `VisitFakeID`, `VisitTime`) VALUES
(1, 'asdasd', '2014-06-24 03:19:27');

-- --------------------------------------------------------

--
-- 表的结构 `Tag`
--

CREATE TABLE IF NOT EXISTS `Tag` (
  `TAGID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TagName` varchar(10) NOT NULL,
  PRIMARY KEY (`TAGID`),
  UNIQUE KEY `TagName` (`TagName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `Tag`
--

INSERT INTO `Tag` (`TAGID`, `TagName`) VALUES
(1, 'xx'),
(2, 'vhgsd'),
(3, 'gg');

-- --------------------------------------------------------

--
-- 表的结构 `TagAssocKnow`
--

CREATE TABLE IF NOT EXISTS `TagAssocKnow` (
  `TAGASSOCID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TAGID` int(10) unsigned NOT NULL,
  `KNOWID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`TAGASSOCID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `TagAssocKnow`
--

INSERT INTO `TagAssocKnow` (`TAGASSOCID`, `TAGID`, `KNOWID`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 1, 1),
(4, 1, 4),
(5, 1, 5),
(6, 3, 5);

-- --------------------------------------------------------

--
-- 表的结构 `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `UID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(20) NOT NULL,
  `PassWord` varchar(64) NOT NULL,
  `RealName` varchar(20) NOT NULL,
  `DepartMent` varchar(20) NOT NULL,
  `ContactInfo` varchar(20) NOT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `User`
--

INSERT INTO `User` (`UID`, `UserName`, `PassWord`, `RealName`, `DepartMent`, `ContactInfo`) VALUES
(3, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'test', 'test', 'test');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
