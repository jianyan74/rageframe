<?php

$sql = "
DROP TABLE IF EXISTS `yl_addon_sys_bottom_menu`;
CREATE TABLE `yl_addon_sys_bottom_menu` (
  `single_id` int(10) NOT NULL AUTO_INCREMENT,
  `manager_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `title` varchar(50) CHARACTER SET gbk NOT NULL,
  `name` char(40) DEFAULT '' COMMENT '标识',
  `seo_key` varchar(50) DEFAULT NULL,
  `seo_content` varchar(1000) DEFAULT NULL,
  `cover` varchar(100) CHARACTER SET gbk DEFAULT '0' COMMENT '封面',
  `description` char(140) DEFAULT '' COMMENT '描述',
  `content` text COMMENT '文章内容',
  `link` varchar(100) CHARACTER SET gbk DEFAULT '' COMMENT '外链',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '可见性',
  `deadline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '截至时间',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `comment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '优先级',
  `pid` int(50) DEFAULT '0' COMMENT '上级id',
  `level` tinyint(1) DEFAULT '1' COMMENT '级别',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '数据状态[1:启用;2:禁用]',
  `append` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`single_id`),
  KEY `article_id` (`single_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='底部导航表';
";

//执行sql
Yii::$app->getDb()->createCommand($sql)->execute();