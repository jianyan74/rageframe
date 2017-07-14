<?php

use yii\db\Migration;

class m170713_230125_sys_news extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_news}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(50) NULL',
            'zuozhe' => 'varchar(20) NULL',
            'content' => 'text NULL',
            'view' => 'int(10) NULL DEFAULT \'0\' COMMENT \'浏览量\'',
            'group' => 'tinyint(1) NULL COMMENT \'分组\'',
            'status' => 'tinyint(1) NULL DEFAULT \'1\'',
            'append' => 'int(10) NULL DEFAULT \'0\'',
            'updated' => 'int(10) NULL DEFAULT \'0\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='新闻表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_news}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

