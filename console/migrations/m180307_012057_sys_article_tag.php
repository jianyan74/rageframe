<?php

use yii\db\Migration;

class m180307_012057_sys_article_tag extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_article_tag}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT COMMENT \'主键\'',
            'title' => 'varchar(20) NOT NULL COMMENT \'标题\'',
            'sort' => 'int(10) NULL DEFAULT \'0\' COMMENT \'排序\'',
            'status' => 'tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'状态(-1:已删除,0:禁用,1:正常)\'',
            'append' => 'int(10) NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'updated' => 'int(10) NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统_标签表'");
        
        /* 索引设置 */
        $this->createIndex('tag_id','{{%sys_article_tag}}','id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_article_tag}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

