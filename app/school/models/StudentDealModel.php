<?php
defined('PATH_ROOT') or die('Access Denied.');
/**
 * 学生奖惩
 */
class StudentDealModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_studentDeal= null;

    private function __construct() {
        $this->_studentDeal = new Data_StudentDeal();
    }

    /**
     * 实例化
     * @return StudentDealModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function getDataCount($where = "") {

        return $this->_studentDeal->getDataCount($where);
    }

    public function getPageData($page, $pageSize, $where = "") {
        return $this->_studentDeal->getPageData($page, $pageSize, $where);
    }

    public function checkData($studentId, $typeId, $checkDate) {
        return $this->_studentDeal->checkData($studentId, $typeId, $checkDate);
    }

    public function addData($params) {
        return $this->_studentDeal->addData($params);
    }

    public function getRowData($dealId) {
        return $this->_studentDeal->getRowData($dealId);
    }

    public function updateData($dealId, $params) {
        return $this->_studentDeal->updateData($dealId, $params);
    }

    public function deleteData($dealId) {
        return $this->_studentDeal->updateData($dealId, array("is_delete" => 1));
    }

}