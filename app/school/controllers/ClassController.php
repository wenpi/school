<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 班级管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/07/05
 */
class ClassController extends Ccc_Base_Controller {

    /**
     * 初始化
     * @see Ccc_Base_Controller::init()
     */
    function init() {
        parent::init();
        $this->checkAuth();
        $this->checkLog();
        $this->_helper->layout()->setLayout("ccc");
    }

    /**
     * 默认action
     */
    public function indexAction() {
        die;
    }

    /**
     * 列表
     */
    public function listAction() {

        // deal with the page.
        $page = (int) $this->_getParam("page");
        $page = $page < 1 ? 1 : $page;
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        // where
        $where = " ";
        $condition = "";
        $className = trim($this->_getParam("class_name"));
        if(!empty($className)) {
            $where .= " and class_name  like '{$className}%' ";
            $condition .= "/class_name/{$className}";
        }

        // compare the page data.
        $dataCount = ClassModel::getInstance()->getDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $data = ClassModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->data = $data;
        // view page
        $this->view->pageData = array("page" => $page, "url" => "/class/list{$condition}",
            "page_count" => $pageCount);
        $this->view->title = "班级列表";
        $this->view->className = $className;
        $this->view->from = base64_encode( urlencode("/page/{$page}" . $condition) );
    }

    // 添加
    public function ajaxAddAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title1 = "添加班级信息";
        $this->view->title2 = "添加特长班信息";
        $this->view->teacherData = TeacherModel::getInstance()->getTeacherDataByWhere();
    }

    // 保存
    public function ajaxSaveAction() {
        $this->_helper->layout->disableLayout();
        $property = (int) $this->_getParam("input_property");
        $teacherId = (int) $this->_getParam("input_teacher_id");
        $className = trim($this->_getParam("input_class_name"));
        $amount = (int) $this->_getParam("input_amount");
        $classMinute = (int) $this->_getParam("input_class_minute");
        $classAddress = trim($this->_getParam("input_class_address"));
        $classTime = trim($this->_getParam("input_class_time"));
        $openDate = trim($this->_getParam("input_open_date"));
        $comments = trim($this->_getParam("input_comments"));

        $isHas = ClassModel::getInstance()->checkData($className);
        if ($isHas > 0) {
            echo "-2";
            exit;
        }
        $teacherData = TeacherModel::getInstance()->getRowData($teacherId);
        $params = array(
            "sch_teacher_id" => $teacherId,
            "sch_teacher_no" => isset($teacherData['teacher_no'])?$teacherData['teacher_no']:"",
            "sch_teacher_name" => isset($teacherData['cn_name'])?$teacherData['cn_name']:"",
            "property" => $property,
            "class_name" => $className,
            "amount" => $amount,
            "class_minute" => $classMinute,
            "class_address" => $classAddress,
            "class_time" => $classTime,
            "open_date" => $openDate,
            "add_user_id" => $this->_session->uid,
            "add_time_int" => time(),
            "comments" => $comments,
        );
        $add = ClassModel::getInstance()->addData($params);
        if ($add > 0) {
            // 更新班级班号/班级编码
            $classNumber = $property . sprintf("%02d", $add);
            $updateParams = array(
                "class_number" => $classNumber,
                "class_no" => $add,
            );
            $update = ClassModel::getInstance()->updateData($add, $updateParams);
        }

        if ($add > 0 && $update > 0) {
            echo 1;
        } else {
            echo "-1";
        }
        exit;
    }
    
    public function ajaxViewAction() {
        $this->_helper->layout->disableLayout();
        $classId = (int) $this->_getParam("class_id");
        $this->view->classData  = ClassModel::getInstance()->getRowData($classId);
        $this->view->title = "查看班级信息";
        $this->view->from = trim($this->_getParam("from"));
    }

    // 编辑
    public function ajaxEditAction() {
        $this->_helper->layout->disableLayout();
        $classId = (int) $this->_getParam("class_id");
        $this->view->classData = ClassModel::getInstance()->getRowData($classId);
        $this->view->teacherData = TeacherModel::getInstance()->getTeacherDataByWhere();
        $this->view->title = "编辑班级信息";
        $this->view->from = trim($this->_getParam("from"));
    }

    // 保存编辑
    public function ajaxUpdateAction() {
        $this->_helper->layout->disableLayout();
        
        $property = (int) $this->_getParam("input_property");
        $teacherId = (int) $this->_getParam("input_teacher_id");
        $className = trim($this->_getParam("input_class_name"));
        $amount = (int) $this->_getParam("input_amount");
        $classMinute = (int) $this->_getParam("input_class_minute");
        $classAddress = trim($this->_getParam("input_class_address"));
        $classTime = trim($this->_getParam("input_class_time"));
        $openDate = trim($this->_getParam("input_open_date"));
        $comments = trim($this->_getParam("input_comments"));
        
        $hiddenClassId = (int) $this->_getParam("class_id");
        $hiddenClassName = trim($this->_getParam("hidden_input_class_name"));
        $hiddenFrom = trim($this->_getParam("hidden_from"));

        if ($hiddenClassName != $className) {
            $isHas = ClassModel::getInstance()->checkData($className);
            if ($isHas > 0) {
                $result = array(
                    "error_code"=>0,
                    "msg"=>"",
                    "data"=>array("update"=>"-2" ) );
                echo Ccc_Third_Json::getInstance()->encode($result);
                exit;
            }
        }

        $teacherData = TeacherModel::getInstance()->getRowData($teacherId);
        $params = array(
            "sch_teacher_id" => $teacherId,
            "sch_teacher_no" => isset($teacherData['teacher_no'])?$teacherData['teacher_no']:"",
            "sch_teacher_name" => isset($teacherData['cn_name'])?$teacherData['cn_name']:"",
            "property" => $property,
            "class_name" => $className,
            "amount" => $amount,
            "class_minute" => $classMinute,
            "class_address" => $classAddress,
            "class_time" => $classTime,
            "open_date" => $openDate,
            "update_user_id" => $this->_session->uid,
            "update_time_int" => time(),
            "comments" => $comments,
        );
        $update = ClassModel::getInstance()->updateData($hiddenClassId, $params);
        $result = array(
            "error_code"=>0,
            "msg"=>"",
            "data"=>array("update"=>$update,"from"=> urldecode( base64_decode($hiddenFrom) ) ) );
        echo Ccc_Third_Json::getInstance()->encode($result);
        exit;
    }

    // 删除
    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $classId = (int) $this->_getParam("class_id");
        $from = trim($this->_getParam("from"));
        $from = urldecode( base64_decode( $from ) );
        $delete = ClassModel::getInstance()->deleteData($classId);
        if ($delete > 0) {
            Ccc_Helper_Com::alertMess("/class/list" . $from, "操作成功");
        } else {
            Ccc_Helper_Com::alertMess("/class/list" . $from, "操作失败");
        }
    }
    
    public function ajaxSetStudentAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title = "配置学生";
        $classId = (int) $this->_getParam("class_id");
        $classData = ClassModel::getInstance()->getRowData($classId);
        if( $classData ) {
            if($classData['property']==0) {
                echo "-1";
                exit;
            }
        }
        $this->view->leftData = ClassModel::getInstance()->getStudentDataBySpecial( $classId );
        $this->view->rightData = ClassModel::getInstance()->getStudentDataByNotSpecial( $classId );
        $this->view->classId = $classId;
        $this->view->from = trim($this->_getParam("from"));
    }
    
    public function ajaxSaveSetStudentAction() {
        $this->_helper->layout->disableLayout();
        $classId = (int) $this->_getParam("class_id");
        $studentIds = trim($this->_getParam("student_ids"));
        $studentIdResult = @explode("|", $studentIds);
        @array_shift($studentIdResult);
        
        $delete = ClassModel::getInstance()->deleteStudentDataByClassId($classId);
        $save = 0;
        if( !empty($studentIdResult) && $delete > 0 ) {
            $save = ClassModel::getInstance()->addStudentDataBySpecial($classId, $studentIdResult);
        }
        if( empty($studentIdResult) && $delete > 0 ) {
            $save = 1;
        }
        echo $save;
        exit;
        
    }
}