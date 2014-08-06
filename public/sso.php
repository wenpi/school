<?php

/**
 * 处理SSO 单点登录
 * @author taozywu | 2013/09/13
 */
// 处理IE iframe  cookie
header("P3P: CP=CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR");

// get the parameter.
$action = trim($_GET['action']);
$nowTime = (int) $_GET['t'];
$token = trim($_GET['token']);
$sessionId = trim($_GET['sid']);
$tokenVal = trim($_GET['tt']);
// deal the parameter.
$checkSessionId = !empty($sessionId) ? base64_decode($sessionId) : "";
$checkToken = $nowTime > 0 ? md5($token . $nowTime) : "";

// 判断参数是否为空
if (empty($action) || empty($checkSessionId) || empty($checkToken)) {
    exit;
}
// 判断安全码
if ($checkToken != $tokenVal) {
    exit;
}

set_include_path(get_include_path());
require_once 'Zend/Session.php';
//@Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
// 判断登录成功
if ($action == "login") {
    Zend_Session::setId($checkSessionId);
    Zend_session::start();
    $session = new Zend_Session_Namespace("ccc", true);
}
// 判断登出成功
if ($action == "logout") {
    if (isset($_SESSION)) {
//        session_destroy();
        Zend_session::destroy();
        
    }
}