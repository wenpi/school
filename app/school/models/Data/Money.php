<?php

/**
 * 接口数据处理
 * @author taozywu
 * @date 2014/08/08
 */
class Data_Money extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function getConfigTermDataCount($where) {
        $sql = "select count(*) from sch_term_config where term_id>0 {$where} and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    /**
     * 获取学期配置分页信息
     * @param type $page
     * @param type $pageSize
     * @param type $where
     * @return type
     */
    public function getConfigTermPageData($page, $pageSize, $where) {
        $startIndex = (int) ($page - 1) * $pageSize;
        $sql = "select * from sch_term_config where term_id>0 {$where} "
            . "and is_delete=0 limit {$startIndex},{$pageSize}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * 查看学期配置一条信息
     * @param type $termId
     */
    public function getConfigTermRowData($termId) {
        $sql = "select * from sch_term_config where term_id={$termId} and is_delete=0";
        $termConfigRowData = $this->_db->fetchRow($sql);

        return !empty($termConfigRowData) ? $termConfigRowData : array();
    }

    public function updateConfigTermData($termId, $params) {
        $this->_db->update("sch_term_config", $params, "term_id=" . $termId);

        return 1;
    }

    //############################
    public function getConfigMoneyProjectDataCount($where) {
        $sql = "select count(*) from sch_money_projects where money_project_id>0 {$where} and is_delete=0";
        $count = $this->_db->fetchOne($sql);
        
        return $count;
    }
    
    public function getConfigMoneyProjectPageData($page, $pageSize, $where) {
        $startIndex = (int) ($page - 1) * $pageSize;
        $sql = "select * from sch_money_projects where money_project_id>0 {$where} "
            . "and is_delete=0 limit {$startIndex},{$pageSize}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function getConfigMoneyProjectRowData($mpId) {
        $sql = "select * from sch_money_projects where money_project_id={$mpId} and is_delete=0";
        $moneyProjectConfigRowData = $this->_db->fetchRow($sql);

        return !empty($moneyProjectConfigRowData) ? $moneyProjectConfigRowData : array();
    }

    public function getConfigTermData($where) {
        $sql = "select * from sch_term_config where term_id>0 {$where}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function getConfigMoneyProjectData($where) {
        $sql = "select * from sch_money_projects where money_project_id>0 {$where}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function checkData($classId, $termId, $month, $projectId) {
        $sql = "select count(*) from sch_money_config where sch_class_id={$classId} 
            and sch_term_id={$termId} and month={$month} and sch_money_project_id={$projectId}";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function addData($params) {
        $this->_db->insert("sch_money_config", $params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function getConfigMoneyDataCount($where = "") {
        $sql = "select count(*) from sch_money_config where money_config_id>0 {$where} and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function getConfigMoneyPageData($page, $pageSize, $where) {
        $startIndex = (int) ($page - 1) * $pageSize;
        $sql = "select * from sch_money_config where money_config_id>0 {$where} and is_delete=0 limit {$startIndex},{$pageSize}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function updatConfigMoneyData($mcId, $params) {
        $this->_db->update("sch_money_config", $params, "money_config_id=" . $mcId);

        return 1;
    }

    public function getConfigMoneyRowData($mcId) {
        $sql = "select * from sch_money_config where money_config_id={$mcId}";
        $configMoneyData = $this->_db->fetchRow($sql);

        return !empty($configMoneyData) ? $configMoneyData : array();
    }

    public function updateConfigMoneyData($mcId, $params) {
        $this->_db->update("sch_money_config", $params, "money_config_id=" . $mcId);

        return 1;
    }

    public function getMoneyPageData($page, $pageSize, $where) {
        $startIndex = (int) ($page - 1) * $pageSize;
        $sql = "select * from sch_money_data where money_data_id>0 {$where} and is_delete=0 limit {$startIndex},{$pageSize}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function getMoneyByWhere($classId, $termId, $month, $projectId) {
        $where = $month != 0 ? " and month={$month} " : "";
        $sql = "select money from sch_money_config where sch_class_id={$classId} "
            . "and sch_term_id={$termId} {$where} and sch_money_project_id={$projectId} and is_delete=0";
        $money = $this->_db->fetchOne($sql);
        if ($money <= 0) {
            $sql = "select money from sch_money_config where sch_class_id={$classId} "
                . "and sch_term_id={$termId} and sch_money_project_id={$projectId} and is_delete=0";
            $money = $this->_db->fetchOne($sql);
        }

        return $money <= 0 ? 0 : $money;
    }

    // 通过费用日期+班级编号来查找最大流水号
    public function getMoneyMaxNumberByWhere($moneyDate, $classId) {
        $sql = "SELECT RIGHT(`money_number`,3) AS t FROM sch_money_data WHERE money_date='{$moneyDate}' "
            . "AND sch_class_id = '{$classId}' ORDER BY t DESC LIMIT 1;";
        $moneyNumber = $this->_db->fetchOne($sql);

        return $moneyNumber;
    }

    public function addMoneyData($params) {
        $this->_db->insert("sch_money_data", $params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function getMoneyDataCount($where) {
        $sql = "select count(*) from sch_money_data where money_data_id>0 {$where} and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function getMoneyRowData($mdId) {
        $sql = "select * from sch_money_data where money_data_id={$mdId}";
        $moneyRowData = $this->_db->fetchRow($sql);

        return !empty($moneyRowData) ? $moneyRowData : array();
    }

    public function updateMoneyData($mdId, $params) {
        $this->_db->update("sch_money_data", $params, "money_data_id=" . $mdId);

        return 1;
    }

    public function getStudentMoneyPageData($page, $pageSize, $where) {
        $startIndex = (int) ($page - 1) * $pageSize;
        $sql = "SELECT ssmd.`student_money_data_id`,ssmd.`sch_class_id`,ssmd.`sch_class_name`,"
            . "ssmd.`sch_class_no`,ssmd.`sch_term_id`,ssmd.`sch_term_name`,ssmd.`sch_student_id`,"
            . "ssmd.`sch_student_name`,ssmd.`sch_student_no`,ssmd.status,"
            . "smd.`money_data_id`,smd.`money_number`,smd.`type`,smd.`money_date`,smd.`money_name`,"
            . "smd.`sch_money_project_id`,smd.`sch_money_project_name`,smd.`money`,smd.`realy_money` "
            . "FROM sch_student_money_data AS ssmd,sch_money_data AS smd WHERE "
            . "ssmd.`sch_money_data_id` = smd.`money_data_id` {$where} AND ssmd.`is_delete`=0 "
            . "AND smd.`is_delete`=0 limit {$startIndex},{$pageSize}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function getStudentMoneyDataCount($where) {
        $sql = "SELECT COUNT(*) FROM sch_student_money_data AS ssmd,sch_money_data AS smd "
            . "WHERE ssmd.`sch_money_data_id` = smd.`money_data_id` {$where} AND ssmd.`is_delete`=0 "
            . "AND smd.`is_delete`=0 ";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function addStudentMoneyData($params) {
        $this->_db->insert("sch_student_money_data", $params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function getStudentMoneyRowData($smdId) {
        $sql = "select * from sch_student_money_data where student_money_data_id={$smdId} and is_delete=0";
        $studentMoneyRowData = $this->_db->fetchRow($sql);
        $moneyDataId = isset($studentMoneyRowData['sch_money_data_id']) ? $studentMoneyRowData['sch_money_data_id'] : 0;
        $moneyRowData = $this->getMoneyRowData($moneyDataId);
        $studentMoneyRowData['item_money'] = $moneyRowData;

        return $studentMoneyRowData;
    }

    public function updateStudentMoneyData($smdId, $params) {
        $this->_db->update("sch_student_money_data", $params, "student_money_data_id=" . $smdId);

        return 1;
    }

}