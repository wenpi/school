<?php

/**
 * xhprof性能分析类
 * @author taozywu
 * @date 2012/09/08 | updated by 2013/04/26
 */
class Ccc_Third_Xhprof {

    /**
     * xhprof返回的数据
     * @var array
     */
    public $data = null;

    /**
     * 命名空间，用于生成分析数据地址
     * @var string
     */
    private $_nameSpace = null;

    /**
     * 单例对象
     */
    private static $_singletonObject;

    /**
     * 分析开关，如果关（false），则析构时不调用disable函数
     * @var bool
     */
    private $_switchOn = false;

    /**
     * 实例化
     * @param string $nameSpace
     */
    private function __construct($nameSpace) {
        ob_start();

        $this->_nameSpace = $nameSpace;
    }

    /**
     * 单例
     * @return LibsXhprof
     */
    public static function getInstance($nameSpace) {
        $className = __CLASS__;
        if (!isset(self::$_singletonObject[$className]) || !self::$_singletonObject[$className]) {
            self::$_singletonObject[$className] = new self($nameSpace);
        }

        return self::$_singletonObject[$className];
    }

    /**
     * 开启xhprof性能分析
     * @param 0-普通记录|XHPROF_FLAGS_MEMORY-内存|XHPROF_FLAGS_CPU-系统CPU|XHPROF_FLAGS_NO_BUILTINS-不记录内部函数 $params 分析参数
     * @param array $configs 数组配置 = array
     * (
     *     //忽略的函数
     *     'ignored_functions' => array
     *         (
     *             'call_user_func',
     *         )
     * )
     */
    public function enable($params = 0, $configs = array()) {
        //xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY); ;
        $this->_switchOn = true;
        if (!function_exists('xhprof_enable')) {
            die('U Should Install Xhprof On SERVER!');
        }

        xhprof_enable($params, $configs);
    }

    /**
     * 析构时结束分析
     * 也可自己定义结束分析时间
     */
    public function __destruct() {
        if ($this->_switchOn === true) {
            $this->disable();
        }

        $this->getUrl();

        ob_end_flush();
    }

    /**
     * 关闭性能分析
     */
    public function disable() {
        $this->_switchOn = true;
        $this->data = xhprof_disable();
    }

    /**
     * 获取性能分析地址
     */
    public function getUrl() {
        include_once "ext/xhprof/xhprofLib/utils/xhprof_lib.php";
        include_once "ext/xhprof/xhprofLib/utils/xhprof_runs.php";
        $xhprofRuns = new XHProfRuns_Default();
        $runId = $xhprofRuns->save_run($this->data, $this->_nameSpace);
        $xhUrl = "/xhprof/index.php?run={$runId}&source={$this->_nameSpace}";
        header("xhprof_url: " . $xhUrl);
    }

}