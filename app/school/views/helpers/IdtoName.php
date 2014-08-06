<?php
/**
 *
 * @author Administrator
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * IdtoName helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_IdtoName {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * 
	 */
	public function idtoName($p) {
		// TODO Auto-generated Zend_View_Helper_IdtoName::idtoName() helper 
		$dbAdapter = Zend_Registry::get('adapter');
		$db = $dbAdapter['db_r'];
		$sql = "SELECT {$p['field']} FROM {$p['tab']} WHERE {$p['condition']} = '{$p['col']}'";
		$rs = $db->fetchOne($sql);;
		return $rs ? $rs : '--';
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
