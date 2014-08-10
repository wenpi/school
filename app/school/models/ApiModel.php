<?php

class ApiModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_api = null;

    private function __construct() {
        $this->_api = new Data_Api();
    }

    /**
     * 实例化
     * @return ApiModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }
    
    public function addSchoolData( $params ) {
        return SchoolModel::getInstance()->addSchoolData($params);
    }
    
    
    public function getUserData($where = "" ) {
        return $this->_api->getUserData( $where );
    }

}