/*
SQLyog v10.2
MySQL - 5.0.21 : Database - ccc
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ccc` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ccc`;

/*Table structure for table `admin_apps` */

DROP TABLE IF EXISTS `admin_apps`;

CREATE TABLE `admin_apps` (
  `app_id` int(11) NOT NULL auto_increment COMMENT '应用编号',
  `app_name` varchar(40) NOT NULL default '''''' COMMENT '应用名称',
  `app_string` varchar(20) NOT NULL default '''''' COMMENT '应用字符串',
  `comments` text NOT NULL COMMENT '描述',
  `sort` smallint(4) NOT NULL default '20' COMMENT '排序',
  `status` tinyint(1) NOT NULL default '2' COMMENT '状态[1-激活2-未激活]',
  `is_delete` tinyint(1) NOT NULL default '2' COMMENT '删除[1-是2-否]',
  PRIMARY KEY  (`app_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='应用表';

/*Data for the table `admin_apps` */

insert  into `admin_apps`(`app_id`,`app_name`,`app_string`,`comments`,`sort`,`status`,`is_delete`) values (1,'系统','cccnew','',21,1,2),(2,'办公OA','oa','',20,1,2),(3,'进销存ERP','erp','',20,1,2);

/*Table structure for table `admin_company_group` */

DROP TABLE IF EXISTS `admin_company_group`;

CREATE TABLE `admin_company_group` (
  `company_group_id` int(11) NOT NULL auto_increment COMMENT '映射编号',
  `company_id` int(11) NOT NULL default '0' COMMENT '公司编号',
  `group_id` int(11) NOT NULL default '0' COMMENT '组别编号',
  PRIMARY KEY  (`company_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司组映射表';

/*Data for the table `admin_company_group` */

/*Table structure for table `admin_company_user` */

DROP TABLE IF EXISTS `admin_company_user`;

CREATE TABLE `admin_company_user` (
  `company_user_id` int(11) NOT NULL auto_increment COMMENT '映射编号',
  `company_id` int(11) NOT NULL default '0' COMMENT '公司编号',
  `user_id` int(11) NOT NULL default '0' COMMENT '用户编号',
  PRIMARY KEY  (`company_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司用户映射表';

/*Data for the table `admin_company_user` */

/*Table structure for table `admin_companys` */

DROP TABLE IF EXISTS `admin_companys`;

CREATE TABLE `admin_companys` (
  `company_id` int(11) NOT NULL auto_increment COMMENT '公司编号',
  `short_name` varchar(20) NOT NULL default '' COMMENT '公司简称',
  `full_name` varchar(64) NOT NULL default '' COMMENT '公司全称',
  `website` varchar(255) default '' COMMENT '网址',
  `comments` text NOT NULL COMMENT '公司描述',
  `is_delete` tinyint(1) NOT NULL default '2' COMMENT '删除[1-是2-否]',
  PRIMARY KEY  (`company_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司表';

/*Data for the table `admin_companys` */

/*Table structure for table `admin_condition_info` */

DROP TABLE IF EXISTS `admin_condition_info`;

CREATE TABLE `admin_condition_info` (
  `condition_id` int(11) NOT NULL auto_increment COMMENT '条件ID',
  `depart_id` int(11) NOT NULL default '0' COMMENT '部门',
  `group_id` int(11) NOT NULL default '0' COMMENT '组别',
  `flow_id` int(11) NOT NULL default '0' COMMENT '流程表',
  `node_id` int(11) NOT NULL default '0' COMMENT '节点ID',
  `condition_class_name` varchar(50) NOT NULL default '' COMMENT '条件类名',
  `condition_action_name` varchar(50) NOT NULL default '' COMMENT '条件方法',
  PRIMARY KEY  (`condition_id`),
  KEY `index_1` (`depart_id`,`group_id`,`flow_id`,`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='条件流表';

/*Data for the table `admin_condition_info` */

/*Table structure for table `admin_flow_deal_data` */

DROP TABLE IF EXISTS `admin_flow_deal_data`;

CREATE TABLE `admin_flow_deal_data` (
  `flow_deal_data_id` int(11) NOT NULL auto_increment COMMENT '流程处理明细ID',
  `flow_id` int(11) NOT NULL default '0' COMMENT '流程表',
  `node_id` int(11) NOT NULL default '0' COMMENT '节点ID',
  `data_id` int(11) NOT NULL default '0' COMMENT '数据ID',
  `resource_id` int(11) NOT NULL default '0' COMMENT '模块/动作ID',
  `operate_user_id` int(11) NOT NULL default '0' COMMENT '操作人ID',
  `operate_result` tinyint(1) NOT NULL default '0' COMMENT '操作结果[1-通过2-不通过]',
  `operate_comments` text COMMENT '操作记录',
  `operate_time_int` int(11) NOT NULL default '0' COMMENT '操作时间',
  PRIMARY KEY  (`flow_deal_data_id`),
  KEY `index_1` (`flow_id`,`node_id`,`data_id`,`resource_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='流程处理明细表';

/*Data for the table `admin_flow_deal_data` */

/*Table structure for table `admin_flow_info` */

DROP TABLE IF EXISTS `admin_flow_info`;

CREATE TABLE `admin_flow_info` (
  `flow_id` int(11) NOT NULL auto_increment COMMENT '流程表',
  `depart_id` int(11) NOT NULL default '0' COMMENT '部门',
  `group_id` int(11) NOT NULL default '0' COMMENT '组别',
  `flow_name` varchar(20) NOT NULL default '' COMMENT '流程名称',
  `resource_id` int(11) NOT NULL default '0' COMMENT '模块/动作ID',
  `comments` text COMMENT '备注',
  `add_user_id` int(11) NOT NULL default '0' COMMENT '添加人ID',
  `add_user_name` varchar(64) NOT NULL default '' COMMENT '添加人名称',
  `add_time_int` int(11) NOT NULL default '0' COMMENT '添加时间',
  PRIMARY KEY  (`flow_id`),
  KEY `index_1` (`depart_id`,`group_id`,`resource_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='流程表';

/*Data for the table `admin_flow_info` */

/*Table structure for table `admin_group_role` */

DROP TABLE IF EXISTS `admin_group_role`;

CREATE TABLE `admin_group_role` (
  `group_role_id` int(11) NOT NULL auto_increment COMMENT '映射编号',
  `group_id` int(11) NOT NULL default '0' COMMENT '组别编号',
  `role_id` int(11) NOT NULL default '0' COMMENT '角色编号',
  PRIMARY KEY  (`group_role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='组角色表';

/*Data for the table `admin_group_role` */

/*Table structure for table `admin_groups` */

DROP TABLE IF EXISTS `admin_groups`;

CREATE TABLE `admin_groups` (
  `group_id` int(11) NOT NULL auto_increment COMMENT '组别编号',
  `parent_id` int(11) NOT NULL default '0' COMMENT '父类编号',
  `group_name` varchar(40) NOT NULL COMMENT '组别名称',
  `comments` int(11) NOT NULL COMMENT '描述',
  `is_delete` tinyint(1) NOT NULL default '2' COMMENT '删除[1-是2-否]',
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='组表';

/*Data for the table `admin_groups` */

/*Table structure for table `admin_logs` */

DROP TABLE IF EXISTS `admin_logs`;

CREATE TABLE `admin_logs` (
  `log_id` int(11) NOT NULL auto_increment COMMENT '日志编号',
  `app_string` varchar(30) NOT NULL default '’‘' COMMENT '应用字符串',
  `module_string` varchar(30) NOT NULL default '’‘' COMMENT '控制器字符串',
  `action_string` varchar(30) NOT NULL default '’‘' COMMENT '动作字符串',
  `operate_user_id` int(11) NOT NULL default '0' COMMENT '操作人编号',
  `operate_user_name` int(30) NOT NULL COMMENT '操作人用户名',
  `user_id` int(11) NOT NULL default '0' COMMENT '普通用户编号',
  `user_name` int(30) NOT NULL COMMENT '普通用户名',
  `title` varchar(100) NOT NULL COMMENT '简短描述',
  `comments` text NOT NULL COMMENT '描述',
  `add_time_int` int(11) NOT NULL default '0' COMMENT '添加时间',
  `is_delete` tinyint(1) NOT NULL default '2' COMMENT '删除[1-是2-否]',
  PRIMARY KEY  (`log_id`),
  KEY `index_1` (`log_id`,`app_string`,`module_string`,`action_string`,`is_delete`),
  KEY `index_2` (`log_id`,`is_delete`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表';

/*Data for the table `admin_logs` */

/*Table structure for table `admin_node_info` */

DROP TABLE IF EXISTS `admin_node_info`;

CREATE TABLE `admin_node_info` (
  `node_id` int(11) NOT NULL auto_increment COMMENT '节点ID',
  `flow_id` int(11) default NULL COMMENT '流程表',
  `node_name` varchar(50) default NULL COMMENT '节点名称',
  `comments` text COMMENT '描述',
  `node_no` tinyint(4) default NULL COMMENT '步数[排序]',
  `flow_status` tinyint(1) default NULL COMMENT '流程状态[1-开始2-结束3-进行中]',
  PRIMARY KEY  (`node_id`),
  KEY `index_1` (`flow_id`,`node_no`,`flow_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='流程节点表';

/*Data for the table `admin_node_info` */

/*Table structure for table `admin_node_role` */

DROP TABLE IF EXISTS `admin_node_role`;

CREATE TABLE `admin_node_role` (
  `node_role_id` int(11) NOT NULL auto_increment COMMENT '节点权限ID',
  `flow_id` int(11) default NULL COMMENT '流程表',
  `node_id` int(11) default NULL COMMENT '节点ID',
  `role_id` int(11) default NULL COMMENT '角色ID',
  `approval_ids` varchar(255) default NULL COMMENT '审批人ID（如果不填则默认取角色中的用户ID，可以选多个以|隔开）',
  PRIMARY KEY  (`node_role_id`),
  KEY `index_1` (`flow_id`,`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='节点权限表';

/*Data for the table `admin_node_role` */

/*Table structure for table `admin_resources` */

DROP TABLE IF EXISTS `admin_resources`;

CREATE TABLE `admin_resources` (
  `resource_id` int(11) NOT NULL auto_increment COMMENT '应用模块动作挂接编号',
  `app_id` int(11) NOT NULL default '0' COMMENT '应用挂接编号',
  `app_string` char(64) NOT NULL default '' COMMENT '应用挂接字符串',
  `module_id` int(11) NOT NULL default '0' COMMENT '模块挂接编号',
  `module_string` char(64) NOT NULL default '' COMMENT '模块挂接字符串',
  `module_sort` int(11) NOT NULL default '20' COMMENT '模块排序',
  `action_string` char(64) NOT NULL default '' COMMENT '动作挂接字符串',
  `name` char(64) NOT NULL default '' COMMENT '名称',
  `sort` int(11) NOT NULL default '20' COMMENT '排序',
  `url` varchar(255) NOT NULL default '' COMMENT 'url',
  `is_right_data` tinyint(1) NOT NULL default '2' COMMENT '是否开启数据权限（1=开启2=不开）',
  `right_class_name` varchar(100) NOT NULL default '' COMMENT '类名',
  `right_action_name` varchar(100) NOT NULL default '' COMMENT 'action名',
  `add_time` int(11) NOT NULL default '0' COMMENT '添加时间',
  `user_id` int(11) NOT NULL default '0' COMMENT '创建人id',
  `user_name` varchar(64) NOT NULL default '' COMMENT '创建人名称',
  `comment` text COMMENT '描述',
  `is_view` tinyint(1) NOT NULL default '2' COMMENT '是否可见（默认：2 可见：1）',
  `is_update` tinyint(1) NOT NULL default '2' COMMENT '是否可修改（默认：2 修改：1）',
  `is_log` tinyint(1) NOT NULL default '2' COMMENT '是否日志（默认：2 日志：1）',
  `is_remove` tinyint(1) NOT NULL default '2' COMMENT '是否可删除(默认：2 删除：1)',
  `is_delete` tinyint(1) NOT NULL default '2' COMMENT '状态[1-删除2-非删除]',
  PRIMARY KEY  (`resource_id`),
  KEY `index2` (`app_id`,`is_view`,`module_sort`),
  KEY `index3` (`is_view`,`sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='应用模块动作映射表';

/*Data for the table `admin_resources` */

insert  into `admin_resources`(`resource_id`,`app_id`,`app_string`,`module_id`,`module_string`,`module_sort`,`action_string`,`name`,`sort`,`url`,`is_right_data`,`right_class_name`,`right_action_name`,`add_time`,`user_id`,`user_name`,`comment`,`is_view`,`is_update`,`is_log`,`is_remove`,`is_delete`) values (1,0,'cccnew',0,'my',1,'','个人主页',0,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(2,0,'cccnew',1,'my',1,'list.all.user','成人简介',1,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(3,0,'cccnew',1,'my',1,'edit.user.info','修改资料',2,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(4,0,'cccnew',1,'my',1,'edit.user.pass','修改密码',3,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(5,1,'cccnew',0,'',2,'','公司管理',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(6,1,'cccnew',5,'company',2,'ajax.add.company','公司管理添加公司',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(7,1,'cccnew',5,'company',2,'ajax.all.company','公司管理ajax公司列表',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(8,1,'cccnew',5,'company',2,'ajax.company.group.data','公司管理公司部门列表',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(9,1,'cccnew',5,'company',2,'ajax.delete.company','公司管理删除公司',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(10,1,'cccnew',5,'company',2,'ajax.delete.company.group','公司管理删除公司部门',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(11,1,'cccnew',5,'company',2,'ajax.detail.company','公司管理查看某公司信息',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(12,1,'cccnew',5,'company',2,'ajax.save.company.data','公司管理保存公司',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(13,1,'cccnew',5,'company',2,'list','公司管理公司列表',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(14,1,'cccnew',0,'group',3,'','部门管理',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(15,1,'cccnew',14,'group',3,'ajax.all.group','部门管理ajax部门列表',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(16,1,'cccnew',14,'group',3,'ajax.delete.group','部门管理删除部门',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(17,1,'cccnew',14,'group',3,'ajax.detail.group','部门管理查看某部门信息',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(18,1,'cccnew',14,'group',3,'ajax.save.group.data','部门管理保存部门',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(19,1,'cccnew',14,'group',3,'list','部门管理部门列表',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(20,1,'cccnew',0,'resource',4,'','资源管理',0,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(21,1,'cccnew',20,'resource',4,'add.action','资源管理添加资源',2,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(22,1,'cccnew',20,'resource',4,'add.action.ok','资源管理添加资源操作',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(23,1,'cccnew',20,'resource',4,'add.app','资源管理添加应用',1,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(24,1,'cccnew',20,'resource',4,'add.app.ok','资源管理添加应用操作',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(25,1,'cccnew',20,'resource',4,'ajax.show.action.sort','资源管理显示动作排序',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(26,1,'cccnew',20,'resource',4,'ajax.show.module.data','资源管理显示模块数据',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(27,1,'cccnew',20,'resource',4,'ajax.sort.action.data','资源管理排序动作数据',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(28,1,'cccnew',20,'resource',4,'ajax.update.app.status','资源管理更新应用状态',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(29,1,'cccnew',20,'resource',4,'delete.action','资源管理删除动作',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(30,1,'cccnew',20,'resource',4,'delete.app','资源管理删除应用',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(31,1,'cccnew',20,'resource',4,'edit.action','资源管理编辑动作',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(32,1,'cccnew',20,'resource',4,'edit.action.ok','资源管理编辑动作操作',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(33,1,'cccnew',20,'resource',4,'edit.app','资源管理编辑应用',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(34,1,'cccnew',20,'resource',4,'edit.app.ok','资源管理编辑应用操作',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(35,1,'cccnew',20,'resource',4,'list.action','资源管理资源列表',4,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(36,1,'cccnew',20,'resource',4,'list.app','资源管理应用列表',3,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(37,1,'cccnew',20,'resource',4,'view.action','资源管理查看资源',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(38,1,'cccnew',20,'resource',4,'view.app','资源管理查看应用',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(39,1,'cccnew',0,'right',5,'','权限管理',0,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(40,1,'cccnew',39,'right',5,'ajax.get.action.data','权限管理获取动作数据',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(41,1,'cccnew',39,'right',5,'ajax.get.module.data','权限管理获取模块数据',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(42,1,'cccnew',39,'right',5,'ajax.save.role.right','权限管理保存角色权限',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(43,1,'cccnew',39,'right',5,'ajax.show.role.right','权限管理显示角色权限',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(44,1,'cccnew',39,'right',5,'list.company','权限管理公司管理',1,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(45,1,'cccnew',39,'right',5,'list.group','权限管理部门管理',2,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(46,1,'cccnew',39,'right',5,'list.role','权限管理角色管理',3,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(47,1,'cccnew',39,'right',5,'list.role.right','权限管理角色权限管理',5,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(48,1,'cccnew',39,'right',5,'list.user','权限管理用户管理',4,'',0,'','',1381299454,1,'admin','',1,1,1,1,2),(49,1,'cccnew',0,'role',6,'','角色管理',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(50,1,'cccnew',49,'role',6,'ajax.add.role','角色管理添加角色',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(51,1,'cccnew',49,'role',6,'ajax.all.role','角色管理ajax角色列表',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(52,1,'cccnew',49,'role',6,'ajax.delete.role','角色管理删除角色',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(53,1,'cccnew',49,'role',6,'ajax.detail.role','角色管理查看某角色',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(54,1,'cccnew',49,'role',6,'ajax.save.role.data','角色管理保存角色',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(55,1,'cccnew',49,'role',6,'list','角色管理角色列表',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(56,1,'cccnew',0,'user',7,'','用户管理',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(57,1,'cccnew',56,'user',7,'ajax.add.user.group','用户管理添加用户组',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(58,1,'cccnew',56,'user',7,'ajax.delete.user.group','用户管理删除用户组',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(59,1,'cccnew',56,'user',7,'ajax.save.user.role','用户管理保存用户角色',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(60,1,'cccnew',56,'user',7,'ajax.update.user.pass','用户管理更新用户密码',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(61,1,'cccnew',56,'user',7,'ajax.update.user.status','用户管理更新用户状态',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(62,1,'cccnew',56,'user',7,'ajax.upload.userphoto','用户管理更新用户图像',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(63,1,'cccnew',56,'user',7,'delete','用户管理删除用户',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(64,1,'cccnew',56,'user',7,'edit','用户管理编辑用户',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(65,1,'cccnew',56,'user',7,'edit.ok','用户管理编辑用户操作',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(66,1,'cccnew',56,'user',7,'list.user.group','用户管理用户组列表',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(67,1,'cccnew',56,'user',7,'list.user.role','用户管理用户角色列表',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(68,1,'cccnew',56,'user',7,'show.user.pass','用户管理弹出用户密码框',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(69,1,'cccnew',56,'user',7,'show.user.status','用户管理弹出用户状态框',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(70,1,'cccnew',56,'user',7,'update.super','用户管理更新系统管理',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(71,1,'cccnew',56,'user',7,'view','用户管理查看用户',0,'',0,'','',1381299454,1,'admin','',0,1,1,1,2),(72,3,'erp',0,'stockplan',1,'','采购计划管理',0,'',0,'','',1381299481,1,'admin','',1,1,1,1,2),(73,3,'erp',72,'stockplan',1,'add','采购计划添加',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(74,3,'erp',72,'stockplan',1,'delete','采购计划删除',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(75,3,'erp',72,'stockplan',1,'edit.brand','采购计划型号修改',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(76,3,'erp',72,'stockplan',1,'edit.codes','采购计划代码修改',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(77,3,'erp',72,'stockplan',1,'edit.product.name','采购计划品名修改',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(78,3,'erp',72,'stockplan',1,'edit.send.date','采购计划发货日期修改',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(79,3,'erp',72,'stockplan',1,'edit.stock.count','采购计划数量修改',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(80,3,'erp',72,'stockplan',1,'edit.stock.name','采购计划采购名称修改',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(81,3,'erp',72,'stockplan',1,'edit.supplier.name','采购计划供应商修改',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(82,3,'erp',72,'stockplan',1,'edit.uit.price','采购计划单价修改',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(83,3,'erp',72,'stockplan',1,'excel','采购计划导出',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(84,3,'erp',72,'stockplan',1,'list','采购计划列表',1,'',0,'','',1381299481,1,'admin','',1,1,1,1,2),(85,3,'erp',0,'material',2,'','原材料管理',0,'',0,'','',1381299481,1,'admin','',1,1,1,1,2),(86,3,'erp',85,'material',2,'add','原材料添加',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(87,3,'erp',85,'material',2,'add.sn','原材料sn添加',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(88,3,'erp',85,'material',2,'edit.sn.number','原材料sn修改',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(89,3,'erp',85,'material',2,'import.sn','原材料sn导入',0,'',0,'','',1381299481,1,'admin','',0,1,1,1,2),(90,3,'erp',85,'material',2,'list','原材料列表',1,'',0,'','',1381299481,1,'admin','',1,1,1,1,2),(91,3,'erp',0,'salestat',3,'','销售支撑',0,'',0,'','',1381299481,1,'admin','',1,1,0,1,2),(92,3,'erp',91,'salestat',3,'ajax.saleroom.by.indutry','销售支撑按行业统计',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(93,3,'erp',91,'salestat',3,'ajax.saleroom.by.month','销售支撑按月统计',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(94,3,'erp',91,'salestat',3,'ajax.saleroom.by.project','销售支撑按项目统计',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(95,3,'erp',91,'salestat',3,'indutry.saleroom','销售支撑行业统计',1,'',0,'','',1381299481,1,'admin','',1,1,1,1,2),(96,3,'erp',0,'logistics',4,'','物流管理',0,'',0,'','',1381299481,1,'admin','',1,1,0,1,2),(97,3,'erp',96,'logistics',4,'add.send.good','物流管理添加发货',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(98,3,'erp',96,'logistics',4,'add.send.good.ok','物流管理添加发货操作',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(99,3,'erp',96,'logistics',4,'ajax.get.data.by.bargainnumber','物流管理通过合同编号显示',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(100,3,'erp',96,'logistics',4,'delete','物流管理删除',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(101,3,'erp',96,'logistics',4,'edit.arrival.time','物流管理编辑到货日期',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(102,3,'erp',96,'logistics',4,'edit.bargain.id','物流管理编辑合同编号',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(103,3,'erp',96,'logistics',4,'edit.category','物流管理编辑类别',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(104,3,'erp',96,'logistics',4,'edit.company','物流管理编辑公司',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(105,3,'erp',96,'logistics',4,'edit.content.sn','物流管理编辑contentsn',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(106,3,'erp',96,'logistics',4,'edit.delivery.time','物流管理编辑发货日期',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(107,3,'erp',96,'logistics',4,'edit.examine.time','物流管理编辑验货日期',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(108,3,'erp',96,'logistics',4,'edit.logistics.num','物流管理编辑物流单号',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(109,3,'erp',96,'logistics',4,'edit.mobile','物流管理编辑手机',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(110,3,'erp',96,'logistics',4,'edit.order.type','物流管理编辑订单类型',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(111,3,'erp',96,'logistics',4,'edit.phone','物流管理编辑电话',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(112,3,'erp',96,'logistics',4,'edit.product.model','物流管理编辑产品型号',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(113,3,'erp',96,'logistics',4,'edit.product.num','物流管理编辑产品数量',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(114,3,'erp',96,'logistics',4,'edit.received.address','物流管理编辑收货地址',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(115,3,'erp',96,'logistics',4,'edit.received.company','物流管理编辑收货公司',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(116,3,'erp',96,'logistics',4,'edit.received.people','物流管理编辑收货人',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(117,3,'erp',96,'logistics',4,'edit.remarks','物流管理编辑备注',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(118,3,'erp',96,'logistics',4,'edit.status','物流管理编辑状态',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(119,3,'erp',96,'logistics',4,'edit.zipcode','物流管理编辑邮编',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(120,3,'erp',96,'logistics',4,'list','物流管理列表',1,'',0,'','',1381299481,1,'admin','',1,1,0,1,2),(121,3,'erp',96,'logistics',4,'new.add','物流管理新建',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(122,3,'erp',96,'logistics',4,'new.add.ok','物流管理新建操作',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(123,3,'erp',96,'logistics',4,'show.add.sn','物流管理添加发货sn展示',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2),(124,3,'erp',96,'logistics',4,'show.sn','物流管理列表sn展示',0,'',0,'','',1381299481,1,'admin','',0,1,0,1,2);

/*Table structure for table `admin_role_right` */

DROP TABLE IF EXISTS `admin_role_right`;

CREATE TABLE `admin_role_right` (
  `role_right_id` int(11) NOT NULL auto_increment COMMENT '映射编号',
  `role_id` int(11) NOT NULL default '0' COMMENT '角色编号',
  `resource_id` int(11) NOT NULL default '0' COMMENT '资源编号',
  `app_id` int(11) NOT NULL default '0' COMMENT '应用编号',
  `app_string` varchar(20) NOT NULL default '' COMMENT '应用字符串',
  `module_id` int(11) NOT NULL default '0' COMMENT '模块编号',
  `module_string` varchar(64) NOT NULL default '' COMMENT '模块字符串',
  `action_string` varchar(64) NOT NULL default '' COMMENT '动作字符串',
  PRIMARY KEY  (`role_right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色权限表';

/*Data for the table `admin_role_right` */

/*Table structure for table `admin_roles` */

DROP TABLE IF EXISTS `admin_roles`;

CREATE TABLE `admin_roles` (
  `role_id` int(11) NOT NULL auto_increment COMMENT '角色编号',
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  `comments` text NOT NULL COMMENT '角色描述',
  `status` tinyint(1) NOT NULL default '1' COMMENT '状态[1-激活2-未激活]',
  `is_delete` tinyint(1) NOT NULL default '2' COMMENT '删除[1-是2-否]',
  PRIMARY KEY  (`role_id`),
  KEY `index1` (`role_id`,`role_name`,`is_delete`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色表';

/*Data for the table `admin_roles` */

insert  into `admin_roles`(`role_id`,`role_name`,`comments`,`status`,`is_delete`) values (1,'物流管理查看角色','物流管理-查看',1,2),(2,'物流管理生产角色','物流管理-生产',1,2);

/*Table structure for table `admin_supper_user` */

DROP TABLE IF EXISTS `admin_supper_user`;

CREATE TABLE `admin_supper_user` (
  `supper_user_id` int(11) NOT NULL auto_increment COMMENT '超级管理编号',
  `user_id` int(11) NOT NULL default '0' COMMENT '用户编号',
  PRIMARY KEY  (`supper_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='超级用户表';

/*Data for the table `admin_supper_user` */

insert  into `admin_supper_user`(`supper_user_id`,`user_id`) values (1,1);

/*Table structure for table `admin_user_company` */

DROP TABLE IF EXISTS `admin_user_company`;

CREATE TABLE `admin_user_company` (
  `user_company_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0' COMMENT '用户编号',
  `user_type` tinyint(1) NOT NULL default '0' COMMENT '人员类别(0-员工1-本所学生2-客座学生3-实习生4-兼职生)',
  `job_status` tinyint(1) NOT NULL default '0' COMMENT '在职状态(0-正式员工1-离职员工2-实习生3-学生4-兼职生)',
  `entry_date` date NOT NULL COMMENT '入职日期',
  `positive_date` date NOT NULL COMMENT '转正日期',
  `separation_date` date NOT NULL COMMENT '离职日期',
  `separation_reason` varchar(255) NOT NULL COMMENT '离职原因',
  `contract_num` tinyint(3) default '0' COMMENT '劳动合同续签次数',
  `contract_date` date NOT NULL COMMENT '劳动合同续签日期',
  `post` char(30) NOT NULL COMMENT '岗位',
  `post_level` tinyint(3) NOT NULL COMMENT '岗位级别',
  `job_location` char(30) NOT NULL COMMENT '工作所在地',
  `position` char(20) NOT NULL COMMENT '职务',
  `job_source` tinyint(1) NOT NULL default '0' COMMENT '招聘来源(0-其他1-社招2-校招)',
  `human_relations` tinyint(1) NOT NULL default '0' COMMENT '人事关系(0-其他1-公司（蓝鲸分公司）2-公司（蓝鲸）3-学生（硕士/博士）4-计算所)',
  `station_number` char(30) NOT NULL COMMENT '工位号',
  `office_phone` varchar(50) NOT NULL COMMENT '办公电话',
  PRIMARY KEY  (`user_company_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户所在公司信息表';

/*Data for the table `admin_user_company` */

insert  into `admin_user_company`(`user_company_id`,`user_id`,`user_type`,`job_status`,`entry_date`,`positive_date`,`separation_date`,`separation_reason`,`contract_num`,`contract_date`,`post`,`post_level`,`job_location`,`position`,`job_source`,`human_relations`,`station_number`,`office_phone`) values (1,1,0,0,'0000-00-00','0000-00-00','0000-00-00','',0,'0000-00-00','',0,'','',0,0,'','');

/*Table structure for table `admin_user_detail` */

DROP TABLE IF EXISTS `admin_user_detail`;

CREATE TABLE `admin_user_detail` (
  `user_detail_id` int(11) NOT NULL auto_increment COMMENT '自增编号',
  `user_id` int(11) NOT NULL default '0' COMMENT '用户编号',
  `home_town` varchar(100) NOT NULL default '' COMMENT '籍贯(可以省/市|市/区)',
  `sex` tinyint(1) NOT NULL default '0' COMMENT '性别(0-保密1-男2-女)',
  `ethnic` char(20) NOT NULL default '' COMMENT '民族',
  `age` tinyint(4) NOT NULL default '0' COMMENT '年龄(不从身份证取，如果没填则从出生日期证取；如果出生日期没填则从身份证取)',
  `birth_date` date NOT NULL COMMENT '出生日期(如果没填则从身份证取)',
  `id_number` varchar(30) NOT NULL default '' COMMENT '身份证(显示可以稍微屏蔽后几位)',
  `is_married` tinyint(1) NOT NULL default '0' COMMENT '是否结婚(0-保密1-已婚2-未婚)',
  `political_landscape` tinyint(1) NOT NULL default '0' COMMENT '政治外貌(0-其他1-群众2-团员3-预备党员4-党员)',
  `educational_background` tinyint(1) NOT NULL default '0' COMMENT '学历(0-其他1-大专2-本科3-硕士4-博士5-博士后6-高中7-中专8-小学)',
  `degree` tinyint(1) NOT NULL default '0' COMMENT '学位(0-其他1-学士2-硕士3-博士)',
  `graduated` char(30) NOT NULL default '' COMMENT '毕业院校',
  `specialty` char(40) NOT NULL default '' COMMENT '专业',
  `graduation` date NOT NULL COMMENT '毕业时间',
  `home_phone` char(30) NOT NULL default '' COMMENT '家庭电话',
  `mobile_phone` char(20) NOT NULL default '' COMMENT '手机',
  `msn` char(30) NOT NULL default '' COMMENT 'msn',
  `qq` int(20) NOT NULL default '0' COMMENT 'qq',
  `email` varchar(30) NOT NULL default '' COMMENT 'email',
  `current_address` varchar(50) NOT NULL default '' COMMENT '现住址',
  `technical_expertise_language` varchar(255) NOT NULL default '' COMMENT '技术特长-语言[存储格式如果都不选则为0]',
  `technical_expertise_hardware` varchar(255) NOT NULL default '' COMMENT '技术特长-硬件',
  `technical_expertise_software` varchar(255) NOT NULL default '' COMMENT '技术特长-软件',
  `technical_expertise_system` varchar(255) NOT NULL default '' COMMENT '技术特长-操作系统',
  `technical_expertise_network` varchar(255) NOT NULL default '' COMMENT '技术特长-网络',
  `technical_expertise_other` varchar(255) NOT NULL default '' COMMENT '技术特长-其他',
  `interests_sport` varchar(255) NOT NULL default '' COMMENT '兴趣爱好-运动',
  `interests_art` varchar(255) NOT NULL default '' COMMENT '兴趣爱好-艺术',
  `interests_chess` varchar(255) NOT NULL default '' COMMENT '兴趣爱好-棋牌',
  `interests_other` varchar(255) NOT NULL default '' COMMENT '兴趣爱好-其他',
  `motto` varchar(100) NOT NULL default '' COMMENT '座右铭',
  `user_photo` varchar(255) default '' COMMENT '用户图片',
  PRIMARY KEY  (`user_detail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户详细信息表';

/*Data for the table `admin_user_detail` */

insert  into `admin_user_detail`(`user_detail_id`,`user_id`,`home_town`,`sex`,`ethnic`,`age`,`birth_date`,`id_number`,`is_married`,`political_landscape`,`educational_background`,`degree`,`graduated`,`specialty`,`graduation`,`home_phone`,`mobile_phone`,`msn`,`qq`,`email`,`current_address`,`technical_expertise_language`,`technical_expertise_hardware`,`technical_expertise_software`,`technical_expertise_system`,`technical_expertise_network`,`technical_expertise_other`,`interests_sport`,`interests_art`,`interests_chess`,`interests_other`,`motto`,`user_photo`) values (1,1,'',0,'',0,'0000-00-00','',0,0,0,0,'','','0000-00-00','','','',0,'','','0|1','1|2|3','','1|2','','test1','0|1|2','0|2|4','0|2|5','test2','你好啊呀','');

/*Table structure for table `admin_user_group` */

DROP TABLE IF EXISTS `admin_user_group`;

CREATE TABLE `admin_user_group` (
  `user_group_id` int(11) NOT NULL auto_increment COMMENT '映射编号',
  `user_id` int(11) NOT NULL default '0' COMMENT '用户编号',
  `group_id` int(11) NOT NULL default '0' COMMENT '组别编号',
  PRIMARY KEY  (`user_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组表';

/*Data for the table `admin_user_group` */

/*Table structure for table `admin_user_role` */

DROP TABLE IF EXISTS `admin_user_role`;

CREATE TABLE `admin_user_role` (
  `user_role_id` int(11) NOT NULL auto_increment COMMENT '映射编号',
  `user_id` int(11) NOT NULL default '0' COMMENT '用户编号',
  `role_id` int(11) NOT NULL default '0' COMMENT '角色编号',
  PRIMARY KEY  (`user_role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户角色表';

/*Data for the table `admin_user_role` */

insert  into `admin_user_role`(`user_role_id`,`user_id`,`role_id`) values (1,733,1),(2,7,1),(3,1016,1),(4,1014,1),(5,746,1),(6,671,1),(16,18,1),(8,561,2),(9,563,2),(10,538,2),(14,1069,2);

/*Table structure for table `admin_users` */

DROP TABLE IF EXISTS `admin_users`;

CREATE TABLE `admin_users` (
  `user_id` int(11) NOT NULL auto_increment COMMENT '用户编号',
  `user_name` varchar(64) NOT NULL COMMENT '用户名',
  `real_name` varchar(64) NOT NULL COMMENT '昵称',
  `user_pass` varchar(32) NOT NULL COMMENT '密码',
  `status` tinyint(1) NOT NULL default '1' COMMENT '状态[1=已激活2-未激活3-已冻结4-已删除]',
  `ip` varchar(255) NOT NULL default '*' COMMENT 'IP',
  `login_time` int(11) NOT NULL default '0' COMMENT '上次登录时间',
  `logout_time` int(11) NOT NULL default '0' COMMENT '上次登出时间',
  `login_status` tinyint(1) NOT NULL default '0' COMMENT '登录状态(0-未登录1-已登录)',
  `add_time_int` int(11) NOT NULL default '0' COMMENT '添加时间',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户基础表';

/*Data for the table `admin_users` */

insert  into `admin_users`(`user_id`,`user_name`,`real_name`,`user_pass`,`status`,`ip`,`login_time`,`logout_time`,`login_status`,`add_time_int`) values (1,'admin','系统管理员','59ce8d441cad41067c5d5c199934216b',1,'*',1381903364,1381896252,1,0),(2,'xiaozhanye','肖展业','eb510d24202322de83b94b7cde7cdf8c',1,'*',0,0,0,1021347404),(7,'xulu','许鲁','6faade4339797545077a407d4074a233',1,'*',0,0,0,1021353447),(11,'zhangjg','张建刚','91ad129dc6218e1fae931cfc86d656f4',1,'*',0,0,0,1021613448),(18,'huangzhi','黄治','670dfb62c168d9ed43f28627f16ced8f',1,'*',0,0,0,1022639755),(19,'hanxm','韩晓明','adcc83a82d0e90aeda3cad5bc8057977',1,'*',0,0,0,1022643303),(21,'mayl','马一力','7cb4b62238afb2b4191c894742a9ac14',1,'*',0,0,0,1022647746),(34,'hanyue','韩月','431aeb78bef32ef22af24e6582cca36a',1,'*',0,0,0,1027993517),(35,'lijing','李静','e10adc3949ba59abbe56e057f20f883e',1,'*',0,0,0,1027995865),(57,'liuzj','刘振军','2c0b5211ce84ae20e7134f86ca124f76',1,'*',0,0,0,1040093466),(59,'jiht','纪海涛','a82d987a0c6ce9182a715d4d07a85e74',1,'*',0,0,0,1047344908),(63,'kuyn','库依楠','0a18bbd2ce27f79851e97be3e6a3a820',1,'*',0,0,0,1048217696),(956,'xuw','徐伟','19811e9432fe8e3359155e01ebb720fb',1,'*',0,0,0,1337848207),(84,'songzhen','宋震','e10adc3949ba59abbe56e057f20f883e',1,'*',0,0,0,1067774201),(96,'lijian','李健','0d0d4a4f4822fb89a48b4620b7a8f9ee',1,'*',0,0,0,1088469822),(100,'wangxiangdong','王相东','1829f1ac175552013c10e3c85c9306c0',1,'*',0,0,0,1089602293),(103,'zhangjw','张军伟','3a748c7dba76decb0bde1b8323d029c1',1,'*',0,0,0,1090229885),(115,'hexf','何小峰','c07e01f6c6dd4157afe3596f3a808fba',1,'*',0,0,0,1099296913),(150,'zhanghuan','张欢','e10adc3949ba59abbe56e057f20f883e',1,'*',0,0,0,1111714261),(157,'mahui','马辉','74edf43984394b3fc6aa0a10fb41f916',1,'*',0,0,0,1113207245),(167,'zhuzhili','朱智力','b17f6bd009703d6f800760d3b9222e26',1,'*',0,0,0,1116548443),(169,'wangjp','王建平','24d7cf8626779fa456432276f40324ee',1,'*',0,0,0,1117674811),(214,'xiaoqingxiong','肖庆雄','1dc3c5faf7f71c2ae8e475f02ce16caf',1,'*',0,0,0,1126146627),(216,'liuzh','刘振晗','69ed688613f4a636545c424e2fca02fc',1,'*',0,0,0,1126505309),(217,'liuliu','刘浏','2a285e64f137ce82e182aaeb4e8b8f78',1,'*',0,0,0,1126597274),(223,'xuhaiguo','徐海国','8f427697209dea9d3b0b20f475936bd2',1,'*',0,0,0,1129509723),(249,'jiaoshangwei','焦尚伟','4d4dcdc66b539fca112dd15cbca57b95',1,'*',0,0,0,1137044684),(489,'guojiaojuan','郭姣娟','71dd39bc2224dad3a61d6cfb47fb5818',1,'*',0,0,0,1205145496),(254,'guomingyang','郭明阳','0988195bb6ea1405d4622ea8a30d27bc',1,'*',0,0,0,1139798691),(714,'liubingbing','刘冰冰','c1cda286fcd4d61572afa71b34a6efed',1,'*',0,0,0,1288852756),(305,'gaosong','高嵩','084e0343a0486ff05530df6c705c8bb4',1,'*',0,0,0,1147916301),(306,'wuwenyang','吴文阳','a89fd68eb35a39d049fc07da06e80242',1,'*',0,0,0,1147924107),(309,'huanglingling','黄玲玲','26439ed5d1a3f8347b671e4920713a77',1,'*',0,0,0,1149474042),(310,'wuzy','吴震洋','020dc331fdf78406ae44fb2b5d0631ee',1,'*',0,0,0,1149483194),(326,'liupf','刘培峰','6ea6323c490815570f2651174782c17e',1,'*',0,0,0,1152233649),(338,'wangzhiyuan','王志远','64be4374fed9e072a40744e5e9498098',1,'*',0,0,0,1154675026),(348,'mawj','马文君','a6944434e5a90c19e01e0c0ca7ddb44f',1,'*',0,0,0,1156383613),(389,'zhuqianyuan','朱乾元','990a71cfacc8803c309751a46d359349',1,'*',0,0,0,1300105727),(404,'dingdinghua','丁定华','69b502dff860f9ea7c88cfbef791cfb9',1,'*',0,0,0,1173160522),(1022,'caijieming','蔡杰明','1c63129ae9db9c60c3e8aa94d3e00495',1,'*',0,0,0,1357541407),(439,'wanghua','王华','c5c6fd9ce394778b252b51784b1c2fd2',1,'*',0,0,0,1184034070),(441,'songxia','宋霞','6f82c478134d067b551b7c3e075e76c6',1,'*',0,0,0,1184061942),(570,'lijiande','李建德','0d189c779f54fd69a1d947f149e5dc13',1,'*',0,0,0,1231382221),(563,'liyong','李勇','55c91463bb50b68db80bbc1571a1fa27',1,'*',0,0,0,1227579621),(497,'lichunhua','李春华','c397074c38cd211d8a06aab1fe62df4e',1,'*',0,0,0,1205720471),(499,'zhangxi','张熙','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1205722451),(502,'zhangweiqun','张维群','a8accff3f23db2b5d0cd5891d781a575',1,'*',0,0,0,1206927261),(504,'wangxiaofei','王晓飞','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1207099564),(508,'weixiaobo','魏晓波','4a73f7eb12bb4b0039b3060acaa8c588',1,'*',0,0,0,1207704944),(509,'wangzhi','王志','5f45627e45bba110e0e772cb09b4fc70',1,'*',0,0,0,1207705028),(510,'jinjinglong','金景龙','3056f3723a491b121fccbd6314f61083',1,'*',0,0,0,1207705074),(512,'zhangjiangang2','张建刚','c163ed0efe4cfecec7ad2b3549621280',1,'*',0,0,0,1207705089),(519,'yangkerong','杨克荣','cfe0c066bd91cf2383d050b626564ee5',1,'*',0,0,0,1209973722),(523,'renjianhui','任建辉','869e8154cdecaf4183eed4e183f2cc06',1,'*',0,0,0,1214446324),(645,'hanpeipei','韩培培','f8993a45252c500ac4ecabcf797cbfcd',1,'*',0,0,0,1267177225),(527,'haopeng','郝鹏','ce0dbcaaa87586eed6f037b3d1d873e3',1,'*',0,0,0,1216168966),(528,'zhangweijia','张伟佳','557c1363818cec4ac62e350207049243',1,'*',0,0,0,1216168995),(530,'konghaiyue','孔海悦','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1216170341),(538,'lijinming','李锦明','ecd8de1710f5160afca7cde0686d9e83',1,'*',0,0,0,1216177217),(541,'liuxiaojing','刘晓婧','5d063c117a4814b2272e25b1ebcf3619',1,'*',0,0,0,1216178470),(561,'zhangqiang','张强','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1223864059),(548,'qianruoxin','钱若昕','9253e00fad279dd36e08949ad8c698ac',1,'*',0,0,0,1219287175),(551,'tianlimin','田利民','e10adc3949ba59abbe56e057f20f883e',1,'*',0,0,0,1219719070),(578,'zhaomeng','赵猛','6f0a7943f40dd0acc8b57567f7f0e1f1',1,'*',0,0,0,1236753490),(583,'yangxue','杨雪','793b2485e8a00bc7ff1c2d2cc8505158',1,'*',0,0,0,1238553038),(584,'panchengjun','潘成君','262d9140a65ea6ee35f221d80b57d79f',1,'*',0,0,0,1239782881),(67,'buqz','卜庆忠','c2128341feb078951910ba640255d0d8',1,'*',0,0,0,1049720553),(626,'liuxiaogang','刘小刚','27d7b744883dfbcc19a971f1322e005d',1,'*',0,0,0,1258453688),(592,'sunzhenyuan','孙振元','33642f70a2e11fb2068d8bcbb9124f38',1,'*',0,0,0,1241916457),(593,'wanghaiqin','王海芹','dfc39babd8d58ed9c2c4352837607e17',1,'*',0,0,0,1242265571),(600,'fangyuan','方媛','659b661f77ae2d77daacbf9c9ef65035',1,'*',0,0,0,1247462893),(604,'luoxi','罗奚','50c1659d1eb642eda13eabc3b62b6d3c',1,'*',0,0,0,1247463138),(605,'liufang','刘芳','',1,'*',0,0,0,1247463176),(607,'chenpengxu','陈鹏旭','a0ad9c2d4970630b8f2e98f1190a09c9',1,'*',0,0,0,1247463310),(610,'chenhuan','陈焕','2531e77e4f49eb3518858323bd930768',1,'*',0,0,0,1247463889),(612,'lidexiong','黎德雄','01388b55e91f97958b5935b7d60a66f5',1,'*',0,0,0,1247464186),(613,'jiaoyingtian','矫英田','2702f9e939f067c2049a1fad78532790',1,'*',0,0,0,1247464265),(614,'liudeqiang','刘德强','d76fa75cdec8357a0775eac2654e3856',1,'*',0,0,0,1247464343),(616,'yufei','于飞','3fbf23c25492895554130ac16c67ee1b',1,'*',0,0,0,1247464500),(617,'tengbaosen','滕宝森','',1,'*',0,0,0,1247464601),(619,'liuguoliang','刘国良','327f2f168d392fef164da9e1d078b839',1,'*',0,0,0,1252286856),(621,'lixiangchao','李向超','e43607c13427e519098e3e54c54aab9a',1,'*',0,0,0,1254044989),(625,'gaoruilin','高瑞林','22daa3aeac4276b589a438f4290cf2c1',1,'*',0,0,0,1257406577),(680,'liujianliang','刘建亮','da913b89f7dfe8a2ec7e31ad45c342b5',1,'*',1381903558,0,1,1277349652),(671,'zhengshunhua','郑顺花','4297f44b13955235245b2497399d7a93',1,'*',0,0,0,1271731472),(632,'dongleilei','董磊磊','',1,'*',0,0,0,1267174758),(633,'helan','何兰','f39508ab7d7bfdbfea66980ba4abc5f5',1,'*',0,0,0,1267174948),(639,'dongyunzhou','董云州','d5ea818525084df7eea31b5754e6c92c',1,'*',0,0,0,1267176131),(648,'guogaofeng','郭高峰','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1268285657),(649,'shaobingqing','邵冰清','dae0fa7cabc7ca11ecfef77041c9154c',1,'*',0,0,0,1268285904),(1021,'yanghongzhang','杨洪章','41f328563aac52b22a948857908a435d',1,'*',0,0,0,1357540666),(1020,'wangkaird','王凯','7b93a361692449d2a82487f93228d396',1,'*',0,0,0,1357539995),(663,'yangxiaohu','杨小虎','6df6bed724966aeb97d45cffb1c555a7',1,'*',0,0,0,1270114507),(666,'shuyoucun','舒友村','a06c90e67236e9263c5ce3d78bdd4aad',1,'*',0,0,0,1271652756),(667,'wangbing','王兵','db52e78768aa59b3c1f2f631c6301277',1,'*',0,0,0,1271652836),(668,'chenfangxian','陈方县','1388464d4c5a9aaa6937410b3d732c6a',1,'*',0,0,0,1271652908),(669,'zhengcaiping','郑彩平','68991880911a3d98db6efaa39c21fd1a',1,'*',0,0,0,1271652965),(670,'liangyi','梁毅','c96b81a9551dfa6fee25b1830a7cbd7f',1,'*',0,0,0,1271664033),(672,'guowei','郭伟','20729ce46d33f2d37b6cadb8d07c9d47',1,'*',0,0,0,1272445696),(679,'yizhenhua','伊振华','15f4d0cbf9a84af5d8db255fe494ae15',1,'*',0,0,0,1276323522),(687,'qiyu','齐宇','ef23fb6ed8b783f5b145435e637f3208',1,'*',0,0,0,1277867699),(688,'shafanghao','沙方浩','3d186804534370c3c817db0563f0e461',1,'*',0,0,0,1277868083),(689,'wuyongfang','吴永芳','ca6d98fccf38095ee49c49fe1e4d98da',1,'*',0,0,0,1277868259),(693,'chendeliang','陈德梁','f96517d6f9c2fcd4ab209e61659b4123',1,'*',0,0,0,1277868626),(695,'zhangzhen','张振','e1a85be28fbf3614463438f3b5166c98',1,'*',1381903440,0,1,1277868737),(699,'luoxiang','罗翔','5915f6386ae922751c4f83e00347cef3',1,'*',0,0,0,1277869018),(701,'wangzhe','汪','b63afaff32a1763d99ce53757a641df4',1,'*',0,0,0,1277869164),(702,'sunyanli','孙艳丽','a8ad67e08fee6176531ce8c1a6377a02',1,'*',0,0,0,1277881062),(703,'chenjie','陈捷','55dc34fa241f73b426c65e96c7193fc0',1,'*',0,0,0,1278470806),(706,'wanghui','王慧','3d3ef90f323062fa9255b3731a15501e',1,'*',0,0,0,1280814866),(735,'zhaomin','赵敏','006dfab0fb7d273c56838d9b7f882380',1,'*',0,0,0,1304408264),(709,'wutao','吴涛','e10adc3949ba59abbe56e057f20f883e',1,'*',1381902507,1381902586,0,1281690229),(710,'wangdongjie','王东杰','2a4e85456f4249bc85c1bac05ed94557',1,'*',0,0,0,1282888538),(737,'daitianmin','代天敏','bc285578a0b1c3e04da4f56ee2a3012f',1,'*',0,0,0,1305081307),(721,'ligaofeng','李高峰','e9af655b8683cd3f130d1d2f0a546a8f',1,'*',0,0,0,1300083998),(722,'lichunyan','李春燕','5c69ee2aa6618baf84b06901eac36189',1,'*',0,0,0,1300347749),(726,'jidan','季丹','d76cf7245989a941d70316b0e57ecf50',1,'*',0,0,0,1301638343),(733,'malihua','马丽华','5d77d30a6320b4499b6a66e4e4136fbc',1,'*',0,0,0,1303282881),(738,'lixiaochen','李晓辰','39b02ceef5e274780b709421cf2d809a',1,'*',0,0,0,1305105336),(741,'donghuanqing','董欢庆','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1305791780),(742,'wangzhen','王朕','',1,'*',0,0,0,1305861128),(743,'huwensheng','胡文胜','',1,'*',0,0,0,1306467243),(745,'pengxingbao','彭兴宝','0abbb889b59c1fa43ec0713d1bf56565',1,'*',0,0,0,1306890600),(746,'wangjirong','王吉荣','75068ffeafc50f575180e80695e6b9ec',1,'*',0,0,0,1307415052),(747,'liliangfei','李亮飞','85a1d185ae11ee3bb8845ec5bf5fbfc2',1,'*',1381903267,0,1,1307415142),(756,'zhangrui','张芮','43305fc216b9c0f63902effe26587d0e',1,'*',0,0,0,1310018709),(749,'wubaolin','吴宝林','e5b6325f7077e0f860cc0a377454a344',1,'*',0,0,0,1308897911),(759,'qiuzhixin','邱志鑫','16030cf0f8ad29ecbcf6d7d006e3e533',1,'*',0,0,0,1310607979),(754,'pandaguo','潘大国','a14d18bb28cfb38dc6362c87a6061aaa',1,'*',0,0,0,1309743687),(760,'wanghong','王红','321c556181b4360dfae375d20630a97f',1,'*',0,0,0,1310609339),(761,'sunhongjin','孙洪金','b17e80019cae66ce467157606f3a4e9f',1,'*',0,0,0,1310609698),(765,'dongjunduo','董俊铎','e52c3e527ec924d6a83b6f51264248b4',1,'*',0,0,0,1310612176),(766,'wangchangsong','王长松','c0cba3301365bd54b632677fee6f230b',1,'*',0,0,0,1310612314),(767,'lina','李娜','7c87f0d5884d11c1fb90464b136f968f',1,'*',0,0,0,1310612605),(768,'liuyuwei','刘雨薇','0d2daa90f0d03f9956e06dd9529bd51c',1,'*',0,0,0,1310612726),(772,'liuhongtong','刘洪通','a6d43a253ff8c21267b8200cdb2ae90c',1,'*',0,0,0,1310614228),(773,'zhangrenfeng','张仁峰','53820ab6ecb81599c094b8fb212bd583',1,'*',0,0,0,1310614412),(778,'changbiao','常标','aac9b8746a28387f50f79591cee37288',1,'*',0,0,0,1310615589),(779,'jimingzhe','嵇明哲','e322a1645c61dafe533fac0329baa7cd',1,'*',0,0,0,1310615700),(781,'wangzhongsheng','王中圣','87819bc5b51df24eab203d94f1fd17c3',1,'*',0,0,0,1310615894),(785,'lizhanhe','李占和','d9954316e6d8abee42ea098a8619cb64',1,'*',0,0,0,1310619558),(791,'liyawen','李亚文','690c7121be624267519ec5789ac58aaa',1,'*',0,0,0,1311831461),(796,'zhaoguoqian','赵国谦','46e44aa0bc21d8a826d79344df38be4b',1,'*',0,0,0,1313059638),(797,'dingyuan','丁元','',1,'*',0,0,0,1313059760),(803,'liuyue','柳月','4e926dd8a38a689d19031bef11f77f2b',1,'*',0,0,0,1314251524),(800,'tianya','田亚','4fc218144dd71241e41a27d3d15f3621',1,'*',1381893110,0,1,1313396046),(804,'liuyaxin','刘雅馨','3a43afce6d01eecb25b23586f26fb36c',1,'*',0,0,0,1314252987),(805,'zhangyun','张芸','',1,'*',0,0,0,1314254928),(809,'maliuying','马留英','633d5b5b9fd7cb0a154ef2a03004d217',1,'*',0,0,0,1314871310),(812,'lizeming','李则鸣','f39b44a114c42661d35a532244c343ef',1,'*',0,0,0,1315982018),(815,'wubingxin','吴冰心','',1,'*',0,0,0,1316655624),(816,'wangbao','王宝','6288614a2f3e72bca50462b7123ebd4a',1,'*',0,0,0,1316765506),(820,'huzhenguo','胡振国','5e3487b9075bddddff8ff7c0ef8acc8f',1,'*',0,0,0,1318072609),(823,'shilinna','史琳娜','d809acf2ff18252e2df81abf05fb21ac',1,'*',0,0,0,1318561501),(828,'linjianjin','林建金','e3154fc4517b392ddf86c2681ab0ac28',1,'*',0,0,0,1319180478),(831,'zengqingwei','曾庆伟','d7af994f1f1ef8b5e3beb9f7fb139f57',1,'*',0,0,0,1319425182),(832,'lirui','李蕊','54c3591615519fd2d9355d25b1486740',1,'*',0,0,0,1319692430),(839,'zhanxiaoxiao','詹肖肖','4fdf2bf4f749374e5c8ce29d99945d31',1,'*',0,0,0,1322201181),(841,'yuanyuwei','袁禹伟','52c69e3a57331081823331c4e69d3f2e',1,'*',1381893193,0,1,1322646462),(843,'wuxupu','武旭普','367a7c00ac5d0da6c9535f95edad1fdd',1,'*',0,0,0,1324021688),(844,'sunxiuhuan','孙秀焕','',1,'*',0,0,0,1324022060),(845,'maxuemeng','马学萌','830fd5ff9939abb1a22f758469d20893',1,'*',0,0,0,1324022116),(846,'dingjiao','丁娇','cb1801429c556af6cd0b501bc95d581a',1,'*',0,0,0,1324022164),(911,'sunjianwei','孙建伟','9ae5eec255a05504f730a5e5aa5850e3',1,'*',1381902413,0,1,1333680739),(851,'sunqingfeng','孙清峰','03717c7fb369cdf83f5347e1e6bb1f99',1,'*',0,0,0,1325318604),(855,'liukai','刘凯','8013e92d7a6a9d6cde69541667f004da',1,'*',0,0,0,1327113835),(856,'leiyu','雷雨','7fa8282ad93047a4d6fe6111c93b308a',1,'*',0,0,0,1327113927),(858,'duxuemei','杜雪梅','2880176caaf16d6d079f08c2abd87ace',1,'*',0,0,0,1327114072),(864,'renguangkuo','任广阔','8891eb77c7c2de21516574f93100269b',1,'*',0,0,0,1328585467),(865,'lvdinglong','吕定龙','8f1d974a0add03f15993edb56222e88c',1,'*',0,0,0,1328585497),(866,'liuhuan','刘欢','a4927a5a192068f32eba4f8ba00d35b1',1,'*',0,0,0,1328585523),(868,'wangjianxin','王建新','3446a922477b8819252048019da0ffa7',1,'*',0,0,0,1328585584),(871,'liujinxi','刘金玺','8e3864b42d7cf62bad247656c546cf4d',1,'*',0,0,0,1328585882),(872,'fangning','方宁','7ddb7915e9596eb1d6a42abf47f83734',1,'*',0,0,0,1328585914),(873,'linxue','林雪','ec202b1c7575f46e0e62ccaf9d8071e1',1,'*',0,0,0,1328585945),(874,'guofengya','郭丰雅','b9c104b90261946a10a05cd3453305d1',1,'*',1381903482,0,1,1328585977),(875,'tianbo','田波','56c86db7fb84a225800a3840b4b5b557',1,'*',0,0,0,1328586029),(876,'yanxiaoyan','闫晓燕','ecd53b3d3ad35c6fa587a90ae7d7783d',1,'*',0,0,0,1328586067),(877,'zhangwenping','张文萍','0778b8ae69b932158dc77fd56347e50b',1,'*',0,0,0,1328586094),(879,'shouxiaoyun','寿小云','5a2539633f3372e89aa9a39578fc37c1',1,'*',0,0,0,1328586153),(880,'daiguochao','戴国超','eeb53921f9c6019a1a1ab30286b2e0d5',1,'*',0,0,0,1328586191),(881,'puxinxue','蒲新雪','661d67a31d75a4be35aadfd79639a0ab',1,'*',0,0,0,1328586226),(882,'liuxinyuan','刘新元','5c31a6668455113cd9d7baea63dfa43e',1,'*',0,0,0,1328586260),(883,'liuyu','刘钰','faea6866eaae22d9773fcfc25d3bc5ee',1,'*',0,0,0,1328586316),(884,'hewenting','何文婷','',1,'*',0,0,0,1328866991),(885,'liuyums','刘宇','b8affe0ac983893d419bb66a26b428d6',1,'*',0,0,0,1330311171),(890,'shenqi','申琦','028f318eed1849ca01d6108e10f4f4fb',1,'*',0,0,0,1330311720),(891,'wangqiangeng','王乾庚','6c3f10d5d4ca968916c2bbb66351eee1',1,'*',0,0,0,1330311771),(892,'yanpengfei','闫鹏飞','5c28c72a4afe696ef0e17d6753f6e4ae',1,'*',0,0,0,1330505798),(893,'chenshuting','陈舒婷','7f2a13ce976638c3396a45acf2994b5b',1,'*',0,0,0,1330591082),(895,'zhanghao','张浩','9f0606ac2992a2c426e6a78b996cdcea',1,'*',0,0,0,1330591304),(897,'lijianshe','李建设','f7c40248d2a48ed1a713055f9fe0036d',1,'*',0,0,0,1331605002),(898,'chenglianjiang','程连江','680c277950a0c5965339666bd7da512b',1,'*',0,0,0,1331605157),(899,'liulei','刘蕾','b11d048ca5322b53b5aec80664ecbdbb',1,'*',0,0,0,1331605248),(900,'mijinlong','米金龙','dd9cd7d85311d4c00a1dcc17a442009b',1,'*',0,0,0,1331605363),(901,'wangdong','王东','e0916f38213a86308fe3b36158c242e8',1,'*',0,0,0,1331605578),(903,'wanghuijiang','汪汇江','a45cf722544a29077d7452efc799d755',1,'*',0,0,0,1331780358),(907,'zhujiaolu','朱教禄','823aaec2d65a2026f65572b9dc8e2162',1,'*',0,0,0,1332319887),(908,'fangfei','方飞','a546b55d0f2aaba698be7c3be71d54db',1,'*',0,0,0,1332320214),(912,'liujilong','刘纪龙','7b236992984a9c10649390e87505aa15',1,'*',0,0,0,1333942679),(913,'shandawei','单大伟','',1,'*',0,0,0,1333950727),(914,'zhoulei','周磊','50b5f34cd69aeb0afca697c95d7ab965',1,'*',0,0,0,1333950803),(915,'zhanghaoyu','张皓宇','912160b4a97f05c1de9e7233af8f0397',1,'*',0,0,0,1333954790),(916,'yepeng','叶鹏','',1,'*',0,0,0,1333954823),(919,'yunfei','云菲','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1334891910),(921,'zhouqingshan','周青山','e3ceb5881a0a1fdaad01296d7554868d',1,'*',0,0,0,1334892272),(922,'zhaohe','赵翮','5eb99b39e875af95293ef1f49b0e27a3',1,'*',0,0,0,1336021624),(923,'gengchengshan','耿成山','1181103276134128c0643388ed02e41a',1,'*',0,0,0,1336021789),(926,'lilulu','李露露','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1336528212),(927,'changqing','常青','e8f43cfa00772ec850047e22fda39d5a',1,'*',0,0,0,1337736031),(960,'xuzhiwei','徐智伟','4da181763f5120338fb27dee73304502',1,'*',0,0,0,1340271321),(961,'lvyuejia','吕跃佳','bb57e4c52119daef24c140608c530863',1,'*',0,0,0,1340271499),(963,'hanfeng','韩枫','9681504d01efadfb01264efed9a02b53',1,'*',0,0,0,1340271701),(965,'liyangzhao','李养兆','9e9fcc00c733da96991d7e02a2c39341',1,'*',0,0,0,1340675105),(967,'wangyachen','王亚晨','e10adc3949ba59abbe56e057f20f883e',1,'*',0,0,0,1341275864),(968,'gelina','葛丽娜','ed0480281be7fd6593f9525b8cc77ec8',1,'*',0,0,0,1341805835),(970,'jiaquan','贾权','8aa24184c170bb08a5e88d479370d513',1,'*',0,0,0,1341805933),(971,'liubozhi','刘博智','164f26f1cee8bd73394640ade9ddf4af',1,'*',0,0,0,1341805969),(972,'dingshengping','丁声平','de9acb3f97f146c0858c6bb4b2b5b28c',1,'*',0,0,0,1341806016),(977,'chenyang','陈洋','041c87e2357eb15655cc3710670eb2e3',1,'*',0,0,0,1341806325),(978,'wangmaohong','王懋红','e1c43d07b753893a100859d3d420fc78',1,'*',0,0,0,1341806370),(979,'liubing','刘冰','0e58492cb19ef20368e1b658c88c71e9',1,'*',0,0,0,1341809565),(980,'yanhuan','严欢','1e800fe565d08fe7db0f0a6c529d3db6',1,'*',0,0,0,1341809616),(981,'renpeijia','任培家','8b784fce61cbfe404d973d8036c30921',1,'*',0,0,0,1341809651),(983,'liupingping','刘萍萍','2b4efdf6938f4a71248244efe48246a9',1,'*',0,0,0,1341809796),(984,'shaoruiqiong','邵瑞琼','34a79f4e6f875d21d759060d97abe8ab',1,'*',0,0,0,1341809856),(985,'dingyuguang','丁宇光','85cd8903c84f34cc5da540c0ad9348bb',1,'*',0,0,0,1341811289),(987,'sunxiaobin','孙晓宾','789631f14127cac1b5fb49238c392790',1,'*',0,0,0,1341811354),(989,'liuyoujin','刘有金','7780804a2d65d33e5b7f7d494d1bde9e',1,'*',0,0,0,1341811428),(991,'chenna','陈娜','a565d2ab7e7657eeb9dec40e1f69d743',1,'*',0,0,0,1341811494),(992,'zhangyan','张燕','9253a95e050bcbdfac99187ca022b32e',1,'*',0,0,0,1341811520),(993,'xuehaitao','薛海涛','f76fb34b22fe0f78993824c36b0a1432',1,'*',0,0,0,1341811551),(995,'zhaoyan','赵岩','79805c70fc99f51f40861704b335d1c4',1,'*',0,0,0,1341811620),(1002,'shaobingyang','邵炳阳','acff9afbb698a200cc3607a6bc191f03',1,'*',0,0,0,1343268210),(1003,'jiaohui','焦辉','88e79bb3a913a43d57e0237ca45a4703',1,'*',0,0,0,1343351571),(1004,'yangjinnan','杨金楠','e8a3708b785db17e74f9d3cfc57940b8',1,'*',0,0,0,1344224489),(1007,'lvxuejiao','吕雪娇','b18869061c23393bdb60bb9539b541ce',1,'*',0,0,0,1346037909),(1009,'zhaomeixin','赵美欣','9a9b6cd865718800766e81d6f83faeef',1,'*',0,0,0,1347845423),(1010,'yangpengsd','杨鹏','37b58c062cf70b12339af5a0b4e34ff6',1,'*',0,0,0,1350981255),(1011,'wangquan','汪权','d0a12276baba743c03e4836d256a36a3',1,'*',0,0,0,1350981540),(1013,'jiaojianjun','焦建军','9e5b2add4ebc40f1bffdee1555bb2d9a',1,'*',0,0,0,1352258447),(1014,'yangliu','杨柳','',1,'*',0,0,0,1353488957),(1015,'zhangyong','张永','62bd77187e8a6f972a9ac67ed734efae',1,'*',0,0,0,1354584579),(1016,'bianhuimei','边慧梅','1c63129ae9db9c60c3e8aa94d3e00495',1,'*',0,0,0,1354584961),(1017,'baijunlin','白俊林','72b491c36ac099a2d295e6cf855e163c',1,'*',0,0,0,1354847918),(1018,'shixiaofang','师晓芳','30f24d930e038923ddd87aab8a5b3b73',1,'*',0,0,0,1354847987),(1025,'gaoyuxin','高玉欣','489605275477fbf0016fcf4d8d92ddcd',1,'*',0,0,0,1360132948),(1026,'dongmingquan','董明全','a928274b4f95bb70f8bd0c3bdd53dfb9',1,'*',0,0,0,1360133164),(1027,'tianye','田野','62957aa4fe0cc72b7ad5868ef38a5938',1,'*',0,0,0,1360133371),(1030,'wangzhensd','王震','e28507deda00c8c69ced44cc73c76627',1,'*',1381903038,0,1,1360133685),(1031,'lichao','李超','98d73eb6282f511d27f2b47c8c78d11a',1,'*',0,0,0,1360133842),(1032,'mudapeng','穆大朋','417bb6ec32067acd7635d5458abd079a',1,'*',0,0,0,1360134002),(1033,'zouchengwei','邹成伟','610d7a665d7c34400715405bdf336472',1,'*',0,0,0,1360134097),(1034,'lunanxi','卢男希','b2d866b0bf6762cc7c399de115810cfd',1,'*',0,0,0,1360134176),(1035,'jiangzhaodi','姜招娣','0c2186458b864af0627230f848c3cda2',1,'*',0,0,0,1360134595),(1036,'panhaozhe','潘昊哲','ca0658ceb0e5b092842536dc080eab3d',1,'*',0,0,0,1360134744),(1037,'donghailong','董海龙','b61c8a225ebbc3ce63f863f563f8bd38',1,'*',0,0,0,1360134843),(1038,'zhangjingwen','张静文','fee998e642314771cf1805b34a49cf35',1,'*',0,0,0,1360134954),(1040,'shicuizhu','史翠竹','329587cd6872968a6f7f8691e670da7f',1,'*',0,0,0,1360135099),(1041,'xiemengxia','谢梦霞','66ccbb3e10c60dfe6b667497a5e29005',1,'*',0,0,0,1360135157),(1042,'chendan','陈丹','05fb30d1ef59e1f3a835054eb5c4388f',1,'*',0,0,0,1360135231),(1046,'xiaoxinyu','肖新宇','79d53a9924137ed5aba7d299f77e4102',1,'*',0,0,0,1360135648),(1049,'shangfeng','尚峰','41cad80a211bda0716b9c9101525d7a1',1,'*',0,0,0,1360135941),(1050,'wangrui','王蕊','284d011ae23d7824abcfcae377d297c6',1,'*',0,0,0,1361169506),(1052,'yanglin','杨琳','69dddcaf054307b9b56f394b0dee6c97',1,'*',0,0,0,1361332629),(1054,'wangxiaoxiang','王晓祥','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1361936784),(1056,'zhaojunwei','赵峻伟','2e392bd3de979a3403874eb8adcea936',1,'*',0,0,0,1362105954),(1057,'dongpengfei','董鹏飞','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1362991944),(1059,'fangyanan','房亚楠','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1364976600),(1061,'lusuran','卢素然','f5083ea8a61edd49c9ef91312d7df66e',1,'*',0,0,0,1365324024),(1062,'guozhongqiu','郭忠秋','c6a9ffbd7b904cd281fe87fa2bc25017',1,'*',0,0,0,1367908740),(1063,'hanchengqin','韩承钦','e4948fca99235a9b9a029633d632fe9e',1,'*',0,0,0,1367909122),(1064,'lizongzhe','李宗','521ee7d9e7c3b6e77ad70f8b31c54a78',1,'*',0,0,0,1368438299),(1065,'fuxiaoxi','付晓希','0c86597b5930bcd93639843ef07ba628',1,'*',0,0,0,1369277376),(1068,'sunzhen','孙震','b38cf0593f4e12f9c38f1028ba9c0e9f',1,'*',0,0,0,1371194623),(1069,'wanglichao','王丽超','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1372140734),(1071,'zhangjingzhe','张晶哲','0e2a241d07eb2444faf935c9a96d2493',1,'*',0,0,0,1372410530),(1072,'yangyanjun','杨艳君','7651b68e5f95079280eaab1770bbdc31',1,'*',0,0,0,1372410629),(1073,'zhubaohui','朱宝晖','5416d7cd6ef195a0f7622a9c56b55e84',1,'*',0,0,0,1372410722),(1074,'wangfangfang','王芳芳','c0862a4c33dc060e63c0aa01db241c3d',1,'*',0,0,0,1372410825),(1075,'liangpan','梁攀','6e1f71ce516d9ad514b399db5cb9429a',1,'*',0,0,0,1372410920),(1076,'biyanbo','毕彦博','061e734d81fe766f69fb5d6d291ee971',1,'*',0,0,0,1372410965),(1078,'hanlei','韩磊','96e79218965eb72c92a549dd5a330112',1,'*',0,0,0,1373539377),(1079,'linmeifang','林玫芳','42a03ee792a093e1592acbd8f5ff558e',1,'*',0,0,0,1373959917),(1089,'liyangpl','李阳','',1,'*',0,0,0,1379822063),(1080,'wangjie','王洁','afe3a4c530e212f4cbf02def25140d45',1,'*',0,0,0,1376382955),(1083,'liujian','刘健','e4aa4867a695625163632eee3a87ea79',1,'*',0,0,0,1377048634),(1084,'chenxiu','陈秀','76da1f8d455d65e118dcbc8dea26cf4d',1,'*',0,0,0,1377238182),(1085,'helanhr','何兰','c8837b23ff8aaa8a2dde915473ce0991',1,'*',0,0,0,1378718457),(1086,'liuyancui','刘艳翠','87be642abf609a7adbcba75da17eae4d',1,'*',0,0,0,1378981612),(1087,'tianhuahr','田华','81ccfc16a3779474341faea4e9f562b8',1,'*',0,0,0,1378981719),(1088,'hexiaolin','何小林','8d86614c6b5166b6447145a2adbf6b46',1,'*',0,0,0,1379306346),(1091,'songzhixin','宋志新','',1,'*',0,0,0,1379832690),(1092,'houjie','侯杰','8225d5411641ada8342d85011a98a320',1,'*',0,0,0,1021347404);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;