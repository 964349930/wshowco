-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 03 月 19 日 09:54
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='纠错记录表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ws_debug_log`
--

INSERT INTO `ws_debug_log` (`id`, `user_id`, `info`, `date_add`) VALUES
(1, 1, '2', 1395208511);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ws_ext_val`
--

CREATE TABLE IF NOT EXISTS `ws_ext_val` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `res_id` mediumint(8) unsigned NOT NULL COMMENT '资源ID',
  `ext_id` mediumint(8) unsigned NOT NULL COMMENT '扩展ID',
  `value` varchar(255) NOT NULL COMMENT '扩展内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `ws_item`
--

INSERT INTO `ws_item` (`id`, `parent_id`, `user_id`, `title`, `cover`, `intro`, `info`, `status`, `template_id`, `views`, `likes`, `sort_order`, `date_add`, `date_modify`) VALUES
(1, 0, 1, '关于我们', '201403/14/5322a1d3bf1e4.jpg', '关于我们描述', '关于我们内容0', 1, 1, 5, 0, 1, 1394776452, 1394778581),
(2, 0, 1, '产品展示', '', '产品展示描述', '产品展示', 1, 1, 7, 0, 2, 1394776658, 1394776658),
(3, 2, 1, '产品1', '', '产品1描述', '产品1内容', 1, 1, 0, 0, 1, 1394778104, 1394778104),
(4, 0, 4, '男女服装', '', '男女服装1', '男女服装内容', 1, 2, 0, 0, 1, 1394806997, 1394812555),
(5, 0, 4, '名包', '', '名包', '名包', 1, 2, 0, 0, 2, 1394807160, 1394812567),
(6, 0, 4, '名表', '', '名比啊', '名表', 1, 1, 0, 0, 3, 1394807182, 1394807182),
(7, 0, 4, '饰品', '', '饰品', '饰品', 1, 1, 0, 0, 4, 1394807196, 1394807196),
(8, 0, 4, '香水', '', '香水', '香水', 1, 1, 0, 0, 5, 1394807214, 1394807214),
(9, 0, 4, '化妆品', '', '化妆品', '化妆品', 1, 1, 0, 0, 6, 1394807242, 1394807242),
(10, 0, 1, '在线留言', '', '在线留言', '在线留言', 1, 3, 22, 0, 3, 1394854819, 1394854849),
(11, 0, 5, '关于海森', '', '关于海森描述', '关于海森内容', 1, 13, 0, 0, 1, 1395022506, 1395022666);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='会员信息表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ws_member`
--

INSERT INTO `ws_member` (`id`, `user_id`, `wechat_id`, `name`, `avatar`, `password`, `mobile`, `email`, `date_reg`, `date_login`) VALUES
(1, 1, 'FromUser', '', '', '', '', '', 1395209295, 1395209295);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='会员留言信息表' AUTO_INCREMENT=58 ;

--
-- 转存表中的数据 `ws_member_msg`
--

INSERT INTO `ws_member_msg` (`id`, `type`, `member_id`, `mobile`, `qq`, `wechat`, `email`, `info`, `date_msg`) VALUES
(55, 1, 1, '0', '0', '0', '', 'subscribe', 1395208727);

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
  `address` varchar(255) NOT NULL COMMENT '详细地址',
  `tel` char(15) NOT NULL COMMENT '联系电话',
  `mobile` char(15) NOT NULL COMMENT '手机号码',
  `qq` char(12) NOT NULL COMMENT 'QQ号码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `longitude` decimal(12,8) NOT NULL DEFAULT '0.00000000' COMMENT '经度',
  `latitude` decimal(12,8) NOT NULL DEFAULT '0.00000000' COMMENT '维度',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='网站全局参数表' AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `ws_setting`
--

INSERT INTO `ws_setting` (`id`, `user_id`, `site_name`, `logo`, `url`, `background`, `theme_id`, `color_id`, `address`, `tel`, `mobile`, `qq`, `email`, `longitude`, `latitude`) VALUES
(9, 4, 'Allison奢华名品汇', '', '0', '', 1, 1, '河南省郑州市', '0371-88888888', '', '', 'orangechen.1991@gmail.com', '0.00000000', '0.00000000'),
(10, 1, '半氪心', '', '0', '', 1, 1, '', '0379-88888888', '', '', '', '0.00000000', '0.00000000'),
(11, 5, '海森国际', '', '0', '', 2, 1, '', '', '', '', '', '0.00000000', '0.00000000');

-- --------------------------------------------------------

--
-- 表的结构 `ws_shop_order`
--

CREATE TABLE IF NOT EXISTS `ws_shop_order` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员ID',
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
-- 表的结构 `ws_shop_trolley`
--

CREATE TABLE IF NOT EXISTS `ws_shop_trolley` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车ID',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员ID',
  `order_id` mediumint(8) unsigned NOT NULL COMMENT '订单DI',
  `date_add` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='购物车' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ws_tab`
--

CREATE TABLE IF NOT EXISTS `ws_tab` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `fid` mediumint(8) NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(20) NOT NULL COMMENT '选项卡名称',
  `spell` varchar(20) NOT NULL COMMENT '选项卡标识',
  `description` varchar(255) NOT NULL COMMENT '功能描述',
  `content` text NOT NULL COMMENT '功能详情',
  `url` varchar(100) NOT NULL COMMENT '链接地址',
  `display_order` smallint(6) NOT NULL COMMENT '显示顺序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '显示状态：默认1为显示',
  `ctime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='平台界面选项卡信息表' AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `ws_tab`
--

INSERT INTO `ws_tab` (`id`, `fid`, `name`, `spell`, `description`, `content`, `url`, `display_order`, `status`, `ctime`) VALUES
(16, 2, '话题回复', 'topic', '', '', 'index.php?g=Admin&m=Topic&a=topicList', 4, 1, 0),
(15, 2, '图文回复', 'news', '', '', 'index.php?g=Admin&m=News&a=newsList', 3, 1, 0),
(14, 2, '文本回复', 'text', '', '', 'index.php?g=Admin&m=Text&a=textList', 2, 1, 0),
(13, 2, '关注时回复', 'sub', '', '', 'index.php?g=Admin&m=News&a=subscribe&keyword=关注', 1, 1, 0),
(12, 1, '微网访问记录', 'visit', '', '', 'index.php?g=Admin&m=Log&a=logList&type=visit', 0, 1, 0),
(11, 1, '消息记录', 'message', '', '', 'index.php?g=Admin&m=Log&a=logList&type=message', 0, 0, 0),
(10, 1, '接口调用记录', 'api', '', '', 'index.php?g=Admin&m=Log&a=logList&type=api', 0, 1, 0),
(9, 0, '微会员', '', '', '', '', 9, 0, 0),
(3, 0, '自定义菜单', '', '', '', '', 3, 1, 0),
(2, 0, '自动回复', '', '', '', '', 2, 1, 0),
(1, 0, '运营记录', '', '', '', '', 1, 1, 0),
(4, 0, '微官网', '', '', '', '', 4, 1, 0),
(5, 0, '微商城', '', '', '', '', 5, 0, 0),
(7, 0, '微预约', '', '', '', '', 7, 0, 0),
(6, 0, '微留言', '', '', '', '', 6, 1, 0),
(8, 0, '微应用', '', '', '', '', 8, 1, 0),
(17, 3, '菜单列表', 'menu', '', '', 'index.php?g=Admin&m=Menu&a=menuList', 0, 1, 0),
(18, 4, '微网设置', 'setting', '', '', 'index.php?g=Admin&m=Cat&a=setting', 1, 1, 0),
(19, 4, '栏目管理', 'cat', '', '', 'index.php?g=Admin&m=Cat&a=catList', 2, 1, 0),
(20, 4, '主题列表', 'theme', '', '', 'index.php?g=Admin&m=Theme&a=themeList', 3, 1, 0),
(22, 6, '留言管理', 'leave', '', '', 'index.php?g=Admin&m=Leave&a=leaveList', 1, 1, 0),
(23, 7, '预约管理', 'reserve', '', '', 'index.php?g=Admin&m=Reserve&a=reserveList', 1, 1, 0),
(24, 8, '应用列表', 'toolList', '', '', 'index.php?g=Admin&m=Tool&a=toolList', 1, 1, 0),
(25, 2, '无匹配回复', 'none', '', '', 'index.php?g=Admin&m=News&a=subscribe&keyword=默认', 2, 1, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ws_theme`
--

INSERT INTO `ws_theme` (`id`, `name`, `spell`, `cover`, `intro`, `author`, `version`, `status`, `date_add`, `date_modify`) VALUES
(1, '默认主题', 'default', '201403/14/5322d1cf13619.jpg', '默认主题', 'chen', 1.0, 1, 0, 1394790863),
(2, '海森国际', 'haisen', '201403/17/532652682d2f9.jpg', '海森国际微网站主题', 'shuan', 1.0, 1, 1395020393, 1395020393);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

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
(13, 2, '详情页', 'detail', 1.0, 1, 3, 1395021905, 1395021905);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `ws_user`
--

INSERT INTO `ws_user` (`id`, `group_id`, `name`, `password`, `mobile`, `avatar`, `key`, `url`, `token`, `appid`, `appsecrect`, `date_reg`, `date_log`, `ip_log`) VALUES
(1, 1, 'chen', 'fe01d67a002dfa0f3ac084298142eccd', '15550005746', '201403/14/5322898c44ae2.jpg', 'chen', '', 'chenmo', '', '', 0, 0, '0'),
(4, 2, 'allison', '4651d80cfa79f4933bc5408665394e9c', '15550005746', '201403/14/532305635ec48.jpg', '', '', 'allison', '', '', 1394803627, 1394803627, '0'),
(5, 2, 'haisen', 'ff9327827f8e171914f34e428d6eafba', '', '', '', '', '', '', '', 1395022299, 1395022299, '0');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单管理' AUTO_INCREMENT=113 ;

--
-- 转存表中的数据 `ws_wechat_menu`
--

INSERT INTO `ws_wechat_menu` (`id`, `parent_id`, `user_id`, `name`, `type`, `value`, `sort_order`, `date_modify`) VALUES
(111, 0, 1, 'sfaf', 'click', 'dfadf', 2, 1395109221),
(110, 0, 1, '半颗心', 'view', '001', 1, 1395107153),
(112, 110, 1, 'afdaf ', 'click', 'ad', 3, 1395109305);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `ws_wechat_news`
--

INSERT INTO `ws_wechat_news` (`id`, `user_id`, `date_add`, `date_modify`) VALUES
(1, 1, 0, 0),
(2, 1, 0, 1395035603),
(7, 5, 1395049721, 1395049844),
(6, 5, 1395048849, 1395048849),
(8, 1, 1395122783, 1395122783);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='图文素材表' AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `ws_wechat_news_meta`
--

INSERT INTO `ws_wechat_news_meta` (`id`, `news_id`, `title`, `cover`, `description`, `content`, `url`, `sort_order`, `status`, `date_add`, `date_modify`) VALUES
(1, 1, '图文测试', '', '图文描述', '', 'http://www.baidu.com', 255, 1, 1395034976, 1395034976),
(2, 2, '欢迎欢迎', '201403/17/53268d2374660.jpg', '欢迎描书0', '', 'http://localhost/ccms/index.php?g=Mobile&amp;m=Index&amp;a=index&amp;user=haisen', 255, 1, 1395035427, 1395035603),
(6, 6, '1212', '', '1313', '1313', '', 1, 1, 1395049864, 1395049864),
(8, 8, '000', '', '0.', '0.0', '', 1, 1, 1395122798, 1395122798),
(9, 8, '.2', '', '2.1', '\r\n1313', '', 2, 1, 1395122807, 1395122807);

-- --------------------------------------------------------

--
-- 表的结构 `ws_wechat_route`
--

CREATE TABLE IF NOT EXISTS `ws_wechat_route` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `obj_type` varchar(20) NOT NULL DEFAULT 'news' COMMENT '资源类型',
  `obj_id` varchar(10) NOT NULL COMMENT '资源ID',
  `keyword` varchar(20) NOT NULL COMMENT '唯一标识',
  `date_add` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='响应路由表' AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `ws_wechat_route`
--

INSERT INTO `ws_wechat_route` (`id`, `obj_type`, `obj_id`, `keyword`, `date_add`, `date_modify`) VALUES
(2, 'text', '8', '帮助1', 1395026605, 1395032563),
(3, 'text', '10', '帮助2', 1395026788, 1395026941),
(5, 'text', '11', '帮助3', 1395032588, 1395032588),
(6, 'news', '1', '关注', 1395034976, 1395034976),
(7, 'news', '2', '无匹配', 1395035427, 1395035603),
(8, 'news', '7', '图文121', 1395045829, 1395049844),
(11, 'text', '12', '测试', 1395104857, 1395104857),
(10, 'news', '6', '图文3', 1395048849, 1395048849),
(12, 'news', '8', '000', 1395122783, 1395122783),
(18, 'common', '0', '取消关注', 1395222382, 1395222382),
(14, 'common', '0', '关注', 1395222343, 1395222343),
(15, 'common', '0', '天气', 1395222352, 1395222352),
(16, 'common', '0', '新闻', 1395222360, 1395222360),
(17, 'common', '0', '笑话', 1395222366, 1395222366),
(19, 'common', '0', '默认', 1395222683, 1395222683),
(20, 'text', '13', '哈哈哈哈', 1395222731, 1395222731);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文本回复' AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `ws_wechat_text`
--

INSERT INTO `ws_wechat_text` (`id`, `user_id`, `content`, `date_add`, `date_modify`) VALUES
(8, 5, '帮助测试文本1', 1395024768, 1395032563),
(11, 5, '半天祝啊啊', 1395032588, 1395032588),
(10, 5, '哈哈哈', 1395026788, 1395026941),
(12, 1, '测试本文', 1395104857, 1395104857),
(13, 1, '哈哈哈哈', 1395222731, 1395222731);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='插件详情表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `ws_wechat_tool`
--

INSERT INTO `ws_wechat_tool` (`id`, `name`, `intro`, `function`, `status`, `sort_order`, `date_add`, `date_modify`) VALUES
(1, '天气查询', '输入“天气”后跟任意城市名称，查询城市天气', 'weather', 0, 1, 0, 0),
(2, '新闻', '输入“新闻”，回复当前新浪头条新闻', 'sinaNews', 1, 0, 0, 0),
(3, '翻译', '输入“翻译”加任意内容，回复翻译后的内容', 'trans', 0, 2, 0, 0),
(4, '英语', '输入“英语”，回复一句随机英语', 'english', 1, 1, 0, 0),
(5, '笑话', '回复“笑话”，回复一则随机笑话', 'joke', 1, 3, 0, 0);

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
