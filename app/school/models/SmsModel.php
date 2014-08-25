<?php

defined('PATH_ROOT') or die('Access Denied.');

class SmsModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_sms = null;

    private function __construct() {
        $this->_sms = new Data_Sms();
    }

    /**
     * 实例化
     * @return SmsModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function getUserDataByWhere($type,$where ="") {
        $arr = array();
        if($type==1) {
            $data = StudentModel::getInstance()->getStudentDataByWhere($where);
            if($data)  {
                foreach($data as $p){
                    $parentRowData = ParentModel::getInstance()->getParentDataBySms($p['student_id']);
                    $mobilePhone = isset($parentRowData['mobile_phone']) ? $parentRowData['mobile_phone'] : "";
                    $arr[] = array("user_id"=>$p['student_id'],"user_name"=>$p['cn_name'],"user_no"=>$p['student_no'],
                        "user_phone"=>$mobilePhone);
                }
            }
        } else {
            $data = TeacherModel::getInstance()->getTeacherDataByWhere($where);
            if($data)  {
                foreach($data as $p){
                    $arr[] = array("user_id"=>$p['teacher_id'],"user_name"=>$p['cn_name'],"user_no"=>$p['teacher_no'],
                        "user_phone"=>$p['mobile_phone']);
                }
            }
        }
        
        return $arr;
    }
    
    public function addData($params) {
        return $this->_sms->addData($params);
    }
    
    public function getDataCount($where="") { 
        return $this->_sms->getDataCount($where);
    }
    
    public function getPageData($page,$pageSize,$where="") {
        return $this->_sms->getPageData($page,$pageSize,$where);
    }
    public function getRowData($messageSendId) {
        return $this->_sms->getRowData($messageSendId);
    }
}