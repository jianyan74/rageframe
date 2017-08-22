<?php
return [
    'vendorPath'     => dirname(dirname(__DIR__)) . '/vendor',
    'language'       => 'zh-CN',
    'sourceLanguage' => 'zh-cn',
    'timeZone'       => 'Asia/Shanghai',
    'components'     => [

        /**-------------------格式化时间--------------------**/
        'formatter' => [
            'dateFormat'        => 'yyyy-MM-dd',
            'datetimeFormat'    => 'yyyy-MM-dd HH:mm:ss',
            'decimalSeparator'  => ',',
            'thousandSeparator' => ' ',
            'currencyCode'      => 'CNY',
        ],

        /**-------------------网站公共配置--------------------**/
        'config'      => [
            'class'           => 'jianyan\basics\common\models\sys\Config',
        ],

        /**-------------------文件缓存配置--------------------**/
        'cache'      => [
            'class'           => 'yii\caching\FileCache',
            'cachePath'       => '@backend/runtime/cache'//缓存路径
        ],

        /**-------------------redis缓存配置-------------------**/
        'redis'      => [
            'class'          => 'yii\redis\Connection',
            'hostname'       => 'localhost',
            'port'           => 6379,
            'database'       => 0,
        ],

        /**----------------------微信路由配置--------------------**/
        'urlManagerWechat' => [
            'class' => 'yii\web\urlManager',//echo Yii::$app->urlManagerWechat->createAbsoluteUrl(...);
            'scriptUrl' => '/wechat', //代替'baseUrl'
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'suffix'          => '.html',//静态
        ],

        /**----------------------前台路由配置--------------------**/
        'urlManagerFrontend' => [
            'class' => 'yii\web\urlManager',//echo Yii::$app->urlManagerFrontend->createAbsoluteUrl(...);
            'scriptUrl' => '/index.php', //代替'baseUrl'
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'suffix'          => '.html',//静态
        ],

        /**----------------------资源创建管理--------------------**/
        'assetManager' => [
            'forceCopy' => true,//线上建议将forceCopy设置成false，如果访问量不大无所谓
        ],

        /**----------------------微信SDK----------------------**/
        'wechat' => [
            'class' => 'maxwen\easywechat\Wechat',
             'userOptions'    => [],  # 用户身份类参数
             'sessionParam'   => 'wechatUser', # 微信用户信息将存储在会话在这个密钥
             'returnUrlParam' => '_wechatReturnUrl', # returnUrl 存储在会话中
        ],
    ],
];
