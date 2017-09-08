<?php

use yii\db\Migration;

class m170908_042135_sys_notify_cate extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_notify_cate}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(20) NULL',
            'sort' => 'int(10) NULL DEFAULT \'0\'',
            'append' => 'int(10) NULL DEFAULT \'0\'',
            'updated' => 'int(10) NULL DEFAULT \'0\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='后台公告分类'");
        
        /* 索引设置 */
        $this->createIndex('tag_id','{{%sys_notify_cate}}','id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_notify_cate}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

