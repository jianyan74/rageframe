<?php

use yii\db\Migration;

class m170908_042134_sys_action_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_action_log}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'action' => 'varchar(10) NOT NULL COMMENT \'行为id\'',
            'manager_id' => 'int(10) unsigned NOT NULL COMMENT \'执行用户id\'',
            'username' => 'varchar(50) NOT NULL DEFAULT \'\' COMMENT \'用户名\'',
            'action_ip' => 'bigint(20) NOT NULL COMMENT \'执行行为者ip\'',
            'model' => 'varchar(50) NOT NULL DEFAULT \'\' COMMENT \'触发行为的表\'',
            'record_id' => 'int(10) unsigned NOT NULL COMMENT \'触发行为的数据id\'',
            'log_url' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'日志地址\'',
            'remark' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'日志备注\'',
            'country' => 'varchar(50) NULL DEFAULT \'\'',
            'province' => 'varchar(50) NULL DEFAULT \'\'',
            'city' => 'varchar(50) NULL DEFAULT \'\'',
            'district' => 'varchar(150) NULL DEFAULT \'\'',
            'status' => 'tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'状态(-1:已删除,0:禁用,1:正常)\'',
            'append' => 'int(10) unsigned NOT NULL COMMENT \'执行行为的时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='行为表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_action_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

