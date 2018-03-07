<?php

use yii\db\Migration;

class m180307_012101_wxapp_versions extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wxapp_versions}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'account_id' => 'int(10) NULL DEFAULT \'0\' COMMENT \'小程序id\'',
            'version' => 'varchar(10) NULL',
            'description' => 'varchar(255) NULL',
            'modules' => 'varchar(1000) NULL',
            'design_method' => 'tinyint(1) NULL DEFAULT \'3\'',
            'quickmenu' => 'varchar(2500) NULL DEFAULT \'\'',
            'append' => 'int(10) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='小程序_版本表'");
        
        /* 索引设置 */
        $this->createIndex('version','{{%wxapp_versions}}','version',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wxapp_versions}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

