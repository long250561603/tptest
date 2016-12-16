-- phpMyAdmin SQL Dump
-- version 4.4.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-12-16 10:33:42
-- 服务器版本： 5.5.28
-- PHP Version: 5.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tp5`
--

-- --------------------------------------------------------

--
-- 表的结构 `it_admin`
--

CREATE TABLE IF NOT EXISTS `it_admin` (
  `id` smallint(5) unsigned NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 启用 0 禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后登录IP',
  `role_id` tinyint(4) NOT NULL COMMENT '角色ID'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员表';

--
-- 转存表中的数据 `it_admin`
--

INSERT INTO `it_admin` (`id`, `username`, `password`, `status`, `create_time`, `last_login_time`, `last_login_ip`, `role_id`) VALUES
(1, 'admin', 'b63ddacba6c3835cc1b250c5d9de6ac1', 1, '2016-10-18 15:28:37', '2016-12-16 09:47:10', '127.0.0.1', 1),
(3, 'test', 'b63ddacba6c3835cc1b250c5d9de6ac1', 1, '2016-11-26 22:10:05', '2016-12-16 09:46:24', '127.0.0.1', 5);

-- --------------------------------------------------------

--
-- 表的结构 `it_attribute`
--

CREATE TABLE IF NOT EXISTS `it_attribute` (
  `attr_id` tinyint(3) unsigned NOT NULL COMMENT '属性主键ID',
  `attr_name` varchar(30) NOT NULL COMMENT '属性名称',
  `type_id` tinyint(3) unsigned NOT NULL COMMENT '商品类型主键ID',
  `attr_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '属性类型 0代表唯一 1代表单选 默认是0',
  `attr_input_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '属性录入方式 0 代表手工 1 代表列表默认是0',
  `attr_values` varchar(150) NOT NULL COMMENT '属性可选值'
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='属性表';

--
-- 转存表中的数据 `it_attribute`
--

INSERT INTO `it_attribute` (`attr_id`, `attr_name`, `type_id`, `attr_type`, `attr_input_type`, `attr_values`) VALUES
(25, '分辨率', 1, 0, 0, ''),
(20, '品牌', 1, 1, 1, '苹果,小米,华为'),
(24, '品牌', 2, 0, 1, '耐克，阿玛尼');

-- --------------------------------------------------------

--
-- 表的结构 `it_auth`
--

CREATE TABLE IF NOT EXISTS `it_auth` (
  `id` mediumint(8) unsigned NOT NULL,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(20) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `pid` smallint(5) unsigned NOT NULL COMMENT '父级ID',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `condition` char(100) DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='规则表';

--
-- 转存表中的数据 `it_auth`
--

INSERT INTO `it_auth` (`id`, `name`, `title`, `type`, `status`, `pid`, `icon`, `sort`, `condition`) VALUES
(1, 'Admin', '用户管理', 1, 1, 0, '', 0, ''),
(2, 'Admin/lst', '用户列表', 1, 1, 1, '', 0, ''),
(4, 'Role', '角色管理', 1, 1, 0, '', 0, ''),
(5, 'Role/lst', '角色列表', 1, 1, 4, '', 0, ''),
(6, 'Role/add', '添加角色', 1, 1, 4, '', 0, ''),
(7, 'Admin/add', '添加用户', 1, 1, 1, '', 0, ''),
(8, 'Auth', '菜单管理', 1, 1, 0, '', 0, ''),
(9, 'Auth/lst', '菜单列表', 1, 1, 8, '', 0, ''),
(10, 'Auth/add', '添加菜单', 1, 1, 8, '', 0, ''),
(11, 'Goods', '商品管理', 1, 1, 0, '', 0, ''),
(12, 'Goods/lst', '商品列表', 1, 1, 11, '', 0, ''),
(13, 'Goods/add', '添加商品', 1, 1, 11, '', 0, ''),
(17, 'Category/lst', '栏目列表', 1, 1, 11, '', 0, ''),
(15, 'Type/add', '添加商品类型', 1, 1, 11, '', 0, ''),
(16, 'Type/lst', '商品类型列表', 1, 1, 11, '', 0, ''),
(18, 'Category/add', '添加栏目', 1, 1, 11, '', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `it_category`
--

CREATE TABLE IF NOT EXISTS `it_category` (
  `cat_id` smallint(5) unsigned NOT NULL COMMENT '商品分类主键ID',
  `cat_name` varchar(30) NOT NULL COMMENT '分类名称',
  `pid` smallint(5) unsigned NOT NULL COMMENT '上级ID，0代表顶级分类'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='商品分类表';

--
-- 转存表中的数据 `it_category`
--

INSERT INTO `it_category` (`cat_id`, `cat_name`, `pid`) VALUES
(1, '苹果手机', 0),
(2, '苹果7', 1);

-- --------------------------------------------------------

--
-- 表的结构 `it_goods`
--

CREATE TABLE IF NOT EXISTS `it_goods` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品主键ID',
  `goods_name` varchar(30) NOT NULL COMMENT '商品名称',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '商品库存',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品本店价格',
  `is_sale` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '商品是否商家 0 代表不上架 1代表上架 默认是1',
  `is_new` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否新品 0代表非新品 1代表新品 默认是1',
  `is_hot` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否热销 0代表非消热1代表热销 默认1',
  `is_best` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否精品 0代表非精品1代表精品 默认是1',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '伪删除 0代表没有删除 1 代表删除默认是0',
  `cat_id` smallint(5) unsigned NOT NULL COMMENT '分类主键ID',
  `type_id` tinyint(3) unsigned NOT NULL COMMENT '商品类型主键ID',
  `goods_img` varchar(150) NOT NULL DEFAULT '' COMMENT '商品图片',
  `goods_thumb` varchar(150) NOT NULL DEFAULT '' COMMENT '商品缩略图',
  `goods_descp` text NOT NULL COMMENT '商品描述',
  `created` varchar(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_code` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启二维码生成 1代表开启 0代表关闭 默认是1',
  `code_url` varchar(150) NOT NULL DEFAULT '' COMMENT '二维码的地址',
  `is_code_show` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '二维码显示与否 1代表显示 0代表不显示'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='商品表';

--
-- 转存表中的数据 `it_goods`
--

INSERT INTO `it_goods` (`goods_id`, `goods_name`, `goods_number`, `goods_price`, `is_sale`, `is_new`, `is_hot`, `is_best`, `is_delete`, `cat_id`, `type_id`, `goods_img`, `goods_thumb`, `goods_descp`, `created`, `is_code`, `code_url`, `is_code_show`) VALUES
(1, '苹果1', 50, '100.00', 1, 1, 1, 1, 0, 1, 1, '/uploads/20161214\\4c472fb81f3c9917fa0cddafa0676204.png', '', '<p>11</p>', '1481687269', 1, '', 1),
(2, '苹果2', 222, '555.00', 1, 1, 1, 1, 0, 1, 1, '/uploads/20161214\\9357c3a46cbe93829bf5a90c597f8a4e.png', '', '<p>111</p>', '1481687803', 1, '', 1),
(3, '苹果2', 22, '55.00', 1, 1, 1, 1, 0, 1, 1, '/uploads/20161214\\3fe0fbf95abdce54469c930bc65a06b1.png', '', '<p>222</p>', '1481687825', 1, '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `it_goods_attribute`
--

CREATE TABLE IF NOT EXISTS `it_goods_attribute` (
  `id` mediumint(8) unsigned NOT NULL COMMENT '商品属性值主键ID',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品主键ID',
  `goods_attr_id` smallint(5) unsigned NOT NULL COMMENT '属性主键ID',
  `goods_attr_value` varchar(150) NOT NULL COMMENT '商品属性值'
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='商品属性值表';

--
-- 转存表中的数据 `it_goods_attribute`
--

INSERT INTO `it_goods_attribute` (`id`, `goods_id`, `goods_attr_id`, `goods_attr_value`) VALUES
(1, 9, 25, '222'),
(2, 9, 20, '小米'),
(3, 9, 20, '苹果'),
(4, 9, 20, '华为'),
(5, 10, 25, '1111'),
(6, 10, 20, '苹果'),
(7, 11, 25, '11111'),
(8, 11, 20, '苹果'),
(9, 1, 25, '1111'),
(10, 1, 20, '苹果'),
(11, 3, 25, '2222'),
(12, 3, 20, '苹果');

-- --------------------------------------------------------

--
-- 表的结构 `it_role`
--

CREATE TABLE IF NOT EXISTS `it_role` (
  `id` mediumint(8) unsigned NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL COMMENT '权限规则ID'
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='权限组表';

--
-- 转存表中的数据 `it_role`
--

INSERT INTO `it_role` (`id`, `title`, `status`, `rules`) VALUES
(1, '超级管理组', 1, '*'),
(5, '测试组', 1, '1,2,7,4,5,6,8,9,10');

-- --------------------------------------------------------

--
-- 表的结构 `it_test`
--

CREATE TABLE IF NOT EXISTS `it_test` (
  `id` int(8) unsigned NOT NULL,
  `nickname` varchar(50) NOT NULL COMMENT '昵称',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `birthday` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '生日',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `it_test`
--

INSERT INTO `it_test` (`id`, `nickname`, `email`, `birthday`, `status`, `create_time`, `update_time`) VALUES
(1, '流年', 'thinkphp@qq.com', 1481524941, 0, 1481524941, 1481524941),
(2, '流年', 'thinkphp@qq.com', 226339200, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `it_type`
--

CREATE TABLE IF NOT EXISTS `it_type` (
  `id` tinyint(3) unsigned NOT NULL COMMENT '商品类型主键',
  `type_name` varchar(30) NOT NULL COMMENT '商品类型名称',
  `markup` varchar(150) NOT NULL DEFAULT '' COMMENT '商品类型备注'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='商品类型表';

--
-- 转存表中的数据 `it_type`
--

INSERT INTO `it_type` (`id`, `type_name`, `markup`) VALUES
(1, '手机商城', '啊就算'),
(2, '服装商城', '服装服装');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `it_admin`
--
ALTER TABLE `it_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- Indexes for table `it_attribute`
--
ALTER TABLE `it_attribute`
  ADD PRIMARY KEY (`attr_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `it_auth`
--
ALTER TABLE `it_auth`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- Indexes for table `it_category`
--
ALTER TABLE `it_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `it_goods`
--
ALTER TABLE `it_goods`
  ADD PRIMARY KEY (`goods_id`),
  ADD KEY `goods_price` (`goods_price`,`is_sale`,`is_new`,`is_hot`,`is_best`,`is_delete`,`cat_id`,`type_id`),
  ADD KEY `created` (`created`),
  ADD KEY `is_code_show` (`is_code_show`);

--
-- Indexes for table `it_goods_attribute`
--
ALTER TABLE `it_goods_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `it_role`
--
ALTER TABLE `it_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `it_test`
--
ALTER TABLE `it_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `it_type`
--
ALTER TABLE `it_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `it_admin`
--
ALTER TABLE `it_admin`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `it_attribute`
--
ALTER TABLE `it_attribute`
  MODIFY `attr_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '属性主键ID',AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `it_auth`
--
ALTER TABLE `it_auth`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `it_category`
--
ALTER TABLE `it_category`
  MODIFY `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品分类主键ID',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `it_goods`
--
ALTER TABLE `it_goods`
  MODIFY `goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品主键ID',AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `it_goods_attribute`
--
ALTER TABLE `it_goods_attribute`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品属性值主键ID',AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `it_role`
--
ALTER TABLE `it_role`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `it_test`
--
ALTER TABLE `it_test`
  MODIFY `id` int(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `it_type`
--
ALTER TABLE `it_type`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类型主键',AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
