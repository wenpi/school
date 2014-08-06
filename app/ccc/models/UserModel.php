<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 用户模块
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/07/24
 */
class UserModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_user;

    private function __construct() {
        $this->_user = new Data_User();
    }

    /**
     * 实例化
     * @return UserModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function getUserList($where = "") {
        return $this->_user->getUserList($where);
    }

    public function getUserInfo($userId) {
        return $this->_user->getUserInfo($userId);
    }

    public function updateData($userId, $params) {
        return $this->_user->updateData($userId, $params);
    }

    public function getUserRoleData($userId) {
        return $this->_user->getUserRoleData($userId);
    }

    public function deleteUserRoleByUserId($userId) {
        return $this->_user->deleteUserRoleByUserId($userId);
    }

    public function addUserRole($userId, $roleIds) {
        return $this->_user->addUserRole($userId, $roleIds);
    }

    public function checkUserName($userName) {
        return $this->_user->checkUserName($userName);
    }

    public function addData($params) {
        return $this->_user->addData($params);
    }

    public function deleteData($userId) {
        return $this->_user->deleteData($userId);
    }

    public function getUserRoleByUserId($userId) {
        return $this->_user->getUserRoleByUserId($userId);
    }

    public function getUserRoleCountByUserId($userId) {
        return $this->_user->getUserRoleCountByUserId($userId);
    }

    public function getUserTypeData($where = "") {

        return $this->_user->getUserTypeData($where);
    }

    // @todo
    public function getDbDataByTypeId($typeId, $leftData) {
        $sqlName = "";
        $sqlWhere = "";
        $or = "";
        $where = "";
        switch ($typeId) {
            case 1:
            case 2:
                $sqlWhere = "teacher_no";
                $sqlName = "select teacher_no as right_no,cn_name as right_name
                    from sch_teachers where status=1 and is_delete=0";
                break;
            case 3:
                $sqlName = "";
                break;
            case 7:
                $sqlName = "";
                break;
            default:
                $sqlName = "";
                break;
        }
        if ($sqlName) {
            if ($leftData) {
                foreach ($leftData as $p) {
                    $where .= " {$or}'{$p['user_name']}' ";
                    $or = ",";
                }
            }
            $where = !empty($where) ? " and {$sqlWhere} not in ($where) " : "";
            $sqlName = $sqlName . $where;
//            echo $sqlName;

            return $this->_user->getDbDataBySql($sqlName);
        }

        return NULL;
    }

    public function deleteUserSetByUserType($userType) {
        return $this->_user->deleteUserSetByUserType($userType);
    }

    public function addUserSet($userType, $userIdResult, $defaultPass) {
        return $this->_user->addUserSet($userType, $userIdResult, $defaultPass);
    }

}