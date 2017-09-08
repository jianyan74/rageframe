<?php

use yii\db\Migration;

class m170908_042133_common_sms_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%common_sms_log}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'mobile' => 'varchar(11) NULL DEFAULT \'\' COMMENT \'手机号码\'',
            'code' => 'int(10) NULL DEFAULT \'0\' COMMENT \'验证码\'',
            'append' => 'int(10) NULL DEFAULT \'0\' COMMENT \'添加时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='通用_短信发送日志表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%common_sms_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

