<?php

namespace addons\BottomMenu\admin\controllers;

use yii;
use common\components\Addons;
use common\helpers\SysArrayHelper;
use addons\BottomMenu\common\models\BottomMenu;

/**
 * 底部导航控制器
 * Class BottomMenuController
 * @package backend\controllers
 */
class BottomMenuController extends Addons
{
    /**
    * 首页
    */
    public function actionIndex()
    {
        $models = BottomMenu::find()->orderBy('sort Asc,append Asc')->asArray()->all();
        $models = SysArrayHelper::itemsMerge($models,'single_id');

        return $this->renderAddon('index',[
            'models' => $models,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * 编辑/新增
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $single_id     = $request->get('single_id');
        $level    = $request->get('level');
        $pid      = $request->get('pid');
        $parent_title = $request->get('parent_title','无');
        $model          = $this->findModel($single_id);

        //等级
        !empty($level) && $model->level = $level;
        //上级id
        !empty($pid) && $model->pid = $pid;

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
     * @throws NotFoundHttpException
     * 修改
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
            if($model->save())
            {
                $result['flg'] = 1;
                $result['msg'] = "修改成功!";
            }
            else
            {
                $result['msg'] = $this->analysisError($model->getErrors());
            }

            echo json_encode($result);
        }
        else
        {
            throw new NotFoundHttpException('请求出错!');
        }
    }


    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * 删除
     */
    public function actionDelete($single_id)
    {
        if($this->findModel($single_id)->delete())
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
            $model = new BottomMenu;
            return $model->loadDefaultValues();
        }

        if (empty(($model = BottomMenu::findOne($id))))
        {
            return new BottomMenu;
        }

        return $model;
    }
}
            