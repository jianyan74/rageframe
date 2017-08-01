<?php
namespace backend\modules\sys\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use common\models\sys\Cate;
use common\helpers\SysArrayHelper;
use backend\controllers\MController;

/**
 * 分类控制器
 * Class CateController
 * @package backend\modules\sys\controllers
 */
class CateController extends MController
{
    /**
     * 首页
     * @return string
     */
    public function actionIndex()
    {
        $models = Cate::find()
            ->orderBy('sort Asc,append Asc')
            ->asArray()
            ->all();

        $models = SysArrayHelper::itemsMerge($models,'cate_id');

        return $this->render('index', [
            'models' => $models,
        ]);
    }

    /**
     * 编辑
     * @return array|mixed|string|\yii\web\Response
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $cate_id  = $request->get('cate_id');
        $level    = $request->get('level');
        $pid      = $request->get('pid');
        $parent_title = $request->get('parent_title','无');
        $model        = $this->findModel($cate_id);

        !empty($level) && $model->level = $level;//等级
        !empty($pid) && $model->pid   = $pid;//上级id

        if ($model->load(Yii::$app->request->post()))
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

        return $this->renderAjax('edit', [
            'model'         => $model,
            'parent_title'  => $parent_title,
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
     * @param $pid
     */
    public function actionList($pid, $typeid = 0)
    {
        $model = Cate::getList($pid);

        if(!$pid)
        {
            $str = Html::tag('option',"请选择二级分类", ['value'=>'']);
            return json_encode($str);
        }

        $str = Html::tag('option',"请选择二级分类", ['value'=>'']);

        foreach($model as $value=>$name)
        {
            $str .= Html::tag('option',Html::encode($name),array('value'=>$value));
        }

        echo json_encode($str);
    }

    /**
     * 删除
     * @param $cate_id
     * @return mixed
     */
    public function actionDelete($cate_id)
    {
        if($this->findModel($cate_id)->delete())
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
     * @return $this|Cate|static
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            $model = new Cate;
            return $model->loadDefaultValues();
        }

        if (empty(($model = Cate::findOne($id))))
        {
            return new Cate;
        }

        return $model;
    }
}
