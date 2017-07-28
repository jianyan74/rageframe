<?php
namespace common\controllers;

use yii;
use EasyWeChat\Payment\Order;

/**
 * 微信基类控制器
 * Class WechatController
 * @package common\controllers
 */
class WechatController extends BaseController
{
    /**
     * 实例化SDK
     * @var
     */
    protected $_app;

    /**
     * 网页授权类别
     * 更多 snsapi_base
     * @var array
     */
    protected $_scopes = ['snsapi_userinfo'];

    /**
     * 当前进入微信用户信息
     * @var
     */
    protected $_wechatMember;

    /**
     * 当前登录的系统用户信息
     * @var
     */
    protected $_member;

    /**
     * 微信支付回调url
     * @var
     */
    protected $_notifyUrl;

    /**
     * 默认检测到微信进入自动获取用户信息
     * @var bool
     */
    protected $_openGetWechatUser = true;

    public function init()
    {
        /**
         * Debug 模式，bool 值：true/false
         *
         * 当值为 false 时，所有的日志都不会记录
         */
        $wechatConfig = [];
        $wechatConfig['debug'] = true;
        /**
         * 账号基本信息，请从微信公众平台/开放平台获取
         */
        $wechatConfig['app_id'] = Yii::$app->config->info('WECHAT_APPID');
        $wechatConfig['secret'] = Yii::$app->config->info('WECHAT_APPSERCRET');
        $wechatConfig['token'] = Yii::$app->config->info('WECHAT_TOKEN');
        $wechatConfig['aes_key'] = Yii::$app->config->info('WECHAT_ENCODINGAESKEY');// EncodingAESKey，安全模式下请一定要填写！！！
        /**
         * 日志配置
         *
         * level: 日志级别, 可选为：
         *         debug/info/notice/warning/error/critical/alert/emergency
         * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
         * file：日志文件位置(绝对路径!!!)，要求可写权限
         */
        $wechatConfig['log']['level'] = 'debug';
        $wechatConfig['log']['permission'] = 0777;
        $wechatConfig['log']['file'] = '/tmp/rageframe/wechat/'.date('Y-m').'/'.date('d').'/rf_wechat.log';
        /**
         * 获取用户信息
         */
        $wechatConfig['oauth']['scopes'] = $this->_scopes;
        $wechatConfig['oauth']['callback'] = '/wechat';
        /**
         * 微信支付配置
         */
        $wechatConfig['payment']['merchant_id'] = Yii::$app->config->info('WECHAT_MCHID');//商户id
        $wechatConfig['payment']['key'] = Yii::$app->config->info('WECHAT_API_KEY');//商户秘钥
        $wechatConfig['payment']['cert_path'] = Yii::$app->config->info('WECHAT_APICLIENT_CERT');// XXX: 绝对路径！！！！
        $wechatConfig['payment']['key_path'] = Yii::$app->config->info('WECHAT_APICLIENT_KEY');// XXX: 绝对路径！！！！
        $wechatConfig['payment']['notify_url'] = $this->_notifyUrl;// 你也可以在下单时单独设置来想覆盖它
        //$wechatConfig['payment']['device_info'] = '';//设备号
        //$wechatConfig['payment']['sub_app_id'] = '';//子商户公众账号
        //$wechatConfig['payment']['sub_merchant_id'] = '';//子商户号

        Yii::$app->params['WECHAT'] = $wechatConfig;
        $this->_app = Yii::$app->wechat->getApp();

        /**
         * 检测到微信进入自动获取用户信息
         */
        $this->_openGetWechatUser && $this->getWechatUser();

        /**
         * 当前进入微信用户信息
         */
        $this->_wechatMember = json_decode(Yii::$app->session->get('wechatUser'),true);
    }

    /**
     * 微信网页授权
     * @return bool
     */
    public function getWechatUser()
    {
        if(Yii::$app->wechat->isWechat && !Yii::$app->wechat->isAuthorized())
        {
            return Yii::$app->wechat->authorizeRequired()->send();
        }

        return false;
    }

    /**
     * 创建支付订单
     * @param $attributes
     * @return array
     */
    protected function wechatPay($attributes)
    {
        $order = new Order($attributes);
        $payment = $this->_app->payment;
        $result = $payment->prepare($order);

        $config = [];
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS')
        {
            $prepayId = $result->prepay_id;
            $config = $payment->configForJSSDKPayment($prepayId); // 返回数组
        }

        return $config;
    }
}