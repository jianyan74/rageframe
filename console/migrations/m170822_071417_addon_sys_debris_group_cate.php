<?php

use yii\db\Migration;

class m170822_071417_addon_sys_debris_group_cate extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addon_sys_debris_group_cate}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(50) NULL',
            'name' => 'varchar(10) NULL',
            'type' => 'tinyint(4) NULL DEFAULT \'1\'',
            'sort' => 'int(10) NULL DEFAULT \'0\'',
            'append' => 'int(10) NULL',
            'updated' => 'int(10) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addon_sys_debris_group_cate}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

