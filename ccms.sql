-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 03 月 29 日 10:11
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ccms`
--
CREATE DATABASE IF NOT EXISTS `ccms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ccms`;

-- --------------------------------------------------------

--
-- 表的结构 `ws_debug_log`
--

CREATE TABLE IF NOT EXISTS `ws_debug_log` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '纠错ID',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '1' COMMENT '用户ID',
  `info` varchar(255) NOT NULL COMMENT '内容',
  `date_add` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='纠错记录表' AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `ws_debug_log`
--

INSERT INTO `ws_debug_log` (`id`, `user_id`, `info`, `date_add`) VALUES
(17, 1, 'a:7:{s:2:"id";s:1:"2";s:10:"gallery_id";s:1:"2";s:5:"title";s:7:"图片1";s:4:"path";s:27:"201403/25/53311a2dea4a1.jpg";s:8:"date_add";s:10:"1395726895";s:11:"date_modify";s:10:"1395726893";s:9:"path_name";s:41:"./data/attach/201403/25/53311a2dea4a1.jpg";}', 1395727807),
(16, 1, 'a:1:{i:0;s:9:"path_name";}', 1395727759),
(15, 1, 'UPDATE `ws_ext_val` SET `ext_id`=3,`value`=''12'',`date_modify`=1395307623 WHERE ( `id` = 1 )', 1395307623);

-- --------------------------------------------------------

--
-- 表的结构 `ws_ext`
--

CREATE TABLE IF NOT EXISTS `ws_ext` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `res_type` varchar(50) NOT NULL COMMENT '资源类型',
  `res_id` mediumint(8) unsigned NOT NULL COMMENT '资源ID',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `type` varchar(50) NOT NULL DEFAULT 'text' COMMENT '字段类型',
  `lable` varchar(50) NOT NULL COMMENT '标签',
  `sort_order` mediumint(8) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `ws_ext`
--

INSERT INTO `ws_ext` (`id`, `res_type`, `res_id`, `title`, `type`, `lable`, `sort_order`) VALUES
(3, 'item', 2, '价格', 'text', 'price', 2),
(4, 'item', 2, '颜色', 'text', 'color', 2),
(5, 'item', 16, '价格', 'text', 'price', 1),
(6, 'item', 16, '尺寸', 'text', 'size', 2),
(7, 'item', 16, '颜色', 'text', 'color', 3),
(8, 'item', 16, '口味', 'text', 'taste', 5);

-- --------------------------------------------------------

--
-- 表的结构 `ws_ext_val`
--

CREATE TABLE IF NOT EXISTS `ws_ext_val` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `res_id` mediumint(8) unsigned NOT NULL COMMENT '资源ID',
  `ext_id` mediumint(8) unsigned NOT NULL COMMENT '扩展ID',
  `value` varchar(255) NOT NULL COMMENT '扩展内容',
  `date_add` int(10) unsigned NOT NULL DEFAULT '0',
  `date_modify` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `ws_ext_val`
--

INSERT INTO `ws_ext_val` (`id`, `res_id`, `ext_id`, `value`, `date_add`, `date_modify`) VALUES
(1, 3, 3, '12', 1395306972, 1395733243),
(2, 3, 4, '红色', 1395307782, 1395733243),
(3, 15, 3, '1500', 1395308478, 1395889740),
(4, 15, 4, 'white', 1395308478, 1395889740),
(5, 20, 5, '10', 1395910246, 1395910569),
(6, 20, 6, '6|8|10', 1395910246, 1395910569),
(7, 20, 7, '红色|黄色', 1395910246, 1395910569),
(8, 20, 8, '甜', 1395910246, 1395910569),
(9, 21, 5, '20', 1395910295, 1395910582),
(10, 21, 6, '8|10', 1395910295, 1395910582),
(11, 21, 7, '白色|黑色', 1395910295, 1395910582),
(12, 21, 8, '酸甜', 1395910295, 1395910582),
(13, 22, 3, '10', 1396076720, 1396076720),
(14, 22, 4, '热度', 1396076720, 1396076720),
(15, 23, 3, '0', 1396076737, 1396076737),
(16, 23, 4, '', 1396076737, 1396076737),
(17, 24, 3, '2', 1396076758, 1396076758),
(18, 24, 4, '', 1396076758, 1396076758),
(19, 25, 3, '4', 1396076771, 1396076771),
(20, 25, 4, '', 1396076771, 1396076771),
(21, 26, 3, '', 1396076783, 1396076783),
(22, 26, 4, '', 1396076783, 1396076783);

-- --------------------------------------------------------

--
-- 表的结构 `ws_gallery`
--

CREATE TABLE IF NOT EXISTS `ws_gallery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '图库id',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `title` varchar(50) NOT NULL COMMENT '图库标题',
  `intro` varchar(255) NOT NULL COMMENT '图库简介',
  `cover` varchar(255) NOT NULL COMMENT '封面',
  `date_add` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `ws_gallery`
--

INSERT INTO `ws_gallery` (`id`, `parent_id`, `user_id`, `title`, `intro`, `cover`, `date_add`, `date_modify`) VALUES
(11, 0, 1, '是嘎嘎', 'again', '20', 1395729185, 1395739548),
(13, 0, 1, '首页幻灯片', '首页幻灯片', '35', 1395821978, 1396056371),
(14, 0, 6, '蛋糕', '蛋糕图片', '', 1395909980, 1395909980),
(15, 0, 6, '鲜花', '鲜花', '', 1395909991, 1395909991),
(16, 0, 6, '礼品', '礼品', '', 1395909998, 1395909998),
(17, 0, 6, '其他', '图标之类的', '', 1395911358, 1395911358),
(18, 0, 6, '首页幻灯片', '首页幻灯片', '', 1395911526, 1395911526);

-- --------------------------------------------------------

--
-- 表的结构 `ws_gallery_meta`
--

CREATE TABLE IF NOT EXISTS `ws_gallery_meta` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片ID',
  `gallery_id` int(11) unsigned NOT NULL,
  `title` varchar(50) NOT NULL COMMENT '标题',
  `path` varchar(255) NOT NULL COMMENT '图片路径',
  `date_add` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='图库图片表' AUTO_INCREMENT=37 ;

--
-- 转存表中的数据 `ws_gallery_meta`
--

INSERT INTO `ws_gallery_meta` (`id`, `gallery_id`, `title`, `path`, `date_add`, `date_modify`) VALUES
(10, 11, '', '201403/25/53312ca2264ba.jpg', 1395731618, 1395731618),
(9, 0, '', '201403/25/53312bec4533f.jpg', 1395731438, 1395731438),
(8, 11, '1', '201403/25/5331253b977d1.jpg', 1395729725, 1395729723),
(11, 11, '', '201403/25/53312da626ff1.jpg', 1395731880, 1395731880),
(12, 11, '', '201403/25/53312dcde2134.jpg', 1395731919, 1395731919),
(13, 11, '', '201403/25/53313007e69df.jpg', 1395732488, 1395732488),
(14, 11, '', '201403/25/5331313f587b3.jpg', 1395732799, 1395732799),
(15, 11, '', '201403/25/533132e685358.jpg', 1395733223, 1395733223),
(16, 11, '', '201403/25/533132fab6133.jpg', 1395733243, 1395733243),
(17, 11, '', '201403/25/533133afe5487.jpg', 1395733424, 1395733424),
(18, 11, '', '201403/25/533134abcf68f.jpg', 1395733676, 1395733676),
(19, 11, '', '201403/25/533134c3579f0.jpg', 1395733699, 1395733699),
(20, 11, '', '201403/25/53314b9cf0d6c.jpg', 1395739549, 1395739549),
(35, 13, '1', '201403/29/5336210f20c74.jpg', 1396056335, 1396056335),
(22, 14, '蛋糕1', '201403/27/5333e59a62690.jpg', 1395910042, 1395910042),
(23, 14, '蛋糕2', '201403/27/5333e5a609761.jpg', 1395910054, 1395910054),
(24, 14, '蛋糕3', '201403/27/5333e5be61342.jpg', 1395910078, 1395910078),
(25, 14, '蛋糕4', '201403/27/5333e5cb4c24d.jpg', 1395910091, 1395910091),
(26, 14, '蛋糕5', '201403/27/5333e5d6929d3.jpg', 1395910102, 1395910102),
(27, 14, '蛋糕6', '201403/27/5333e5e19e7cb.jpg', 1395910113, 1395910113),
(28, 17, '1', '201403/27/5333eae0bad8c.jpg', 1395911392, 1395911392),
(29, 17, '', '201403/27/5333eae86ae03.jpg', 1395911400, 1395911400),
(30, 17, '', '201403/27/5333eaeee96e8.jpg', 1395911406, 1395911406),
(31, 17, '', '201403/27/5333eaf54a573.jpg', 1395911413, 1395911413),
(32, 18, '1', '201403/27/5333eb79090a9.jpg', 1395911545, 1395911545),
(33, 18, '2', '201403/27/5333eb80c84ff.jpg', 1395911552, 1395911552),
(34, 18, '3', '201403/27/5333eb8847442.jpg', 1395911560, 1395911560),
(36, 13, '2', '201403/29/533621186a155.jpg', 1396056344, 1396056344);

-- --------------------------------------------------------

--
-- 表的结构 `ws_item`
--

CREATE TABLE IF NOT EXISTS `ws_item` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) unsigned NOT NULL COMMENT '父级ID',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `cover` varchar(255) NOT NULL COMMENT '封面',
  `intro` varchar(255) NOT NULL COMMENT '简介',
  `info` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '显示状态，默认1为显示',
  `template_id` mediumint(8) NOT NULL DEFAULT '1',
  `views` mediumint(8) unsigned NOT NULL COMMENT '浏览量',
  `likes` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'like s ',
  `sort_order` mediumint(8) unsigned NOT NULL COMMENT '排序',
  `date_add` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `date_modify` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- 转存表中的数据 `ws_item`
--

INSERT INTO `ws_item` (`id`, `parent_id`, `user_id`, `title`, `cover`, `intro`, `info`, `status`, `template_id`, `views`, `likes`, `sort_order`, `date_add`, `date_modify`) VALUES
(1, 0, 1, '关于我们', '15', '关于我们描述0', '&lt;p&gt;关于我们内容00&lt;/p&gt;', 1, 1, 5, 0, 1, 1394776452, 1395733222),
(2, 0, 1, '产品展示', '12', '产品展示描述', '&lt;p&gt;产品展示&lt;/p&gt;', 1, 2, 7, 0, 2, 1394776658, 1395889689),
(3, 2, 1, '产品1', '16', '产品1描述', '&lt;p&gt;产品1内容&lt;/p&gt;', 1, 1, 0, 0, 1, 1394778104, 1395733242),
(4, 0, 4, '男女服装', '', '男女服装1', '男女服装内容', 1, 2, 0, 0, 1, 1394806997, 1394812555),
(5, 0, 4, '名包', '', '名包', '名包', 1, 2, 0, 0, 2, 1394807160, 1394812567),
(6, 0, 4, '名表', '', '名比啊', '名表', 1, 1, 0, 0, 3, 1394807182, 1394807182),
(7, 0, 4, '饰品', '', '饰品', '饰品', 1, 1, 0, 0, 4, 1394807196, 1394807196),
(8, 0, 4, '香水', '', '香水', '香水', 1, 1, 0, 0, 5, 1394807214, 1394807214),
(9, 0, 4, '化妆品', '', '化妆品', '化妆品', 1, 1, 0, 0, 6, 1394807242, 1394807242),
(10, 0, 1, '在线留言', '20', '在线留言', '&lt;p&gt;在线留言&lt;/p&gt;', 1, 3, 22, 0, 3, 1394854819, 1395889708),
(11, 0, 5, '关于海森', '', '关于海森描述', '关于海森内容', 1, 13, 0, 0, 1, 1395022506, 1395022666),
(14, 0, 1, '联系方式', '18', '联系方式', '&lt;p&gt;联系方式&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', 1, 8, 0, 0, 4, 1395285697, 1395889723),
(15, 2, 1, 'z10', '10', 'z10是', '&lt;p&gt;z10 is the blackberry first bb10 phone&lt;br/&gt;&lt;/p&gt;', 1, 1, 0, 0, 2, 1395308478, 1395889740),
(16, 0, 6, '蛋糕', '28', '蛋糕订购', '&lt;p&gt;蛋糕订购&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', 1, 15, 0, 0, 1, 1395909896, 1395911431),
(17, 0, 6, '鲜花', '29', '鲜花', '&lt;p&gt;鲜花&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', 1, 15, 0, 0, 2, 1395909916, 1395911444),
(18, 0, 6, '礼品', '31', '礼品', '&lt;p&gt;礼品&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', 1, 15, 0, 0, 3, 1395909935, 1395911458),
(19, 0, 6, '会员中心', '30', '会员中心', '&lt;p&gt;会员中心&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', 1, 15, 0, 0, 4, 1395909957, 1395911471),
(20, 16, 6, '蛋糕1', '22', '蛋糕1描述', '&lt;p&gt;蛋糕1详情&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', 1, 16, 0, 0, 1, 1395910246, 1395910569),
(21, 16, 6, '蛋糕2', '23', '蛋糕2描述', '&lt;p&gt;蛋糕2详情&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', 1, 16, 0, 0, 2, 1395910295, 1395910582),
(22, 2, 1, '测试', '', '测试', '测试&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', 1, 1, 0, 0, 3, 1396076719, 1396076719),
(23, 2, 1, '测试', '', '测试', '&lt;p&gt;测试测试测试测试测试测试测试测试测试测试&lt;/p&gt;', 1, 1, 0, 0, 4, 1396076737, 1396076737),
(24, 2, 1, '测试', '', '测试', '&lt;p&gt;测试&lt;/p&gt;', 1, 1, 0, 0, 5, 1396076758, 1396076758),
(25, 2, 1, '测试', '', '测试', '&lt;p&gt;测试&lt;/p&gt;', 1, 1, 0, 0, 6, 1396076771, 1396076771),
(26, 2, 1, '测试', '', '测试', '&lt;p&gt;测试&lt;/p&gt;', 1, 1, 0, 0, 7, 1396076783, 1396076783);

-- --------------------------------------------------------

--
-- 表的结构 `ws_item_img`
--

CREATE TABLE IF NOT EXISTS `ws_item_img` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` mediumint(8) unsigned NOT NULL COMMENT '栏目ID',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `image` varchar(255) NOT NULL COMMENT '图片地址',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，默认0为不显示',
  `sort_order` mediumint(8) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ws_member`
--

CREATE TABLE IF NOT EXISTS `ws_member` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员ID',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '用户ID',
  `wechat_id` varchar(100) NOT NULL COMMENT '会员微信号',
  `name` varchar(50) NOT NULL COMMENT '会员名称',
  `avatar` varchar(100) NOT NULL COMMENT '头像',
  `password` varchar(255) NOT NULL COMMENT '登录密码',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `email` varchar(50) NOT NULL COMMENT '邮箱地址',
  `date_reg` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `date_login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`mobile`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='会员信息表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ws_member`
--

INSERT INTO `ws_member` (`id`, `user_id`, `wechat_id`, `name`, `avatar`, `password`, `mobile`, `email`, `date_reg`, `date_login`) VALUES
(1, 1, 'FromUser', '', '', '', '', '', 1395209295, 1395209295),
(2, 1, 'chanmo', 'chanmo', '', '', '', '', 1395976724, 1395978987);

-- --------------------------------------------------------

--
-- 表的结构 `ws_member_event`
--

CREATE TABLE IF NOT EXISTS `ws_member_event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员浏览记录ID',
  `member_id` int(10) unsigned NOT NULL COMMENT '会员ID ',
  `item_id` int(10) unsigned NOT NULL COMMENT '栏目ID',
  `event` varchar(50) NOT NULL DEFAULT 'views' COMMENT 'defualt 1 is visit action, 2 is like action',
  `item_name` varchar(100) NOT NULL COMMENT '栏目名称',
  `date_event` int(10) NOT NULL COMMENT '访问时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='会员action记录' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `ws_member_msg`
--

CREATE TABLE IF NOT EXISTS `ws_member_msg` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '信息类型，默认1为微信留言，2为网站留言',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员ID',
  `mobile` varchar(11) NOT NULL DEFAULT '0' COMMENT '手机号码',
  `qq` varchar(11) NOT NULL DEFAULT '0' COMMENT 'QQ号码',
  `wechat` varchar(20) NOT NULL DEFAULT '0' COMMENT '微信号码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `info` varchar(255) NOT NULL COMMENT '内容',
  `date_msg` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='会员留言信息表' AUTO_INCREMENT=77 ;

--
-- 转存表中的数据 `ws_member_msg`
--

INSERT INTO `ws_member_msg` (`id`, `type`, `member_id`, `mobile`, `qq`, `wechat`, `email`, `info`, `date_msg`) VALUES
(55, 1, 1, '0', '0', '0', '', 'subscribe', 1395208727),
(58, 1, 2, '0', '0', '0', '', '测试', 1395976754),
(61, 1, 2, '0', '0', '0', '', '英语', 1395977151),
(62, 1, 2, '0', '0', '0', '', '我的信息', 1395977383),
(74, 1, 2, '0', '0', '0', '', '笑话', 1395978642),
(75, 1, 2, '0', '0', '0', '', '新闻', 1395978867),
(76, 1, 2, '0', '0', '0', '', '百度新闻', 1395978987);

-- --------------------------------------------------------

--
-- 表的结构 `ws_setting`
--

CREATE TABLE IF NOT EXISTS `ws_setting` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '微信ID',
  `site_name` varchar(20) NOT NULL COMMENT '站点名称',
  `logo` varchar(100) NOT NULL COMMENT '网站LOGO',
  `url` varchar(100) NOT NULL DEFAULT '0' COMMENT '微网链接',
  `background` varchar(100) NOT NULL COMMENT '首页背景图',
  `theme_id` mediumint(8) NOT NULL DEFAULT '1' COMMENT '主题ID',
  `color_id` mediumint(8) unsigned NOT NULL DEFAULT '1' COMMENT '配色ID',
  `banner_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '首页幻灯片图库',
  `address` varchar(255) NOT NULL COMMENT '详细地址',
  `tel` char(15) NOT NULL COMMENT '联系电话',
  `mobile` char(15) NOT NULL COMMENT '手机号码',
  `qq` char(12) NOT NULL COMMENT 'QQ号码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `longitude` decimal(12,8) NOT NULL DEFAULT '0.00000000' COMMENT '经度',
  `latitude` decimal(12,8) NOT NULL DEFAULT '0.00000000' COMMENT '维度',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='网站全局参数表' AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `ws_setting`
--

INSERT INTO `ws_setting` (`id`, `user_id`, `site_name`, `logo`, `url`, `background`, `theme_id`, `color_id`, `banner_id`, `address`, `tel`, `mobile`, `qq`, `email`, `longitude`, `latitude`) VALUES
(9, 4, 'Allison奢华名品汇', '', '0', '', 1, 1, 0, '河南省郑州市', '0371-88888888', '', '', 'orangechen.1991@gmail.com', '0.00000000', '0.00000000'),
(10, 1, '半氪心', '14', '0', '', 1, 1, 13, '', '0379-88888888', '', '', '', '0.00000000', '0.00000000'),
(11, 5, '海森国际', '', '0', '', 2, 1, 0, '', '', '', '', '', '0.00000000', '0.00000000'),
(14, 6, '3156蛋糕商城', '', '0', '', 3, 1, 18, '山东省济南市', '0531-00000000', '', '', 'orangechen.1991@gmail.com', '0.00000000', '0.00000000');

-- --------------------------------------------------------

--
-- 表的结构 `ws_shop_order`
--

CREATE TABLE IF NOT EXISTS `ws_shop_order` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车ID',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员ID',
  `receive_name` varchar(50) NOT NULL COMMENT '收货人姓名',
  `receive_mobile` varchar(11) NOT NULL COMMENT '收货人手机号码',
  `comment` varchar(255) NOT NULL COMMENT '买家留言',
  `pay_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '支付方式：默认1为支付宝支付',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '订单状态：默认1为提交，2为支付，3为发货，4为收货，5为评价，0为取消',
  `date_add` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='购物车' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ws_shop_order_meta`
--

CREATE TABLE IF NOT EXISTS `ws_shop_order_meta` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `item_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  `number` smallint(4) unsigned NOT NULL DEFAULT '1' COMMENT '数量',
  `price` double(6,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '单价',
  `discount` smallint(4) unsigned NOT NULL DEFAULT '100' COMMENT '折扣',
  `price_count` double(6,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '总价',
  `date_add` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `date_modify` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ws_tab`
--

CREATE TABLE IF NOT EXISTS `ws_tab` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `parent_id` mediumint(8) NOT NULL DEFAULT '0' COMMENT '父ID',
  `title` varchar(20) NOT NULL COMMENT '选项卡名称',
  `tag` varchar(20) NOT NULL COMMENT '选项卡标识',
  `intro` varchar(255) NOT NULL COMMENT '功能描述',
  `info` text NOT NULL COMMENT '功能详情',
  `url` varchar(100) NOT NULL COMMENT '链接地址',
  `sort_order` smallint(6) DEFAULT NULL COMMENT '显示顺序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '显示状态：默认1为管理员显示，用户不显示，2为都显示',
  `date_add` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='平台界面选项卡信息表' AUTO_INCREMENT=63 ;

--
-- 转存表中的数据 `ws_tab`
--

INSERT INTO `ws_tab` (`id`, `parent_id`, `title`, `tag`, `intro`, `info`, `url`, `sort_order`, `status`, `date_add`, `date_modify`) VALUES
(48, 31, '信息列表', '', '', '', 'Member/msgList', 2, 2, 1396086860, 1396087570),
(47, 31, '会员列表', '', '', '', 'Member/memberList', 1, 2, 1396086834, 1396086834),
(46, 30, '栏目管理', '', '', '', 'Item/itemList', 2, 2, 1396086805, 1396086805),
(45, 30, '微网设置', '', '', '', 'Item/setting', 1, 2, 1396086788, 1396086788),
(44, 39, '菜单管理', '', '', '', 'Tab/tabList', 1, 2, 1396086699, 1396086699),
(43, 29, '修改密码', '', '', '', 'User/password', 2, 2, 1396084579, 1396084579),
(42, 29, '基本信息', '', '', '', 'User/basic', 1, 2, 1396084517, 1396084517),
(41, 28, '主题管理', '', '', '', '', 4, 2, 1396084426, 1396087645),
(40, 28, '微信功能', '', '', '', '', 3, 2, 1396084412, 1396087636),
(39, 28, '平台设置', '', '', '', '', 2, 2, 1396084390, 1396084390),
(38, 28, '用户管理', '', '', '', '', 1, 2, 1396084379, 1396084379),
(33, 27, '图库管理', '', '', '', '', 6, 2, 1396084280, 1396084280),
(34, 27, '推送管理', '', '', '', '', 7, 2, 1396084293, 1396084293),
(35, 27, '菜单管理', '', '', '', '', 8, 2, 1396084304, 1396084304),
(36, 27, '主题管理', '', '', '', '', 9, 2, 1396084328, 1396084328),
(37, 27, '插件管理', '', '', '', '', 10, 2, 1396084344, 1396084344),
(49, 33, '图库列表', '', '', '', 'Gallery/galleryList', 1, 2, 1396086930, 1396086930),
(29, 27, '我的信息', '', '', '', '', 1, 2, 1396084176, 1396084189),
(30, 27, '微网管理', '', '', '', '', 2, 2, 1396084216, 1396084216),
(31, 27, '会员管理', '', '', '', '', 3, 2, 1396084227, 1396084227),
(28, 0, '设置', 'setting', '', '', '', 2, 2, 1396084101, 1396084433),
(27, 0, '内容', 'content', '内容管理', '', '', 1, 2, 1396084013, 1396084039),
(50, 34, '关注回复', '', '', '', 'News/special, array(''keyword''=>''关注'')', 1, 2, 1396086997, 1396086997),
(51, 34, '默认回复', '', '', '', 'News/special, array(''keyword''=>''默认'')', 2, 2, 1396087021, 1396087021),
(52, 34, '文本回复', '', '', '', 'News/textList', 3, 2, 1396087064, 1396087064),
(53, 34, '图文回复', '', '', '', 'News/newsList', 4, 2, 1396087078, 1396087078),
(54, 35, '菜单列表', '', '', '', 'Menu/menuList', 1, 1, 1396087107, 1396087107),
(55, 36, '主题列表', '', '', '', 'Theme/themeList', 1, 2, 1396087168, 1396087168),
(56, 37, '插件列表', '', '', '', 'Tool/toolList', 1, 2, 1396087207, 1396087207),
(57, 38, '用户列表', '', '', '', 'User/userList', 1, 2, 1396087260, 1396087260),
(58, 38, '添加用户', '', '', '', 'User/add', 2, 2, 1396087284, 1396087621),
(59, 40, '接口模拟', '', '', '', 'Wechat/sim', 1, 2, 1396087326, 1396087326),
(60, 40, '关键字', '', '', '', 'Wechat/keywordList', 3, 2, 1396087365, 1396087731),
(61, 40, '插件管理', '', '', '', 'Tool/toolList', 2, 2, 1396087380, 1396087380),
(62, 41, '主题列表', '', '', '', 'Theme/themeList', 1, 2, 1396087407, 1396087407);

-- --------------------------------------------------------

--
-- 表的结构 `ws_theme`
--

CREATE TABLE IF NOT EXISTS `ws_theme` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '主题名称',
  `spell` varchar(50) NOT NULL COMMENT '主题标记',
  `cover` varchar(100) NOT NULL COMMENT '效果图',
  `intro` varchar(255) NOT NULL COMMENT '描述',
  `author` varchar(50) NOT NULL COMMENT '作者',
  `version` double(3,1) NOT NULL DEFAULT '1.0' COMMENT '版本',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_add` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `spell` (`spell`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ws_theme`
--

INSERT INTO `ws_theme` (`id`, `name`, `spell`, `cover`, `intro`, `author`, `version`, `status`, `date_add`, `date_modify`) VALUES
(1, '默认主题', 'default', '14', '默认主题', 'chen', 1.0, 1, 0, 1395893154),
(2, '海森国际', 'haisen', '8', '海森国际微网站主题', 'shuan', 1.0, 1, 1395020393, 1395893139),
(3, '蛋糕商城', 'cakeshop', '10', '商城模板', 'chuan', 1.0, 1, 1395910370, 1395910370);

-- --------------------------------------------------------

--
-- 表的结构 `ws_theme_tpl`
--

CREATE TABLE IF NOT EXISTS `ws_theme_tpl` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `theme_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '主题ID',
  `name` varchar(20) NOT NULL COMMENT '模板名称',
  `spell` varchar(20) NOT NULL COMMENT '模板拼写',
  `version` float(3,1) NOT NULL DEFAULT '1.0' COMMENT '版本',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` mediumint(8) DEFAULT '-1' COMMENT '显示顺序',
  `date_add` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `date_modify` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `ws_theme_tpl`
--

INSERT INTO `ws_theme_tpl` (`id`, `theme_id`, `name`, `spell`, `version`, `status`, `sort_order`, `date_add`, `date_modify`) VALUES
(1, 1, '详情页', 'detail', 1.0, 1, 1, 0, 0),
(2, 1, '列表页', 'list', 1.0, 1, 2, 0, 0),
(3, 1, '在线留言', 'leave', 1.0, 1, 4, 0, 0),
(4, 1, '在线预约', 'reserve', 1.0, 0, 5, 0, 1394873686),
(5, 1, '栅格页', 'grid', 1.0, 1, 3, 0, 0),
(8, 1, '联系方式页', 'contact', 1.0, 1, -1, 0, 0),
(11, 2, '图文列表', 'list', 1.0, 1, 1, 1395021877, 1395022129),
(12, 2, '文字列表', 'textList', 1.0, 1, 2, 1395021890, 1395021890),
(13, 2, '详情页', 'detail', 1.0, 1, 3, 1395021905, 1395021905),
(14, 2, '会员中心', 'user', 1.0, 1, 4, 1395899556, 1395899572),
(15, 3, '列表页', 'list', 1.0, 0, 1, 1395910428, 1395910428),
(16, 3, '商品详情页', 'detail', 1.0, 0, 2, 1395910445, 1395910445),
(17, 3, '个人中心页', 'user', 1.0, 0, 3, 1395910458, 1395910458);

-- --------------------------------------------------------

--
-- 表的结构 `ws_user`
--

CREATE TABLE IF NOT EXISTS `ws_user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '分组ID',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `avatar` varchar(255) NOT NULL COMMENT '头像',
  `key` varchar(50) NOT NULL COMMENT '密钥',
  `url` varchar(100) NOT NULL COMMENT '接口地址',
  `token` varchar(50) NOT NULL,
  `appid` varchar(100) NOT NULL,
  `appsecrect` varchar(100) NOT NULL,
  `date_reg` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `date_log` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `ip_log` varchar(15) NOT NULL DEFAULT '0' COMMENT '上次登录Ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `ws_user`
--

INSERT INTO `ws_user` (`id`, `group_id`, `name`, `password`, `mobile`, `avatar`, `key`, `url`, `token`, `appid`, `appsecrect`, `date_reg`, `date_log`, `ip_log`) VALUES
(1, 1, 'chen', 'fe01d67a002dfa0f3ac084298142eccd', '15550005746', '11', 'chen', '', 'chenmo', '', '', 0, 0, '0'),
(4, 2, 'allison', '4651d80cfa79f4933bc5408665394e9c', '15550005746', '201403/14/532305635ec48.jpg', '', '', 'allison', '', '', 1394803627, 1394803627, '0'),
(6, 2, 'cakeshop', 'a69d888a968c33f3f2f2eb6368732161', '', '22', '', '', '', '', '', 1395909744, 1395909744, '0');

-- --------------------------------------------------------

--
-- 表的结构 `ws_wechat_menu`
--

CREATE TABLE IF NOT EXISTS `ws_wechat_menu` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `parent_id` mediumint(8) unsigned NOT NULL COMMENT '父级ID',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '用户ID',
  `name` varchar(20) NOT NULL COMMENT '菜单名称',
  `type` enum('view','click') NOT NULL DEFAULT 'view' COMMENT '菜单类型',
  `value` varchar(100) NOT NULL COMMENT '菜单值：若type为url，则为链接类型；若type为click，则为eventkey',
  `sort_order` mediumint(8) unsigned NOT NULL DEFAULT '5' COMMENT '排序',
  `date_modify` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单管理' AUTO_INCREMENT=114 ;

--
-- 转存表中的数据 `ws_wechat_menu`
--

INSERT INTO `ws_wechat_menu` (`id`, `parent_id`, `user_id`, `name`, `type`, `value`, `sort_order`, `date_modify`) VALUES
(111, 0, 1, 'sfaf', 'click', 'dfadf', 2, 1395109221),
(110, 0, 1, '半颗心', 'view', '001', 1, 1395107153),
(112, 110, 1, '哈哈哈哈', 'view', 'ad', 1, 1395281237),
(113, 111, 1, '菜单策划', 'click', '关键字', 1, 1395281217);

-- --------------------------------------------------------

--
-- 表的结构 `ws_wechat_news`
--

CREATE TABLE IF NOT EXISTS `ws_wechat_news` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '用户ID',
  `date_add` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `ws_wechat_news`
--

INSERT INTO `ws_wechat_news` (`id`, `user_id`, `date_add`, `date_modify`) VALUES
(1, 1, 0, 1395733676),
(2, 1, 0, 1395890469),
(7, 5, 1395049721, 1395370169),
(6, 5, 1395048849, 1395370173),
(8, 1, 1395122783, 1395372616),
(9, 5, 1395371238, 1395371238),
(10, 5, 1395371503, 1395371503);

-- --------------------------------------------------------

--
-- 表的结构 `ws_wechat_news_meta`
--

CREATE TABLE IF NOT EXISTS `ws_wechat_news_meta` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `news_id` mediumint(8) unsigned NOT NULL COMMENT '图文ID',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `cover` varchar(100) NOT NULL COMMENT '封面',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `content` text NOT NULL COMMENT '详细内容',
  `url` varchar(100) NOT NULL COMMENT '链接地址',
  `sort_order` mediumint(8) unsigned NOT NULL DEFAULT '255' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用状态：默认1为启用',
  `date_add` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='图文素材表' AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `ws_wechat_news_meta`
--

INSERT INTO `ws_wechat_news_meta` (`id`, `news_id`, `title`, `cover`, `description`, `content`, `url`, `sort_order`, `status`, `date_add`, `date_modify`) VALUES
(1, 1, '欢迎进入MY WORLD', '18', '这里是XXX', '', 'http://www.baidu.com', 255, 1, 1395034976, 1395733676),
(2, 2, '对不起，没有找到所需的内容', '19', 'I''m so sorry.', '', 'http://localhost/ccms/index.php?g=Mobile&amp;m=Index&amp;a=index&amp;user=haisen', 255, 1, 1395035427, 1395890469),
(6, 6, '1212', '', '1313', '1313', '', 1, 1, 1395049864, 1395049864),
(8, 8, '图文1', '19', '图为1描述', '&lt;p&gt;图文2描述&lt;br/&gt;&lt;/p&gt;', '', 1, 1, 1395122798, 1395733699),
(9, 8, '图文2', '12', '图为呢2', '&lt;p&gt;图文2尼尔&lt;br/&gt;&lt;/p&gt;', '', 2, 1, 1395122807, 1395890561),
(10, 9, '哈哈哈哈', '', '哈哈哈哈哈', '', '', 255, 1, 1395371238, 1395371238),
(11, 10, '对不起，没有匹配到任何东西哦', '', '没有啊没有啊', '', '', 255, 1, 1395371503, 1395371503);

-- --------------------------------------------------------

--
-- 表的结构 `ws_wechat_route`
--

CREATE TABLE IF NOT EXISTS `ws_wechat_route` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '用户ID',
  `obj_type` varchar(20) NOT NULL DEFAULT 'news' COMMENT '资源类型',
  `obj_id` varchar(10) NOT NULL COMMENT '资源ID',
  `keyword` varchar(20) NOT NULL COMMENT '唯一标识',
  `date_add` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='响应路由表' AUTO_INCREMENT=40 ;

--
-- 转存表中的数据 `ws_wechat_route`
--

INSERT INTO `ws_wechat_route` (`id`, `user_id`, `obj_type`, `obj_id`, `keyword`, `date_add`, `date_modify`) VALUES
(2, 5, 'text', '8', '帮助1', 1395026605, 1395370158),
(3, 5, 'text', '10', '帮助2', 1395026788, 1395370163),
(5, 5, 'text', '11', '帮助3', 1395032588, 1395370153),
(6, 1, 'news', '1', '关注', 1395034976, 1395733676),
(7, 1, 'news', '2', '无匹配', 1395035427, 1395890469),
(8, 5, 'news', '7', '图文121', 1395045829, 1395370169),
(11, 1, 'text', '12', '测试', 1395104857, 1395975740),
(10, 5, 'news', '6', '图文3', 1395048849, 1395370173),
(12, 1, 'news', '8', '发个图文吧', 1395122783, 1395372616),
(18, 0, 'common', '0', '取消关注', 1395222382, 1395222382),
(14, 0, 'common', '0', '关注', 1395222343, 1395222343),
(15, 0, 'common', '0', '天气', 1395222352, 1395222352),
(16, 0, 'common', '0', '新闻', 1395222360, 1395222360),
(17, 0, 'common', '0', '笑话', 1395222366, 1395222366),
(19, 0, 'common', '0', '默认', 1395222683, 1395222683),
(20, 1, 'text', '13', '你是谁', 1395222731, 1395372592),
(21, 1, 'tool', '2', '新闻', 1395370037, 1395370037),
(22, 5, 'news', '9', '关注', 1395371238, 1395371238),
(23, 5, 'news', '10', '无匹配', 1395371503, 1395371503),
(24, 0, 'common', '0', '无匹配', 1395372479, 1395372479),
(26, 5, 'tool', '5', '笑话', 1395374541, 1395374541),
(27, 0, 'common', '0', '菜谱', 1395378986, 1395378986),
(38, 1, 'tool', '8', '我的信息', 1395978143, 1395978143),
(29, 0, 'common', '0', '我的信息', 1395970086, 1395970086),
(30, 0, 'common', '0', '我的收藏', 1395970100, 1395970100),
(31, 0, 'common', '0', '我的记录', 1395970112, 1395970112),
(32, 0, 'common', '0', '我的订单', 1395970786, 1395970786),
(33, 1, 'tool', '9', '我的收藏', 1395976929, 1395976929),
(34, 1, 'tool', '4', '英语', 1395976937, 1395976937),
(35, 1, 'tool', '1', '天气查询', 1395976941, 1395976941),
(36, 1, 'tool', '3', '翻译', 1395976945, 1395976945),
(37, 1, 'tool', '5', '笑话', 1395976949, 1395976949),
(39, 1, 'tool', '10', '百度新闻', 1395978969, 1395978969);

-- --------------------------------------------------------

--
-- 表的结构 `ws_wechat_text`
--

CREATE TABLE IF NOT EXISTS `ws_wechat_text` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '用户ID',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `date_add` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文本回复' AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `ws_wechat_text`
--

INSERT INTO `ws_wechat_text` (`id`, `user_id`, `content`, `date_add`, `date_modify`) VALUES
(8, 5, '帮助测试文本1', 1395024768, 1395370158),
(11, 5, '半天祝啊啊', 1395032588, 1395370153),
(10, 5, '哈哈哈', 1395026788, 1395370163),
(12, 1, '测试本文哈哈哈哈', 1395104857, 1395975740),
(13, 1, '我是我哦', 1395222731, 1395372592);

-- --------------------------------------------------------

--
-- 表的结构 `ws_wechat_tool`
--

CREATE TABLE IF NOT EXISTS `ws_wechat_tool` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `name` varchar(20) NOT NULL COMMENT '插件名称',
  `intro` varchar(255) NOT NULL COMMENT '插件描述',
  `function` varchar(20) NOT NULL COMMENT '处理函数名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '插件启用状态：默认1为可用',
  `sort_order` mediumint(8) unsigned NOT NULL COMMENT '显示顺序，1为最前',
  `date_add` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='插件详情表' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `ws_wechat_tool`
--

INSERT INTO `ws_wechat_tool` (`id`, `name`, `intro`, `function`, `status`, `sort_order`, `date_add`, `date_modify`) VALUES
(1, '天气查询', '输入“天气”后跟任意城市名称，查询城市天气', 'weather', 0, 1, 0, 0),
(2, '新闻', '输入“新闻”，回复当前新浪头条新闻', 'sinaNews', 1, 0, 0, 0),
(3, '翻译', '输入“翻译”加任意内容，回复翻译后的内容', 'trans', 0, 2, 0, 0),
(4, '英语', '输入“英语”，回复一句随机英语', 'english', 1, 1, 0, 0),
(5, '笑话', '输入“笑话”，回复一则随机笑话', 'joke', 1, 3, 0, 1395970707),
(6, '菜谱', '输入“菜谱”，随机返回一个菜谱', 'cookBook', 0, 4, 1395374131, 1395374359),
(8, '我的信息', '输入“我的信息”，根据用户的微信号获取用户的个人信息，以文本的形式返回给用户。', 'memberInfo', 1, 1, 1395970581, 1395970581),
(9, '我的收藏', '输入“我的收藏”，获取到用户的ID，然后根据ID获取到收藏列表，以图文的形式返回。', 'memberLike', 1, 0, 1395970672, 1395970672),
(10, '百度新闻', '输入“百度新闻”，以图文形式回复5条百度新闻', 'baiduNews', 1, 5, 1395978962, 1395978962);

-- --------------------------------------------------------

--
-- 表的结构 `ws_wechat_tpl`
--

CREATE TABLE IF NOT EXISTS `ws_wechat_tpl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `type` varchar(20) NOT NULL COMMENT '模板类型',
  `texttpl` text NOT NULL COMMENT '模板数据',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='xml模板信息表' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `ws_wechat_tpl`
--

INSERT INTO `ws_wechat_tpl` (`id`, `type`, `texttpl`) VALUES
(1, 'news', '<item>\r\n<Title><![CDATA[%s]]></Title>\r\n<Description><![CDATA[%s]]></Description>\r\n<PicUrl><![CDATA[%s]]></PicUrl>\r\n<Url><![CDATA[%s]]></Url>\r\n</item>'),
(2, 'text', ' <MsgType><![CDATA[text]]></MsgType>\r\n <Content><![CDATA[%s]]></Content>'),
(3, 'image', '<MsgType><![CDATA[image]]></MsgType>\r\n<Image>\r\n<MediaId><![CDATA[media_id]]></MediaId>\r\n</Image>'),
(4, 'voice', '<MsgType><![CDATA[voice]]></MsgType>\r\n<Voice>\r\n<MediaId><![CDATA[media_id]]></MediaId>\r\n</Voice>'),
(5, 'video', '<MsgType><![CDATA[video]]></MsgType>\r\n<Video>\r\n<MediaId><![CDATA[media_id]]></MediaId>\r\n<ThumbMediaId><![CDATA[thumb_media_id]]></ThumbMediaId>\r\n</Video> '),
(6, 'music', '<MsgType><![CDATA[music]]></MsgType>\r\n<Music>\r\n<Title><![CDATA[TITLE]]></Title>\r\n<Description><![CDATA[DESCRIPTION]]></Description>\r\n<MusicUrl><![CDATA[MUSIC_Url]]></MusicUrl>\r\n<HQMusicUrl><![CDATA[HQ_MUSIC_Url]]></HQMusicUrl>\r\n<ThumbMediaId><![CDATA[media_id]]></ThumbMediaId>'),
(7, 'header', ' <xml>\r\n <ToUserName><![CDATA[%s]]></ToUserName>\r\n <FromUserName><![CDATA[%s]]></FromUserName>\r\n <CreateTime>%s</CreateTime>\r\n %s\r\n </xml>\r\n');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
