<?php
//  Copyright (c) 2009 Facebook
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//

//
// XHProf: A Hierarchical Profiler for PHP
//
// XHProf has two components:
//
//  * This module is the UI/reporting component, used
//    for viewing results of XHProf runs from a browser.
//
//  * Data collection component: This is implemented
//    as a PHP extension (XHProf).
//
//
//
// @author(s)  Kannan Muthukkaruppan
//             Changhao Jiang
//

// by default assume that xhprof_html & xhprof_lib directories
// are at the same level.
//$GLOBALS['XHPROF_LIB_ROOT'] = dirname(__FILE__) . '/../xhprof_lib';
include( 'config.php' );

// param name, its type, and default value
$params = array('run'        => array(XHPROF_STRING_PARAM, ''),
                'wts'        => array(XHPROF_STRING_PARAM, ''),
                'symbol'     => array(XHPROF_STRING_PARAM, ''),
                'sort'       => array(XHPROF_STRING_PARAM, 'wt'), // wall time
                'run1'       => array(XHPROF_STRING_PARAM, ''),
                'run2'       => array(XHPROF_STRING_PARAM, ''),
                'source'     => array(XHPROF_STRING_PARAM, 'xhprof'),
                'all'        => array(XHPROF_UINT_PARAM, 0),
                );

// pull values of these params, and create named globals for each param
xhprof_param_init($params);

/* reset params to be a array of variable names to values
   by the end of this page, param should only contain values that need
   to be preserved for the next page. unset all unwanted keys in $params.
 */
foreach ($params as $k => $v) {
  $params[$k] = $$k;

  // unset key from params that are using default values. So URLs aren't
  // ridiculously long.
  if ($params[$k] == $v[1]) {
    unset($params[$k]);
  }
}
$vbar  = ' class="vbar"';
$vwbar = ' class="vwbar"';
$vwlbar = ' class="vwlbar"';
$vbbar = ' class="vbbar"';
$vrbar = ' class="vrbar"';
$vgbar = ' class="vgbar"';

$xhprof_runs_impl = new XHProfRuns_Default();
?>
<html>

<head><title>XHProf: 分层性能分析报告</title>
<?php xhprof_include_js_css();?>

</head>

<body>
<a href="/monitor" target="_blank">错误监控</a><br />
<?php displayXHProfReport($xhprof_runs_impl, $params, $source, $run, $wts, $symbol, $sort, $run1, $run2);?>


</body>
</html>
