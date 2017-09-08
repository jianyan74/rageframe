<?php

use yii\db\Migration;

class m170908_042134_sys_desk_menu extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_desk_menu}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'cover' => 'varchar(100) NULL DEFAULT \'\' COMMENT \'封面图标\'',
            'title' => 'varchar(50) NOT NULL DEFAULT \'\' COMMENT \'标题\'',
            'pid' => 'int(50) NULL DEFAULT \'0\' COMMENT \'上级id\'',
            'url' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'链接地址\'',
            'menu_css' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'样式\'',
            'sort' => 'int(5) NULL DEFAULT \'0\' COMMENT \'排序\'',
            'level' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'级别\'',
            'status' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'是否隐藏\'',
            'append' => 'int(10) NULL COMMENT \'添加时间\'',
            'updated' => 'int(10) NULL COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统菜单导航表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_desk_menu}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

