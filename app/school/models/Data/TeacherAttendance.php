<?php

/**
 * 接口数据处理
 * @author sln
 * @date 2013/11/27
 */
class Data_TeacherAttenDance extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function getDataCount($where) {
        $sql = "select count(*) from sch_teacher_attendance "
                . "where teacher_attendance_id>0 {$where}  and is_delete=0";
//        echo $sql;
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function getPageData($page, $pageSize, $where) {
        $startIndex = ($page - 1) * $pageSize;
        $sql = "select * from sch_teacher_attendance "
                . "where teacher_attendance_id>0 {$where} and is_delete=0 limit {$startIndex},{$pageSize}";
//        echo $sql;exit;
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function checkData($teacherId, $checkDate) {
        $sql = "select count(*) from sch_teacher_attendance where teacher_id={$teacherId} "
                . "and attendance_date='{$checkDate}' and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function addData($params) {
        $this->_db->insert("sch_teacher_attendance", $params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function getRowData($attendanceId) {
        $sql = "select * from sch_teacher_attendance where teacher_attendance_id={$attendanceId} and is_delete=0";
        $data = $this->_db->fetchRow($sql);

        return !empty($data) ? $data : array();
    }

    public function updateData($attendanceId, $params) {
        $this->_db->update("sch_teacher_attendance", $params, "teacher_attendance_id=" . $attendanceId);
        return 1;
    }

//    public function deleteData($attendanceId) {
//        return $this->updateData($attendanceId, array("is_delete" => 1));
//    }

}