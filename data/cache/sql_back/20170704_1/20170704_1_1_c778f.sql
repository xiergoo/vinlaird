
SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `vl_admin`;
CREATE TABLE `vl_admin` (
  `admin_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '管理员名称',
  `admin_password` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '管理员密码',
  `admin_login_time` int(10) NOT NULL DEFAULT '0' COMMENT '登录时间',
  `admin_login_num` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `admin_is_super` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否超级管理员',
  `admin_gid` smallint(6) DEFAULT '0' COMMENT '权限组ID',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk;

DROP TABLE IF EXISTS `vl_admin_log`;
CREATE TABLE `vl_admin_log` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `content` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '操作内容',
  `createtime` int(10) unsigned DEFAULT NULL COMMENT '发生时间',
  `admin_name` char(20) CHARACTER SET utf8 NOT NULL COMMENT '管理员',
  `admin_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `ip` char(15) CHARACTER SET utf8 NOT NULL COMMENT 'IP',
  `url` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'act&op'
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

DROP TABLE IF EXISTS `vl_gadmin`;
CREATE TABLE `vl_gadmin` (
  `gid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '自增id',
  `gname` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '组名',
  `limits` text CHARACTER SET utf8 COMMENT '权限内容'
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

DROP TABLE IF EXISTS `vl_goods`;
CREATE TABLE `vl_goods` (
  `goods_id` smallint(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `goods_name` varchar(30) CHARACTER SET latin1 NOT NULL COMMENT '商品名',
  `goods_imgs` varchar(1000) CHARACTER SET latin1 NOT NULL COMMENT '图片',
  `goods_desc` varchar(5000) CHARACTER SET latin1 NOT NULL COMMENT '描述',
  `goods_buy_price` float(7,2) unsigned NOT NULL COMMENT '成本价',
  `goods_market_price` float(7,2) unsigned NOT NULL COMMENT '市场价',
  `goods_stock` int(10) unsigned NOT NULL COMMENT '库存',
  `stock_warning` smallint(5) unsigned NOT NULL COMMENT '库存预警',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `create_time` int(10) unsigned NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品';

DROP TABLE IF EXISTS `vl_lock`;
CREATE TABLE `vl_lock` (
  `pid` bigint(20) unsigned NOT NULL COMMENT 'IP+TYPE',
  `pvalue` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '次数',
  `expiretime` int(11) NOT NULL DEFAULT '0' COMMENT '锁定截止时间'
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

DROP TABLE IF EXISTS `vl_mail_msg_temlates`;
CREATE TABLE `vl_mail_msg_temlates` (
  `name` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '模板名称',
  `title` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '模板标题',
  `code` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '模板调用代码',
  `content` text CHARACTER SET utf8 NOT NULL COMMENT '模板内容'
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

DROP TABLE IF EXISTS `vl_member_msg_tpl`;
CREATE TABLE `vl_member_msg_tpl` (
  `mmt_code` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '用户消息模板编号',
  `mmt_name` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '模板名称',
  `mmt_message_switch` tinyint(3) unsigned NOT NULL COMMENT '站内信接收开关',
  `mmt_message_content` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '站内信消息内容',
  `mmt_short_switch` tinyint(3) unsigned NOT NULL COMMENT '短信接收开关',
  `mmt_short_content` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '短信接收内容',
  `mmt_mail_switch` tinyint(3) unsigned NOT NULL COMMENT '邮件接收开关',
  `mmt_mail_subject` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '邮件标题',
  `mmt_mail_content` text CHARACTER SET utf8 NOT NULL COMMENT '邮件内容'
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

DROP TABLE IF EXISTS `vl_order`;
CREATE TABLE `vl_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `saler_id` smallint(5) unsigned NOT NULL COMMENT '销售商ID',
  `goods_id` smallint(5) unsigned NOT NULL COMMENT '商品ID',
  `order_sn` varchar(20) CHARACTER SET latin1 DEFAULT NULL COMMENT '订单号',
  `goods_num` smallint(5) unsigned NOT NULL COMMENT '商品数量',
  `goods_price` float(7,2) unsigned NOT NULL COMMENT '商品单价',
  `goods_amount` float(9,2) unsigned NOT NULL COMMENT '订单总价',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态。0-待付款，1-平台准备中（已付款），2-已取消，3-已投递，可以查看物流，4-已收货，5-退款中，6-已退款',
  `create_time` int(10) unsigned NOT NULL COMMENT '下单时间',
  `receive_name` varchar(10) CHARACTER SET latin1 NOT NULL COMMENT '收货人姓名',
  `receive_mobile` char(11) CHARACTER SET latin1 NOT NULL COMMENT '收货人手机',
  `receive_address` varchar(150) CHARACTER SET latin1 NOT NULL COMMENT '收货人地址',
  `deliver_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '物流公司',
  `deliver_code` varchar(30) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '物流单号',
  `deliver_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  PRIMARY KEY (`order_id`),
  KEY `i_saler_id` (`saler_id`),
  KEY `i_goods_id` (`goods_id`),
  KEY `i_order_sn` (`order_sn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单';

DROP TABLE IF EXISTS `vl_saler`;
CREATE TABLE `vl_saler` (
  `saler_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '销售商id',
  `saler_name` varchar(30) CHARACTER SET latin1 NOT NULL COMMENT '销售商用户名',
  `saler_password` char(32) CHARACTER SET latin1 NOT NULL COMMENT '密码',
  `saler_salt` char(4) CHARACTER SET latin1 NOT NULL COMMENT '盐',
  `saler_realname` varchar(20) CHARACTER SET latin1 NOT NULL COMMENT '真实名称',
  `saler_level` tinyint(1) unsigned NOT NULL COMMENT '销售商等级',
  `role_id` smallint(5) unsigned NOT NULL COMMENT '角色id',
  `store_id` int(10) unsigned NOT NULL COMMENT '店铺id',
  `is_owner` tinyint(1) unsigned NOT NULL COMMENT '是否是店铺所有者',
  `cash_pledge` float(6,0) unsigned NOT NULL COMMENT '押金金额',
  `cash_status` tinyint(1) unsigned NOT NULL COMMENT '押金状态，0-未缴，1-已缴，2-已退',
  `refund_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '退款时间',
  `refund_admin_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '退款操作人',
  `create_admin_id` smallint(5) unsigned NOT NULL COMMENT '创建人',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`saler_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='销售商';

DROP TABLE IF EXISTS `vl_saler_order`;
CREATE TABLE `vl_saler_order` (
  `so_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `saler_id` int(10) unsigned NOT NULL COMMENT '销售商id',
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `goods_num` int(10) unsigned NOT NULL COMMENT '数量',
  `so_amount` float(9,2) unsigned NOT NULL COMMENT '总价',
  `create_time` int(10) unsigned NOT NULL COMMENT '时间',
  PRIMARY KEY (`so_id`),
  KEY `i_saler_id` (`saler_id`),
  KEY `i_goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='销售商订货';

DROP TABLE IF EXISTS `vl_saler_return`;
CREATE TABLE `vl_saler_return` (
  `sr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `saler_id` int(10) unsigned NOT NULL COMMENT '销售商id',
  `sr_month` char(6) DEFAULT NULL COMMENT '返现年月。如：201707',
  `sr_amount` float(9,2) DEFAULT NULL COMMENT '返现金额',
  `sr_status` tinyint(4) DEFAULT NULL COMMENT '返现状态。0-未返，1-已返',
  `sr_time` int(11) DEFAULT NULL COMMENT '返现时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`sr_id`),
  KEY `i_saler_id` (`saler_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='销售商返现';

DROP TABLE IF EXISTS `vl_saler_stock`;
CREATE TABLE `vl_saler_stock` (
  `stock_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `saler_id` smallint(5) unsigned NOT NULL,
  `goods_id` smallint(5) unsigned NOT NULL,
  `stock` smallint(5) unsigned NOT NULL,
  `saled_count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`stock_id`),
  UNIQUE KEY `u_saler_goods_id` (`saler_id`,`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='销售商库存';

DROP TABLE IF EXISTS `vl_setting`;
CREATE TABLE `vl_setting` (
  `name` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '名称',
  `value` text CHARACTER SET utf8 COMMENT '值'
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

