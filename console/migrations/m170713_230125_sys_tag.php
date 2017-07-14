<?php

use yii\db\Migration;

class m170713_230125_sys_tag extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_tag}}', [
            'tag_id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(20) NULL',
            'sort' => 'int(10) NULL DEFAULT \'0\'',
            'status' => 'tinyint(2) NULL DEFAULT \'1\'',
            'append' => 'int(10) NULL DEFAULT \'0\'',
            'updated' => 'int(10) NULL DEFAULT \'0\'',
            'PRIMARY KEY (`tag_id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='标签表'");
        
        /* 索引设置 */
        $this->createIndex('tag_id','{{%sys_tag}}','tag_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_tag}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

