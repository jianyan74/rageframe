<?php

use yii\db\Migration;

class m180209_052959_sys_action_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_action_log}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT COMMENT \'主键\'',
            'action' => 'varchar(10) NOT NULL DEFAULT \'0\' COMMENT \'行为id\'',
            'manager_id' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'执行用户id\'',
            'username' => 'varchar(50) NOT NULL DEFAULT \'\' COMMENT \'用户名\'',
            'action_ip' => 'bigint(20) NOT NULL DEFAULT \'0\' COMMENT \'执行行为者ip\'',
            'model' => 'varchar(50) NOT NULL DEFAULT \'\' COMMENT \'触发行为的表\'',
            'record_id' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'触发行为的数据id\'',
            'log_url' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'日志地址\'',
            'remark' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'日志备注\'',
            'country' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'国家\'',
            'province' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'省\'',
            'city' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'市\'',
            'district' => 'varchar(150) NULL DEFAULT \'\' COMMENT \'说明\'',
            'status' => 'tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'状态[-1:删除;0:禁用;1启用]\'',
            'append' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统_行为表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%sys_action_log}}',['id'=>'43','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>'','province'=>'','city'=>'','district'=>'','status'=>'1','append'=>'1518154028']);
        
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

