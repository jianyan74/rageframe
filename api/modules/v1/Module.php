<?php
namespace api\modules\v1;

use Yii;

/**
 * Class Module
 * @package api\modules\v1
 */
class Module extends \yii\base\Module
{
    /**
     * @var string
     */
    public $controllerNamespace = 'api\modules\v1\controllers';

    public function init()
    {
        parent::init();
        //session 设置无效
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
    }
}
