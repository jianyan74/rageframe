<?php

use yii\db\Migration;

class m180307_012056_member_address extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%member_address}}', [
            'id' => 'bigint(20) NOT NULL AUTO_INCREMENT COMMENT \'主键\'',
            'member_id' => 'int(11) NULL DEFAULT \'0\' COMMENT \'用户id\'',
            'provinces' => 'int(10) NULL DEFAULT \'0\' COMMENT \'省id\'',
            'city' => 'int(10) NULL DEFAULT \'0\' COMMENT \'市id\'',
            'area' => 'int(10) NULL DEFAULT \'0\' COMMENT \'区id\'',
            'detailed_address' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'详细地址\'',
            'realname' => 'varchar(100) NULL DEFAULT \'\' COMMENT \'真实姓名\'',
            'telephone' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'家庭号码\'',
            'mobile' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'手机号码\'',
            'append' => 'int(10) NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'updated' => 'int(10) NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户_收货地址表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%member_address}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

