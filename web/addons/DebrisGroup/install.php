<?php

$sql = "
DROP TABLE IF EXISTS `yl_addon_sys_debris_group`;
CREATE TABLE `yl_addon_sys_debris_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `cover` varchar(255) DEFAULT NULL COMMENT '图片',
  `link` varchar(1000) DEFAULT NULL,
  `content` longtext COMMENT '文章',
  `character` varchar(255) DEFAULT NULL COMMENT '文字',
  `sort` int(10) DEFAULT '0',
  `cate_id` int(10) DEFAULT NULL,
  `description` varchar(1000) DEFAULT '' COMMENT '描述',
  `append` int(10) DEFAULT '0',
  `updated` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for yl_addon_sys_debris_group_cate
-- ----------------------------
DROP TABLE IF EXISTS `yl_addon_sys_debris_group_cate`;
CREATE TABLE `yl_addon_sys_debris_group_cate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `name` varchar(10) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '1',
  `sort` int(10) DEFAULT '0',
  `append` int(10) DEFAULT NULL,
  `updated` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
";

//执行sql
Yii::$app->getDb()->createCommand($sql)->execute();