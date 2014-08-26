<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 科目管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/07/05
 */
class SubjectController extends Ccc_Base_Controller {

    /**
     * 初始化
     * @see Ccc_Base_Controller::init()
     */
    function init() {
        parent::init();
        $this->checkAuth() ;
        $this->checkLog() ;
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

        $subjectName = trim($this->_getParam("subject_name"));
        // deal with the page.
        $page = (int) $this->_getParam("page");
        $page = $page < 1 ? 1 : $page;
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
//        $pageSize = 1;
        // where
        $where = " ";
        $condition = "";
        
        $where .=!empty($subjectName) ? " and subject_name like '{$subjectName}%' " : "";
        $condition .=!empty($subjectName) ? "/subject_name/{$subjectName}" : "";

        // compare the page data.
        $dataCount = SubjectModel::getInstance()->getDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $data = SubjectModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->data = $data;
        // view page
        $this->view->pageData = array("page" => $page, "url" => "/subject/list{$condition}",
            "page_count" => $pageCount);
        $this->view->title = "科目列表";
        $this->view->subjectName = $subjectName;
    }

    // 添加
    public function ajaxAddAction() {
        $this->view->title = "添加科目信息";
        $this->view->classData = ClassModel::getInstance()->getClassData(" and status in (1,4) ");
    }

    // 保存
    public function ajaxSaveAction() {
        $this->_helper->layout->disableLayout();
        $typeId = (int) $this->_getParam("input_type_id");
        $classId = (int) $this->_getParam("input_class_id");
        $subjectName = trim($this->_getParam("input_subject_name"));
        $comments = trim($this->_getParam("input_comments"));

        $isHas = SubjectModel::getInstance()->checkData($classId, $subjectName);
        if ($isHas > 0) {
            echo "-2";
            exit;
        }
        $classData = ClassModel::getInstance()->getRowData($classId);
        $params = array(
            "type_id" => $typeId,
            "sch_class_id" => $classId,
            "sch_class_no" => isset($classData['class_no']) ? $classData['class_no'] : 0,
            "sch_class_name" => isset($classData['class_name']) ? $classData['class_name'] : "",
            "subject_name" => $subjectName,
            "comments" => $comments,
        );
        $add = SubjectModel::getInstance()->addData($params);
        echo $add;
        exit;
    }

    // 编辑
    public function ajaxEditAction() {
        $subjectId = (int) $this->_getParam("subject_id");
        $this->view->classData = ClassModel::getInstance()->getClassData(" and status in (1,4) ");
        $this->view->subjectData = SubjectModel::getInstance()->getRowData($subjectId);
        $this->view->title = "编辑科目信息";
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

//        echo $subjectName . "-" . $hiddenSubjectName;exit;
        if( $hiddenSubjectName!=$subjectName ) {
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