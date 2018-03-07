<?php

use yii\db\Migration;

class m180307_012056_sys_article extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_article}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'manager_id' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'用户ID\'',
            'title' => 'varchar(50) NOT NULL COMMENT \'标题\'',
            'name' => 'char(40) NULL DEFAULT \'\' COMMENT \'标识\'',
            'cover' => 'varchar(100) NULL DEFAULT \'\' COMMENT \'封面\'',
            'seo_key' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'seo关键字\'',
            'seo_content' => 'varchar(1000) NULL DEFAULT \'\' COMMENT \'seo内容\'',
            'cate_id' => 'int(10) NULL DEFAULT \'0\' COMMENT \'分类id\'',
            'description' => 'char(140) NULL DEFAULT \'\' COMMENT \'描述\'',
            'position' => 'smallint(5) NOT NULL DEFAULT \'0\' COMMENT \'推荐位\'',
            'content' => 'longtext NULL COMMENT \'文章内容\'',
            'link' => 'varchar(100) NULL DEFAULT \'\' COMMENT \'外链\'',
            'deadline' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'截至时间\'',
            'author' => 'varchar(40) NULL DEFAULT \'\' COMMENT \'作者\'',
            'view' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'浏览量\'',
            'comment' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'评论数\'',
            'bookmark' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'收藏数\'',
            'incontent' => 'tinyint(1) NULL DEFAULT \'0\' COMMENT \'1显示在文章中\'',
            'sort' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'优先级\'',
            'status' => 'tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'状态[-1:删除;0:禁用;1启用]\'',
            'append' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'updated' => 'int(10) NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统_文章表'");
        
        /* 索引设置 */
        $this->createIndex('article_id','{{%sys_article}}','id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_article}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

