<?php

use yii\db\Migration;

class m170908_042134_sys_article extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_article}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'manager_id' => 'int(10) unsigned NOT NULL COMMENT \'用户ID\'',
            'title' => 'varchar(50) NOT NULL COMMENT \'标题\'',
            'name' => 'char(40) NULL DEFAULT \'\' COMMENT \'标识\'',
            'cover' => 'varchar(100) NULL DEFAULT \'\' COMMENT \'封面\'',
            'seo_key' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'seo关键字\'',
            'seo_content' => 'varchar(1000) NULL DEFAULT \'\' COMMENT \'seo内容\'',
            'cate_stair' => 'int(10) unsigned NULL COMMENT \'一级分类\'',
            'cate_second' => 'int(10) NULL DEFAULT \'0\' COMMENT \'二级分类\'',
            'description' => 'char(140) NULL DEFAULT \'\' COMMENT \'描述\'',
            'position' => 'smallint(5) unsigned NOT NULL DEFAULT \'0\' COMMENT \'推荐位\'',
            'content' => 'longtext NULL COMMENT \'文章内容\'',
            'link' => 'varchar(100) NULL DEFAULT \'\' COMMENT \'外链\'',
            'display' => 'tinyint(3) NOT NULL DEFAULT \'1\' COMMENT \'可见性\'',
            'deadline' => 'int(10) unsigned NOT NULL COMMENT \'截至时间\'',
            'author' => 'varchar(40) NULL DEFAULT \'\' COMMENT \'作者\'',
            'view' => 'int(10) unsigned NOT NULL COMMENT \'浏览量\'',
            'comment' => 'int(10) unsigned NOT NULL COMMENT \'评论数\'',
            'bookmark' => 'int(10) unsigned NOT NULL COMMENT \'收藏数\'',
            'incontent' => 'tinyint(1) NULL DEFAULT \'0\' COMMENT \'1显示在文章中\'',
            'sort' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'优先级\'',
            'status' => 'tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'状态(-1:已删除,0:禁用,1:正常)\'',
            'append' => 'int(10) unsigned NOT NULL COMMENT \'创建时间\'',
            'updated' => 'int(10) unsigned NULL COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章表'");
        
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

