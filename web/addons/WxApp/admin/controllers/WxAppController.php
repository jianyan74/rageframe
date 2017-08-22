<?php
namespace addons\WxApp\admin\controllers;

use yii;
use common\components\Addons;
use addons\WxApp\common\models\WxApp;

/**
 * 小程序控制器
 * Class WxAppController
 * @package addons\WxApp\admin\controllers
 */
class WxAppController extends Addons
{
    /**
    * 首页
    */
    public function actionIndex()
    {
        return $this->renderAddon('index',[
        ]);
    }
}
            