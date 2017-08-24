<?php
return [
    /**-------------------总管理员配置-------------------**/
    'adminAccount'           => 1,//系统管理员账号id

    /**-------------------后台网站基础配置-------------------**/
    //'siteTitle'              => "",//后台系统名称
    //'abbreviation'           => "",//缩写
    //'acronym'                => "",//拼音缩写

    /**-------------------备份配置配置-------------------**/
    'dataBackupPath'              => Yii::getAlias('@rootPath') . '/common/backup', //数据库备份根路径
    'dataBackPartSize'            => 20971520,//数据库备份卷大小
    'dataBackCompress'            => 1,//压缩级别
    'dataBackCompressLevel'       => 9,//数据库备份文件压缩级别
    'dataBackLock'                => 'backup.lock',//数据库备份缓存文件名

    /**-------------------禁止删除的后台菜单id-------------------**/
    'noDeleteMenu' => [65,108],

    //不需要验证的路由全称
    'noAuthRoute' => [
        'main/index',//系统主页
        'main/system',//系统首页
        'sys/system/index',//系统入口
        'sys/addons/execute',//模块插件渲染
        'sys/addons/centre',//模块插件基础设置渲染
        'sys/addons/qr',//模块插件二维码渲染
        'sys/addons/cover',//模块插件导航
        'sys/addons/binding',//模块插件入口
        'sys/provinces/index',//省市区联动
        'wechat/default/index',//微信api
    ],

    //不需要验证的方法
    'noAuthAction' => [
        'upload',//百度编辑器上传
    ],
];
