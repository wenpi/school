<?php

/**
 * 用户数据
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/06/04
 */
class Data_User extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function getUserList($where) {
        $sql = "select user_id,user_name,real_name,status from admin_users where user_id >0 {$where} "
                . "and status in (1,2,3) order by user_name asc";
        $data = $this->_db->fetchAll($sql);

        return !$data ? array() : $data;
    }

    public function getUserInfo($userId) {
        $sql = "select * from admin_users where user_id={$userId}";
        $data = $this->_db->fetchRow($sql);

        return !empty($data) ? $data : array();
    }

    public function updateData($userId, $params) {
        $this->_db->update("admin_users", $params, "user_id=" . $userId);
        return 1;
    }

    public function getUserRoleData($userId) {
        $sql = "select ar.role_id,ar.role_name from admin_user_role as aur,admin_roles as ar "
                . "where aur.role_id=ar.role_id and ar.is_delete=0 and aur.user_id={$userId}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * 删除某用户角色
     * @param type $userId
     */
    public function deleteUserRoleByUserId($userId) {
        $this->_db->delete("admin_user_role", "user_id=" . $userId);

        return 1;
    }

    /**
     * 添加用户角色
     * @param type $userId
     * @param type $roleIds
     */
    public function addUserRole($userId, $roleIds) {
        $where = "";
        if (!empty($roleIds)) {
            $or = "";
            foreach ($roleIds as $roleId) {
                $where .= "{$or}('{$userId}','{$roleId}')";
                $or = ",";
            }
        }
        if (!empty($where)) {
            $sql = "INSERT INTO admin_user_role (`user_id`,`role_id`) VALUES{$where}";
            $this->_db->query($sql);
        }

        return 1;
    }

    public function checkUserName($userName) {
        $sql = "select count(*) from admin_users where user_name='{$userName}' and status in (1,2,3)";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function addData($params) {
        $this->_db->insert("admin_users", $params);
        $add = $this->_db->lastInsertid();

        return $add;
    }

    public function deleteData($userId) {
        $params = array("status" => 4);
        $this->_db->update("admin_users", $params, "user_id=" . $userId);
        return 1;
    }

    /**
     * 获取某用户的用户角色
     * @param type $userId
     */
    public function getUserRoleByUserId($userId) {
        $sql = "select ar.role_id,ar.role_name from admin_user_role as aur,admin_roles as ar "
                . "where aur.role_id=ar.role_id and ar.is_delete=0 and aur.user_id={$userId}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * 获取某用户的角色总数
     * @param type $userId
     * @return type
     */
    public function getUserRoleCountByUserId($userId) {
        $sql = "select count(ar.role_id) from admin_user_role as aur,admin_roles as ar "
                . "where aur.role_id=ar.role_id and ar.is_delete=0 and aur.user_id={$userId}";
        $count = (int) $this->_db->fetchOne($sql);

        return $count;
    }

    public function getUserTypeData($where) {
        $sql = "select * from admin_user_type where user_type_id>0 {$where} and is_delete=0";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function getDbDataBySql($sql) {
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function deleteUserSetByUserType($userType) {
        $params = array("status" => 4);
        $this->_db->update("admin_users", $params, "user_type=" . $userType);

        return 1;
    }

    public function addUserSet($userType, $userIds , $defaultPass) {
        if (!empty($userIds)) {
            $defaultPass =  md5($defaultPass);
            foreach ($userIds as $u) {
                try {
                    @list($uid, $uname) = @explode("_", $u);
                    if( ( $has = $this->checkUserName($uid) ) <1 ) {
                        $sql = "INSERT INTO admin_users (`user_type`,`user_name`,`real_name`,`user_pass`,`status`) "
                                . "VALUES('{$userType}','{$uid}','{$uname}','{$defaultPass}',1)";
//                                echo $sql;
                        $this->_db->query($sql);
                    }
                } catch (Exception $e) {
                    
                }
            }
        }

        return 1;
    }
    
    
    public function checkUserInfo($userName, $userPass) {
        $sql = "select count(*) from admin_users where user_name ='{$userName}' 
            and user_pass='{$userPass}' and status in (1,2,3)";
        $count = $this->_db->fetchOne($sql);
        
        return $count;
    }

}