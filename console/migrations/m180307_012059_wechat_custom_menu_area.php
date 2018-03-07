<?php

use yii\db\Migration;

class m180307_012059_wechat_custom_menu_area extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_custom_menu_area}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(100) NOT NULL DEFAULT \'\' COMMENT \'标题\'',
            'pid' => 'int(10) NULL DEFAULT \'0\' COMMENT \'父级id\'',
            'level' => 'tinyint(4) NULL DEFAULT \'1\' COMMENT \'级别\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='微信_自定义菜单_省市'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_custom_menu_area}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

