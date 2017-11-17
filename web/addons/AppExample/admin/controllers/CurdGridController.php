<?php

namespace addons\AppExample\admin\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\components\Addons;
use addons\AppExample\common\models\Curd;
use addons\AppExample\common\models\CurdSearch;

/**
 * CurdGridController implements the CRUD actions for Curd model.
 */
class CurdGridController extends Addons
{
    /**
     * Lists all Curd models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CurdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAddon('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Curd model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAddon('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Curd model.
     * If creation is successful, the browser will be redirectAddoned to the 'view' page.
     * @return mixed
     */
    public function actionEdit()
    {
        $model = new Curd();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirectAddon(['view', 'id' => $model->id]);
        } else {
            return $this->renderAddon('edit', [
                'model' => $model,
            ]);
        }
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
     * 返回模型
     * @param $id
     * @return $this|Curd|static
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            $model = new Curd;
            return $model->loadDefaultValues();
        }

        if (empty(($model = Curd::findOne($id))))
        {
            $model = new Curd;
            return $model->loadDefaultValues();
        }

        return $model;
    }
}
