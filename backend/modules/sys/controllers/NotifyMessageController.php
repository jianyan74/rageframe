<?php
namespace backend\modules\sys\controllers;

use yii;
use yii\data\Pagination;
use common\models\sys\Notify;
use common\models\sys\NotifyManager;
use backend\controllers\MController;

/**
 * 消息控制器
 * Class TagController
 * @package backend\modules\sys\controllers
 */
class NotifyMessageController extends MController
{
    /**
     * 系统私信
     * @return string
     */
    public function actionIndex()
    {
        $data = Notify::find()->where(['type' => Notify::TYPE_MESSAGE]);
        $data->andFilterWhere(['sender' => Yii::$app->user->identity->id]);
        $data->andWhere(['sender_display'=>Notify::TYPE_ANNOUNCE]);

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->with('managerTarget')
            ->orderBy('append desc')
            ->limit($pages->limit)
            ->all();

        return $this->render('index',[
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    /**
     * 系统私信-编辑/新增
     * @return string|yii\web\Response
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $id   = $request->get('id');
        $model    = $this->findModel($id);
        $model->sender = Yii::$app->user->getId();
        $model->type = Notify::TYPE_MESSAGE;
        $model->target_type = Notify::TARGET_TYPE_MANAGER;
        $model->scenario = 'message';

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }

        return $this->render('edit', [
            'model'    => $model,
        ]);
    }

    /**
     * 系统消息
     * @return string
     */
    public function actionPersonal()
    {
        $keywords  = Yii::$app->request->get('keywords');

        $where = [];
        if($keywords)
        {
            $where = ['like', 'content', $keywords];//标题
        }

        $data = Notify::find()
            ->where(['type' => Notify::TYPE_MESSAGE,'target'=>Yii::$app->user->id])
            ->andWhere(['target_display'=>Notify::TYPE_ANNOUNCE])
            ->andWhere($where);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->with('manager')
            ->orderBy('append desc')
            ->limit($pages->limit)
            ->all();

        NotifyManager::updateTime('last_message_time');

        return $this->render('personal',[
            'models' => $models,
            'pages' => $pages,
            'keywords' => $keywords,
        ]);
    }

    /**
     * 发送者逻辑删除
     * @param $id
     * @return mixed
     */
    public function actionSenderDelete($id)
    {
        $model = $this->findModel($id);
        $model->sender_display = Notify::DISPLAY_OFF;
        if($model->save())
        {
            return $this->message("删除成功",$this->redirect(['index']));
        }
        else
        {
            return $this->message("删除失败",$this->redirect(['index']),'error');
        }
    }

    /**
     * 发送者逻辑删除
     * @param $id
     * @return mixed
     */
    public function actionTargetDelete($id)
    {
        $model = $this->findModel($id);
        $model->target_display = Notify::DISPLAY_OFF;
        if($model->save())
        {
            return $this->message("删除成功",$this->redirect(['personal']));
        }
        else
        {
            return $this->message("删除失败",$this->redirect(['personal']),'error');
        }
    }

    /**
     * 返回模型
     * @param $id
     * @return $this|Notify|static
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            $model = new Notify;
            return $model->loadDefaultValues();
        }

        if (empty(($model = Notify::findOne($id))))
        {
            return new Notify;
        }

        return $model;
    }
}