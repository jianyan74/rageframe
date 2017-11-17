<?php
return [
    'adminEmail' => 'admin@example.com',

    /** ------ 总管理员配置 ------ **/

    'adminAccount' => 1,// 系统管理员账号id

    /** ------ 后台网站基础配置 ------ **/

    // 'siteTitle'              => "",// 后台系统名称
    // 'abbreviation'           => "",// 缩写
    // 'acronym'                => "",// 拼音缩写

    /** ------ 备份配置配置 ------ **/

    'dataBackupPath' => Yii::getAlias('@rootPath') . '/common/backup', // 数据库备份根路径
    'dataBackPartSize' => 20971520,// 数据库备份卷大小
    'dataBackCompress' => 1,// 压缩级别
    'dataBackCompressLevel' => 9,// 数据库备份文件压缩级别
    'dataBackLock' => 'backup.lock',// 数据库备份缓存文件名

    /** ------ 自定义接口配置 ------ **/

    'userApiPath' => Yii::getAlias('@rootPath') . '/common/userapis', // 自定义接口路径
    'userApiNamespace' => '\common\userapis', // 命名空间

    /** ------ 禁止删除的后台菜单id ------ **/

    'noDeleteMenu' => [65,108],
    // 不需要验证的路由全称
    'noAuthRoute' => [

    ],
    // 不需要验证的方法
    'noAuthAction' => [

    ],
];