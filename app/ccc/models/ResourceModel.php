<?php

defined('PATH_ROOT') or die('Access Denied.');

/**
 * 资源模块
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/08/05
 */
class ResourceModel {

    /**
     * 单例
     * @var type
     */
    private static $_singletonObject = null;
    private $_resource;

    private function __construct() {
        $this->_resource = new Data_Resource();
    }

    /**
     * 实例化
     * @return ResourceModel
     */
    public static function getInstance() {
        $className = __CLASS__;

        if (!isset(self::$_singletonObject [$className]) || !self::$_singletonObject [$className]) {
            self::$_singletonObject [$className] = new self ();
        }

        return self::$_singletonObject [$className];
    }

    /**
     * 获取所有应用数据
     */
    public function getAppAllData($where = "") {
        return $this->_resource->getAppAllData($where);
    }

    /**
     * 添加应用
     * @param type $params
     */
    public function addAppData(array $params) {
        return $this->_resource->addAppData($params);
    }

    /**
     * 更新应用状态
     * @param type $appId
     * @param type $status
     */
    public function updateAppStatus($appId, $status) {
        return $this->_resource->updateAppStatus($appId, $status);
    }

    /**
     * 查看某条应用信息
     * @param type $appId
     */
    public function getAppInfoData($appId) {
        return $this->_resource->getAppInfoData($appId);
    }

    /**
     * 删除应用
     * @param type $appId
     */
    public function deleteAppData($appId) {
        return $this->_resource->deleteAppData($appId);
    }

    /**
     * get all module and action data.
     * @param type $page
     * @param type $pageSize
     * @param type $where
     * @return type
     */
    public function getModuleActionPageData($page, $pageSize, $where) {
        $data = $this->_resource->getModuleActionPageData($page, $pageSize, $where);
        if( $data ) {
            foreach( $data as $k=>$v ) {
                $arr[$v['module_id']][] = $data[$k];
            }
        }
        return !$data ? array() : $arr;
    }
    
    public function getModuleDataByParams( $params ) {
        $where = "";
        if( $params ) {
            $or = "";
            foreach( $params as $p ) {
                $where .= " {$or} resource_id={$p} ";
                $or = "OR";
            }
        }
        $where = !empty($where) ? " and ($where) " : " and resource_id<1 ";
        return $this->_resource->getModuleDataByWhere( $where );
    }

    /**
     * get module and action count .
     * @param type $where
     */
    public function getModuleActionDataCount($where) {
        return $this->_resource->getModuleActionDataCount($where);
    }

    /**
     * 系统管理员下某应用的所有module和action
     * @param type $appId
     * @return type
     */
    public function getDataByAppId($appId, $where = "") {
        return $this->_resource->getDataByAppId($appId, $where);
    }

    /**
     * 获取模块数据
     * @param type $where
     * @return type
     */
    public function getModuleData($where = "") {
        return $this->_resource->getModuleData($where);
    }

    public function isModuleData($appId, $moduleString) {
        return $this->_resource->isModuleData($appId, $moduleString);
    }

    /**
     * 添加模块
     */
    public function addModuleData($params) {
        return $this->_resource->addModuleData($params);
    }

    /**
     * 获取某条资源信息
     * @param type $resourceId
     * @return type
     */
    public function getResourceInfoById($resourceId) {
        return $this->_resource->getResourceInfoById($resourceId);
    }

    /**
     * 判断动作
     * @param type $appId
     * @param type $moduleId
     * @param type $actionString
     * @return type
     */
    public function isActionData($appId, $moduleId, $actionString) {
        return $this->_resource->isActionData($appId, $moduleId, $actionString);
    }

    /**
     * 添加动作
     * @param type $params
     * @return type
     */
    public function addActionData($params) {
        return $this->_resource->addActionData($params);
    }

    /**
     * 获取模块/动作排序
     * @param type $appId
     * @param type $moduleId
     */
    public function getActionSortWhereData($appId, $moduleId) {
        return $this->_resource->getActionSortWhereData($appId, $moduleId);
    }

    public function sortModuleData($moduleId, $moduleSort) {
        return $this->_resource->sortModuleData($moduleId, $moduleSort);
    }

    public function sortActionData($actionId, $actionSort) {
        return $this->_resource->sortActionData($actionId, $actionSort);
    }

    /**
     * get module data by app_id.
     * @param type $appId
     */
    public function getModuleDataByAppId($appId) {
        return $this->_resource->getModuleDataByAppId($appId);
    }

    /**
     * get app module action data by where.
     * @param type $where
     * @return type
     */
    public function appModuleActionData($where) {
        return $this->_resource->appModuleActionData($where);
    }

    public function getAppDataByUserRole($userRole) {
        return $this->_resource->getAppDataByUserRole($userRole);
    }

    public function getResourceDataByUserRole($userRole) {
        return $this->_resource->getResourceDataByUserRole($userRole);
    }

    /**
     * 更新模块
     * @param type $resourceId
     * @param type $params
     */
    public function updateModuleData($resourceId, $params) {
        return $this->_resource->updateModuleData($resourceId, $params);
    }

    /**
     * 获取下一个sort
     * @param type $appId
     * @param type $moduleId
     * @param type $sort
     * @return type
     */
    public function getNextSortData($appId, $moduleId, $sort) {
        return $this->_resource->getNextSortData($appId, $moduleId, $sort);
    }

    /**
     * 获取下一个模块ID
     * @param type $appId
     * @param type $moduleId
     * @param type $sort
     * @return type
     */
    public function getNextModuleId($appId, $moduleId, $sort) {
        return $this->_resource->getNextModuleId($appId, $moduleId, $sort);
    }

    /**
     * 更新下一个模块排序
     * @param type $appId
     * @param type $moduleId
     * @param type $params
     * @return type
     */
    public function updateNextModuleSortData($appId, $moduleId, $params) {
        return $this->_resource->updateNextModuleSortData($appId, $moduleId, $params);
    }

    /**
     * 更新动作
     * @param type $resourceId
     * @param type $params
     */
    public function updateActionData($resourceId, $params) {
        return $this->_resource->updateActionData($resourceId, $params);
    }

    /**
     * 删除模块/动作
     * @param type $resourceId
     */
    public function deleteActionData($resourceId) {
        return $this->_resource->deleteActionData($resourceId);
    }

    /**
     * 判断某应用是否存在
     * @param type $appId
     */
    public function isAppData($appString) {
        return $this->_resource->isAppData($appString);
    }

    /**
     * 修改应用数据
     * @param type $appId
     * @param type $params
     * @return type
     */
    public function updateAppData($appId, $params) {
        return $this->_resource->updateAppData($appId, $params);
    }

    public function getRightResourceDataByUserId($userId) {
        return $this->_resource->getRightResourceDataByUserId($userId);
    }

}