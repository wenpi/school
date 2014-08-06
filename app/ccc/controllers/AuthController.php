<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * AuthController
 * @author  taozywu<wutao@bwstor.com.cn>
 * @date 2014/07/20
 */
class AuthController extends Ccc_Base_Controller {

    /**
     * 初始化
     * @see Ccc_Base_Controller::init()
     */
    public function init() {
        parent::init();
        $this->checkAuth();
        $this->checkLog();
        $this->_helper->layout()->setLayout("ccc");
    }

    public function indexAction() {
        
    }

    public function listAction() {
        
        $rightName = trim($this->_getParam("right_name"));
        // deal with the page.
        $page = (int) $this->_getParam("page");
        $page = $page < 1 ? 1 : $page;
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        // where
        $where = " ";
        $condition = "";
        $where = !empty($rightName) ? " and right_name like '{$rightName}%'" : "";
        $condition = !empty($rightName) ? "/right_name/{$rightName}" : "";

        // compare the page data.
        $dataCount = AuthModel::getInstance()->getDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $data = AuthModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->data = $data;
        // view page
        $this->view->pageData = array("page" => $page, "url" => "/auth/list{$condition}",
            "page_count" => $pageCount);
        $this->view->title = "权限管理";
        $this->view->from = base64_encode("/page/{$page}" . $condition);
        $this->view->rightName = $rightName;
    }

    public function ajaxEditAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title1 = "编辑权限信息";
        $this->view->title2 = "编辑权限与资源映射配置信息";
        $rightId = (int) $this->_getParam("right_id");
        $this->view->rightRowData = AuthModel::getInstance()->getRowData($rightId);
    }

    public function ajaxUpdateRightInfoAction() {
        $this->_helper->layout->disableLayout();
        $rightId = (int) $this->_getParam("right_id");
        $input_comments = trim($this->_getParam("input_comments"));
        $params = array(
            "comments" => $input_comments,
        );
        $update = AuthModel::getInstance()->updateData($rightId, $params);
        echo $update;
        exit;
    }
    
    public function ajaxAddAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title = "添加权限信息";
    }
    
    public function ajaxSaveRightInfoAction() {
        $this->_helper->layout->disableLayout();
        $inputRightName = trim($this->_getParam("input_rightname"));
        $inputComments = trim($this->_getParam("input_comments"));
        $isHas = AuthModel::getInstance()->checkData( $inputRightName );
        if( $isHas >0 ) {
            echo "-2";
            exit;
        }
        $params = array(
            "right_name" => $inputRightName,
            "comments" => $inputComments,
        );
        $add = AuthModel::getInstance()->addData( $params );
        echo $add;
        exit;
    }
    
    public function ajaxDeleteAction() {
        $this->_helper->layout->disableLayout();
        $rightId = (int) $this->_getParam("right_id");
        $from = trim($this->_getParam("from"));
        // 删除之前先判断是否有资源映射数据，如果有则不能删除。否则可以。
        $isDelete = AuthModel::getInstance()->checkRightResource( $rightId );
        if($isDelete>0) {
            echo "-1";
            exit;
        }
        $params = array("is_delete" => 1);
        $update = AuthModel::getInstance()->updateData($rightId, $params);
        $errorCode = $update == 1 ? 0 : 1;
        $result = array("error_code" => $errorCode, "msg" => "", "data"=>array("from" => base64_decode($from)));
        echo Ccc_Third_Json::getInstance()->encode( $result );
        exit;
    }

}