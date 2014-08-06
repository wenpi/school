<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * AdminController
 * @author  taozywu<wutao@bwstor.com.cn>
 * @date 2013/06/04
 */
class AdminController extends Ccc_Base_Controller {

    /**
     * 初始化
     * @see Ccc_Base_Controller::init()
     */
    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->_forward("login");
    }

    /**
     * 登录
     */
    public function loginAction() {
        $redirect = 0;
        if (isset($this->_session->uid) && !empty($this->_session->uid)) {
			  if(isset($this->_session->isccc) && $this->_session->isccc >0 ) { 
					$this->_session->urolecheck = true;
			  }
            // OK
//            $isLogin = AdminModel::getInstance()->isUserLogin($this->_session->uid);
//            if ($isLogin) {
                $this->_forward("logina", "admin", "ccc", array("act" => 1));
//            } else {
//                $this->_session->unsetAll("ccc");
//                $redirect = 1;
//            }
        } else {
            $redirect = 1;
        }

        if ($redirect == 1) {
            $this->_helper->layout->setLayout("ccc");
        }
    }

    /**
     * 登录处理
     * 1=OK 2=登录失败 3=已经登录 4=未激活 5=冻结 6=删除 7=ip拒绝 8=已登录不能再登录
     */
    public function loginaAction() {
        $act = (int) $this->_getParam("act");
        if (!$act) {
            $redirect = 0;
            if (isset($this->_session->uid) && !empty($this->_session->uid)) {
                $redirect = 3; // 已经登录
            } else {
                $to = trim($this->_getParam("to"));
                $userName = trim($this->_getParam("user_name"));
                $userPass = $this->_getParam("user_pass");
                if (empty($userName) || empty($userPass)) {
                    Ccc_Helper_Com::alertMess("/admin/login", "用户名或密码不能为空，正在返回", 1);
                }
                $config = new Zend_Config_Ini(PATH_ROOT . DS . $this->_conf->path->params_conf, "admin");
                $passwdWhere = isset($config->general_passwd) ? $config->general_passwd : "";
                $userInfo = AdminModel::getInstance()->getUserInfoByWhere($userName, md5($userPass), $passwdWhere);
//				print_r($userInfo);
                if (!$userInfo) {
                    $redirect = 2; // 登录失败
                } else {
                    if ($userInfo['status'] == 2) {
                        $redirect = 4;  // 未激活
                    } else if ($userInfo['status'] == 3) {
                        $redirect = 5;  // 已冻结
                    } else if ($userInfo['status'] == 4) {
                        $redirect = 6;  // 已删除
                    } else {
                        // 判断IP
                        if ($userInfo['ip'] != "*") {
                            $nowIp = Ccc_Helper_Com::getIp();
                            if (!in_array($nowIp, explode(",", $userInfo['ip']))) {
                                $redirect = 7;  // IP拒绝
                            }
                        }
                        // 检查是否要做已登录不能再登录的设定
                        if (isset($config->check_login) && $config->check_login && $userInfo['login_status'] == 1) {
                            $redirect = 8;  // 已登录不能再登录
                        } else {
                            $redirect = 1;
                        }
                    }
                }
            }
        } else {
            $redirect = 3;
        }

        // 处理
        $to = isset($to) && !empty($to) ? base64_decode($to) : "/admin/login";

        if ($redirect == 1) {
            $this->_session->uid = $userInfo['user_id'];
            $this->_session->uname = $userInfo['user_name'];
            $this->_session->unickname = $userInfo['real_name'];
            // 获取是否是系统管理员还是普通管理员 true | false
            $this->_session->urolecheck = AdminModel::getInstance()->checkRole($this->_session->uid);
            // 如果是系统管理员就不用再去取了。
            $this->_session->urole = !$this->_session->urolecheck ? AdminModel::getInstance()->getRole($this->_session->uid) : FALSE;
            $this->_session->uright = !$this->_session->urolecheck ? AdminModel::getInstance()->getRight($this->_session->uid) : FALSE;
            // 用户基本信息
            $this->_session->uinfo = $userInfo;
            // 更新登录状态以及登录时间
            AdminModel::getInstance()->updateUserLoginStatus($this->_session->uid, 1, time());
            // 跳转
            $config = new Zend_Config_Ini(PATH_ROOT . DS . $this->_conf->path->params_conf, "admin");
            $authToken = isset($config->auth_token) ? $config->auth_token : "";
            $authUrlArray = isset($config->auth_url) ? @explode("|", $config->auth_url) : array();
            echo AdminModel::getInstance()->auth("login", base64_encode(session_id()), $authToken, $authUrlArray);
            Ccc_Helper_Com::alertMess("/admin/home", "登录成功，正在跳转...", 1);
        } elseif ($redirect == 2) {
            Ccc_Helper_Com::alertMess("{$to}", "登录失败，正在返回...", 1);
        } elseif ($redirect == 3) {
            Ccc_Helper_Com::alertMess("/admin/home", "已登录，正在跳转...", 1);
        } elseif ($redirect == 4) {
            Ccc_Helper_Com::alertMess("{$to}", "帐号未激活，正在返回...", 1);
        } elseif ($redirect == 5) {
            Ccc_Helper_Com::alertMess("{$to}", "账号已冻结，正在返回...", 1);
        } elseif ($redirect == 6) {
            Ccc_Helper_Com::alertMess("{$to}", "帐号已删除，正在返回...", 1);
        } elseif ($redirect == 7) {
            Ccc_Helper_Com::alertMess("{$to}", "IP拒绝登录，正在返回...", 1);
        } elseif ($redirect == 8) {
            Ccc_Helper_Com::alertMess("{$to}", "已在异地登录，正在返回...", 1);
        }
    }

    /**
     * 注销
     */
    public function logoutAction() {
        if (isset($this->_session->uid) && !empty($this->_session->uid)) {
            // 更新状态
            AdminModel::getInstance()->updateUserLoginStatus($this->_session->uid, 0, 0, time());
            // 注销
            $this->_session->unsetAll("ccc");
            // 中转 注销
            $config = new Zend_Config_Ini(PATH_ROOT . DS . $this->_conf->path->params_conf, "admin");
            $authToken = isset($config->auth_token) ? $config->auth_token : "";
            $authUrlArray = isset($config->auth_url) ? @explode("|", $config->auth_url) : array();
            echo AdminModel::getInstance()->auth( "logout", base64_encode(session_id()), $authToken, $authUrlArray);
        }
        $this->_forward("login", "admin");
    }

    /**
     * 框架
     */
    public function homeAction() {
        if (!isset($this->_session->uid) || empty($this->_session->uid)) {
            $this->_forward("login", "admin");
        }
    }

    /**
     * 主页首页
     */
    public function homeIndexAction() {
        if (!isset($this->_session->uid) || empty($this->_session->uid)) {
            $this->_forward("login", "admin");
        }
        die(" Welcome to Admin's System！ ");
    }

    /**
     * ajax menu
     */
    public function ajaxGetMenuAction() {
        $this->_helper->layout->disableLayout();

        if (!isset($this->_session->uid) || empty($this->_session->uid)) {
            $result = array("error_code" => "-2", "msg" => "Session Lost", "data" => array());
            echo Ccc_Third_Json::getInstance()->encode($result);
            exit;
        }
//        echo "ddd";
        // 公用
        $defaultAppData = array();
        if ($this->_conf->menu->common_open) {
            $defaultAppData = array(
                array(
                    "app_id" => "0",
                    "app_name" => isset($this->_conf->menu->common_name) ? $this->_conf->menu->common_name : "",
                    "app_string" => "",
                )
            );
        }
        $appData = array();
        $resourceWhere = "";
        if ($this->_session->urolecheck) {
            //最高级管理员只能看到后台管理系统，其他均看不到
            $appData = ResourceModel::getInstance()->getAppAllData("  and status=1 ");
        } else {
            $appParams = array();
            $moduleParams = array();
            $resourceParams = array();
            $appWhere = "";
            // 普通管理员
            $rightResourceData = ResourceModel::getInstance()->getRightResourceDataByUserId($this->_session->uid);
            if (!empty($rightResourceData)) {
                foreach ($rightResourceData as $p) {
                    $appParams[$p['app_id']] = $p['app_id'];
                    $moduleParams[$p['module_id']] = $p['module_id'];
                    $resourceParams[$p['resource_id']] = $p['resource_id'];
                }
            }
            $resourceParams = @array_merge($resourceParams , $moduleParams );
            $appWhere = !empty($appParams) ? implode(",",$appParams) : "";
            $appWhere = !empty($appWhere) ? " and app_id in ({$appWhere}) " : " and 1>2 ";
            $resourceWhere = !empty($resourceParams) ? implode(",",$resourceParams) : "";
            $resourceWhere = !empty($resourceWhere) ? " and resource_id in ({$resourceWhere}) " : "";
            $appData = ResourceModel::getInstance()->getAppAllData($appWhere);
        }
        $result = array_merge($defaultAppData, $appData);
        if (!empty($result)) {
            foreach ($result as & $p) {
                $p['item'] = ResourceModel::getInstance()->getDataByAppId($p['app_id'], $resourceWhere);
            }
        }
        $this->view->data = $result;
    }

    /**
     * ajax header
     */
    public function ajaxGetHeaderAction() {
        $this->_helper->layout->disableLayout();
        if (!isset($this->_session->uid) || empty($this->_session->uid)) {
            $result = array("error_code" => "-2", "msg" => "Session Lost", "data" => array());
            echo Ccc_Third_Json::getInstance()->encode($result);
            exit;
        }
        @include PATH_DATA . "/data_header.php";
        $headerTools = isset($HEADERTOOLS[$GLOBALS['db_flag']])?explode("|",$HEADERTOOLS[$GLOBALS['db_flag']]) : NULL;
        $array = array();
        if($headerTools) {
            foreach($headerTools as $p) {
                $headerToolsStr = @explode("=" , $p);
                if($headerToolsStr) {
                    $array[] = array("title"=>$headerToolsStr[0],"url"=>$headerToolsStr[1]);
                }
            }
        }
        $this->view->array = $array;
    }

    /**
     * 超时
     */
    public function timeoutAction() {
        $this->_forward("login", "admin");
    }

    /**
     * 获取天气数据
     * // @todo 可以用独立脚本放在服务器上跑。然后这块直接调用配置文件来读取数据。
     */
    public function ajaxGetWeatherDataAction() {
        $this->_helper->layout->disableLayout();
        if (!isset($this->_session->uid) || empty($this->_session->uid)) {
            $result = array("error_code" => "-2", "msg" => "Session Lost", "data" => array());
            echo Ccc_Third_Json::getInstance()->encode($result);
            exit;
        }
        $config = new Zend_Config_Ini(PATH_ROOT . DS . $this->_conf->path->params_conf, "admin");
        $pathWeather = isset($config->path_weather) ? $config->path_weather : "";
        Ccc_Helper_Com::createFile(PATH_ROOT . $pathWeather);
        require_once PATH_ROOT . $pathWeather;
        $weather = "WEATHERS";
        echo!empty($$weather) ? $$weather : "";
        exit;
    }

    /**
     * 提供远程登录/登出
     */
    public function dealLoginaAction() {
        $isCheck = false;
        $action = trim($this->_getParam("act"));

        $config = new Zend_Config_Ini(PATH_ROOT . DS . $this->_conf->path->params_conf, "admin");
        if ($action == "login") {
            // 如果之前已经有登录过，需要先注销掉
            unset($this->_session->uid, $this->_session->uname, $this->_session->unickname);
            unset($this->_session->urolecheck, $this->_session->urole);
            if (!isset($this->_session->uid) || empty($this->_session->uid)) {
                $userName = trim($this->_getParam("user_name"));
                $userPass = $this->_getParam("user_pass");
                $passwdWhere = isset($config->general_passwd) ? $config->general_passwd : "";
                $userInfo = AdminModel::getInstance()->getUserInfoByWhere($userName, $userPass, $passwdWhere);
                if (!empty($userInfo) && $userInfo['status'] != 2 && $userInfo['status'] != 3 && $userInfo['status'] != 4) {
                    if ($userInfo['ip'] != "*") {
                        $nowIp = Ccc_Helper_Com::getIp();
                        if (in_array($nowIp, explode(",", $userInfo['ip']))) {
                            $isCheck = true;
                        }
                    } else {
                        $isCheck = true;
                    }
                }
            }

            if ($isCheck) {
                $this->_session->uid = $userInfo['user_id'];
                $this->_session->uname = $userInfo['user_name'];
                $this->_session->unickname = $userInfo['real_name'];
                // 获取是否是系统管理员还是普通管理员 true | false
                $this->_session->urolecheck = AdminModel::getInstance()->checkRole($this->_session->uid);
                // 如果是系统管理员就不用再去取了。
                $this->_session->urole = !$this->_session->urolecheck ? AdminModel::getInstance()->getRole($this->_session->uid) : FALSE;
            }
            // 更新登录状态以及登录时间
            AdminModel::getInstance()->updateUserLoginStatus((int) $this->_session->uid, 1, time());
        } else if ($action == "logout") {
            // 更新状态
            AdminModel::getInstance()->updateUserLoginStatus((int) $this->_session->uid, 0, 0, time());
            // 注销
            $this->_session->unsetAll("ccc");
        }
		exit;
    }

    /**
     * 查看成员简介
     */
    public function listAllUserAction() {
        exit("查看成员简介");
    }

    /**
     * 编辑用户信息
     */
    public function editUserInfoAction() {
        exit("修改用户信息");
    }

    /**
     * 编辑用户密码
     */
    public function editUserPassAction() {
        exit("修改用户密码");
    }

}