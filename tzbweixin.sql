-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- 主机: w.rdc.sae.sina.com.cn:3307
-- 生成日期: 2014 年 08 月 16 日 11:11
-- 服务器版本: 5.5.23
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `app_littlenut`
--

-- --------------------------------------------------------

--
-- 表的结构 `CategoryAssocContent`
--

CREATE TABLE IF NOT EXISTS `CategoryAssocContent` (
  `CATEGORYASSOCID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CATEGORYID` int(11) NOT NULL,
  `CONTENTID` int(11) NOT NULL,
  `AddTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CATEGORYASSOCID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `CategoryAssocContent`
--

INSERT INTO `CategoryAssocContent` (`CATEGORYASSOCID`, `CATEGORYID`, `CONTENTID`, `AddTime`) VALUES
(17, 1, 21, '2014-08-16 11:11:03');

-- --------------------------------------------------------

--
-- 表的结构 `Content`
--

CREATE TABLE IF NOT EXISTS `Content` (
  `CONTENTID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `Author` varchar(50) NOT NULL,
  `Content` text NOT NULL,
  `AddTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CONTENTID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `Content`
--

INSERT INTO `Content` (`CONTENTID`, `Title`, `Author`, `Content`, `AddTime`) VALUES
(21, '测试', 'chl', '<p>这里我可以写一些输入提示</p><p>测试</p>', '2014-08-16 11:11:03');

-- --------------------------------------------------------

--
-- 表的结构 `ContentCategory`
--

CREATE TABLE IF NOT EXISTS `ContentCategory` (
  `CATEGORYID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(50) NOT NULL,
  `CategoryKey` varchar(50) NOT NULL,
  PRIMARY KEY (`CATEGORYID`),
  KEY `CategoryKey` (`CategoryKey`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `ContentCategory`
--

INSERT INTO `ContentCategory` (`CATEGORYID`, `CategoryName`, `CategoryKey`) VALUES
(1, '创青春指南', 'TZB_GUIDE'),
(2, '会务安排', 'TZB_MEETING'),
(3, '特别活动', 'TZB_ACTIVITY'),
(4, '联系我们', 'TZB_CONNECT'),
(5, '创政策', 'TZB_POLICY'),
(6, '创青春达人', 'TZB_PERSON'),
(7, '创team资讯', 'TZB_TEAM'),
(8, '图片汇编', 'TZB_PIC');

-- --------------------------------------------------------

--
-- 表的结构 `Knowledge`
--

CREATE TABLE IF NOT EXISTS `Knowledge` (
  `KNOWID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Question` text NOT NULL,
  `Answer` text NOT NULL,
  PRIMARY KEY (`KNOWID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `Knowledge`
--

INSERT INTO `Knowledge` (`KNOWID`, `Question`, `Answer`) VALUES
(14, '你好吗', '你好');

-- --------------------------------------------------------

--
-- 表的结构 `Session`
--

CREATE TABLE IF NOT EXISTS `Session` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(500) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `Session`
--

INSERT INTO `Session` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('6a8407583ca876427125514c033a9123', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', 1408155200, 'a:4:{s:9:"user_data";s:0:"";s:3:"UID";s:1:"3";s:8:"UserName";s:4:"test";s:8:"LoggedIn";b:1;}'),
('1ff5060e4545eb2657bbc356b177e3ce', '222.240.46.182', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', 1408158557, 'a:4:{s:9:"user_data";s:0:"";s:3:"UID";s:1:"3";s:8:"UserName";s:4:"test";s:8:"LoggedIn";b:1;}');

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
(1, 'asdasd', '2014-06-24 11:19:27');

-- --------------------------------------------------------

--
-- 表的结构 `Tag`
--

CREATE TABLE IF NOT EXISTS `Tag` (
  `TAGID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TagName` varchar(10) NOT NULL,
  PRIMARY KEY (`TAGID`),
  UNIQUE KEY `TagName` (`TagName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `Tag`
--

INSERT INTO `Tag` (`TAGID`, `TagName`) VALUES
(12, 'test');

-- --------------------------------------------------------

--
-- 表的结构 `TagAssocKnow`
--

CREATE TABLE IF NOT EXISTS `TagAssocKnow` (
  `TAGASSOCID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TAGID` int(10) unsigned NOT NULL,
  `KNOWID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`TAGASSOCID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `TagAssocKnow`
--

INSERT INTO `TagAssocKnow` (`TAGASSOCID`, `TAGID`, `KNOWID`) VALUES
(19, 12, 14);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `User`
--

INSERT INTO `User` (`UID`, `UserName`, `PassWord`, `RealName`, `DepartMent`, `ContactInfo`) VALUES
(3, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'test', 'test', 'test'),
(5, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '管理员', '', '');
