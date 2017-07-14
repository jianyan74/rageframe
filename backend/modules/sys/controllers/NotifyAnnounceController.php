<?php
namespace backend\modules\sys\controllers;

use yii;
use yii\data\Pagination;
use common\models\sys\Notify;
use common\models\sys\NotifyManager;
use backend\controllers\MController;

/**
 * 消息公告控制器
 * Class TagController
 * @package backend\modules\sys\controllers
 */
class NotifyAnnounceController extends MController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'upload' => Yii::$app->params['ueditorConfig']
        ];
    }

    /**
     * 系统公告
     * @return string
     */
    public function actionIndex()
    {
        $data = Notify::find()->where(['type' => Notify::TYPE_ANNOUNCE]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->with('manager')
            ->orderBy('append desc')
            ->limit($pages->limit)
            ->all();

        return $this->render('index',[
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    /**
     * 系统公告-编辑/新增
     * @return string|yii\web\Response
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $id   = $request->get('id');
        $model    = $this->findModel($id);
        $model->sender = Yii::$app->user->getId();
        $model->type = Notify::TYPE_ANNOUNCE;
        $model->scenario = 'announce';

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }

        return $this->render('edit', [
            'model'    => $model,
        ]);
    }

    /**
     * 系统公告
     * @return string
     */
    public function actionPersonal()
    {
        $keywords  = Yii::$app->request->get('keywords');

        $where = [];
        if($keywords)
        {
            $where = ['like', 'title', $keywords];//标题
        }

        $data = Notify::find()->where(['type' => Notify::TYPE_ANNOUNCE])->andWhere($where);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->with('manager')
            ->orderBy('append desc')
            ->limit($pages->limit)
            ->all();

        NotifyManager::updateTime();

        return $this->render('personal',[
            'models' => $models,
            'pages' => $pages,
            'keywords' => $keywords,
        ]);
    }

    /**
     * 系统公告-编辑/新增
     * @return string|yii\web\Response
     */
    public function actionView()
    {
        $request  = Yii::$app->request;
        $id   = $request->get('id');
        $model    = $this->findModel($id);

        // 系统公告浏览次数
        Notify::updateAllCounters(['view' => 1], ['id' => $id]);

        return $this->render('view', [
            'model'    => $model,
        ]);
    }

    /**
     * 删除
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete())
        {
            return $this->message("删除成功",$this->redirect(['index']));
        }
        else
        {
            return $this->message("删除失败",$this->redirect(['index']),'error');
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