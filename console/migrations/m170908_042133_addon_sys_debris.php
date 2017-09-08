<?php

use yii\db\Migration;

class m170908_042133_addon_sys_debris extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addon_sys_debris}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(50) NULL COMMENT \'标题\'',
            'name' => 'varchar(50) NULL COMMENT \'标识\'',
            'type' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'类型[1:图片;2:文字:3:链接;文章]\'',
            'cover' => 'varchar(255) NULL COMMENT \'图片\'',
            'link' => 'varchar(1000) NULL',
            'content' => 'longtext NULL COMMENT \'文章\'',
            'character' => 'varchar(255) NULL COMMENT \'文字\'',
            'append' => 'int(10) NULL DEFAULT \'0\'',
            'updated' => 'int(10) NULL DEFAULT \'0\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addon_sys_debris}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

