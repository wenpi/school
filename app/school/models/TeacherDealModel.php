<?php
defined('PATH_ROOT') or die('Access Denied.');
/**
 * 教工奖惩
 */
class TeacherDealModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_teacherDeal= null;

    private function __construct() {
        $this->_teacherDeal = new Data_TeacherDeal();
    }

    /**
     * 实例化
     * @return TeacherDealModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function getDataCount($where = "") {

        return $this->_teacherDeal->getDataCount($where);
    }

    public function getPageData($page, $pageSize, $where = "") {
        return $this->_teacherDeal->getPageData($page, $pageSize, $where);
    }

    public function checkData($teacherId, $typeId, $checkDate) {
        return $this->_teacherDeal->checkData($teacherId, $typeId, $checkDate);
    }

    public function addData($params) {
        return $this->_teacherDeal->addData($params);
    }

    public function getRowData($dealId) {
        return $this->_teacherDeal->getRowData($dealId);
    }

    public function updateData($dealId, $params) {
        return $this->_teacherDeal->updateData($dealId, $params);
    }

    public function deleteData($dealId) {
        return $this->_teacherDeal->updateData($dealId, array("is_delete" => 1));
    }

}