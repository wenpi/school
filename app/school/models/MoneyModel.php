<?php

defined('PATH_ROOT') or die('Access Denied.');

class MoneyModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_money = null;

    private function __construct() {
        $this->_money = new Data_Money();
    }

    /**
     * 实例化
     * @return MoneyModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function getConfigTermPageData($page = 1, $pageSize = 20, $where = "") {
        return $this->_money->getConfigTermPageData($page, $pageSize, $where);
    }

    public function getConfigTermRowData($termId) {
        return $this->_money->getConfigTermRowData($termId);
    }

    public function updateConfigTermData($termId, $params) {
        return $this->_money->updateConfigTermData($termId, $params);
    }

    public function deleteConfigTermData($termId) {
        return $this->_money->updateConfigTermData($termId, array("is_delete" => 1));
    }

    //###########################
    public function getConfigMoneyProjectPageData($page = 1, $pageSize = 20, $where = "") {
        return $this->_money->getConfigMoneyProjectPageData($page, $pageSize, $where);
    }

    public function getConfigMoneyProjectRowData($mpId) {
        return $this->_money->getConfigMoneyProjectRowData($mpId);
    }

}