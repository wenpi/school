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

    // 编辑
    public function ajaxEditAction() {
        $subjectId = (int) $this->_getParam("subject_id");
        $this->view->classData = ClassModel::getInstance()->getClassData();
        $this->view->subjectData = SubjectModel::getInstance()->getRowData($subjectId);
        $this->view->title = "编辑班级信息";
    }

    // 保存编辑
    public function ajaxUpdateAction() {
        $this->_helper->layout->disableLayout();
        $subjectId = (int) $this->_getParam("subject_id");
        $typeId = (int) $this->_getParam("input_type_id");
        $subjectName = trim($this->_getParam("input_subject_name"));
        $comments = trim($this->_getParam("input_comments"));
        $hiddenClassId = (int) $this->_getParam("hidden_class_id");
        $hiddenSubjectName = trim($this->_getParam("hidden_subject_name"));

        if ($hiddenSubjectName != $subjectName) {
            $isHas = SubjectModel::getInstance()->checkData($hiddenClassId, $subjectName);
            if ($isHas > 0) {
                echo "-2";
                exit;
            }
        }

        $params = array(
            "type_id" => $typeId,
            "subject_name" => $subjectName,
            "comments" => $comments,
        );
        $update = SubjectModel::getInstance()->updateData($subjectId, $params);
        echo $update;
        exit;
    }

    // 删除
    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $subjectId = (int) $this->_getParam("subject_id");
        $delete = SubjectModel::getInstance()->delete($subjectId);
        if ($delete > 0) {
            Ccc_Helper_Com::alertMess("/subject/list", "操作成功");
        } else {
            Ccc_Helper_Com::alertMess("/subject/list", "操作失败");
        }
    }

}