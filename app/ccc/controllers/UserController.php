<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * UserController
 * @author  taozywu<wutao@bwstor.com.cn>
 * @date 2013/07/03
 */
class UserController extends Ccc_Base_Controller {

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
        die();
    }

    public function listAction() {
        $userName = trim($this->_getParam("user_name"));
        $where = !empty($userName) ? " and user_name like '{$userName}%'" : "";
        $this->view->title = "用户管理";
        $this->view->userName = $userName;
//        echo "d";
        $this->view->data = UserModel::getInstance()->getUserList("{$where}");
    }

    public function ajaxEditAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title1 = "编辑用户信息";
        $this->view->title2 = "配置用户角色信息";
        $userId = (int) $this->_getParam("user_id");
        // 获取用户基本信息
        $this->view->userInfo = UserModel::getInstance()->getUserInfo($userId);
        $userRole = UserModel::getInstance()->getUserRoleData($userId);
        $where = "";
        $rWhere = "";
        if (!empty($userRole)) {
            foreach ($userRole as $ur) {
                $where .= " and role_id!={$ur['role_id']}";
            }
        }
        if (!$this->_isAdmin) {
            $or = "";
            if (!empty($this->_session->urole)) {
                foreach ($this->_session->urole as $r) {
                    $rWhere .= "{$or}{$r['role_id']}";
                    $or = ",";
                }
            }
        }
        $rWhere = !empty($rWhere) ? " and role_id in ({$rWhere}) " : "";
        $where .= $rWhere;
        $this->view->userRole = $userRole;
        $this->view->allRole = RoleModel::getInstance()->getRoleData($where);
    }

    public function ajaxUpdateUserInfoAction() {
        $this->_helper->layout->disableLayout();
        $userId = (int) $this->_getParam("user_id");
        $inputRealName = trim($this->_getParam("input_realname"));
        $inputIp = trim($this->_getParam("input_ip"));
        $inputStatus = (int) $this->_getParam("input_status");
        $params = array(
            "real_name" => $inputRealName,
            "ip" => $inputIp,
            "status" => $inputStatus,
                );
        $update = UserModel::getInstance()->updateData($userId, $params);
        echo $update;
        exit;
    }

    public function ajaxUpdateUserPassAction() {
        $this->_helper->layout->disableLayout();
        $userId = (int) $this->_getParam("user_id");
        $inputNewPass = trim($this->_getParam("input_newpass"));
        $params = array(
            "user_pass" => md5($inputNewPass),
                );
        $update = UserModel::getInstance()->updateData($userId, $params);
        echo $update;
        exit;
    }

    public function ajaxSaveUserRoleAction() {
        $this->_helper->layout->disableLayout();
        $userId = (int) $this->_getParam("user_id");
        $roleIds = trim($this->_getParam("role_ids"));
        if ($userId == 0) {
            echo -1;
            exit;
        }
        $roleResult = @explode("|", $roleIds);
        array_shift($roleResult);
        // 将之前的角色删掉，然后再重新插入。
        $delete = UserModel::getInstance()->deleteUserRoleByUserId($userId);
        $save = 0;
        if (!empty($roleResult) && $delete > 0) {
            $save = UserModel::getInstance()->addUserRole($userId, $roleResult);
        }
        echo $save;
        exit;
    }

    public function ajaxAddAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title1 = "添加用户信息";
        $this->view->title2 = "配置用户设置信息";
        $this->view->userTypeData = UserModel::getInstance()->getUserTypeData();
        $config = new Zend_Config_Ini(PATH_ROOT . DS . $this->_conf->path->params_conf, "admin");
        $this->view->defaultPasswd = isset($config->default_passwd) ? $config->default_passwd : "123456";
    }

    public function ajaxSaveUserInfoAction() {
        $this->_helper->layout->disableLayout();
        $inputUserName = trim($this->_getParam("input_username"));
        $inputRealName = trim($this->_getParam("input_realname"));
        $inputIp = trim($this->_getParam("input_ip"));
        $inputStatus = (int) $this->_getParam("input_status");
        $inputNewPass = trim($this->_getParam("input_newpass"));
        $isHas = UserModel::getInstance()->checkUserName($inputUserName);
        if ($isHas > 0) {
            echo "-2";
            exit;
        }
        $params = array(
            "user_name" => $inputUserName,
            "real_name" => $inputRealName,
            "ip" => $inputIp,
            "status" => $inputStatus,
            "user_pass" => md5($inputNewPass),
                );
        $add = UserModel::getInstance()->addData($params);
        echo $add;
        exit;
    }

    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $userId = (int) $this->_getParam("user_id");
        $delete = UserModel::getInstance()->deleteData($userId);
        if ($delete > 0) {
            Ccc_Helper_Com::alertMess("/user/list", "操作成功", 1);
        }
    }

    public function ajaxShowDataAction() {
        $this->_helper->layout->disableLayout();
        $typeId = (int) $this->_getParam("type_id");
//        echo $dbName;exit;
        $leftData = UserModel::getInstance()->getUserList(" and user_type={$typeId} and status in (1,2,3) ");
        $leftString = "";
        if ($leftData) {
            foreach ($leftData as $left) {
                $leftString .= "<option value='{$left['user_name']}_{$left['real_name']}'>{$left['real_name']}[{$left['user_name']}]</option>";
            }
        }
//        print_r($leftData);
        $rightString = "";
        $rightData = UserModel::getInstance()->getDbDataByTypeId($typeId, $leftData);
        if ($rightData) {
            foreach ($rightData as $right) {
                $rightString .= "<option value='{$right['right_no']}_{$right['right_name']}'>{$right['right_name']}[{$right['right_no']}]</option>";
            }
        }
        $result = array("error_code" => 0, "msg" => "", "data" => array("left" => $leftString,"right" => $rightString));
        echo Ccc_Third_Json::getInstance()->encode($result);
        exit;
    }

    public function ajaxSaveUserSetAction() {
        $this->_helper->layout->disableLayout();
        $userType = (int) $this->_getParam("user_type_id");
        $userIdStr = trim($this->_getParam("user_id_str"));
        // 不管怎么操作，先将数据清掉。然后重新加数据。如果没数据则不需要加。
        $userIdResult = @explode("|", $userIdStr);
        @array_shift($userIdResult);
        $delete = UserModel::getInstance()->deleteUserSetByUserType($userType);
        $save = 0;
        if( !empty($userIdResult) && $delete > 0 ) {
            $config = new Zend_Config_Ini(PATH_ROOT . DS . $this->_conf->path->params_conf, "admin");
            $defaultPass = isset($config->default_passwd) ? $config->default_passwd : "123456";
            $save = UserModel::getInstance()->addUserSet($userType, $userIdResult, $defaultPass);
        }
        if( empty($userIdResult) && $delete > 0 ) {
            $save = 1;
        }
        echo $save;
        exit;
    }

}