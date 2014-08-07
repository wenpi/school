<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 学生管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/07/05
 */
class StudentController extends Ccc_Base_Controller {

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

        $studentId = (int) $this->_getParam("student_id");
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


        $dataCount = StudentModel::getInstance()->getDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        $data = StudentModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->title = "学生管理";
        $this->view->data = $data;
        // view page
        $this->view->pageData = array("page" => $page, "url" => "/student/list.action{$condition}",
            "page_count" => $pageCount);
        $this->view->enName = $enName;
        $this->view->cnName = $cnName;
        $this->view->studentId = $studentId;
        $this->view->from = base64_encode( urlencode("/page/{$page}" . $condition) );

    }

    public function addAction() {
        $this->view->title = "添加学生信息";
        $this->view->classData = ClassModel::getInstance()->getClassData();
    }

    /**
     * 上传图像
     */
    public function ajaxUploadPhotoAction() {
        $this->_helper->layout->disableLayout();
        $config = new Zend_Config_Ini(PATH_ROOT . DS . $this->_conf->path->params_conf, "school");
        if (!isset($_FILES[$config->student->upload_name])
                || !is_uploaded_file($_FILES[$config->student->upload_name]["tmp_name"])
                || $_FILES[$config->student->upload_name]["error"] != 0) {
            die(0);
        }
        // get the paramter.
        $studentId = (int) $this->_getParam("student_id");
        // get the config.
        $photoPath = isset($config->student->path_user_photo) ? PATH_ROOT . $config->student->path_user_photo : "";
        $photoType = isset($config->student->type_user_photo) ? $config->student->type_user_photo : "";
        $photoMaxsize = isset($config->student->maxsize_user_photo) ? $config->student->maxsize_user_photo : 2048;
        $photoType = str_replace("*.", "", $photoType);
        $photoType = !empty($photoType) ? @explode(";", $photoType) : array();
        $userPhoto = "";
        $classUpload = Ccc_Third_Upload::getInstance($photoPath, $photoType, $photoMaxsize);
        $upload = $classUpload->run($config->student->upload_name,1,$studentId);
        if ($upload) {
            $result = $classUpload->getInfo();
            // 更新数据表
            $userPhoto = $result[0]['saveName'];
            $params = array(
                "photo_name" => $userPhoto,
            );
            StudentModel::getInstance()->updateData($studentId, $params);
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
        );
        $addSchoolParams = array(
            "sch_class_id" => (int) $this->_getParam("class_id"),
            "school_status" => (int) $this->_getParam("school_status"),
            "entrance_date" => trim($this->_getParam("entrance_date")),
            "graduate_date" => trim($this->_getParam("graduate_date")),
            "add_user_id" => (int)$this->_session->uid,
            "add_time_int" => time(),
        );
        $result = array_merge($addBaseParams,$addSchoolParams);
        $add = StudentModel::getInstance()->addData($result);
//	$add = 1;
        if($add>0) {
	    // 添加家长信息
            $parentEnName = $this->_getParam("parent_en_name");
            $parentCnName = $this->_getParam("parent_cn_name");
            $parentNamed = $this->_getParam("parent_named");
            $parentPhone = $this->_getParam("parent_phone");
            $parentMobilePhone = $this->_getParam("parent_mobile_phone");
            $parentIsMessage = $this->_getParam("parent_is_message");
            $dealParams = StudentModel::getInstance()->dealParentParams($parentEnName, $parentCnName, $parentNamed,
                    $parentPhone, $parentMobilePhone, $parentIsMessage);
            $addParent = 0;
            if ($dealParams) {
                foreach ($dealParams as $p) {
                    $p['sch_student_id'] = $add;
                    ParentModel::getInstance()->addData($p);
                }
                $addParent = 1;
            }
        }

        if($add>0 && $addParent>0) {
            Ccc_Helper_Com::alertMess("/student/list", "添加成功");
        } else {
            Ccc_Helper_Com::alertMess("/student/list", "添加失败");
        }
    }

    public function editAction() {
        $studentId = (int) $this->_getParam("student_id");
        $from = trim($this->_getParam("from"));
        $studentData = StudentModel::getInstance()->getRowData($studentId);
        $studentData['birthday'] = $studentData['birthday']=="0000-00-00"?"":$studentData['birthday'];
        $studentData['entrance_date'] = $studentData['entrance_date']=="0000-00-00"?"":$studentData['entrance_date'];
        $studentData['graduate_date'] = $studentData['graduate_date']=="0000-00-00"?"":$studentData['graduate_date'];
        $this->view->studentData = $studentData;
        $config = new Zend_Config_Ini(PATH_ROOT . DS . $this->_conf->path->params_conf, "school");
        $swfData = array(
            "upload_url" => isset($config->student->upload_url) ? $config->student->upload_url : "",
            "upload_name" => isset($config->student->upload_name) ? $config->student->upload_name : "",
            "maxsize_user_photo" => isset($config->student->maxsize_user_photo) ? $config->student->maxsize_user_photo : "",
            "type_user_photo" => isset($config->student->type_user_photo) ? $config->student->type_user_photo : "",
            "path_user_photo" => isset($config->student->path_user_photo) ? $config->student->path_user_photo : "",
        );
        $this->view->swfData = $swfData;
        $this->view->from = $from;
		$this->view->classData = ClassModel::getInstance()->getClassData();
        $this->view->title = "编辑学生信息";
		$this->view->parentData = ParentModel::getInstance()->getParentDataByWhere( " and sch_student_id={$studentId}" );
    }

    public function updateAction() {
        $this->_helper->layout->disableLayout();
        $hiddenStudentId = (int) $this->_getParam("hidden_student_id");
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
        );
        $addSchoolParams = array(
            "sch_class_id" => (int) $this->_getParam("class_id"),
            "entrance_date" => trim($this->_getParam("entrance_date")),
            "graduate_date" => trim($this->_getParam("graduate_date")),
            "school_status" => (int) $this->_getParam("school_status"),
            "update_user_id" => (int)$this->_session->uid,
            "update_time_int" => time(),
        );
        $result = array_merge($addBaseParams,$addSchoolParams);
        $update = StudentModel::getInstance()->updateData($hiddenStudentId, $result);
        $where = !empty($from) ? urldecode( base64_decode($from) ) : "";
        $where = $where . "/student_id/{$hiddenStudentId}";
        if($update>0) {
            // 更新家长信息
            $parentEnName = $this->_getParam("parent_en_name");
            $parentCnName = $this->_getParam("parent_cn_name");
            $parentNamed = $this->_getParam("parent_named");
            $parentPhone = $this->_getParam("parent_phone");
            $parentMobilePhone = $this->_getParam("parent_mobile_phone");
            $parentIsMessage = $this->_getParam("parent_is_message");
            $dealParams = StudentModel::getInstance()->dealParentParams($parentEnName, $parentCnName, $parentNamed,
                    $parentPhone, $parentMobilePhone, $parentIsMessage);
            $addParent = 0;
            if ($dealParams) {
                foreach ($dealParams as $k=> $p) {
                    ParentModel::getInstance()->updateData($k, $p);
                }
                $addParent = 1;
            }
        }

        if( $update>0 && $addParent >0 ) {
            Ccc_Helper_Com::alertMess("/student/list{$where}", "操作成功");
        } else {
            Ccc_Helper_Com::alertMess("/student/list{$where}", "操作失败");
        }
    }

    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $studentId = (int) $this->_getParam("student_id");
        $delete = StudentModel::getInstance()->deleteData($studentId);
        $from = trim($this->_getParam("from"));
        $where = !empty($from) ? urldecode( base64_decode($from) ) : "";
        if($delete>0) {
            Ccc_Helper_Com::alertMess("/teacher/list{$where}", "操作成功");
        } else {
            Ccc_Helper_Com::alertMess("/teacher/list{$where}", "操作失败");
        }
    }

}