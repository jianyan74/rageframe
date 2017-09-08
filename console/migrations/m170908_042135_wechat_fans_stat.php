<?php

use yii\db\Migration;

class m170908_042135_wechat_fans_stat extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_fans_stat}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'new_attention' => 'int(10) unsigned NOT NULL COMMENT \'今日新关注\'',
            'cancel_attention' => 'int(10) unsigned NOT NULL COMMENT \'今日取消关注\'',
            'cumulate_attention' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'累计关注\'',
            'date' => 'date NOT NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信关注统计表'");
        
        /* 索引设置 */
        $this->createIndex('uniacid','{{%wechat_fans_stat}}','date',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_fans_stat}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

