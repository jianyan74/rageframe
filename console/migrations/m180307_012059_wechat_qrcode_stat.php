<?php

use yii\db\Migration;

class m180307_012059_wechat_qrcode_stat extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_qrcode_stat}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'qrcord_id' => 'int(10) unsigned NULL',
            'openid' => 'varchar(50) NULL DEFAULT \'\'',
            'type' => 'tinyint(1) unsigned NULL DEFAULT \'0\' COMMENT \'1:关注 2:扫描\'',
            'name' => 'varchar(50) NULL DEFAULT \'\'',
            'scene_str' => 'varchar(64) NULL',
            'scene_id' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'append' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信_二维码扫描记录表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_qrcode_stat}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

