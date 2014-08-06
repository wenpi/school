<?php

/**
 * Role 数据
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/06/04
 */
class Data_Role extends Ccc_Base_Model {

    public $_tableName = 'admin_roles';

    public function init() {
        parent::init();
    }

    /**
     * 获取角色数据
     * @param $where
     */
    public function getPageData($page, $pageSize , $where) {
        $startIndex = (int) ($page-1) * $pageSize ;
        $sql = "select * from {$this->_tableName} where role_id > 0 {$where} and is_delete=0 "
                . "limit {$startIndex},{$pageSize}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }
    
    
    
    public function getDataCount($where) {
        $sql = "select count(*) from  {$this->_tableName} where role_id>0 {$where} ";
        $count = $this->_db->fetchOne($sql);
        return $count;
    }
    
    public function getRoleData($where) {
        $sql = "select * from {$this->_tableName} where role_id > 0 {$where} and is_delete=0 ";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }
    

    public function getRoleInfo($roleId) {
        $sql = "select * from {$this->_tableName} where role_id ={$roleId} and is_delete=0";
        $data = $this->_db->fetchRow($sql);
        return !empty($data) ? $data : array();
    }

    public function updateData($roleId, $params) {
        $this->_db->update($this->_tableName, $params, "role_id=" . $roleId);
        return 1;
    }

    public function checkRoleName($roleName) {
        $sql = "select count(*) from {$this->_tableName} where role_name='{$roleName}' and is_delete=0";
        $count = $this->_db->fetchOne($sql);
        return $count;
    }
    
    public function addData( $params ) {
        $this->_db->insert($this->_tableName,$params ) ;
        $add = $this->_db->lastInsertid();
        
        return $add;
    }

    public function checkRoleRight( $roleId ) {
        $sql = "select count(*) from admin_role_right where role_id={$roleId} ";
        $count = $this->_db->fetchOne($sql);
        
        return $count;
    }
    
}