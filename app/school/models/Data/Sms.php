<?php

/**
 * 接口数据处理
 * @author taozywu
 * @date 2014/08/08
 */
class Data_Sms extends Ccc_Base_Model {

    public function init() {
        parent::init();
    }

    public function addData($params) {
        $this->_db->insert("sch_message_send", $params);
        $add = $this->_db->lastInsertId();

        return $add;
    }

    public function getDataCount($where) {
        $sql = "select count(*) from sch_message_send where message_send_id >0 {$where} and is_delete=0";
        $count = $this->_db->fetchOne($sql);

        return $count;
    }

    public function getPageData($page, $pageSize, $where) {
        $startIndex = (int) ($page - 1) * $pageSize;
        $sql = "select * from sch_message_send where message_send_id >0 {$where} and is_delete=0 "
            . "order by message_send_id desc limit {$startIndex},{$pageSize}";
        $data = $this->_db->fetchAll($sql);

        return !empty($data) ? $data : array();
    }

    public function getRowData($messageSendId) {
        $sql = "select * from sch_message_send where message_send_id={$messageSendId} and is_delete=0";
        $messageRowData = $this->_db->fetchRow($sql);

        return !empty($messageRowData) ? $messageRowData : array();
    }

}