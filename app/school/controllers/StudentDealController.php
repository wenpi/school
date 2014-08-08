<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 学生奖惩管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/07/05
 */
class StudentDealController extends Ccc_Base_Controller {

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
        $studentId = (int) $this->_getParam("student_id");
        $startDate = trim($this->_getParam("start_date"));
        $endDate = trim($this->_getParam("end_date"));

        $page = (int) $this->_getParam("page");
        $page = $page < 1 ? 1 : $page;
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        $where = "";
        $condition = "";

        if ($studentId > 0) {
            $where .= " and sch_student_id = {$studentId} ";
            $condition .= "/student_id/{$studentId}";
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
        $dataCount = StudentDealModel::getInstance()->getDataCount($where);
//        echo $dataCount;exit;
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $this->view->title = "学生奖惩管理";
        $this->view->data = StudentDealModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->pageData = array("page" => $page, "url" => "/teacherdeal/list{$condition}","page_count" => $pageCount);
        $this->view->studentData = StudentModel::getInstance()->getStudentDataByWhere(  );
        $this->view->studentId = $studentId;
        $this->view->startDate = $startDate;
        $this->view->endDate = $endDate;
        $this->view->from = base64_encode(urlencode("/page/{$page}" . $condition));
    }

    public function ajaxAddAction() {
        $this->view->title = "添加学生奖惩信息";
        $this->view->studentData = StudentModel::getInstance()->getStudentDataByWhere();
    }


    public function ajaxSaveAction() {
        $this->_helper->layout->disableLayout();
        $studentId = (int) $this->_getParam("input_student_id");
        $typeId = (int) $this->_getParam("input_type_id");
        $dealName = trim($this->_getParam("input_deal_name"));
        $dealDate = trim($this->_getParam("input_deal_date"));
        $dealReason = trim($this->_getParam("input_deal_reason"));

        $isHas = StudentDealModel::getInstance()->checkData($studentId, $typeId, $dealDate);
        if($isHas>0) {
            echo "-2";
            exit;
        }
        $studentData = StudentModel::getInstance()->getRowData( $studentId );
        $params = array(
            "sch_student_id" => $studentId,
            "sch_student_no" => isset($studentData['student_no'])?$studentData['student_no']:"",
            "sch_student_name" => isset($studentData['cn_name'])?$studentData['cn_name']:"",
            "deal_date" =>$dealDate,
            "type_id" => $typeId,
            "deal_name" => $dealName,
            "deal_reason" => $dealReason,
            "deal_user_id" => $this->_session->uid,
            "deal_real_name" => $this->_session->unickname,
        );
        $add = StudentDealModel::getInstance()->addData($params);
        echo $add;
        exit;
    }

    public function ajaxEditAction() {
        $this->_helper->layout->disableLayout();
        $dealId = (int) $this->_getParam("deal_id");
        $this->view->data = StudentDealModel::getInstance()->getRowData( $dealId );
        $this->view->studentData = StudentModel::getInstance()->getStudentDataByWhere();
        $this->view->title = "编辑学生奖惩信息";
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
        $update = StudentDealModel::getInstance()->updateData( $dealId , $params );
        echo $update;
        exit;
    }


    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $dealId = (int) $this->_getParam("deal_id");
        $from = trim($this->_getParam("from"));
        $from = !empty($from) ? urldecode( base64_decode($from) ) : "";
        $delete = StudentDealModel::getInstance()->deleteData($dealId);
        $url = "/studentdeal/list{$from}";
        if($delete>0) {
            Ccc_Helper_Com::alertMess($url, "操作成功");
        } else {
            Ccc_Helper_Com::alertMess($url, "操作失败" );
        }
    }

	public function myListAction() {
        // get the paramter.
        $startDate = trim($this->_getParam("start_date"));
        $endDate = trim($this->_getParam("end_date"));

        $page = (int) $this->_getParam("page");
        $page = $page < 1 ? 1 : $page;
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        $where = " and sch_student_no = '{$this->_session->uname}' ";
//		$where = "";
        $condition = "";

        if (!empty($startDate)) {
            $where .= " and deal_date>='{$startDate} 00:00:00' ";
            $condition .= "/start_date/{$startDate}";
        }
        if (!empty($endDate)) {
            $where .= " and deal_date<='{$endDate} 23:59:59'";
            $condition .= "/end_date/{$endDate}";
        }

        // count.
        $dataCount = StudentDealModel::getInstance()->getDataCount($where);
//        echo $dataCount;exit;
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $this->view->title = "我的奖惩列表";
        $this->view->data = StudentDealModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->pageData = array("page" => $page, "url" => "/teacherdeal/my.list{$condition}","page_count" => $pageCount);
        $this->view->startDate = $startDate;
        $this->view->endDate = $endDate;
        $this->view->from = base64_encode(urlencode("/page/{$page}" . $condition));
    }

	public function ajaxViewAction() {
		$this->_helper->layout->disableLayout();
		$dealId = (int) $this->_getParam("deal_id");
		$dealRowData = StudentDealModel::getInstance()->getRowData( $dealId );
		$this->view->dealRowData = $dealRowData;
		$this->view->from = trim( $this->_getParam( "from" ) );
		$this->view->title = "查看我的奖惩信息";
	}


}