
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

DROP TABLE IF EXISTS `vl_setting`;
CREATE TABLE `vl_setting` (
  `name` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '名称',
  `value` text CHARACTER SET utf8 COMMENT '值'
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

