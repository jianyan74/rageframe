<?php
namespace addons\AppExample\home\controllers;

use yii;
use common\components\Addons;
use addons\AppExample\common\models\AppExample;

/**
 * 示例功能控制器
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
            