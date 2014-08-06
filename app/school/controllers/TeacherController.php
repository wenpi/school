<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 教工管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/07/05
 */
class TeacherController extends Ccc_Base_Controller {

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
        
        $teacherId = (int) $this->_getParam("teacher_id");
        $enName = trim($this->_getParam("en_name"));
        $cnName = trim($this->_getParam("cn_name"));

        $page = (int) $this->_getParam("page");
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        $where = "";
        $condition = "";
        
        
        $where .=!empty($enName) ? " and en_name like '{$enName}%' " : "";
        $condition .=!empty($enName) ? "/en_name/{$enName}" : "";
        $where .=!empty($cnName) ? " and cn_name like '{$cnName}%' " : "";
        $condition .=!empty($cnName) ? "/cn_name/{$cnName}" : "";
        
        
        $dataCount = TeacherModel::getInstance()->getDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        $data = TeacherModel::getInstance()->getPageData($page, $pageSize, $where);
        // teacher type data
        $teahcerTypeData = TeacherModel::getInstance()->getTypeData();
        $schoolJobData = SchoolModel::getInstance()->getJobData();
        if ($data) {
            foreach ($data as & $p) {
                $p['teacher_type_name'] = $p['school_teacher_type_id'] > 0 ? $teahcerTypeData[$p['school_teacher_type_id']] : "-";
                $p['job_name'] = $p['school_job_id'] > 0 ? $schoolJobData[$p['school_job_id']] : "-";
            }
        }
        $this->view->title = "教工管理";
        $this->view->data = $data;
        // view page
        $this->view->pageData = array("page" => $page, "url" => "/resource/list.action{$condition}",
            "page_count" => $pageCount);
        $this->view->enName = $enName;
        $this->view->cnName = $cnName;
        $this->view->teacherId = $teacherId;
        $this->view->from = base64_encode("/page/{$page}" . $condition);
        
    }

    public function addAction() {
        $this->view->title = "添加教工信息";
        $this->view->classData = ClassModel::getInstance()->getClassData();
        $this->view->teacherTypeData = TeacherModel::getInstance()->getTypeData();
        $this->view->jobData = JobModel::getInstance()->getJobData();
    }

    /**
     * 上传图像
     */
    public function ajaxUploadPhotoAction() {
        $this->_helper->layout->disableLayout();
        $config = new Zend_Config_Ini(PATH_ROOT . DS . $this->_conf->path->params_conf, "school");
        if (!isset($_FILES["user_photo"]) 
                || !is_uploaded_file($_FILES["user_photo"]["tmp_name"]) 
                || $_FILES["user_photo"]["error"] != 0) {
            die(0);
        }
        // get the paramter.
        $teacherId = (int) $this->_getParam("teacher_id");
        // get the config.
        $photoPath = isset($config->teacher->path_user_photo) ? PATH_ROOT . $config->teacher->path_user_photo : "";
        $photoType = isset($config->teacher->type_user_photo) ? $config->teacher->type_user_photo : "";
        $photoMaxsize = isset($config->teacher->maxsize_user_photo) ? $config->teacher->maxsize_user_photo : 2048;
        $photoType = str_replace("*.", "", $photoType);
        $photoType = !empty($photoType) ? @explode(";", $photoType) : array();
        $userPhoto = "";
        $classUpload = Ccc_Third_Upload::getInstance($photoPath, $photoType, $photoMaxsize);
        $upload = $classUpload->run("user_photo");
        if ($upload) {
            $result = $classUpload->getInfo();
            // 更新数据表
            $userPhoto = $result[0]['saveName'];
            $params = array(
                "photo_name" => $userPhoto,
            );
            TeacherModel::getInstance()->updateData($teacherId, $params);
        }
        echo $userPhoto;
        exit;
    }

    public function saveAction() {
        $this->_helper->layout->disableLayout();
        // get the params;
        $addBaseParams = array(
            "en_name" => trim($this->_getParam("en_name")),
            "cn_name" => trim($this->_getParam("cn_name")),
            "sex" => (int) $this->_getParam("sex"),
            "birthday" => trim($this->_getParam("birthday")),
            "address" => trim($this->_getParam("address")),
            "id_type" => (int) $this->_getParam("id_type"),
            "id_number" => trim($this->_getParam("id_name")),
            "phone" => trim($this->_getParam("phone")),
            "mobile_phone" => trim($this->_getParam("mobile_phone")),
            "email" => trim($this->_getParam("email")),
            "graduate_school" => trim($this->_getParam("graduate_school")),
            "graduate_date" => trim($this->_getParam("graduate_date")),
            "graduate_specialty" => trim($this->_getParam("graduate_specialty")),
            "max_education" => (int) $this->_getParam("max_education"),
        );
        $addSchoolParams = array(
            "school_class_id" => (int) $this->_getParam("class_id"),
            "school_teacher_type_id" => (int) $this->_getParam("teacher_type_id"),
            "school_job_id" => (int) $this->_getParam("job_id"),
            "job_date" => trim($this->_getParam("job_date")),
            "bargain_start_date" => trim($this->_getParam("bargain_start_date")),
            "bargain_end_date" => trim($this->_getParam("bargain_end_date")),
            "bargain_count" => (int) $this->_getParam("bargain_count"),
            "leave_date" => trim($this->_getParam("leave_date")),
            "leave_reason" => trim($this->_getParam("leave_reason")),
            "add_user_id" => (int)$this->_session->uid,
            "add_time_int" => time(),
        );
        $result = array_merge($addBaseParams,$addSchoolParams);
        $add = TeacherModel::getInstance()->addData($result);
        if($add>0) {
            $classId = (int) $this->_getParam("class_id");
            $classRowData = ClassModel::getInstance()->getRowData($classId);
            $classNumber = isset($classRowData['class_number'])?$classRowData['class_number']:"000000";     // 班级编码
            $typeNumber = (int) $this->_getParam("teacher_type_id");
            $leaveData = trim($this->_getParam("leave_date"));
            $maxNumber = !empty($add) ? sprintf( "%03d" , $add ) : "000";
            $teacherNumber = $classNumber . $typeNumber . $maxNumber;
            $updateParams = array(
                "teacher_number" => $teacherNumber,
                "teacher_no" => $add,
                "status" => !empty($leaveData)?2:1,
            );
            $update = TeacherModel::getInstance()->updateData($add,$updateParams);
        }
        
        if($add>0 && $update>0) {
            Ccc_Helper_Com::alertMess("/teacher/list", "添加成功");
        } else {
            Ccc_Helper_Com::alertMess("/teacher/list", "添加失败");
        }
    }
    
    public function editAction() {
        $this->view->classData = ClassModel::getInstance()->getClassData();
        $this->view->teacherTypeData = TeacherModel::getInstance()->getTypeData();
        $this->view->jobData = JobModel::getInstance()->getJobData();
        $this->view->title = "编辑教工信息";
        $teacherId = (int) $this->_getParam("teacher_id");
        $from = trim($this->_getParam("from"));
        $teacherData = TeacherModel::getInstance()->getRowData($teacherId);
        $teacherData['birthday'] = $teacherData['birthday']=="0000-00-00"?"":$teacherData['birthday'];
        $teacherData['job_date'] = $teacherData['job_date']=="0000-00-00"?"":$teacherData['job_date'];
        $teacherData['bargain_start_date'] = $teacherData['bargain_start_date']=="0000-00-00"?"":$teacherData['bargain_start_date'];
        $teacherData['bargain_end_date'] = $teacherData['bargain_end_date']=="0000-00-00"?"":$teacherData['bargain_end_date'];
        $teacherData['graduate_date'] = $teacherData['graduate_date']=="0000-00-00"?"":$teacherData['graduate_date'];
        $teacherData['leave_date'] = $teacherData['leave_date']=="0000-00-00"?"":$teacherData['leave_date'];
        $this->view->teacherData = $teacherData;
        $config = new Zend_Config_Ini(PATH_ROOT . DS . $this->_conf->path->params_conf, "school");
        $swfData = array(
            "upload_url" => isset($config->teacher->upload_url) ? $config->teacher->upload_url : "",
            "upload_name" => isset($config->teacher->upload_name) ? $config->teacher->upload_name : "",
            "maxsize_user_photo" => isset($config->teacher->maxsize_user_photo) ? $config->teacher->maxsize_user_photo : "",
            "type_user_photo" => isset($config->teacher->type_user_photo) ? $config->teacher->type_user_photo : "",
            "path_user_photo" => isset($config->teacher->path_user_photo) ? $config->teacher->path_user_photo : "",
        );
        $this->view->swfData = $swfData;
        $this->view->from = $from;
    }
    
    public function updateAction() {
        $this->_helper->layout->disableLayout();
        
        $hiddenTeacherId = (int) $this->_getParam("hidden_teacher_id");
        $from = trim($this->_getParam("from"));
        // get the params;
        $addBaseParams = array(
            "en_name" => trim($this->_getParam("en_name")),
            "cn_name" => trim($this->_getParam("cn_name")),
            "sex" => (int) $this->_getParam("sex"),
            "birthday" => trim($this->_getParam("birthday")),
            "address" => trim($this->_getParam("address")),
            "id_type" => (int) $this->_getParam("id_type"),
            "id_number" => trim($this->_getParam("id_name")),
            "phone" => trim($this->_getParam("phone")),
            "mobile_phone" => trim($this->_getParam("mobile_phone")),
            "email" => trim($this->_getParam("email")),
            "graduate_school" => trim($this->_getParam("graduate_school")),
            "graduate_date" => trim($this->_getParam("graduate_date")),
            "graduate_specialty" => trim($this->_getParam("graduate_specialty")),
            "max_education" => (int) $this->_getParam("max_education"),
        );
        $leaveData = trim($this->_getParam("leave_date"));
        $addSchoolParams = array(
            "school_class_id" => (int) $this->_getParam("class_id"),
            "school_teacher_type_id" => (int) $this->_getParam("teacher_type_id"),
            "school_job_id" => (int) $this->_getParam("job_id"),
            "job_date" => trim($this->_getParam("job_date")),
            "bargain_start_date" => trim($this->_getParam("bargain_start_date")),
            "bargain_end_date" => trim($this->_getParam("bargain_end_date")),
            "bargain_count" => (int) $this->_getParam("bargain_count"),
            "leave_date" => trim($this->_getParam("leave_date")),
            "leave_reason" => trim($this->_getParam("leave_reason")),
            "status" => !empty($leaveData)?2:1,
            "update_user_id" => (int)$this->_session->uid,
            "update_time_int" => time(),
        );
        $result = array_merge($addBaseParams,$addSchoolParams);
        $update = TeacherModel::getInstance()->updateData($hiddenTeacherId, $result);
        $where =!empty($from)?base64_decode($from):"";
        $where = $where . "/teacher_id/{$hiddenTeacherId}";
        if($update>0) {
            Ccc_Helper_Com::alertMess("/teacher/list{$where}", "操作成功");
        } else {
            Ccc_Helper_Com::alertMess("/teacher/list{$where}", "操作失败");
        }
    }
    
    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $teacherId = (int) $this->_getParam("teacher_id");
        $delete = TeacherModel::getInstance()->deleteData($teacherId);
        $from = trim($this->_getParam("from"));
        $where =!empty($from)?base64_decode($from):"";
        if($delete>0) {
            Ccc_Helper_Com::alertMess("/teacher/list{$where}", "操作成功");
        } else {
            Ccc_Helper_Com::alertMess("/teacher/list{$where}", "操作失败");
        }
    }
    
    
 

}