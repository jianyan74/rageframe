<?php
namespace wechat\controllers;

use Yii;
use common\controllers\WechatController;

/**
 * 微信应用基类
 *
 * Class WController
 * @package wechat\controllers
 */
class WController extends WechatController
{
    public function init()
    {
        parent::init();
        /** 非微信网页打开时候开启模拟数据 **/
        if(empty($this->_wechatMember) && Yii::$app->params['wecahtSimulate']['appSwitch'] == true)
        {
            $this->_wechatMember = Yii::$app->params['wecahtSimulate']['userInfo'];
        }
    }
}
