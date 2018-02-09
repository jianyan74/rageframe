<?php
$params = array_merge(
    require(__DIR__ . '/../../vendor/jianyan74/rageframe-basics/backend/config/params.php'),
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'main',// 默认控制器
    'bootstrap' => ['log'],
    'components' => [
        'request'=>[
            'csrfParam'=>'_csrf-backend'
        ],
        'user' => [
            'identityClass' => 'jianyan\basics\common\models\sys\Manager',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['site/login'],
            'idParam' => '__admin',
            'as afterLogin' => 'common\behaviors\AfterLogin',
        ],
        'session' => [
            'name' => 'advanced-backend',
            'timeout' => 7200
        ],
        /** ------ 视图替换 ------ **/
        'view' => [
            'theme' => [
                'pathMap' => [
                    // 表示@backend/views优先于@basics/backend/views
                    '@basics/backend/views' => '@backend/views',
                    '@basics/backend/modules/sys/views' => '@backend/modules/sys/views',
                    '@basics/backend/modules/wechat/views' => '@backend/modules/wechat/views'
                ],
            ],
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
        /** ------ 路由配置 ------ **/
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,  // 这个是生成路由 ?r=site/about--->/site/about
            'showScriptName' => false,
            'suffix' => '.html',// 静态
            'rules' =>[

            ],
        ],
        /** ------ 错误定向页 ------ **/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /** ------ RBAC配置 ------ **/
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%sys_auth_item}}',
            'assignmentTable' => '{{%sys_auth_assignment}}',
            'itemChildTable' => '{{%sys_auth_item_child}}',
            'ruleTable' => '{{%sys_auth_rule}}',
        ],
    ],
    'modules' => [
        /** ------ 会员模块 ------ **/
        'member' => [
            'class' => 'backend\modules\member\Module',
        ],
    ],
    'controllerMap' => [
        // 文件上传公共控制器
        'file' => [
            'class' => 'jianyan\basics\common\controllers\FileBaseController',
        ]
    ],
    'params' => $params,
];
