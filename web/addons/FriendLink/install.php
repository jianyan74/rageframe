<?php

$sql = "
DROP TABLE IF EXISTS `yl_addon_sys_links`;
CREATE TABLE `yl_addon_sys_links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '站点名称',
  `cover` varchar(100) DEFAULT '0' COMMENT '封面图片',
  `link` varchar(140) NOT NULL COMMENT '链接地址',
  `summary` varchar(255) DEFAULT '' COMMENT '站点描述',
  `sort` int(3) unsigned DEFAULT '0' COMMENT '优先级',
  `type` tinyint(3) unsigned DEFAULT '1' COMMENT '类型分组',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态（-1：禁用，1：正常）',
  `append` int(10) unsigned DEFAULT '0' COMMENT '添加时间',
  `updated` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='友情连接表';
";

//执行sql
Yii::$app->getDb()->createCommand($sql)->execute();