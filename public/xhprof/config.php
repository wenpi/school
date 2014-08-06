<?php
$GLOBALS['XHPROF_LIB_ROOT'] = realpath ( dirname ( __FILE__ ) . '/../' ) . '/../ext/Xhprof/xhprofLib';
include_once $GLOBALS['XHPROF_LIB_ROOT'].'/display/xhprof.php';

//设置执行时间
ini_set('max_execution_time', 100);

?>
