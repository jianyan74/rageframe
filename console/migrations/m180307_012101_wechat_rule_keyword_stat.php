<?php

use yii\db\Migration;

class m180307_012101_wechat_rule_keyword_stat extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_rule_keyword_stat}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'rule_id' => 'int(10) NULL DEFAULT \'0\' COMMENT \'规则id\'',
            'keyword_id' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'hit' => 'int(10) unsigned NULL DEFAULT \'1\' COMMENT \'关键字id\'',
            'append' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'updated' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信_触发关键字记录表'");
        
        /* 索引设置 */
        $this->createIndex('idx_createtime','{{%wechat_rule_keyword_stat}}','updated',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_rule_keyword_stat}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

