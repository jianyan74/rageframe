<?php

use yii\db\Migration;

class m180307_012057_sys_article_cate extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_article_cate}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT COMMENT \'主键\'',
            'title' => 'varchar(50) NOT NULL DEFAULT \'\' COMMENT \'标题\'',
            'pid' => 'int(50) NULL DEFAULT \'0\' COMMENT \'上级id\'',
            'sort' => 'int(5) NULL DEFAULT \'0\' COMMENT \'排序\'',
            'level' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'级别\'',
            'group' => 'varchar(50) NULL DEFAULT \'0\' COMMENT \'分组\'',
            'status' => 'tinyint(4) NULL DEFAULT \'1\' COMMENT \'状态[-1:删除;0:禁用;1启用]\'',
            'append' => 'int(10) NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'updated' => 'int(10) NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统_文章分类表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_article_cate}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

