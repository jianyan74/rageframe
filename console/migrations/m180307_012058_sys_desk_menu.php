<?php

use yii\db\Migration;

class m180307_012058_sys_desk_menu extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_desk_menu}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT COMMENT \'主键\'',
            'cover' => 'varchar(100) NULL DEFAULT \'\' COMMENT \'封面图标\'',
            'title' => 'varchar(50) NOT NULL DEFAULT \'\' COMMENT \'标题\'',
            'pid' => 'int(50) NULL DEFAULT \'0\' COMMENT \'上级id\'',
            'url' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'链接地址\'',
            'menu_css' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'样式\'',
            'sort' => 'int(5) NULL DEFAULT \'0\' COMMENT \'排序\'',
            'level' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'级别\'',
            'url_type' => 'tinyint(4) NULL DEFAULT \'1\' COMMENT \'链接类型[1:系统路由2:直接链接]\'',
            'target' => 'tinyint(4) NULL DEFAULT \'1\' COMMENT \'是否新窗口打开\'',
            'status' => 'tinyint(4) NULL DEFAULT \'1\' COMMENT \'状态[-1:删除;0:禁用;1启用]\'',
            'append' => 'int(10) NULL DEFAULT \'0\' COMMENT \'添加时间\'',
            'updated' => 'int(10) NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统_前台菜单导航表'");
        
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

