<?php
namespace wechat\controllers;

use Yii;
use yii\helpers\Url;
use common\controllers\AddonsBaseController;

/**
 * 微信插件渲染控制器
 * Class AddonsController
 * @package wechat\controllers
 */
class AddonsController extends AddonsBaseController
{
    public function init()
    {
        /**
         * 微信支付回调地址
         */
        $this->_notifyUrl = Yii::$app->request->hostInfo . Url::to(['/we-notify/notify']);
        /**
         * 继承
         */
        parent::init();
        /**
         * 非微信网页打开时候开启模拟数据
         */
        if(Yii::$app->params['wecahtSimulate']['addonSwitch'] == true && empty($this->_wechatMember))
        {
            $this->_wechatMember = Yii::$app->params['wecahtSimulate']['userInfo'];
        }
    }
}
