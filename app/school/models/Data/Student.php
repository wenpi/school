<?php

/**
 * 接口数据处理
 * @author sln
 * @date 2013/11/27
 */
class Data_Student extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function addData($params ) {
        $this->_db->insert("sch_students",$params);
        $add = $this->_db->lastInsertId();
		if( $add>0 ) {
			$this->updateData( $add , array( "student_no" => $add ) ) ;
		}
        return $add;
    }

    public function updateData($studentId, $params) {
        $this->_db->update("sch_students", $params, "student_id=" . $studentId);
        return 1;
    }

	public function getRowData( $studentId ) {
		$sql = "select * from sch_students where student_id={$studentId} ";
		$studentData = $this->_db->fetchRow( $sql );

		return !empty($studentData) ? $studentData : array();
	}


}