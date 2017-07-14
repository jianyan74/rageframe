<?php
namespace backend\modules\sys\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\sys\DeskMenu;
use common\helpers\SysArrayHelper;
use backend\controllers\MController;

/**
 * 前台导航控制器
 * Class DeskMenuController
 * @package backend\modules\sys\controllers
 */
class DeskMenuController extends MController
{
    /**
     * @return string
     * 首页
     */
    public function actionIndex()
    {
        $models = DeskMenu::find()->orderBy('sort Asc,append Asc')->asArray()->all();
        $models = SysArrayHelper::itemsMerge($models,'menu_id');

        return $this->render('index', [
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
        $menu_id  = $request->get('menu_id');
        $level    = $request->get('level');
        $pid      = $request->get('pid');
        $parent_title = $request->get('parent_title','无');
        $model        = $this->findModel($menu_id);

        !empty($level) && $model->level = $level;//等级
        !empty($pid)   && $model->pid   = $pid;//上级id

        //设置状态默认值
        !$model->status && $model->status = DeskMenu::STATUS_ON;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }

        return $this->render('edit', [
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
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * 删除
     */
    public function actionDelete($menu_id)
    {
        if($this->findModel($menu_id)->delete())
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
            $model = new DeskMenu;
            return $model->loadDefaultValues();
        }

        if (empty(($model = DeskMenu::findOne($id))))
        {
            return new DeskMenu;
        }

        return $model;
    }
}
