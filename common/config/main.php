<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    'sourceLanguage' => 'zh-cn',
    'timeZone' => 'Asia/Shanghai',
    'bootstrap' => [
        'queue'// 队列系统
    ],
    'components' => [
        /** ------ 格式化时间 ------ **/
        'formatter' => [
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CNY',
        ],
        /** ------ 网站公共配置 ------ **/
        'config' => [
            'class' => 'jianyan\basics\common\models\sys\Config',
        ],
        /** ------ 文件缓存配置 ------ **/
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@backend/runtime/cache' // 注意如果要改成redis请删除，否则会报错
        ],
        /** ------ redis配置 ------ **/
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        /** ------ MemCache缓存配置 ------ **/
        'memcache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 100,
                ],
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 50,
                ],
                'useMemcached' => false , // true:memcached, false:memcache
            ],
        ],
        /** ------ 队列设置 ------ **/
        'queue' => [
            'class' => 'yii\queue\redis\Queue',
            'redis' => 'redis', // 连接组件或它的配置
            'channel' => 'queue', // Queue channel key
            'as log' => 'yii\queue\LogBehavior',// 日志
        ],
        /** ------ 全文搜索引擎 ------ **/
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
        /** ------ 微信路由配置 ------ **/
        'urlManagerWechat' => [
            'class' => 'yii\web\urlManager',
            'scriptUrl' => '/wechat', // 代替'baseUrl'
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'suffix' => '.html',// 静态
        ],
        /** ------ 前台路由配置 ------ **/
        'urlManagerFrontend' => [
            'class' => 'yii\web\urlManager',
            'scriptUrl' => '/index.php', // 代替'baseUrl'
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'suffix' => '.html',// 静态
        ],
        /** ------ 资源创建管理 ------ **/
        'assetManager' => [
            // 线上建议将forceCopy设置成false，如果访问量不大无所谓
            'forceCopy' => true,
        ],
        /** ------ 微信SDK ------ **/
        'wechat' => [
            'class' => 'jianyan\easywechat\Wechat',
            'userOptions' => [],  // 用户身份类参数
            'sessionParam' => 'wechatUser', // 微信用户信息将存储在会话在这个密钥
            'returnUrlParam' => '_wechatReturnUrl', // returnUrl 存储在会话中
        ],
        /** ------ 公用支付 ------ **/
        'pay' => [
            'class' => 'jianyan\basics\common\components\Pay',
        ]
    ],
    /** ------ 服务层 ------ **/
    'services' => [
        'test' => [
            'class' => 'common\servers\Test',
            // 子服务
            'childService' => [
                'test' => [
                    'class' => 'common\servers\test\Test',
                ],
            ],
        ],
    ]
];
