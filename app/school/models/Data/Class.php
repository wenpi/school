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
        $sql = "select count(*) from sch_classes where class_id>0 {$where} and `status` in (1,4) and is_delete=0 ";
        $count = (int) $this->_db->fetchOne($sql);

        return $count;
    }

    public function getPageData($page , $pageSize, $where) {
        $startIndex = (int) ($page-1) * $pageSize;
        $sql = "select * from sch_classes where class_id>0 {$where} and `status` in (1,4) and is_delete=0 "
                . "order by class_id desc limit {$startIndex},{$pageSize}";
        $data = $this->_db->fetchAll($sql);
        
        return !empty($data) ? $data : array();
    }
    
    public function getStudentDataBySpecial( $classId ) {
        $sql = "SELECT student_id,cn_name,student_no FROM sch_students "
                . "WHERE student_id IN ( SELECT sch_student_id FROM sch_specialclass_student "
                . "WHERE sch_class_id={$classId} ) ";
        $studentData = $this->_db->fetchAll($sql);
        
        return !empty($studentData) ? $studentData : array();
    } 
    
    
    public function getStudentDataByNotSpecial( $classId ) {
        $sql = "SELECT student_id,cn_name,student_no FROM sch_students "
                . "WHERE student_id NOT IN ( SELECT sch_student_id FROM "
                . "sch_specialclass_student WHERE sch_class_id={$classId} ) ";
        $studentData = $this->_db->fetchAll($sql);
        
        return !empty($studentData) ? $studentData : array();
    }
    
    public function deleteStudentDataByClassId( $classId ) {
        $this->_db->delete("sch_specialclass_student","sch_class_id=" . $classId);
        
        return 1;
    }
    
    public function  addStudentDataBySpecial($where) {
        $sql = "INSERT INTO sch_specialclass_student (`sch_class_id`,`sch_student_id`) VALUES{$where}";
        $this->_db->query($sql);
        
        return 1;
    }
    
    public function getClassTypeData($where) {
        $sql = "select * from sch_class_type where class_type_id>0 {$where} and is_delete=0";
        $data = $this->_db->fetchAll($sql);
        
        return !empty($data) ? $data : array();
    }
    
    
    public function getClassTypeRowData($classTypeId) { 
        $sql = "select * from sch_class_type where class_type_id={$classTypeId} and is_delete=0";
        $classTypeRowData = $this->_db->fetchRow($sql);
        
        return !empty($classTypeRowData) ? $classTypeRowData : array();
    }
    
    public function getClassRowData($classId) {
        $sql = "select * from sch_classes where class_id={$classId} ";
        $classRowData = $this->_db->fetchRow($sql);
        
        return !empty($classRowData) ? $classRowData : array();
    }
}