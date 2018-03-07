<?php

use yii\db\Migration;

class m180307_012059_wechat_attachment extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_attachment}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'manager_id' => 'int(10) unsigned NOT NULL',
            'type' => 'varchar(15) NOT NULL DEFAULT \'\'',
            'file_name' => 'varchar(255) NULL DEFAULT \'\'',
            'attachment' => 'varchar(255) NULL DEFAULT \'\'',
            'media_id' => 'varchar(255) NULL',
            'width' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'height' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'model' => 'varchar(10) NULL DEFAULT \'\'',
            'tag' => 'varchar(5000) NULL DEFAULT \'\'',
            'link_type' => 'tinyint(4) NULL DEFAULT \'1\' COMMENT \'1微信2本地\'',
            'append' => 'int(10) unsigned NULL',
            'updated' => 'int(10) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='微信_资源表'");
        
        /* 索引设置 */
        $this->createIndex('media_id','{{%wechat_attachment}}','media_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_attachment}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

