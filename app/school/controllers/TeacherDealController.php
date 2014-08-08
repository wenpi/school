<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 教工惩罚管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/07/05
 */
class TeacherDealController extends Ccc_Base_Controller {

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

    public function listAction() {
        // get the paramter.
        $teacherId = (int) $this->_getParam("teacher_id");
        $startDate = trim($this->_getParam("start_date"));
        $endDate = trim($this->_getParam("end_date"));

        $page = (int) $this->_getParam("page");
        $page = $page < 1 ? 1 : $page;
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        $where = "";
        $condition = "";

        if ($teacherId > 0) {
            $where .= " and teacher_id = {$teacherId} ";
            $condition .= "/teacher_id/{$teacherId}";
        }
        if (!empty($startDate)) {
            $where .= " and deal_date>='{$startDate}' ";
            $condition .= "/start_date/{$startDate}";
        }
        if (!empty($endDate)) {
            $where .= " and deal_date<='{$endDate}'";
            $condition .= "/end_date/{$endDate}";
        }

        // count.
        $dataCount = TeacherDealModel::getInstance()->getDataCount($where);
//        echo $dataCount;exit;
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $this->view->title = "教工奖惩管理";
        $this->view->data = TeacherDealModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->pageData = array("page" => $page, "url" => "/teacherdeal/list{$condition}","page_count" => $pageCount);
        $this->view->teacherData = TeacherModel::getInstance()->getTeacherDataByWhere(  );
        $this->view->teacherId = $teacherId;
        $this->view->startDate = $startDate;
        $this->view->endDate = $endDate;
        $this->view->from = base64_encode("/page/{$page}" . $condition);
    }

    public function ajaxAddAction() {
        $this->view->showTeacher = (int) $this->_getParam("show_teacher");
        $this->view->title = "添加教工奖惩信息";
        $this->view->teacherData = TeacherModel::getInstance()->getTeacherDataByWhere();
        // 通过工号找到teacher表中的teacher_id.
        $this->view->teacherId = TeacherModel::getInstance()->getTeacherIdByJobNumber($this->_session->uname);
    }


    public function ajaxSaveAction() {
        $this->_helper->layout->disableLayout();
        $teacherId = (int) $this->_getParam("input_teacher_id");
        $typeId = (int) $this->_getParam("input_type_id");
        $dealName = trim($this->_getParam("input_deal_name"));
        $dealDate = trim($this->_getParam("input_deal_date"));
        $dealReason = trim($this->_getParam("input_deal_reason"));

        $isHas = TeacherDealModel::getInstance()->checkData($teacherId, $typeId, $dealDate);
        if($isHas>0) {
            echo "-2";
            exit;
        }
        $teacherData = TeacherModel::getInstance()->getRowData( $teacherId );
        $params = array(
            "teacher_id" => $teacherId,
            "teacher_no" => isset($teacherData['teacher_no'])?$teacherData['teacher_no']:"",
            "teacher_name" => isset($teacherData['cn_name'])?$teacherData['cn_name']:"",
            "deal_date" =>$dealDate,
            "type_id" => $typeId,
            "deal_name" => $dealName,
            "deal_reason" => $dealReason,
            "deal_user_id" => $this->_session->uid,
            "deal_real_name" => $this->_session->unickname,
        );
        $add = TeacherDealModel::getInstance()->addData($params);
        echo $add;
        exit;
    }

    public function ajaxEditAction() {
        $this->_helper->layout->disableLayout();
        $dealId = (int) $this->_getParam("deal_id");
        $this->view->data = TeacherDealModel::getInstance()->getRowData( $dealId );
        $this->view->teacherData = TeacherModel::getInstance()->getTeacherDataByWhere();
        $this->view->title = "编辑教工奖惩信息";
        $this->view->showTeacher = (int) $this->_getParam("show_teacher");
    }

    public function ajaxUpdateAction() {
        $this->_helper->layout->disableLayout();
        $dealId = (int) $this->_getParam("deal_id");
        $dealName = trim($this->_getParam("input_deal_name"));
        $dealReason = trim($this->_getParam("input_deal_reason"));
        $params = array(
            "deal_name" => $dealName,
            "deal_reason" => $dealReason,
        );
        $update = TeacherDealModel::getInstance()->updateData( $dealId , $params );
        echo $update;
        exit;
    }

    public function myListAction() {
        // get the paramter.
        $teacherId = (int) $this->_getParam("teacher_id");
        $startDate = trim($this->_getParam("start_date"));
        $endDate = trim($this->_getParam("end_date"));

        $page = (int) $this->_getParam("page");
        $page = $page < 1 ? 1 : $page;
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        $where = " and teacher_no = '{$this->_session->uname} ";
        $condition = "";

        if ($teacherId > 0) {
            $where .= " and teacher_id = {$teacherId} ";
            $condition .= "/teacher_id/{$teacherId}";
        }
        if (!empty($startDate)) {
            $where .= " and deal_date>='{$startDate}' ";
            $condition .= "/start_date/{$startDate}";
        }
        if (!empty($endDate)) {
            $where .= " and deal_date<='{$endDate}'";
            $condition .= "/end_date/{$endDate}";
        }

        // count.
        $dataCount = TeacherDealModel::getInstance()->getDataCount($where);
//        echo $dataCount;exit;
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $this->view->title = "我的教工奖惩管理";
        $this->view->data = TeacherDealModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->pageData = array("page" => $page, "url" => "/teacherdeal/my.list{$condition}","page_count" => $pageCount);
//        $this->view->teacherData = TeacherModel::getInstance()->getTeacherDataByWhere(  );
        $this->view->teacherId = $teacherId;
        $this->view->startDate = $startDate;
        $this->view->endDate = $endDate;
        $this->view->from = base64_encode("/page/{$page}" . $condition);
    }

    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $dealId = (int) $this->_getParam("deal_id");
        $showTeacher = (int) $this->_getParam("show_teacher");
        $from = trim($this->_getParam("from"));
        $from = !empty($from) ? base64_decode($from) : "";
        $delete = TeacherDealModel::getInstance()->deleteData($dealId);
        $url = $showTeacher == 0 ? "/teacherdeal/my.list{$from}" : "/teacherdeal/list{$from}";
        if($delete>0) {
            Ccc_Helper_Com::alertMess($url, "操作成功");
        } else {
            Ccc_Helper_Com::alertMess($url, "操作失败" );
        }
    }


}