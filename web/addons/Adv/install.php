<?php

$sql = "
DROP TABLE IF EXISTS `yl_addon_sys_adv`;
CREATE TABLE `yl_addon_sys_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `title` varchar(30) NOT NULL COMMENT '标题',
  `cover` varchar(100) DEFAULT NULL COMMENT '图片',
  `location_id` int(11) DEFAULT '0' COMMENT '广告位ID',
  `silder_text` varchar(255) DEFAULT ' ' COMMENT '图片描述',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  `jump_link` varchar(255) DEFAULT NULL COMMENT '跳转链接',
  `jump_type` tinyint(1) DEFAULT '1' COMMENT '跳转方式[1:新标签; 2:当前页]',
  `sort` int(5) DEFAULT '0' COMMENT '优先级（0-9）',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态（-1：禁用，1：正常）',
  `groups` tinyint(5) DEFAULT '0' COMMENT '幻灯片分组',
  `append` int(10) DEFAULT NULL COMMENT '创建时间',
  `updated` int(10) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='广告表';

-- ----------------------------
-- Table structure for yl_sys_adv_location
-- ----------------------------
DROP TABLE IF EXISTS `yl_addon_sys_adv_location`;
CREATE TABLE `yl_addon_sys_adv_location` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL COMMENT '标题',
  `name` varchar(30) NOT NULL COMMENT '标识',
  `sort` int(5) DEFAULT '0' COMMENT '优先级（0-9）',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态（-1：禁用，1：正常）',
  `append` int(10) DEFAULT NULL COMMENT '创建时间',
  `updated` int(10) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='广告位置表';
";

//执行sql
Yii::$app->getDb()->createCommand($sql)->execute();