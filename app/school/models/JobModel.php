<?php
defined('PATH_ROOT') or die('Access Denied.');

class JobModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_job = null;

    private function __construct() {
        $this->_job = new Data_Job();
    }

    /**
     * 实例化
     * @return JobModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function checkData($jobName) {
        return $this->_job->checkData($jobName);
    }

    public function addData($params) {
        return $this->_job->addData($params);
    }

    public function getDataCount($where) {
        return $this->_job->getDataCount($where);
    }

    public function getPageData($page, $pageSize, $where) {
        return $this->_job->getPageData($page, $pageSize, $where);
    }

    public function deleteData($jobId) {
        return $this->_job->deleteData($jobId);
    }

    public function getRowData($jobId) {
        return $this->_job->getRowData( $jobId );
    }

    public function updateData($jobId, $params ) {
        return $this->_job->updateData($jobId, $params);
    }

    public function getJobData( $where = "" ) {
        return $this->_job->getJobData( $where );
    }

}