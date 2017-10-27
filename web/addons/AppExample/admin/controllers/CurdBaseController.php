<?php
namespace addons\AppExample\admin\controllers;

use yii;
use yii\data\Pagination;
use common\components\Addons;
use addons\AppExample\common\models\Curd;

/**
 * 示例功能控制器
 * Class CurdController
 * @package addons\Curd\admin\controllers
 */
class CurdBaseController extends Addons
{
     /**
     * 首页
     * @return string
     */
    public function actionIndex()
    {
        $data = Curd::find();
        $pages = new Pagination([
            'totalCount' => $data->count(),
            'pageSize' => $this->_pageSize
        ]);

        $models = $data->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        
        return $this->renderAddon('index',[
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    /**
     * 编辑
     * @return string|yii\web\Response
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $id = $request->get('id');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))
        {
            $model->stat_time = strtotime($model->stat_time);
            $model->end_time = strtotime($model->end_time);
            $model->covers = serialize($model->covers);
            if($model->save())
            {
                return $this->redirectAddon(['index']);
            }
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
     * 全局通用修改排序和状态
     * @param $id
     * @return array
     */
    public function actionAjaxUpdate()
    {
        $id = Yii::$app->request->get('id');
        $insert_data = [];
        $data = Yii::$app->request->get();
        isset($data['status']) && $insert_data['status'] = $data['status'];
        isset($data['sort']) && $insert_data['sort'] = $data['sort'];

        $result = $this->setResult();
        $model = $this->findModel($id);
        $model->attributes = $insert_data;

        if(!$model->save())
        {
            $result->code = 422;
            $result->message = $this->analysisError($model->getFirstErrors());
        }
        else
        {
            $result->code = 200;
            $result->message = '修改成功';
        }

        return $this->getResult();
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
            