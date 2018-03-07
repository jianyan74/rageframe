<?php
namespace addons\AppExample\home\controllers;

use yii;
use common\components\Addons;

/**
 * 示例功能控制器
 *
 * Class AppExampleController
 * @package addons\AppExample\home\controllers
 */
class AppExampleController extends Addons
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
            