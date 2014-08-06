<?php
/**
 * 引导文件，加载bootstrap模块配置
 *
 * @author taozywu
 * @date 2014/06/26
 */
ob_start();
header ( 'Content-Type: text/html; charset=utf-8' );
require_once 'bootstrap.php'; //加载启动配置文件

define ( 'DS', DIRECTORY_SEPARATOR );	//目录分隔符
define ( 'PATH_ROOT', realpath ( dirname ( __FILE__ ) . '/../' ) );	//文件根目录;
define ( 'PATH_LIB', PATH_ROOT . DS . 'lib' );	//库目录
define ( 'PATH_EXT', PATH_ROOT . DS . 'ext' );	//扩展目录
define ( 'PATH_APP', PATH_ROOT . DS . 'app' );	//应用目录
define( 'PATH_DATA' , PATH_ROOT . DS . 'data' ) ; //数据目录

define ( 'PATH_CONF', PATH_ROOT . DS . 'conf' . DS . 'conf.ini' );	//文本配置文件
define ( 'PATH_PEAR', get_include_path () );

try {
	$boot_app = new Bootstrap();
} catch (Exception $e) {
}
