<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 费用管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/07/05
 */
class MoneyController extends Ccc_Base_Controller {

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

    public function addMoneyDataAction() {
        $this->view->title = "添加费用总表信息";
        $this->view->classData = ClassModel::getInstance()->getClassData();
        $this->view->projectData = MoneyModel::getInstance()->getConfigMoneyProjectData();
        $this->view->termData = MoneyModel::getInstance()->getConfigTermData();
    }

    public function saveMoneyDataAction() {
        $this->_helper->layout->disableLayout();
        $moneyType = (int) $this->_getParam("money_type");
        $moneyDate = trim($this->_getParam("money_date"));
        $termId = (int) $this->_getParam("term_id");
        $classId = (int) $this->_getParam("class_id");
        $projectId = (int) $this->_getParam("project_id");
        $name = trim($this->_getParam("name"));
        $realMoney = trim($this->_getParam("real_money"));
        $comments = trim($this->_getParam("comments"));
        
        $hiddeMoney = trim($this->_getParam("hidden_money"));

        // 获取流水号，通过费用日期+班级号
        $no = MoneyModel::getInstance()->getMoneyMaxNumberByWhere($moneyDate, $classId);
        $no = $no + 1;
        $no = !empty($no) ? sprintf("%03d", $no) : "000";
        $classRowData = ClassModel::getInstance()->getClassRowData($classId);
        $classNo = isset($classRowData['class_no']) ? $classRowData['class_no'] : "00";
        $moneyDateResult = str_replace("-","",$moneyDate);
        $moneyNumber = $moneyDateResult . $classNo . $no;
        $termRowData = MoneyModel::getInstance()->getConfigTermRowData($termId);
        $projectRowData = MoneyModel::getInstance()->getConfigMoneyProjectRowData($projectId);
        $params = array(
            "sch_class_id" => $classId,
            "sch_class_no" => $classNo,
            "sch_class_name" => isset($classRowData['class_name']) ? $classRowData['class_name'] : "",
            "sch_term_id" => $termId,
            "sch_term_name" => isset($termRowData['term_name']) ? $termRowData['term_name'] : "",
            "money_number" => $moneyNumber,
            "money_date" => $moneyDate,
            "type" => $moneyType,
            "money_name" => $name,
            "sch_money_project_id" => $projectId,
            "sch_money_project_name" => isset($projectRowData['money_project_name']) ? $projectRowData['money_project_name'] : "",
            "money" => $hiddeMoney,
            "realy_money" => $realMoney,
            "comments" => $comments,
            "add_user_id" => $this->_session->uid,
            "add_time_int" => time(),
        );
        
        $add = MoneyModel::getInstance()->addMoneyData($params);
        if ($add > 0) {
            Ccc_Helper_Com::alertMess("/money/list.money.data", "添加成功");
        } else {
            Ccc_Helper_Com::alertMess("/money/add.money.data", "添加失败");
        }
    }

    public function ajaxGetMoneyByWhereAction() {
        $this->_helper->layout->disableLayout();
        $moneyDate = trim($this->_getParam("money_date"));
        $classId = (int) $this->_getParam("class_id");
        $projectId = (int) $this->_getParam("project_id");
        $termId = (int) $this->_getParam("term_id");
        $monthResult = !empty($moneyDate) ? explode("-", $moneyDate) : "";
        $month = !empty($monthResult) ? $monthResult[1] : 0;
        $money = MoneyModel::getInstance()->getMoneyByWhere($classId, $termId, $month, $projectId);
        echo $money;
        exit;
        //  
    }

    /**
     * 教师费用列表
     */
    public function listTeacherMoneyDataAction() {

        die("教工费用列表");
        $this->view->title = "教工费用列表";
        
    }

    /**
     * 学生费用列表
     */
    public function listStudentMoneyDataAction() {
        $this->view->title = "学生费用列表";
        
        $moneyDate = trim($this->_getParam("money_date"));
        $moneyType = (int) $this->_getParam("money_type");
        $moneyProject = (int) $this->_getParam("money_project");
        $studentId = (int) $this->_getParam("student_id");
        $moneyNumber = trim($this->_getParam("money_number"));

        $page = (int) $this->_getParam("page");
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        $where = "";
        $condition = "";
        
        if(!empty($moneyDate)) { 
            $where .= " and smd.money_date = '{$moneyDate}' ";
            $condition .= "/money_date/{$moneyDate}";
        }
        $where .= " and smd.type={$moneyType}";
        $condition .= "/money_type/{$moneyType}";
        if($moneyProject>0) { 
            $where .= " and smd.sch_money_project_id={$moneyProject}";
            $condition .= "/money_project/{$moneyProject}";
        }
        if($studentId>0) {
            $where .= " and ssmd.sch_student_id={$studentId}";
            $condition .= "/student_id/{$studentId}";
        }
        if(!empty($moneyNumber)) { 
            $where .= " and smd.money_number like '{$moneyNumber}%'";
            $condition .= "/money_number/{$moneyNumber}";
        }

        $dataCount = MoneyModel::getInstance()->getStudentMoneyDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;

        $this->view->data = MoneyModel::getInstance()->getStudentMoneyPageData($page, $pageSize, $where);
        $this->view->from = base64_encode(urlencode("/page/{$page}" . $condition));
        $this->view->pageData = array("page" => $page, "url" => "/money/list.student.money.data{$condition}",
            "page_count" => $pageCount);
        $this->view->projectData = MoneyModel::getInstance()->getConfigMoneyProjectData();
        $this->view->title = "学生费用列表";
        $this->view->moneyDate = $moneyDate;
        $this->view->moneyType = $moneyType;
        $this->view->moneyProject = $moneyProject;
        $this->view->moneyNumber = $moneyNumber;
        $this->view->studentId = $studentId;
        $this->view->studentData = StudentModel::getInstance()->getStudentDataByWhere();
    }

    public function addStudentMoneyDataAction() {
        $this->view->title = "添加学生费用信息";
        
        $this->view->classData = ClassModel::getInstance()->getClassData();
        $this->view->projectData = MoneyModel::getInstance()->getConfigMoneyProjectData();
        $this->view->termData = MoneyModel::getInstance()->getConfigTermData();
        $this->view->studentData = StudentModel::getInstance()->getStudentDataByWhere();
    }
    
    public function saveStudentMoneyDataAction() {
        $this->_helper->layout->disableLayout();
        $classId = (int) $this->_getParam("class_id");
        $termId = (int) $this->_getParam("term_id");
        $studentId = (int) $this->_getParam("student_id");
        $moneyType = (int) $this->_getParam("money_type");
        $moneyDate = trim($this->_getParam("money_date"));
        $projectId = (int) $this->_getParam("project_id");
        $name = trim($this->_getParam("name"));
        $money = trim($this->_getParam("hidden_money"));
        $realyMoney = trim($this->_getParam("realy_money"));
        $commnets = trim($this->_getParam("comments"));
        
        
        $classRowData = ClassModel::getInstance()->getClassRowData($classId);
        $termRowData = MoneyModel::getInstance()->getConfigTermRowData($termId);
        $projectRowData = MoneyModel::getInstance()->getConfigMoneyProjectRowData($projectId);
        $studentRowData = StudentModel::getInstance()->getRowData($studentId);
        
        $no = MoneyModel::getInstance()->getMoneyMaxNumberByWhere($moneyDate, $classId);
        $no = $no + 1;
        $no = !empty($no) ? sprintf("%03d", $no) : "000";
        $classNo = isset($classRowData['class_no']) ? $classRowData['class_no'] : "00";
        $moneyDateResult = str_replace("-","",$moneyDate);
        $moneyNumber = $moneyDateResult . $classNo . $no;
        // 添加费用信息
        $params2 = array(
            "sch_class_id" => $classId,
            "sch_class_no" => $classNo,
            "sch_class_name" => isset($classRowData['class_name']) ? $classRowData['class_name'] : "",
            "sch_term_id" => $termId,
            "sch_term_name" => isset($termRowData['term_name']) ? $termRowData['term_name'] : "",
            "money_number" => $moneyNumber,
            "money_date" => $moneyDate,
            "type" => $moneyType,
            "money_name" => $name,
            "sch_money_project_id" => $projectId,
            "sch_money_project_name" => isset($projectRowData['money_project_name']) ? $projectRowData['money_project_name'] : "",
            "money" => $money,
            "realy_money" => $realyMoney,
            "comments" => $commnets,
            "add_user_id" => $this->_session->uid,
            "add_time_int" => time(),
        );
        $add2 = MoneyModel::getInstance()->addMoneyData($params2);
        if($add2>0) {
            $params1 = array(
                "sch_money_data_id" => $add2,
                "sch_class_id" => $classId,
                "sch_class_no" => isset($classRowData['class_no']) ? $classRowData['class_no'] : "",
                "sch_class_name" => isset($classRowData['class_name']) ? $classRowData['class_name'] : "",
                "sch_term_id" => $termId,
                "sch_term_name" => isset($termRowData['term_name']) ? $termRowData['term_name'] : "",
                "sch_student_id" => $studentId,
                "sch_student_no" => isset($studentRowData['student_no']) ? $studentRowData['student_no'] : "",
                "sch_student_name" => isset($studentRowData['cn_name']) ? $studentRowData['cn_name'] : "",
                "status" => 1,
            );
            $add1 = MoneyModel::getInstance()->addStudentMoneyData($params1);
        }
        
        if($add2>0 && $add1>0) { 
            Ccc_Helper_Com::alertMess("/money/list.student.money.data" , "添加成功");
        } else {
            Ccc_Helper_Com::alertMess("/money/list.student.money.data" , "添加失败");
        }
    }
    
    public function viewStudentMoneyDataAction() {
        $this->view->title = "查看学生费用信息";
        $smdId = (int) $this->_getParam("smd_id");
        $this->view->studentMoneyRowData = MoneyModel::getInstance()->getStudentMoneyRowData($smdId);
        $this->view->from = trim($this->_getParam("from"));
    }
    
    public function editStudentMoneyDataAction() {
        $this->view->title = "编辑学生费用信息";
        $smdId = (int) $this->_getParam("smd_id");
        $this->view->studentMoneyRowData = MoneyModel::getInstance()->getStudentMoneyRowData($smdId);
        $this->view->from = trim($this->_getParam("from"));
        
        $this->view->classData = ClassModel::getInstance()->getClassData();
        $this->view->projectData = MoneyModel::getInstance()->getConfigMoneyProjectData();
        $this->view->termData = MoneyModel::getInstance()->getConfigTermData();
        $this->view->studentData = StudentModel::getInstance()->getStudentDataByWhere();
    }
    
    public function updateStudentMoneyDataAction() {
        $this->_helper->layout->disableLayout();
        $hiddenSmdId = (int) $this->_getParam("hidden_smd_id");
        $from = trim($this->_getParam("from"));
        $moneyType = (int) $this->_getParam("money_type");
        $name = trim($this->_getParam("name"));
        $realyMoney = trim($this->_getParam("realy_money"));
        $comments = trim($this->_getParam("comments"));
        $studentMoneyRowData = MoneyModel::getInstance()->getStudentMoneyRowData($hiddenSmdId);
        $mdId = isset($studentMoneyRowData['sch_money_data_id']) ? $studentMoneyRowData['sch_money_data_id'] : 0;
        $params = array(
            "type" => $moneyType,
            "money_name" => $name,
            "realy_money" => $realyMoney,
            "comments" => $comments,
        );
        $update = MoneyModel::getInstance()->updateMoneyData($mdId, $params);
        $from = urldecode(base64_decode($from));
        if($update>0) {
            Ccc_Helper_Com::alertMess("/money/list.student.money.data" . $from, "修改成功");
        } else {
            Ccc_Helper_Com::alertMess("/money/list.student.money.data" . $from, "修改失败");
        }
    }
    
    public function deleteStudentMoneyDataAction() {
        $this->_helper->layout->disableLayout();
        $smdId = (int) $this->_getParam("smd_id");
        $from = trim($this->_getParam("from"));
        //先删除费用信息，在删除学生信息
        $studentMoneyRowData = MoneyModel::getInstance()->getStudentMoneyRowData($smdId);
        $mdId = isset($studentMoneyRowData['sch_money_data_id']) ? $studentMoneyRowData['sch_money_data_id'] : 0;
        if($mdId>0) {
            // 删除
            MoneyModel::getInstance()->deleteMoneyData($mdId);
        }
        $delete = MoneyModel::getInstance()->deleteStudentMoneyData($smdId);
        $from = urldecode(base64_decode($from));
        if($delete>0) {
            Ccc_Helper_Com::alertMess("/money/list.student.money.data" . $from, "修改成功");
        } else {
            Ccc_Helper_Com::alertMess("/money/list.student.money.data" . $from, "修改失败");
        }
    }
    /**
     * 费用列表
     */
    public function listMoneyDataAction() {
        
        $moneyDate = trim($this->_getParam("money_date"));
        $moneyType = (int) $this->_getParam("money_type");
        $moneyProject = (int) $this->_getParam("money_project");
        $moneyNumber = trim($this->_getParam("money_number"));

        $page = (int) $this->_getParam("page");
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        $where = "";
        $condition = "";
        
        if(!empty($moneyDate)) { 
            $where .= " and money_date = '{$moneyDate}' ";
            $condition .= "/money_date/{$moneyDate}";
        }
        $where .= " and type={$moneyType}";
        $condition .= "/money_type/{$moneyType}";
        if($moneyProject>0) { 
            $where .= "/sch_money_project_id={$moneyProject}";
            $condition .= "/money_project/{$moneyProject}";
        }
        if(!empty($moneyNumber)) { 
            $where .= " and money_number like '{$moneyNumber}%'";
            $condition .= "/money_number/{$moneyNumber}";
        }

        $dataCount = MoneyModel::getInstance()->getMoneyDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;

        $this->view->data = MoneyModel::getInstance()->getMoneyPageData($page, $pageSize, $where);
        $this->view->from = base64_encode(urlencode("/page/{$page}" . $condition));
        $this->view->pageData = array("page" => $page, "url" => "/money/list.money.data{$condition}",
            "page_count" => $pageCount);
        $this->view->projectData = MoneyModel::getInstance()->getConfigMoneyProjectData();
        $this->view->title = "费用总表";
        $this->view->moneyDate = $moneyDate;
        $this->view->moneyType = $moneyType;
        $this->view->moneyProject = $moneyProject;
        $this->view->moneyNumber = $moneyNumber;
    }

    public function viewMoneyDataAction() {
        $mdId = (int) $this->_getParam("md_id");
        $from = trim($this->_getParam("from"));
        $moneyRowData = MoneyModel::getInstance()->getMoneyRowData($mdId);
        $this->view->moneyRowData = $moneyRowData;
        $this->view->from = $from;
        $this->view->title = "查看费用信息";
    }
    
    public function editMoneyDataAction() {
        $this->view->title = "编辑费用信息";
        $mdId = (int) $this->_getParam("md_id");
        $from = trim($this->_getParam("from"));
        $moneyRowData = MoneyModel::getInstance()->getMoneyRowData($mdId);
        $this->view->moneyRowData = $moneyRowData;
        $this->view->from = $from;
        $this->view->classData = ClassModel::getInstance()->getClassData();
        $this->view->projectData = MoneyModel::getInstance()->getConfigMoneyProjectData();
        $this->view->termData = MoneyModel::getInstance()->getConfigTermData();
    }
    
    public function updateMoneyDataAction() {
        $this->_helper->layout->disableLayout();
        $hiddenMdId = (int) $this->_getParam("hidden_md_id");
        $from = trim($this->_getParam("from"));
        
        $name = trim($this->_getParam("name"));
        $realyMoney = trim($this->_getParam("realy_money"));
        $comments = trim($this->_getParam("comments"));
        
        $params = array(
            "money_name" => $name,
            "realy_money" => $realyMoney,
            "comments" => $comments,
            "update_user_id" => $this->_session->uid,
            "update_time_int" => time(),
        );
        $update = MoneyModel::getInstance()->updateMoneyData($hiddenMdId,$params);
        $from = urldecode(base64_decode($from));
        if($update>0) {
            Ccc_Helper_Com::alertMess("/money/list.money.data" . $from, "修改成功");
        } else {
            Ccc_Helper_Com::alertMess("/money/list.money.data" . $from, "修改失败");
        }
        
    }
    // 学期配置
    public function listConfigTermAction() {
        $this->view->title = "学期配置列表";
        $termName = trim($this->_getParam("term_name"));

        $page = (int) $this->_getParam("page");
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
//        $pageSize = 1;
        $where = "";
        $condition = "";
        
        if(!empty($termName)) {
            $where .= " and term_name like '%{$termName}%' ";
            $condition .= "/term_name/{$termName}";
        }

        $dataCount = MoneyModel::getInstance()->getConfigTermDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        
        $this->view->data = MoneyModel::getInstance()->getConfigTermPageData($page, $pageSize, $where);
        // view page
        $this->view->pageData = array("page" => $page, "url" => "/money/list.config.term{$condition}",
            "page_count" => $pageCount);
        $this->view->termName = $termName;
        $this->view->from = base64_encode(urlencode("/page/{$page}" . $condition));
    }

    public function ajaxAddConfigTermAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title = "添加学期配置信息";
    }

    public function ajaxSaveConfigTermAction() {
        
    }

    public function ajaxViewConfigTermAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title = "查看学期配置信息";

        $termId = (int) $this->_getParam("term_id");
        $this->view->configTermData = MoneyModel::getInstance()->getConfigTermRowData($termId);
        $this->view->from = trim($this->_getParam("from"));
    }

    public function ajaxEditConfigTermAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title = "编辑学期配置信息";

        $termId = (int) $this->_getParam("term_id");
        $this->view->configTermData = MoneyModel::getInstance()->getConfigTermRowData($termId);
        $this->view->from = trim($this->_getParam("from"));
    }

    public function ajaxUpdateConfigTermAction() {
        
    }

    public function deleteConfigTermAction() {
        $this->_helper->layout->disableLayout();
        $termId = (int) $this->_getParam("term_id");
        $from = trim($this->_getParam("from"));
        $from = urldecode(base64_decode($from));
        $delete = MoneyModel::getInstance()->deleteConfigTermData($termId);
        if ($delete > 0) {
            Ccc_Helper_Com::alertMess("/money/list.config.term" . $from, "操作成功");
        } else {
            Ccc_Helper_Com::alertMess("/class/list.config.term" . $from, "操作失败");
        }
    }

    // 费用项目配置
    public function listConfigMoneyProjectAction() {
        $this->view->title = "费用项目配置列表";
        $projectName = trim($this->_getParam("project_name"));

        $page = (int) $this->_getParam("page");
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
//        $pageSize = 1;
        $where = "";
        $condition = "";
        
        if(!empty($projectName)) {
            $where .= " and money_project_name like '%{$projectName}%' ";
            $condition .= "/project_name/{$projectName}";
        }

        $dataCount = MoneyModel::getInstance()->getConfigMoneyProjectDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;

        $this->view->data = MoneyModel::getInstance()->getConfigMoneyProjectPageData($page, $pageSize, $where);
        // view page
        $this->view->pageData = array("page" => $page, "url" => "/money/list.config.money.project{$condition}",
            "page_count" => $pageCount);
        $this->view->projectName = $projectName;
        $this->view->from = base64_encode(urlencode("/page/{$page}" . $condition));
    }

    public function ajaxAddConfigMoneyProjectAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title = "添加费用项目配置信息";
    }

    public function ajaxViewConfigMoneyProjectAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title = "查看费用项目配置信息";
        $mpId = (int) $this->_getParam("mp_id");
        $this->view->configMoneyProjectData = MoneyModel::getInstance()->getConfigMoneyProjectRowData($mpId);
        $this->view->from = trim($this->_getParam("from"));
    }

    // 班级+学期+费用项目 =》 费用
    public function listConfigMoneyAction() {
        $this->view->title = "班级学期项目费用列表";
        // deal with the page.
        $page = (int) $this->_getParam("page");
        $page = $page < 1 ? 1 : $page;
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        // where
        $where = " ";
        $condition = "";
        $className = trim($this->_getParam("class_name"));
        if (!empty($className)) {
            $where .= " and class_name  like '{$className}%' ";
            $condition .= "/class_name/{$className}";
        }

        // compare the page data.
        $dataCount = MoneyModel::getInstance()->getConfigMoneyDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $data = MoneyModel::getInstance()->getConfigMoneyPageData($page, $pageSize, $where);
        $this->view->data = $data;
        // view page
        $this->view->pageData = array("page" => $page, "url" => "/money/list.config.money{$condition}",
            "page_count" => $pageCount);
        $this->view->title = "班级学期项目费用列表";
        $this->view->className = $className;
        $this->view->from = base64_encode(urlencode("/page/{$page}" . $condition));
    }

    public function addConfigMoneyAction() {
        $this->view->title = "添加班级学期项目费用信息";
        $this->view->classData = ClassModel::getInstance()->getClassData();
        $this->view->termData = MoneyModel::getInstance()->getConfigTermData();
        $this->view->projectData = MoneyModel::getInstance()->getConfigMoneyProjectData();
    }

    public function saveConfigMoneyAction() {
        $this->_helper->layout->disableLayout();
        $classId = (int) $this->_getParam("class_id");
        $termId = (int) $this->_getParam("term_id");
        $month = (int) $this->_getParam("month");
        $projectId = (int) $this->_getParam("project_id");
        $money = trim($this->_getParam("money"));
        $comments = trim($this->_getParam("comments"));

//        echo $month;exit;
        $check = MoneyModel::getInstance()->checkData($classId, $termId, $month, $projectId);
        if ($check > 0) {
            Ccc_Helper_Com::alertMess("/money/add.config.money", "数据已存在，请重试");
            exit;
        }
        $classData = ClassModel::getInstance()->getClassDataByWhere();
        $termData = MoneyModel::getInstance()->getConfigTermDataByWhere();
        $projectData = MoneyModel::getInstance()->getConfigMoneyProjectDataByWhere();

        $params = array(
            "sch_class_id" => $classId,
            "sch_class_name" => isset($classData['name'][$classId]) ? $classData['name'][$classId] : "",
            "sch_class_no" => isset($classData['no'][$classId]) ? $classData['no'][$classId] : 0,
            "sch_term_id" => $termId,
            "sch_term_name" => isset($termData[$termId]) ? $termData[$termId] : 0,
            "month" => $month,
            "sch_money_project_id" => $projectId,
            "sch_money_project_name" => isset($projectData[$projectId]) ? $projectData[$projectId] : "",
            "money" => $money,
            "comments" => $comments,
            "add_user_id" => $this->_session->uid,
            "add_time_int" => time(),
        );

//        print_r($params);exit;
        $add = MoneyModel::getInstance()->addData($params);
        if ($add > 0) {
            Ccc_Helper_Com::alertMess("/money/list.config.money", "添加成功");
        } else {
            Ccc_Helper_Com::alertMess("/money/add.config.money", "添加失败");
        }
    }

    public function viewConfigMoneyAction() {
        $this->view->title = "查看班级学期项目费用信息";
        $mcId = (int) $this->_getParam("mc_id");
        $from = trim($this->_getParam("from"));
        $configMoneyData = MoneyModel::getInstance()->getConfigMoneyRowData($mcId);
        $this->view->configMoneyData = $configMoneyData;
        $this->view->from = $from;
    }

    public function editConfigMoneyAction() {
        $this->view->title = "编辑班级学期项目费用信息";
        $mcId = (int) $this->_getParam("mc_id");
        $from = trim($this->_getParam("from"));
        $configMoneyData = MoneyModel::getInstance()->getConfigMoneyRowData($mcId);
        $this->view->configMoneyData = $configMoneyData;
        $this->view->classData = ClassModel::getInstance()->getClassData();
        $this->view->termData = MoneyModel::getInstance()->getConfigTermData();
        $this->view->projectData = MoneyModel::getInstance()->getConfigMoneyProjectData();
        $this->view->from = $from;
    }

    public function updateConfigMoneyAction() {
        $this->_helper->layout->disableLayout();
        $hiddenMcId = (int) $this->_getParam("hidden_mc_id");
        $from = trim($this->_getParam("from"));
        $money = trim($this->_getParam("money"));
        $comments = trim($this->_getParam("comments"));

        $params = array(
            "money" => $money,
            "comments" => $comments,
            "update_user_id" => $this->_session->uid,
            "update_time_int" => time(),
        );

        $from = urldecode(base64_decode($from));

        $update = MoneyModel::getInstance()->updateConfigMoneyData($hiddenMcId, $params);
        if ($update > 0) {
            Ccc_Helper_Com::alertMess("/money/list.config.money{$from}", "修改成功");
        } else {
            Ccc_Helper_Com::alertMess("/money/list.config.money{$from}", "修改失败");
        }
    }

    public function deleteConfigMoneyAction() {
        $this->_helper->layout->disableLayout();
        $mcId = (int) $this->_getParam("mc_id");
        $from = trim($this->_getParam("from"));
        $from = urldecode(base64_decode($from));
        $delete = MoneyModel::getInstance()->deleteConfigMoneyData($mcId);
        if ($delete > 0) {
            Ccc_Helper_Com::alertMess("/money/list.config.money{$from}", "删除成功");
        } else {
            Ccc_Helper_Com::alertMess("/money/list.config.money{$from}", "删除失败");
        }
    }

}