<?php

defined( 'PATH_ROOT' ) or die( 'Access Denied.' ) ;

/**
 * 短信管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/07/05
 */
class SmsController extends Ccc_Base_Controller
{

	/**
	 * 初始化
	 * @see Ccc_Base_Controller::init()
	 */
	function init()
	{
		parent::init() ;
		$this->checkAuth() ;
		$this->checkLog() ;
		$this->_helper->layout()->setLayout( "ccc" ) ;
	}

	/**
	 * 默认action
	 */
	public function indexAction()
	{
		die ;
	}

	public function listAction()
	{
		echo "dd";
		die ;
	}

	public function sendAction()
	{
		$this->view->title = "发送短信";
		$this->view->classData = ClassModel::getInstance()->getClassData();

	}


	public function sendOkAction() {

	}

	public function ajaxShowUserDataAction() {
		$this->_helper->layout->disableLayout();
	}
}