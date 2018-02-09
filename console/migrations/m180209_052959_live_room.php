<?php

use yii\db\Migration;

class m180209_052959_live_room extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%live_room}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'member_id' => 'int(10) NULL DEFAULT \'0\' COMMENT \'会员id\'',
            'title' => 'varchar(100) NULL DEFAULT \'\' COMMENT \'房间名称\'',
            'onlookers_num' => 'int(10) NULL DEFAULT \'0\' COMMENT \'观众数量\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='直播_房间表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%live_room}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

