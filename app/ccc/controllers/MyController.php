<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * MyController
 * @author  taozywu<wutao@bwstor.com.cn>
 * @date 2013/07/03
 */
class MyController extends Ccc_Base_Controller {

    /**
     * 初始化
     * @see Ccc_Base_Controller::init()
     */
    public function init() {
        parent::init();
        if (!isset($this->_session->uid)) {
            die("Session Lost.");
        }
        if (isset($this->_session->isccc) && $this->_session->isccc > 0) {
            die("抱歉！该用户为授权过来的，不能修改其资料信息");
        }
        $this->_helper->layout()->setLayout("ccc");
    }

    public function indexAction() {
        die();
    }

    public function myspaceAction() {
        $this->view->title1 = "查看个人登录信息";
        $this->view->title2 = "查看个人资料信息";
        $this->view->myInfo = MyModel::getInstance()->getMyInfo($this->_session->uid);
    }

    public function ajaxGetpassAction() {
        $this->view->title = "获取个人密码信息";
    }

    public function ajaxUpdatepassAction() {
        $oldPass = trim($this->_getParam("old_pass"));
        $newPass = trim($this->_getParam("new_pass"));
        $check = MyModel::getInstance()->checkUserInfo($this->_session->uname, $oldPass);
        if ($check < 1) {
            echo "-1";
            exit;
        }
        $update = MyModel::getInstance()->updatePass($this->_session->uid, $newPass);
        if ($update > 0) {
            // 更新
            AdminModel::getInstance()->updateUserLoginStatus($this->_session->uid, 0, 0, time());
            // 注销
            $this->_session->unsetAll("ccc");
        }
        echo $update;
        exit;
    }

}