<?php
namespace addons\DebrisGroup;

use yii;
use common\components\Addons;
use addons\DebrisGroup\common\models\DebrisGroupCate;

/**
 * 全局配置
 * Class SettingController
 * @package addons\DebrisGroup
 */
class Setting extends Addons
{
    /**
    * @param $addons 模块名字
    * @param null $config 参数
    * @return string
    */
    public function actionHook($addons, $config = null)
    {
        return $this->rederHook($addons,[
            'model' => DebrisGroupCate::find()->with('debrisGroup')->where(['name'=>$config])->asArray()->one()
        ]);
    }
}
            