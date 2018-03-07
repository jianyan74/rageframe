<?php

use yii\db\Migration;

class m180307_012059_wechat_news extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_news}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'attach_id' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'title' => 'varchar(50) NOT NULL DEFAULT \'\' COMMENT \'标题\'',
            'thumb_media_id' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'图文消息的封面图片素材id（必须是永久mediaID）\'',
            'thumb_url' => 'varchar(255) NULL DEFAULT \'\'',
            'author' => 'varchar(64) NULL COMMENT \'作者\'',
            'digest' => 'varchar(255) NULL DEFAULT \'\'',
            'show_cover_pic' => 'tinyint(4) NULL DEFAULT \'0\' COMMENT \'0为false，即不显示，1为true，即显示\'',
            'content' => 'mediumtext NULL COMMENT \'图文消息的具体内容，支持HTML标签，必须少于2万字符\'',
            'content_source_url' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'图文消息的原文地址，即点击“阅读原文”后的URL\'',
            'url' => 'varchar(255) NULL DEFAULT \'\'',
            'sort' => 'int(11) NULL DEFAULT \'0\'',
            'append' => 'int(10) NULL',
            'updated' => 'int(10) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='微信_文章表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_news}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

