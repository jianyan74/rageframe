<?php

use yii\db\Migration;

class m180307_012058_sys_menu extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_menu}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(50) NOT NULL DEFAULT \'\' COMMENT \'标题\'',
            'pid' => 'int(50) NULL DEFAULT \'0\' COMMENT \'上级id\'',
            'url' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'链接地址\'',
            'menu_css' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'样式\'',
            'sort' => 'int(5) NULL DEFAULT \'0\' COMMENT \'排序\'',
            'level' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'级别\'',
            'dev' => 'tinyint(4) NULL DEFAULT \'0\' COMMENT \'开发者[0:都可见;开发模式可见]\'',
            'type' => 'varchar(10) NULL DEFAULT \'menu\' COMMENT \'menu:菜单;sys:系统菜单\'',
            'status' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'状态[-1:删除;0:禁用;1启用]\'',
            'append' => 'int(10) NULL DEFAULT \'0\' COMMENT \'添加时间\'',
            'updated' => 'int(10) NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统_菜单导航表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%sys_menu}}',['id'=>'1','title'=>'系统管理','pid'=>'0','url'=>'menu-sys','menu_css'=>'fa-cogs','sort'=>'1','level'=>'1','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1460353610','updated'=>'1507792680']);
        $this->insert('{{%sys_menu}}',['id'=>'9','title'=>'数据还原','pid'=>'7','url'=>'data-base/restore','menu_css'=>'','sort'=>'1','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1461255353','updated'=>'1486260651']);
        $this->insert('{{%sys_menu}}',['id'=>'13','title'=>'网站设置','pid'=>'1','url'=>'sys/config/edit-all','menu_css'=>'','sort'=>'0','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1470970402','updated'=>'1507960932']);
        $this->insert('{{%sys_menu}}',['id'=>'17','title'=>'文章分类','pid'=>'24','url'=>'sys/cate/index','menu_css'=>'','sort'=>'2','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1472700435','updated'=>'1496908196']);
        $this->insert('{{%sys_menu}}',['id'=>'18','title'=>'文章管理','pid'=>'24','url'=>'sys/article/index','menu_css'=>'','sort'=>'1','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1472700480','updated'=>'1496908181']);
        $this->insert('{{%sys_menu}}',['id'=>'19','title'=>'会员管理','pid'=>'0','url'=>'menu-user','menu_css'=>'fa-user','sort'=>'2','level'=>'1','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1477451201','updated'=>'1501730523']);
        $this->insert('{{%sys_menu}}',['id'=>'20','title'=>'用户信息','pid'=>'19','url'=>'member/member/index','menu_css'=>'','sort'=>'0','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1477451240','updated'=>'1496908487']);
        $this->insert('{{%sys_menu}}',['id'=>'24','title'=>'内容管理','pid'=>'0','url'=>'menu-article','menu_css'=>'fa-bars','sort'=>'3','level'=>'1','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1477709532','updated'=>'1501730524']);
        $this->insert('{{%sys_menu}}',['id'=>'25','title'=>'文章标签','pid'=>'24','url'=>'sys/tag/index','menu_css'=>'','sort'=>'3','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1478159762','updated'=>'1496908189']);
        $this->insert('{{%sys_menu}}',['id'=>'29','title'=>'单页管理','pid'=>'24','url'=>'sys/article-single/index','menu_css'=>'','sort'=>'0','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1478567297','updated'=>'1496902031']);
        $this->insert('{{%sys_menu}}',['id'=>'30','title'=>'微信营销','pid'=>'0','url'=>'menu-wechat','menu_css'=>'fa-weixin','sort'=>'9','level'=>'1','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1481595870','updated'=>'1491115081']);
        $this->insert('{{%sys_menu}}',['id'=>'31','title'=>'增强功能','pid'=>'30','url'=>'menu-wechat-advanced','menu_css'=>'','sort'=>'1','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1481595912','updated'=>'1493358740']);
        $this->insert('{{%sys_menu}}',['id'=>'32','title'=>'粉丝','pid'=>'30','url'=>'menu-wechat-fans','menu_css'=>'','sort'=>'2','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1481595928','updated'=>'1493367913']);
        $this->insert('{{%sys_menu}}',['id'=>'33','title'=>'粉丝管理','pid'=>'32','url'=>'wechat/fans/index','menu_css'=>'','sort'=>'0','level'=>'3','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1481596098','updated'=>'1496902932']);
        $this->insert('{{%sys_menu}}',['id'=>'34','title'=>'粉丝标签','pid'=>'32','url'=>'wechat/fans-tags/list','menu_css'=>'','sort'=>'1','level'=>'3','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1481596119','updated'=>'1514361360']);
        $this->insert('{{%sys_menu}}',['id'=>'36','title'=>'素材库','pid'=>'30','url'=>'wechat/attachment/news-index','menu_css'=>'','sort'=>'3','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1481596234','updated'=>'1500694814']);
        $this->insert('{{%sys_menu}}',['id'=>'37','title'=>'数据统计','pid'=>'30','url'=>'#','menu_css'=>'','sort'=>'7','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1481596253','updated'=>'1509513973']);
        $this->insert('{{%sys_menu}}',['id'=>'39','title'=>'回复规则使用量','pid'=>'37','url'=>'wechat/stat/rule','menu_css'=>'','sort'=>'2','level'=>'3','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1481596305','updated'=>'1509514004']);
        $this->insert('{{%sys_menu}}',['id'=>'40','title'=>'关键字命中规则','pid'=>'37','url'=>'wechat/stat/rule-keyword','menu_css'=>'','sort'=>'3','level'=>'3','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1481596321','updated'=>'1509524225']);
        $this->insert('{{%sys_menu}}',['id'=>'47','title'=>'自定义菜单','pid'=>'31','url'=>'wechat/custom-menu/index','menu_css'=>'','sort'=>'1','level'=>'3','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1481596691','updated'=>'1496632789']);
        $this->insert('{{%sys_menu}}',['id'=>'48','title'=>'二维码/转化链接','pid'=>'31','url'=>'wechat/qr/index','menu_css'=>'','sort'=>'2','level'=>'3','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1481596702','updated'=>'1493344815']);
        $this->insert('{{%sys_menu}}',['id'=>'49','title'=>'多客服接入','pid'=>'31','url'=>'#','menu_css'=>'','sort'=>'3','level'=>'3','dev'=>'0','type'=>'menu','status'=>'-1','append'=>'1481596716','updated'=>'1501730528']);
        $this->insert('{{%sys_menu}}',['id'=>'50','title'=>'消息管理','pid'=>'32','url'=>'wechat/msg-history/index','menu_css'=>'','sort'=>'6','level'=>'3','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1481596835','updated'=>'1508988059']);
        $this->insert('{{%sys_menu}}',['id'=>'62','title'=>'参数设置','pid'=>'30','url'=>'/wechat/setting/history-stat','menu_css'=>'','sort'=>'8','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1487726086','updated'=>'1508989287']);
        $this->insert('{{%sys_menu}}',['id'=>'65','title'=>'扩展模块','pid'=>'0','url'=>'sys/addons/index','menu_css'=>'fa-cubes','sort'=>'10','level'=>'1','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1488285719','updated'=>'1501730540']);
        $this->insert('{{%sys_menu}}',['id'=>'66','title'=>'前台导航','pid'=>'1','url'=>'sys/desk-menu/index','menu_css'=>'','sort'=>'1','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1490758283','updated'=>'1496900908']);
        $this->insert('{{%sys_menu}}',['id'=>'68','title'=>'常用系统工具','pid'=>'0','url'=>'sys-tool','menu_css'=>'','sort'=>'5','level'=>'1','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1491105246','updated'=>'1499406130']);
        $this->insert('{{%sys_menu}}',['id'=>'70','title'=>'数据备份','pid'=>'68','url'=>'data-base/backups','menu_css'=>'fa-database','sort'=>'0','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1491105328','updated'=>'1510832350']);
        $this->insert('{{%sys_menu}}',['id'=>'71','title'=>'数据还原','pid'=>'68','url'=>'data-base/restore','menu_css'=>'fa-mail-forward','sort'=>'1','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1491105422','updated'=>'1496908338']);
        $this->insert('{{%sys_menu}}',['id'=>'72','title'=>'服务器信息及日志','pid'=>'0','url'=>'sys-manager','menu_css'=>'','sort'=>'4','level'=>'1','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1491113016','updated'=>'1508405267']);
        $this->insert('{{%sys_menu}}',['id'=>'78','title'=>'系统信息','pid'=>'72','url'=>'system/info','menu_css'=>'fa-exclamation','sort'=>'1','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492316037','updated'=>'1508218709']);
        $this->insert('{{%sys_menu}}',['id'=>'79','title'=>'系统日志','pid'=>'72','url'=>'action-log/index','menu_css'=>'fa-file-text','sort'=>'0','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492326226','updated'=>'1508218709']);
        $this->insert('{{%sys_menu}}',['id'=>'80','title'=>'回收站','pid'=>'24','url'=>'sys/article/recycle','menu_css'=>'','sort'=>'4','level'=>'2','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1492340803','updated'=>'1496902068']);
        $this->insert('{{%sys_menu}}',['id'=>'82','title'=>'配置管理','pid'=>'93','url'=>'config/index','menu_css'=>'fa-gear','sort'=>'2','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492345718','updated'=>'1501797642']);
        $this->insert('{{%sys_menu}}',['id'=>'83','title'=>'后台菜单','pid'=>'93','url'=>'menu/index','menu_css'=>'fa-list','sort'=>'3','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492345776','updated'=>'1501797643']);
        $this->insert('{{%sys_menu}}',['id'=>'84','title'=>'权限管理','pid'=>'86','url'=>'auth-accredit/index','menu_css'=>'fa-suitcase','sort'=>'2','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492345837','updated'=>'1496908390']);
        $this->insert('{{%sys_menu}}',['id'=>'86','title'=>'用户权限','pid'=>'0','url'=>'sys-user','menu_css'=>'','sort'=>'2','level'=>'1','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492346438','updated'=>'1499406111']);
        $this->insert('{{%sys_menu}}',['id'=>'87','title'=>'后台用户','pid'=>'86','url'=>'manager/index','menu_css'=>'fa-user','sort'=>'0','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492346479','updated'=>'1496908312']);
        $this->insert('{{%sys_menu}}',['id'=>'88','title'=>'角色管理','pid'=>'86','url'=>'auth-role/index','menu_css'=>'fa-user-secret','sort'=>'1','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492346502','updated'=>'1496908382']);
        $this->insert('{{%sys_menu}}',['id'=>'89','title'=>'系统消息','pid'=>'0','url'=>'sys-Information','menu_css'=>'','sort'=>'1','level'=>'1','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492347913','updated'=>'1499406140']);
        $this->insert('{{%sys_menu}}',['id'=>'90','title'=>'后台公告','pid'=>'89','url'=>'/sys/notify-announce/index','menu_css'=>'fa-certificate','sort'=>'0','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492348005','updated'=>'1499406307']);
        $this->insert('{{%sys_menu}}',['id'=>'92','title'=>'后台私信','pid'=>'89','url'=>'notify-message/index','menu_css'=>'fa-bell','sort'=>'3','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492356138','updated'=>'1496908303']);
        $this->insert('{{%sys_menu}}',['id'=>'93','title'=>'扩展','pid'=>'0','url'=>'sys-extend','menu_css'=>'','sort'=>'0','level'=>'1','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492499285','updated'=>'1499406104']);
        $this->insert('{{%sys_menu}}',['id'=>'94','title'=>'模块插件','pid'=>'93','url'=>'addons/uninstall','menu_css'=>'fa-cubes','sort'=>'0','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1492499323','updated'=>'1496908282']);
        $this->insert('{{%sys_menu}}',['id'=>'106','title'=>'自动回复','pid'=>'31','url'=>'wechat/rule/index','menu_css'=>'','sort'=>'0','level'=>'3','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1493358892','updated'=>'1501462520']);
        $this->insert('{{%sys_menu}}',['id'=>'108','title'=>'功能插件','pid'=>'0','url'=>'menu-plug-in','menu_css'=>'fa-windows','sort'=>'9','level'=>'1','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1495966938','updated'=>'1501730539']);
        $this->insert('{{%sys_menu}}',['id'=>'112','title'=>'小程序','pid'=>'0','url'=>'sys/wxapp/index','menu_css'=>'fa-code','sort'=>'11','level'=>'1','dev'=>'0','type'=>'menu','status'=>'-1','append'=>'1501796969','updated'=>'1501802519']);
        $this->insert('{{%sys_menu}}',['id'=>'113','title'=>'小程序','pid'=>'93','url'=>'wx-app/index','menu_css'=>'fa-code','sort'=>'1','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1501797662','updated'=>'1501899792']);
        $this->insert('{{%sys_menu}}',['id'=>'115','title'=>'规则管理','pid'=>'86','url'=>'auth-rule/index','menu_css'=>'fa-gavel','sort'=>'3','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1507955145','updated'=>'1507955145']);
        $this->insert('{{%sys_menu}}',['id'=>'116','title'=>'服务器信息','pid'=>'72','url'=>'system/server','menu_css'=>'fa-microchip','sort'=>'2','level'=>'2','dev'=>'0','type'=>'sys','status'=>'1','append'=>'1507993299','updated'=>'1507993819']);
        $this->insert('{{%sys_menu}}',['id'=>'117','title'=>'粉丝关注统计','pid'=>'37','url'=>'wechat/stat/fans-follow','menu_css'=>'','sort'=>'1','level'=>'3','dev'=>'0','type'=>'menu','status'=>'1','append'=>'1509280144','updated'=>'1509525759']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_menu}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

