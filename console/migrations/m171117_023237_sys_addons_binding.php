<?php

use yii\db\Migration;

class m171117_023237_sys_addons_binding extends Migration
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
        $this->insert('{{%sys_addons_binding}}',['id'=>'213','addons_name'=>'AppExample','entry'=>'menu','title'=>'基本表格','route'=>'curd-base/index','icon'=>'']);
        $this->insert('{{%sys_addons_binding}}',['id'=>'214','addons_name'=>'AppExample','entry'=>'menu','title'=>'Grid表格','route'=>'curd-grid/index','icon'=>'']);
        
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

