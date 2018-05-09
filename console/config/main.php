<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log'
    ],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'redis'      => [
            'class'          => 'yii\redis\Connection',
            'hostname'       => 'localhost',
            'port'           => 6379,
            'database'       => 0,
        ],
        'log' =>[
            # 追踪级别
            # 消息跟踪级别
            # 在开发的时候，通常希望看到每个日志消息来自哪里。这个是能够被实现的，通过配置 log 组件的 yii\log\Dispatcher::traceLevel 属性， 就像下面这样：
            'traceLevel' => YII_DEBUG ? 3 : 0,
            # 通过 yii\log\Logger 对象，日志消息被保存在一个数组里。为了这个数组的内存消耗， 当数组积累了一定数量的日志消息，日志对象每次都将刷新被记录的消息到 log targets 中。 你可以通过配置 log 组件的 yii\log\Dispatcher::flushInterval 属性来自定义数量
            'flushInterval' => 1,
            'targets' => [
                'file1' =>[
                    //'levels' => ['warning'],
                    'categories' => ['cron_controller_logs'],
                    'class' => 'yii\log\FileTarget',
                    # 当 yii\log\Logger 对象刷新日志消息到 log targets 的时候，它们并 不能立即获取导出的消息。相反，消息导出仅仅在一个日志目标累积了一定数量的过滤消息的时候才会发生。你可以通过配置 个别的 log targets 的 yii\log\Target::exportInterval 属性来 自定义这个数量，就像下面这样：
                    'exportInterval' => 1,
                    # 输出文件
                    'logFile' => '@app/runtime/logs/cron_controller_logs.log',
                    # 你可以通过配置 yii\log\Target::prefix 的属性来自定义格式，这个属性是一个PHP可调用体返回的自定义消息前缀
                    'prefix' => function ($message) {
                        return $message;
                    },
                    # 除了消息前缀以外，日志目标也可以追加一些上下文信息到每组日志消息中。 默认情况下，这些全局的PHP变量的值被包含在：$_GET, $_POST, $_FILES, $_COOKIE,$_SESSION 和 $_SERVER 中。 你可以通过配置 yii\log\Target::logVars 属性适应这个行为，这个属性是你想要通过日志目标包含的全局变量名称。 举个例子，下面的日志目标配置指明了只有 $_SERVER 变量的值将被追加到日志消息中。
                    # 你可以将 logVars 配置成一个空数组来完全禁止上下文信息包含。或者假如你想要实现你自己提供上下文信息的方式， 你可以重写 yii\log\Target::getContextMessage() 方法。
                    'logVars' => [],
                ],
            ],
        ],
        'errorHandler' => [
            //           'maxSourceLines' => 30,
        ],
    ],
    'controllerMap' => [
        //定时任务
        'cron' => [
            'class' => 'denisog\cronjobs\CronController'
        ],
        //数据库命令行备份
        'migrate' => [
            'class' => 'e282486518\migration\ConsoleController',
        ],
        // webSocket
        'websocket' => [
            'class' => 'jianyan\websocket\console\WebSocketController',
            'server' => 'jianyan\websocket\server\WebSocketServer',
            'host' => '0.0.0.0',// 监听地址
            'port' => 9501,// 监听端口
            'type' => 'wss', // 默认为ws连接，可修改为wss
            'config' => [// 标准的swoole配置项都可以再此加入
                'daemonize' => false,// 守护进程执行
                'task_worker_num' => 4,//task进程的数量
                'ssl_cert_file' => '/etc/letsencrypt/live/www.yllook.com/fullchain.pem',
                'ssl_key_file' => '/etc/letsencrypt/live/www.yllook.com/privkey.pem',
                'pid_file' => __DIR__ . '/../../backend/runtime/logs/server.pid',
                'log_file' => __DIR__ . '/../../backend/runtime/logs/swoole.log',
                'log_level' => 0,
            ],
        ],
    ],
    'params' => $params,
];
