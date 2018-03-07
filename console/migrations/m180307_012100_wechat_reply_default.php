<?php

use yii\db\Migration;

class m180307_012100_wechat_reply_default extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_reply_default}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'follow_content' => 'varchar(255) NULL COMMENT \'关注回复\'',
            'default_content' => 'varchar(255) NULL COMMENT \'默认回复\'',
            'append' => 'int(10) NULL',
            'updated' => 'int(10) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信_默认回复表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_reply_default}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

