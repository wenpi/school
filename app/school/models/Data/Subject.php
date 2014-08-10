<?php

/**
 * 接口数据处理
 * @author sln
 * @date 2013/11/27
 */
class Data_Subject extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function getDataCount($where) {
        $sql = "select count(*) from sch_subjects where subject_id>0 {$where} and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function getPageData($page, $pageSize, $where) {
        $startIndex = ($page - 1) * $pageSize;
        $sql = "select * from sch_subjects where subject_id >0 {$where} and is_delete=0 limit {$startIndex},{$pageSize}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function checkData($classId, $subjectName) {
        $sql = "select count(*) from sch_subjects where class_id={$classId} and subject_name='{$subjectName}' and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function addData($params) {
        $this->_db->insert("sch_subjects", $params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function getRowData($subjectId) {
        $sql = "select * from sch_subjects where subject_id={$subjectId}";
        $data = $this->_db->fetchRow($sql);

        return !empty($data) ? $data : array();
    }

    public function updateData($subjectId, $params) {
        $this->_db->update("sch_subjects", $params, "subject_id=" . $subjectId);
        return 1;
    }
    

}