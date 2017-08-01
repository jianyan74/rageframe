<?php
namespace backend\modules\wechat\controllers;

use yii;
use common\models\wechat\Setting;

/**
 * 参数设置控制器
 * Class SettingController
 * @package backend\modules\wechat\controllers
 */
class SettingController extends WController
{
    /**
     * 参数设置
     * @return string|yii\web\Response
     */
    public function actionHistoryStat()
    {
        if ($setting = Yii::$app->request->post('setting'))
        {
            $setting['msg_history_date']['value'] = (int)$setting['msg_history_date']['value'];

            $model = Setting::findModel();
            $model->history = serialize($setting);
            if($model->save())
            {
                return $this->redirect(['history-stat']);
            }
        }

        return $this->render('history-stat',[
            'list' => Setting::getSetting('history'),
        ]);
    }

    /**
     * 特殊消息回复
     * @return string|yii\web\Response
     */
    public function actionSpecialMessage()
    {
        if ($setting = Yii::$app->request->post('setting'))
        {
            $model = Setting::findModel();
            $model->special = serialize($setting);
            if($model->save())
            {
                return $this->redirect(['special-message']);
            }
        }

        return $this->render('special-message',[
            'list' => Setting::getSetting('special'),
        ]);
    }
}
