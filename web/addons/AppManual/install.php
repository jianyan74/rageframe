<?php

$sql = "
DROP TABLE IF EXISTS `yl_addon_app_manual`;
CREATE TABLE `yl_addon_app_manual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '标题',
  `name` varchar(50) DEFAULT NULL COMMENT '唯一标识',
  `pid` int(50) DEFAULT '0' COMMENT '上级id',
  `content` longtext COMMENT '链接地址',
  `sort` int(5) DEFAULT '0' COMMENT '排序',
  `view` int(10) DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(1) DEFAULT '1' COMMENT '是否隐藏',
  `level` tinyint(1) DEFAULT '1' COMMENT '级别',
  `append` int(10) DEFAULT NULL COMMENT '添加时间',
  `updated` int(10) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='文档表';
";

//执行sql
Yii::$app->getDb()->createCommand($sql)->execute();