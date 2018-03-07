<?php

use yii\db\Migration;

class m180307_012057_sys_auth_item extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_auth_item}}', [
            'name' => 'varchar(64) NOT NULL',
            'type' => 'int(11) NOT NULL',
            'key' => 'int(10) NOT NULL COMMENT \'唯一key\'',
            'description' => 'text NULL',
            'rule_name' => 'varchar(64) NULL DEFAULT \'\'',
            'data' => 'text NULL',
            'parent_key' => 'int(10) NULL DEFAULT \'0\' COMMENT \'父级key\'',
            'level' => 'int(5) NULL DEFAULT \'1\' COMMENT \'级别\'',
            'sort' => 'int(10) NULL DEFAULT \'0\' COMMENT \'排序\'',
            'created_at' => 'int(11) NULL',
            'updated_at' => 'int(11) NULL',
            'PRIMARY KEY (`name`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统_角色路由表'");
        
        /* 索引设置 */
        $this->createIndex('rule_name','{{%sys_auth_item}}','rule_name',0);
        $this->createIndex('type','{{%sys_auth_item}}','type',0);
        
        /* 外键约束设置 */
        $this->addForeignKey('fk_sys_auth_rule_4966_00','{{%sys_auth_item}}', 'rule_name', '{{%sys_auth_rule}}', 'name', 'CASCADE', 'CASCADE' );
        
        /* 表数据 */
        $this->insert('{{%sys_auth_item}}',['name'=>'manager-info','type'=>'2','key'=>'60','description'=>'个人信息','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'0','level'=>'1','sort'=>'0','created_at'=>'1507911922','updated_at'=>'1507955665']);
        $this->insert('{{%sys_auth_item}}',['name'=>'member/member/delete','type'=>'2','key'=>'15','description'=>'用户删除','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'12','level'=>'3','sort'=>'2','created_at'=>'1499405246','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'member/member/edit','type'=>'2','key'=>'13','description'=>'账号管理','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'12','level'=>'3','sort'=>'0','created_at'=>'1499405162','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'member/member/index','type'=>'2','key'=>'12','description'=>'用户信息','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'11','level'=>'2','sort'=>'0','created_at'=>'1499405144','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'member/member/personal','type'=>'2','key'=>'14','description'=>'信息编辑','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'12','level'=>'3','sort'=>'1','created_at'=>'1499405188','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'menu-article','type'=>'2','key'=>'17','description'=>'内容管理','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'0','level'=>'1','sort'=>'3','created_at'=>'1499590378','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'menu-plug-in','type'=>'2','key'=>'37','description'=>'功能插件','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'0','level'=>'1','sort'=>'5','created_at'=>'1499591697','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'menu-sys','type'=>'2','key'=>'2','description'=>'系统管理','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'0','level'=>'1','sort'=>'1','created_at'=>'1499401291','updated_at'=>'1499403645']);
        $this->insert('{{%sys_auth_item}}',['name'=>'menu-user','type'=>'2','key'=>'11','description'=>'用户管理','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'0','level'=>'1','sort'=>'2','created_at'=>'1499405114','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'menu-wechat','type'=>'2','key'=>'36','description'=>'微信营销','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'0','level'=>'1','sort'=>'4','created_at'=>'1499591606','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'menu-wechat-advanced','type'=>'2','key'=>'39','description'=>'增强功能','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'36','level'=>'2','sort'=>'0','created_at'=>'1499591753','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'menu-wechat-fans','type'=>'2','key'=>'40','description'=>'粉丝','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'36','level'=>'2','sort'=>'1','created_at'=>'1499591774','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys-user','type'=>'2','key'=>'64','description'=>'用户权限','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'54','level'=>'2','sort'=>'2','created_at'=>'1508421556','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/addons/index','type'=>'2','key'=>'38','description'=>'扩展模块','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'0','level'=>'1','sort'=>'6','created_at'=>'1499591717','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/article-single/delete','type'=>'2','key'=>'24','description'=>'单页删除','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'18','level'=>'3','sort'=>'1','created_at'=>'1499590780','updated_at'=>'1499590913']);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/article-single/edit','type'=>'2','key'=>'23','description'=>'编辑新增','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'18','level'=>'3','sort'=>'0','created_at'=>'1499590763','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/article-single/index','type'=>'2','key'=>'18','description'=>'单页管理','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'17','level'=>'2','sort'=>'0','created_at'=>'1499590405','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/article-single/update-ajax','type'=>'2','key'=>'25','description'=>'状态修改','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'18','level'=>'3','sort'=>'2','created_at'=>'1499590803','updated_at'=>'1499590916']);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/article/delete','type'=>'2','key'=>'30','description'=>'文章删除','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'22','level'=>'3','sort'=>'1','created_at'=>'1499591213','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/article/delete-all','type'=>'2','key'=>'31','description'=>'一键清空','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'22','level'=>'3','sort'=>'2','created_at'=>'1499591235','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/article/edit','type'=>'2','key'=>'26','description'=>'编辑新增','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'19','level'=>'3','sort'=>'0','created_at'=>'1499590946','updated_at'=>'1510540060']);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/article/hide','type'=>'2','key'=>'28','description'=>'文章删除','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'19','level'=>'3','sort'=>'1','created_at'=>'1499591145','updated_at'=>'1507960904']);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/article/index','type'=>'2','key'=>'19','description'=>'文章管理','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'17','level'=>'2','sort'=>'1','created_at'=>'1499590444','updated_at'=>'1507957062']);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/article/recycle','type'=>'2','key'=>'22','description'=>'回收站','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'17','level'=>'2','sort'=>'4','created_at'=>'1499590554','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/article/show','type'=>'2','key'=>'29','description'=>'文章还原','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'22','level'=>'3','sort'=>'0','created_at'=>'1499591187','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/article/update-ajax','type'=>'2','key'=>'27','description'=>'状态修改','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'19','level'=>'3','sort'=>'2','created_at'=>'1499591127','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/auth-role/accredit','type'=>'2','key'=>'68','description'=>'角色授权','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'65','level'=>'4','sort'=>'2','created_at'=>'1508421675','updated_at'=>'1508421795']);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/auth-role/delete','type'=>'2','key'=>'67','description'=>'角色删除','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'65','level'=>'4','sort'=>'1','created_at'=>'1508421639','updated_at'=>'1508421782']);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/auth-role/edit','type'=>'2','key'=>'66','description'=>'编辑创建','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'65','level'=>'4','sort'=>'0','created_at'=>'1508421619','updated_at'=>'1508421770']);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/auth-role/index','type'=>'2','key'=>'65','description'=>'角色管理','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'64','level'=>'3','sort'=>'1','created_at'=>'1508421586','updated_at'=>'1508421758']);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/cache/clear','type'=>'2','key'=>'63','description'=>'清除缓存','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'60','level'=>'2','sort'=>'2','created_at'=>'1507982352','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/cate/delete','type'=>'2','key'=>'33','description'=>'分类删除','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'20','level'=>'3','sort'=>'1','created_at'=>'1499591521','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/cate/edit','type'=>'2','key'=>'32','description'=>'编辑新增','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'20','level'=>'3','sort'=>'0','created_at'=>'1499591500','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/cate/index','type'=>'2','key'=>'20','description'=>'文章分类','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'17','level'=>'2','sort'=>'2','created_at'=>'1499590504','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/config/edit-all','type'=>'2','key'=>'6','description'=>'网站设置','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'2','level'=>'2','sort'=>'0','created_at'=>'1499403966','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/config/update-info','type'=>'2','key'=>'7','description'=>'保存设置','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'6','level'=>'3','sort'=>'0','created_at'=>'1499404006','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/desk-menu/delete','type'=>'2','key'=>'10','description'=>'导航删除','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'8','level'=>'3','sort'=>'1','created_at'=>'1499404938','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/desk-menu/edit','type'=>'2','key'=>'9','description'=>'编辑/新增','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'8','level'=>'3','sort'=>'0','created_at'=>'1499404082','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/desk-menu/index','type'=>'2','key'=>'8','description'=>'前台导航','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'2','level'=>'2','sort'=>'1','created_at'=>'1499404064','updated_at'=>'1499404068']);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/manager/personal','type'=>'2','key'=>'61','description'=>'个人中心','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'60','level'=>'2','sort'=>'0','created_at'=>'1507982270','updated_at'=>'1510211791']);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/manager/up-passwd','type'=>'2','key'=>'62','description'=>'修改密码','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'60','level'=>'2','sort'=>'1','created_at'=>'1507982299','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/system/index','type'=>'2','key'=>'54','description'=>'系统','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'0','level'=>'1','sort'=>'7','created_at'=>'1499593073','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/tag/delete','type'=>'2','key'=>'35','description'=>'标签删除','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'21','level'=>'3','sort'=>'1','created_at'=>'1499591558','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/tag/edit','type'=>'2','key'=>'34','description'=>'编辑新增','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'21','level'=>'3','sort'=>'0','created_at'=>'1499591538','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'sys/tag/index','type'=>'2','key'=>'21','description'=>'标签管理','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'17','level'=>'2','sort'=>'3','created_at'=>'1499590533','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/attachment/image-index','type'=>'2','key'=>'58','description'=>'图片首页','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'41','level'=>'2','sort'=>'0','created_at'=>'1501627427','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/attachment/news-index','type'=>'2','key'=>'41','description'=>'素材库','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'36','level'=>'1','sort'=>'2','created_at'=>'1499591807','updated_at'=>'1501627385']);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/custom-menu/edit','type'=>'2','key'=>'57','description'=>'编辑新增','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'43','level'=>'4','sort'=>'1','created_at'=>'1499593431','updated_at'=>'1507982396']);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/custom-menu/index','type'=>'2','key'=>'43','description'=>'自定义菜单','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'39','level'=>'3','sort'=>'1','created_at'=>'1499591988','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/fans-groups/list','type'=>'2','key'=>'46','description'=>'粉丝分组','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'40','level'=>'3','sort'=>'1','created_at'=>'1499592051','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/fans/index','type'=>'2','key'=>'45','description'=>'粉丝管理','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'40','level'=>'3','sort'=>'0','created_at'=>'1499592033','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/qr-stat/index','type'=>'2','key'=>'55','description'=>'扫描统计','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'44','level'=>'4','sort'=>'2','created_at'=>'1499593145','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/qr/delete','type'=>'2','key'=>'53','description'=>'删除二维码','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'44','level'=>'4','sort'=>'1','created_at'=>'1499593013','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/qr/edit','type'=>'2','key'=>'52','description'=>'编辑新增','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'44','level'=>'4','sort'=>'0','created_at'=>'1499592971','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/qr/index','type'=>'2','key'=>'44','description'=>'二维码/转化链接','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'39','level'=>'3','sort'=>'2','created_at'=>'1499592011','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/qr/long-qr','type'=>'2','key'=>'56','description'=>'长链接转二维码','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'44','level'=>'4','sort'=>'3','created_at'=>'1499593360','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/reply-basic/edit','type'=>'2','key'=>'47','description'=>'编辑新增文字','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'42','level'=>'4','sort'=>'0','created_at'=>'1499592687','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/reply-default/index','type'=>'2','key'=>'50','description'=>'默认回复','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'42','level'=>'4','sort'=>'4','created_at'=>'1499592869','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/reply-images/edit','type'=>'2','key'=>'48','description'=>'编辑新增图片','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'42','level'=>'4','sort'=>'1','created_at'=>'1499592720','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/reply/delete','type'=>'2','key'=>'49','description'=>'回复删除','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'42','level'=>'4','sort'=>'3','created_at'=>'1499592838','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/rule/index','type'=>'2','key'=>'42','description'=>'自动回复','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'39','level'=>'3','sort'=>'0','created_at'=>'1499591959','updated_at'=>'1501627165']);
        $this->insert('{{%sys_auth_item}}',['name'=>'wechat/setting/special-message','type'=>'2','key'=>'51','description'=>'非文字回复','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'42','level'=>'4','sort'=>'5','created_at'=>'1499592894','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'子权限用户的子用户','type'=>'1','key'=>'69','description'=>'test|添加了|子权限用户的子用户|角色','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'0','level'=>'1','sort'=>'0','created_at'=>'1508422077','updated_at'=>NULL]);
        $this->insert('{{%sys_auth_item}}',['name'=>'测试','type'=>'1','key'=>'59','description'=>'admin|添加了|测试|角色','rule_name'=>NULL,'data'=>NULL,'parent_key'=>'0','level'=>'1','sort'=>'0','created_at'=>'1506318860','updated_at'=>'1507956229']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_auth_item}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

