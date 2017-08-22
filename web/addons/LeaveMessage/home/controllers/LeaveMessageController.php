<?php
namespace addons\LeaveMessage\home\controllers;

use yii;
use common\components\Addons;
use addons\LeaveMessage\common\models\LeaveMessage;

/**
 * Class LeaveMessageController
 * @package backend\controllers
 * 留言管理控制器
 */
class LeaveMessageController extends Addons
{
    /**
     * @return string|\yii\web\Response
     * 编辑/新增
     */
    public function actionAdd()
    {
        $request  = Yii::$app->request;
        $model = new LeaveMessage;
        $model->attributes = $request->post();

        if ($model->save())
        {
            return $this->redirect(['index/index']);
        }

        return $this->redirect(['index/index']);
    }
}
            