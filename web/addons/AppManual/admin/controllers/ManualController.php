<?php
namespace addons\AppManual\admin\controllers;

use yii;
use yii\web\NotFoundHttpException;
use common\components\Addons;
use common\helpers\SysArrayHelper;
use addons\AppManual\common\models\AppManual;

/**
 * 开发手册(文档)控制器
 * Class ManualController
 * @package addons\AppManual\admin\controllers
 */
class ManualController extends Addons
{
    /**
     * @return string
     * 首页
     */
    public function actionIndex()
    {
        $models = AppManual::find()
            ->orderBy('sort asc,append asc')
            ->asArray()
            ->all();

        $models = SysArrayHelper::itemsMerge($models,'id');

        return $this->renderAddon('index', [
            'models' => $models,
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

        !empty($level) && $model->level = $level;//等级
        !empty($pid)   && $model->pid   = $pid;//上级id

        //设置状态默认值
        !$model->status && $model->status = AppManual::STATUS_ON;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirectAddon(['index']);
        }

        return $this->renderAddon('edit', [
            'model'         => $model,
            'parent_title'  => $parent_title,
        ]);
    }

    /**
     * ajax修改
     */
    public function actionUpdateAjax()
    {
        $request = Yii::$app->request;
        if($request->isAjax)
        {
            $result = [];
            $result['flg'] = 2;
            $result['msg'] = "修改失败!";

            $id    = $request->get('id');
            $model = $this->findModel($id);
            $model->attributes = $request->get();
            if($model->validate() && $model->save())
            {
                $result['flg'] = 1;
                $result['msg'] = "修改成功!";
            }
            echo json_encode($result);
        }
        else
        {
            throw new NotFoundHttpException('请求出错!');
        }
    }

    /**
     * 预览
     * @return string
     */
    public function actionView()
    {
        $request  = Yii::$app->request;
        $id  = $request->get('id');

        return $this->renderAjaxAddon('view', [
            'model' => $this->findModel($id),
            'path' => $this->_path
        ]);
    }

    /**
     * 删除
     * @return mixed
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        if($this->findModel($id)->delete())
        {
            return $this->message("删除成功",$this->redirectAddon(['index']));
        }
        else
        {
            return $this->message("删除失败",$this->redirectAddon(['index']),'error');
        }
    }

    /**
     * @param $id
     * @return $this|AppManual|static
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            $model = new AppManual;
            return $model->loadDefaultValues();
        }

        if (empty(($model = AppManual::findOne($id))))
        {
            return new AppManual;
        }

        return $model;
    }
}
