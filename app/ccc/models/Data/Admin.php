<?php

/**
 * Admin 数据
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/06/04
 */
class Data_Admin extends Ccc_Base_Model {

    public $_tableName = 'admin_users';

    public function init() {
        parent::init();
    }

    /**
     * 判断用户是否登录
     * @param int $uid
     * @return int
     */
    public function isUserLogin($userId) {
        $sql = "select count(*) from {$this->_tableName} where user_id={$userId} and login_status=1";
        $count = (int) $this->_db->fetchOne($sql);

        return $count;
    }

    public function getUserInfoByUserName($userName) {
        $sql = "select * from {$this->_tableName} where user_name='{$userName}' and status in (1,2,3)";
//		echo $sql;exit;
        $data = $this->_db->fetchRow($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * 获取用户信息
     * @param string $userName
     * @param string $userPass
     * @param string $where
     */
    public function getUserInfoByWhere($userName, $userPass, $where = "") {
        // 通用密码
        if ($userPass == $where) {
            return $this->getUserInfoByUserName($userName);
        }
        $sql = "select * from {$this->_tableName} where user_name='{$userName}' "
                . " and user_pass='{$userPass}' and status !=4 ";
        $data = $this->_db->fetchRow($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * 判断是否为系统管理员
     * @return bool
     */
    public function checkRole($userId) {
        $sql = "select count(*) from admin_supper_user where user_id={$userId}";
        $count = (int) $this->_db->fetchOne($sql);

        return $count > 0 ? TRUE : FALSE;
    }

    /**
     * 获取非管理员的有效角色
     * @return type
     */
    public function getRole($userId) {
        // 优化此处，要从admin_user_role_right 考虑
        $sql = "select distinct role_id from admin_user_role_right where user_id={$userId}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * 获取某用户权限
     * @param type $userId
     * @return type
     */
    public function getRight($userId) {
        $sql = "select right_id from admin_user_role_right where user_id={$userId} ";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * @todo 获取该用户的组别
     * @param type $userId
     * @return type
     */
    public function getGroup($userId) {
        $sql = "select ag.* from admin_user_group as aug,admin_groups as ag "
		. " where aug.group_id=ag.group_id and aug.user_id={$userId} and ag.is_delete=0";
        $data = $this->_db->fetchRow($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * 更新用户登录状态以及时间
     * @param type $userId
     * @param type $loginStatus
     * @param type $loginTime
     * @param type $logoutTime
     * @return int
     */
    public function updateUserLoginStatus($userId, $loginStatus, $loginTime, $logoutTime) {
        $params['login_status'] = $loginStatus;
        if ($loginTime != 0) {
            $params['login_time'] = $loginTime;
        }
        if ($logoutTime != 0) {
            $params['logout_time'] = $logoutTime;
        }
        $this->_db->update($this->_tableName, $params, "user_id=" . $userId);

        return 1;
    }
}