<?php

use yii\db\Migration;

class m170908_042133_addon_app_manual extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addon_app_manual}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(50) NOT NULL COMMENT \'标题\'',
            'name' => 'varchar(50) NULL COMMENT \'唯一标识\'',
            'pid' => 'int(50) NULL DEFAULT \'0\' COMMENT \'上级id\'',
            'content' => 'longtext NULL COMMENT \'链接地址\'',
            'sort' => 'int(5) NULL DEFAULT \'0\' COMMENT \'排序\'',
            'view' => 'int(10) NULL DEFAULT \'0\' COMMENT \'浏览量\'',
            'status' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'是否隐藏\'',
            'level' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'级别\'',
            'append' => 'int(10) NULL COMMENT \'添加时间\'',
            'updated' => 'int(10) NULL COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addon_app_manual}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

