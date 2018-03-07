<?php

use yii\db\Migration;

class m180307_012056_sys_addons extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_addons}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT COMMENT \'主键\'',
            'name' => 'varchar(40) NOT NULL COMMENT \'插件名或标识\'',
            'title' => 'varchar(20) NOT NULL DEFAULT \'\' COMMENT \'中文名\'',
            'cover' => 'varchar(1000) NULL DEFAULT \'\'',
            'group' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'组别\'',
            'type' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'详细类别\'',
            'brief_introduction' => 'varchar(140) NULL DEFAULT \'\' COMMENT \'简单介绍\'',
            'description' => 'text NULL COMMENT \'插件描述\'',
            'config' => 'text NULL COMMENT \'配置\'',
            'setting' => 'tinyint(1) NULL DEFAULT \'-1\' COMMENT \'设置\'',
            'hook' => 'tinyint(1) NULL DEFAULT \'-1\' COMMENT \'钩子\'',
            'author' => 'varchar(40) NULL DEFAULT \'\' COMMENT \'作者\'',
            'version' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'版本号\'',
            'title_initial' => 'varchar(1) NOT NULL DEFAULT \'\' COMMENT \'首字母拼音\'',
            'wechat_message' => 'varchar(1000) NULL COMMENT \'接收微信回复类别\'',
            'is_rule' => 'tinyint(4) NULL DEFAULT \'0\' COMMENT \'是否要嵌入规则\'',
            'wxapp_support' => 'tinyint(4) NULL DEFAULT \'0\' COMMENT \'小程序[0:不支持;1:支持]\'',
            'status' => 'tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'状态[-1:删除;0:禁用;1启用]\'',
            'append' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'updated' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统_插件表'");
        
        /* 索引设置 */
        $this->createIndex('name','{{%sys_addons}}','name',0);
        
        
        /* 表数据 */
        $this->insert('{{%sys_addons}}',['id'=>'91','name'=>'AppExample','title'=>'示例管理','cover'=>'','group'=>'','type'=>'plug','brief_introduction'=>'系统的功能示例','description'=>'系统自带的功能使用示例及其说明，包含一些简单的交互','config'=>NULL,'setting'=>'0','hook'=>'1','author'=>'简言','version'=>'1.0','title_initial'=>'S','wechat_message'=>'a:0:{}','is_rule'=>'0','wxapp_support'=>'0','status'=>'1','append'=>'1520385550','updated'=>'1520385550']);
        
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

