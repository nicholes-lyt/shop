<?php


//

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录
define('APP_PATH','./Home/');
// 定义应用目录
define('APP_NAME','index');
//定义log4php日志类库
define('LOG4PHP_DIR', "./Home/Lib/Log4php/");
//定义应用需要的常量信息
define("CSS_URL","shop/public/home/css/");

// 引入ThinkPHP入口文件
require '../tpp3.2/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单