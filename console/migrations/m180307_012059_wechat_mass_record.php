<?php

use yii\db\Migration;

class m180307_012059_wechat_mass_record extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_mass_record}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'tag_name' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'标签名称\'',
            'fans_num' => 'int(10) unsigned NULL DEFAULT \'0\' COMMENT \'粉丝数量\'',
            'msg_id' => 'bigint(20) NULL DEFAULT \'0\'',
            'msg_type' => 'varchar(10) NULL COMMENT \'回复类别\'',
            'content' => 'varchar(10000) NULL COMMENT \'内容\'',
            'tag_id' => 'int(10) NULL DEFAULT \'0\' COMMENT \'标签id\'',
            'attach_id' => 'int(10) unsigned NULL',
            'media_id' => 'varchar(100) NULL',
            'type' => 'varchar(10) NULL DEFAULT \'\' COMMENT \'类别\'',
            'status' => 'tinyint(3) unsigned NULL DEFAULT \'1\' COMMENT \'发送状态\'',
            'cron_id' => 'int(10) unsigned NULL COMMENT \'定时任务id\'',
            'send_time' => 'int(10) unsigned NULL DEFAULT \'0\' COMMENT \'发送时间\'',
            'final_send_time' => 'int(10) unsigned NULL DEFAULT \'0\' COMMENT \'最终发送时间\'',
            'append' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信_群发记录'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_mass_record}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

