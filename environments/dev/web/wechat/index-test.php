<?php

// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/jianyan74/rageframe-basics/yii/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../../wechat/config/bootstrap.php');

$config = require(__DIR__ . '/../../wechat/config/test-local.php');

/**
 * 通过配置重写类
 * yii class Map Custom
 */
$yiiClassMap = require(__DIR__ . '/../../common/config/YiiClassMap.php');
if(is_array($yiiClassMap) && !empty($yiiClassMap)){
    foreach($yiiClassMap as $namespace => $filePath){
        Yii::$classMap[$namespace] = $filePath;
    }
}

new jianyan\basics\services\Application($config['services']);
unset($config['services']);

(new yii\web\Application($config))->run();
