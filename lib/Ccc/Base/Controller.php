<?php

/**
 * 基类Controller
 *
 * @author taozywu
 *
 */
class Ccc_Base_Controller extends Zend_Controller_Action {

    public $_session; //session
    public $_conf;  //conf.ini配置文件实例
    public $_cache;  //cache实例
    public $_baseModel;  //Model实例
    public $_isAdmin = false; // 最高级管理员

    /**
     * 初始化
     */

    public function init() {
        $this->_session = Zend_Registry::get('session');
        $this->_conf = Zend_Registry::get('conf');
        $this->_cache = Zend_Registry::get('cache');
        $this->_baseModel = new Ccc_Base_Model();
        $this->_baseFun = new Ccc_Base_Func();
        // 最高级管理员
        $this->_isAdmin = $this->_session->urolecheck;
    }

    /**     *
     * 检查权限
     */
    public function checkAuth() {
        if ($this->_isAdmin) return;
        Ccc_Base_Auth::getInstance(
                $this->getRequest()->getControllerName(), 
                $this->getRequest()->getActionName(), 
                $this->_getParam("j"), 
                $this->_conf->path_user_role_right
        )->right();
    }

    /**
     * 检查日志
     */
    public function checkLog() {
        $appName = isset($GLOBALS['module']) ? $GLOBALS['module'] : "";
        $controllerName = $this->getRequest()->getControllerName();
        $actionName = $this->getRequest()->getActionName();
        $sql = "select count(*) from admin_resources
			where app_string='{$appName}' and module_string='{$controllerName}'
			and action_string='{$actionName}' and is_log=1 and is_delete=0";
        $count = $this->_baseModel->checkLog($sql);
        if ($count > 0) {
            $params = array(
                "app_string" => $appName,
                "module_string" => $controllerName,
                "action_string" => $actionName,
                "operate_user_id" => $this->_session->uid,
                "operate_user_name" => $this->_session->uname,
                "user_id" => $this->_session->uid,
                "user_name" => $this->_session->uname,
                "title" => "",
                "add_time_int" => time()
                    );
            $this->_baseModel->writeLog("admin_logs", $params);
        }
    }

}