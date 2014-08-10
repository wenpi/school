<?php

/**
 * 接口数据处理
 * @author taozywu
 * @date 2014/08/08
 */
class Data_StudentAttenDance extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function getDataCount($where) {
        $sql = "select count(*) from sch_student_attendance "
                . "where student_attendance_id>0 {$where}  and is_delete=0";
//        echo $sql;
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function getPageData($page, $pageSize, $where) {
        $startIndex = ($page - 1) * $pageSize;
        $sql = "select * from sch_student_attendance "
                . "where student_attendance_id>0 {$where} and is_delete=0 limit {$startIndex},{$pageSize}";
//        echo $sql;exit;
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function checkData($studentId, $checkDate) {
        $sql = "select count(*) from sch_student_attendance where sch_student_id={$studentId} "
                . "and attendance_date='{$checkDate}' and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function addData($params) {
        $this->_db->insert("sch_student_attendance", $params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function getRowData($attendanceId) {
        $sql = "select * from sch_student_attendance where student_attendance_id={$attendanceId} and is_delete=0";
        $data = $this->_db->fetchRow($sql);

        return !empty($data) ? $data : array();
    }

    public function updateData($attendanceId, $params) {
        $this->_db->update("sch_student_attendance", $params, "student_attendance_id=" . $attendanceId);
        return 1;
    }

}