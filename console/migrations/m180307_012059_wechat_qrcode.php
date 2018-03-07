<?php

use yii\db\Migration;

class m180307_012059_wechat_qrcode extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_qrcode}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'name' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'场景名称\'',
            'keyword' => 'varchar(100) NULL COMMENT \'关联关键字\'',
            'scene_id' => 'int(10) unsigned NULL DEFAULT \'0\' COMMENT \'场景ID\'',
            'scene_str' => 'varchar(64) NULL COMMENT \'场景值\'',
            'model' => 'tinyint(1) unsigned NULL DEFAULT \'0\'',
            'ticket' => 'varchar(250) NULL DEFAULT \'\'',
            'expire_seconds' => 'int(10) unsigned NULL DEFAULT \'2592000\' COMMENT \'有效期\'',
            'subnum' => 'int(10) unsigned NULL DEFAULT \'0\'',
            'status' => 'tinyint(1) unsigned NULL DEFAULT \'1\'',
            'type' => 'varchar(10) NULL COMMENT \'二维码类型\'',
            'extra' => 'int(10) unsigned NULL',
            'url' => 'varchar(80) NULL COMMENT \'url\'',
            'end_time' => 'int(10) NULL DEFAULT \'0\'',
            'append' => 'int(10) unsigned NULL DEFAULT \'0\' COMMENT \'生成时间\'',
            'updated' => 'int(10) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信_二维码表'");
        
        /* 索引设置 */
        $this->createIndex('idx_qrcid','{{%wechat_qrcode}}','scene_id',0);
        $this->createIndex('ticket','{{%wechat_qrcode}}','ticket',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_qrcode}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

