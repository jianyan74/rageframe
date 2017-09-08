<?php

use yii\db\Migration;

class m170908_042133_addon_sys_adv extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addon_sys_adv}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT COMMENT \'序号\'',
            'title' => 'varchar(30) NOT NULL COMMENT \'标题\'',
            'cover' => 'varchar(100) NULL COMMENT \'图片\'',
            'location_id' => 'int(11) NULL DEFAULT \'0\' COMMENT \'广告位ID\'',
            'silder_text' => 'varchar(255) NULL DEFAULT \' \' COMMENT \'图片描述\'',
            'start_time' => 'int(10) NULL COMMENT \'开始时间\'',
            'end_time' => 'int(10) NULL COMMENT \'结束时间\'',
            'jump_link' => 'varchar(255) NULL COMMENT \'跳转链接\'',
            'jump_type' => 'tinyint(1) NULL DEFAULT \'1\' COMMENT \'跳转方式[1:新标签; 2:当前页]\'',
            'sort' => 'int(5) NULL DEFAULT \'0\' COMMENT \'优先级（0-9）\'',
            'status' => 'tinyint(2) NOT NULL DEFAULT \'1\' COMMENT \'状态（-1：禁用，1：正常）\'',
            'groups' => 'tinyint(5) NULL DEFAULT \'0\' COMMENT \'幻灯片分组\'',
            'append' => 'int(10) NULL COMMENT \'创建时间\'',
            'updated' => 'int(10) NULL COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addon_sys_adv}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

