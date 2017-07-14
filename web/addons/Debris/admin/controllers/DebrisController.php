<?php
namespace addons\Debris\admin\controllers;

use yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use common\components\Addons;
use addons\Debris\common\models\Debris;

/**
 * 碎片管理控制器
 * Class DebrisController
 * @package addons\Debris\admin\controllers
 */
class DebrisController extends Addons
{
    /**
     * 首页
     */
    public function actionIndex()
    {
        $data = Debris::find();
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->renderAddon('index',[
            'pages' => $pages,
            'models' => $models
        ]);
    }

    /**
     * 编辑
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $id = $request->get('id');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirectAddon(['index']);
        }

        return $this->renderAddon('edit',[
            'model' => $model
        ]);
    }

    /**
     * 删除
     */
    public function actionDelete()
    {
        $id =  Yii::$app->request->get('id');
        if($this->findModel($id)->delete())
        {
            $this->message("删除成功",$this->redirectAddon(['index']));
        }
        else
        {
            $this->message("删除失败",$this->redirectAddon(['index']),'error');
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
            $model = new Debris;
            return $model->loadDefaultValues();
        }

        if (empty(($model = Debris::findOne($id))))
        {
            return new Debris;
        }

        return $model;
    }
}
            