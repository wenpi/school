<?php

/**
 * 权限类
 * @auther taozy.wu
 * @date 2013/9/10
 */
if (!isset($_SESSION))
    session_start();

class Ccc_Base_Auth {

    /**
     * 单例对象
     */
    private static $_singletonObject;
    private $_app = '';
    private $_controller = '';
    private $_action = '';
    private $_ajax = false;
    private $_path = '';

    /**
     * 实例化
     * @param string $nameSpace
     */
    private function __construct($controller, $action, $ajax, $path) {
        $this->_app = isset($GLOBALS['module']) ? $GLOBALS['module'] : "";
        $this->_app = $this->_app == "ccc" ? "admin" : $this->_app;
        $this->_app = $this->_app == "erp" ? "business" : $this->_app;
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_ajax = $ajax;
        $this->_path = $path;
        $this->_action = str_replace("-", ".", $this->_action);
    }

    /**
     * 单例
     * @param type $controller
     * @param type $action
     * @param type $ajax
     * @return Ccc_Base_Auth
     */
    public static function getInstance($controller = '', $action = '', $ajax = 0, $path = '') {
        $className = __CLASS__;
        if (!isset(self::$_singletonObject[$className])) {
            self::$_singletonObject[$className] = new self($controller, $action, $ajax, $path);
        }

        return self::$_singletonObject[$className];
    }

    /**
     * 检查登录
     */
    function session() {
        if (!isset($_SESSION['ccc']['uid']) || (isset($_SESSION['ccc']['uid']) && $_SESSION['ccc']['uid'] < 1)) {
            if ($this->_ajax) {
                echo "-1000001";
                exit;
            } else {
                die("Session Lost.");
            }
        }
    }

    /**
     * 检查权限
     */
    function right() {
        // 首先判断是否登录过
        $this->session();
        // 获取系统管理角色
        if (!isset($_SESSION['ccc']['urolecheck']) || !$_SESSION['ccc']['urolecheck']) {
            $isRight = false;
            // 角色权限。
            if (!empty($this->_path) && file_exists(PATH_ROOT . $this->_path)) {
                // 检查
                require_once(PATH_ROOT . $this->_path );
                if (isset($_SESSION['ccc']['uid']) && !empty($_SESSION['ccc']['uid']) && !empty($USERROLERIGHTS)) {
                    $USERROLERIGHTS = @unserialize($USERROLERIGHTS);
                    if (isset($USERROLERIGHTS[$_SESSION['ccc']['uid']]) 
                            && isset($USERROLERIGHTS[$_SESSION['ccc']['uid']][$this->_app]) 
                            && isset($USERROLERIGHTS[$_SESSION['ccc']['uid']][$this->_app][$this->_controller])) {
                        foreach ($USERROLERIGHTS[$_SESSION['ccc']['uid']][$this->_app][$this->_controller] as $p) {
                            if ($this->_action == str_replace("-", ".", $p)) {
                                $isRight = true;
                                break;
                            }
                        }
                    }
                }
            }

            // 处理权限结果
            if (!$isRight) {
                if ($this->_ajax) {
                    echo "-1000002";
                    exit;
                } else {
                    die("<span style=\"color:red\">Access Denied.</span>");
                }
            }
        }
    }

    /**
     * 析构
     */
    public function __destruct() {
        $this->_controller = '';
        $this->_action = '';
        $this->_path = '';
    }

}