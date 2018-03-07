<?php

use yii\db\Migration;

class m180307_012058_sys_manager extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_manager}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'username' => 'varchar(20) NOT NULL DEFAULT \'\' COMMENT \'帐号\'',
            'password_hash' => 'varchar(255) NOT NULL COMMENT \'密码\'',
            'auth_key' => 'varchar(32) NOT NULL COMMENT \'授权令牌\'',
            'password_reset_token' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'密码重置令牌\'',
            'type' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'1:普通管理员;10超级管理员\'',
            'realname' => 'varchar(10) NULL COMMENT \'真实姓名\'',
            'head_portrait' => 'char(255) NULL DEFAULT \'\'',
            'sex' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'1:男;2:女\'',
            'qq' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'qq\'',
            'email' => 'varchar(60) NULL DEFAULT \'\' COMMENT \'邮箱\'',
            'birthday' => 'date NULL COMMENT \'生日\'',
            'user_integral' => 'int(11) NULL DEFAULT \'0\' COMMENT \'当前积分\'',
            'provinces' => 'varchar(10) NULL DEFAULT \'\'',
            'city' => 'varchar(10) NULL',
            'area' => 'varchar(10) NULL',
            'address' => 'varchar(100) NULL DEFAULT \'\' COMMENT \'默认地址\'',
            'visit_count' => 'smallint(5) unsigned NULL DEFAULT \'0\' COMMENT \'访问次数\'',
            'home_phone' => 'varchar(20) NULL COMMENT \'家庭号码\'',
            'mobile_phone' => 'varchar(20) NULL COMMENT \'手机号码\'',
            'role' => 'smallint(6) NULL DEFAULT \'10\' COMMENT \'权限\'',
            'status' => 'smallint(6) NOT NULL DEFAULT \'10\' COMMENT \'状态\'',
            'last_time' => 'int(10) NULL COMMENT \'最后一次登陆时间\'',
            'last_ip' => 'varchar(16) NULL DEFAULT \'\' COMMENT \'最后一次登陆ip\'',
            'created_at' => 'int(11) NOT NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'updated_at' => 'int(11) NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统_后台管理员表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%sys_manager}}',['id'=>'1','username'=>'admin','password_hash'=>'$2y$13$QJuIyPZ7yBo1PKXls2DQM.XS5r8GFnEsUzeASPzRUihMU2RakdsHm','auth_key'=>'z6lrwixmdNF4VqtkXw6z-3vMZdSdngm2','password_reset_token'=>'','type'=>'10','realname'=>'简言','head_portrait'=>'','sex'=>'1','qq'=>'751393839','email'=>'','birthday'=>'2017-02-25','user_integral'=>'0','provinces'=>'330000','city'=>'330200','area'=>'330203','address'=>'大潮街道666号','visit_count'=>'0','home_phone'=>'','mobile_phone'=>'','role'=>'10','status'=>'10','last_time'=>'1520385301','last_ip'=>'127.0.0.1','created_at'=>'1449114934','updated_at'=>'1520385301']);
        $this->insert('{{%sys_manager}}',['id'=>'2','username'=>'test','password_hash'=>'$2y$13$EZXa9i.sHX3VD9JeknGm9OciQeuuQyDuuB2/Oy7LnYGK6Jz/DMrki','auth_key'=>'iWVr_tcZ3NI8MJ_RwE1mBZ0P3iL2O5p9','password_reset_token'=>'','type'=>'1','realname'=>'123','head_portrait'=>'','sex'=>'1','qq'=>'','email'=>'','birthday'=>'2017-09-30','user_integral'=>'0','provinces'=>'220000','city'=>'220300','area'=>'220303','address'=>'','visit_count'=>'0','home_phone'=>'','mobile_phone'=>'','role'=>'10','status'=>'10','last_time'=>'1516176774','last_ip'=>'127.0.0.1','created_at'=>'1490081473','updated_at'=>'1516176774']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_manager}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

