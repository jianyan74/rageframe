<?php

use yii\db\Migration;

class m180307_012058_sys_notify_cate extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_notify_cate}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT COMMENT \'主键\'',
            'title' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'标题\'',
            'sort' => 'int(10) NULL DEFAULT \'0\' COMMENT \'排序\'',
            'append' => 'int(10) NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'updated' => 'int(10) NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统_后台公告分类'");
        
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

