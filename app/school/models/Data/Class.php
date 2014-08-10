<?php

/**
 * 接口数据处理
 * @author taozywu
 * @date 2014/08/08
 */
class Data_Class extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }


    public function getClassData( $where ) {
        $sql = "select class_id,class_no,class_name from sch_classes where class_id >0 {$where} ";
        $data = $this->_db->fetchAll( $sql );

        return !empty($data) ? $data : array();
    }

    public function getRowData( $classId ) {
        $sql = "select * from sch_classes where class_id={$classId}";
        $data = $this->_db->fetchRow( $sql );

        return !empty($data) ? $data : array();
    }

}