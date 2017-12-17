<?php
namespace common\components;

use Yii;

/**
 * 微信EasyWechat SDK 实例化
 *
 * Trait WechatConfig
 * @package common\controllers
 */
trait WechatConfig
{
    /**
     * Debug 模式，bool 值：true/false
     *
     * 当值为 false 时，所有的日志都不会记录
     */
    protected $_debug = true;

    /**
     * 实例化SDK
     *
     * @var
     */
    protected $_app;

    /**
     * 设置参数
     */
    public function setApp()
    {
        $wechatConfig = [];
        $wechatConfig['debug'] = $this->_debug;
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
        $wechatConfig['log']['file'] = '/tmp/rageframe/wechat/'.date('Y-m').'/'.date('d').'/wechat.log';

        /** 微信支付配置 **/
        $wechatConfig['payment']['merchant_id'] = Yii::$app->config->info('WECHAT_MCHID');// 商户id
        $wechatConfig['payment']['key'] = Yii::$app->config->info('WECHAT_API_KEY');// 商户秘钥
        $wechatConfig['payment']['cert_path'] = Yii::$app->config->info('WECHAT_APICLIENT_CERT');// XXX: 绝对路径！！！！
        $wechatConfig['payment']['key_path'] = Yii::$app->config->info('WECHAT_APICLIENT_KEY');// XXX: 绝对路径！！！！

        // $wechatConfig['payment']['device_info'] = '';// 设备号
        // $wechatConfig['payment']['sub_app_id'] = '';// 子商户公众账号
        // $wechatConfig['payment']['sub_merchant_id'] = '';// 子商户号

        Yii::$app->params['WECHAT'] = $wechatConfig;

        $this->_app = Yii::$app->wechat->getApp();
    }
}