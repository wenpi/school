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
    
    public function getConfigTermDataCount($where="") {
        return $this->_money->getConfigTermDataCount($where);
    } 

    
    public function getConfigTermPageData($page = 1, $pageSize = 20, $where = "") {
        return $this->_money->getConfigTermPageData($page, $pageSize, $where);
    }
    
    public function checkConfigTermData($year, $type,$termName) {
        return $this->_money->checkConfigTermData($year,$type,$termName);
    }
    
    public function addConfigTermData($params) {
        return $this->_money->addConfigTermData($params);
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
    public function getConfigMoneyProjectDataCount($where= "") {
        return $this->_money->getConfigMoneyProjectDataCount($where);
    }
    
    
    public function getConfigMoneyProjectPageData($page = 1, $pageSize = 20, $where = "") {
        return $this->_money->getConfigMoneyProjectPageData($page, $pageSize, $where);
    }

    public function getConfigMoneyProjectRowData($mpId) {
        return $this->_money->getConfigMoneyProjectRowData($mpId);
    }

    public function getConfigTermData($where = "") {
        return $this->_money->getConfigTermData($where);
    }

    public function getConfigMoneyProjectData($where = "") {
        return $this->_money->getConfigMoneyProjectData($where);
    }
    
    public function checkConfigMoneyProjectData($projectName) { 
        return $this->_money->checkConfigMoneyProjectData($projectName);
    }
    
    public function addConfigMoneyProjectData($params) { 
        return $this->_money->addConfigMoneyProjectData($params);
    }
    
    public function updateConfigMoneyProjectData($projectId,$params) {
        return $this->_money->updateConfigMoneyProjectData($projectId, $params);
    }
    
    public function deleteConfigMoneyProjectData($projectId) {
        $params = array("is_delete"=>1);
        
        return $this->updateConfigMoneyProjectData($projectId, $params);
    }

    public function checkData($classId, $termId = 0, $month = 0, $projectId = 0) {
        return $this->_money->checkData($classId, $termId, $month, $projectId);
    }

    public function addData($params) {
        return $this->_money->addData($params);
    }

    public function getConfigMoneyDataCount($where = "") {
        return $this->_money->getConfigMoneyDataCount($where);
    }

    public function getConfigMoneyPageData($page, $pageSize, $where = "") {
        return $this->_money->getConfigMoneyPageData($page, $pageSize, $where);
    }

    public function deleteConfigMoneyData($mcId) {
        $params = array("is_delete" => 1);
        return $this->_money->updatConfigMoneyData($mcId, $params);
    }

    public function updatConfigMoneyData($mcId, $params) {
        return $this->_money->updatConfigMoneyData($mcId, $params);
    }

    public function getConfigTermDataByWhere($where = "") {
        $termData = $this->getConfigTermData($where);
        $termResult = array();
        if ($termData) {
            foreach ($termData as $p) {
                $termResult[$p['term_id']] = $p['term_name'];
            }
        }

        return $termResult;
    }

    public function getConfigMoneyProjectDataByWhere($where = "") {
        $projectData = $this->getConfigMoneyProjectData($where);
        $projectResult = array();
        if ($projectData) {
            foreach ($projectData as $p) {
                $projectResult[$p['money_project_id']] = $p['money_project_name'];
            }
        }

        return $projectResult;
    }

    public function getConfigMoneyRowData($mcId) {
        return $this->_money->getConfigMoneyRowData($mcId);
    }

    public function updateConfigMoneyData($mcId, $params) {
        return $this->_money->updateConfigMoneyData($mcId, $params);
    }

    public function getMoneyPageData($page, $pageSize, $where = "") {
        return $this->_money->getMoneyPageData($page, $pageSize, $where);
    }

    public function getMoneyByWhere($classId, $termId, $month = 0, $projectId = 0) {
        return $this->_money->getMoneyByWhere($classId, $termId, $month, $projectId);
    }

    public function getMoneyMaxNumberByWhere($moneyDate, $classId) {
        return $this->_money->getMoneyMaxNumberByWhere($moneyDate, $classId);
    }

    public function addMoneyData($params) {
        return $this->_money->addMoneyData($params);
    }

    public function getMoneyDataCount($where = "") {
        return $this->_money->getMoneyDataCount($where);
    }

    public function getMoneyRowData($mdId) {
        return $this->_money->getMoneyRowData($mdId);
    }

    public function updateMoneyData($mdId, $params) {
        return $this->_money->updateMoneyData($mdId, $params);
    }

    public function getStudentMoneyPageData($page, $pageSize, $where = "") {
        return $this->_money->getStudentMoneyPageData($page, $pageSize, $where);
    }

    public function getStudentMoneyDataCount($where = "") {
        return $this->_money->getStudentMoneyDataCount($where);
    }
    
    public function addStudentMoneyData($params) {
        return $this->_money->addStudentMoneyData($params);
    }
    
    public function getStudentMoneyRowData($smdId) {
        return $this->_money->getStudentMoneyRowData($smdId);
    }
    
    public function deleteMoneyData($mdId) {
        $params = array("is_delete"=>1);
        
        return $this->updateMoneyData($mdId, $params);
    }
    
    public function deleteStudentMoneyData($smdId) {
        $params = array("is_delete"=>1);
        
        return $this->updateStudentMoneyData($smdId,$params);
    }
    
    public function updateStudentMoneyData($smdId,$params) {
        return $this->_money->updateStudentMoneyData($smdId,$params);
    }
}