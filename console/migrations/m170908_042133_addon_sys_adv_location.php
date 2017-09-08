<?php

use yii\db\Migration;

class m170908_042133_addon_sys_adv_location extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addon_sys_adv_location}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(30) NOT NULL COMMENT \'标题\'',
            'name' => 'varchar(30) NOT NULL COMMENT \'标识\'',
            'sort' => 'int(5) NULL DEFAULT \'0\' COMMENT \'优先级（0-9）\'',
            'status' => 'tinyint(2) NULL DEFAULT \'1\' COMMENT \'状态（-1：禁用，1：正常）\'',
            'append' => 'int(10) NULL COMMENT \'创建时间\'',
            'updated' => 'int(10) NULL COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告位置表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addon_sys_adv_location}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

