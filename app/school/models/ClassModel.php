<?php

defined('PATH_ROOT') or die('Access Denied.');

class ClassModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_class = null;

    private function __construct() {
        $this->_class = new Data_Class();
    }

    /**
     * 实例化
     * @return ClassModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function getClassData($where = "") {
        return $this->_class->getClassData($where);
    }

    public function getRowData($classId) {
        return $this->_class->getRowData($classId);
    }

    public function checkData($className) {
        return $this->_class->checkData($className);
    }

    public function addData($params) {
        return $this->_class->addData($params);
    }

    public function updateData($classId, $params) {
        return $this->_class->updateData($classId, $params);
    }

    public function getDataCount($where = "") {
        return $this->_class->getDataCount($where);
    }

    public function getPageData($page = 1, $pageSize = 20, $where = "") {
        return $this->_class->getPageData($page, $pageSize, $where);
    }

    public function getStudentDataBySpecial($classId) {
        return $this->_class->getStudentDataBySpecial($classId);
    }

    public function getStudentDataByNotSpecial($classId) {
        return $this->_class->getStudentDataByNotSpecial($classId);
    }

    public function deleteStudentDataByClassId($classId) {
        return $this->_class->deleteStudentDataByClassId($classId);
    }

    public function addStudentDataBySpecial($classId, $studentIds) {
        $where = "";
        if (!empty($studentIds)) {
            $or = "";
            foreach ($studentIds as $p) {
                $where .= "{$or}('{$classId}','{$p}')";
                $or = ",";
            }
        }
        if (!empty($where)) {

            return $this->_class->addStudentDataBySpecial($where);
        }

        return 0;
    }

    public function deleteData($classId) {
        $params = array("is_delete" => 1);
        return $this->updateData($classId, $params);
    }

}