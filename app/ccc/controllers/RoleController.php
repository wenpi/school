<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * RoleController
 * @author  taozywu<wutao@bwstor.com.cn>
 * @date 2013/07/03
 */
class RoleController extends Ccc_Base_Controller {

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
        $roleName = trim($this->_getParam("role_name"));
        // deal with the page.
        $page = (int) $this->_getParam("page");
        $page = $page < 1 ? 1 : $page;
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        // where
        $where = " ";
        $condition = "";
        $where = !empty($roleName) ? " and role_name like '{$roleName}%'" : "";
        $condition = !empty($roleName) ? "/role_name/{$roleName}" : "";

        // compare the page data.
        $dataCount = RoleModel::getInstance()->getDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $data = RoleModel::getInstance()->getPageData($page, $pageSize, $where);
        $this->view->data = $data;
        // view page
        $this->view->pageData = array("page" => $page, "url" => "/role/list{$condition}",
            "page_count" => $pageCount);
        $this->view->title = "角色管理";
        $this->view->from = base64_encode("/page/{$page}" . $condition);
        $this->view->roleName = $roleName;
    }

    public function ajaxEditAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title1 = "编辑角色信息";
        $this->view->title2 = "编辑角色与权限映射配置信息";
        $roleId = (int) $this->_getParam("role_id");
        $this->view->roleInfo = RoleModel::getInstance()->getRoleInfo($roleId);
    }

    public function ajaxUpdateRoleInfoAction() {
        $this->_helper->layout->disableLayout();
        $roleId = (int) $this->_getParam("role_id");
        $input_comments = trim($this->_getParam("input_comments"));
        $params = array(
            "comments" => $input_comments,
        );
        $update = RoleModel::getInstance()->updateData($roleId, $params);
        echo $update;
        exit;
    }
    
    public function ajaxAddAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title = "添加角色信息";
    }
    
    public function ajaxSaveRoleInfoAction() {
        $this->_helper->layout->disableLayout();
        $inputRoleName = trim($this->_getParam("input_rolename"));
        $inputComments = trim($this->_getParam("input_comments"));
        $isHas = RoleModel::getInstance()->checkRoleName( $inputRoleName );
        if( $isHas >0 ) {
            echo "-2";exit;
        }
        $params = array(
            "role_name" => $inputRoleName,
            "comments" => $inputComments,
        );
        $add = RoleModel::getInstance()->addData( $params );
        echo $add;
        exit;
    }
    
    public function ajaxDeleteAction() {
         $this->_helper->layout->disableLayout();
         $roleId = (int) $this->_getParam("role_id");
         
         $isDelete = RoleModel::getInstance()->checkRoleRight($roleId);
         if($isDelete>0) {
             echo "-1";
             exit;
         }
         $params = array("is_delete"=>1);
         $update = RoleModel::getInstance()->updateData($roleId ,$params);
         echo $update;
         exit;
    }

}