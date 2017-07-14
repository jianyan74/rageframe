<?php
namespace backend\modules\sys\controllers;

use yii;
use yii\helpers\Html;
use common\helpers\SysArrayHelper;
use backend\controllers\MController;
use common\models\sys\ConfigCate;

/**
 * 配置分类控制器
 * Class ConfigCateController
 * @package backend\modules\sys\controllers
 */
class ConfigCateController extends MController
{
    /**
     * 首页
     * @return string
     */
    public function actionIndex()
    {
        $models = ConfigCate::find()
            ->orderBy('sort Asc,append Asc')
            ->asArray()
            ->all();

        return $this->render('index', [
            'models' => SysArrayHelper::itemsMerge($models),
            'configCate' => ConfigCate::getListRoot(),
        ]);
    }

    /**
     * 编辑/新增
     * @return string|\yii\web\Response
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $id  = $request->get('id');
        $level    = $request->get('level');
        $pid      = $request->get('pid');
        $parent_title = $request->get('parent_title','无');
        $model        = $this->findModel($id);

        //等级
        !empty($level) && $model->level = $level;
        //上级id
        !empty($pid) && $model->pid = $pid;

        if ($model->load(Yii::$app->request->post()))
        {
            if($request->isAjax)
            {
                Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
            }
            else
            {
                return $model->save() ? $this->redirect(['index']) : $this->message($this->analysisError($model->getFirstErrors()),$this->redirect(['index']),'error');
            }
        }

        return $this->renderAjax('edit', [
            'model'         => $model,
            'parent_title'  => $parent_title,
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
     * ajax修改
     * @return array
     */
    public function actionUpdateAjax()
    {
        $id = Yii::$app->request->get('id');
        return $this->updateModelData($this->findModel($id));
    }

    /**
     * @param $pid
     */
    public function actionList($pid)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = ConfigCate::getChildList($pid);
        $str = '';
        foreach($model as $value => $name)
        {
            $str .= Html::tag('option',Html::encode($name),array('value'=>$value));
        }

        return $str;
    }

    /**
     * 返回模型
     * @param $id
     * @return $this|ConfigCate|static
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            $model = new ConfigCate;
            return $model->loadDefaultValues();
        }

        if (empty(($model = ConfigCate::findOne($id))))
        {
            return new ConfigCate;
        }

        return $model;
    }

}
