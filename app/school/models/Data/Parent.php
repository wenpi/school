<?php

/**
 * 接口数据处理
 * @author sln
 * @date 2013/11/27
 */
class Data_Parent extends Ccc_Base_Model
{

	public function init()
	{
		parent::init() ;
	}

	public function addData( $params )
	{
		$this->_db->insert( "sch_parents" , $params ) ;
		$add = $this->_db->lastInsertId() ;

		return $add ;
	}

	public function getParentDataByWhere ( $where )
	{
		$sql = "select * from sch_parents where parent_id>0 {$where} and is_delete=0";
		$parentData = $this->_db->fetchAll( $sql );

		return !empty($parentData) ? $parentData : array();
	}

}