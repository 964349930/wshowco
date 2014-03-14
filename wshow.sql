-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 03 月 14 日 10:03
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wshow`
--
CREATE DATABASE IF NOT EXISTS `wshow` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `wshow`;

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
  `title` varchar(50) NOT NULL COMMENT '标题',
  `cover` varchar(255) NOT NULL COMMENT '封面',
  `intro` varchar(255) NOT NULL COMMENT '简介',
  `info` text NOT NULL COMMENT '内容',
  `views` mediumint(8) unsigned NOT NULL COMMENT '浏览量',
  `sort_order` mediumint(8) unsigned NOT NULL COMMENT '排序',
  `date_add` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `date_modify` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ws_item`
--

INSERT INTO `ws_item` (`id`, `parent_id`, `title`, `cover`, `intro`, `info`, `views`, `sort_order`, `date_add`, `date_modify`) VALUES
(1, 0, '关于我们', '201403/14/5322a1d3bf1e4.jpg', '关于我们描述', '关于我们内容0', 0, 1, 1394776452, 1394778581),
(2, 0, '产品展示', '', '产品展示描述', '产品展示', 0, 2, 1394776658, 1394776658),
(3, 2, '产品1', '', '产品1描述', '产品1内容', 0, 1, 1394778104, 1394778104);

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
-- 表的结构 `ws_log`
--

CREATE TABLE IF NOT EXISTS `ws_log` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `wechat_id` mediumint(8) unsigned NOT NULL COMMENT '微信ID',
  `guest_name` varchar(50) NOT NULL DEFAULT '0' COMMENT '关注者唯一ID',
  `msgType` varchar(20) NOT NULL COMMENT '消息类型',
  `content` varchar(255) NOT NULL COMMENT '消息内容',
  `ctime` int(10) NOT NULL DEFAULT '0' COMMENT '接口调用时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='接口访问记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ws_menu`
--

CREATE TABLE IF NOT EXISTS `ws_menu` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `parent_id` mediumint(8) unsigned NOT NULL COMMENT '父级ID',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '用户ID',
  `name` varchar(20) NOT NULL COMMENT '菜单名称',
  `type` enum('view','click') NOT NULL DEFAULT 'view' COMMENT '菜单类型',
  `value` varchar(100) NOT NULL COMMENT '菜单值：若type为url，则为链接类型；若type为click，则为eventkey',
  `sort_order` mediumint(8) unsigned NOT NULL DEFAULT '5' COMMENT '排序',
  `date_modify` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单管理' AUTO_INCREMENT=108 ;

-- --------------------------------------------------------

--
-- 表的结构 `ws_message`
--

CREATE TABLE IF NOT EXISTS `ws_message` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '用户ID',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `info` varchar(255) NOT NULL COMMENT '内容',
  `date_add` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ws_news`
--

CREATE TABLE IF NOT EXISTS `ws_news` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `wechat_id` mediumint(8) unsigned NOT NULL COMMENT '微信ID',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `cover` varchar(100) NOT NULL COMMENT '封面',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `content` text NOT NULL COMMENT '详细内容',
  `url` varchar(100) NOT NULL COMMENT '链接地址',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用状态：默认1为启用',
  `views` mediumint(8) NOT NULL DEFAULT '0' COMMENT '点击数量',
  `comments` mediumint(8) NOT NULL DEFAULT '0' COMMENT '评论数量',
  `ups` mediumint(8) NOT NULL DEFAULT '0' COMMENT '点赞数量',
  `ctime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='图文素材表' AUTO_INCREMENT=105 ;

--
-- 转存表中的数据 `ws_news`
--

INSERT INTO `ws_news` (`id`, `wechat_id`, `title`, `cover`, `description`, `content`, `url`, `status`, `views`, `comments`, `ups`, `ctime`, `mtime`) VALUES
(3, 1, '关于我们', '201312/24/52b9285f0fd97.jpg', '关于我们', '<p>&nbsp;&nbsp;&nbsp;&nbsp;成立于2009年的济南深蓝解码公司，专注互联网开发技术、用户体验设计、交互设计。精于核心技术的钻研与提升，并于2012年精细划分成立内部各技术小组，包括前端设计组，php技术组，手机android和ios系统研发组以及微信，淘宝接口，淘宝api开发组等。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;网站开发</p><p>&nbsp;&nbsp;&nbsp;&nbsp;网站策划</p><p>&nbsp;&nbsp;&nbsp;&nbsp;网站设计</p><p>&nbsp;&nbsp;&nbsp;&nbsp;应用开发</p><p>&nbsp;&nbsp;&nbsp;&nbsp;手机app开发</p><p>&nbsp;&nbsp;&nbsp;&nbsp;微信接口开发</p><p>&nbsp;&nbsp;&nbsp;&nbsp;淘宝接口开发</p><p>&nbsp;&nbsp;&nbsp;&nbsp;微博接口开发</p><p>&nbsp;&nbsp;&nbsp;&nbsp;电子商务系统开发</p><p>&nbsp;&nbsp;&nbsp;&nbsp;互联网运营项目解决方案</p><p>&nbsp;&nbsp;&nbsp;&nbsp;电子商务一体化解决方案</p>', '', 1, 6, 0, 0, 1387854188, 1393655495),
(4, 1, '欢迎进入深蓝解码', '201312/25/52ba42504fb05.jpg', '这里是济南深蓝解码软件有限公司', '', 'http://localhost/wechat/index.php?g=Shenlan&m=Cat&a=index&blue_key=13847686358953', 1, 0, 0, 0, 0, 1392176277),
(5, 1, '艾之家', '201312/25/52ba77c779b2e.jpg', '艾之家', '<p>艾之家&nbsp;&nbsp;&nbsp;&nbsp;O(∩_∩)O哈哈~</p><p><br/></p>', '', 1, 0, 0, 0, 0, 1388195324),
(6, 1, '童音旧版', '201312/25/52ba79c4bbf77.png', '童音旧版', '<p>童音旧版</p>', '', 1, 0, 0, 0, 0, 1388195362),
(2, 1, '解决方案', '201312/24/52b9587111bce.jpg', '解决方案', '<p>&nbsp;&nbsp;&nbsp;&nbsp;方案概述</p><p>&nbsp;&nbsp;&nbsp;&nbsp;—需求频繁调整怎么办？如何创建卓越的个性化体验？</p><p>&nbsp;&nbsp;&nbsp;&nbsp;—解决方案：基于不同业务类型，提供完全定制的产品。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;深蓝整合软件、业务咨询及互联网服务，形成完整的解决方案组，以满足不同的业务，不同的行业需求。拥有专业的自主研发团队，帮你打 造稳定，快速，全方位的解决方案。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;我们可以提供的服务（包括但不局限于）</p><p>&nbsp;&nbsp;&nbsp;&nbsp;官方商城&lt;020项目解决方案行业和社区网站;&lt; p=&quot;&quot;&gt;<!--020项目解决方案行业和社区网站;<--></p><p>&nbsp;&nbsp;&nbsp;&nbsp;企业管理系统开发;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;垂直社交平台;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;垂直商城;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;移动商城;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;手机网站;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;微信应用网站;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;手机端应用我们的解决方案（部分）</p><p>&nbsp;&nbsp;&nbsp;&nbsp;用纸笔构思最初的想法</p><p>&nbsp;&nbsp;&nbsp;&nbsp;分析需求和网站的功能结构；</p><p>&nbsp;&nbsp;&nbsp;&nbsp;作出粗略原型(Axure工具),把主要的信息结构与操作过程表达；</p><p>&nbsp;&nbsp;&nbsp;&nbsp;做精细化原型，包括页面布局，文字，及各种元素； <br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;与开发团队成员进行功能分解，对细节要进行注释；</p><p>&nbsp;&nbsp;&nbsp;&nbsp;与美术团队一起精细化页面设计和前端制作 ; <br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;开发经理执行开发，产品设计师跟进，讲解与测试 ;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;产品功能上线，接受来自用户的需求，功能，测试，性能，可用性，使用感受等多方面的考验<br/></p><p><br/></p>', '', 1, 11, 0, 0, 0, 1393643659),
(7, 1, '案例展示', '201312/25/52ba36d703c3f.jpg', '案例展示', '', '', 1, 33, 0, 0, 0, 1393641634),
(8, 1, '艾萨瑜伽', '201312/25/52ba386ac81a9.jpg', '艾萨瑜伽', '<p>艾萨瑜伽</p>', '', 1, 12, 0, 0, 0, 1393643229),
(9, 1, '童音早教', '201312/25/52ba3783f00cf.jpg', '童音早教', '童音早教', '', 1, 1, 0, 0, 0, 0),
(10, 1, '高新生活网', '201312/25/52ba38b9df09d.jpg', '高新生活网', '<p>高新生活网</p>', '', 1, 0, 0, 0, 0, 1388195476),
(11, 1, '爱尚窝', '201312/25/52ba391a04b15.jpg', '爱尚窝', '<p>爱尚窝</p>', '', 1, 0, 0, 0, 0, 1388195180),
(12, 1, '高丽数码', '201312/25/52ba3950d36a1.jpg', '高丽数码', '<p>高丽数码</p>', '', 1, 0, 0, 0, 0, 1388195450),
(13, 1, '世纪情缘', '201312/25/52ba397adcfcd.jpg', '世纪情缘', '<p>世纪情缘</p>', '', 1, 0, 0, 0, 0, 1388195392),
(14, 1, '联系我们', '201312/25/52ba39b61335b.jpg', '联系我们', '<p>QQ:154212549</p><p>地址：山东省济南市高新开发区工业南路25号</p>', '', 1, 10, 0, 0, 0, 1393656018),
(15, 1, '深蓝解码', '201312/28/52be2edf37e85.jpg', '深蓝解码', '<p>深蓝解码&nbsp;&nbsp;&nbsp;&nbsp;</p><p><br/></p>', '', 1, 0, 0, 0, 1388026049, 1388195640),
(16, 1, '在线留言', '201312/26/52bbdaf4b267c.jpg', '在线留言', '', '', 1, 3, 0, 0, 1388042998, 1393654067),
(17, 1, '在线预约', '201312/26/52bbdb605d1db.jpg', '在线预约', '', '', 1, 1, 0, 0, 1388043106, 1393655543),
(18, 1, '珍合婚庆', '201312/28/52be31360c3b7.jpg', '珍合婚庆', '<p>珍合婚庆是一家专业做婚纱摄影等定制服务的商家<br/></p>', '', 1, 0, 0, 0, 1388196151, 1388196151),
(19, 1, '活力28', '201312/28/52be80f4ef9d0.jpg', '活力28', '', '', 1, 0, 0, 0, 1388216566, 1388216613),
(20, 10, '高丽简介', '201401/25/52e3498f75361.jpg', '高丽简介', '<p class="p0" style="text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-family:; font-size: 10px;">经中华人民共和国国家工商行政管理总局&nbsp;商标局&nbsp;核定通过&nbsp;</span></p><p class="p0" style="text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-family:; font-size: 10px;">注册商标“KONEA”注册号：第8661190号</span></p><p class="p0" style="text-align: left; line-height: 18.75pt; text-indent: 24pt; margin-top: 5pt; margin-bottom: 5pt;"><span style="font-size: 14px;"><span style="color: rgb(65, 65, 65); font-family:;">自2007年成立之初，我们奉行“一本相册，一件珍藏品……”的产品理念，坚持“产品结构合理化、产品质量更优化、服务体系完善化、员工工作快乐化”为企业理想，历经6年磨砺，成都高丽逐渐成长为占地2000余平，员工数十人，拥有</span><span style="color: rgb(255, 0, 0); font-family:;">激光冲印、相册制作、数码打印、韩国烤瓷等</span><span style="color: rgb(65, 65, 65); font-family:;">配套完善的综合性后期公司。努力实现成为“专业的后期产品供应商、最优影楼战略合作伙伴”的企业愿景。我们坚信，一定能为您提供更具价值的综合性后期配套服务。</span></span></p><p style="text-align: center;"><img title="首页图片00.png" style="float: none;" src="http://weixin.d-bluesoft.com/data/attach/editor/20140125/13906261086204.png"/></p><p style="text-align: center;"><span style="font-size: 14px;">公司外貌</span></p><p style="text-align: center;"><img title="首页图片11.png" style="float: none;" src="http://weixin.d-bluesoft.com/data/attach/editor/20140125/13906261095214.png"/></p><p style="text-align: center;"><span style="font-size: 14px;">冲印车间</span></p><p style="text-align: center;"><img title="首页图片22.png" style="float: none;" src="http://weixin.d-bluesoft.com/data/attach/editor/20140125/13906261103309.png"/></p><p style="text-align: center;"><span style="font-size: 14px;">相册车间</span></p><p style="text-align: center;"><img title="首页图片33.png" style="float: none;" src="http://weixin.d-bluesoft.com/data/attach/editor/20140125/13906261124161.png"/></p><p style="text-align: center;"><span style="font-size: 14px;">打印车间</span></p><p style="text-align: center;"><span style="font-family:;"><o:p><img title="二维.jpg" src="http://weixin.d-bluesoft.com/data/attach/editor/20140125/13906270462789.jpg"/></o:p></span></p><p style="text-align: center;"><span style="color: rgb(192, 0, 0); font-family: 微软雅黑,Microsoft YaHei;"><o:p><span style="color: rgb(192, 0, 0); font-size: 14px;"><o:p>敬请关注高丽公众帐号：</o:p><o:p>KONEA66317791</o:p></span></o:p></span></p><p><span style="color: rgb(192, 0, 0); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;"><o:p></o:p></span><p style="text-align: center;"><o:p><span style="color: rgb(0, 0, 0); font-family: 微软雅黑,Microsoft YaHei;">点击右上角分享到朋友圈</span></o:p><br/></p><p class="p0" style="text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style="color: rgb(192, 0, 0); font-family:;">客服总机：<span style="color: rgb(192, 0, 0); font-family: Times New Roman;">02866317791</span><o:p></o:p></span></p><p class="p0" style="text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style="color: rgb(192, 0, 0); font-family:;">客服<span style="color: rgb(192, 0, 0); font-family: Times New Roman;">QQ</span><span style="color: rgb(192, 0, 0); font-family: 宋体;">：</span><span style="color: rgb(192, 0, 0); font-family: Times New Roman;">757510555&nbsp;&nbsp;757510888</span><o:p></o:p></span></p><p class="p0" style="text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style="color: rgb(192, 0, 0); font-family:;">投诉专线：<span style="color: rgb(192, 0, 0); font-family: Times New Roman;">15528293661&nbsp;&nbsp;</span></span></p><p class="p0" style="text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-family:;"><o:p><br/></o:p></span></p><p><br/></p><p></p></p>', '', 1, 38, 0, 0, 1388374588, 1390627838),
(21, 10, '最新动态', '201312/30/52c0f007ad07f.jpg', '施华洛烤瓷版画洛维奇双层延伸烤瓷', '', '', 1, 20, 0, 0, 1388374618, 1388381204),
(22, 10, '新品投票', '201401/20/52dcd2363c7a7.jpg', '新品投票', '<p>投票规则：</p><p>1-点击下列新品，您可进入详细页面进行全面品鉴。</p><p>2-如果您觉得该产品能够赢得客人的喜欢，请您点击对应的圆点，进行投票。</p><p>3-可多款投票，但每款每个微信号只能投票一次。</p><p>我们将根据投票结果对新品进行甄选或改进，择时正式上市，届时会在产品展厅里陈列。</p><h3>喜欢你就投一票，可多选</h3><p><br/></p>', '', 1, 36, 0, 0, 1388374655, 1388394642),
(23, 10, '产品展示', '', '产品展示', '', '', 1, 12, 0, 0, 1388374689, 1388381369),
(24, 10, '地图导航', '', '地图导航', '<p>详细描述公交车路线及驾车路线<br/>地址：成都市郫县安靖镇正义路（成都市看守所接待大厅正前方300米）<br/>公交到达：成都市九里堤公交站乘坐95路公交车，看守所站下车。</p>', '', 1, 19, 0, 0, 1388374710, 1388379980),
(25, 10, '一键拨号', '', '一键拨号', '', '', 1, 50, 0, 0, 1388374740, 1388394375),
(26, 10, '价廉物美，后期争宠', '201312/30/52c1022b5afaf.jpg', '各位新老客户，影楼后期版画传统的水晶拉米已经进行销售数年', '', '', 1, 5, 0, 0, 1388380715, 1388380715),
(27, 10, '高丽至臻相册与传统圣经相册', '201312/30/52c10398f158b.jpg', '相册与传统圣经相册对比品鉴目前后期市场上仍然是客人喜欢的主流产品', '<p>相册与传统圣经相册对比品鉴目前后期市场上仍然是客人喜欢的主流产品</p>', '', 1, 0, 0, 0, 1388381081, 1388381081),
(28, 10, '中式风格', '201312/30/52c104aaee1d0.jpg', '中式风格', '<p>中式风格</p>', '', 1, 1, 0, 0, 1388381355, 1388381355),
(29, 10, '韩式风格', '201312/30/52c104e7e4a9d.jpg', '韩式风格', '<p>韩式风格</p>', '', 1, 3, 0, 0, 1388381416, 1388381416),
(30, 10, '欧式风格', '201312/30/52c1051ed6f88.jpg', '欧式风格', '<p>欧式风格</p>', '', 1, 0, 0, 0, 1388381471, 1388381471),
(31, 10, '韩式风格', '201312/30/52c10547dbee2.jpg', '韩式风格', '<p>韩式风格</p>', '', 1, 2, 0, 0, 1388381512, 1388381512),
(32, 10, '欢迎进入高丽数码', '201312/30/52c107ac9cb8b.jpg', '欢迎进入高丽数码', '', '', 1, 0, 0, 0, 1388382125, 1388382125),
(33, 11, '公司简介', '201401/23/52e0e3f70129f.jpg', '创世纪情缘婚介淮安店是一家正规、专业的中高端婚恋服务机构。不仅提供一对一的婚姻介绍服务，更关注单身男女自身修养、形象礼仪等方面的提升，不但帮您找到理想伴侣，更能帮您找到幸福的密码！地址：新亚国际大厦20楼2012室，幸福热线：0517-83901314，18905235580', '<p style="margin-top:4px;margin-bottom:4px"><span style="font-size: 13px;font-family: Arial, sans-serif">&nbsp; </span><span style="font-family: 宋体, SimSun; "><span style="font-size: 13px; ">&nbsp;</span><span style="font-size: 14px; ">&nbsp;<a href="http://weixin.d-bluesoft.com/index.php?g=Shenlan&m=Cat&a=cat&id=31&blue_key=13883823918393" target="_blank" title="征婚信息">征婚信息</a>&nbsp; &nbsp;<a href="http://weixin.d-bluesoft.com/index.php?g=Shenlan&m=Shiji&a=order&blue_key=13883823918393" target="_blank" title="我要征婚">我要征婚</a>&nbsp; &nbsp;<a href="http://weixin.d-bluesoft.com/index.php?g=Shenlan&m=Cat&a=cat&id=32&blue_key=13883823918393" target="_blank" title="相亲活动">相亲活动</a>&nbsp; &nbsp;<a href="http://weixin.d-bluesoft.com/index.php?g=Shenlan&m=Cat&a=cat&id=33&blue_key=13883823918393" target="_blank" title="联系我们" style="font-family: 宋体, SimSun; font-size: 14.285715103149414px; white-space: normal; ">联系我们</a><span style="font-family: 宋体, SimSun; font-size: 14.285715103149414px;">&nbsp;</span></span></span></p><p style="margin-top:4px;margin-bottom:4px"><span style="font-family: 宋体, SimSun; "><span style="font-size: 14px; ">&nbsp; &nbsp;----------------------------------------</span></span></p><p style="margin-top:4px;margin-bottom:4px"><span style="font-family: 宋体, SimSun; "><span style="font-size: 14px; ">&nbsp; &nbsp; 创世纪情缘婚介——是婚介连锁加盟的创始者，中国婚介第一品牌！是中国唯一一家通过商务部特许经营的专业婚介加盟企业，首家通过ISO9001质量管理体系认证，荣获央视上榜品牌！在国内已发展了900多家特许加盟店。</span></span></p><p style="margin-top:4px;margin-bottom:4px"><span style="font-size: 14px; font-family: 宋体, SimSun; "><span style="font-size: 13px; font-family: Arial, sans-serif; ">&nbsp; &nbsp; </span><span style="font-size: 13px; font-family: 宋体, SimSun; ">【<strong><span style="font-size: 13px; font-family: 黑体, SimHei; "><span style="font-size: 14px; ">创世纪情缘婚介淮安店</span></span></strong>】</span><span style="font-size: 14px; font-family: 宋体, SimSun; "><span style="font-family: 宋体, SimSun; ">于</span><span style="font-family: Arial, sans-serif; ">2013</span><span style="font-family: 宋体, SimSun; ">年</span><span style="font-family: Arial, sans-serif; ">4</span><span style="font-family: 宋体, SimSun; ">月</span><span style="font-family: Arial, sans-serif; ">8</span><span style="font-family: 宋体, SimSun; ">日正式加盟成立，是由婚姻家庭咨询师、婚介师、色彩形象顾问、首席红娘杨娟老师创办。杨老师在婚恋咨询行业有着多年的咨询经验，经常参加全国婚介行业交流会，研究创新一种新型婚恋服务模式，打破了传统的婚介一对一简单的介绍服务方式，坚持</span><span style="font-family: Arial, sans-serif; ">“</span><span style="font-family: 宋体, SimSun; ">授人以鱼，不如授人以渔</span><span style="font-family: Arial, sans-serif; ">”</span><span style="font-family: 宋体, SimSun; ">的服务理念。在原有一对一服务模式的基础上，增加了</span><span style="font-family: Arial, sans-serif; ">“</span><span style="font-family: 宋体, SimSun; ">情感交流、婚恋指导、礼仪培训、个人形象色彩及服装搭配、化妆培训、红酒品鉴、品茶等</span><span style="font-family: Arial, sans-serif; ">”</span><span style="font-family: 宋体, SimSun; ">高端服务，让每个单身男女从改变自身形象开始，提升个人修养，将内在美与外在美有机的结合，从而使每一位单身男女不仅可以找到理想伴侣，而且能够幸福一生！</span></span></span></p><p style="text-align: center; "><a href="http://weixin.d-bluesoft.com/index.php?g=Shenlan&m=Cat&a=cat&id=33&blue_key=13883823918393" target="_blank" title=""><img src="http://weixin.d-bluesoft.com/Public/js/other/editor/ueditor/php/upload/53771390982473.jpg" title="办公环境2.jpg" style="width: 250px; height: 342px; " border="0" height="342" hspace="0" vspace="0" width="250"/></a></p><p><span style="font-family: 宋体, SimSun; font-size: 14.285715103149414px;">&nbsp; &nbsp;----------------------------------------</span></p><p><span style="font-size: 13px; font-family: Arial, sans-serif;">&nbsp;&nbsp;</span><span style="font-family: 宋体, SimSun;"><span style="font-size: 13px; ">&nbsp;</span><span style="font-size: 14px; ">&nbsp;<a href="http://weixin.d-bluesoft.com/index.php?g=Shenlan&m=Cat&a=cat&id=31&blue_key=13883823918393" target="_blank" title="征婚信息">征婚信息</a>&nbsp; &nbsp;<a href="http://weixin.d-bluesoft.com/index.php?g=Shenlan&m=Shiji&a=order&blue_key=13883823918393" target="_blank" title="我要征婚">我要征婚</a>&nbsp; &nbsp;<a href="http://weixin.d-bluesoft.com/index.php?g=Shenlan&m=Cat&a=cat&id=32&blue_key=13883823918393" target="_blank" title="相亲活动">相亲活动</a>&nbsp; &nbsp;<a href="http://weixin.d-bluesoft.com/index.php?g=Shenlan&m=Cat&a=cat&id=33&blue_key=13883823918393" target="_blank" title="联系我们">联系我们</a>&nbsp;</span></span></p>', 'http://weixin.d-bluesoft.com/index.php?g=Shenlan&m=Cat&a=index&', 1, 63, 0, 0, 1388382568, 1391825793),
(82, 12, '栏目1', '', '栏目1', '', '', 1, 2, 0, 0, 1391997885, 1391997885),
(83, 12, '栏目2', '', '栏目2', '', '', 1, 2, 0, 0, 1391997924, 1391997924),
(34, 11, '征婚信息', '', '征婚信息', '', '', 1, 99, 0, 0, 1388382593, 1391823084),
(35, 11, '相亲活动', '201401/29/52e862c64ff8a.jpg', '', '', '', 1, 66, 0, 0, 1388382633, 1392018878),
(36, 11, '联系我们', '201401/23/52e0e430c5ece.jpg', '', '<p style="margin-top:2.9pt;margin-right:0cm;margin-bottom:2.9pt;margin-left:\r\n0cm"><strong><span style="font-size: 18px; font-family: 宋体, SimSun; ">创世纪情缘婚介淮安总店</span></strong><span style="font-family: 宋体, SimSun; font-size: 9.5pt; "><o:p></o:p></span></p><p style="margin-top:2.9pt;margin-right:0cm;margin-bottom:2.9pt;margin-left:\r\n0cm"><span style="font-size: 9.5pt; font-family: 宋体, SimSun; "><o:p>&nbsp;</o:p></span></p><p style="margin-top:2.9pt;margin-right:0cm;margin-bottom:2.9pt;margin-left:\r\n0cm"><span style="font-family: 宋体, SimSun; font-size: 14px; ">地址：淮安市新亚国际大厦<span lang="EN-US" style="font-family: Arial, sans-serif; ">20</span>楼<span lang="EN-US" style="font-family: Arial, sans-serif; ">2012</span>室<span lang="EN-US" style="font-family: Arial, sans-serif; "><o:p></o:p></span></span></p><p style="margin-top:2.9pt;margin-right:0cm;margin-bottom:2.9pt;margin-left:\r\n0cm"><span style="font-family: 宋体, SimSun; font-size: 14px; "><span style="font-family: 宋体, SimSun; ">幸福热线：</span><span lang="EN-US" style="font-family: Arial, sans-serif; ">0517-83901314</span><o:p></o:p></span></p><p style="margin-top:2.9pt;margin-right:0cm;margin-bottom:2.9pt;margin-left:\r\n0cm"><span style="font-family: 宋体, SimSun; font-size: 14px; "><span lang="EN-US" style="font-family: Arial, sans-serif; font-size: 9.5pt; ">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><span style="font-family: 宋体, SimSun; font-size: 14px; "><span lang="EN-US" style="font-family: Arial, sans-serif; ">&nbsp; &nbsp;18905235580(</span><span style="font-family: 宋体, SimSun; ">杨老师</span><span lang="EN-US" style="font-family: Arial, sans-serif; ">)</span></span><o:p></o:p></span></p><p style="margin-top:2.9pt;margin-right:0cm;margin-bottom:2.9pt;margin-left:\r\n0cm"><span style="font-family: 宋体, SimSun; font-size: 14px; "><span style="font-family: 宋体, SimSun; ">公众微信号：</span><span lang="EN-US" style="font-family: Arial, sans-serif; ">hahj12580</span><o:p></o:p></span></p><p style="margin-top:2.9pt;margin-right:0cm;margin-bottom:2.9pt;margin-left:\r\n0cm"><span style="font-size: 14px; font-family: 宋体, SimSun; ">杨老师微信号：<span style="font-family: Arial, sans-serif; ">hayj5580</span></span></p><p style="margin-top:2.9pt;margin-right:0cm;margin-bottom:2.9pt;margin-left:\r\n0cm"><span style="font-family: 宋体, SimSun; font-size: 14px; ">腾讯微博：创世纪情缘婚恋淮安店<span lang="EN-US" style="font-family: Arial, sans-serif; font-size: 14px; "><o:p></o:p></span></span></p><p style="margin-top:2.9pt;margin-right:0cm;margin-bottom:2.9pt;margin-left:\r\n0cm"><span style="font-family: 宋体, SimSun; font-size: 14px; ">新浪微博：创世纪情缘婚恋淮安店<span style="font-family: 宋体, SimSun; font-size: 9.5pt; "></span><span lang="EN-US" style="font-family: Arial, sans-serif; font-size: 9.5pt; "><o:p></o:p></span></span></p><p><span style="font-family: 宋体, SimSun; font-size: 14px; "><span style="font-family: 宋体; ">婚恋交友</span><span lang="EN-US" style="font-family: Arial, sans-serif; ">QQ</span><span style="font-family: 宋体; ">群：</span>28108931</span></p><p><br/></p>', '', 1, 46, 0, 0, 1388382650, 1390707698),
(44, 10, '精美水晶相册', '201312/30/52c1397fa0b1f.jpg', '精美水晶相册', '<p>精美水晶相册</p>', '', 1, 0, 0, 0, 1388394880, 1388394880),
(45, 10, '精美水晶相册', '201312/30/52c139a4bc67b.jpg', '精美水晶相册', '<p>精美水晶相册</p>', '', 1, 0, 0, 0, 1388394917, 1388394917),
(46, 11, 'HASA1108', '201401/23/52e0e39edc36f.jpg', '阳光，帅气的大男孩', '', '', 1, 5, 3, 0, 1390470046, 1390470067),
(58, 10, '服务指南', '201401/20/52dcc9ec377df.jpg', '服务指南', '服务指南', '', 1, 8, 0, 0, 0, 0),
(56, 10, '快乐课堂', '201401/20/52dcc5ac183d8.jpg', '快乐课堂', '快乐课堂', '', 1, 5, 0, 0, 0, 0),
(57, 10, '客件查询', '201401/20/52dcc2cfcc13a.jpg', '客件查询', '客件查询', '', 1, 7, 0, 0, 0, 0),
(59, 10, '相册产品', '201401/20/52dd06a753f26.jpg', '相册产品', '相册产品&nbsp;&nbsp;&nbsp;&nbsp;<p><br/></p>', '', 1, 1, 0, 0, 1390470739, 1390470739),
(60, 10, '挂摆产品', '201401/20/52dd06bddac0e.jpg', '挂摆产品', '<p>挂摆产品挂摆产品</p>', '', 1, 0, 0, 0, 1390470761, 1390470761),
(61, 10, '其他产品', '201401/20/52dd069109ec6.jpg', '其他产品', '<p>其他产品</p>', '', 1, 0, 0, 0, 1390470787, 1390470787),
(65, 11, '公司简介', '201401/29/52e8ac8d488e5.jpg', '创世纪情缘婚介淮安店是一家正规、专业的中高端婚恋服务机构。不仅提供一对一的婚姻介绍服务，更关注单身男女自身修养、形象礼仪等方面的提升，不但帮您找到理想伴侣，更能帮您找到幸福的密码！地址：新亚国际大厦20楼2012室，幸福热线：0517-83901314，18905235580', '', '', 1, 15, 0, 0, 1390980237, 1390981091),
(66, 11, '【如何做夫妻？】“分享到朋友圈即可免费相亲一次”', '201401/29/52e8beded9f06.jpg', '', '<p style="margin-top: 14px; margin-bottom: 14px; white-space: normal; text-indent: 31px; background-color: rgb(248, 247, 245); "><strong><span style="font-family: 楷体_GB2312; color: red; ">1.</span></strong><strong><span style="font-family: 楷体_GB2312; color: red; ">分享这篇文章到朋友圈即可免费相亲一次！</span></strong></p><p style="white-space: normal; text-align: justify; "><strong><span style="font-family: Arial, sans-serif; color: red; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong><strong><span style="font-family: 楷体_GB2312; color: red; ">2.</span></strong><strong><span style="font-family: 楷体_GB2312; color: red; ">扫一扫我们的二维码并关注我们的公众微信号（hahj12580）即可免费相亲一次！</span></strong></p><p style="margin-top: 14px; margin-bottom: 14px; white-space: normal; text-align: justify; text-indent: 28px; background-color: rgb(248, 247, 245); "><strong><span style="text-decoration: underline; "><span style="font-family: 楷体_GB2312; color: rgb(192, 0, 0); ">相亲地址：淮安新亚国际大厦20楼2012室</span></span></strong></p><p style="margin-top: 14px; margin-bottom: 14px; white-space: normal; text-align: justify; text-indent: 28px; background-color: rgb(248, 247, 245); "><strong><span style="text-decoration: underline; "><span style="font-family: 楷体_GB2312; color: rgb(192, 0, 0); ">预约电话：0517-83901314</span></span></strong></p><p style="margin-top: 14px; margin-bottom: 14px; white-space: normal; text-align: justify; text-indent: 28px; background-color: rgb(248, 247, 245); "><strong><span style="text-decoration: underline; "><span style="font-family: 楷体_GB2312; color: rgb(192, 0, 0); ">---------------------------------</span></span></strong></p><p style="margin-top: 14px; margin-bottom: 14px; white-space: normal; text-align: justify; text-indent: 28px; background-color: rgb(248, 247, 245); "><strong><span style="font-family: 楷体_GB2312; ">1</span></strong><strong><span style="font-family: 楷体_GB2312; ">、如果两个人都不愿意变傻，都精明，都什么事弄个究竟，搞个明白，那就准备分手吧。</span></strong></p><p style="white-space: normal; "><strong><span style="font-family: 楷体_GB2312; ">　　2、“不要征服对方”这是夫妻最重要的问题！征服，是夫妻之间经常发生的事情，谈论谁是对的，追究谁是错的！讨论谁伤害了谁，谁过分了！这些，都是大忌。</span></strong></p><p style="white-space: normal; "><strong><span style="font-family: 楷体_GB2312; ">　　3、好夫妻，永远都在相互装傻！装瞎子！爱，就是护短的！能够护短的，才是真爱！</span></strong></p><p style="white-space: normal; "><strong><span style="font-family: 楷体_GB2312; ">　　4、爱啊，别为难对方，别挑剔对方，别指责对方！傻傻地一路相伴。傻，是因为已经决定了，认定了，就没有什么需要再了解、再知道，再改进，再完善的！有进步，接受，没有，也接受！爱，就在那里！</span></strong></p><p style="white-space: normal; "><strong><span style="font-family: 楷体_GB2312; ">　　5、一辈子，能够有一个人，好好相爱，多美啊！别去破坏，多大的事情都不值得你去破坏。不要在相爱的人身上动小聪明，动你的精明！要，就动你的心。</span></strong></p><p style="white-space: normal; "><strong><span style="font-family: 楷体_GB2312; ">　　6、永远不对爱人说重话！永远不去做破坏气氛和心情的事！</span></strong></p><p style="white-space: normal; "><strong><span style="font-family: 楷体_GB2312; ">　　7、男人有脾气正常，但男人的脾气可以对天发对地发对老板发，却不可以对老婆发。因为不管你心情好坏，别人都可以转身离开，却只有爱人要陪着你，陪你度过心灰意冷，度过意气风发。这一生你会得到很多失去很多，而陪你到最后的人却只有一个。天大地大，都不如身边的女人大。</span></strong></p><p style="white-space: normal; text-indent: 31px; "><strong><span style="font-family: 楷体_GB2312; ">8</span></strong><strong><span style="font-family: 楷体_GB2312; ">、写得真好！每个人只能慢慢领悟去学习，因为没有多少人可以做好！所以别做只会说不会做的人！</span></strong></p><p style="white-space: normal; text-indent: 31px; "><strong><span style="font-family: 楷体_GB2312; ">9</span></strong><strong><span style="font-family: 楷体_GB2312; ">、夫妻同心，黄土变金。家事无对错，只有和不和，家和才能万事兴！</span></strong></p><p style="white-space: normal; text-indent: 31px; "><strong><span style="font-family: 楷体_GB2312; ">10</span></strong><strong><span style="font-family: 楷体_GB2312; ">、家是讲爱的地方，不是讲理的地方。</span></strong></p><p style="white-space: normal; text-indent: 31px; "><strong><span style="font-family: 楷体_GB2312; ">11</span></strong><strong><span style="font-family: 楷体_GB2312; ">、家是有根和有魂的，根和魂是由女人掌控。</span></strong></p><p style="white-space: normal; text-indent: 31px; "><strong><span style="font-family: 楷体_GB2312; ">12</span></strong><strong><span style="font-family: 楷体_GB2312; ">、世界上最伟大的力量是爱，最强有力的武</span></strong><strong><span style="font-family: 楷体_GB2312; ">\\</span></strong><strong><span style="font-family: 楷体_GB2312; ">器是感动！</span></strong></p><p style="white-space: normal; text-indent: 31px; "><strong><span style="font-family: 楷体_GB2312; ">13</span></strong><strong><span style="font-family: 楷体_GB2312; ">、吵不离，骂不散，打不走，才是爱真正的爱。</span></strong></p><p style="white-space: normal; text-indent: 31px; "><strong><span style="font-family: 楷体_GB2312; ">14</span></strong><strong><span style="font-family: 楷体_GB2312; ">、不是累了就分手，不是不合适就分开。是即使再累也想在一起，即使不合适也想努力争取，累是因为在乎，不合适是因为爱得不够，真正的爱没有那么多借口。</span></strong></p><p style="white-space: normal; text-indent: 31px; "><strong><span style="font-family: 楷体_GB2312; ">15</span></strong><strong><span style="font-family: 楷体_GB2312; ">、两个人在一起久了难免会吵嘴，女人在气头上往往说出的话句句似刀，而那个肯留下来和你吵架也不想离开你半步的才是真正爱你的男人！</span></strong></p><p style="white-space: normal; text-indent: 31px; "><strong><span style="font-family: 楷体_GB2312; ">16</span></strong><strong><span style="font-family: 楷体_GB2312; ">、当你嫌弃身边的女人不够漂亮，有没有想过有很多男人都羡慕她对你这份死心塌地的感情。</span></strong></p><p style="white-space: normal; text-indent: 31px; "><strong><span style="font-family: 楷体_GB2312; ">17</span></strong><strong><span style="font-family: 楷体_GB2312; ">、当一个女人把什么都给你了，你该知足，她看上的不是你有多帅、多有钱，而是她已经做好了和你同甘共苦的准备。</span></strong></p><p style="white-space: normal; text-indent: 31px; "><strong><span style="font-family: 楷体_GB2312; ">18</span></strong><strong><span style="font-family: 楷体_GB2312; ">、当你嫌弃身边的男人不够优秀，有没有想过他没天没夜的努力就是为了让身边心爱的你有更优越的生活条件。</span></strong></p><p style="white-space: normal; "><strong><span style="font-family: 楷体_GB2312; ">　　19、当一个男人两手空空肯为你去打拼，你该知足，他看上的不是你有多美、多性感，而是他不想苦了跟他的女人。</span></strong></p><p style="white-space: normal; "><strong><span style="font-family: 楷体_GB2312; ">　　20、在一起久了慢慢变成依赖，爱情慢慢变成亲情，就算两个人在一起没有当初的激情，那请别忘了还有感情。当你想要放手的时候，有没有想过当初为什么陪她</span></strong><strong><span style="font-family: 楷体_GB2312; ">\\</span></strong><strong><span style="font-family: 楷体_GB2312; ">他走到这里。</span></strong></p><p style="white-space: normal; "><strong><span style="font-family: 楷体_GB2312; ">　　21、在一起久了，就算没有当时那么相爱也要选择相守，这些你们对彼此做到了吗？</span></strong></p><p style="white-space: normal; text-indent: 31px; "><strong><span style="font-family: 楷体_GB2312; ">22</span></strong><strong><span style="font-family: 楷体_GB2312; ">、看完就转起，为了爱你的人和你爱的人，不想机会溜走就不要说一些伤人的话，要沟通，不要总想放弃！</span></strong></p><p style="margin-top: 14px; margin-bottom: 14px; white-space: normal; text-indent: 28px; background-color: rgb(248, 247, 245); "><span style="font-family: 楷体_GB2312; "></span><strong><span style="text-decoration: underline; "><span style="font-family: 楷体_GB2312; color: rgb(192, 0, 0); ">---------------------------------</span></span></strong></p><p style="margin-top: 14px; margin-bottom: 14px; white-space: normal; text-indent: 31px; background-color: rgb(248, 247, 245); "><strong><span style="font-family: 楷体_GB2312; color: red; ">1.</span></strong><strong><span style="font-family: 楷体_GB2312; color: red; ">分享这篇文章到朋友圈即可免费相亲一次！</span></strong></p><p style="white-space: normal; text-align: justify; "><strong><span style="font-family: Arial, sans-serif; color: red; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong><strong><span style="font-family: 楷体_GB2312; color: red; ">2.</span></strong><strong><span style="font-family: 楷体_GB2312; color: red; ">扫一扫我们的二维码并关注我们的公众微信号（hahj12580）即可免费相亲一次！</span></strong></p><p style="margin-top: 14px; margin-bottom: 14px; white-space: normal; text-align: justify; text-indent: 28px; background-color: rgb(248, 247, 245); "><strong><span style="text-decoration: underline; "><span style="font-family: 楷体_GB2312; color: rgb(192, 0, 0); ">相亲地址：淮安新亚国际大厦20楼2012室</span></span></strong></p><p style="margin-top: 14px; margin-bottom: 14px; white-space: normal; text-align: justify; text-indent: 28px; background-color: rgb(248, 247, 245); "><strong><span style="text-decoration: underline; "><span style="font-family: 楷体_GB2312; color: rgb(192, 0, 0); ">预约电话：0517-83901314</span></span></strong></p><p><br/></p>', '', 1, 14, 0, 0, 1390984926, 1390984926),
(67, 11, '测试', '', '测试', '测试&nbsp;&nbsp;&nbsp;&nbsp;<p><br/></p>', '', 1, 0, 0, 0, 1391740385, 1391740385),
(68, 11, '测试2', '', '测试i2', '', '', 1, 0, 0, 0, 1391740451, 1391740451),
(69, 11, '测试i3', '', '测试3呆呆地', '<p>订单<br/></p>', '', 1, 0, 0, 0, 1391740492, 1391742191),
(70, 11, '测试4', '', '测试4', '测试4<p><br/></p>', '', 1, 0, 0, 0, 1391741199, 1391741199),
(71, 11, '测试4', '', '', '', '', 1, 0, 0, 0, 1391741238, 1391741238),
(72, 11, '测试4', '', '', '<p>测试4</p>', '', 1, 0, 0, 0, 1391742224, 1391742224),
(76, 11, '测试', '', '测试\r\n', '测试<p><br/></p>', '', 1, 0, 0, 0, 1391745765, 1391745765),
(77, 11, '测试无匹配回复', '', '测试无匹配回复啊啊', '', 'http://localhost/wechat/index.php?g=Shenlan&m=Cat&a=index&blue_key=13883823918393', 1, 0, 0, 0, 1391755350, 1391755359),
(78, 11, '测试', '', '测试', '<p>测试</p>', '', 1, 3, 0, 0, 1391762173, 1391762173),
(79, 11, '晴天', '', '晴天', '<p>晴天 更改<br/></p>', '', 1, 0, 0, 0, 1391824625, 1391824856),
(84, 12, '栏目3', '', '栏目3', '', '', 1, 0, 0, 0, 1391997939, 1391997939),
(85, 12, '栏目4', '', '栏目4', '', '', 1, 51, 0, 0, 1391997954, 1392014674),
(86, 2, '公司简介', '', '公司简介', '<p>公司简介</p>', '', 1, 4, 0, 0, 1392027997, 1392027997),
(87, 2, '产品展示', '201402/10/52f8ab28d7139.jpg', '产品展示', '<p>产品展示</p>', '', 1, 8, 0, 0, 1392028016, 1392028458),
(88, 2, '在线留言', '', '在线留言', '<p>在线留言</p>', '', 1, 1, 0, 0, 1392028037, 1392028037),
(89, 2, '联系我们', '', '联系我们', '<p>联系我们</p>', '', 1, 2, 0, 0, 1392028055, 1392028055),
(90, 2, '馋1', '201402/10/52f8ab6415a65.jpg', '馋1', '<p>馋1</p>', '', 1, 3, 0, 0, 1392028383, 1392028539),
(91, 2, '2222', '201402/10/52f8ab3c43509.jpg', '2222', '<p>2222</p>', '', 1, 0, 0, 0, 1392028399, 1392028476),
(92, 1, '', '', '', '', '', 1, 0, 0, 0, 1393643820, 1393643820),
(93, 1, '', '', '', '', '', 1, 2, 0, 0, 1393643855, 1393643855),
(94, 3, '企业简介', '201403/03/531437eed2605.png', '企业简介描述', '<p>企业简介内容</p>', '', 1, 0, 0, 0, 1393816367, 1393833967),
(95, 3, '产品展示', '201403/03/5314380520b57.png', '产品展示描述', '<p>产品展示内容</p>', '', 1, 0, 0, 0, 1393816419, 1393833989),
(96, 3, '在线留言', '201403/03/531438181e885.jpg', '在线留言妙手', '<p>在线留言内容</p>', '', 1, 0, 0, 0, 1393816459, 1393834008),
(97, 3, '联系我们', '201403/03/53143827de28c.png', '联系我们描述', '<p>联系我们内容</p>', '', 1, 0, 0, 0, 1393816487, 1393834024),
(98, 3, '产品1', '201403/03/531438ff8d2fc.jpg', '产品1描述', '<p>产品1内容</p>', '', 1, 0, 0, 0, 1393834184, 1393834239),
(99, 3, '产品2', '201403/03/531439553871f.jpg', '产品2描述', '<p>产品2内容</p>', '', 1, 0, 0, 0, 1393834254, 1393834325),
(100, 3, '产品3', '201403/03/53143977f1beb.jpg', '产品3描述', '产品3内容<p><br/></p>', '', 1, 0, 0, 0, 1393834264, 1393834360),
(101, 3, '产品4', '201403/03/5314399a19ab2.jpg', '产品4描述', '产品4内容<p><br/></p>', '', 1, 0, 0, 0, 1393834274, 1393834394),
(102, 3, '产品5', '201403/03/531439bb8223a.jpg', '产品5描述', '<p>产品5内容</p>', '', 1, 0, 0, 0, 1393834284, 1393834427),
(103, 3, '产品6', '201403/03/531439df2dad1.jpg', '产品6描述', '<p>产品6内容<br/></p>', '', 1, 0, 0, 0, 1393834293, 1393834463),
(104, 4, '', '', '', '', '', 1, 0, 0, 0, 1394248167, 1394248167);

-- --------------------------------------------------------

--
-- 表的结构 `ws_route`
--

CREATE TABLE IF NOT EXISTS `ws_route` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `wechat_id` mediumint(8) unsigned NOT NULL COMMENT '微信ID',
  `obj_type` varchar(20) NOT NULL DEFAULT 'news' COMMENT '资源类型',
  `obj_id` varchar(10) NOT NULL COMMENT '资源ID',
  `keyword` varchar(20) NOT NULL COMMENT '唯一标识',
  `ctime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='响应路由表' AUTO_INCREMENT=142 ;

--
-- 转存表中的数据 `ws_route`
--

INSERT INTO `ws_route` (`id`, `wechat_id`, `obj_type`, `obj_id`, `keyword`, `ctime`, `mtime`) VALUES
(37, 10, 'pushNews', '21', '最新动态', 1388374618, 1390210208),
(26, 1, 'pushNews', '18', '珍合婚庆', 1388196151, 1388196151),
(6, 1, 'pushText', '2', '帮助', 1387848532, 1387848532),
(7, 1, 'pushNews', '3', '关于我们', 1387854188, 1393655495),
(9, 1, 'pushNews', '4', '关注', 1387868695, 1387938385),
(10, 1, 'pushNews', '2', '解决方案', 1387878514, 1393643659),
(11, 1, 'pushNews', '7', '案例展示', 1387935448, 1393641634),
(12, 1, 'pushNews', '8', '艾萨瑜伽', 1387935503, 1393643229),
(13, 1, 'pushNews', '9', '童音早教', 1387935621, 1387935621),
(14, 1, 'pushNews', '10', '高新生活网', 1387935931, 1388195476),
(15, 1, 'pushNews', '11', '爱尚窝', 1387936027, 1388195180),
(16, 1, 'pushNews', '12', '高丽数码', 1387936081, 1388195450),
(17, 1, 'pushNews', '13', '世纪情缘', 1387936124, 1388195393),
(18, 1, 'pushNews', '14', '联系我们', 1387936185, 1393656018),
(66, 10, 'pushNews', '49', '相册产品', 1389579889, 1390216849),
(20, 1, 'pushNews', '6', '童音旧版', 0, 1388195362),
(21, 1, 'pushNews', '15', '深蓝解码', 1388026049, 1388195640),
(22, 1, 'pushNews', '16', '在线留言', 1388042998, 1393654067),
(23, 1, 'pushNews', '17', '在线预约', 1388043106, 1393655543),
(24, 1, 'pushText', '4', '你是谁', 1388052344, 1388115219),
(29, 1, 'pushNews', '19', '活力28', 1388216566, 1388216613),
(33, 1, 'pushTool', '3', '翻译', 1388371852, 1388371852),
(31, 1, 'pushTool', '2', '新闻', 1388370206, 1388370206),
(36, 10, 'pushNews', '20', '', 1388374588, 1390627838),
(38, 10, 'pushNews', '22', '新品投票', 1388374655, 1390204398),
(39, 10, 'pushNews', '23', '产品展示', 1388374689, 1388381369),
(40, 10, 'pushNews', '24', '地图导航', 1388374710, 1388457347),
(41, 10, 'pushNews', '25', '一键拨号', 1388374740, 1388394375),
(42, 10, 'pushNews', '26', '价廉物美，后期争宠', 1388380715, 1388380715),
(43, 10, 'pushNews', '27', '高丽至臻相册与传统圣经相册', 1388381081, 1388381081),
(44, 10, 'pushNews', '28', '中式风格', 1388381355, 1389580122),
(45, 10, 'pushNews', '29', '韩式风格', 1388381416, 1389580104),
(46, 10, 'pushNews', '30', '欧式风格', 1388381471, 1389580085),
(47, 10, 'pushNews', '31', '韩式风格', 1388381512, 1389580067),
(48, 10, 'pushNews', '32', '关注', 1388382125, 1388382125),
(49, 11, 'pushNews', '33', '测试1', 1388382568, 1391825793),
(50, 11, 'pushNews', '34', '关注', 1388382593, 1391823084),
(51, 11, 'pushNews', '35', '帮助', 1388382633, 1392018878),
(52, 11, 'pushNews', '36', '联系我们', 1388382650, 1390707698),
(104, 11, 'pushNews', '66', '', 1390984926, 1390984926),
(60, 10, 'pushNews', '44', '精美水晶相册', 1388394880, 1388469023),
(61, 10, 'pushNews', '45', '', 1388394917, 1388469004),
(62, 11, 'pushNews', '46', '', 1388646830, 1390470067),
(67, 10, 'pushNews', '50', '挂摆产品', 1389579979, 1390216871),
(68, 10, 'pushNews', '51', '其他产品', 1389580008, 1390216894),
(69, 10, 'pushNews', '52', '招贤纳士', 1389681768, 1390215743),
(79, 10, 'pushTool', '2', '新闻', 1390180734, 1390180734),
(73, 10, 'pushNews', '56', '快乐课堂', 1389862871, 1390200788),
(74, 10, 'pushNews', '57', '客件查询', 1389863159, 1390199503),
(75, 10, 'pushNews', '58', '服务指南', 1389863211, 1390201527),
(76, 10, 'pushNews', '59', '课程1', 1389863710, 1390372247),
(77, 10, 'pushNews', '60', '课程2', 1389863743, 1389864899),
(97, 10, 'pushNews', '59', '相册产品', 1390470739, 1390470739),
(86, 10, 'pushText', '6', '？', 1390216413, 1390223031),
(88, 10, 'pushNews', '59', '相册产品', 1390372197, 1390372197),
(89, 10, 'pushNews', '60', '挂摆产品', 1390372233, 1390372233),
(90, 10, 'pushNews', '61', '至臻相册', 1390372313, 1390372313),
(94, 11, 'pushNews', '65', '', 1390466991, 1390466991),
(96, 11, 'pushNews', '46', '', 1390470046, 1390470046),
(98, 10, 'pushNews', '60', '挂摆产品', 1390470761, 1390470761),
(99, 10, 'pushNews', '61', '其他产品', 1390470787, 1390470787),
(105, 11, 'pushNews', '67', '测试', 1391740385, 1391740385),
(106, 11, 'pushNews', '68', '测试2', 1391740451, 1391740451),
(107, 11, 'pushNews', '69', '测试3', 1391740492, 1391742191),
(108, 11, 'pushNews', '72', '测试4', 1391742224, 1391742224),
(109, 11, 'pushNews', '73', '测试4', 1391744111, 1391744111),
(110, 11, 'pushNews', '74', '测试4', 1391744421, 1391744421),
(111, 11, 'pushNews', '75', '个个股', 1391744438, 1391744438),
(112, 11, 'pushNews', '76', '测试', 1391745765, 1391745765),
(113, 11, 'pushNews', '77', '默认', 1391755350, 1391755350),
(114, 11, 'pushNews', '78', '解决', 1391762173, 1391762173),
(115, 11, 'pushText', '7', '', 1391763267, 1391763267),
(116, 11, 'pushNews', '79', '关注', 1391824625, 1391824856),
(119, 12, 'pushNews', '82', '栏目1', 1391997885, 1391997885),
(120, 12, 'pushNews', '83', '兰姆2 ', 1391997924, 1391997924),
(121, 12, 'pushNews', '84', '栏目3', 1391997939, 1391997939),
(122, 12, 'pushNews', '85', '栏目4', 1391997954, 1392014674),
(123, 2, 'pushNews', '86', '公司简介', 1392027997, 1392027997),
(124, 2, 'pushNews', '87', '产品展示', 1392028016, 1392028458),
(125, 2, 'pushNews', '88', '在线留言', 1392028037, 1392028037),
(126, 2, 'pushNews', '89', '联系我们', 1392028055, 1392028055),
(127, 2, 'pushNews', '90', '', 1392028383, 1392028539),
(128, 2, 'pushNews', '91', '2222', 1392028399, 1392028476),
(129, 1, 'pushNews', '92', '', 1393643820, 1393643820),
(130, 1, 'pushNews', '93', '', 1393643855, 1393643855),
(131, 3, 'pushNews', '94', '', 1393816367, 1393833967),
(132, 3, 'pushNews', '95', '', 1393816419, 1393833989),
(133, 3, 'pushNews', '96', '', 1393816459, 1393834008),
(134, 3, 'pushNews', '97', '', 1393816487, 1393834024),
(135, 3, 'pushNews', '98', '', 1393834184, 1393834239),
(136, 3, 'pushNews', '99', '', 1393834254, 1393834325),
(137, 3, 'pushNews', '100', '', 1393834264, 1393834360),
(138, 3, 'pushNews', '101', '', 1393834274, 1393834394),
(139, 3, 'pushNews', '102', '', 1393834284, 1393834427),
(140, 3, 'pushNews', '103', '', 1393834293, 1393834463),
(141, 4, 'pushNews', '104', '', 1394248167, 1394248167);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='网站全局参数表' AUTO_INCREMENT=9 ;

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
-- 表的结构 `ws_template`
--

CREATE TABLE IF NOT EXISTS `ws_template` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `name` varchar(20) NOT NULL COMMENT '模板名称',
  `spell` varchar(20) NOT NULL COMMENT '模板拼写',
  `version` float(3,1) NOT NULL DEFAULT '1.0' COMMENT '版本',
  `display_order` mediumint(8) DEFAULT '-1' COMMENT '显示顺序',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `ws_template`
--

INSERT INTO `ws_template` (`id`, `name`, `spell`, `version`, `display_order`, `mtime`) VALUES
(1, '详情页', 'detail', 1.0, 1, 0),
(2, '列表页', 'list', 1.0, 2, 0),
(3, '在线留言', 'leave', 1.0, 4, 0),
(4, '在线预约', 'reserve', 1.0, 5, 0),
(5, '栅格页', 'grid', 1.0, 3, 0),
(8, '联系方式页', 'contact', 1.0, -1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ws_text`
--

CREATE TABLE IF NOT EXISTS `ws_text` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `wechat_id` mediumint(8) unsigned NOT NULL COMMENT '微信ID',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `ctime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文本回复' AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- 表的结构 `ws_theme`
--

CREATE TABLE IF NOT EXISTS `ws_theme` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '主题名称',
  `cover` varchar(100) NOT NULL COMMENT '效果图',
  `intro` varchar(255) NOT NULL COMMENT '描述',
  `author` varchar(50) NOT NULL COMMENT '作者',
  `version` double(3,1) NOT NULL DEFAULT '1.0' COMMENT '版本',
  `date_add` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `date_modify` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ws_theme`
--

INSERT INTO `ws_theme` (`id`, `name`, `cover`, `intro`, `author`, `version`, `date_add`, `date_modify`) VALUES
(1, '默认主题', '201403/14/5322d1cf13619.jpg', '默认主题', 'chen', 1.0, 0, 1394790863);

-- --------------------------------------------------------

--
-- 表的结构 `ws_tool`
--

CREATE TABLE IF NOT EXISTS `ws_tool` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `tool_name` varchar(20) NOT NULL COMMENT '插件名称',
  `description` varchar(255) NOT NULL COMMENT '插件描述',
  `function` varchar(20) NOT NULL COMMENT '处理函数名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '插件启用状态：默认1为可用',
  `display_order` mediumint(8) unsigned NOT NULL COMMENT '显示顺序，1为最前',
  `ctime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='插件详情表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `ws_tool`
--

INSERT INTO `ws_tool` (`id`, `tool_name`, `description`, `function`, `status`, `display_order`, `ctime`, `mtime`) VALUES
(1, '天气查询', '输入“天气”后跟任意城市名称，查询城市天气', 'weather', 0, 1, 0, 0),
(2, '新闻', '输入“新闻”，回复当前新浪头条新闻', 'sinaNews', 1, 0, 0, 0),
(3, '翻译', '输入“翻译”加任意内容，回复翻译后的内容', 'trans', 0, 2, 0, 0),
(4, '英语', '输入“英语”，回复一句随机英语', 'english', 1, 1, 0, 0),
(5, '笑话', '回复“笑话”，回复一则随机笑话', 'joke', 1, 3, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ws_topic`
--

CREATE TABLE IF NOT EXISTS `ws_topic` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `wechat_id` mediumint(8) unsigned NOT NULL COMMENT '微信ID',
  `news_ids` varchar(20) NOT NULL COMMENT '图文ID',
  `news_order` varchar(20) NOT NULL COMMENT '图文排序',
  `top_id` mediumint(8) NOT NULL COMMENT '首图文ID',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ws_topic`
--

INSERT INTO `ws_topic` (`id`, `wechat_id`, `news_ids`, `news_order`, `top_id`, `ctime`, `mtime`) VALUES
(1, 1, '', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ws_topic_news`
--

CREATE TABLE IF NOT EXISTS `ws_topic_news` (
  `id` mediumint(8) unsigned NOT NULL COMMENT '唯一ID',
  `topic_id` mediumint(8) unsigned NOT NULL COMMENT '话题ID',
  `news_id` mediumint(8) unsigned NOT NULL COMMENT '图文ID',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='话题-图文表';

--
-- 转存表中的数据 `ws_topic_news`
--

INSERT INTO `ws_topic_news` (`id`, `topic_id`, `news_id`, `ctime`, `mtime`) VALUES
(0, 1, 1, 0, 0),
(0, 1, 2, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ws_tpl`
--

CREATE TABLE IF NOT EXISTS `ws_tpl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `type` varchar(20) NOT NULL COMMENT '模板类型',
  `texttpl` text NOT NULL COMMENT '模板数据',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='xml模板信息表' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `ws_tpl`
--

INSERT INTO `ws_tpl` (`id`, `type`, `texttpl`) VALUES
(1, 'news', '<item>\r\n<Title><![CDATA[%s]]></Title>\r\n<Description><![CDATA[%s]]></Description>\r\n<PicUrl><![CDATA[%s]]></PicUrl>\r\n<Url><![CDATA[%s]]></Url>\r\n</item>'),
(2, 'text', ' <MsgType><![CDATA[text]]></MsgType>\r\n <Content><![CDATA[%s]]></Content>'),
(3, 'image', '<MsgType><![CDATA[image]]></MsgType>\r\n<Image>\r\n<MediaId><![CDATA[media_id]]></MediaId>\r\n</Image>'),
(4, 'voice', '<MsgType><![CDATA[voice]]></MsgType>\r\n<Voice>\r\n<MediaId><![CDATA[media_id]]></MediaId>\r\n</Voice>'),
(5, 'video', '<MsgType><![CDATA[video]]></MsgType>\r\n<Video>\r\n<MediaId><![CDATA[media_id]]></MediaId>\r\n<ThumbMediaId><![CDATA[thumb_media_id]]></ThumbMediaId>\r\n</Video> '),
(6, 'music', '<MsgType><![CDATA[music]]></MsgType>\r\n<Music>\r\n<Title><![CDATA[TITLE]]></Title>\r\n<Description><![CDATA[DESCRIPTION]]></Description>\r\n<MusicUrl><![CDATA[MUSIC_Url]]></MusicUrl>\r\n<HQMusicUrl><![CDATA[HQ_MUSIC_Url]]></HQMusicUrl>\r\n<ThumbMediaId><![CDATA[media_id]]></ThumbMediaId>'),
(7, 'header', ' <xml>\r\n <ToUserName><![CDATA[%s]]></ToUserName>\r\n <FromUserName><![CDATA[%s]]></FromUserName>\r\n <CreateTime>%s</CreateTime>\r\n %s\r\n </xml>\r\n');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ws_user`
--

INSERT INTO `ws_user` (`id`, `group_id`, `name`, `password`, `mobile`, `avatar`, `key`, `url`, `token`, `appid`, `appsecrect`, `date_reg`, `date_log`, `ip_log`) VALUES
(1, 1, 'chen', 'fe01d67a002dfa0f3ac084298142eccd', '15550005746', '201403/14/5322898c44ae2.jpg', 'chen', '', '', '', '', 0, 0, '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
