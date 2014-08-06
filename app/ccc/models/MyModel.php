<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 个人模块
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/07/24
 */
class MyModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_user;

    private function __construct() {
        $this->_user = new Data_User();
    }

    /**
     * 实例化
     * @return MyModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    public function getMyInfo($uid) {

        return $this->_user->getUserInfo($uid);
    }
    
    public function checkUserInfo($userName,$userPass) {
        return $this->_user->checkUserInfo($userName,md5( $userPass ) );
    }

    public function updatePass( $userId , $newPass) {
        $params = array(
            "user_pass" => md5($newPass),
        );
        
        return $this->_user->updateData($userId, $params);
    }
             
}