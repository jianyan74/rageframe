<?php
namespace backend\modules\sys\controllers;

use yii;
use common\helpers\SysArrayHelper;
use backend\controllers\MController;
use backend\modules\sys\models\Menu;

/**
 * 菜单控制器
 * Class MenuController
 * @package backend\modules\sys\controllers
 */
class MenuController extends MController
{
    /**
     * 首页
     * @return string
     */
    public function actionIndex()
    {
        $type = Yii::$app->request->get('type','menu');
        $models = Menu::find()
            ->where(['type'=>$type])
            ->orderBy('sort Asc,append Asc')
            ->asArray()
            ->all();

        $models = SysArrayHelper::itemsMerge($models,'menu_id');

        return $this->render('index', [
            'models' => $models,
            'type' => $type,
            'menuType' => Menu::$type,
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
        $type = $request->get('type');
        $model        = $this->findModel($menu_id);
        $model->type = $type;

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
                return $model->save() ? $this->redirect(['index','type'=>$type]) : $this->message($this->analysisError($model->getFirstErrors()),$this->redirect(['index','type'=>$type]),'error');
            }
        }

        return $this->renderAjax('edit', [
            'model'         => $model,
            'parent_title'  => $parent_title,
        ]);
    }

    /**
     * 删除
     * @param $menu_id
     * @return mixed
     */
    public function actionDelete($menu_id)
    {
        $type = Yii::$app->request->get('type');
        if($this->findModel($menu_id)->delete())
        {
            return $this->message("删除成功",$this->redirect(['index','type' => $type]));
        }
        else
        {
            return $this->message("删除失败",$this->redirect(['index','type' => $type]),'error');
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
     * 返回模型
     * @param $id
     * @return $this|Menu|static
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            $model = new Menu;
            return $model->loadDefaultValues();
        }

        if (empty(($model = Menu::findOne($id))))
        {
            return new Menu;
        }

        return $model;
    }

}
