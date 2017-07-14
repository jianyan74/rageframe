<?php

$sql = "
DROP TABLE IF EXISTS `yl_addon_sys_debris`;
CREATE TABLE `yl_addon_sys_debris` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `name` varchar(50) DEFAULT NULL COMMENT '标识',
  `type` tinyint(1) DEFAULT '1' COMMENT '类型[1:图片;2:文字:3:链接;文章]',
  `cover` varchar(255) DEFAULT NULL COMMENT '图片',
  `link` varchar(1000) DEFAULT NULL,
  `content` longtext COMMENT '文章',
  `character` varchar(255) DEFAULT NULL COMMENT '文字',
  `append` int(10) DEFAULT '0',
  `updated` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
";

//执行sql
Yii::$app->getDb()->createCommand($sql)->execute();