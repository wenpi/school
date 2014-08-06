<?php

/**
 * 基类Function
 *
 * @author taozywu
 *
 */
class Ccc_Base_Func extends Ccc_Base_Model {

    private $_extDb = null;

    public function init() {
        parent::init();

//		$adapter = Zend_Registry::get( "adapter" ) ;
//		$this->_extDb = is_array( $adapter ) ? $adapter[ 'db_testsystem' ] : null ;
//		if( $this->_extDb == null )
//		{
//			return false ;
//		}
    }

}