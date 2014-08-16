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
     * 教师费用列表
     */
    public function listTeacherAction() {

       
        $this->view->title = "教工费用列表";
    }

   
    
    /**
     * 学生费用列表
     */
    public function listStudentAction() {
        $this->view->title = "学生费用列表";
    }
    
    
    /**
     * 费用列表
     */
    public function listAction() {
        
    }
    
    
    
    
    
    
    
    
    
    
    
    // 学期配置
    public function listConfigTermAction() {
        $this->view->title = "学期配置列表";
        
        $page = 1;
        $pageSize = 20;
        $where = "";
        $condition = "";
        
        $this->view->data = MoneyModel::getInstance()->getConfigTermPageData($page, $pageSize, $where);
        $this->view->from = base64_encode( urlencode("/page/{$page}" . $condition) );
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
        $this->view->configTermData = MoneyModel::getInstance()->getConfigTermRowData( $termId );
        $this->view->from = trim($this->_getParam("from"));
    }
    
    public function ajaxEditConfigTermAction() { 
        $this->_helper->layout->disableLayout();
        $this->view->title = "编辑学期配置信息"; 
        
        $termId = (int) $this->_getParam("term_id");
        $this->view->configTermData = MoneyModel::getInstance()->getConfigTermRowData( $termId );
        $this->view->from = trim($this->_getParam("from"));
    }
    
    public function ajaxUpdateConfigTermAction() {
        
        
    }
    
    public function deleteConfigTermAction() {
        $this->_helper->layout->disableLayout();
        $termId = (int) $this->_getParam("term_id");
        $from = trim($this->_getParam("from"));
        $from = urldecode( base64_decode( $from ) );
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
        
        $page = 1;
        $pageSize = 20;
        $where = "";
        $condition = "";
        
        $this->view->data = MoneyModel::getInstance()->getConfigMoneyProjectPageData( $page, $pageSize , $where );
        $this->view->from = base64_encode( urlencode("/page/{$page}" . $condition) );
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
    }
    
    public function addConfigMoneyAction() {
        $this->view->title = "添加班级学期项目费用信息";
    }
    
    public function saveConfigMoneyAction() {
        
    }
    
    public function editConfigMoneyAction() {
        
    }
    
    public function updateConfigMoneyAction() {
        
    }
    
    public function deleteConfigMoneyAction() {
        
    }
    
    
        
    
}