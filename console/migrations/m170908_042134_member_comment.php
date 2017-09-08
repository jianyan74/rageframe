<?php

use yii\db\Migration;

class m170908_042134_member_comment extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%member_comment}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'member_id' => 'int(11) NOT NULL DEFAULT \'0\' COMMENT \'用户id\'',
            'type_id' => 'int(11) NOT NULL',
            'type' => 'varchar(20) NOT NULL COMMENT \'类别\'',
            'content' => 'text NOT NULL COMMENT \'内容\'',
            'pid' => 'int(11) NOT NULL DEFAULT \'0\' COMMENT \'上级id\'',
            'up' => 'int(1) NOT NULL DEFAULT \'0\' COMMENT \'点赞\'',
            'down' => 'int(1) NOT NULL DEFAULT \'0\' COMMENT \'踩\'',
            'append' => 'int(10) NOT NULL',
            'updated' => 'int(10) NOT NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='评论表'");
        
        /* 索引设置 */
        $this->createIndex('type','{{%member_comment}}','type, type_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%member_comment}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

