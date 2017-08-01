<?php
namespace backend\modules\wechat\controllers;

use yii;
use backend\controllers\MController;

/**
 * 微信基类控制器
 * Class WController
 * @package backend\modules\wechat\controllers
 */
class WController extends MController
{
    /**
     * @var
     * 实例化SDK
     */
    protected $_app;

    /**
     * 自动运行
     */
    public function init()
    {
        /**
         * Debug 模式，bool 值：true/false
         *
         * 当值为 false 时，所有的日志都不会记录
         */
        Yii::$app->params['WECHAT']['debug'] = true;
        /**
         * 账号基本信息，请从微信公众平台/开放平台获取
         */
        Yii::$app->params['WECHAT']['app_id'] = Yii::$app->config->info('WECHAT_APPID');
        Yii::$app->params['WECHAT']['secret'] = Yii::$app->config->info('WECHAT_APPSERCRET');
        Yii::$app->params['WECHAT']['token'] = Yii::$app->config->info('WECHAT_TOKEN');
        Yii::$app->params['WECHAT']['aes_key'] = Yii::$app->config->info('WECHAT_ENCODINGAESKEY');// EncodingAESKey，安全模式下请一定要填写！！！
        /**
         * 日志配置
         *
         * level: 日志级别, 可选为：
         *         debug/info/notice/warning/error/critical/alert/emergency
         * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
         * file：日志文件位置(绝对路径!!!)，要求可写权限
         */
        Yii::$app->params['WECHAT']['log']['level'] = 'debug';
        Yii::$app->params['WECHAT']['log']['permission'] = 0777;
        Yii::$app->params['WECHAT']['log']['file'] = '/tmp/rageframe/backend/'.date('Y-m').'/'.date('d').'/rf_wechat.log';

        $this->_app = Yii::$app->wechat->getApp();

        parent::init();
    }
}
