<?php
return [
    // 是否开启api log 日志记录
    'debug' => false,
    // api接口token有效期 默认2天
    'user.accessTokenExpire' => 2 * 24 * 3600,
    // token有效期是否验证 默认不验证
    'user.accessTokenValidity' => false,
    // 不需要token验证的方法
    'user.optional' => [
        'login',
        'refresh',
    ],
    // 速度控制6秒内访问3次，注意，数组的第一个不要设置1，设置1会出问题，一定要大于2，譬如下面  6秒内只能访问三次
    'user.rateLimit' => [3, 6],
];