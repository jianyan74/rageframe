<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@wechat', dirname(dirname(__DIR__)) . '/wechat');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@rootPath', dirname(dirname(__DIR__)));// 根目录
Yii::setAlias('@resource', dirname(dirname(__DIR__)) . '/web/resource');// 资源目录
Yii::setAlias('@addons', dirname(dirname(__DIR__)) . '/web/addons');// 插件绝对路径目录
Yii::setAlias('@addonurl', '/addons');// 插件url
Yii::setAlias('@attachment', dirname(dirname(__DIR__)) . '/web/attachment');// 附件路径
Yii::setAlias('@attachurl', '/attachment');// 附件二级域名->配置apache
Yii::setAlias('@basics', dirname(dirname(__DIR__)) . '/vendor/jianyan74/rageframe-basics');