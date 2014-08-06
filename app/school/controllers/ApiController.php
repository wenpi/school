<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 合同脚本管理
 * @author taozywu <taozywu@gmail.com>
 * @date 2014/3/14
 */
class ApiController extends Ccc_Base_Controller {

    /**
     * 初始化
     * @see Ccc_Base_Controller::init()
     */
    function init() {
        parent::init();
        $this->_helper->layout->disableLayout();
    }

    /**
     * 默认action
     */
    public function indexAction() {
        exit;
    }

    // 同步学校数据库
    public function addSchoolAction() {

        $params = trim($this->_getParam("params"));
        $params = base64_decode( $params );
        try {
            list($schoolId, $foundDate, $foundUserId ) = @explode( "_" , $params );
        } catch (Exception $exc) {
            $schoolId = 0 ;
            $foundDate = "";
            $foundUserId = 0;
        }
        $addParams = array(
            "school_id" => $schoolId,
            "found_date" => $foundDate,
            "found_user_id" => $foundUserId,
        );
        $add = ApiModel::getInstance()->addSchoolData( $addParams );
        echo $add ;
        exit;
    }

}