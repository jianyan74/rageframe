<?php

use yii\db\Migration;

class m170908_042134_sys_addons extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_addons}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'name' => 'varchar(40) NOT NULL COMMENT \'插件名或标识\'',
            'title' => 'varchar(20) NOT NULL DEFAULT \'\' COMMENT \'中文名\'',
            'cover' => 'varchar(1000) NULL',
            'group' => 'varchar(20) NULL COMMENT \'组别\'',
            'type' => 'varchar(20) NULL COMMENT \'类别\'',
            'brief_introduction' => 'varchar(140) NULL DEFAULT \'\' COMMENT \'简单介绍\'',
            'description' => 'text NULL COMMENT \'插件描述\'',
            'status' => 'tinyint(1) NOT NULL DEFAULT \'1\' COMMENT \'状态\'',
            'config' => 'text NULL COMMENT \'配置\'',
            'setting' => 'tinyint(1) NULL DEFAULT \'-1\'',
            'hook' => 'tinyint(1) NULL DEFAULT \'-1\' COMMENT \'钩子\'',
            'author' => 'varchar(40) NULL DEFAULT \'\' COMMENT \'作者\'',
            'version' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'版本号\'',
            'wechat_message' => 'varchar(1000) NULL COMMENT \'接收微信回复类别\'',
            'wxapp_support' => 'tinyint(1) NULL DEFAULT \'0\' COMMENT \'小程序支持 0不支持1支持\'',
            'append' => 'int(10) unsigned NOT NULL COMMENT \'安装时间\'',
            'updated' => 'int(10) unsigned NOT NULL COMMENT \'是否有后台列表\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='插件表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%sys_addons}}',['id'=>'32','name'=>'LeaveMessage','title'=>'留言管理','cover'=>NULL,'group'=>NULL,'type'=>'plug','brief_introduction'=>'','description'=>'投诉留言插件','status'=>'1','config'=>NULL,'setting'=>'-1','hook'=>'1','author'=>'简言','version'=>'1.0','wechat_message'=>'','wxapp_support'=>'0','append'=>'1503989412','updated'=>'1503989412']);
        $this->insert('{{%sys_addons}}',['id'=>'23','name'=>'Adv','title'=>'广告管理','cover'=>NULL,'group'=>NULL,'type'=>'plug','brief_introduction'=>'广告插件','description'=>'广告插件','status'=>'1','config'=>NULL,'setting'=>'-1','hook'=>'1','author'=>'简言','version'=>'1.0','wechat_message'=>'','wxapp_support'=>'0','append'=>'1503383909','updated'=>'1503903667']);
        $this->insert('{{%sys_addons}}',['id'=>'30','name'=>'AppManual','title'=>'开发手册','cover'=>NULL,'group'=>NULL,'type'=>'services','brief_introduction'=>'','description'=>'网站说明文档，支持马克笔记编写','status'=>'1','config'=>NULL,'setting'=>'1','hook'=>'-1','author'=>'简言','version'=>'1.0','wechat_message'=>'a:0:{}','wxapp_support'=>'0','append'=>'1503989401','updated'=>'1503989401']);
        $this->insert('{{%sys_addons}}',['id'=>'29','name'=>'Debris','title'=>'碎片管理','cover'=>NULL,'group'=>NULL,'type'=>'plug','brief_introduction'=>'','description'=>'碎片管理,网站内有些碎片信息可以进行统一管理如图片、单文章、文字。','status'=>'1','config'=>NULL,'setting'=>'-1','hook'=>'1','author'=>'简言','version'=>'1.0','wechat_message'=>'a:0:{}','wxapp_support'=>'0','append'=>'1503905274','updated'=>'1503905274']);
        $this->insert('{{%sys_addons}}',['id'=>'18','name'=>'DebrisGroup','title'=>'碎片组别','cover'=>NULL,'group'=>NULL,'type'=>'plug','brief_introduction'=>'','description'=>'碎片组别','status'=>'1','config'=>NULL,'setting'=>'-1','hook'=>'1','author'=>'简言','version'=>'1.0','wechat_message'=>'','wxapp_support'=>'0','append'=>'1503382253','updated'=>'1503382253']);
        $this->insert('{{%sys_addons}}',['id'=>'24','name'=>'BottomMenu','title'=>'底部导航','cover'=>NULL,'group'=>NULL,'type'=>'plug','brief_introduction'=>'','description'=>'底部导航','status'=>'1','config'=>NULL,'setting'=>'-1','hook'=>'1','author'=>'简言','version'=>'1.0','wechat_message'=>'','wxapp_support'=>'0','append'=>'1503383913','updated'=>'1503383913']);
        $this->insert('{{%sys_addons}}',['id'=>'25','name'=>'FriendLink','title'=>'友情链接','cover'=>NULL,'group'=>NULL,'type'=>'plug','brief_introduction'=>'','description'=>'友情链接','status'=>'1','config'=>NULL,'setting'=>'-1','hook'=>'1','author'=>'简言','version'=>'1.0','wechat_message'=>'','wxapp_support'=>'0','append'=>'1503383917','updated'=>'1503383917']);
        $this->insert('{{%sys_addons}}',['id'=>'31','name'=>'WxApp','title'=>'小程序','cover'=>NULL,'group'=>NULL,'type'=>'activity','brief_introduction'=>'','description'=>'小程序测试','status'=>'1','config'=>NULL,'setting'=>'-1','hook'=>'-1','author'=>'简言','version'=>'1.0','wechat_message'=>'a:0:{}','wxapp_support'=>'1','append'=>'1503989406','updated'=>'1503989406']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_addons}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

