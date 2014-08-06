<?php

class SubjectModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_subject = null;

    private function __construct() {
        $this->_subject = new Data_Subject();
    }

    /**
     * 实例化
     * @return SubjectModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function getPageData($page, $pageSize, $where) {
        return $this->_subject->getPageData($page, $pageSize, $where);
    }
    
    
    public function getDataCount( $where ) {
        return $this->_subject->getDataCount( $where );
    }

    public function checkData( $classId , $subjectName ) {
        return $this->_subject->checkData( $classId , $subjectName );
    }
    
    public function addData( $params ) {
        return $this->_subject->addData($params);
    }
    
    public function getRowData($subjectId ) {
        return $this->_subject->getRowData($subjectId);
    }
    
    public function updateData($subjectId,$params) {
        return $this->_subject->updateData($subjectId,$params);
    }
    
    public function delete($subjectId ) {
        $params = array(
            "is_delete" => 1,
        );
        
        return $this->_subject->updateData($subjectId,$params);
    }
}