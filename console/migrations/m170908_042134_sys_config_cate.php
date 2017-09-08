<?php

use yii\db\Migration;

class m170908_042134_sys_config_cate extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_config_cate}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(50) NOT NULL COMMENT \'标题\'',
            'pid' => 'int(50) NULL DEFAULT \'0\' COMMENT \'上级id\'',
            'sort' => 'int(5) NULL DEFAULT \'0\' COMMENT \'排序\'',
            'status' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'是否隐藏\'',
            'level' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'级别\'',
            'append' => 'int(10) NULL COMMENT \'添加时间\'',
            'updated' => 'int(10) NULL COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='公共配置分类表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%sys_config_cate}}',['id'=>'1','title'=>'网站配置','pid'=>'0','sort'=>'0','status'=>'1','level'=>'1','append'=>'1497177084','updated'=>'1497243589']);
        $this->insert('{{%sys_config_cate}}',['id'=>'2','title'=>'系统配置','pid'=>'0','sort'=>'1','status'=>'1','level'=>'1','append'=>'1497177084','updated'=>'1497177130']);
        $this->insert('{{%sys_config_cate}}',['id'=>'3','title'=>'微信公众号','pid'=>'0','sort'=>'2','status'=>'1','level'=>'1','append'=>'1497177084','updated'=>'1497177131']);
        $this->insert('{{%sys_config_cate}}',['id'=>'4','title'=>'第三方支付','pid'=>'0','sort'=>'3','status'=>'1','level'=>'1','append'=>'1497177095','updated'=>'1497177132']);
        $this->insert('{{%sys_config_cate}}',['id'=>'5','title'=>'第三方登录','pid'=>'0','sort'=>'4','status'=>'1','level'=>'1','append'=>'1497177103','updated'=>'1497177133']);
        $this->insert('{{%sys_config_cate}}',['id'=>'6','title'=>'邮件配置','pid'=>'0','sort'=>'5','status'=>'1','level'=>'1','append'=>'1497177113','updated'=>'1497177133']);
        $this->insert('{{%sys_config_cate}}',['id'=>'7','title'=>'云存储','pid'=>'0','sort'=>'6','status'=>'1','level'=>'1','append'=>'1497177124','updated'=>'1497177136']);
        $this->insert('{{%sys_config_cate}}',['id'=>'8','title'=>'支付宝手机','pid'=>'4','sort'=>'0','status'=>'1','level'=>'2','append'=>'1497177218','updated'=>'1497248415']);
        $this->insert('{{%sys_config_cate}}',['id'=>'9','title'=>'微信','pid'=>'4','sort'=>'0','status'=>'1','level'=>'2','append'=>'1497177226','updated'=>'1497177406']);
        $this->insert('{{%sys_config_cate}}',['id'=>'10','title'=>'银联','pid'=>'4','sort'=>'0','status'=>'-1','level'=>'2','append'=>'1497177235','updated'=>'1497247812']);
        $this->insert('{{%sys_config_cate}}',['id'=>'11','title'=>'QQ登录','pid'=>'5','sort'=>'0','status'=>'1','level'=>'2','append'=>'1497177283','updated'=>'1497177283']);
        $this->insert('{{%sys_config_cate}}',['id'=>'12','title'=>'微博登录','pid'=>'5','sort'=>'1','status'=>'1','level'=>'2','append'=>'1497177295','updated'=>'1497177401']);
        $this->insert('{{%sys_config_cate}}',['id'=>'13','title'=>'微信登录','pid'=>'5','sort'=>'2','status'=>'1','level'=>'2','append'=>'1497177320','updated'=>'1497177402']);
        $this->insert('{{%sys_config_cate}}',['id'=>'14','title'=>'GitHub登录','pid'=>'5','sort'=>'3','status'=>'1','level'=>'2','append'=>'1497177361','updated'=>'1497177403']);
        $this->insert('{{%sys_config_cate}}',['id'=>'15','title'=>'七牛云','pid'=>'7','sort'=>'0','status'=>'1','level'=>'2','append'=>'1497177378','updated'=>'1497177378']);
        $this->insert('{{%sys_config_cate}}',['id'=>'16','title'=>'邮件','pid'=>'6','sort'=>'0','status'=>'1','level'=>'2','append'=>'1497177394','updated'=>'1497181686']);
        $this->insert('{{%sys_config_cate}}',['id'=>'17','title'=>'网站配置','pid'=>'1','sort'=>'0','status'=>'1','level'=>'2','append'=>'1497177421','updated'=>'1497243611']);
        $this->insert('{{%sys_config_cate}}',['id'=>'18','title'=>'系统配置','pid'=>'2','sort'=>'0','status'=>'1','level'=>'2','append'=>'1497177428','updated'=>'1497182113']);
        $this->insert('{{%sys_config_cate}}',['id'=>'19','title'=>'公众号配置','pid'=>'3','sort'=>'0','status'=>'1','level'=>'2','append'=>'1497177441','updated'=>'1497181644']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_config_cate}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

