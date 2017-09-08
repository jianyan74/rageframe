<?php

use yii\db\Migration;

class m170908_042133_addon_sys_links extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addon_sys_links}}', [
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT \'主键\'',
            'title' => 'varchar(80) NOT NULL DEFAULT \'\' COMMENT \'站点名称\'',
            'cover' => 'varchar(100) NULL COMMENT \'封面图片\'',
            'link' => 'varchar(140) NOT NULL COMMENT \'链接地址\'',
            'summary' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'站点描述\'',
            'sort' => 'int(3) unsigned NULL COMMENT \'优先级\'',
            'type' => 'tinyint(3) unsigned NULL DEFAULT \'1\' COMMENT \'类型分组\'',
            'status' => 'tinyint(2) NULL DEFAULT \'1\' COMMENT \'状态（-1：禁用，1：正常）\'',
            'append' => 'int(10) unsigned NULL COMMENT \'添加时间\'',
            'updated' => 'int(10) NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='友情连接表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addon_sys_links}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

