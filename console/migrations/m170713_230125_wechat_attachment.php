<?php

use yii\db\Migration;

class m170713_230125_wechat_attachment extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_attachment}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'manager_id' => 'int(10) unsigned NOT NULL',
            'filename' => 'varchar(255) NOT NULL',
            'attachment' => 'varchar(255) NOT NULL',
            'media_id' => 'varchar(255) NOT NULL',
            'width' => 'int(10) unsigned NOT NULL',
            'height' => 'int(10) unsigned NOT NULL',
            'type' => 'varchar(15) NOT NULL',
            'model' => 'varchar(25) NOT NULL',
            'tag' => 'varchar(5000) NOT NULL',
            'append' => 'int(10) unsigned NOT NULL',
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

