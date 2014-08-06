# 地域表
DROP TABLE IF EXISTS `admin_areas`;
CREATE TABLE `admin_areas` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '地域编号',
  `area_number` varchar(20) NOT NULL DEFAULT '' COMMENT '地域编码',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父类编号（默认为0）',
  `area_name` varchar(50) NOT NULL DEFAULT '' COMMENT '地域名称',
  `comments` text COMMENT '备注',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0-不删除1-删除）',
  PRIMARY KEY (`area_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='地域表'

# 部门/组别表
DROP TABLE IF EXISTS `admin_groups`;
CREATE TABLE `admin_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '组别编号',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父类编号',
  `group_number` varchar(20) NOT NULL DEFAULT '' COMMENT '组别编码',
  `group_name` varchar(40) NOT NULL DEFAULT '' COMMENT '组别名称',
  `comments` text NOT NULL COMMENT '描述',
  `is_delete` tinyint(1) NOT NULL DEFAULT '2' COMMENT '删除[1-是2-否]',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='组表'


# 合同相关数据结构
# 资源表
insert into `admin_resources` (`app_id`, `app_string`, `module_id`, `module_string`, `module_sort`, `action_string`, `name`, `sort`, `url`, `is_right_data`, `right_class_name`, `right_action_name`, `add_time`, `user_id`, `user_name`, `comment`, `is_view`, `is_update`, `is_log`, `is_remove`, `is_delete`) values('3','erp','0','bargain','20','','合同管理','20','','0','','','1385344061','1','admin','','1','1','0','1','2');
insert into `admin_resources` (`app_id`, `app_string`, `module_id`, `module_string`, `module_sort`, `action_string`, `name`, `sort`, `url`, `is_right_data`, `right_class_name`, `right_action_name`, `add_time`, `user_id`, `user_name`, `comment`, `is_view`, `is_update`, `is_log`, `is_remove`, `is_delete`) values('3','erp','126','bargain','20','add.sale.base','录入销售合同','21','','0','','','1385344406','1','admin','','1','1','0','1','1');
insert into `admin_resources` (`app_id`, `app_string`, `module_id`, `module_string`, `module_sort`, `action_string`, `name`, `sort`, `url`, `is_right_data`, `right_class_name`, `right_action_name`, `add_time`, `user_id`, `user_name`, `comment`, `is_view`, `is_update`, `is_log`, `is_remove`, `is_delete`) values('3','erp','126','bargain','20','list.sale','销售合同管理','21','','0','','','1385429411','1','admin','销售合同管理','1','1','0','1','2');
insert into `admin_resources` (`app_id`, `app_string`, `module_id`, `module_string`, `module_sort`, `action_string`, `name`, `sort`, `url`, `is_right_data`, `right_class_name`, `right_action_name`, `add_time`, `user_id`, `user_name`, `comment`, `is_view`, `is_update`, `is_log`, `is_remove`, `is_delete`) values('3','erp','126','bargain','20','list.purchase','采购合同管理','21','','0','','','1385429437','1','admin','采购合同管理','1','1','0','1','2');
insert into `admin_resources` (`app_id`, `app_string`, `module_id`, `module_string`, `module_sort`, `action_string`, `name`, `sort`, `url`, `is_right_data`, `right_class_name`, `right_action_name`, `add_time`, `user_id`, `user_name`, `comment`, `is_view`, `is_update`, `is_log`, `is_remove`, `is_delete`) values('3','erp','126','bargain','20','list.transport','运输合同管理','21','','0','','','1385429471','1','admin','运输合同管理','1','1','0','1','2');
insert into `admin_resources` (`app_id`, `app_string`, `module_id`, `module_string`, `module_sort`, `action_string`, `name`, `sort`, `url`, `is_right_data`, `right_class_name`, `right_action_name`, `add_time`, `user_id`, `user_name`, `comment`, `is_view`, `is_update`, `is_log`, `is_remove`, `is_delete`) values('3','erp','126','bargain','20','list.serve','服务合同管理','21','','0','','','1385429496','1','admin','服务合同管理','1','1','0','1','2');


#修改合同
ALTER TABLE `ccc`.`erp_business_bargain` CHANGE `is_master_slave` `is_master_slave` TINYINT(1) DEFAULT 0 NOT NULL COMMENT '主从合同（0-否1-是）';
ALTER TABLE `ccc`.`erp_business_bargain` CHANGE `bargain_number` `bargain_number` VARCHAR(25) CHARSET utf8 COLLATE utf8_general_ci DEFAULT '' NOT NULL COMMENT '合同编码'


ALTER TABLE `ccc`.`erp_business_bargain` ADD COLUMN `group_id` INT(11) DEFAULT 0 NOT NULL COMMENT '组别编号' AFTER `sale_user_id`, ADD COLUMN `group_number` VARCHAR(20) DEFAULT '' NOT NULL COMMENT '组别编码' AFTER `group_id`;

ALTER TABLE `ccc`.`erp_business_bargain` ADD COLUMN `serial_number` CHAR(4) DEFAULT '' NOT NULL COMMENT '连续号' AFTER `bargain_number`;

ALTER TABLE `ccc`.`erp_business_bargain` ADD COLUMN `year` INT(4) DEFAULT 0 NOT NULL COMMENT '年' AFTER `bargain_number`, DROP PRIMARY KEY, ADD PRIMARY KEY (`bargain_id`, `bargain_number`, `group_id`);


ALTER TABLE `ccc`.`erp_business_bargain` CHANGE `serial_number` `serial_number` INT(4) ZEROFILL DEFAULT 0 NOT NULL COMMENT '连续号';


ALTER TABLE `ccc`.`erp_business_bargain` ADD COLUMN `is_offical` TINYINT(1) DEFAULT 0 NOT NULL COMMENT '是否正式合同（0-临时1-正式）' AFTER `serial_number`;

ALTER TABLE `ccc`.`erp_business_bargain` DROP COLUMN `company_id`;

ALTER TABLE `ccc`.`erp_business_bargain_product` ADD COLUMN `product_text_name` VARCHAR(50) DEFAULT '' NOT NULL COMMENT '名称' AFTER `bargain_number`;

ALTER TABLE `ccc`.`erp_business_bargain_ship` ENGINE=INNODB;

ALTER TABLE `ccc`.`erp_business_bargain_ship_batch` ENGINE=INNODB;

ALTER TABLE `ccc`.`erp_business_bargain_pay` ENGINE=INNODB;

ALTER TABLE `ccc`.`erp_business_bargain_pay_invoice_batch` ENGINE=INNODB;

ALTER TABLE `ccc`.`erp_business_bargain_product` ENGINE=INNODB;

ALTER TABLE `ccc`.`erp_business_bargain_service` ENGINE=INNODB;




ALTER TABLE `ccc`.`admin_users` ADD COLUMN `user_address` TINYINT(1) DEFAULT 0 NOT NULL COMMENT '用户公司所在地（0-北京1-天津）' AFTER `ip`; 