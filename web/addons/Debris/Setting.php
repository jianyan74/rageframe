<?php
namespace addons\Debris;

use yii;
use common\components\Addons;
use addons\Debris\common\models\Debris;

/**
 * 全局配置
 * Class SettingController
 * @package addons\Debris
 */
class Setting extends Addons
{
    /**
     * 钩子
     * @param $addon -模块名称
     * @param null $config ->前台传递过来的参数
     * @return string
     */
    public function actionHook($addon,$config = null)
    {
        return $this->rederHook($addon,[
            'model' => Debris::find()->where(['name' => $config])->one()
        ]);
    }
}
            