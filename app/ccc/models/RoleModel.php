<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * Role模块
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/06/04
 */
class RoleModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_role;

    private function __construct() {
        $this->_role = new Data_Role();
    }

    /**
     * 实例化
     * @return RoleModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    
    public function getDataCount($where = "") {
        return $this->_role->getDataCount($where);
    }
    
    /**
     * 获取角色分页数据
     * @param type $where
     */
    public function getPageData( $page , $pageSize , $where = "") {
        return $this->_role->getPageData( $page , $pageSize , $where );
    }
    
    
    /**
     * 供给用户配置角色使用  $url/user/edit/user_id/1
     * @param type $where
     * @return type
     */
    public function getRoleData($where = "") {
        return $this->_role->getRoleData($where);
    }

    public function getRoleInfo($roleId) {
        return $this->_role->getRoleInfo($roleId);
    }

    public function updateData($roleId, $params) {
        return $this->_role->updateData($roleId, $params);
    }

    public function checkRoleName($roleName) {
        return $this->_role->checkRoleName($roleName);
    }

    public function addData($params) {
        return $this->_role->addData($params);
    }

    public function checkRoleRight($roleId) {
        return $this->_role->checkRoleRight($roleId);
    }

}