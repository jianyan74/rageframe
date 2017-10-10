<?php

use yii\db\Migration;

class m171010_060050_sys_addons extends Migration
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
            'cover' => 'varchar(1000) NULL DEFAULT \'\'',
            'group' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'组别\'',
            'type' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'类别\'',
            'brief_introduction' => 'varchar(140) NULL DEFAULT \'\' COMMENT \'简单介绍\'',
            'description' => 'text NULL COMMENT \'插件描述\'',
            'config' => 'text NULL COMMENT \'配置\'',
            'setting' => 'tinyint(1) NULL DEFAULT \'-1\'',
            'hook' => 'tinyint(1) NULL DEFAULT \'-1\' COMMENT \'钩子\'',
            'author' => 'varchar(40) NULL DEFAULT \'\' COMMENT \'作者\'',
            'version' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'版本号\'',
            'title_initial' => 'varchar(1) NOT NULL DEFAULT \'\' COMMENT \'首字母拼音\'',
            'wechat_message' => 'varchar(1000) NULL COMMENT \'接收微信回复类别\'',
            'wxapp_support' => 'tinyint(1) NULL DEFAULT \'0\' COMMENT \'小程序支持 0不支持1支持\'',
            'status' => 'tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'状态\'',
            'append' => 'int(10) unsigned NOT NULL COMMENT \'安装时间\'',
            'updated' => 'int(10) unsigned NOT NULL COMMENT \'是否有后台列表\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='插件表'");
        
        /* 索引设置 */
        $this->createIndex('name','{{%sys_addons}}','name',0);
        
        
        /* 表数据 */
        $this->insert('{{%sys_addons}}',['id'=>'57','name'=>'Adv','title'=>'广告管理','cover'=>'','group'=>'','type'=>'plug','brief_introduction'=>'广告插件','description'=>'广告插件','config'=>NULL,'setting'=>'0','hook'=>'1','author'=>'简言','version'=>'1.0','title_initial'=>'G','wechat_message'=>'','wxapp_support'=>'0','status'=>'1','append'=>'1506256036','updated'=>'1507609840']);
        $this->insert('{{%sys_addons}}',['id'=>'58','name'=>'AppManual','title'=>'开发手册','cover'=>'','group'=>'','type'=>'services','brief_introduction'=>'开发手册','description'=>'网站说明文档，支持马克笔记编写','config'=>NULL,'setting'=>'1','hook'=>'0','author'=>'简言','version'=>'1.0','title_initial'=>'K','wechat_message'=>'a:0:{}','wxapp_support'=>'0','status'=>'1','append'=>'1506256043','updated'=>'1507609843']);
        $this->insert('{{%sys_addons}}',['id'=>'59','name'=>'WxApp','title'=>'小程序','cover'=>'','group'=>'','type'=>'activity','brief_introduction'=>'小程序测试','description'=>'小程序测试','config'=>NULL,'setting'=>'0','hook'=>'0','author'=>'简言','version'=>'1.0','title_initial'=>'X','wechat_message'=>'a:0:{}','wxapp_support'=>'1','status'=>'1','append'=>'1506256087','updated'=>'1506256087']);
        $this->insert('{{%sys_addons}}',['id'=>'60','name'=>'BottomMenu','title'=>'底部导航','cover'=>'','group'=>'','type'=>'plug','brief_introduction'=>'底部导航','description'=>'底部导航','config'=>NULL,'setting'=>'0','hook'=>'1','author'=>'简言','version'=>'1.0','title_initial'=>'D','wechat_message'=>'','wxapp_support'=>'0','status'=>'1','append'=>'1506256115','updated'=>'1506256115']);
        $this->insert('{{%sys_addons}}',['id'=>'61','name'=>'Debris','title'=>'碎片管理','cover'=>'','group'=>'','type'=>'plug','brief_introduction'=>'碎片管理','description'=>'碎片管理,网站内有些碎片信息可以进行统一管理如图片、单文章、文字。','config'=>NULL,'setting'=>'0','hook'=>'1','author'=>'简言','version'=>'1.0','title_initial'=>'S','wechat_message'=>'a:0:{}','wxapp_support'=>'0','status'=>'1','append'=>'1506256120','updated'=>'1507609846']);
        $this->insert('{{%sys_addons}}',['id'=>'62','name'=>'DebrisGroup','title'=>'碎片组别','cover'=>'','group'=>'','type'=>'plug','brief_introduction'=>'碎片组别','description'=>'碎片组别','config'=>NULL,'setting'=>'0','hook'=>'1','author'=>'简言','version'=>'1.0','title_initial'=>'S','wechat_message'=>'','wxapp_support'=>'0','status'=>'1','append'=>'1506256125','updated'=>'1506256125']);
        $this->insert('{{%sys_addons}}',['id'=>'63','name'=>'FriendLink','title'=>'友情链接','cover'=>'','group'=>'','type'=>'plug','brief_introduction'=>'友情链接','description'=>'友情链接','config'=>NULL,'setting'=>'0','hook'=>'1','author'=>'简言','version'=>'1.0','title_initial'=>'Y','wechat_message'=>'','wxapp_support'=>'0','status'=>'1','append'=>'1506256130','updated'=>'1506256130']);
        $this->insert('{{%sys_addons}}',['id'=>'64','name'=>'LeaveMessage','title'=>'留言管理','cover'=>'','group'=>'','type'=>'plug','brief_introduction'=>'投诉留言插件','description'=>'投诉留言插件','config'=>NULL,'setting'=>'0','hook'=>'1','author'=>'简言','version'=>'1.0','title_initial'=>'L','wechat_message'=>'','wxapp_support'=>'0','status'=>'1','append'=>'1506256138','updated'=>'1506256138']);
        
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

