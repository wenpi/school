<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 权限系统模块
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/07/23
 */
class RightModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_right;

    private function __construct() {
        $this->_right = new Data_Right();
    }

    /**
     * 实例化
     * @return RightModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function getRoleRightByRoleId($roleId) {
        return $this->_right->getRoleRightByRoleId($roleId);
    }

    public function getRightDataByWhere($where = "") {
        return $this->_right->getRightDataByWhere($where);
    }
    
    public function getRightCountByWhere( $where = "" ) {
        return $this->_right->getRightCountByWhere( $where );
    }

    public function getRightByUserIdAndRoleId($userId, $roleId) {
        return $this->_right->getRightByUserIdAndRoleId($userId, $roleId);
    }

    public function deleteUserRoleRightByWhere($userId, $roleId , $rightIds) {
        $where = "";
        if( $rightIds ) {
            $or = "";
            foreach( $rightIds as $p ) {
                $where .= " {$or} right_id={$p} ";
                $or = "or";
            }
        }
        $where = !empty($where) ? " and ({$where}) " : " and 1>1 ";
        return $this->_right->deleteUserRoleRightByWhere($userId, $roleId , $where );
    }

    public function saveUserRoleRight($userId, $roleId, $rightIds) {
        $params = array();
        foreach ($rightIds as $right) {
            $params[] = array(
                "user_id" => $userId,
                "role_id" => $roleId,
                "right_id" => $right);
        }
        if (!empty($params)) {
            foreach ($params as $p) {
                $this->_right->saveUserRoleRight($p);
            }
        }

        return 1;
    }

    public function getUserRightResourceData() {
        return $this->_right->getUserRightResourceData();
    }
    
    public function getResourceDataByRightId( $rightId ) {
        return $this->_right->getResourceDataByRightId( $rightId );
    }

}