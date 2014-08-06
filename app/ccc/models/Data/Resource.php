<?php

/**
 * 资源数据
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/08/05
 */
class Data_Resource extends Ccc_Base_Model {

    private $_tableName1 = "admin_apps";
    private $_tableName2 = "admin_resources";

    public function init() {
        parent::init();
    }

    /**
     * 获取所有应用数据
     * @param type $where
     * @return type
     */
    public function getAppAllData($where) {
        $sql = "select * from {$this->_tableName1} "
                . "where app_id>0 {$where} and is_delete=0 order by `sort` asc ";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * 添加应用
     * @param type $params
     */
    public function addAppData($params) {
        $this->_db->insert($this->_tableName1, $params);
        return 1;
    }

    /**
     * 更新应用状态
     * @param type $appId
     * @param type $status
     */
    public function updateAppStatus($appId, $status) {
        $this->_db->update($this->_tableName1, array("status" => $status), "app_id=" . $appId);

        return 1;
    }

    /**
     * 某条应用信息
     * @param type $appId
     */
    public function getAppInfoData($appId) {
        $sql = "select * from {$this->_tableName1} where app_id={$appId}";
        $data = $this->_db->fetchRow($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * 删除应用
     * @param type $appId
     */
    public function deleteAppData($appId) {
        $this->_db->update($this->_tableName1, array("is_delete" => 1), "app_id=" . $appId);

        return 1;
    }

    /**
     * 获取系统管理员下某应用的所有module和action
     */
    public function getDataByAppId($appId, $where) {
        $sql = "select *,0 as selected from {$this->_tableName2} where resource_id>0 "
                . "{$where} and app_id={$appId} and is_view=1 and is_delete=0 ORDER BY "
                . "module_sort,`sort` ASC ";
        $data = $this->_db->fetchAll($sql);
        $arr = array();
        if ($data) {
            foreach ($data as $k => $v) {
                $arr[$v['module_id']][] = $data[$k];
            }
        }
        unset($data);
        $array = isset($arr[0]) ? $arr[0] : array();
        if ($array) {
            foreach ($array as & $r) {
                $r['node'] = isset($arr[$r['resource_id']]) ? $arr[$r['resource_id']] : array();
            }
        }

        return $array;
    }

    /**
     * get module and action page data.
     * @param type $page
     * @param type $pageSize
     * @param type $where
     * @return type
     */
    public function getModuleActionPageData($page, $pageSize, $where) {
        $startIndex = ($page - 1) * $pageSize;
        $sql = "SELECT * FROM admin_resources WHERE resource_id >0 {$where} AND is_delete=0 "
                . "ORDER BY module_sort,sort,is_view ASC limit {$startIndex},{$pageSize}";
        $data = $this->_db->fetchAll($sql);
        return !$data ? array() : $data;
    }

    public function getModuleDataByWhere( $where ) {
        $sql = "select * from admin_resources where resource_id>0 {$where} and is_delete=0 "
                . "ORDER BY module_sort,sort,is_view ASC";
        return $this->_db->fetchAll( $sql );
    }
    /**
     * get module and action count.
     * @param type $where
     */
    public function getModuleActionDataCount($where) {
        $sql = "select count(*) from {$this->_tableName2} where resource_id>0 {$where} and is_delete=0";
        $count = (int) $this->_db->fetchOne($sql);

        return $count;
    }

    /**
     * 获取模块数据
     * @param type $where
     * @return type
     */
    public function getModuleData($where) {
        $sql = "SELECT `resource_id` as module_id,module_string,name FROM {$this->_tableName2} "
                . "WHERE `resource_id`>0 {$where} and module_id=0 ";
        $data = $this->_db->fetchAll($sql);

        return !$data ? array() : $data;
    }

    /**
     * 判断模块是否存在
     * @param type $appId
     * @param type $moduleString
     * @return int
     */
    public function isModuleData($appId, $moduleString) {
        $sql = "select count(*) from {$this->_tableName2} where resource_id>0 and app_id={$appId} "
                . "and module_string='{$moduleString}' and is_delete=2 ";
        $count = (int) $this->_db->fetchOne($sql);

        return $count;
    }

    /**
     * 添加模块数据
     */
    public function addModuleData($params) {
        $this->_db->insert($this->_tableName2, $params);

        return 1;
    }

    /**
     * 获取某条资源信息
     * @param type $resourceId
     * @return type
     */
    public function getResourceInfoById($resourceId) {
        $sql = "select *,0 as selected from {$this->_tableName2} where resource_id={$resourceId} and is_delete=0";
        $resourceInfo = $this->_db->fetchRow($sql);

        return !empty($resourceInfo) ? $resourceInfo : array();
    }

    /**
     * 判断动作是否存在
     * @param type $appId
     * @param type $moduleId
     * @param type $actionString
     * @return type
     */
    public function isActionData($appId, $moduleId, $actionString) {
        $sql = "select count(*) from {$this->_tableName2} where resource_id>0 and app_id={$appId} "
                . "and module_id={$moduleId} and action_string='{$actionString}' and is_delete=0";
        $count = (int) $this->_db->fetchOne($sql);

        return $count;
    }

    /**
     * 添加动作
     * @param type $params
     */
    public function addActionData($params) {
        $this->_db->insert($this->_tableName2, $params);

        return 1;
    }

    /**
     * 获取模块/动作排序
     * @param type $appId
     * @param type $moduleId
     * @return type
     */
    public function getActionSortWhereData($appId, $moduleId) {
        $where = $moduleId == 0 ? "module_sort" : "sort";
        $sql = "select {$where} as sort,name from {$this->_tableName2} where resource_id>0 "
                . "and app_id ={$appId} and module_id={$moduleId} and is_view=1 and is_delete=0 "
                . "order by {$where} asc";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * 更新模块排序
     * @param type $moduleId
     * @param type $moduleSort
     * @return int
     */
    public function sortModuleData($moduleId, $moduleSort) {
        // 先更新模块
        $this->_db->update($this->_tableName2, array("module_sort" => $moduleSort), "resource_id=" . $moduleId);
        // 在更新动作关联的模块排序
        $this->_db->update($this->_tableName2, array("module_sort" => $moduleSort), "module_id=" . $moduleId);
        return 1;
    }

    /**
     * 更新动作排序
     * @param type $actionId
     * @param type $actionSort
     * @return int
     */
    public function sortActionData($actionId, $actionSort) {
        $this->_db->update($this->_tableName2, array("sort" => $actionSort), "resource_id=" . $actionId);
        return 1;
    }

    /**
     * get module data by app_id .
     * @param type $appId
     */
    public function getModuleDataByAppId($appId) {
        $sql = "select * from admin_resources
            where resource_id>0 and app_id={$appId} and module_id=0 and is_delete=0 order by module_sort asc ";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * get app module action data by where
     * @param type $where
     */
    public function appModuleActionData($where) {
        $sql = "select *,0 as selected from admin_resources where resource_id>0 {$where} and is_delete=0 "
		. "ORDER BY app_id ASC,module_sort ASC,module_id ASC,is_view DESC,`sort` ASC ";
        $data = $this->_db->fetchAll($sql);
        $arr = array();
        $array = array();
        if ($data) {
            foreach ($data as $k => $v) {
                if ($v['module_id'] != 0) {
                    $array[$v['module_id']] = $this->getResourceInfoById($v['module_id']);
                    $arr[$v['module_id']][] = $data[$k];
                } else {
                    $array[$v['resource_id']] = $v;
                }
            }
        }

        if ($array) {
            foreach ($array as & $r) {
                $r['node'] = isset($arr[$r['resource_id']]) ? $arr[$r['resource_id']] : array();
            }
        }

        return $array;
    }

    /**
     * 通过角色来获取应用数据
     * @param type $userRole
     */
    public function getAppDataByUserRole($userRole) {
        $roleWhere = "";
        if ($userRole) {
            $or = "";
            foreach ($userRole as $r) {
                $roleWhere .= "{$or} role_id={$r['role_id']}";
                $or = " OR ";
            }
        }
        $where = !empty($roleWhere) ? " and (1>2 or {$roleWhere}) " : " and 1>2 ";
        $sql = "select * from admin_apps where app_id in (select distinct app_id from admin_role_right "
                . "where role_right_id>0 {$where})";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function getResourceDataByUserRole($userRole) {
        $roleWhere = "";
        if ($userRole) {
            $or = "";
            foreach ($userRole as $r) {
                $roleWhere .= "{$or} role_id={$r['role_id']}";
                $or = " OR ";
            }
        }
        $where = !empty($roleWhere) ? " and (1>2 or {$roleWhere}) " : " and 1>2 ";
        $sql = "select resource_id from admin_role_right where resource_id>0 {$where}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    /**
     * 更新模块
     * @param type $resourceId
     * @param type $params
     */
    public function updateModuleData($resourceId, $params) {
        $this->_db->update($this->_tableName2, $params, "resource_id=" . $resourceId);

        return 1;
    }

    public function getNextSortData($appId, $moduleId, $sort) {
        if ($moduleId == 0) {
            $sql = "select module_sort from {$this->_tableName2} where app_id={$appId} and module_id=0 "
                    . "and module_sort > {$sort} and is_delete=0 order by module_sort asc limit 1";
        } else {
            $sql = "select sort from {$this->_tableName2} where app_id={$appId} and module_id={$moduleId} "
                    . "and sort > {$sort} and is_delete=0 order by sort asc limit 1";
        }
        $sort = (int) $this->_db->fetchOne($sql);

        return $sort;
    }

    /**
     * 获取下一个模块ID
     * @param type $appId
     * @param type $moduleId
     * @param type $sort
     */
    public function getNextModuleId($appId, $moduleId, $sort) {
        $sql = "select resource_id from {$this->_tableName2} where app_id={$appId} "
                . "and module_id={$moduleId} and module_sort={$sort} and is_delete=0 "
                . "order by resource_id asc limit 1";
        $moduleId = $this->_db->fetchOne($sql);

        return $moduleId;
    }

    /**
     * 更新下一个模块的排序
     * @param type $appId
     * @param type $moduleId
     * @param type $params
     * @return int
     */
    public function updateNextModuleSortData($appId, $moduleId, $params) {
        $this->_db->update($this->_tableName2, $params, "resource_id=" . $moduleId);
        $this->_db->update($this->_tableName2, $params, "app_id={$appId} and module_id={$moduleId}");
        return 1;
    }

    /**
     * 更新动作
     * @param type $resourceId
     * @param type $params
     */
    public function updateActionData($resourceId, $params) {
        $this->_db->update($this->_tableName2, $params, "resource_id=" . $resourceId);

        return 1;
    }

    /**
     * 删除模块/动作
     * @param type $resourceId
     */
    public function deleteActionData($resourceId) {
        $this->_db->update($this->_tableName2, array("is_delete" => 1), "resource_id=" . $resourceId);

        return 1;
    }

    /**
     * 判断某应用是否存在
     * @param type $appString
     */
    public function isAppData($appString) {
        $sql = "select count(*) from {$this->_tableName1} where app_string='{$appString}' and is_delete=0";
        $count = (int) $this->_db->fetchOne($sql);

        return $count;
    }

    /**
     * 更新应用数据
     * @param type $appId
     * @param type $params
     * @return int
     */
    public function updateAppData($appId, $params) {
        $this->_db->update($this->_tableName1, $params, "app_id=" . $appId);

        return 1;
    }

    /**
     * 获取某用户的对应的所有资源权限数据
     * @param type $userId
     */
    public function getRightResourceDataByUserId($userId) {
        $sql = "SELECT * FROM admin_right_resource WHERE right_id IN "
                . "( SELECT right_id FROM admin_user_role_right WHERE user_id={$userId} )";
//                echo $sql;
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

}