<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 学生考勤管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/07/05
 */
class StudentattendanceController extends Ccc_Base_Controller {

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
            $where .= " and come_time>='{$startDate}' ";
            $condition .= "/start_date/{$startDate}";
        }
        if (!empty($endDate)) {
            $where .= " and leave_time<='{$endDate}'";
            $condition .= "/end_date/{$endDate}";
        }
        
        // count.
        $dataCount = TeacherAttendanceModel::getInstance()->getDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $this->view->title = "教工考勤管理";
        $this->view->data = TeacherAttendanceModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->pageData = array("page" => $page, "url" => "/teacherattendance/list{$condition}","page_count" => $pageCount);
        $this->view->teacherData = TeacherModel::getInstance()->getTeacherDataByWhere(  );
        $this->view->teacherId = $teacherId;
        $this->view->startDate = $startDate;
        $this->view->endDate = $endDate;
        $this->view->from = base64_encode("/page/{$page}" . $condition);
    }

    /**
     * 添加所有人员考勤信息
     */
    public function ajaxAddAction() {
        $this->view->showTeacher = (int) $this->_getParam("show_teacher");
        $this->view->title = "添加教工考勤信息";
        $this->view->teacherData = TeacherModel::getInstance()->getTeacherDataByWhere();
        // 通过工号找到teacher表中的teacher_id.
        $this->view->teacherId = TeacherModel::getInstance()->getTeacherIdByJobNumber($this->_session->uname);
    }

    public function ajaxSaveAction() {
        $this->_helper->layout->disableLayout();
        $teacherId = (int) $this->_getParam("input_teacher_id");
        $attendanceDate = trim($this->_getParam("input_attendance_date"));
        $comeTime = trim( $this->_getParam("input_come_time"));
        $leaveTime = trim($this->_getParam("input_leave_time"));
        $reason = trim($this->_getParam("input_reason"));
        if( !empty($attendanceDate) ) $comeTime = $attendanceDate . " " . $comeTime;
        if( !empty($attendanceDate) ) $leaveTime = $attendanceDate . " " . $leaveTime;
        $isHas = TeacherAttendanceModel::getInstance()->checkData( $teacherId , $attendanceDate );
        if( $isHas>0 ) {
            echo "-2";
            exit;
        }
        $teacherData = TeacherModel::getInstance()->getRowData( $teacherId );
        $params = array(
            "teacher_id" => $teacherId,
            "teacher_no" => isset($teacherData['teacher_no'])?$teacherData['teacher_no']:"",
            "teacher_name" => isset($teacherData['cn_name'])?$teacherData['cn_name']:"",
            "attendance_date" => $attendanceDate,
            "come_time" => $comeTime,
            "leave_time" => $leaveTime,
            "reason" => $reason,
        );
        $add = TeacherAttendanceModel::getInstance()->addData( $params );
        echo $add;
        exit;
    }
    
    public function ajaxEditAction() {
         $this->_helper->layout->disableLayout();
         $attendanceId = (int) $this->_getParam("attendance_id");
         $data = TeacherAttendanceModel::getInstance()->getRowData( $attendanceId );
         $data['come_time'] = !empty($data['come_time']) ? date("H:i",strtotime($data['come_time'])) : "";
         $data['leave_time'] = !empty($data['leave_time']) ? date("H:i",strtotime($data['leave_time'])) : "";
         $this->view->data = $data;
         $this->view->teacherData = TeacherModel::getInstance()->getTeacherDataByWhere();
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
        $update = TeacherAttendanceModel::getInstance()->updateData($attendanceId,$params);
        echo $update;
        exit;
    }
    
    /**
     * 删除考勤信息
     */
    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $attendanceId = (int) $this->_getParam("attendance_id");
        $showTeacher = (int) $this->_getParam("show_teacher");
        $from = trim($this->_getParam("from"));
        $from = !empty($from) ? base64_decode($from) : "";
        $delete = TeacherAttendanceModel::getInstance()->deleteData($attendanceId);
        $url = $showTeacher == 0 ? "/teacherattendance/my.list{$from}" : "/teacherattendance/list{$from}";
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
            $where .= " and come_time>='{$startDate}' ";
            $condition .= "/start_date/{$startDate}";
        }
        if (!empty($endDate)) {
            $where .= " and leave_time<='{$endDate}'";
            $condition .= "/end_date/{$endDate}";
        }
        $where .= " and teacher_no = '{$this->_session->uname}' ";
        // count.
        $dataCount = TeacherAttendanceModel::getInstance()->getDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $this->view->title = "我的考勤列表";
        $this->view->data = TeacherAttendanceModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->pageData = array("page" => $page, "url" => "/teacherattendance/my.list{$condition}","page_count" => $pageCount);
//        $this->view->teacherData = TeacherModel::getInstance()->getTeacherDataByAttendance(  );
        $this->view->teacherId = $teacherId;
        $this->view->startDate = $startDate;
        $this->view->endDate = $endDate;
        $this->view->from = base64_encode("/page/{$page}" . $condition);
    }


}