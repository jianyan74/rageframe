<?php

use yii\db\Migration;

class m180307_012058_sys_notify extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_notify}}', [
            'id' => 'bigint(20) NOT NULL AUTO_INCREMENT COMMENT \'主键\'',
            'title' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'标题\'',
            'content' => 'text NULL COMMENT \'消息内容\'',
            'type' => 'tinyint(1) NULL DEFAULT \'0\' COMMENT \'消息类型[1:公告 Announce;2:提醒 Remind;3:信息 Message]\'',
            'announce_type' => 'tinyint(1) NULL DEFAULT \'0\' COMMENT \'公告类型\'',
            'target' => 'int(10) NULL DEFAULT \'0\' COMMENT \'目标id\'',
            'target_type' => 'varchar(100) NULL DEFAULT \'\' COMMENT \'目标类型\'',
            'target_display' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'接受者是否删除\'',
            'action' => 'varchar(100) NULL DEFAULT \'\' COMMENT \'动作类型\'',
            'sender' => 'int(10) NULL DEFAULT \'0\' COMMENT \'发送者id\'',
            'view' => 'int(10) NULL DEFAULT \'0\' COMMENT \'浏览量\'',
            'sender_display' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'发送者是否删除\'',
            'is_withdraw' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'是否撤回 -1是撤回\'',
            'updated' => 'int(10) NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'append' => 'int(10) NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统_消息公告表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_notify}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

