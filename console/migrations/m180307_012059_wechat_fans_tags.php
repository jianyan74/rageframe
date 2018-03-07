<?php

use yii\db\Migration;

class m180307_012059_wechat_fans_tags extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_fans_tags}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'tags' => 'text NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信_粉丝标签表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_fans_tags}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

