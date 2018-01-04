<?php

use yii\db\Migration;

class m180104_024350_wechat_fans_stat extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_fans_stat}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'new_attention' => 'int(10) unsigned NOT NULL COMMENT \'今日新关注\'',
            'cancel_attention' => 'int(10) unsigned NOT NULL COMMENT \'今日取消关注\'',
            'cumulate_attention' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'累计关注\'',
            'date' => 'date NOT NULL',
            'append' => 'int(10) NULL DEFAULT \'0\'',
            'updated' => 'int(10) NULL DEFAULT \'0\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信关注统计表'");
        
        /* 索引设置 */
        $this->createIndex('uniacid','{{%wechat_fans_stat}}','date',0);
        
        
        /* 表数据 */
        $this->insert('{{%wechat_fans_stat}}',['id'=>'60','new_attention'=>'0','cancel_attention'=>'0','cumulate_attention'=>'16','date'=>'2017-12-28','append'=>'1514390400','updated'=>'1515033784']);
        $this->insert('{{%wechat_fans_stat}}',['id'=>'61','new_attention'=>'0','cancel_attention'=>'0','cumulate_attention'=>'16','date'=>'2017-12-29','append'=>'1514476800','updated'=>'1515033784']);
        $this->insert('{{%wechat_fans_stat}}',['id'=>'62','new_attention'=>'0','cancel_attention'=>'0','cumulate_attention'=>'16','date'=>'2017-12-30','append'=>'1514563200','updated'=>'1515033784']);
        $this->insert('{{%wechat_fans_stat}}',['id'=>'63','new_attention'=>'0','cancel_attention'=>'0','cumulate_attention'=>'16','date'=>'2017-12-31','append'=>'1514649600','updated'=>'1515033784']);
        $this->insert('{{%wechat_fans_stat}}',['id'=>'64','new_attention'=>'0','cancel_attention'=>'0','cumulate_attention'=>'16','date'=>'2018-01-01','append'=>'1514736000','updated'=>'1515033784']);
        $this->insert('{{%wechat_fans_stat}}',['id'=>'65','new_attention'=>'0','cancel_attention'=>'0','cumulate_attention'=>'16','date'=>'2018-01-02','append'=>'1514822400','updated'=>'1515033784']);
        $this->insert('{{%wechat_fans_stat}}',['id'=>'66','new_attention'=>'0','cancel_attention'=>'0','cumulate_attention'=>'16','date'=>'2018-01-03','append'=>'1514908800','updated'=>'1515033784']);
        $this->insert('{{%wechat_fans_stat}}',['id'=>'67','new_attention'=>'0','cancel_attention'=>'0','cumulate_attention'=>'0','date'=>'2018-01-04','append'=>'1514995200','updated'=>'1515033784']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_fans_stat}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

