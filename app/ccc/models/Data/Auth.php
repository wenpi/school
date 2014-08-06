<?php

/**
 * 权限数据
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/06/04
 */
class Data_Auth extends Ccc_Base_Model {

    public $_tableName = 'admin_rights';

    public function init() {
        parent::init();
    }

    /**
     * 获取角色数据
     * @param $where
     */
    public function getPageData( $page , $pageSize , $where ) {
        $startIndex = (int) ($page-1) * $pageSize;
        $sql = "select * from {$this->_tableName} where right_id > 0 {$where} "
                . "and is_delete=0 limit {$startIndex},{$pageSize} ";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }
    
    public function getDataCount($where) {
        $sql = "select count(*) from {$this->_tableName} where right_id >0 {$where} ";
        $count = $this->_db->fetchOne($sql);
        
        return $count;
    }
    

    public function getRowData($rightId) {
        $sql = "select * from {$this->_tableName} where right_id ={$rightId} and is_delete=0";
        $data = $this->_db->fetchRow($sql);
        return !empty($data) ? $data : array();
    }

    public function updateData($rightId, $params) {
        $this->_db->update($this->_tableName, $params, "right_id=" . $rightId);
        return 1;
    }

    public function checkData($name) {
        $sql = "select count(*) from {$this->_tableName} where right_name='{$name}' and is_delete=0";
        $count = $this->_db->fetchOne($sql);
        return $count;
    }
    
    public function addData( $params ) {
        $this->_db->insert($this->_tableName,$params ) ;
        $add = $this->_db->lastInsertid();
        
        return $add;
    }

    
    public function checkRightResource( $rightId ) {
        $sql = "select count(*) from admin_right_resource where right_id ={$rightId} ";
        $count = $this->_db->fetchOne($sql);
        
        return $count;
    }
    
}