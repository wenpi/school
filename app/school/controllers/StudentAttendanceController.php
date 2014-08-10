<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 学生考勤管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/08/01
 */
class StudentAttendanceController extends Ccc_Base_Controller {

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
     * 所有人员考勤管理
     */
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
            $where .= " and come_time>='{$startDate}' ";
            $condition .= "/start_date/{$startDate}";
        }
        if (!empty($endDate)) {
            $where .= " and leave_time<='{$endDate}'";
            $condition .= "/end_date/{$endDate}";
        }

        // count.
        $dataCount = StudentAttendanceModel::getInstance()->getDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $this->view->title = "学生考勤管理";
        $this->view->data = StudentAttendanceModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->pageData = array("page" => $page, "url" => "/studentattendance/list{$condition}","page_count" => $pageCount);
        $this->view->studentData = StudentModel::getInstance()->getStudentDataByWhere(  );
        $this->view->studentId = $studentId;
        $this->view->startDate = $startDate;
        $this->view->endDate = $endDate;
        $this->view->from = base64_encode( urlencode( "/page/{$page}" . $condition ) );
    }

    /**
     * 添加所有人员考勤信息
     */
    public function ajaxAddAction() {
        $this->view->title = "添加学生考勤信息";
        $this->view->studentData = StudentModel::getInstance()->getStudentDataByWhere();
    }

    public function ajaxSaveAction() {
        $this->_helper->layout->disableLayout();
        $studentId = (int) $this->_getParam("input_student_id");
        $attendanceDate = trim($this->_getParam("input_attendance_date"));
        $comeTime = trim( $this->_getParam("input_come_time"));
        $leaveTime = trim($this->_getParam("input_leave_time"));
        $reason = trim($this->_getParam("input_reason"));
        if( !empty($attendanceDate) ) $comeTime = $attendanceDate . " " . $comeTime;
        if( !empty($attendanceDate) ) $leaveTime = $attendanceDate . " " . $leaveTime;
        $isHas = StudentAttendanceModel::getInstance()->checkData( $studentId , $attendanceDate );
        if( $isHas>0 ) {
            echo "-2";
            exit;
        }
        $studentData = StudentModel::getInstance()->getRowData( $studentId );
        $params = array(
            "sch_student_id" => $studentId,
            "sch_student_no" => isset($studentData['student_no'])?$studentData['student_no']:"",
            "sch_student_name" => isset($studentData['cn_name'])?$studentData['cn_name']:"",
            "attendance_date" => $attendanceDate,
            "come_time" => $comeTime,
            "leave_time" => $leaveTime,
            "reason" => $reason,
        );
        $add = StudentAttendanceModel::getInstance()->addData( $params );
        echo $add;
        exit;
    }

    public function ajaxEditAction() {
         $this->_helper->layout->disableLayout();
         $attendanceId = (int) $this->_getParam("attendance_id");
         $data = StudentAttendanceModel::getInstance()->getRowData( $attendanceId );
         $data['come_time'] = !empty($data['come_time']) ? date("H:i",strtotime($data['come_time'])) : "";
         $data['leave_time'] = !empty($data['leave_time']) ? date("H:i",strtotime($data['leave_time'])) : "";
         $this->view->data = $data;
		 $this->view->studentData = StudentModel::getInstance()->getStudentDataByWhere();
         $this->view->title = "编辑教工考勤信息";
    }

    public function ajaxUpdateAction() {
        $this->_helper->layout->disableLayout();
        $attendanceId = (int) $this->_getParam("attendance_id");
        $comeTime = trim( $this->_getParam("input_come_time"));
        $leaveTime = trim($this->_getParam("input_leave_time"));
        $reason = trim($this->_getParam("input_reason"));
        $hiddenAttendanceDate = trim($this->_getParam("hidden_attendance_date"));
        if( !empty($hiddenAttendanceDate) ) $comeTime = $hiddenAttendanceDate . " " . $comeTime;
        if( !empty($hiddenAttendanceDate) ) $leaveTime = $hiddenAttendanceDate . " " . $leaveTime;
        $params = array(
            "come_time" => $comeTime,
            "leave_time" => $leaveTime,
            "reason" => $reason,
        );
        $update = StudentAttendanceModel::getInstance()->updateData($attendanceId,$params);
        echo $update;
        exit;
    }

    /**
     * 删除考勤信息
     */
    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $attendanceId = (int) $this->_getParam("attendance_id");
        $from = trim($this->_getParam("from"));
        $from = !empty($from) ? urldecode( base64_decode($from) ) : "";
        $delete = StudentAttendanceModel::getInstance()->deleteData($attendanceId);
        $url = "/studentattendance/list{$from}";
        if($delete>0) {
            Ccc_Helper_Com::alertMess($url, "操作成功");
        } else {
            Ccc_Helper_Com::alertMess($url, "操作失败" );
        }
    }

    /**
     * 我的考勤列表
     */
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
            $where .= " and come_time>='{$startDate} 00:00:00' ";
            $condition .= "/start_date/{$startDate}";
        }
        if (!empty($endDate)) {
            $where .= " and leave_time<='{$endDate} 23:59:59'";
            $condition .= "/end_date/{$endDate}";
        }
        // count.
        $dataCount = StudentAttendanceModel::getInstance()->getDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $this->view->title = "我的考勤列表";
        $this->view->data = StudentAttendanceModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->pageData = array("page" => $page, "url" => "/studentattendance/my.list{$condition}","page_count" => $pageCount);
//        $this->view->teacherData = TeacherModel::getInstance()->getTeacherDataByAttendance(  );
        $this->view->startDate = $startDate;
        $this->view->endDate = $endDate;
        $this->view->from = base64_encode( urlencode( "/page/{$page}" . $condition ) );
    }

	public function ajaxViewAction() {
		$this->_helper->layout->disableLayout();
		$attendanceId = (int) $this->_getParam("attendance_id");
		$attendanceRowData = StudentAttendanceModel::getInstance()->getRowData( $attendanceId );
		$this->view->attendanceRowData = $attendanceRowData;
		$this->view->from = trim( $this->_getParam( "from" ) );
		$this->view->title = "查看我的考勤信息";
	}


}