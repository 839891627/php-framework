<?php
/**
 * @author: arvin.cao@shoufuyou.com
 * Date: 2019-04-10
 * Time: 10:47
 */

/**
 * 入口文件
 * 1. 定义常量
 * 2. 加载函数库
 * 3. 启动框架
 */

define('IMOOC', realpath('./'));
define('CORE', IMOOC . '/core');
define('APP', IMOOC . '/app');
define('MODULE', 'app');

define('DEBUG', true);

include "vendor/autoload.php";

if (DEBUG) {
    // 利用第三方的调试包
    $whoops = new Whoops\Run();
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();

    ini_set('display_errors', 'on');
} else {
    ini_set('display_errors', 'off');
}

include CORE . '/common/function.php';

include CORE . '/imooc.php';

// 当调用的类不存在，则去执行 imooc::load 方法
spl_autoload_register('\core\imooc::load');

\core\imooc::run();
