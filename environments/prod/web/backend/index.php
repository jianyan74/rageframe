<?php
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/jianyan74/rageframe-basics/yii/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../../backend/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../vendor/jianyan74/rageframe-basics/backend/config/main.php'),
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../../backend/config/main.php'),
    require(__DIR__ . '/../../backend/config/main-local.php')
);

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

/**
 * 添加rageframe的服务 ，Yii::$service  ,  将services的配置添加到这个对象。
 * 使用方法：Yii::$service->cms->article;
 * 上面的例子就是获取cms服务的子服务article。
 */
new jianyan\basics\services\Application($config['services']);
unset($config['services']);

(new yii\web\Application($config))->run();
