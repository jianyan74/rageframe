<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        //版本
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
        //版本2
        'v2' => [
            'class' => 'api\modules\v2\Module',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\base\AccessToken',
            'enableAutoLogin' => true,
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
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' 		=> true,
            'enableStrictParsing' 	=> true,
            'showScriptName' 		=> false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        /**
                         * 默认登录测试控制器
                         * http://当前域名/api/site/login?group=1
                         */
                        'site',
                        /*------------业务相关------------*/
                        'v1/default',
                    ],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'GET search' => 'search',
                    ],
                ],
            ]
        ],

        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $response->data = [
                    'code' => $response->getStatusCode(),
                    'message' => $response->statusText,
                    'data' => $response->data,
                ];
                $response->format = yii\web\Response::FORMAT_JSON;
            },
        ],
        'errorHandler' => [
            'errorAction' => 'message/error',
        ],
    ],

    'params' => $params,
];