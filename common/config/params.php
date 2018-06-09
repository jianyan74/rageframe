<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    // 推荐位
    'recommend' => [
        '1'    => "首页",
        '2'    => "列表",
        '4'    => "内页",
    ],

    /** ------ 上传配置 ------ **/

    // 默认上传文件路由
    'uploadDefaultFileUrl' => '',
    // 默认上传图片路由
    'uploadDefaultImageUrl' => '',

    // 图片上传配置
    'imagesUpload' => [
        'maxSize'    => 1024 * 1024 * 2,// 图片最大上传大小,默认2M
        'maxExc'     => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],// 可上传图片后缀不填写即为不限
        'path'       => 'images/',// 图片创建路径
        'thumbPath'  => 'thumb/',// 图片创建缩略图路径
        'subName'    => 'Y/m/d',// 图片上传子目录规则
        'prefix'     => 'image_',// 图片名称前缀
    ],
    // 视频上传配置
    'videosUpload' => [
        'maxSize'    => 1024 * 1024 * 10,// 最大上传大小,默认10M
        'maxExc'     => ['.mp4'],// 可上传文件后缀不填写即为不限
        'path'       => 'videos/',// 创建路径
        'subName'    => 'Y/m/d',// 上传子目录规则
        'prefix'     => 'video_',// 名称前缀
    ],
    // 语音上传配置
    'voicesUpload' => [
        'maxSize'    => 1024 * 1024 * 50,// 最大上传大小,默认50M
        'maxExc'     => ['.amr', '.mp3'],// 可上传文件后缀不填写即为不限
        'path'       => 'voices/',// 创建路径
        'subName'    => 'Y/m/d',// 上传子目录规则
        'prefix'     => 'voice_',// 名称前缀
    ],
    // 文件上传配置
    'filesUpload' => [
        'maxSize'    => 1024 * 1024 * 50,// 最大上传大小,默认50M
        'maxExc'     => [],// 可上传文件后缀不填写即为不限
        'path'       => 'files/',// 创建路径
        'subName'    => 'Y/m/d',// 上传子目录规则
        'prefix'     => 'file_',// 名称前缀
    ],
    // 上传状态映射表
    'uploadState' => [
        "ERROR_TMP_FILE"           => "临时文件错误",
        "ERROR_TMP_FILE_NOT_FOUND" => "找不到临时文件",
        "ERROR_SIZE_EXCEED"        => "文件大小超出网站限制",
        "ERROR_TYPE_NOT_ALLOWED"   => "文件类型不允许",
        "ERROR_CREATE_DIR"         => "目录创建失败",
        "ERROR_DIR_NOT_WRITEABLE"  => "目录没有写权限",
        "ERROR_FILE_MOVE"          => "文件保存时出错",
        "ERROR_FILE_NOT_FOUND"     => "找不到上传文件",
        "ERROR_WRITE_CONTENT"      => "写入文件内容错误",
        "ERROR_UNKNOWN"            => "未知错误",
        "ERROR_DEAD_LINK"          => "链接不可用",
        "ERROR_HTTP_LINK"          => "链接不是http链接",
        "ERROR_HTTP_CONTENTTYPE"   => "链接contentType不正确"
    ],

    /** ------ 微信配置 ------ **/

    // 微信配置 具体可参考EasyWechat
    'wechatConfig' => [],
    // 微信支付配置 具体可参考EasyWechat
    'wechatPaymentConfig' => [],
    // 微信小程序配置 具体可参考EasyWechat
    'wechatMiniProgramConfig' => [],
    // 微信开放平台第三方平台配置 具体可参考EasyWechat
    'wechatOpenPlatformConfig' => [],
    // 微信企业微信配置 具体可参考EasyWechat
    'wechatWorkConfig' => [],
];
