<?php

use yii\db\Migration;

class m180307_012057_sys_auth_item_child extends Migration
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
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统_角色权限表'");
        
        /* 索引设置 */
        $this->createIndex('child','{{%sys_auth_item_child}}','child',0);
        
        /* 外键约束设置 */
        $this->addForeignKey('fk_sys_auth_item_5843_00','{{%sys_auth_item_child}}', 'parent', '{{%sys_auth_item}}', 'name', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_sys_auth_item_5843_01','{{%sys_auth_item_child}}', 'child', '{{%sys_auth_item}}', 'name', 'CASCADE', 'CASCADE' );
        
        /* 表数据 */
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'menu-article']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'menu-article']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys-user']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys-user']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/article-single/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/article-single/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/article-single/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/article-single/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/article-single/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/article-single/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/article-single/update-ajax']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/article-single/update-ajax']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/article/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/article/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/article/delete-all']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/article/delete-all']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/article/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/article/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/article/hide']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/article/hide']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/article/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/article/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/article/recycle']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/article/recycle']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/article/show']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/article/show']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/article/update-ajax']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/article/update-ajax']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/auth-role/accredit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/auth-role/accredit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/auth-role/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/auth-role/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/auth-role/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/auth-role/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/auth-role/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/auth-role/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/cate/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/cate/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/cate/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/cate/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/cate/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/cate/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/system/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/system/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/tag/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/tag/delete']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/tag/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/tag/edit']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'子权限用户的子用户','child'=>'sys/tag/index']);
        $this->insert('{{%sys_auth_item_child}}',['parent'=>'测试','child'=>'sys/tag/index']);
        
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

