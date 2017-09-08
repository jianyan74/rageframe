<?php
namespace addons\Adv;

use yii;
use common\components\Addons;
use addons\Adv\common\models\AdvLocation;

/**
 * Class SettingController
 * @package addons\Adv
 * 全局配置
 */
class Setting extends Addons
{
    /**
     * @param $addons -模块名字
     * @param null $config -参数
     * @return string
     */
    public function actionHook($addons, $config = null)
    {
        return $this->rederHook($addons,[
            'models' => AdvLocation::find()->with('adv')->where(['name' => $config])->all()
        ]);
    }
}
            