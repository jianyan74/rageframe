<?php

use yii\db\Migration;

class m171117_023237_api_access_token extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_access_token}}', [
            'id' => 'int(20) unsigned NOT NULL AUTO_INCREMENT',
            'access_token' => 'varchar(60) NULL DEFAULT \'\'',
            'group' => 'tinyint(4) NULL DEFAULT \'1\' COMMENT \'组别(默认为会员:1)\'',
            'user_id' => 'bigint(20) NULL COMMENT \'关联的用户id\'',
            'status' => 'smallint(6) NOT NULL DEFAULT \'10\' COMMENT \'用户状态\'',
            'allowance' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'规定时间可获取次数\'',
            'allowance_updated_at' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'最后一次提交时间\'',
            'updated_at' => 'int(10) NULL DEFAULT \'0\' COMMENT \'更新时间\'',
            'created_at' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='api_授权秘钥表'");
        
        /* 索引设置 */
        $this->createIndex('access_token','{{%api_access_token}}','access_token',1);
        
        
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

