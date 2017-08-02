<?php

use yii\db\Migration;

class m170802_011259_sys_action_log extends Migration
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
        $this->insert('{{%sys_action_log}}',['id'=>'1','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1500165813']);
        $this->insert('{{%sys_action_log}}',['id'=>'2','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1500165836']);
        $this->insert('{{%sys_action_log}}',['id'=>'3','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'1034821290','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>'中国','province'=>'浙江','city'=>'宁波','district'=>'','status'=>'1','append'=>'1500430570']);
        $this->insert('{{%sys_action_log}}',['id'=>'4','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'666583544','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>'中国','province'=>'浙江','city'=>'宁波','district'=>'','status'=>'1','append'=>'1500712659']);
        $this->insert('{{%sys_action_log}}',['id'=>'5','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1500861563']);
        $this->insert('{{%sys_action_log}}',['id'=>'6','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'1034821290','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>'中国','province'=>'浙江','city'=>'宁波','district'=>'','status'=>'1','append'=>'1500949505']);
        $this->insert('{{%sys_action_log}}',['id'=>'7','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1501036802']);
        $this->insert('{{%sys_action_log}}',['id'=>'8','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1501037412']);
        $this->insert('{{%sys_action_log}}',['id'=>'9','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'1034821290','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>'中国','province'=>'浙江','city'=>'宁波','district'=>'','status'=>'1','append'=>'1501038903']);
        $this->insert('{{%sys_action_log}}',['id'=>'10','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1501076691']);
        $this->insert('{{%sys_action_log}}',['id'=>'11','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1501076738']);
        $this->insert('{{%sys_action_log}}',['id'=>'12','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1501117086']);
        $this->insert('{{%sys_action_log}}',['id'=>'13','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1501121292']);
        $this->insert('{{%sys_action_log}}',['id'=>'14','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'666583510','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>'中国','province'=>'浙江','city'=>'宁波','district'=>'','status'=>'1','append'=>'1501330266']);
        $this->insert('{{%sys_action_log}}',['id'=>'15','action'=>'login','manager_id'=>'2','username'=>'test','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1501624395']);
        $this->insert('{{%sys_action_log}}',['id'=>'16','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1501636153']);
        
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

