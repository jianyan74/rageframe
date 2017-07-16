<?php
namespace backend\modules\sys\controllers;

use yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use common\models\sys\Tag;
use backend\controllers\MController;

/**
 * 标签管理控制器
 * Class TagController
 * @package backend\modules\sys\controllers
 */
class TagController extends MController
{
    /**
     * 首页
     */
    public function actionIndex()
    {
        $data = Tag::find();
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('sort')
            ->limit($pages->limit)
            ->all();

        return $this->render('index',[
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    /**
     * 编辑/新增
     * @return string|\yii\web\Response
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $id   = $request->get('id');
        $model    = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }

        return $this->render('edit', [
            'model'    => $model,
        ]);
    }

    /**
     * ajax修改
     * @return array
     */
    public function actionUpdateAjax()
    {
        $id = Yii::$app->request->get('id');
        return $this->updateModelData($this->findModel($id));
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
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     * 返回模型
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            $model = new Tag;
            return $model->loadDefaultValues();
        }

        if (empty(($model = Tag::findOne($id))))
        {
            return new Tag;
        }

        return $model;
    }
}