<?php

use yii\db\Migration;

class m180307_012101_wxapp_general_analysis extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wxapp_general_analysis}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'session_cnt' => 'int(10) NOT NULL',
            'visit_pv' => 'int(10) NOT NULL COMMENT \'浏览量\'',
            'visit_uv' => 'int(10) NOT NULL',
            'visit_uv_new' => 'int(10) NOT NULL',
            'type' => 'tinyint(2) NOT NULL',
            'stay_time_uv' => 'varchar(10) NOT NULL',
            'stay_time_session' => 'varchar(10) NOT NULL',
            'visit_depth' => 'varchar(10) NOT NULL',
            'ref_date' => 'varchar(8) NOT NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小程序_统计'");
        
        /* 索引设置 */
        $this->createIndex('ref_date','{{%wxapp_general_analysis}}','ref_date',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wxapp_general_analysis}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

