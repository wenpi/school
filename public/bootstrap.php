<?php

/**
 * 启动配置文件
 *
 * @author wangchao
 */
class Bootstrap {

    protected $_module; //应用名
    protected $_dbFlag; //匹配数据库标识
    protected $_conf; //文本配置文件
    protected $_frontCtrl; //前端控制器
    protected $_is_pro; //是否为生产环境
    protected $_pro = 'debug'; //生产环境判断变量    @@debug = 调试

    public function __construct() {

        $this->setAppModule();
        $this->setAppInclude();
        $this->setFramework();
        $this->setConfig();
        $this->setDb();
        $this->setSession();
        $this->setFrontCtrl();
        $this->setLayout();
        //$this->setRouter();
        $this->setCache();
        $this->setZFDebug(); // zfdebug
        $this->setXhprof(); // 性能检查
        $this->setDispatch();
    }

    /**
     * 设置APP模块
     * @author updated by taozywu
     * @date 2013/07/25
     * // admin.child.com          后台管理
     * // school.a1-debug.child.com   ||   school.a1.child.com
     */
    public function setAppModule() {
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Shanghai");
        try {
            list( $module, $hostResult ) = explode(".", $_SERVER['HTTP_HOST']);
            if( strpos($hostResult,"-") !== false ) {
                list($dbFlag , $proName) = explode("-",$hostResult);
            } else {
                // 没有找到“-”说明为正式域名
                $dbFlag = $hostResult;
                $proName = "product";
            }
        } catch (Exception $e) {
            $module = "ccc";
            $hostResult = "a1-debug";
            $dbFlag = "ccc";
            $proName = "debug";
        }

        // 将admin转为代码中对应的目录ccc
        $module = $module == "admin" ? "ccc" : $module;
        $GLOBALS['domain_name'] = $_SERVER['HTTP_HOST'];
        $GLOBALS['db_flag'] = $dbFlag;
        $this->_module = $GLOBALS['module'] = isset($module) ? $module : "ccc";
        $this->_dbFlag = $GLOBALS['db_flag'];
        $this->_is_pro = ( isset($proName) && $proName == $this->_pro ) ? FALSE : TRUE;
    }

    /**
     * 设置APP的include_path
     */
    public function setAppInclude() {
        define("PATH_MOD", PATH_APP . DS . $this->_module);         //模块目录
        define("PATH_MOD_CTRL", PATH_MOD . DS . 'controllers');     //模块controllers目录
        define("PATH_MOD_MODEL", PATH_MOD . DS . 'models');         //模块models目录
        define("PATH_MOD_VIEW", PATH_MOD . DS . 'views');           //模块views目录
        define("PATH_MOD_LAYOUT", PATH_MOD_VIEW . DS . 'layout');   //模块layout目录

        $include = array(
            PATH_ROOT,
            PATH_LIB,
            PATH_APP,
            PATH_MOD,
            PATH_MOD_CTRL,
            PATH_MOD_MODEL,
            PATH_MOD_VIEW,
            PATH_PEAR,
        );

        set_include_path(implode(PATH_SEPARATOR, $include));
    }

    /**
     * 加载文本配置文件conf.ini
     */
    public function setConfig() {
        error_reporting(E_ALL);
        //生产环境和测试环境判断，加载不同的配置
        $section = $this->_is_pro ? 'product' : 'debug';
        $this->_conf = new Zend_Config_Ini(PATH_CONF, $section);
        $GLOBALS['host'] = isset($this->_conf->www->host) ? $this->_conf->www->host : "";
        $GLOBALS['base_url'] = isset($this->_conf->www->baseurl) ? $this->_conf->www->baseurl : "";
        Zend_Registry::set("conf", $this->_conf);
    }

    /**
     * 设置ZEND FRAMEWORK自动加载
     */
    public function setFramework() {
        require_once 'Zend/Loader/Autoloader.php';
        @Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
    }

    /**
     * 设置日志
     */
    public function setLogs() {
        $logger = new Zend_Log();
        $stream = @fopen('log.txt', 'a');
        $writer = new Zend_Log_Writer_Stream($stream);
        $format = '%timestamp% %priorityName% (%priority%): %message%' . PHP_EOL;
        $formatter = new Zend_Log_Formatter_Simple($format);
        $writer->setFormatter($formatter);
        $logger->addWriter($writer);
        Zend_Registry::set('logger', $logger);
    }

    /**
     * 设置前端控制器
     */
    public function setFrontCtrl() {
        try {
            $this->_frontCtrl = Zend_Controller_Front::getInstance();
            $fc = array("{$this->_module}" => PATH_MOD_CTRL); //模块默认路径
            $this->_frontCtrl->setControllerDirectory($fc);
            $this->_frontCtrl->setBaseUrl("/"); //基地址
            $this->_frontCtrl->setDefaultModule($this->_module); //默认加载模块
            $this->_frontCtrl->throwExceptions(true);
            Zend_Registry::set('frontCtrl', $this->_frontCtrl);
        } catch (Zend_Controller_Exception $e) {
            print_r($e);
        } catch (Exception $e) {
            echo "<pre><b>" . $e->getMessage() . "</b>\n" . $e->getTraceAsString() . "</pre>";
        }
    }

    /**
     * 设置控制器分发
     */
    public function setDispatch() {
        try {
            $this->_frontCtrl->dispatch();
        } catch (Zend_Controller_Exception $e) {
            print_r($e);
            //header("Location:http://error2.php");
        } catch (Exception $e) {
            echo "<pre><b>" . $e->getMessage() . "</b>\n" . $e->getTraceAsString() . "</pre>";
        }
    }

    /**
     * 设置布局
     */
    public function setLayout() {
        $layout = Zend_Layout::startMvc(PATH_MOD_LAYOUT);
        $layout->setLayout('default');
        return $layout;
    }

    /**
     * 设置Db类
     */
    public function setDb() {
        ob_start();
        $adapter = array();
        $dbConfigs = @include PATH_ROOT . $this->_conf->db->path_db_config;
//        print_r($dbConfigs[$this->_dbFlag]);
        $db_r = array(
            'adapter' => $this->_conf->db->adapter,
            'host' => @$dbConfigs[$this->_dbFlag]['db_hostname'],
            'username' => @$dbConfigs[$this->_dbFlag]['db_username'],
            'password' => @$dbConfigs[$this->_dbFlag]['db_password'],
            'dbname' => @$dbConfigs[$this->_dbFlag]['db_name'],
            "charset" => @$dbConfigs[$this->_dbFlag]['db_charset'],
            'profiler' => 1,
            'port' => @$dbConfigs[$this->_dbFlag]['db_port'],
        );

        $adapter['db_r'] = Zend_Db::factory($this->_conf->db->adapter, $db_r);

        try {
            $adapter['db_r']->getConnection();
        } catch (Zend_Db_Adapter_Exception $e) {
            echo $e->getMessage();
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }
        Zend_Db_Table::setDefaultAdapter($adapter['db_r']);
        Zend_Registry::set('adapter', $adapter);
        $adapter['db_r']->query("SET NAMES 'utf8'");
        $this->dbAdapter = $adapter['db_r'];
    }

    /**
     * 初始化SESSION
     */
    public function setSession() {
        // 针对特殊session处理
        $PHPSESSID = "";
        if (isset($_POST['PHPSESSID'])) {
            $PHPSESSID = $_POST['PHPSESSID'];
        } else if (isset($_GET['PHPSESSID'])) {
            $PHPSESSID = $_GET['PHPSESSID'];
        }
        if (!empty($PHPSESSID)) {
            Zend_Session::setOptions(array('strict' => 'on'));
            Zend_Session::setId($PHPSESSID);
        }
        Zend_Session::start();
        Zend_Session::setOptions($this->_conf->session->toArray());
        $session = new Zend_Session_Namespace("ccc", true);
        Zend_Registry::set("session", $session);
    }

    /**
     * 设置cache
     */
    public function setCache() {
        $cache_front = array(
            'lifeTime' => $this->_conf->cache->lifetime,
            'automatic_Serialization' => $this->_conf->cache->automatic_serialization
        );

        $cache_back = array(
            'servers' => array(
                'host' => $this->_conf->cache->host,
                'port' => $this->_conf->cache->port,
                'persistent' => $this->_conf->cache->persistent,
                'cache_dir' => $this->_conf->cache->cache_dir
            ),
            'compression' => true
        );
        try {
            $cache = Zend_Cache::factory('Core', 'Memcached', $cache_front, $cache_back);
            Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
        } catch (Exception $e) {
            $cache = null;
        }
        Zend_Registry::set('cache', $cache);

        return $cache;
    }

    /**
     * 检查代码中所有函数性能
     * 调用测试：打开当前url的http header 查看。
     */
    public function setXhprof() {
        $_rand = substr(md5(time()), 0, 20);
        // 如果开启
        if (isset($this->_conf->xhprof->debug) && $this->_conf->xhprof->debug)
            Ccc_Third_Xhprof::getInstance("{$_rand}")->enable();
    }

    /**
     * 配置zfDebug
     * @add by taozywu
     * @date 2013/05/16
     */
    public function setZFDebug() {
        if (isset($this->_conf->debug) && $this->_conf->debug) {
            $autoloader = Zend_Loader_Autoloader::getInstance();
            $autoloader->registerNamespace('ZFDebug');

            $options = array(
                'jquery_path' => "http://" . $_SERVER['HTTP_HOST'] . "/js/jquery-1.8.2.min.js",
                'plugins' => array(
                    'Variables',
//					'Html' ,
                    'Database' => array('adapter' => $this->dbAdapter),
                    'File' => array('basePath' => PATH_APP),
//					'Memory' ,
                    'Time',
//					'Registry' ,
                    'Exception'
                )
            );

            $debug = new ZFDebug_Controller_Plugin_Debug($options);
            $this->_frontCtrl->registerPlugin($debug);
        }
    }

}