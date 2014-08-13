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

        $this->view->title = "费用列表";
    }

    public function addAction() {
        $this->view->title = "费用录入";
    }
    
    public function saveAction() {
        
    }
    
    public function editAction() {
        
    }
    
    public function updateAction() {
        
    }
    
    public function deleteAction() {
        
    }
    
}