/*
SQLyog Ultimate v11.24 (32 bit)
MySQL - 5.6.12 : Database - school_a1
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`school_a1` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `school_a1`;

/*Table structure for table `admin_apps` */

DROP TABLE IF EXISTS `admin_apps`;

CREATE TABLE `admin_apps` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '应用编号',
  `app_name` varchar(40) NOT NULL DEFAULT '''''' COMMENT '应用名称',
  `app_string` varchar(20) NOT NULL DEFAULT '''''' COMMENT '应用字符串',
  `comments` text NOT NULL COMMENT '描述',
  `sort` smallint(4) NOT NULL DEFAULT '20' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态[1-激活0-未激活]',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除[1-是0-否]',
  PRIMARY KEY (`app_id`),
  KEY `index1` (`app_id`,`app_name`,`status`,`is_delete`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='应用表';

/*Data for the table `admin_apps` */

insert  into `admin_apps`(`app_id`,`app_name`,`app_string`,`comments`,`sort`,`status`,`is_delete`) values (1,'后台管理系统','admin','',1,1,0),(4,'学校管理系统','school','',2,1,0);

/*Table structure for table `admin_logs` */

DROP TABLE IF EXISTS `admin_logs`;

CREATE TABLE `admin_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志编号',
  `app_string` varchar(30) NOT NULL DEFAULT '' COMMENT '应用字符串',
  `module_string` varchar(30) NOT NULL DEFAULT '' COMMENT '控制器字符串',
  `action_string` varchar(30) NOT NULL DEFAULT '' COMMENT '动作字符串',
  `operate_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人编号',
  `operate_user_name` int(30) NOT NULL COMMENT '操作人用户名',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '普通用户编号',
  `user_name` int(30) NOT NULL COMMENT '普通用户名',
  `title` varchar(100) NOT NULL COMMENT '简短描述',
  `comments` text NOT NULL COMMENT '描述',
  `add_time_int` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '2' COMMENT '删除[1-是2-否]',
  PRIMARY KEY (`log_id`),
  KEY `index_1` (`log_id`,`app_string`,`module_string`,`action_string`,`is_delete`),
  KEY `index_2` (`log_id`,`is_delete`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表';

/*Data for the table `admin_logs` */

/*Table structure for table `admin_resource_page` */

DROP TABLE IF EXISTS `admin_resource_page`;

CREATE TABLE `admin_resource_page` (
  `resource_page_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `app_string` varchar(50) NOT NULL DEFAULT '' COMMENT '应用字符串',
  `module_string` varchar(50) NOT NULL DEFAULT '' COMMENT '模块字符串',
  `action_string` varchar(50) NOT NULL DEFAULT '' COMMENT '动作字符串',
  `resource_id` int(11) NOT NULL DEFAULT '0' COMMENT '资源编号',
  `page_name` varchar(50) NOT NULL COMMENT '配置页面',
  `comments` text COMMENT '描述',
  `add_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '添加用户编号',
  `add_user_name` varchar(32) NOT NULL DEFAULT '' COMMENT '添加用户名',
  `add_time_int` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-不删除1-删除）',
  PRIMARY KEY (`resource_page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='资源页面配置表';

/*Data for the table `admin_resource_page` */

/*Table structure for table `admin_resources` */

DROP TABLE IF EXISTS `admin_resources`;

CREATE TABLE `admin_resources` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '应用模块动作挂接编号',
  `app_id` int(11) NOT NULL DEFAULT '0' COMMENT '应用挂接编号',
  `app_string` char(64) NOT NULL DEFAULT '' COMMENT '应用挂接字符串',
  `module_id` int(11) NOT NULL DEFAULT '0' COMMENT '模块挂接编号',
  `module_string` char(64) NOT NULL DEFAULT '' COMMENT '模块挂接字符串',
  `module_sort` int(11) NOT NULL DEFAULT '20' COMMENT '模块排序',
  `action_string` char(64) NOT NULL DEFAULT '' COMMENT '动作挂接字符串',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `sort` int(11) NOT NULL DEFAULT '20' COMMENT '排序',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT 'url',
  `is_right_data` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启数据权限（0=不1=开启）',
  `right_class_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类名',
  `right_action_name` varchar(100) NOT NULL DEFAULT '' COMMENT 'action名',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建人id',
  `user_name` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人名称',
  `comment` text COMMENT '描述',
  `is_view` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可见（0=不1=可见）',
  `is_update` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可修改（0=不1=可改）',
  `is_log` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否日志（0=不记录1=记录）',
  `is_remove` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可删除(0=不可删除1=可删除)',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（0=不删除1=删除）',
  PRIMARY KEY (`resource_id`),
  KEY `index1` (`app_id`,`is_view`,`is_delete`,`module_sort`,`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=406 DEFAULT CHARSET=utf8 COMMENT='应用模块动作映射表';

/*Data for the table `admin_resources` */

insert  into `admin_resources`(`resource_id`,`app_id`,`app_string`,`module_id`,`module_string`,`module_sort`,`action_string`,`name`,`sort`,`url`,`is_right_data`,`right_class_name`,`right_action_name`,`add_time`,`user_id`,`user_name`,`comment`,`is_view`,`is_update`,`is_log`,`is_remove`,`is_delete`) values (1,1,'admin',0,'resource',1,'','资源管理',20,'',0,'','',0,0,'',NULL,1,0,0,0,0),(2,1,'admin',1,'resource',1,'list.app','应用资源管理',20,'',0,'','',0,0,'',NULL,1,0,0,0,0),(3,1,'admin',1,'resource',1,'list.action','模块动作资源管理',20,'',0,'','',0,0,'',NULL,1,0,0,0,0),(40,1,'admin',28,'right',2,'list.right','权限管理',20,'',0,'','',0,0,'',NULL,1,0,0,0,0),(41,4,'school',0,'job',1,'list','岗位管理',1,'',0,'','',0,0,'',NULL,1,0,0,0,0),(6,1,'admin',28,'role',2,'list','角色管理',2,'',0,'','',0,0,'',NULL,1,0,0,0,0),(8,1,'admin',28,'right',3,'list.user.role.right','用户权限管理',3,'',0,'','',0,0,'',NULL,1,0,0,0,0),(9,1,'admin',28,'role',2,'add.role','录入角色',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(10,1,'admin',28,'role',2,'ajax.show.role.id.list','录入角色获取角色id列表',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(11,1,'admin',28,'role',2,'save.role','保存角色',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(12,1,'admin',1,'resource',1,'add.action','录入模块/动作',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(13,1,'admin',1,'resource',1,'add.action.ok','保存模块/动作',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(14,1,'admin',1,'resource',1,'add.app','录入应用',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(15,1,'admin',1,'resource',1,'add.app.ok','保存应用',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(16,1,'admin',1,'resource',1,'ajax.show.action.sort','录入模块/动作处理排序',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(17,1,'admin',1,'resource',1,'ajax.show.module.data','获取模块',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(18,1,'admin',1,'resource',1,'ajax.sort.action.data','模块/动作列表处理排序',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(19,1,'admin',1,'resource',1,'ajax.update.app.status','更新应用状态',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(20,1,'admin',1,'resource',1,'delete.action','删除模块/动作',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(21,1,'admin',1,'resource',1,'edit.action','修改模块/动作',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(22,1,'admin',1,'resource',1,'edit.action.ok','修改模块/动作操作',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(23,1,'admin',1,'resource',1,'edit.app','修改应用',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(24,1,'admin',1,'resource',1,'edit.app.ok','修改应用操作',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(25,1,'admin',1,'resource',1,'view.action','查看模块/动作',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(26,1,'admin',1,'resource',1,'view.app','查看应用',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(27,1,'admin',1,'resource',1,'delete.app','删除应用',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(28,1,'admin',0,'right',2,'','系统管理',20,'',0,'','',0,0,'',NULL,1,0,0,0,0),(29,1,'admin',28,'right',2,'ajax.get.right.data.by.role.id','通过角色获取权限',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(30,1,'admin',28,'right',2,'ajax.get.role.data.by.user.id','通过用户获取角色',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(31,1,'admin',28,'right',2,'ajax.save.user.role.right','保存用户角色权限',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(32,1,'admin',28,'user',2,'manage','用户操作',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(33,1,'admin',0,'role',3,'','角色管理',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(34,1,'admin',0,'user',4,'','用户管理',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(35,1,'admin',34,'user',4,'edit','编辑用户',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(36,1,'admin',34,'user',4,'list.user.role','用户角色列表',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(37,1,'admin',34,'user',4,'ajax.save.user.role','保存用户角色',20,'',0,'','',0,0,'',NULL,0,0,0,0,0),(39,1,'admin',28,'right',2,'list.user','用户管理',1,'',0,'','',0,0,'',NULL,1,0,0,0,0),(42,4,'school',0,'job',1,'ajax.add','添加岗位-显示',1,'',0,'','',0,0,'',NULL,0,0,0,0,0),(43,4,'school',0,'job',1,'ajax.save','添加岗位-操作',1,'',0,'','',0,0,'',NULL,0,0,0,0,0),(44,4,'school',0,'job',1,'ajax.edit','修改岗位-显示',1,'',0,'','',0,0,'',NULL,0,0,0,0,0),(45,4,'school',0,'job',1,'ajax.update','修改岗位-操作',1,'',0,'','',0,0,'',NULL,0,0,0,0,0),(46,4,'school',0,'job',1,'delete','删除岗位',1,'',0,'','',0,0,'',NULL,0,0,0,0,0),(47,4,'school',0,'subject',2,'list','科目管理',2,'',0,'','',0,0,'',NULL,1,0,0,0,0),(48,4,'school',0,'subject',2,'ajax.add','添加科目-显示',2,'',0,'','',0,0,'',NULL,0,0,0,0,0),(49,4,'school',0,'subject',2,'ajax.save','添加科目-操作',2,'',0,'','',0,0,'',NULL,0,0,0,0,0),(50,4,'school',0,'subject',2,'ajax.edit','修改科目-显示',2,'',0,'','',0,0,'',NULL,0,0,0,0,0),(51,4,'school',0,'subject',2,'ajax.update','修改科目-操作',2,'',0,'','',0,0,'',NULL,0,0,0,0,0),(52,4,'school',0,'subject',2,'delete','删除科目',2,'',0,'','',0,0,'',NULL,0,0,0,0,0),(53,4,'school',0,'teacherattendance',3,'list','教工考勤管理',3,'',0,'','',0,0,'',NULL,1,0,0,0,0),(54,4,'school',0,'teacherattendance',3,'ajax.add','添加教工考勤-显示',3,'',0,'','',0,0,'',NULL,0,0,0,0,0),(55,4,'school',0,'teacherattendance',3,'ajax.save','添加教工考勤-操作',3,'',0,'','',0,0,'',NULL,0,0,0,0,0),(56,4,'school',0,'teacherattendance',3,'ajax.edit','修改教工考勤-显示',3,'',0,'','',0,0,'',NULL,0,0,0,0,0),(57,4,'school',0,'teacherattendance',3,'ajax.update','修改教工考勤-操作',3,'',0,'','',0,0,'',NULL,0,0,0,0,0),(58,4,'school',0,'teacherattendance',3,'delete','删除教工考勤',3,'',0,'','',0,0,'',NULL,0,0,0,0,0),(59,4,'school',0,'teacherdeal',4,'list','教工奖惩管理',4,'',0,'','',0,0,'',NULL,1,0,0,0,0),(60,4,'school',0,'teacherdeal',4,'ajax.add','添加教工奖惩-显示',4,'',0,'','',0,0,'',NULL,0,0,0,0,0),(61,4,'school',0,'teacherdeal',4,'ajax.save','添加教工奖惩-操作',4,'',0,'','',0,0,'',NULL,0,0,0,0,0),(62,4,'school',0,'teacherdeal',4,'ajax.edit','修改教工奖惩-显示',4,'',0,'','',0,0,'',NULL,0,0,0,0,0),(63,4,'school',0,'teacherdeal',4,'ajax.update','修改教工奖惩-操作',4,'',0,'','',0,0,'',NULL,0,0,0,0,0),(64,4,'school',0,'teacherdeal',4,'delete','删除教工奖惩',4,'',0,'','',0,0,'',NULL,0,0,0,0,0),(65,4,'school',0,'teacher',5,'list','教工管理',5,'',0,'','',0,0,'',NULL,1,0,0,0,0),(66,4,'school',0,'teacher',5,'add','添加教工-显示',5,'',0,'','',0,0,'',NULL,0,0,0,0,0),(67,4,'school',0,'teacher',5,'save','添加教工-操作',5,'',0,'','',0,0,'',NULL,0,0,0,0,0),(68,4,'school',0,'teacher',5,'edit','修改教工-显示',5,'',0,'','',0,0,'',NULL,0,0,0,0,0),(69,4,'school',0,'teacher',5,'ajax.upload.photo','修改教工-上传照片',5,'',0,'','',0,0,'',NULL,0,0,0,0,0),(70,4,'school',0,'teacher',5,'update','修改教工-操作',5,'',0,'','',0,0,'',NULL,0,0,0,0,0),(71,4,'school',0,'teacher',5,'delete','删除教工',5,'',0,'','',0,0,'',NULL,0,0,0,0,0),(72,4,'school',0,'teacherattendance',6,'my.list','我的教工考勤管理',6,'',0,'','',0,0,'',NULL,1,0,0,0,0),(73,4,'school',0,'teacherattendance',6,'ajax.add','添加我的教工考勤-显示',6,'',0,'','',0,0,'',NULL,0,0,0,0,0),(74,4,'school',0,'teacherattendance',6,'ajax.save','添加我的教工考勤-操作',6,'',0,'','',0,0,'',NULL,0,0,0,0,0),(75,4,'school',0,'teacherattendance',6,'ajax.edit','修改我的教工考勤-显示',6,'',0,'','',0,0,'',NULL,0,0,0,0,0),(76,4,'school',0,'teacherattendance',6,'ajax.update','修改我的教工考勤-操作',6,'',0,'','',0,0,'',NULL,0,0,0,0,0),(77,4,'school',0,'teacherattendance',6,'delete','删除我的教工考勤',6,'',0,'','',0,0,'',NULL,0,0,0,0,0),(78,4,'school',0,'teacherdeal',7,'my.list','我的教工奖惩管理',7,'',0,'','',0,0,'',NULL,1,0,0,0,0),(79,4,'school',0,'teacherdeal',7,'ajax.add','添加我的教工奖惩-显示',7,'',0,'','',0,0,'',NULL,0,0,0,0,0),(80,4,'school',0,'teacherdeal',7,'ajax.save','添加我的奖惩-操作',7,'',0,'','',0,0,'',NULL,0,0,0,0,0),(81,4,'school',0,'teacherdeal',7,'ajax.edit','修改我的教工奖惩-显示',7,'',0,'','',0,0,'',NULL,0,0,0,0,0),(82,4,'school',0,'teacherdeal',7,'ajax.update','修改我的教工奖惩-操作',7,'',0,'','',0,0,'',NULL,0,0,0,0,0),(83,4,'school',0,'teacherdeal',7,'delete','删除我的教工奖惩',7,'',0,'','',0,0,'',NULL,0,0,0,0,0);

/*Table structure for table `admin_right_resource` */

DROP TABLE IF EXISTS `admin_right_resource`;

CREATE TABLE `admin_right_resource` (
  `right_resource_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限资源编号',
  `right_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限编号',
  `resource_id` int(11) NOT NULL DEFAULT '0' COMMENT '资源编号',
  `app_id` int(11) NOT NULL DEFAULT '0' COMMENT '应用编号',
  `app_string` varchar(50) NOT NULL DEFAULT '' COMMENT '应用字符串',
  `module_id` int(11) NOT NULL DEFAULT '0' COMMENT '模块编号',
  `module_string` varchar(50) NOT NULL DEFAULT '' COMMENT '模块字符串',
  `action_string` varchar(50) NOT NULL DEFAULT '' COMMENT '动作字符串',
  PRIMARY KEY (`right_resource_id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COMMENT='权限资源映射表';

/*Data for the table `admin_right_resource` */

insert  into `admin_right_resource`(`right_resource_id`,`right_id`,`resource_id`,`app_id`,`app_string`,`module_id`,`module_string`,`action_string`) values (1,1,41,4,'school',0,'job','list'),(2,1,42,4,'school',0,'job','ajax.add'),(3,1,43,4,'school',0,'job','ajax.save'),(4,1,44,4,'school',0,'job','ajax.edit'),(5,1,45,4,'school',0,'job','ajax.update'),(6,1,46,4,'school',0,'job','delete'),(7,1,47,4,'school',0,'subject','list'),(8,1,48,4,'school',0,'subject','ajax.add'),(9,1,49,4,'school',0,'subject','ajax.save'),(10,1,50,4,'school',0,'subject','ajax.edit'),(11,1,51,4,'school',0,'subject','ajax.update'),(12,1,52,4,'school',0,'subject','delete'),(13,1,53,4,'school',0,'teacherattendance','list'),(14,1,54,4,'school',0,'teacherattendance','ajax.add'),(15,1,55,4,'school',0,'teacherattendance','ajax.save'),(16,1,56,4,'school',0,'teacherattendance','ajax.edit'),(17,1,57,4,'school',0,'teacherattendance','ajax.update'),(18,1,58,4,'school',0,'teacherattendance','delete'),(19,1,59,4,'school',0,'teacherdeal','list'),(20,1,60,4,'school',0,'teacherdeal','ajax.add'),(21,1,61,4,'school',0,'teacherdeal','ajax.save'),(22,1,62,4,'school',0,'teacherdeal','ajax.edit'),(23,1,63,4,'school',0,'teacherdeal','ajax.update'),(24,1,64,4,'school',0,'teacherdeal','delete'),(25,1,65,4,'school',0,'teacher','list'),(26,1,66,4,'school',0,'teacher','add'),(27,1,67,4,'school',0,'teacher','save'),(28,1,68,4,'school',0,'teacher','edit'),(29,1,69,4,'school',0,'teacher','ajax.upload.photo'),(30,1,70,4,'school',0,'teacher','update'),(31,1,71,4,'school',0,'teacher','delete'),(32,7,41,4,'school',0,'job','list'),(33,7,42,4,'school',0,'job','ajax.add'),(34,7,43,4,'school',0,'job','ajax.save'),(35,7,44,4,'school',0,'job','ajax.edit'),(36,7,45,4,'school',0,'job','ajax.update'),(37,7,46,4,'school',0,'job','delete'),(38,7,53,4,'school',0,'teacherattendance','list'),(39,7,54,4,'school',0,'teacherattendance','ajax.add'),(40,7,55,4,'school',0,'teacherattendance','ajax.save'),(41,7,56,4,'school',0,'teacherattendance','ajax.edit'),(42,7,57,4,'school',0,'teacherattendance','ajax.update'),(43,7,58,4,'school',0,'teacherattendance','delete'),(44,7,59,4,'school',0,'teacherdeal','list'),(45,7,60,4,'school',0,'teacherdeal','ajax.add'),(46,7,61,4,'school',0,'teacherdeal','ajax.save'),(47,7,62,4,'school',0,'teacherdeal','ajax.edit'),(48,7,63,4,'school',0,'teacherdeal','ajax.update'),(49,7,64,4,'school',0,'teacherdeal','delete'),(50,7,65,4,'school',0,'teacher','list'),(51,7,66,4,'school',0,'teacher','add'),(52,7,67,4,'school',0,'teacher','save'),(53,7,68,4,'school',0,'teacher','edit'),(54,7,69,4,'school',0,'teacher','ajax.upload.photo'),(55,7,70,4,'school',0,'teacher','update'),(56,7,71,4,'school',0,'teacher','delete'),(57,8,65,4,'school',0,'teacher','list');

/*Table structure for table `admin_rights` */

DROP TABLE IF EXISTS `admin_rights`;

CREATE TABLE `admin_rights` (
  `right_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限编号',
  `right_name` varchar(50) NOT NULL DEFAULT '' COMMENT '权限名称',
  `comments` text COMMENT '备注',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-不删1-删除）',
  PRIMARY KEY (`right_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='权限表';

/*Data for the table `admin_rights` */

insert  into `admin_rights`(`right_id`,`right_name`,`comments`,`is_delete`) values (1,'教工管理所有权限','教工管理所有权限',0),(2,'学生管理所有权限','学生管理所有权限',0),(3,'班级管理所有权限','班级管理所有权限',0),(4,'特长班管理所有权限','特长班管理所有权限',0),(5,'短信管理所有权限','短信管理所有权限',0),(6,'收费管理所有权限','收费管理所有权限',0),(7,'教工管理所有权限（不含教学分配、教学科目维护）','教工管理所有权限（不含教学分配、教学科目维护）',0),(8,'教师查询','教师查询',0),(9,'学生查询','学生查询',0),(10,'班级查询','班级查询',0),(11,'特长班查询','特长班查询',0),(12,'收费查询','收费查询',0),(13,'短信查询','短信查询',0);

/*Table structure for table `admin_role_right` */

DROP TABLE IF EXISTS `admin_role_right`;

CREATE TABLE `admin_role_right` (
  `role_right_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '映射编号',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色编号',
  `right_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限编号',
  PRIMARY KEY (`role_right_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='角色权限表';

/*Data for the table `admin_role_right` */

insert  into `admin_role_right`(`role_right_id`,`role_id`,`right_id`) values (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,2,6),(7,3,7),(8,3,2),(9,4,8),(10,4,9),(11,4,10),(12,4,11),(13,4,12),(14,4,13);

/*Table structure for table `admin_roles` */

DROP TABLE IF EXISTS `admin_roles`;

CREATE TABLE `admin_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色编号',
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  `comments` text NOT NULL COMMENT '角色描述',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除[1-是0-否]',
  PRIMARY KEY (`role_id`),
  KEY `index1` (`role_id`,`role_name`,`is_delete`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='角色表';

/*Data for the table `admin_roles` */

insert  into `admin_roles`(`role_id`,`role_name`,`comments`,`is_delete`) values (1,'教务管理员','教务管理员',0),(2,'财务管理员','财务管理员',0),(3,'行政管理员','行政管理员',0),(4,'教师员工','教师员工',0);

/*Table structure for table `admin_supper_user` */

DROP TABLE IF EXISTS `admin_supper_user`;

CREATE TABLE `admin_supper_user` (
  `supper_user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '超级管理编号',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户编号',
  PRIMARY KEY (`supper_user_id`),
  KEY `index1` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='超级用户表';

/*Data for the table `admin_supper_user` */

insert  into `admin_supper_user`(`supper_user_id`,`user_id`) values (1,1);

/*Table structure for table `admin_user_role` */

DROP TABLE IF EXISTS `admin_user_role`;

CREATE TABLE `admin_user_role` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '映射编号',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户编号',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色编号',
  PRIMARY KEY (`user_role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户角色表';

/*Data for the table `admin_user_role` */

insert  into `admin_user_role`(`user_role_id`,`user_id`,`role_id`) values (1,2,1),(3,3,4);

/*Table structure for table `admin_user_role_right` */

DROP TABLE IF EXISTS `admin_user_role_right`;

CREATE TABLE `admin_user_role_right` (
  `user_role_right_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户编号',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色编号',
  `right_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限编号',
  PRIMARY KEY (`user_role_right_id`),
  KEY `index1` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `admin_user_role_right` */

insert  into `admin_user_role_right`(`user_role_right_id`,`user_id`,`role_id`,`right_id`) values (10,3,4,8),(8,2,1,1),(9,2,1,2),(4,2,1,3),(5,2,1,4),(6,2,1,5);

/*Table structure for table `admin_user_type` */

DROP TABLE IF EXISTS `admin_user_type`;

CREATE TABLE `admin_user_type` (
  `user_type_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '教工类别编号',
  `type_number` int(1) unsigned zerofill NOT NULL DEFAULT '0' COMMENT '教工类别编码',
  `type_name` varchar(50) NOT NULL DEFAULT '' COMMENT '教工类别名称',
  `comments` text COMMENT '描述',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-否1-是）',
  PRIMARY KEY (`user_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='人员类别表';

/*Data for the table `admin_user_type` */

insert  into `admin_user_type`(`user_type_id`,`type_number`,`type_name`,`comments`,`is_delete`) values (1,1,'校长',NULL,0),(2,2,'教师',NULL,0),(3,3,'学生',NULL,0),(4,4,'厨师',NULL,0),(5,5,'司机',NULL,0),(6,6,'保育员',NULL,0),(7,7,'家长',NULL,0),(8,8,'保安',NULL,0),(9,9,'保洁员',NULL,0);

/*Table structure for table `admin_users` */

DROP TABLE IF EXISTS `admin_users`;

CREATE TABLE `admin_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `user_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-后台添加1/2-教工转3-学生转7-家长转',
  `user_name` varchar(64) NOT NULL COMMENT '用户名',
  `real_name` varchar(64) NOT NULL COMMENT '昵称',
  `user_pass` varchar(32) NOT NULL COMMENT '密码',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态[1=已激活2-未激活3-已冻结4-已删除]',
  `ip` varchar(255) NOT NULL DEFAULT '*' COMMENT 'IP（多个IP以逗号隔开）',
  `is_config` tinyint(1) NOT NULL DEFAULT '0' COMMENT '配置（0-默认后台增加1-教工转成2-学生转成3-家长转成）',
  `login_time` int(11) NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `logout_time` int(11) NOT NULL DEFAULT '0' COMMENT '上次登出时间',
  `login_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '登录状态(0-未登录1-已登录)',
  `add_time_int` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `index3` (`user_name`),
  KEY `index1` (`user_id`,`login_status`),
  KEY `index2` (`user_name`,`user_pass`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';

/*Data for the table `admin_users` */

insert  into `admin_users`(`user_id`,`user_type`,`user_name`,`real_name`,`user_pass`,`status`,`ip`,`is_config`,`login_time`,`logout_time`,`login_status`,`add_time_int`) values (1,0,'admin','最高级管理员','e10adc3949ba59abbe56e057f20f883e',1,'*',0,1406125871,1406125916,0,0),(2,0,'zhangtuanzhou','张团周','e10adc3949ba59abbe56e057f20f883e',1,'*',0,1406125848,1406125866,0,0),(3,0,'wutao','吴涛','e10adc3949ba59abbe56e057f20f883e',1,'*',0,1406125922,1406125841,1,0);

/*Table structure for table `sch_classes` */

DROP TABLE IF EXISTS `sch_classes`;

CREATE TABLE `sch_classes` (
  `class_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '班级编号',
  `sch_teacher_id` int(9) NOT NULL DEFAULT '0' COMMENT '班主任（授课教师）编号',
  `sch_teacher_no` int(8) unsigned zerofill NOT NULL DEFAULT '00000000' COMMENT '教师工号',
  `sch_teacher_name` varchar(64) DEFAULT '' COMMENT '教师名称',
  `class_number` int(3) unsigned zerofill NOT NULL DEFAULT '000' COMMENT '班级编码',
  `property` tinyint(1) NOT NULL DEFAULT '0' COMMENT '属性（0-普通班1-特长班）',
  `class_no` int(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '班号',
  `class_name` varchar(30) NOT NULL DEFAULT '' COMMENT '班级名称',
  `amount` int(4) NOT NULL DEFAULT '0' COMMENT '人数',
  `class_minute` int(2) DEFAULT '0' COMMENT '课时（分）',
  `class_address` varchar(100) NOT NULL DEFAULT '' COMMENT '上课地址',
  `class_time` datetime DEFAULT NULL COMMENT '上课时间',
  `open_date` date DEFAULT NULL COMMENT '开班日期',
  `comments` text COMMENT '描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0-未激活1-激活2-合并3-撤销4-升级）',
  `add_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '录入人ID',
  `add_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '修改人ID',
  `update_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-否1-是）',
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='班级表';

/*Data for the table `sch_classes` */

insert  into `sch_classes`(`class_id`,`sch_teacher_id`,`sch_teacher_no`,`sch_teacher_name`,`class_number`,`property`,`class_no`,`class_name`,`amount`,`class_minute`,`class_address`,`class_time`,`open_date`,`comments`,`status`,`add_user_id`,`add_time_int`,`update_user_id`,`update_time_int`,`is_delete`) values (1,0,00000000,'',001,0,01,'test',50,120,'北京','2014-08-04 18:04:00','2014-08-05','test',1,1,1407665056,0,0,0),(2,0,00000000,'',102,1,02,'test1',1,11,'1','2014-08-12 18:54:00','2014-08-05','tret',1,1,1407668055,0,0,0);

/*Table structure for table `sch_job` */

DROP TABLE IF EXISTS `sch_job`;

CREATE TABLE `sch_job` (
  `job_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '岗位编号',
  `job_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '级别（0-无1-初级2-中级3-高级）',
  `job_name` varchar(50) NOT NULL DEFAULT '' COMMENT '岗位名称',
  `comments` text COMMENT '描述',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-否1-是）',
  PRIMARY KEY (`job_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='岗位表';

/*Data for the table `sch_job` */

insert  into `sch_job`(`job_id`,`job_level`,`job_name`,`comments`,`is_delete`) values (1,0,'专任教师',NULL,0),(2,0,'职员','',0),(3,0,'教辅人员','',0),(4,0,'工勤人员','',1);

/*Table structure for table `sch_message_list` */

DROP TABLE IF EXISTS `sch_message_list`;

CREATE TABLE `sch_message_list` (
  `message_list_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '短信明细编号',
  `message_send_id` int(9) NOT NULL DEFAULT '0' COMMENT '短信发送编号',
  `receive_mobile_phone` varchar(20) NOT NULL DEFAULT '' COMMENT '接收人手机号',
  `send_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '投递状态（0-已投递1-投递成功2-投递失败）',
  `send_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '投递时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-不删除1-删除）',
  PRIMARY KEY (`message_list_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信明细表';

/*Data for the table `sch_message_list` */

/*Table structure for table `sch_message_send` */

DROP TABLE IF EXISTS `sch_message_send`;

CREATE TABLE `sch_message_send` (
  `message_send_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '短信发送编号',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型（0-系统1-学生（家长）2-教师）',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `contents` varchar(2000) NOT NULL DEFAULT '' COMMENT '短信内容',
  `receive_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '接收人类型（0-单体1-班级）',
  `receive_class_id` int(9) NOT NULL DEFAULT '0' COMMENT '接收人班级',
  `receive_user_ids` varchar(2000) NOT NULL DEFAULT '' COMMENT '接收人编号（多个请以逗号隔开）',
  `receive_user_names` varchar(2000) NOT NULL DEFAULT '' COMMENT '接收人名称（多个请以逗号隔开）',
  `receive_mobile_phones` varchar(2000) NOT NULL DEFAULT '' COMMENT '接收人手机号（多个请以逗号隔开）',
  `send_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '发送人编号',
  `send_user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '发送人名称',
  `send_time_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发送时间类型（0-立即发送1-定时发送）',
  `send_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '定时发送时间',
  `send_result` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发送结果（0-未发送1-已发送）',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-不删除1-删除）',
  PRIMARY KEY (`message_send_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信发送表';

/*Data for the table `sch_message_send` */

/*Table structure for table `sch_money_config` */

DROP TABLE IF EXISTS `sch_money_config`;

CREATE TABLE `sch_money_config` (
  `money_config_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '费用配置编号',
  `sch_class_id` int(9) NOT NULL DEFAULT '0' COMMENT '班级编号',
  `sch_term_id` int(9) NOT NULL DEFAULT '0' COMMENT '学期编号 ',
  `month` int(2) NOT NULL DEFAULT '0' COMMENT '月份',
  `sch_money_project_id` int(9) NOT NULL DEFAULT '0' COMMENT '收费项目编号',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '收费金额',
  `comments` text COMMENT '收费说明',
  `add_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '记录人ID',
  `add_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '记录时间',
  `update_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '修改人ID',
  `update_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-不删除1-删除）',
  PRIMARY KEY (`money_config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='费用配置表';

/*Data for the table `sch_money_config` */

/*Table structure for table `sch_money_data` */

DROP TABLE IF EXISTS `sch_money_data`;

CREATE TABLE `sch_money_data` (
  `money_data_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '幼儿园费用编号',
  `money_number` int(15) unsigned zerofill NOT NULL DEFAULT '000000000000000' COMMENT '费用单号（日期+学校号二位+班级号二位+流水号三位）',
  `money_date` date DEFAULT NULL COMMENT '费用日期',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '费用类型（0-收入1-支出）',
  `money_name` varchar(100) NOT NULL DEFAULT '' COMMENT '费用名称',
  `sch_money_project_id` int(9) NOT NULL DEFAULT '0' COMMENT '费用项目编号',
  `sch_money_project_name` int(9) NOT NULL DEFAULT '0' COMMENT '费用项目名称',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '应交金额',
  `realy_money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '实际交金额',
  `comments` text COMMENT '说明',
  `add_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '录入人编号',
  `add_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '修改人编号',
  `update_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-不删除1-已删除）',
  PRIMARY KEY (`money_data_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='幼儿园费用表';

/*Data for the table `sch_money_data` */

/*Table structure for table `sch_money_projects` */

DROP TABLE IF EXISTS `sch_money_projects`;

CREATE TABLE `sch_money_projects` (
  `money_project_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '收费项目编号',
  `money_project_name` varchar(50) NOT NULL DEFAULT '' COMMENT '收费项目名称',
  `comments` text COMMENT '描述',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-不删除1-不删除）',
  PRIMARY KEY (`money_project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='费用项目表';

/*Data for the table `sch_money_projects` */

/*Table structure for table `sch_parents` */

DROP TABLE IF EXISTS `sch_parents`;

CREATE TABLE `sch_parents` (
  `parent_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '家长编号',
  `sch_student_id` int(9) NOT NULL DEFAULT '0' COMMENT '学生编号',
  `en_name` varchar(50) NOT NULL DEFAULT '' COMMENT '英文名字',
  `cn_name` varchar(50) NOT NULL DEFAULT '' COMMENT '中文名字',
  `parent_no` int(3) unsigned zerofill NOT NULL DEFAULT '000' COMMENT '登录号（流水号）',
  `parent_named` tinyint(1) NOT NULL DEFAULT '0' COMMENT '称谓（0-无1-爸爸2-妈妈3-爷爷4-奶奶5-外公6-外婆7-姑姑8-姑父）',
  `phone` varchar(50) NOT NULL DEFAULT '' COMMENT '联系电话',
  `mobile_phone` varchar(30) NOT NULL DEFAULT '' COMMENT '联系手机',
  `is_message` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否优先短信联系（0-否1-是）',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-否1-是）',
  PRIMARY KEY (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='家长表';

/*Data for the table `sch_parents` */

insert  into `sch_parents`(`parent_id`,`sch_student_id`,`en_name`,`cn_name`,`parent_no`,`parent_named`,`phone`,`mobile_phone`,`is_message`,`is_delete`) values (1,1,'wutao','吴涛',000,1,'','123123123',1,0),(2,1,'','',000,1,'','',0,0),(3,1,'','',000,1,'','',0,0),(4,1,'','',000,1,'','',0,0);

/*Table structure for table `sch_school_info` */

DROP TABLE IF EXISTS `sch_school_info`;

CREATE TABLE `sch_school_info` (
  `school_info_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '详细编号',
  `school_id` int(9) NOT NULL DEFAULT '0' COMMENT '学校编号',
  `school_no` int(2) NOT NULL DEFAULT '0' COMMENT '学校代码（学校号）',
  `school_name` varchar(100) DEFAULT '' COMMENT '学校名称',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型（0-无1-公立2-私立）',
  `address` varchar(1200) NOT NULL DEFAULT '' COMMENT '学校地址',
  `logo_pic` varchar(20) NOT NULL DEFAULT '' COMMENT '学校LOGO图片',
  `phone` varchar(100) NOT NULL DEFAULT '' COMMENT '联系电话（多个请以逗号隔开）',
  `fax_phone` varchar(20) NOT NULL DEFAULT '' COMMENT '传真',
  `website` varchar(100) NOT NULL DEFAULT '' COMMENT '网站',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '联系邮箱',
  `found_date` date DEFAULT NULL COMMENT '创立时间（建校日期）',
  `found_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '创建人ID（园长ID）',
  `comments` text COMMENT '学校简介',
  `add_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '录入人ID',
  `add_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '修改人ID',
  `update_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-否1-是）',
  PRIMARY KEY (`school_info_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='幼儿园详细表';

/*Data for the table `sch_school_info` */

/*Table structure for table `sch_specialclass_student` */

DROP TABLE IF EXISTS `sch_specialclass_student`;

CREATE TABLE `sch_specialclass_student` (
  `sepcialclass_student_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '班级与学生映射编号',
  `sch_class_id` int(9) DEFAULT NULL COMMENT '班级编号',
  `student_id` int(9) DEFAULT NULL COMMENT '学生编号',
  PRIMARY KEY (`sepcialclass_student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='特长班与学生映射表';

/*Data for the table `sch_specialclass_student` */

/*Table structure for table `sch_student_attendance` */

DROP TABLE IF EXISTS `sch_student_attendance`;

CREATE TABLE `sch_student_attendance` (
  `student_attendance_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '考勤编号',
  `sch_student_id` int(9) NOT NULL DEFAULT '0' COMMENT '学生编号',
  `sch_student_no` int(3) NOT NULL DEFAULT '0' COMMENT '登录号',
  `sch_student_name` varchar(30) NOT NULL DEFAULT '' COMMENT '学生名称',
  `come_time` datetime DEFAULT NULL COMMENT '到校时间',
  `leave_time` datetime DEFAULT NULL COMMENT '离校时间',
  `reason` text COMMENT '缺勤事由',
  `attendance_date` date DEFAULT NULL COMMENT '考勤日期（统计使用）',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-否1-是）',
  PRIMARY KEY (`student_attendance_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='学生考勤表';

/*Data for the table `sch_student_attendance` */

/*Table structure for table `sch_student_deal_data` */

DROP TABLE IF EXISTS `sch_student_deal_data`;

CREATE TABLE `sch_student_deal_data` (
  `student_deal_data_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '奖惩编号',
  `sch_student_id` int(9) NOT NULL DEFAULT '0' COMMENT '学生编号',
  `sch_student_no` int(3) unsigned zerofill NOT NULL DEFAULT '000' COMMENT '登录号',
  `sch_student_name` varchar(30) NOT NULL DEFAULT '' COMMENT '学生中文名称',
  `deal_date` date DEFAULT NULL COMMENT '处理日期',
  `type_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '处理类型（1-奖励2-处罚）',
  `deal_name` varchar(50) NOT NULL DEFAULT '' COMMENT '处理名称',
  `deal_reason` text COMMENT '处理是由',
  `deal_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `deal_real_name` varchar(64) NOT NULL DEFAULT '' COMMENT '处理人名称',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-否1-是）',
  PRIMARY KEY (`student_deal_data_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='学生奖惩表';

/*Data for the table `sch_student_deal_data` */

insert  into `sch_student_deal_data`(`student_deal_data_id`,`sch_student_id`,`sch_student_no`,`sch_student_name`,`deal_date`,`type_id`,`deal_name`,`deal_reason`,`deal_user_id`,`deal_real_name`,`is_delete`) values (1,1,001,'吴涛','2014-08-05',1,'test','test',1,'最高级管理员',0);

/*Table structure for table `sch_student_money_data` */

DROP TABLE IF EXISTS `sch_student_money_data`;

CREATE TABLE `sch_student_money_data` (
  `student_money_data_id` int(9) NOT NULL COMMENT '学生费用编号',
  `sch_money_data_id` int(9) NOT NULL DEFAULT '0' COMMENT '幼儿园费用编号',
  `sch_class_id` int(9) NOT NULL DEFAULT '0' COMMENT '班级编号',
  `sch_class_no` int(2) NOT NULL DEFAULT '0' COMMENT '班号',
  `sch_class_name` varchar(50) NOT NULL DEFAULT '' COMMENT '班级名称',
  `sch_term_id` int(9) NOT NULL DEFAULT '0' COMMENT '学期编号',
  `sch_term_name` varchar(50) NOT NULL DEFAULT '' COMMENT '学期名称',
  `sch_student_id` int(9) NOT NULL DEFAULT '0' COMMENT '学生编号',
  `sch_student_no` int(2) NOT NULL DEFAULT '0' COMMENT '学生学号',
  `sch_student_name` varchar(50) NOT NULL DEFAULT '' COMMENT '学生名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '缴费状态（0-未缴费1-已缴费）',
  `comments` text COMMENT '说明',
  `add_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '录入人编号',
  `add_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '修改人编号',
  `update_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-不删除1-已删除）',
  PRIMARY KEY (`student_money_data_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='学生费用记录表';

/*Data for the table `sch_student_money_data` */

/*Table structure for table `sch_students` */

DROP TABLE IF EXISTS `sch_students`;

CREATE TABLE `sch_students` (
  `student_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '学生编号',
  `sch_class_id` int(9) NOT NULL DEFAULT '0' COMMENT '班级编号',
  `en_name` varchar(50) NOT NULL DEFAULT '' COMMENT '英文名字',
  `cn_name` varchar(50) NOT NULL DEFAULT '' COMMENT '中文名字',
  `student_no` int(3) unsigned zerofill NOT NULL DEFAULT '000' COMMENT '学号',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别（0-无1-男2-女）',
  `birthday` date DEFAULT NULL COMMENT '出生日期',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '住址',
  `id_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '证件类型(0-其他1-身份证2-临时身份证3-护照4-军人证5-驾驶证)',
  `id_number` varchar(30) NOT NULL DEFAULT '' COMMENT '证件号码',
  `photo_name` varchar(50) NOT NULL DEFAULT '' COMMENT '照片',
  `entrance_date` date DEFAULT NULL COMMENT '入学日期',
  `graduate_date` date DEFAULT NULL COMMENT '毕业日期',
  `school_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '学籍状态（0-在读1-毕业）',
  `add_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '添加人编号',
  `add_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '修改人编号',
  `update_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-否1-是）',
  PRIMARY KEY (`student_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='学生表';

/*Data for the table `sch_students` */

insert  into `sch_students`(`student_id`,`sch_class_id`,`en_name`,`cn_name`,`student_no`,`sex`,`birthday`,`address`,`id_type`,`id_number`,`photo_name`,`entrance_date`,`graduate_date`,`school_status`,`add_user_id`,`add_time_int`,`update_user_id`,`update_time_int`,`is_delete`) values (1,1,'test','吴涛',001,0,'2014-08-05','北京',0,'123123123','1.jpg','0000-00-00','0000-00-00',0,0,1407316411,1,1407390352,0);

/*Table structure for table `sch_subjects` */

DROP TABLE IF EXISTS `sch_subjects`;

CREATE TABLE `sch_subjects` (
  `subject_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '科目编号',
  `type_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '科目类别（0-无1-文科2-理科3-兴趣科）',
  `class_id` int(9) NOT NULL DEFAULT '0' COMMENT '班级编号',
  `class_name` varchar(30) NOT NULL DEFAULT '' COMMENT '班级名称',
  `subject_name` varchar(30) NOT NULL COMMENT '科目名称',
  `comments` text COMMENT '描述',
  `add_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '添加人',
  `add_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-否1-是）',
  PRIMARY KEY (`subject_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='科目表（语文/数学等）';

/*Data for the table `sch_subjects` */

/*Table structure for table `sch_teacher_attendance` */

DROP TABLE IF EXISTS `sch_teacher_attendance`;

CREATE TABLE `sch_teacher_attendance` (
  `teacher_attendance_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '考勤编号',
  `teacher_id` int(9) NOT NULL DEFAULT '0' COMMENT '教工编号',
  `teacher_no` int(3) unsigned zerofill NOT NULL DEFAULT '000' COMMENT '教工工号',
  `teacher_name` varchar(30) NOT NULL DEFAULT '' COMMENT '教工中文名',
  `come_time` datetime DEFAULT NULL COMMENT '到校时间',
  `leave_time` datetime DEFAULT NULL COMMENT '离校时间',
  `reason` text COMMENT '缺勤事由',
  `attendance_date` date DEFAULT NULL COMMENT '考勤日期（统计使用）',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-否1-是）',
  PRIMARY KEY (`teacher_attendance_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='教工考勤表';

/*Data for the table `sch_teacher_attendance` */

/*Table structure for table `sch_teacher_deal_data` */

DROP TABLE IF EXISTS `sch_teacher_deal_data`;

CREATE TABLE `sch_teacher_deal_data` (
  `teacher_deal_data_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '奖惩编号',
  `teacher_id` int(9) NOT NULL DEFAULT '0' COMMENT '教工编号',
  `teacher_no` int(3) unsigned zerofill NOT NULL DEFAULT '000' COMMENT '教工工号',
  `teacher_name` varchar(30) NOT NULL DEFAULT '' COMMENT '教工中文名',
  `deal_date` date DEFAULT NULL COMMENT '处理日期',
  `type_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '处理类型（1-奖励2-处罚）',
  `deal_name` varchar(50) NOT NULL DEFAULT '' COMMENT '处理名称',
  `deal_reason` text COMMENT '处理是由',
  `deal_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `deal_real_name` varchar(64) NOT NULL DEFAULT '' COMMENT '处理人名称',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-否1-是）',
  PRIMARY KEY (`teacher_deal_data_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='教工奖惩表';

/*Data for the table `sch_teacher_deal_data` */

/*Table structure for table `sch_teacher_money_data` */

DROP TABLE IF EXISTS `sch_teacher_money_data`;

CREATE TABLE `sch_teacher_money_data` (
  `teacher_money_data_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '教师工资记录编号',
  `sch_money_data_id` int(9) NOT NULL DEFAULT '0' COMMENT '幼儿园费用编号',
  `sch_class_id` int(9) NOT NULL DEFAULT '0' COMMENT '班级编号',
  `sch_class_no` int(2) NOT NULL DEFAULT '0' COMMENT '班号',
  `sch_class_name` varchar(50) NOT NULL DEFAULT '' COMMENT '班级名称',
  `sch_term_id` int(9) NOT NULL DEFAULT '0' COMMENT '学期编号',
  `sch_term_name` varchar(50) NOT NULL DEFAULT '' COMMENT '学期名称',
  `sch_teacher_id` int(9) NOT NULL DEFAULT '0' COMMENT '教师编号',
  `sch_teacher_no` int(2) NOT NULL DEFAULT '0' COMMENT '教师工号',
  `sch_teacher_name` varchar(50) NOT NULL DEFAULT '' COMMENT '教师名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '缴费状态（0-未缴费1-已缴费）',
  `comments` text COMMENT '说明',
  `add_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '录入人编号',
  `add_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '修改人编号',
  `update_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-不删除1-已删除）',
  PRIMARY KEY (`teacher_money_data_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='教师费用记录表';

/*Data for the table `sch_teacher_money_data` */

/*Table structure for table `sch_teachers` */

DROP TABLE IF EXISTS `sch_teachers`;

CREATE TABLE `sch_teachers` (
  `teacher_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '教工编号',
  `school_class_id` int(9) NOT NULL DEFAULT '0' COMMENT '班级编号',
  `school_teacher_type_id` int(9) NOT NULL DEFAULT '0' COMMENT '教工类别编号',
  `school_job_id` int(9) NOT NULL DEFAULT '0' COMMENT '岗位编号',
  `en_name` varchar(50) NOT NULL DEFAULT '' COMMENT '英文名字',
  `cn_name` varchar(50) NOT NULL DEFAULT '' COMMENT '中文名字',
  `teacher_no` int(3) unsigned zerofill NOT NULL DEFAULT '000' COMMENT '工号（登录使用，取自增编号值）',
  `teacher_number` int(15) unsigned zerofill NOT NULL DEFAULT '000000000000000' COMMENT '教工编码（学校+属性+工号校验）',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别（0-无1-男2-女）',
  `birthday` date DEFAULT NULL COMMENT '出生日期',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '住址',
  `id_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '证件类型（0-其他1-身份证2-临时身份证3-护照4-军人证5-驾驶证）',
  `id_number` varchar(50) NOT NULL DEFAULT '' COMMENT '证件号码',
  `phone` varchar(30) NOT NULL DEFAULT '' COMMENT '联系电话',
  `mobile_phone` varchar(20) NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `photo_name` varchar(50) DEFAULT '' COMMENT '照片',
  `job_date` date DEFAULT NULL COMMENT '入职日期',
  `bargain_start_date` date DEFAULT NULL COMMENT '签订合同上一次生效起始日期',
  `bargain_end_date` date DEFAULT NULL COMMENT '签订合同上一次生效结束日期',
  `bargain_count` tinyint(1) NOT NULL DEFAULT '0' COMMENT '签订合同次数',
  `leave_date` date DEFAULT NULL COMMENT '离职日期',
  `leave_reason` text COMMENT '离职原因',
  `graduate_school` varchar(100) NOT NULL DEFAULT '' COMMENT '毕业院校',
  `graduate_date` date DEFAULT NULL COMMENT '毕业日期',
  `graduate_specialty` varchar(50) NOT NULL DEFAULT '' COMMENT '毕业专业',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（0-未激活1-激活2-离职）',
  `max_education` tinyint(1) NOT NULL DEFAULT '0' COMMENT '最高学历（0-无1-大专2-本科3-重点4-研究生5-硕士6-博士7-博士后）',
  `add_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '录入人ID',
  `add_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_user_id` int(9) NOT NULL DEFAULT '0' COMMENT '修改人ID',
  `update_time_int` int(9) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-否1-是）',
  PRIMARY KEY (`teacher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='教工表';

/*Data for the table `sch_teachers` */

/*Table structure for table `sch_term_config` */

DROP TABLE IF EXISTS `sch_term_config`;

CREATE TABLE `sch_term_config` (
  `term_id` int(9) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `year` int(2) NOT NULL DEFAULT '0' COMMENT '学年',
  `term_name` varchar(50) NOT NULL DEFAULT '' COMMENT '学期名称',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '学期类型（0-无1-春季学期2-夏季学期3-秋季学期4-其他）',
  `start_date` date DEFAULT NULL COMMENT '开始时间',
  `end_date` date DEFAULT NULL COMMENT '结束时间',
  `comments` text COMMENT '描述',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-不删除1-删除）',
  PRIMARY KEY (`term_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='学期配置表';

/*Data for the table `sch_term_config` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
