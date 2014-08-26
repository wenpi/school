<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 短信管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/07/05
 */
class SmsController extends Ccc_Base_Controller {

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

    public function listAction() {
        $this->view->title = "短信列表";
        $keywords = trim($this->_getParam("keywords"));
        
        
        $page = (int) $this->_getParam("page");
        $pageSize = isset($this->_conf->page_size) ? $this->_conf->page_size : 20;
//        $pageSize = 1;
        $where = "";
        $condition = "";
        
        if(!empty($keywords)) { 
            $where .= " and title like '%{$keywords}%' ";
            $condition .= "/keywords/{$keywords}";
        }
        
        $dataCount = SmsModel::getInstance()->getDataCount($where);
        $pageCount = ceil($dataCount / $pageSize);
        $page = ($page >= $pageCount) ? $pageCount : ($page = ($page < 1) ? 1 : $page);
        $page = $page < 1 ? 1 : $page;

        $this->view->data = SmsModel::getInstance()->getPageData($page, $pageSize, $where);
        // view page
        $this->view->pageData = array("page" => $page, "url" => "/sms/list{$condition}",
            "page_count" => $pageCount);
        $this->view->keywords = $keywords;
        $this->view->from = base64_encode(urlencode("/page/{$page}" . $condition));
    }
    
    public function viewAction() {
        $this->view->title  = "查看短信信息";
        $messageSendId = (int) $this->_getParam("message_send_id");
        $this->view->smsRowData = SmsModel::getInstance()->getRowData($messageSendId);
        $this->view->from = trim($this->_getParam("from"));
    }

    public function sendAction() {
        $this->view->title = "发送短信";
        $this->view->classData = ClassModel::getInstance()->getClassData(" and status in (1,4) ");
    }

    public function sendOkAction() {
        $this->_helper->layout->disableLayout();
        $type = (int) $this->_getParam("type");
        $hiddenUserId = $this->_getParam("hidden_user_id");
        $hiddenUserNo = $this->_getParam("hidden_user_no");
        $hiddenUserName = $this->_getParam("hidden_user_name");
        $hiddenUserPhone = $this->_getParam("hidden_user_phone");
        $sendType = (int)$this->_getParam("send_time_type");
        $sendTime = trim($this->_getParam("send_time"));
        $title = trim($this->_getParam("title"));
        $content = trim(htmlspecialchars($this->_getParam("content")));
        
        if(!$hiddenUserId) {
            Ccc_Helper_Com::alertMess("/sms/send","接收人不能为空");
        }
        $hiddenUserIdResult = implode(",",$hiddenUserId);
        $hiddenUserNoResult = implode(",",$hiddenUserNo);
        $hiddenUserNameResult = implode(",",$hiddenUserName);
        $hiddenUserPhoneResult = implode(",",$hiddenUserPhone);
        
        
        $params = array(
            "type" => $type,
            "title" => $title,
            "content" => $content,
            "receive_user_ids" => $hiddenUserIdResult,
            "receive_user_nos" => $hiddenUserNoResult,
            "receive_user_names" => $hiddenUserNameResult,
            "receive_mobile_phones" => $hiddenUserPhoneResult,
            "send_user_id" => $this->_session->uid,
            "send_user_name" => $this->_session->uname,
            "send_time_type" => $sendType,
            "send_time_int" => $sendType==1?strtotime($sendTime):0,
            "send_result" => 1
        );
        
        $add = SmsModel::getInstance()->addData($params);
        if($add>0) {
            Ccc_Helper_Com::alertMess("/sms/list", "发送成功");
        } else {
            Ccc_Helper_Com::alertMess("/sms/send", "发送失败");
        }
        
    }

    public function ajaxShowUserDataAction() {
        $this->_helper->layout->disableLayout();
        $this->view->title = "选择接收人";
        $type = (int) $this->_getParam("type");
        $classId = (int) $this->_getParam("val");
        $where = $classId > 0 ? " and sch_class_id={$classId} " : "";
        $this->view->userData = SmsModel::getInstance()->getUserDataByWhere($type, $where);
    }

    public function ajaxAddUserDataAction() {
        $this->_helper->layout->disableLayout();
        $userIds = trim($this->_getParam("user_ids"));
        $userIdResult = @explode("|", $userIds);
        array_shift($userIdResult);

        $userNos = trim($this->_getParam("user_nos"));
        $userNoResult = @explode("|", $userNos);
        array_shift($userNoResult);

        $userNames = trim($this->_getParam("user_names"));
        $userNameResult = @explode("|", $userNames);
        array_shift($userNameResult);

        $userPhones = trim($this->_getParam("user_phones"));
        $userPhoneResult = @explode("|", $userPhones);
        array_shift($userPhoneResult);


        $this->view->divUserIdResult = $userIdResult;
        $this->view->divUserNoResult = $userNoResult;
        $this->view->divUserNameResult = $userNameResult;
        $this->view->divUserPhoneResult = $userPhoneResult;
    }

}