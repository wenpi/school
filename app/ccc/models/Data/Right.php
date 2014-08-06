<?php

/**
 * 用户角色权限 数据
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/06/04
 */
class Data_Right extends Ccc_Base_Model {

    public $_tableName = '';

    public function init() {
        parent::init();
    }

    /**
     * 获取条件后所有权限数据
     * @param type $where
     * @return type
     */
    public function getRightDataByWhere($where) {
        $sql = "select * from admin_rights where right_id>0 {$where} and is_delete=0 ";
        $data = $this->_db->fetchAll($sql);

        return !$data ? array() : $data;
    }
    
    public function getRightCountByWhere($where) {
        $sql = "select count(*) from admin_rights where right_id>0 {$where} and is_delete=0 ";
        $count = $this->_db->fetchOne( $sql );
        
        return $count;
    }

    /**
     * 获取某角色的权限数据
     * @param type $roleId
     * @return type
     */
    public function getRoleRightByRoleId($roleId) {
        $sql = "select * from admin_role_right where role_id={$roleId}";
        $data = $this->_db->fetchAll($sql);

        return !$data ? array() : $data;
    }

    /**
     * 获取某用户某角色下的所有权限
     * @param type $userId
     * @param type $roleId
     */
    public function getRightByUserIdAndRoleId($userId, $roleId) {
        $sql = "select right_id from admin_user_role_right where user_id={$userId} and role_id={$roleId}";
        $data = $this->_db->fetchAll($sql);
        $arr = array();
        if (!empty($data)) {
            foreach ($data as $p) {
                $arr[$p['right_id']] = 'OK';
            }
        }

        return $arr;
    }

    /**
     * 删除某用户某角色下所有权限
     * @param type $userId
     * @param type $roleId
     */
    public function deleteUserRoleRightByWhere($userId, $roleId , $where ) {
        $sql = "delete from admin_user_role_right where user_id={$userId} and role_id={$roleId} {$where}";
        $this->_db->query($sql);

        return 1;
    }

    public function saveUserRoleRight($params) {
        $this->_db->insert("admin_user_role_right", $params);
        $add = (int) $this->_db->lastInsertId();

        return $add;
    }

    public function getUserRightResourceData() {
        $sql = "SELECT b.`user_id`,a.app_string,a.module_string,a.action_string
			FROM admin_right_resource AS a,admin_user_role_right AS b
			WHERE a.right_id = b.`right_id` ";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }
    
    public function getResourceDataByRightId($rightId ) {
        $sql = "select * from admin_right_resource where right_id={$rightId}";
        $data = $this->_db->fetchAll( $sql );
        
        return !empty($data) ? $data : array(); 
    }

}