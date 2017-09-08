<?php

use yii\db\Migration;

class m170908_042136_wechat_rule extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_rule}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'name' => 'varchar(50) NOT NULL DEFAULT \'\'',
            'module' => 'varchar(50) NOT NULL',
            'displayorder' => 'int(10) unsigned NOT NULL',
            'status' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'状态[1：启用;-1禁用]\'',
            'append' => 'int(10) NULL',
            'updated' => 'int(10) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='微信_回复规则名称表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_rule}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

