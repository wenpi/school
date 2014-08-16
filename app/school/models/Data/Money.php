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
    public function getConfigMoneyProjectPageData($page,$pageSize,$where) {
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

}