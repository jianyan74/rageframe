<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use jianyan\basics\common\models\wechat\Setting;
use jianyan\basics\common\models\wechat\MsgHistory;

/**
 * Class MsgHistory
 * @package console\controllers
 */
class MsgHistoryController extends Controller
{
    /**
     * 清理过期的历史记录
     */
    public function actionIndex()
    {
        $model = Setting::find()->one();
        if($model && !empty($model->history))
        {
            $history = unserialize($model->history);
            if($history['msg_history_date']['value'] > 0)
            {
                $one_day = 60 * 60 * 24;
                $time = time() - $one_day * $history['msg_history_date']['value'];
                MsgHistory::deleteAll(['<=', 'append', $time]);

                echo date('Y-m-d H:i:s') . ' --- ' . '清理成功;' . PHP_EOL;
                exit();
            }
        }

        echo date('Y-m-d H:i:s') . ' --- ' . '数据设置未清除;' . PHP_EOL;
        exit();
    }
}