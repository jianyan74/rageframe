<?php

$sql = "
DROP TABLE IF EXISTS `yl_addon_sys_message`;
CREATE TABLE `yl_addon_sys_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `realname` varchar(50) CHARACTER SET gbk DEFAULT NULL COMMENT '真实姓名',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号码',
  `home_phone` varchar(20) DEFAULT NULL COMMENT '电话号码',
  `content` varchar(1000) DEFAULT NULL COMMENT '内容',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `type` tinyint(1) DEFAULT '1' COMMENT '分组[1:留言建议;2:投诉]',
  `address` varchar(100) DEFAULT NULL COMMENT '地址',
  `ip` varchar(16) DEFAULT NULL COMMENT 'ip',
  `append` int(10) DEFAULT '0',
  `updated` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言投诉表';
";

//执行sql
Yii::$app->getDb()->createCommand($sql)->execute();