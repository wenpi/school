<?php

/**
 * 接口数据处理
 * @author sln
 * @date 2013/11/27
 */
class Data_School extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    
    public function addSchoolData ( $params ) {
       $this->_db->insert("sch_school_info", $params);
       return $this->_db->lastInsertId();
    }
    
    public function getJobData() {
        $sql = " select * from sch_job where is_delete=0 ";
        $data = $this->_db->fetchAll( $sql );
        
        return !empty($data) ? $data : array();
    }

}