<?php

use yii\db\Migration;

class m180307_012058_sys_pay_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_pay_log}}', [
            'pay_id' => 'int(10) NOT NULL AUTO_INCREMENT COMMENT \'主键\'',
            'openid' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'微信openid\'',
            'mch_id' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'商户支付账户\'',
            'out_trade_no' => 'varchar(32) NULL DEFAULT \'\' COMMENT \'商户订单号\'',
            'transaction_id' => 'varchar(50) NULL DEFAULT \'\' COMMENT \'微信订单号\'',
            'total_fee' => 'double(10,2) NULL DEFAULT \'0\' COMMENT \'微信充值金额\'',
            'pay_type' => 'tinyint(3) NOT NULL DEFAULT \'1\' COMMENT \'支付类型[1:微信;2:支付宝;3:银联]\'',
            'pay_sn' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'订单号\'',
            'ordersn' => 'varchar(20) NULL DEFAULT \'\' COMMENT \'订单号\'',
            'pay_fee' => 'double(10,2) NOT NULL DEFAULT \'0\' COMMENT \'支付金额\'',
            'fee_type' => 'varchar(10) NULL DEFAULT \'\' COMMENT \'标价币种\'',
            'pay_status' => 'tinyint(2) NULL DEFAULT \'-1\' COMMENT \'支付状态\'',
            'group' => 'tinyint(3) NULL DEFAULT \'1\' COMMENT \'组别\'',
            'trade_type' => 'varchar(16) NULL COMMENT \'交易类型，取值为：JSAPI，NATIVE，APP等\'',
            'append' => 'int(10) NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'updated' => 'int(10) NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`pay_id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统_支付日志'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_pay_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

