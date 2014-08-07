<?php

class ParentModel {
    /**
     * 用户类型 ： 家长
     */

    const USER_TYPE = 3;

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_parent = null;

    private function __construct() {
        $this->_parent = new Data_Parent();
    }

    /**
     * 实例化
     * @return ParentModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function addData($params) {
        return $this->_parent->addData($params);
    }

    public function getParentDataByWhere($where = "") {
        return $this->_parent->getParentDataByWhere($where);
    }

    public function updateData($parentId, $params) {
        return $this->_parent->updateData($parentId, $params);
    }

    public function getParentDataCountByWhere( $where = "" ) {
        return $this->_parent->getParentDataCountByWhere($where);
    }

    public function deleteDataByWhere( $where= "" ){
        $params = array("is_delete"=>1);

        return $this->_parent->deleteDataByWhere( $where , $params );
    }

	



}