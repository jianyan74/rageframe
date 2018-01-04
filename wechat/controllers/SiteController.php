<?php
namespace wechat\controllers;

/**
 * 默认首页控制器
 *
 * Class SiteController
 * @package wechat\controllers
 */
class SiteController extends WController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 微信首页
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 验证登录根据openid
     *
     */
    public function actionLogin()
    {

    }

    public function actionTest()
    {
        $user = $this->_wechatMember;

        $result = $this->wechatPay([
            'body' => '腾讯充值中心-QQ会员充值',
            'out_trade_no' => '20150806125346',
            'total_fee' => 88,
            'notify_url' => 'https://pay.weixin.qq.com/wxpay/pay.action', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid' => $user['id'],
        ]);

        // 测试
        p($result);
    }
}
