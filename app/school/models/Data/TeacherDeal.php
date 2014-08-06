<?php

/**
 * 接口数据处理
 * @author sln
 * @date 2013/11/27
 */
class Data_TeacherDeal extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function getDataCount($where) {
        $sql = "select count(*) from sch_teacher_deal_data "
                . "where teacher_deal_data_id>0 {$where}  and is_delete=0";
//        echo $sql;
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function getPageData($page, $pageSize, $where) {
        $startIndex = ($page - 1) * $pageSize;
        $sql = "select * from sch_teacher_deal_data "
                . "where teacher_deal_data_id>0 {$where} and is_delete=0 limit {$startIndex},{$pageSize}";
//        echo $sql;exit;
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function checkData($teacherId, $typeId ,$checkDate) {
        $sql = "select count(*) from sch_teacher_deal_data where teacher_id={$teacherId} "
                . "and deal_date='{$checkDate}' and type_id={$typeId} and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function addData($params) {
        $this->_db->insert("sch_teacher_deal_data", $params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function getRowData($dealId) {
        $sql = "select * from sch_teacher_deal_data where teacher_deal_data_id={$dealId} and is_delete=0";
        $data = $this->_db->fetchRow($sql);

        return !empty($data) ? $data : array();
    }

    public function updateData($dealId, $params) {
        $this->_db->update("sch_teacher_deal_data", $params, "teacher_deal_data_id=" . $dealId);
        return 1;
    }

}