<?php
namespace api\modules\v1;

use Yii;

/**
 * v1 module definition class
 */
class index extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        parent::init();
        # session 设置无效
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
        // custom initialization code goes here
    }
}
