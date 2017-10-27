<?php
return [
    //每分钟定时运行脚本
    'cron'      => '* * * * *',

    /**
     * 'test/example' => [
     *          'cron'      => '* * * * *',
     *          'cron-stdout'=> '/tmp/ExampleCommand.log',
     *          'cron-stderr'=> '/tmp/ExampleCommandError.log',
     * ],
     */
    'cronJobs' => [
        //清理过期的微信历史消息记录
        //每天凌晨执行一次
        'msg-history/index' => [
            'cron' => '0 0 * * *',
            'cron-stdout'=> '/tmp/rageframe/cron/MsgHistory.log',
            'cron-stderr'=> '/tmp/rageframe/cron/MsgHistoryError.log',
        ]
        //......更多的定时任务
    ],
];