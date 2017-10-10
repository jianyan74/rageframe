<?php

use yii\db\Migration;

class m171010_060051_sys_auth_item_child extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_auth_item_child}}', [
            'parent' => 'varchar(64) NOT NULL',
            'child' => 'varchar(64) NOT NULL',
            'PRIMARY KEY (`parent`,`child`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限表'");
        
        /* 索引设置 */
        $this->createIndex('child','{{%sys_auth_item_child}}','child',0);
        
        /* 外键约束设置 */
        $this->addForeignKey('fk_sys_auth_item_4009_00','{{%sys_auth_item_child}}', 'parent', '{{%sys_auth_item}}', 'name', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_sys_auth_item_4009_01','{{%sys_auth_item_child}}', 'child', '{{%sys_auth_item}}', 'name', 'CASCADE', 'CASCADE' );
        
        /* 表数据 */
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'member/member/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'menu-article']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'menu-plug-in']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'menu-sys']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'menu-user']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'menu-wechat']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'menu-wechat-advanced']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'menu-wechat-fans']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'other']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/addons/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/article-single/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/article-single/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/article-single/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/article-single/update-ajax']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/article/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/article/delete-all']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/article/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/article/hide']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/article/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/article/recycle']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/article/show']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/article/update-ajax']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/cache/clear']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/cate/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/cate/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/cate/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/config/edit-all']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/desk-menu/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/desk-menu/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/manager/personal']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/manager/up-passwd']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/system/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/tag/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/tag/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'sys/tag/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/attachment/image-index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/attachment/news-index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/custom-menu/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/custom-menu/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/fans-groups/list']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/fans/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/qr-stat/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/qr/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/qr/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/reply-basic/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/reply-default/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/reply-images/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/reply/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/rule/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试用户','child'=>'wechat/setting/special-message']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_auth_item_child}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

