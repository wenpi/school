<?php

/**
 * 接口数据处理
 * @author taozywu
 * @date 2014/08/08
 */
class Data_StudentDeal extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function getDataCount($where) {
        $sql = "select count(*) from sch_student_deal_data "
                . "where student_deal_data_id>0 {$where}  and is_delete=0";
//        echo $sql;
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function getPageData($page, $pageSize, $where) {
        $startIndex = ($page - 1) * $pageSize;
        $sql = "select * from sch_student_deal_data "
                . "where student_deal_data_id>0 {$where} and is_delete=0 limit {$startIndex},{$pageSize}";
//        echo $sql;exit;
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function checkData($studentId, $typeId ,$checkDate) {
        $sql = "select count(*) from sch_student_deal_data where sch_student_id={$studentId} "
                . "and deal_date='{$checkDate}' and type_id={$typeId} and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function addData($params) {
        $this->_db->insert("sch_student_deal_data", $params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function getRowData($dealId) {
        $sql = "select * from sch_student_deal_data where student_deal_data_id={$dealId} and is_delete=0";
        $data = $this->_db->fetchRow($sql);

        return !empty($data) ? $data : array();
    }

    public function updateData($dealId, $params) {
        $this->_db->update("sch_student_deal_data", $params, "student_deal_data_id=" . $dealId);
        return 1;
    }

}