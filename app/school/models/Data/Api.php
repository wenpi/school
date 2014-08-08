<?php

/**
 * 接口数据处理
 * @author taozywu
 * @date 2014/08/08
 */
class Data_Api extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function getUserData($where) {
        $sql = "select user_id,user_name,real_name,status from admin_users "
                . "where user_id >0 {$where} order by user_name asc";
//        echo $sql;
        $data = $this->_db->fetchAll($sql);

        return !$data ? array() : $data;
    }

}