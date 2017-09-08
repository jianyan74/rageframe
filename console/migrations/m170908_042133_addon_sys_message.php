<?php

use yii\db\Migration;

class m170908_042133_addon_sys_message extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addon_sys_message}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'realname' => 'varchar(50) NULL COMMENT \'真实姓名\'',
            'mobile' => 'varchar(11) NULL COMMENT \'手机号码\'',
            'home_phone' => 'varchar(20) NULL COMMENT \'电话号码\'',
            'content' => 'varchar(1000) NULL COMMENT \'内容\'',
            'status' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'状态\'',
            'type' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'分组[1:留言建议;2:投诉]\'',
            'address' => 'varchar(100) NULL COMMENT \'地址\'',
            'ip' => 'varchar(16) NULL COMMENT \'ip\'',
            'append' => 'int(10) NULL DEFAULT \'0\'',
            'updated' => 'int(10) NULL DEFAULT \'0\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言投诉表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addon_sys_message}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

