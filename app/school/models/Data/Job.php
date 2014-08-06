<?php

/**
 * 接口数据处理
 * @author sln
 * @date 2013/11/27
 */
class Data_Job extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function checkData($jobName) {
        $sql = "select count(*) from sch_job where job_name = '{$jobName}' and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function addData($params) {
        $this->_db->insert("sch_job", $params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function getDataCount($where) {
        $sql = "select count(*) from sch_job where job_id>0 {$where} and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function getPageData($page, $pageSize, $where) {
        $startIndex = ($page - 1) * $pageSize;
        $sql = "select * from sch_job where job_id>0 {$where} and is_delete=0 limit {$startIndex} , {$pageSize}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function deleteData($jobId) {
        return $this->updateData($jobId, array("is_delete" => 1));
    }

    public function updateData($jobId, $params) {
        $this->_db->update("sch_job", $params, "job_id=" . $jobId);

        return 1;
    }

    
    public function getRowData( $jobId ) {
        $sql = "select * from sch_job where job_id = {$jobId} and is_delete=0";
        $data = $this->_db->fetchRow( $sql );
        
        return !empty($data) ? $data : array();
    }
    
    public function getJobData($where) {
        $sql = "select job_id,job_name from sch_job where job_id>0 {$where} and is_delete = 0" ;
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }
    
}