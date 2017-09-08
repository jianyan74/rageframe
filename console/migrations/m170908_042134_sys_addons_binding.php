<?php

use yii\db\Migration;

class m170908_042134_sys_addons_binding extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_addons_binding}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'addons_name' => 'varchar(30) NOT NULL DEFAULT \'\' COMMENT \'插件名称\'',
            'entry' => 'varchar(10) NOT NULL DEFAULT \'\' COMMENT \'入口类别\'',
            'title' => 'varchar(50) NOT NULL COMMENT \'名称\'',
            'route' => 'varchar(30) NOT NULL COMMENT \'路由\'',
            'icon' => 'varchar(50) NULL COMMENT \'图标\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='插件相关绑定表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%sys_addons_binding}}',['id'=>'29','addons_name'=>'DebrisGroup','entry'=>'menu','title'=>'内容管理','route'=>'index/index','icon'=>'']);
        $this->insert('{{%sys_addons_binding}}',['id'=>'30','addons_name'=>'DebrisGroup','entry'=>'menu','title'=>'分类管理','route'=>'cate/index','icon'=>'']);
        $this->insert('{{%sys_addons_binding}}',['id'=>'38','addons_name'=>'Adv','entry'=>'menu','title'=>'广告列表','route'=>'adv/index','icon'=>'']);
        $this->insert('{{%sys_addons_binding}}',['id'=>'39','addons_name'=>'Adv','entry'=>'menu','title'=>'广告位置','route'=>'adv-location/index','icon'=>'']);
        $this->insert('{{%sys_addons_binding}}',['id'=>'40','addons_name'=>'BottomMenu','entry'=>'menu','title'=>'底部导航','route'=>'bottom-menu/index','icon'=>'']);
        $this->insert('{{%sys_addons_binding}}',['id'=>'41','addons_name'=>'FriendLink','entry'=>'menu','title'=>'链接管理','route'=>'friend-link/index','icon'=>'']);
        $this->insert('{{%sys_addons_binding}}',['id'=>'47','addons_name'=>'Debris','entry'=>'menu','title'=>'碎片列表','route'=>'debris/index','icon'=>'']);
        $this->insert('{{%sys_addons_binding}}',['id'=>'48','addons_name'=>'AppManual','entry'=>'cover','title'=>'文档入口','route'=>'manual/index','icon'=>'']);
        $this->insert('{{%sys_addons_binding}}',['id'=>'49','addons_name'=>'AppManual','entry'=>'menu','title'=>'文档管理','route'=>'manual/index','icon'=>'']);
        $this->insert('{{%sys_addons_binding}}',['id'=>'50','addons_name'=>'LeaveMessage','entry'=>'menu','title'=>'留言管理','route'=>'leave-message/index','icon'=>'']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_addons_binding}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

