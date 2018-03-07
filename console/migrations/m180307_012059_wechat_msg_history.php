<?php

use yii\db\Migration;

class m180307_012059_wechat_msg_history extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_msg_history}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'rule_id' => 'int(10) unsigned NULL DEFAULT \'0\' COMMENT \'规则id\'',
            'keyword_id' => 'int(10) NULL DEFAULT \'0\' COMMENT \'关键字id\'',
            'openid' => 'varchar(50) NULL DEFAULT \'\'',
            'module' => 'varchar(50) NULL DEFAULT \'\'',
            'message' => 'varchar(1000) NULL DEFAULT \'\'',
            'type' => 'varchar(10) NULL DEFAULT \'\'',
            'append' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COMMENT='微信_历史记录表'");
        
        /* 索引设置 */
        $this->createIndex('idx_createtime','{{%wechat_msg_history}}','append',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_msg_history}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

