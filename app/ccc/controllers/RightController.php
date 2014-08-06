<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * RightController
 * @author  taozywu<wutao@bwstor.com.cn>
 * @date 2013/07/03
 */
class RightController extends Ccc_Base_Controller {

    /**
     * 初始化
     * @see Ccc_Base_Controller::init()
     */
    public function init() {
        parent::init();
//        $this->checkAuth();
        $this->checkLog();
        $this->_helper->layout()->setLayout("ccc");
    }

    public function indexAction() {
        exit;
    }

    // 用户列表
    public function listUserAction() {
        $this->_forward("list", "user");
    }

    
    // 角色列表
    public function listRoleAction() {
        $this->_forward("list", "role");
    }
    
    
    // 权限列表
    public function listRightAction() {
        $this->_forward("list","auth");
    }
    
    
    // 用户角色权限列表
    public function listUserRoleRightAction() {
        $this->view->userData = UserModel::getInstance()->getUserList();
        $this->view->title = "用户角色权限列表";
    }

    /**
     * 通过用户来获取对应的角色数据
     */
    public function ajaxGetRoleDataByUserIdAction() {
        $this->_helper->layout()->disableLayout();
        $userId = (int) $this->_getParam("user_id");
        $this->view->roleData = UserModel::getInstance()->getUserRoleByUserId($userId);
        $this->view->roleCount = UserModel::getInstance()->getUserRoleCountByUserId($userId);
    }

    /**
     * 通过角色来获取对应的权限数据
     * 获取某用户的权限数据
     */
    public function ajaxGetRightDataByRoleIdAction() {
        $this->_helper->layout()->disableLayout();
        $userId = (int) $this->_getParam("user_id");
        $roleId = (int) $this->_getParam("role_id");
        $rightResult = RightModel::getInstance()->getRoleRightByRoleId($roleId);
        $where = "";
        if (!empty($rightResult)) {
            foreach ($rightResult as $p) {
                $or = " or ";
                $where .= " {$or} right_id={$p['right_id']} ";
            }
        }
        $where = !empty($where) ? " and ( 1>2 {$where} ) " : " and 1>2 ";
        // 获取某角色下所有权限
        $result = RightModel::getInstance()->getRightDataByWhere($where);
        $count = RightModel::getInstance()->getRightCountByWhere($where);
        // 获取指定用户某角色权限
        $userRoleRight = RightModel::getInstance()->getRightByUserIdAndRoleId($userId, $roleId);
        // 获取当前登录用户角色权限
        $sessUserRoleRight = RightModel::getInstance()->getRightByUserIdAndRoleId($this->_session->uid, $roleId);
        if (!empty($result)) {
            foreach ($result as & $p) {
                $p['selected'] = 0;
                $p['current_selected'] = 0;
                // 最高级管理员
                if (!$this->_isAdmin) {
                    if (isset($sessUserRoleRight[$p['right_id']]) && $sessUserRoleRight[$p['right_id']] == 'OK') {
                        $p['current_selected'] = 1;
                    }
                } else {
                    $p['current_selected'] = 1;
                }
                if (isset($userRoleRight[$p['right_id']]) && $userRoleRight[$p['right_id']] == 'OK') {
                    $p['selected'] = 1;
                }
                if (isset($p['node']) && !empty($p['node'])) {
                    foreach ($p['node'] as &$pp) {
                        $pp['selected'] = 0;
                        $pp['current_selected'] = 0;
                        if (!$this->_isAdmin) {
                            if (isset($sessUserRoleRight[$pp['right_id']]) && $sessUserRoleRight[$pp['right_id']] == 'OK') {
                                $pp['current_selected'] = 1;
                            }
                        } else {
                            $pp['current_selected'] = 1;
                        }
                        if (isset($userRoleRight[$pp['right_id']]) && $userRoleRight[$pp['right_id']] == 'OK') {
                            $pp['selected'] = 1;
                        }
                    }
                }
            }
        }
        $this->view->rightData = $result;
        $this->view->roleId = $roleId;
        $this->view->count = $count;
    }

    /**
     * 保存用户角色权限
     */
    public function ajaxSaveUserRoleRightAction() {
        $this->_helper->layout()->disableLayout();
        $userId = (int) $this->_getParam("user_id");
        $roleId = (int) $this->_getParam("role_id");
        $rightIds = trim($this->_getParam("right_ids"));
        $check = (int) $this->_getParam("check");

        $rightIdArr = !empty($rightIds) ? @explode("|", $rightIds) : array();
        if (!empty($rightIdArr)) {
            array_shift($rightIdArr);
        }
        $count = count( $rightIdArr ) ;
        // 先删除某用户某角色所有权限
        RightModel::getInstance()->deleteUserRoleRightByWhere($userId, $roleId , $rightIdArr);
        if ($count > 0 && $check > 0) {
            // 保存用户角色权限
            RightModel::getInstance()->saveUserRoleRight($userId, $roleId, $rightIdArr);
        }
        // 生成静态文件
        $userRoleRightData = RightModel::getInstance()->getUserRightResourceData();
        $data = array();
        if ($userRoleRightData) {
            foreach ($userRoleRightData as $p) {
                if (!empty($p['action_string'])) {
                    $data[$p['user_id']][$p['app_string']][$p['module_string']][] = $p['action_string'];
                }
            }
        }        
        $isSave = 0;
        $content = "<?php $" . "USERROLERIGHTS" . "='" . serialize($data) . "';?>";
        if (isset($this->_conf->path_user_role_right)) {
            Ccc_Helper_Com::createFile(PATH_ROOT . $this->_conf->path_user_role_right);
            file_put_contents(PATH_ROOT . $this->_conf->path_user_role_right, $content);
            $isSave = 1;
        } else {
            $isSave = -1;
        }

        echo $isSave;
        exit;
    }

    public function ajaxGetResourceDataByRightIdAction() {
        $this->_helper->layout()->disableLayout();
        $rightId = (int) $this->_getParam("right_id");
        $this->view->data = RightModel::getInstance()->getResourceDataByRightId( $rightId );
    }
}