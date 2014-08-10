<?php

/**
 * 接口数据处理
 * @author taozywu
 * @date 2014/08/08
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

	public function getDataCount( $where ) {
		$sql = "select count(*) from sch_students where student_id>0 {$where} and is_delete=0";
		$count = $this->_db->fetchOne($sql);

		return $count;
	}

	public function getPageData ($page, $pageSize , $where) {
		$startIndex = (int) ($page-1) * $pageSize;
		$sql = "select * from sch_students where student_id>0 {$where} order by student_id desc limit {$startIndex},{$pageSize}";
		$data = $this->_db->fetchAll($sql);

		return !empty($data) ? $data : array();
	}

	public function getStudentDataByWhere( $where ) {
		$sql = "select student_id,student_no,en_name,cn_name from sch_students where student_id>0 {$where} and is_delete=0";
		$data = $this->_db->fetchAll($sql);

		return !empty($data) ? $data : array();
	}

	public function checkData( $studentId , $typeId , $dealDate ) {
		$sql = "select count(*) from ";
	}

}