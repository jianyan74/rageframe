<?php

use yii\db\Migration;

class m170908_042133_addon_sys_debris_group extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addon_sys_debris_group}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(50) NULL COMMENT \'标题\'',
            'cover' => 'varchar(255) NULL COMMENT \'图片\'',
            'link' => 'varchar(1000) NULL',
            'content' => 'longtext NULL COMMENT \'文章\'',
            'character' => 'varchar(255) NULL COMMENT \'文字\'',
            'sort' => 'int(10) NULL DEFAULT \'0\'',
            'cate_id' => 'int(10) NULL',
            'description' => 'varchar(1000) NULL DEFAULT \'\' COMMENT \'描述\'',
            'append' => 'int(10) NULL DEFAULT \'0\'',
            'updated' => 'int(10) NULL DEFAULT \'0\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%addon_sys_debris_group}}',['id'=>'1','title'=>'21312','cover'=>'/attachment/images/2017/08-22/img_vC492a4Jzj.jpg','link'=>'123','content'=>NULL,'character'=>NULL,'sort'=>'0','cate_id'=>'1','description'=>'123','append'=>'1503383012','updated'=>'1503383012']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addon_sys_debris_group}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

