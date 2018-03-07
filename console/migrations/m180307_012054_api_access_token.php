<?php

use yii\db\Migration;

class m180307_012054_api_access_token extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_access_token}}', [
            'id' => 'int(20) unsigned NOT NULL AUTO_INCREMENT',
            'refresh_token' => 'varchar(60) NULL DEFAULT \'\' COMMENT \'刷新令牌\'',
            'access_token' => 'varchar(60) NULL DEFAULT \'\' COMMENT \'授权令牌\'',
            'group' => 'tinyint(4) NULL DEFAULT \'1\' COMMENT \'组别[1会员]\'',
            'user_id' => 'bigint(20) NULL DEFAULT \'0\' COMMENT \'关联的用户id\'',
            'status' => 'tinyint(4) NOT NULL DEFAULT \'10\' COMMENT \'用户状态\'',
            'allowance' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'规定时间可获取次数\'',
            'allowance_updated_at' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'最后一次提交时间\'',
            'created_at' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'updated_at' => 'int(10) NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='api_授权秘钥表'");
        
        /* 索引设置 */
        $this->createIndex('access_token','{{%api_access_token}}','access_token',1);
        $this->createIndex('refresh_token','{{%api_access_token}}','refresh_token',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%api_access_token}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

