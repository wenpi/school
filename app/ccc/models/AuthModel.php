<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * Auth模块
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/06/04
 */
class AuthModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_auth;

    private function __construct() {
        $this->_auth = new Data_Auth();
    }

    /**
     * 实例化
     * @return AuthModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    /**
     * 获取角色数据
     * @param type $where
     */
    public function getPageData($page , $pageSize , $where = "") {
        return $this->_auth->getPageData($page , $pageSize , $where);
    }

    public function getDataCount( $where = "" ) {
        return $this->_auth->getDataCount($where);
    }
    
    public function getRowData( $rightId ) {
        return $this->_auth->getRowData($rightId);
    }

    public function updateData($rightId, $params) {
        return $this->_auth->updateData($rightId, $params);
    }

    public function checkData($name) {
        return $this->_auth->checkData($name);
    }

    public function addData($params) {
        return $this->_auth->addData($params);
    }
    
    public function checkRightResource( $rightId ) {
        return $this->_auth->checkRightResource( $rightId );
    }

}