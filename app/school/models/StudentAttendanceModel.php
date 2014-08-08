<?php
defined('PATH_ROOT') or die('Access Denied.');
/**
 * 学生考勤
 */
class StudentAttendanceModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_studentAttendance = null;

    private function __construct() {
        $this->_studentAttendance = new Data_StudentAttenDance();
    }

    /**
     * 实例化
     * @return StudentAttendanceModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function getDataCount($where = "") {

        return $this->_studentAttendance->getDataCount($where);
    }

    public function getPageData($page, $pageSize, $where = "") {
        return $this->_studentAttendance->getPageData($page, $pageSize, $where);
    }

    public function checkData($studentId, $checkDate) {
        return $this->_studentAttendance->checkData($studentId, $checkDate);
    }

    public function addData($params) {
        return $this->_studentAttendance->addData($params);
    }

    public function getRowData($attendanceId) {
        return $this->_studentAttendance->getRowData($attendanceId);
    }

    public function updateData($attendanceId, $params) {
        return $this->_studentAttendance->updateData($attendanceId, $params);
    }

    public function deleteData($attendanceId) {
        return $this->_studentAttendance->updateData($attendanceId, array("is_delete" => 1));
    }

}