<?php

use yii\db\Migration;

class m180307_012101_wechat_rule_stat extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_rule_stat}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'rule_id' => 'int(10) unsigned NULL DEFAULT \'0\' COMMENT \'规则id\'',
            'hit' => 'int(10) unsigned NULL DEFAULT \'1\'',
            'append' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'updated' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信_触发规则记录表'");
        
        /* 索引设置 */
        $this->createIndex('idx_createtime','{{%wechat_rule_stat}}','updated',0);
        $this->createIndex('rid','{{%wechat_rule_stat}}','rule_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_rule_stat}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

