<?php
defined('PATH_ROOT') or die('Access Denied.');

class StudentModel
{
	/**
	 * 用户类型 ： 学生
	 */

	const USER_TYPE = 2 ;

	/**
	 * 单例
	 * @var type
	 */
	private static $_singletonObject = null ;
	private $_student = null ;

	private function __construct()
	{
		$this->_student = new Data_Student() ;
	}

	/**
	 * 实例化
	 * @return StudentModel
	 */
	public static function getInstance()
	{
		$className = __CLASS__ ;

		if( !isset( self::$_singletonObject [ $className ] ) || !self::$_singletonObject [ $className ] )
		{
			self::$_singletonObject [ $className ] = new self () ;
		}

		return self::$_singletonObject [ $className ] ;
	}

	public function addData( $params )
	{
		return $this->_student->addData( $params ) ;
	}

	public function dealParentParams( $parentEnName , $parentCnName ,
		$parentNamed , $parentPhone , $parentMobilePhone , $parentIsMessage )
	{
		$result = array( ) ;
		$this->_getDealParentParams( "en_name" , $parentEnName , $result ) ;
		$this->_getDealParentParams( "cn_name" , $parentCnName , $result ) ;
		$this->_getDealParentParams( "parent_named" , $parentNamed , $result ) ;
		$this->_getDealParentParams( "phone" , $parentPhone , $result ) ;
		$this->_getDealParentParams( "mobile_phone" , $parentMobilePhone , $result ) ;
		$this->_getDealParentParams( "is_message" , $parentIsMessage , $result ) ;

		return $result ;
	}

	private function _getDealParentParams( $key , $data , &$result )
	{
		if( $data )
		{
			foreach( $data as $k => $v )
			{
				$result[ $k ][ $key ] = $v ;
			}
		}
	}

	public function getRowData( $studentId )
	{
		return $this->_student->getRowData( $studentId ) ;
	}

	public function updateData( $studentId , $params )
	{
		return $this->_student->updateData( $studentId , $params ) ;
	}

	public function deleteData( $studentId )
	{
		$params = array( "is_delete" => 1 ) ;
		$delete = $this->updateData( $studentId , $params ) ;
		if( $delete > 0 )
		{
			ParentModel::getInstance()->deleteDataByWhere( " sch_student_id={$studentId} " ) ;
		}

		return 1 ;
	}

	public function getDataCount( $where = " " )
	{
		return $this->_student->getDataCount( $where ) ;
	}

	public function getPageData( $page , $pageSize , $where )
	{
		return $this->_student->getPageData( $page , $pageSize , $where ) ;
	}

	public function getStudentDataByWhere( $where = " " )
	{
		return $this->_student->getStudentDataByWhere( $where ) ;
	}

	public function checkData( $studentId , $typeId , $dealDate )
	{
		return $this->_student->checkData( $studentId , $typeId , $dealDate ) ;
	}



}