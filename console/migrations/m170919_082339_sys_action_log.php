<?php

use yii\db\Migration;

class m170919_082339_sys_action_log extends Migration
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
        $this->insert('{{%sys_action_log}}',['id'=>'20','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503138071']);
        $this->insert('{{%sys_action_log}}',['id'=>'21','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503191606']);
        $this->insert('{{%sys_action_log}}',['id'=>'22','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503307707']);
        $this->insert('{{%sys_action_log}}',['id'=>'23','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'1034821290','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>'中国','province'=>'浙江','city'=>'宁波','district'=>'','status'=>'1','append'=>'1503308746']);
        $this->insert('{{%sys_action_log}}',['id'=>'24','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503357386']);
        $this->insert('{{%sys_action_log}}',['id'=>'25','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503363103']);
        $this->insert('{{%sys_action_log}}',['id'=>'26','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503363974']);
        $this->insert('{{%sys_action_log}}',['id'=>'27','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503366180']);
        $this->insert('{{%sys_action_log}}',['id'=>'28','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503366369']);
        $this->insert('{{%sys_action_log}}',['id'=>'29','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503366549']);
        $this->insert('{{%sys_action_log}}',['id'=>'30','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503384289']);
        $this->insert('{{%sys_action_log}}',['id'=>'31','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'1034821290','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>'中国','province'=>'浙江','city'=>'宁波','district'=>'','status'=>'1','append'=>'1503384351']);
        $this->insert('{{%sys_action_log}}',['id'=>'32','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503385030']);
        $this->insert('{{%sys_action_log}}',['id'=>'33','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503405639']);
        $this->insert('{{%sys_action_log}}',['id'=>'34','action'=>'login','manager_id'=>'2','username'=>'test','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503407693']);
        $this->insert('{{%sys_action_log}}',['id'=>'35','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503576547']);
        $this->insert('{{%sys_action_log}}',['id'=>'36','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503579281']);
        $this->insert('{{%sys_action_log}}',['id'=>'37','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503579293']);
        $this->insert('{{%sys_action_log}}',['id'=>'38','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503579440']);
        $this->insert('{{%sys_action_log}}',['id'=>'39','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503579449']);
        $this->insert('{{%sys_action_log}}',['id'=>'40','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503581204']);
        $this->insert('{{%sys_action_log}}',['id'=>'41','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503638823']);
        $this->insert('{{%sys_action_log}}',['id'=>'42','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503741012']);
        $this->insert('{{%sys_action_log}}',['id'=>'43','action'=>'login','manager_id'=>'2','username'=>'test','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503741021']);
        $this->insert('{{%sys_action_log}}',['id'=>'44','action'=>'logout','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503742860']);
        $this->insert('{{%sys_action_log}}',['id'=>'45','action'=>'login','manager_id'=>'2','username'=>'test','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503742869']);
        $this->insert('{{%sys_action_log}}',['id'=>'46','action'=>'logout','manager_id'=>'2','username'=>'test','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/logout.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503755209']);
        $this->insert('{{%sys_action_log}}',['id'=>'47','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>NULL,'province'=>NULL,'city'=>NULL,'district'=>NULL,'status'=>'1','append'=>'1503755219']);
        $this->insert('{{%sys_action_log}}',['id'=>'48','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'666583546','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>'中国','province'=>'浙江','city'=>'宁波','district'=>'','status'=>'1','append'=>'1503758634']);
        $this->insert('{{%sys_action_log}}',['id'=>'49','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'1034821290','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>'中国','province'=>'浙江','city'=>'宁波','district'=>'','status'=>'1','append'=>'1504229782']);
        $this->insert('{{%sys_action_log}}',['id'=>'50','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'1034821290','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>'中国','province'=>'浙江','city'=>'宁波','district'=>'','status'=>'1','append'=>'1504661710']);
        $this->insert('{{%sys_action_log}}',['id'=>'51','action'=>'login','manager_id'=>'1','username'=>'admin','action_ip'=>'2130706433','model'=>'manager','record_id'=>'0','log_url'=>'/backend/site/login.html','remark'=>NULL,'country'=>'','province'=>'','city'=>'','district'=>'','status'=>'1','append'=>'1505809027']);
        
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

