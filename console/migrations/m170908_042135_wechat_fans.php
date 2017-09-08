<?php

use yii\db\Migration;

class m170908_042135_wechat_fans extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_fans}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'member_id' => 'int(10) unsigned NULL',
            'unionid' => 'varchar(64) NULL COMMENT \'唯一公众号ID\'',
            'openid' => 'varchar(50) NOT NULL',
            'nickname' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'昵称\'',
            'headimgurl' => 'varchar(255) NULL DEFAULT \'\'',
            'sex' => 'tinyint(2) NULL DEFAULT \'0\' COMMENT \'性别\'',
            'follow' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'是否关注 0取消关注\'',
            'followtime' => 'int(10) unsigned NULL COMMENT \'关注时间\'',
            'unfollowtime' => 'int(10) unsigned NULL COMMENT \'取消关注时间\'',
            'tag' => 'varchar(1000) NULL COMMENT \'标签\'',
            'group_id' => 'int(10) unsigned NULL COMMENT \'用户分组\'',
            'last_longitude' => 'varchar(10) NULL COMMENT \'最后一次经纬度上报\'',
            'last_latitude' => 'varchar(10) NULL COMMENT \'最后一次经纬度上报\'',
            'last_address' => 'varchar(100) NULL COMMENT \'最后一次经纬度上报地址\'',
            'last_updated' => 'int(10) NULL',
            'country' => 'varchar(100) NULL',
            'province' => 'varchar(100) NULL',
            'city' => 'varchar(100) NULL',
            'append' => 'int(10) unsigned NULL',
            'updated' => 'int(10) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COMMENT='微信_粉丝表'");
        
        /* 索引设置 */
        $this->createIndex('openid','{{%wechat_fans}}','openid',0);
        $this->createIndex('updatetime','{{%wechat_fans}}','append',0);
        $this->createIndex('nickname','{{%wechat_fans}}','nickname',0);
        $this->createIndex('uid','{{%wechat_fans}}','member_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_fans}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

