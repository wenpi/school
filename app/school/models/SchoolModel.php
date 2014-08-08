<?php
defined('PATH_ROOT') or die('Access Denied.');

class SchoolModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_school = null;

    private function __construct() {
        $this->_school = new Data_School();
    }

    /**
     * 实例化
     * @return SchoolModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function addSchoolData( $params ) {
        return $this->_school->addSchoolData( $params );
    }

    public function getJobData() {
        $jobData = $this->_school->getJobData();
        $arr = array();
        if($jobData) {
            foreach($jobData as $p) {
                $arr[$p['job_id']] = $p['job_name'];
            }
        }

        return $arr;
    }
}