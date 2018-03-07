<?php

use yii\db\Migration;

class m180307_012101_wechat_setting extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_setting}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'history' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'历史消息参数设置\'',
            'special' => 'text NULL COMMENT \'特殊消息回复参数\'',
            'append' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'updated' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信_参数设置'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_setting}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

