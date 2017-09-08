<?php

use yii\db\Migration;

class m170908_042133_member extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%member}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'username' => 'varchar(20) NULL COMMENT \'帐号\'',
            'password_hash' => 'varchar(255) NULL',
            'auth_key' => 'varchar(32) NULL',
            'password_reset_token' => 'varchar(255) NULL',
            'wechat_openid' => 'varchar(50) NULL COMMENT \'微信openid\'',
            'type' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'1:普通会员；10管理员\'',
            'nickname' => 'varchar(10) NULL COMMENT \'昵称\'',
            'realname' => 'varchar(10) NULL COMMENT \'真实姓名\'',
            'head_portrait' => 'varchar(255) NULL',
            'sex' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'1:男;2:女\'',
            'qq' => 'varchar(20) NULL',
            'email' => 'varchar(60) NULL DEFAULT \'\'',
            'birthday' => 'date NULL',
            'user_money' => 'decimal(10,2) NULL DEFAULT \'0.00\' COMMENT \'余额\'',
            'accumulate_money' => 'decimal(10,2) NULL DEFAULT \'0.00\' COMMENT \'累积消费\'',
            'frozen_money' => 'decimal(10,2) NULL DEFAULT \'0.00\' COMMENT \'累积金额\'',
            'user_integral' => 'int(11) NULL DEFAULT \'0\' COMMENT \'当前积分\'',
            'address_id' => 'mediumint(8) unsigned NULL COMMENT \'默认地址\'',
            'visit_count' => 'smallint(5) unsigned NULL DEFAULT \'0\' COMMENT \'访问次数\'',
            'home_phone' => 'varchar(20) NULL COMMENT \'家庭号码\'',
            'mobile_phone' => 'varchar(20) NULL COMMENT \'手机号码\'',
            'passwd_question' => 'varchar(50) NULL COMMENT \'密码问题\'',
            'passwd_answer' => 'varchar(255) NULL COMMENT \'密码答案\'',
            'role' => 'smallint(6) NULL DEFAULT \'10\'',
            'status' => 'smallint(6) NULL DEFAULT \'10\'',
            'last_time' => 'int(10) NULL COMMENT \'最后一次登陆时间\'',
            'last_ip' => 'varchar(16) NULL DEFAULT \'\' COMMENT \'最后一次登陆ip\'',
            'city' => 'varchar(100) NULL',
            'province' => 'varchar(100) NULL',
            'country' => 'varchar(100) NULL',
            'updated_at' => 'int(11) NULL',
            'created_at' => 'int(11) NOT NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%member}}',['id'=>'2','username'=>'manager','password_hash'=>'$2y$13$76xaAS4Cy.UqasjdEah2rejsOZgZrpDav7U/cv.dvodctlVOoRa1i','auth_key'=>'6b3PYZvg9SQxMAJDoNOQK6jGdJBVgHnJ','password_reset_token'=>'jrLdVAeAWDrHDJ9iF2aOX_gVpneU4Ew9_1500472047','wechat_openid'=>NULL,'type'=>'1','nickname'=>NULL,'realname'=>NULL,'head_portrait'=>NULL,'sex'=>'1','qq'=>NULL,'email'=>'751393839@qq.com','birthday'=>NULL,'user_money'=>'0.00','accumulate_money'=>'0.00','frozen_money'=>'0.00','user_integral'=>'0','address_id'=>'0','visit_count'=>'1','home_phone'=>NULL,'mobile_phone'=>NULL,'passwd_question'=>NULL,'passwd_answer'=>NULL,'role'=>'10','status'=>'10','last_time'=>'1500430123','last_ip'=>'61.174.30.170','city'=>NULL,'province'=>NULL,'country'=>NULL,'updated_at'=>'1500472047','created_at'=>'1500430122']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%member}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

