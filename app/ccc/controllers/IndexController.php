<?php

defined( 'PATH_ROOT' ) or die( 'Access Denied.' ) ;

/**
 * IndexController
 *
 * @author wangchao
 * @version 1
 */
class IndexController extends Ccc_Base_Controller
{

	protected $_indexM ; //模型实例

	/**
	 * 初始化
	 * @see Ccc_Base_Controller::init()
	 */

	public function init()
	{
		parent::init() ;
	}

	public function indexAction()
	{
		$this->_forward( "login" , "admin" ) ;
	}

}
