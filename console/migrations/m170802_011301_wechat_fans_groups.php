<?php

use yii\db\Migration;

class m170802_011301_wechat_fans_groups extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_fans_groups}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'groups' => 'text NULL',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信_用户分组'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%wechat_fans_groups}}',['id'=>'2','groups'=>'a:4:{i:0;a:3:{s:2:"id";i:0;s:4:"name";s:9:"未分组";s:5:"count";i:44;}i:1;a:3:{s:2:"id";i:1;s:4:"name";s:9:"黑名单";s:5:"count";i:0;}i:2;a:3:{s:2:"id";i:2;s:4:"name";s:9:"星标组";s:5:"count";i:1;}i:3;a:3:{s:2:"id";i:101;s:4:"name";s:6:"啦啦";s:5:"count";i:0;}}']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_fans_groups}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

