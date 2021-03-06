<?php

/**
 * 接口数据处理
 * @author taozywu
 * @date 2014/08/08
 */
class Data_Parent extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function addData($params) {
        $this->_db->insert("sch_parents", $params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function getParentDataByWhere($where) {
        $sql = "select * from sch_parents where parent_id>0 {$where} and is_delete=0";
        $parentData = $this->_db->fetchAll($sql);

        return !empty($parentData) ? $parentData : array();
    }

    public function updateData( $parentId , $params) {
        $this->_db->update("sch_parents", $params, "parent_id=" . $parentId);

        return 1;
    }

    public function getParentDataCountByWhere($where) {
        $sql = "select count(*) from sch_parents where parent_id>0 {$where} and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function deleteDataByWhere( $where , $params ) {
        $this->_db->update("sch_parents", $params, $where );

        return 1;
    }
    
    public function getParentDataBySms($studentId) {
        $sql = "select * from sch_parents where sch_student_id={$studentId} and is_message=1 "
                . "and is_delete=0 limit 1";
        $parentRowData = $this->_db->fetchRow($sql);
        
        return !empty($parentRowData) ? $parentRowData : array();
    }

}