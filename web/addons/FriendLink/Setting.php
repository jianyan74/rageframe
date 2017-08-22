<?php
namespace addons\FriendLink;

use yii;
use common\components\Addons;
use addons\FriendLink\common\models\FriendLink;

/**
 * Class SettingController
 * @package addons\FriendLink
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
            