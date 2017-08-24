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
            'class' => 'api\modules\v1\index',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\member\Member',
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
                #################
                ## default Api ##
                #################
                # http://rageframe/api/v1/default
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/default'],
                    'pluralize' => false,
                ],
            ]
        ],

        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],

    'params' => $params,
];