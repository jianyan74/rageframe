<?php
namespace backend\modules\sys\controllers;

use yii;
use common\helpers\SysArrayHelper;
use yii\web\NotFoundHttpException;
use backend\modules\sys\models\AuthItem;
use backend\controllers\MController;

/**
 * RBAC权限控制器
 * Class AuthAccreditController
 * @package backend\modules\sys\controllers
 */
class AuthAccreditController extends MController
{
    /**
     * 权限管理
     */
    public function actionIndex()
    {
        $models   = AuthItem::find()->where(['type'=>AuthItem::AUTH])
            ->asArray()
            ->orderBy('sort asc')
            ->all();

        return $this->render('index',[
            'models' => SysArrayHelper::itemsMerge($models,'key',0,'parent_key'),
        ]);
    }

    /**
     * 权限编辑
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $name     = $request->get('name');
        $model    = $this->findModel($name);

        $level    = $request->get('level',1);
        !empty($level) && $model->level = $level;//等级

        //表单提交
        if($model->load($request->post()))
        {
            if($request->isAjax)
            {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
            }
            else
            {
                return $model->save() ? $this->redirect(['index']) : $this->message($this->analysisError($model->getFirstErrors()),$this->redirect(['index']),'error');
            }
        }

        //父级key
        $parent_key = $request->get('parent_key',0);
        if($parent_key == 0)
        {
            $parent_name = "暂无";
        }
        else
        {
            $prent = AuthItem::find()->where(['key'=>$parent_key])->one();
            $parent_name = $prent['description'];
        }

        return $this->renderAjax('edit', [
            'model'       => $model,
            'parent_key'  => $parent_key,
            'parent_name' => $parent_name,
        ]);
    }

    /**
     * 权限删除
     */
    public function actionDelete($name)
    {
        if($this->findModel($name)->delete())
        {
            $this->message('权限删除成功',$this->redirect(['index']));
        }
        else
        {
            $this->message('权限删除失败',$this->redirect(['index']),'error');
        }
    }

    /**
     * ajax修改
     * @return array
     */
    public function actionUpdateAjax()
    {
        $name = Yii::$app->request->get('name');
        return $this->updateModelData($this->findModel($name));
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
            $model = new AuthItem;
            return $model->loadDefaultValues();
        }

        if (empty(($model = AuthItem::findOne($id))))
        {
            return new AuthItem;
        }

        return $model;
    }
}