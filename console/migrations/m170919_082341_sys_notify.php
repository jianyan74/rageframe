<?php

use yii\db\Migration;

class m170919_082341_sys_notify extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_notify}}', [
            'id' => 'bigint(20) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(255) NULL COMMENT \'标题\'',
            'content' => 'text NULL COMMENT \'消息内容\'',
            'type' => 'tinyint(1) NULL DEFAULT \'0\' COMMENT \'消息类型:1: 公告 Announce，2: 提醒 Remind，3：信息 Message\'',
            'announce_type' => 'tinyint(1) NULL DEFAULT \'0\' COMMENT \'公告类型\'',
            'target' => 'int(10) NULL DEFAULT \'0\' COMMENT \'目标id\'',
            'target_type' => 'varchar(100) NULL COMMENT \'目标类型\'',
            'target_display' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'接受者是否删除\'',
            'action' => 'varchar(100) NULL COMMENT \'动作类型\'',
            'sender' => 'int(10) NULL DEFAULT \'0\' COMMENT \'发送者id\'',
            'view' => 'int(10) NULL DEFAULT \'0\' COMMENT \'浏览量\'',
            'sender_display' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'发送者是否删除\'',
            'is_withdraw' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'是否撤回 -1是撤回\'',
            'updated' => 'int(10) NULL',
            'append' => 'int(10) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='消息表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%sys_notify}}',['id'=>'1','title'=>'重大事件','content'=>'<p>重大事件！！！！！！！！<br/></p>','type'=>'1','announce_type'=>'1','target'=>'0','target_type'=>NULL,'target_display'=>'1','action'=>NULL,'sender'=>'1','view'=>'2','sender_display'=>'1','is_withdraw'=>'1','updated'=>'1500166656','append'=>'1500166656']);
        $this->insert('{{%sys_notify}}',['id'=>'2','title'=>'又来了一条公告','content'=>'<p>又来了一条公告</p>','type'=>'1','announce_type'=>'1','target'=>'0','target_type'=>NULL,'target_display'=>'1','action'=>NULL,'sender'=>'1','view'=>'2','sender_display'=>'1','is_withdraw'=>'1','updated'=>'1503480253','append'=>'1503480253']);
        $this->insert('{{%sys_notify}}',['id'=>'3','title'=>NULL,'content'=>'我想和你说说话','type'=>'3','announce_type'=>'0','target'=>'2','target_type'=>'manager','target_display'=>'1','action'=>NULL,'sender'=>'1','view'=>'0','sender_display'=>'1','is_withdraw'=>'1','updated'=>'1503480328','append'=>'1503480328']);
        
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

