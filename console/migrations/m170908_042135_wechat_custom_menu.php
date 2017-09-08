<?php

use yii\db\Migration;

class m170908_042135_wechat_custom_menu extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_custom_menu}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT COMMENT \'公众号id\'',
            'menu_id' => 'int(10) unsigned NULL',
            'type' => 'tinyint(3) unsigned NULL DEFAULT \'1\' COMMENT \'1:默认菜单；3个性化菜单\'',
            'title' => 'varchar(30) NULL',
            'sex' => 'tinyint(3) unsigned NULL',
            'group_id' => 'int(10) NULL',
            'client_platform_type' => 'tinyint(3) unsigned NULL',
            'area' => 'varchar(50) NULL',
            'data' => 'text NULL',
            'menu_data' => 'text NULL COMMENT \'微信菜单\'',
            'status' => 'tinyint(3) NULL DEFAULT \'-1\' COMMENT \'是否启用\'',
            'append' => 'int(10) unsigned NULL',
            'updated' => 'int(10) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信_自定义菜单'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_custom_menu}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

