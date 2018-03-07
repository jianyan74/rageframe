<?php

use yii\db\Migration;

class m180307_012101_wxapp_account extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wxapp_account}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'addon_name' => 'varchar(20) NULL COMMENT \'模块名称\'',
            'token' => 'varchar(32) NULL',
            'encodingaeskey' => 'varchar(43) NULL',
            'level' => 'tinyint(4) NULL DEFAULT \'1\'',
            'account' => 'varchar(30) NULL',
            'original' => 'varchar(50) NULL',
            'key' => 'varchar(50) NULL',
            'secret' => 'varchar(50) NULL DEFAULT \'\'',
            'name' => 'varchar(30) NULL DEFAULT \'\'',
            'status' => 'tinyint(4) NULL DEFAULT \'1\' COMMENT \'状态[-1:删除;0:禁用;1启用]\'',
            'append' => 'int(10) NULL',
            'updated' => 'int(10) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='小程序_账号'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wxapp_account}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

