<?php
/**
 *
 * @author Administrator
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * DataGrid helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_DataGrid {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * 
	 */
	public function dataGrid($fields = array(), $filter = array(), $script = 'datagrid/dataGrid.phtml') {
		// TODO Auto-generated Zend_View_Helper_DataGrid::dataGrid() helper 
		$this->view->fields = $fields;
		$this->view->filter = $filter;
		$html = $this->view->render($script);
		return $html;
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
