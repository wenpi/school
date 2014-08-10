<?php

class TeacherModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_teacher = null;

    private function __construct() {
        $this->_teacher = new Data_Teacher();
    }

    /**
     * 实例化
     * @return TeacherModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function getDataCount($where = "") {
        return $this->_teacher->getDataCount($where);
    }

    public function getPageData($page, $pageSize, $where = "") {
        return $this->_teacher->getPageData($page, $pageSize, $where);
    }

    public function getTypeData() {
        $typeData = $this->_teacher->getTypeData();
        $arr = array();
        if ($typeData) {
            foreach ($typeData as $p) {
                $arr[$p['user_type_id']] = $p['type_name'];
            }
        }

        return $arr;
    }

    public function getTeacherDataByWhere($where = "") {
        return $this->_teacher->getTeacherDataByWhere($where);
    }

    public function getRowData($teacherId) {
        return $this->_teacher->getRowData($teacherId);
    }

    public function getTeacherIdByJobNumber($jobNumber) {
        return $this->_teacher->getTeacherIdByJobNumber($jobNumber);
    }

    public function getMaxTeacherNo($classId, $typeNumber) {
        return $this->_teacher->getMaxTeacherNo($classId, $typeNumber);
    }

    public function checkData($teacherNumber) {
        return $this->_teacher->checkData($teacherNumber);
    }

    public function addData($params) {
        return $this->_teacher->addData($params);
    }

    public function updateData($teacherId, $params) {
        return $this->_teacher->updateData($teacherId, $params);
    }
    
    public function deleteData($teacherId) {
        $params = array("is_delete"=>1);
               
        return $this->updateData($teacherId, $params);
    }
    
    public function getTeacherData( $leftData ) {
        $where = "";
        if($leftData) {
            $or = "";
            foreach($leftData as $p) {
                $where .= "{$or}'{$p['user_name']}'" ;
                $or = ",";
            }
        }
        $where = !empty($where) ? " and teacher_no not in ( {$where} ) " : "";
        return $this->_teacher->getTeacherData( $where );
    }

}