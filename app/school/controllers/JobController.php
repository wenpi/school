<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 岗位管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/07/05
 */
class JobController extends Ccc_Base_Controller {

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
        // deal with the page.
        $page = (int) $this->_getParam("page");
        $page = $page < 1 ? 1 : $page;
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        // where
        $where = " ";
        $condition = "";

        // compare the page data.
        $dataCount = JobModel::getInstance()->getDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $data = JobModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->data = $data;
        // view page
        $this->view->pageData = array("page" => $page, "url" => "/job/list{$condition}",
            "page_count" => $pageCount);
        $this->view->title = "岗位管理";
        $this->view->from = base64_encode("/page/{$page}" . $condition);
    }

    // 添加
    public function ajaxAddAction() {
        $this->view->title = "添加岗位信息";
    }

    public function ajaxSaveAction() {
        $this->_helper->layout->disableLayout();
        $jobLevel = (int) $this->_getParam("input_job_level");
        $jobName = trim($this->_getParam("input_job_name"));
        $comments = trim($this->_getParam("input_comments"));

        $isHas = JobModel::getInstance()->checkData($jobName);
        if ($isHas > 0) {
            echo "-2";
            exit;
        }

        $params = array(
            "job_level" => $jobLevel,
            "job_name" => $jobName,
            "comments" => $comments,
                );

        $add = JobModel::getInstance()->addData($params);
        echo $add;
        exit;
    }

    // 编辑
    public function ajaxEditAction() {
        $this->_helper->layout->disableLayout();
        $jobId = (int) $this->_getParam("job_id");
        $this->view->jobData = JobModel::getInstance()->getRowData($jobId);
        $this->view->title = "编辑岗位信息";
                
    }

    public function ajaxUpdateAction() {
        $this->_helper->layout->disableLayout();
        $jobId = (int) $this->_getParam("job_id");
        $hiddenJobName = trim($this->_getParam("hidden_input_job_name"));
        $jobName = trim($this->_getParam("input_job_name"));
        $jobComments = trim($this->_getParam("input_job_comments"));
        $isHas = 0;
        if($hiddenJobName!=$jobName) {
            $isHas = JobModel::getInstance()->checkData($jobName);
        }
        if( $isHas>0 ) {
            echo "-2";
            exit;
        }
        $params = array(
            "job_name" => $jobName,
            "comments" => $jobComments,
        );
        $update = JobModel::getInstance()->updateData($jobId,$params);
        echo $update;
        exit;
    }

    // 删除
    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $jobId = (int) $this->_getParam("job_id");
        $delete = JobModel::getInstance()->deleteData($jobId);
        if ($delete > 0) {
            Ccc_Helper_Com::alertMess("/job/list", "操作成功");
        } else {
            Ccc_Helper_Com::alertMess("/job/list", "操作失败");
        }
    }

}