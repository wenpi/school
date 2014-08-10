<?php

/**
 * 接口数据处理
 * @author taozywu
 * @date 2014/08/08
 */
class Data_Teacher extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function getDataCount($where) {
        $sql = "select count(*) from sch_teachers where teacher_id >0 {$where} and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function getPageData($page, $pageSize, $where) {
        $startIndex = (int) ($page - 1) * $pageSize;
        $sql = "select * from sch_teachers where teacher_id >0 {$where} and is_delete=0 "
                . "order by teacher_id limit {$startIndex},{$pageSize}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function getTypeData() {
        $sql = " select * from admin_user_type where is_delete=0 ";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function getTeacherDataByWhere($where) {
        $sql = "select teacher_id,cn_name,teacher_no from sch_teachers where teacher_id>0 {$where} "
                . "and is_delete=0 ORDER BY CONVERT(cn_name USING GBK) ASC ";
//        echo $sql;
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function getRowData($teacherId) {
        $sql = "select * from sch_teachers where teacher_id={$teacherId} ";
        $data = $this->_db->fetchRow($sql);

        return !empty($data) ? $data : array();
    }

    public function getTeacherIdByJobNumber($jobNumber) {
        // 工号连续不关乎是否删除，删除的也记录在上？
        $sql = "select teacher_id from sch_teachers where teacher_no = '{$jobNumber}'  and is_delete=0";
//        echo $sql;
        $teacherId = $this->_db->fetchOne($sql);

        return $teacherId;
    }

    public function getMaxTeacherNo($classId, $typeNumber) {
        $sql = "select teacher_no from sch_teachers where class_id={$classId}
            and type_number={$typeNumber} and is_delete=0 order by teacher_no desc limit 1";
        $teacherNo = (int) $this->_db->fetchOne($sql);

        return $teacherNo;
    }

    public function checkData($teacherNumber) {
        $sql = "select count(*) from sch_teachers where teacher_number='{$teacherNumber}' and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function addData($params ) {
        $this->_db->insert("sch_teachers",$params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function updateData($teacherId, $params) {
        $this->_db->update("sch_teachers", $params, "teacher_id=" . $teacherId);
        return 1;
    }

    public function getTeacherData($where) {
        $sql = "select teacher_id,teacher_no,cn_name from sch_teachers where teacher_id>0 {$where} and is_delete=0";
//        echo $sql;
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

}