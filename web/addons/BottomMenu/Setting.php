<?php
namespace addons\BottomMenu;

use yii;
use common\components\Addons;
use addons\BottomMenu\common\models\BottomMenu;
/**
 * 全局配置
 * Class SettingController
 * @package addons\BottomMenu
 */
class Setting extends Addons
{
    /**
     * @param null $config 标识
     * @return string 实现钩子
     */
    public function actionHook($addons,$config = null)
    {
        return $this->rederHook($addons,[
            'model' => BottomMenu::find()->where(['name'=>$config])->one()
        ]);
    }
}
            