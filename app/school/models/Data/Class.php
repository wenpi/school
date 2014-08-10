<?php

/**
 * 接口数据处理
 * @author taozywu
 * @date 2014/08/08
 */
class Data_Class extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function getClassData($where) {
        $sql = "select class_id,class_no,class_name from sch_classes where class_id >0 {$where} and is_delete=0 ";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function getRowData($classId) {
        $sql = "select * from sch_classes where class_id={$classId} and is_delete=0";
        $data = $this->_db->fetchRow($sql);

        return !empty($data) ? $data : array();
    }

    public function checkData($className) {
        $sql = "select count(*) from sch_classes where class_name='{$className}' and is_delete=0 ";
        $count = (int) $this->_db->fetchOne($sql);

        return $count;
    }

    public function addData($params) {
        $this->_db->insert("sch_classes", $params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function updateData($classId, $params) {
        $this->_db->update("sch_classes", $params, "class_id=" . $classId);

        return 1;
    }
    
    public function getDataCount( $where ) {
        $sql = "select count(*) from sch_classes where class_id>0 {$where} ";
        $count = (int) $this->_db->fetchOne($sql);

        return $count;
    }

    public function getPageData($page , $pageSize, $where) {
        $startIndex = (int) ($page-1) * $pageSize;
        $sql = "select * from sch_classes where class_id>0 {$where} "
                . "order by class_id desc limit {$startIndex},{$pageSize}";
        $data = $this->_db->fetchAll($sql);
        
        return !empty($data) ? $data : array();
    }
}