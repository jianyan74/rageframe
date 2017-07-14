<?php

use yii\db\Migration;

class m170713_230125_sys_manager extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_manager}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'username' => 'varchar(20) NOT NULL DEFAULT \'\' COMMENT \'帐号\'',
            'password_hash' => 'varchar(255) NOT NULL',
            'auth_key' => 'varchar(32) NOT NULL',
            'password_reset_token' => 'varchar(255) NULL',
            'type' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'1:普通会员；10管理员\'',
            'realname' => 'varchar(10) NULL COMMENT \'真实姓名\'',
            'head_portrait' => 'char(255) NULL',
            'sex' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'1:男;2:女\'',
            'qq' => 'varchar(20) NULL',
            'email' => 'varchar(60) NULL DEFAULT \'\'',
            'birthday' => 'date NULL',
            'user_integral' => 'int(11) NULL DEFAULT \'0\' COMMENT \'当前积分\'',
            'provinces' => 'varchar(10) NULL',
            'city' => 'varchar(10) NULL',
            'area' => 'varchar(10) NULL',
            'address' => 'varchar(100) NULL DEFAULT \'\' COMMENT \'默认地址\'',
            'visit_count' => 'smallint(5) unsigned NULL DEFAULT \'0\' COMMENT \'访问次数\'',
            'home_phone' => 'varchar(20) NULL COMMENT \'家庭号码\'',
            'mobile_phone' => 'varchar(20) NULL COMMENT \'手机号码\'',
            'role' => 'smallint(6) NULL DEFAULT \'10\'',
            'status' => 'smallint(6) NOT NULL DEFAULT \'10\'',
            'last_time' => 'int(10) NULL COMMENT \'最后一次登陆时间\'',
            'last_ip' => 'varchar(16) NULL DEFAULT \'\' COMMENT \'最后一次登陆ip\'',
            'created_at' => 'int(11) NOT NULL',
            'updated_at' => 'int(11) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='后台管理员表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%sys_manager}}',['id'=>'1','username'=>'admin','password_hash'=>'$2y$13$AYIDdkPcbMn5hWdZd0P8zOOPDcnOOUhKs7FNGvtYxTXGi2MMT62oG','auth_key'=>'z6lrwixmdNF4VqtkXw6z-3vMZdSdngm2','password_reset_token'=>'','type'=>'10','realname'=>'简言','head_portrait'=>'/attachment/images/2017/07-12/img_KuWeUv9woo.jpg','sex'=>'0','qq'=>'751393839','email'=>'751393839@qq.com','birthday'=>'2017-02-25','user_integral'=>'0','provinces'=>'150000','city'=>'150300','area'=>'150303','address'=>'大潮街道666号','visit_count'=>'200','home_phone'=>'','mobile_phone'=>'13484261295','role'=>'10','status'=>'10','last_time'=>'1499986539','last_ip'=>'127.0.0.1','created_at'=>'1449114934','updated_at'=>'1499986539']);
        $this->insert('{{%sys_manager}}',['id'=>'2','username'=>'test','password_hash'=>'$2y$13$jfst4UfC2RYFDCphT2LWNeTeAj1bdg95ikF2z6OOE24qQFcOCJavm','auth_key'=>'iWVr_tcZ3NI8MJ_RwE1mBZ0P3iL2O5p9','password_reset_token'=>NULL,'type'=>'1','realname'=>'','head_portrait'=>'/attachment/images/2017/06-12/img_buSy48y2BU.jpg','sex'=>'1','qq'=>NULL,'email'=>'','birthday'=>NULL,'user_integral'=>'0','provinces'=>'140000','city'=>'140200','area'=>'140203','address'=>'','visit_count'=>'0','home_phone'=>NULL,'mobile_phone'=>'','role'=>'10','status'=>'10','last_time'=>'1492418153','last_ip'=>'127.0.0.1','created_at'=>'1490081473','updated_at'=>'1497249724']);
        
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

