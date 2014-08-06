<?php

/**
 * 过滤类
 * @author taozywu<wutao@bwstor.com.cn>
 * @date 2013/04/26
 */
class Ccc_Third_Filter {

    /**
     * 单例对象
     */
    private static $_singletonObject;

    /**
     * 实例化
     * @param string $nameSpace
     */
    private function __construct() {
        
    }

    /**
     * 单例
     * @return Filter
     */
    public static function getInstance() {
        $className = __CLASS__;
        if (!isset(self::$_singletonObject[$className]) || !self::$_singletonObject[$className]) {
            self::$_singletonObject[$className] = new self( );
        }

        return self::$_singletonObject[$className];
    }

    // 全局过滤
    public function iFilter() {
        if (is_array($_SERVER)) {
            foreach ($_SERVER as $k => $v) {
                if (isset($_SERVER[$k])) {
                    $_SERVER[$k] = str_replace(array('<', '>', '"', "'", '%3C', '%3E', '%22', '%27', '%3c', '%3e'), '', $v);
                }
            }
        }

        unset($_ENV, $HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS, $HTTP_ENV_VARS);

        $_GET = self::_filterSlashes($_GET);
        $_POST = self::_filterSlashes($_POST);
        $_COOKIE = self::_filterSlashes($_COOKIE);
        $_REQUEST = self::_filterSlashes($_REQUEST);
    }

    /**
     * 过滤SQL['、"、\、NULL]
     * @param type $value
     * @return boolean
     */
    private static function _filterSlashes($value) {
        if (get_magic_quotes_gpc())
            return " U maybe turn on magic quotes gpc , please turn off.";

        if (empty($value)) {
            return $value;
        } else {
            return is_array($value) ? array_map(array('Filter', '_filterSlashes'), $value) : addslashes($value);
        }
    }

    /**
     * 对URL进行encode和decode
     * @param type $value
     * @param type $urlMode   DECODE|ENCODE
     * @return type
     */
    public function filterUrl($value, $urlMode = 'DECODE') {
        if (empty($value)) {
            return $value;
        } else {
            return is_array($value) ? array_map(array('Ccc_Third_Filter', 'filterUrl'), $value) : ($urlMode == "DECODE" ? urldecode($value) : urlencode($value) );
        }
    }

    /**
     * 过滤对象
     * @param type $obj
     * @return type
     */
    function filterObj($obj) {
        if (is_object($obj) == true) {
            foreach ($obj AS $key => $val) {
                $obj->$key = self::_filterSlashes($val);
            }
        } else {
            $obj = self::_filterSlashes($obj);
        }

        return $obj;
    }

    /**
     * 过滤HTML[&、"、'、<、>]
     * @param type $value
     * @return type
     */
    public function filterHtml($value) {
        if (function_exists('htmlspecialchars'))
            return htmlspecialchars($value);
        return str_replace(array("&", '"', "'", "<", ">"), array("&amp;", "&quot;", "&#039;", "&lt;", "&gt;"), $value);
    }

    /**
     * 过滤SCRIPT[...]
     * @param type $value
     * @return type
     */
    public function filterScript($value) {
        $value = preg_replace("/(javascript:)?on(click|load|key|mouse|error|abort|move|unload|change|dblclick|move|reset|resize|submit)/i", "&111n\\2", $value);
        $value = preg_replace("/<script(.*?)>(.*?)<\/script>/si", "", $value);
        $value = preg_replace("/<iframe(.*?)>(.*?)<\/iframe>/si", "", $value);
        $value = preg_replace("/<object.+<\/object>/iesU", '', $value);

        return $value;
    }

    /**
     * 过滤SQL
     * @param type $value
     * @return type
     */
    public function filterSql($value) {
        $sql = array("select", 'insert', "update", "delete", "\'", "\/\*",
            "\.\.\/", "\.\/", "union", "into", "load_file", "outfile");
        $sql_re = array("", "", "", "", "", "", "", "", "", "", "", "");

        return str_replace($sql, $sql_re, $value);
    }

    /**
     * 通用过滤包括字符串、数组
     * @param type $value
     * @return type
     */
    public function filterEscape($value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = self::_filteStr($v);
            }
        } else {
            $value = self::_filteStr($value);
        }

        return $value;
    }

    /**
     * 过滤字符串
     * @param string $value
     * @return mixed
     */
    private static function _filteStr($value) {
        $value = str_replace(array("\0", "%00", "\r"), '', $value);
        $value = preg_replace(array('/[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]/', '/&(?!(#[0-9]+|[a-z]+);)/is'), array('', '&amp;'), $value);
        $value = str_replace(array("%3C", '<'), '&lt;', $value);
        $value = str_replace(array("%3E", '>'), '&gt;', $value);
        $value = str_replace(array('"', "'", "\t", '  '), array('&quot;', '&#39;', '    ', '&nbsp;&nbsp;'), $value);

        return $value;
    }

}