<?php

/**
 * 教工考勤
 */
class TeacherAttendanceModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_teacherAttendance = null;

    private function __construct() {
        $this->_teacherAttendance = new Data_TeacherAttenDance();
    }

    /**
     * 实例化
     * @return TeacherAttendanceModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function getDataCount($where = "") {

        return $this->_teacherAttendance->getDataCount($where);
    }

    public function getPageData($page, $pageSize, $where = "") {
        return $this->_teacherAttendance->getPageData($page, $pageSize, $where);
    }

    public function checkData($teacherId, $checkDate) {
        return $this->_teacherAttendance->checkData($teacherId, $checkDate);
    }

    public function addData($params) {
        return $this->_teacherAttendance->addData($params);
    }

    public function getRowData($attendanceId) {
        return $this->_teacherAttendance->getRowData($attendanceId);
    }

    public function updateData($attendanceId, $params) {
        return $this->_teacherAttendance->updateData($attendanceId, $params);
    }

    public function deleteData($attendanceId) {
        return $this->_teacherAttendance->updateData($attendanceId, array("is_delete" => 1));
    }

}