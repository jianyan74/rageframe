<?php

use yii\db\Migration;

class m180307_012100_wechat_reply_basic extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_reply_basic}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'rule_id' => 'int(10) NULL DEFAULT \'0\' COMMENT \'规则id\'',
            'attach_id' => 'int(11) NULL DEFAULT \'0\' COMMENT \'素材id\'',
            'content' => 'varchar(1000) NULL COMMENT \'内容\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信_文字回复'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_reply_basic}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

