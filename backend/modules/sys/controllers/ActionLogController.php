<?php
namespace backend\modules\sys\controllers;

use yii;
use yii\data\Pagination;
use common\models\sys\ActionLog;
use backend\controllers\MController;

/**
 * 系统日志控制器控制器
 * Class ActionLogController
 * @package backend\modules\sys\controllers
 */
class ActionLogController extends MController
{
    /**
     * 首页
     */
    public function actionIndex()
    {
        $data = ActionLog::find()->with('manager');
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('id desc')
            ->limit($pages->limit)
            ->all();

        return $this->render('index',[
            'models'    => $models,
            'pages'     => $pages,
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
     * 一键清空
     * @return mixed
     */
    public function actionDeleteAll()
    {
        if(ActionLog::deleteAll())
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
     * @return ActionLog|static
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            return new ActionLog;
        }

        if (empty(($model = ActionLog::findOne($id))))
        {
            return new ActionLog;
        }

        return $model;
    }
}