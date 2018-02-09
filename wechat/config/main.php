<?php
$params = array_merge(
    require(__DIR__ . '/../../vendor/jianyan74/rageframe-basics/wechat/config/params.php'),
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-wechat',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'wechat\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request'=>[
            'csrfParam'=>'_csrf-wechat'
        ],
        'user' => [
            'identityClass' => 'common\models\member\Member',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-wechat', 'httpOnly' => true],
            'loginUrl' => ['site/login'],
            'idParam' => '__wechat',
            'as afterLogin' => 'common\behaviors\AfterLogin',
        ],
        'session' => [
            'name' => 'advanced-wechat',// 这是用于在微信登录的会话cookie的名称
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /** ------ 路由配置 ------ **/
        'urlManager' => [
            'class'           => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,  //这个是生成路由 ?r=site/about--->/site/about
            'showScriptName'  => false,
            'suffix'          => '.html',//静态
            'rules'           =>[
            ],
        ],
    ],
    'controllerMap' => [
        //插件渲染默认控制器
        'addons' => [
            'class' => 'jianyan\basics\common\controllers\AddonsBaseController',
        ],
        'file' => [
            'class' => 'jianyan\basics\common\controllers\FileBaseController',
        ]
    ],
    'modules' => [],
    'params' => $params,
];