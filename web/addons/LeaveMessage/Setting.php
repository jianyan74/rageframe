<?php
namespace addons\LeaveMessage;

use yii;
use common\components\Addons;
use addons\LeaveMessage\admin\models\LeaveMessage;
/**
 * Class SettingController
 * @package addons\LeaveMessage
 * 全局配置
 */
class Setting extends Addons
{
    
    
    /**
    * @param $addons 模块名字
    * @param null $config 参数
    * @return string
    */
    public function actionHook($addons,$config = null)
    {
        return $this->rederHook($addons,[
        ]);
    }
}
            