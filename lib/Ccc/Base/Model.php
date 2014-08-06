<?php

/**
 * 基类Model
 *
 * @author taozywu
 *
 */
class Ccc_Base_Model extends Zend_Db_Table_Abstract {

    public $_db; //数据库实例
    public static $_instance;
    protected $_session;

    public function init() {
        $this->_session = Zend_Registry::get('session');
        $this->setDb();
    }

    /**
     * 获取db实例
     */
    public function setDb() {
        $this->_db = $this->getAdapter();
    }

    public function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getDb() {
        if (empty($this->_db)) {
            return $this->getAdapter();
        } else {
            return $this->_db;
        }
    }

    /**
     * 判断是否要做日志
     * @param type $sql
     * @return type
     */
    public function checkLog($sql) {
        $count = (int) $this->_db->fetchOne($sql);

        return $count;
    }

    /**
     * 记录日志
     * @param type $params
     * @return int
     */
    public function writeLog($tableName, $params) {
        $this->_db->insert($tableName, $params);

        return 1;
    }

}