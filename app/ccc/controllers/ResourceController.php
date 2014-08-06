<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * ResourceController
 * @author  taozywu<wutao@bwstor.com.cn>
 * @date 2013/07/03
 */
class ResourceController extends Ccc_Base_Controller {

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

    /**
     * 首页
     */
    public function indexAction() {
        die;
    }

    /**
     * 应用列表
     */
    public function listAppAction() {
        $this->view->title = "应用资源管理";
        $appName = trim(addslashes($this->_getParam("app_name")));
        $where = "";
        $where .=!empty($appName) ? " and app_name like '{$appName}%'" : "";
        $this->view->appName = $appName;
        $this->view->data = ResourceModel::getInstance()->getAppAllData($where);
    }

    /**
     * get action data list .
     */
    public function listActionAction() {
        // get the parameter.
        $appId = (int) $this->_getParam("app_id");
        $moduleId = (int) $this->_getParam("module_id");
        $keyword = trim(addslashes($this->_getParam("keyword")));
        // deal with the page.
        $page = (int) $this->_getParam("page");
        $page = $page < 1 ? 1 : $page;
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
        // where
        $where = " ";
        $condition = "";
        $where .= $appId > 0 ? " and app_id={$appId} " : "";
        $condition .= $appId > 0 ? "/app_id/{$appId}" : "";
        $where .= $moduleId > 0 ? " and module_id={$moduleId} " : " and module_id<>0 ";
        $condition .= $moduleId > 0 ? "/module_id/{$moduleId}" : "";
        $where .=!empty($keyword) ? " and name like '{$keyword}%' " : "";
        $condition .=!empty($keyword) ? "/keyword/{$keyword}" : "";
        
        
        // compare the page data.
        $dataCount = ResourceModel::getInstance()->getModuleActionDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;
        // data.
        $actionData = ResourceModel::getInstance()->getModuleActionPageData($page, $pageSize, $where);
        $data = ResourceModel::getInstance()->getModuleDataByParams( array_keys($actionData) );
        if($data) {
            foreach($data as & $p) {
                $p['item'] = isset($actionData[$p['resource_id']]) ? $actionData[$p['resource_id']] : NULL;
            }
        }
        $this->view->data = $data;
        // view page
        $this->view->pageData = array("page" => $page, "url" => "/resource/list.action{$condition}",
            "page_count" => $pageCount);
        $this->view->appId = $appId;
        $this->view->moduleId = $moduleId;
        $this->view->keyword = $keyword;
        $this->view->title = "模块动作资源管理";
        $this->view->from = base64_encode("/page/{$page}" . $condition);
        $this->view->appData = ResourceModel::getInstance()->getAppAllData(" and status=1 ");
    }

    /**
     * 查看动作
     */
    public function viewActionAction() {
        $resourceId = (int) $this->_getParam("resource_id");
        $from = trim($this->_getParam("from"));
        $actionData = ResourceModel::getInstance()->getResourceInfoById($resourceId);
        $tmpAppData = ResourceModel::getInstance()->getAppInfoData($actionData['app_id']);
        $actionData['app_name'] = !empty($tmpAppData) ? $tmpAppData['app_name'] : "";
        if ($actionData['module_id'] == 0) {
            $actionData['module_name'] = $actionData['name'];
            $actionData['action_name'] = "";
        } else {
            $tmpModuleData = ResourceModel::getInstance()->getResourceInfoById($actionData['module_id']);
            $actionData['module_name'] = !empty($tmpModuleData) ? $tmpModuleData['name'] : "";
            $actionData['action_name'] = $actionData['name'];
        }
        $this->view->from = base64_decode($from);
        $this->view->actionData = $actionData;
    }

    /**
     * ajax get module data.
     */
    public function ajaxShowModuleDataAction() {
        $this->_helper->layout->disableLayout();
        $appId = (int) $this->_getParam("app_id");
        $moduleId = (int) $this->_getParam("module_id");
        $this->view->moduleData = ResourceModel::getInstance()->getModuleData(" and app_id={$appId} ");
        $this->view->moduleId = $moduleId;
    }

    /**
     * 添加应用
     */
    public function addAppAction() {
        $this->view->title = "添加应用资源信息";
        // 获取排序
        $this->view->appSort = ResourceModel::getInstance()->getAppAllData(" and status=1 ");
    }

    /**
     * 添加应用 OK
     */
    public function addAppOkAction() {
        $appName = trim(addslashes($this->_getParam("app_name")));
        $appString = trim(addslashes($this->_getParam("app_string")));
        $sort = (int) $this->_getParam("sort");
        $comments = trim(htmlspecialchars($this->_getParam("comments")));
        $params = array(
            "app_name" => $appName,
            "app_string" => $appString,
            "sort" => $sort == 0 ? 20 : $sort + 1,
            "comments" => $comments
                );
        $add = ResourceModel::getInstance()->addAppData($params);
        if ($add > 0) {
            Ccc_Helper_Com::alertMess("/resource/list.app", "添加成功，正在跳转...", 1);
        } else {
            Ccc_Helper_Com::alertMess("/resource/add.app", "添加失败，正在返回...", 1);
        }
    }

    /**
     * 更新应用状态
     */
    public function ajaxUpdateAppStatusAction() {
        $appId = (int) $this->_getParam("app_id");
        $status = (int) $this->_getParam("status");
        $update = ResourceModel::getInstance()->updateAppStatus($appId, $status);
        echo $update;
        exit;
    }

    /**
     * 查看应用
     */
    public function viewAppAction() {
        $this->view->title = "查看应用资源信息";
        $appId = (int) $this->_getParam("app_id");
        $this->view->appData = ResourceModel::getInstance()->getAppInfoData($appId);
    }

    /**
     * 修改应用
     */
    public function editAppAction() {
        
        $appId = (int) $this->_getParam("app_id");
        $this->view->appData = ResourceModel::getInstance()->getAppInfoData($appId);
        $this->view->appSort = ResourceModel::getInstance()->getAppAllData(" and app_id<>{$appId} and status=1 ");
        $this->view->title = "编辑应用资源信息";
    }

    /**
     * 修改应用OK
     */
    public function editAppOkAction() {
        $hiddenAppId = (int) $this->_getParam("hidden_app_id");
        $hiddenAppString = trim($this->_getParam("hidden_app_string"));
        $appName = trim($this->_getParam("app_name"));
        $appString = trim($this->_getParam("app_string"));
        $sort = (int) $this->_getParam("sort");
        $comments = trim(htmlspecialchars($this->_getParam("comments")));
        // 应用字符串
        if (empty($appString)) {
            Ccc_Helper_Com::alertMess("/resource/edit.app/app_id/" . $hiddenAppId, "应用字符串不能为空，正在返回...", 1);
        }
        if ($hiddenAppString != $appString) {
            $isHas = ResourceModel::getInstance()->isAppData($appString);
            if ($isHas > 0) {
                Ccc_Helper_Com::alertMess(
                        "/resource/edit.app/app_id/" . $hiddenAppId, "已存在该应用字符串，正在返回...", 1);
            }
        }

        $params = array(
            "app_name" => $appName,
            "app_string" => $appString,
            "comments" => $comments,
            "sort" => $sort + 1,
            "status" => 2
                );

        $update = ResourceModel::getInstance()->updateAppData($hiddenAppId, $params);
        if ($update > 0) {
            Ccc_Helper_Com::alertMess(
                    "/resource/list.app", "修改成功，正在跳转...", 1, "meta");
        }
    }

    /**
     * 删除应用
     */
    public function deleteAppAction() {
        $appId = (int) $this->_getParam("app_id");
        $delete = ResourceModel::getInstance()->deleteAppData($appId);
        if ($delete > 0) {
            Ccc_Helper_Com::alertMess("/resource/list.app", "删除成功，正在跳转...", 1);
        }
    }

    /**
     * add module or action page.
     *
     */
    public function addActionAction() {
        $this->view->title = "添加模块动作资源信息";
        $this->view->appData = ResourceModel::getInstance()->getAppAllData(" and status=1 ");
        $this->view->moduleData = ResourceModel::getInstance()->getModuleData(" and app_id=0 ");
    }

    /**
     * add module or action data.
     */
    public function addActionOkAction() {
        $appId = (int) $this->_getParam("app_id");
        $moduleId = (int) $this->_getParam("module_id");
        $actionString = trim(addslashes($this->_getParam("action_string")));
        $actionName = trim(addslashes($this->_getParam("action_name")));
        $url = trim(addslashes($this->_getParam("url")));
        $isView = trim($this->_getParam("is_view"));
        $isUpdate = trim($this->_getParam("is_update"));
        $isLog = trim($this->_getParam("is_log"));
        $isRemove = trim($this->_getParam("is_remove"));
        $sort = (int) $this->_getParam("sort");
        $isRightData = trim($this->_getParam("is_right_data"));
        $rightClassName = trim(addslashes($this->_getParam("right_class_name")));
        $rightActionName = trim(addslashes($this->_getParam("right_action_name")));
        $comment = trim(htmlspecialchars($this->_getParam("comment")));
        // deal with parameter
        $isView = $isView == "on" ? 1 : 0;
        $isUpdate = $isUpdate == "on" ? 1 : 0;
        $isLog = $isLog == "on" ? 1 : 0;
        $isRemove = $isRemove == "on" ? 1 : 0;
        $sort = $sort == 0 ? 20 : $sort;
        $isRightData = $isRightData == "on" ? 1 : 0;

        $isHas = 0;
        $add = 0;
        $appInfo = ResourceModel::getInstance()->getAppInfoData($appId);
        if ($moduleId == 0) {
            // 判断模块是否存在
            $isHas = ResourceModel::getInstance()->isModuleData($appId, $actionString);
            if ($isHas > 0) {
                Ccc_Helper_Com::alertMess("/resource/list.action/app_id/{$appId}", "该模块已存在，正在返回...", 1);
            }
            $params = array(
                "user_id" => $this->_session->uid,
                "user_name" => $this->_session->uname,
                "app_id" => $appId,
                "app_string" => !empty($appInfo['app_string']) ? $appInfo['app_string'] : "",
                "module_id" => 0,
                "module_string" => $actionString,
                "module_sort" => $isView == 1 ? ($sort + 1) : $sort,
                "action_string" => "",
                "name" => $actionName,
                "url" => $url,
                "is_right_data" => $isRightData,
                "right_class_name" => $rightClassName,
                "right_action_name" => $rightActionName,
                "is_view" => $isView,
                "is_update" => $isUpdate,
                "is_log" => $isLog,
                "is_remove" => $isRemove,
                "add_time" => time(),
                "comment" => $comment,
                    );
            $add = ResourceModel::getInstance()->addModuleData($params);
        } else {
            // 判断动作是否存在
            $isHas = ResourceModel::getInstance()->isActionData($appId, $moduleId, $actionString);
            if ($isHas) {
                Ccc_Helper_Com::alertMess(
                        "/resource/list.action/app_id/{$appId}", "该动作已存在，正在返回...", 1);
            }
            $moduleInfo = ResourceModel::getInstance()->getResourceInfoById($moduleId);
            $params = array(
                "user_id" => $this->_session->uid,
                "user_name" => $this->_session->uname,
                "app_id" => $appId,
                "app_string" => !empty($appInfo['app_string']) ? $appInfo['app_string'] : "",
                "module_id" => $moduleId,
                "module_string" => !empty($moduleInfo['module_string']) ? $moduleInfo['module_string'] : "",
                "module_sort" => !empty($moduleInfo['module_sort']) ? $moduleInfo['module_sort'] : "",
                "action_string" => $actionString,
                "name" => $actionName,
                "sort" => $isView == 1 ? ($sort + 1) : $sort,
                "url" => $url,
                "is_right_data" => $isRightData,
                "right_class_name" => $rightClassName,
                "right_action_name" => $rightActionName,
                "is_view" => $isView,
                "is_update" => $isUpdate,
                "is_log" => $isLog,
                "is_remove" => $isRemove,
                "add_time" => time(),
                "comment" => $comment,
                    );
            $add = ResourceModel::getInstance()->addActionData($params);
        }
        // 跳转
        if ($add > 0) {
            Ccc_Helper_Com::alertMess("/resource/list.action/app_id/{$appId}", "添加成功，正在跳转...", 1);
        } else {
            Ccc_Helper_Com::alertMess("/resource/add.action", "添加失败，正在返回...", 1);
        }
    }

    /**
     * 添加模块/动作  排序
     */
    public function ajaxShowActionSortAction() {
        $this->_helper->layout->disableLayout();
        $appId = (int) $this->_getParam("app_id");
        $moduleId = (int) $this->_getParam("module_id");
        $this->view->selectOne = (int) $this->_getParam("select_one");
        $this->view->actionSortData = ResourceModel::getInstance()->getActionSortWhereData($appId, $moduleId);
    }

    /**
     * 排序 模块/动作
     */
    public function ajaxSortActionDataAction() {
        $this->_helper->layout->disableLayout();
        $actionId = (int) $this->_getParam("action_id");
        $sort = (int) $this->_getParam("sort");
        $flag = trim($this->_getParam("flag"));
        $from = trim($this->_getParam("from"));
        if ($flag == "father") {// module sort
            $result = ResourceModel::getInstance()->sortModuleData($actionId, $sort);
        } else {// action sort
            $result = ResourceModel::getInstance()->sortActionData($actionId, $sort);
        }

        $result = array(
            "error_code" => 0,
            "msg" => "",
            "data" => array("result" => $result, "from" => base64_decode($from)));
        exit(Ccc_Third_Json::getInstance()->encode($result));
    }

    /**
     * 编辑模块/动作
     */
    public function editActionAction() {
        $resourceId = (int) $this->_getParam("resource_id");
        $from = trim($this->_getParam("from"));
        $this->view->from = base64_decode($from);
        $actionData = ResourceModel::getInstance()->getResourceInfoById($resourceId);
        $this->view->actionData = $actionData;
        $this->view->appData = ResourceModel::getInstance()->getAppAllData(" and status=1 ");
        $this->view->moduleData = ResourceModel::getInstance()->getModuleData(" and app_id=0 ");
    }

    /**
     * 编辑模块/动作 OK
     */
    public function editActionOkAction() {
        // hidden
        $hiddenResourceId = (int) $this->_getParam("hidden_resource_id");
        $hiddenAppId = (int) $this->_getParam("hidden_app_id");
        $hiddenModuleId = (int) $this->_getParam("hidden_module_id");
        $hiddenActionString = trim($this->_getParam("hidden_action_string"));
        $from = trim($this->_getParam("from"));
        // get the paramter.
        $appId = (int) $this->_getParam("app_id");
        $moduleId = (int) $this->_getParam("module_id");
        $actionString = trim($this->_getParam("action_string"));
        $actionName = trim($this->_getParam("action_name"));
        $url = trim($this->_getParam("url"));
        $isView = trim($this->_getParam("is_view"));
        $isUpdate = trim($this->_getParam("is_update"));
        $isLog = trim($this->_getParam("is_log"));
        $isRemove = trim($this->_getParam("is_remove"));
        $sort = (int) $this->_getParam("sort");
        $isRightData = trim($this->_getParam("is_right_data"));
        $rightClassName = trim(addslashes($this->_getParam("right_class_name")));
        $rightActionName = trim(addslashes($this->_getParam("right_action_name")));
        $comment = trim(htmlspecialchars($this->_getParam("comment")));
        // deal the paramter.
        $isView = $isView == "on" ? 1 : 0;
        $isUpdate = $isUpdate == "on" ? 1 : 0;
        $isLog = $isLog == "on" ? 1 : 0;
        $isRemove = $isRemove == "on" ? 1 : 0;
        $sort = $sort == 0 ? 20 : $sort;
        $isRightData = $isRightData == "on" ? 1 : 0;

        $isHas = 0;
        $isCheck = false;
        $isRefer = false;
        $update = 0;
        if ($appId != $hiddenAppId || $moduleId != $hiddenModuleId || $actionString != $hiddenActionString) {
            $isCheck = true;
        }
        $appInfo = ResourceModel::getInstance()->getAppInfoData($appId);
        if ($moduleId == 0) {
            // 判断模块是否存在
            if ($isCheck) {
                $isHas = ResourceModel::getInstance()->isModuleData($appId, $actionString);
                if ($isHas > 0) {
                    $isRefer = true;
                }
            }
        } else {
            // 判断动作是否存在
            if ($isCheck) {
                $isHas = ResourceModel::getInstance()->isActionData($appId, $moduleId, $actionString);
                if ($isHas) {
                    $isRefer = true;
                }
            }
        }

        if ($isRefer) {
            Ccc_Helper_Com::alertMess(
                    "/resource/edit.action/resource_id/{$hiddenResourceId}/from/{$from}", ($moduleId == 0 ? "该模块已存在," : "该动作已存在,") . "正在返回...", 1 );
        }

        if ($moduleId == 0) {
            $params = array(
                "app_id" => $appId,
                "app_string" => !empty($appInfo['app_string']) ? $appInfo['app_string'] : "",
                "module_id" => 0,
                "module_string" => $actionString,
                "action_string" => "",
                "name" => $actionName,
                "url" => $url,
                "is_right_data" => $isRightData,
                "right_class_name" => $isRightData == 1 ? $rightClassName : "",
                "right_action_name" => $isRightData == 1 ? $rightActionName : "",
                "is_view" => $isView,
                "is_update" => $isUpdate,
                "is_log" => $isLog,
                "is_remove" => $isRemove,
                "comment" => $comment,
                    );
            if ($isView == 1) {
                $params['module_sort'] = $sort + 1;
            }
            $update = ResourceModel::getInstance()->updateModuleData($hiddenResourceId, $params);
            if ($isView == 1) {
                // 判断当前sort和下一个sort
                $nextSort = ResourceModel::getInstance()->getNextSortData($appId, 0, $sort);
                $nextSort = (int) $nextSort;
                if ($nextSort <= ( $sort + 1 )) {
                    $nextModuleId = ResourceModel::getInstance()->getNextModuleId($appId, 0, $nextSort);
                    $nextSort++;
                    ResourceModel::getInstance()->updateNextModuleSortData(
                            $appId, $nextModuleId, array("module_sort" => $nextSort));
                }
            }
        } else {
            $moduleInfo = ResourceModel::getInstance()->getResourceInfoById($moduleId);
            $params = array(
                "app_id" => $appId,
                "app_string" => !empty($appInfo['app_string']) ? $appInfo['app_string'] : "",
                "module_id" => $moduleId,
                "module_string" => !empty($moduleInfo['module_string']) ? $moduleInfo['module_string'] : "",
                "module_sort" => !empty($moduleInfo['module_sort']) ? $moduleInfo['module_sort'] : "",
                "action_string" => $actionString,
                "name" => $actionName,
                "sort" => $isView == 1 ? ($sort + 1) : $sort,
                "url" => $url,
                "is_right_data" => $isRightData,
                "right_class_name" => $isRightData == 1 ? $rightClassName : "",
                "right_action_name" => $isRightData == 1 ? $rightActionName : "",
                "is_view" => $isView,
                "is_update" => $isUpdate,
                "is_log" => $isLog,
                "is_remove" => $isRemove,
                "comment" => $comment,
                    );
            $update = ResourceModel::getInstance()->updateActionData($hiddenResourceId, $params);
        }

        if ($update > 0) {
            Ccc_Helper_Com::alertMess("/resource/list.action" . base64_decode($from), "保存成功，正在跳转...", 1);
        }
    }

    /**
     * 删除模块/动作
     */
    public function deleteActionAction() {
        $resourceId = (int) $this->_getParam("resource_id");
        $from = trim($this->_getParam("from"));
        $delete = ResourceModel::getInstance()->deleteActionData($resourceId);
        if ($delete > 0) {
            Ccc_Helper_Com::alertMess("/resource/list.action" . base64_decode($from), "操作成功，正在跳转...", 1);
        }
    }

}