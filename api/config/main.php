<?php
$params = array_merge(
    require(__DIR__ . '/../../vendor/jianyan74/rageframe-basics/api/config/params.php'),
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
    'components' => [
        'user' => [
            'identityClass' => 'common\models\base\AccessToken',
            'enableAutoLogin' => true,
            'enableSession' => false,// 显示一个HTTP 403 错误而不是跳转到登录界面
            'loginUrl' => null,
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
            // 美化Url,默认不启用。但实际使用中，特别是产品环境，一般都会启用。
            'enablePrettyUrl' => true,
            // 是否启用严格解析，如启用严格解析，要求当前请求应至少匹配1个路由规则，
            // 否则认为是无效路由。
            // 这个选项仅在 enablePrettyUrl 启用后才有效。启用容易出错
            // 注意:如果不需要严格解析路由请直接删除此行代码
            'enableStrictParsing' => true,
            // 是否在URL中显示入口脚本。是对美化功能的进一步补充。
            'showScriptName' => false,
            // 指定续接在URL后面的一个后缀，如 .html 之类的。仅在 enablePrettyUrl 启用时有效。
            'suffix' => '',
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        /**
                         * 默认登录测试控制器
                         * http://当前域名/api/site/login?group=1
                         */
                        'site',
                        'room',
                        'file',
                        /** ------ 业务相关 ------ **/
                        'v1/default',
                    ],
                    'pluralize' => false,// 是否启用复数形式，注意index的复数indices，开启后不直观
                    'extraPatterns' => [
                        'POST login' => 'login',// 登录获取token
                        'GET refresh' => 'refresh',// 重置token
                        'GET search' => 'search',// 测试查询
                        'POST upload-images' => 'upload-images', // 图片上传
                        'POST upload-videos' => 'upload-videos', // 视频上传
                        'POST upload-voices' => 'upload-voices', // 语音上传
                        'POST upload-files' => 'upload-files', // 文件上传
                        'POST upload-base64-img' => 'upload-base64-img', // base64上传 其他上传权限自己添加
                    ],
                ],
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $response->data = [
                    'code' => $response->statusCode,
                    'message' => $response->statusText,
                    'data' => $response->data,
                ];
                // 格式化报错输入格式 默认为格式500状态码 其他可自行修改
                if ($response->statusCode == 500) {
                    if (YII_DEBUG){
                        $exception = Yii::$app->getErrorHandler()->exception;
                        $response->data['data'] = [
                            'name' => ($exception instanceof Exception || $exception instanceof ErrorException) ? $exception->getName() : 'Exception',
                            'type' => get_class($exception),
                            'file' => $exception->getFile(),
                            'errorMessage' => $exception->getMessage(),
                            'line' => $exception->getLine(),
                            'stack-trace' => explode("\n", $exception->getTraceAsString()),
                        ];

                        if ($exception instanceof Exception){
                            $response->data['data']['error-info'] = $exception->errorInfo;
                        }
                    } else {
                        $response->data['data'] = '内部服务器错误';
                    }
                }

                $response->format = yii\web\Response::FORMAT_JSON;
            },
        ],
        'errorHandler' => [
            'errorAction' => 'message/error',
        ],
    ],
    'modules' => [
        // 版本1
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
        // 版本2
        'v2' => [
            'class' => 'api\modules\v2\Module',
        ],
    ],
    'params' => $params,
];