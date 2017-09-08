<?php

use yii\db\Migration;

class m170908_042134_sys_article_cate extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_article_cate}}', [
            'cate_id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(50) NOT NULL COMMENT \'标题\'',
            'pid' => 'int(50) NULL DEFAULT \'0\' COMMENT \'上级id\'',
            'sort' => 'int(5) NULL DEFAULT \'0\' COMMENT \'排序\'',
            'status' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'是否隐藏\'',
            'level' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'级别\'',
            'group' => 'varchar(50) NULL COMMENT \'分组\'',
            'append' => 'int(10) NULL COMMENT \'添加时间\'',
            'updated' => 'int(10) NULL COMMENT \'修改时间\'',
            'PRIMARY KEY (`cate_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文章分类表'");
        
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

