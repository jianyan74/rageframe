<?php
namespace addons\AppManual;

use yii;
use common\components\Addons;
use addons\AppManual\common\models\AppManual;

/**
 * 全局配置
 * Class SettingController
 * @package addons\AppManual
 */
class Setting extends Addons
{
    /**
     * 配置默认首页
     * @return string
     */
    public function actionDisplay()
    {
        $request  = Yii::$app->request;
        if($request->isPost)
        {
            $config = $request->post('config');
            $this->setConfig($config);
        }
        
        return $this->renderAddon('index',[
            'config' => $this->getConfig()
        ]);
    }
}
            