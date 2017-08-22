<?php

namespace addons\DebrisGroup\admin\controllers;

use yii;
use yii\data\Pagination;
use common\components\Addons;
use addons\DebrisGroup\common\models\DebrisGroup;
use addons\DebrisGroup\common\models\DebrisGroupCate;

/**
 * 碎片组别控制器
 * Class DebrisGroupController
 * @package backend\controllers
 */
class IndexController extends Addons
{
    /**
     * 首页
     */
    public function actionIndex()
    {
        $request  = Yii::$app->request;
        $cate_id = $request->get('cate_id',0);

        //查询
        $where = [];
        if($cate_id)
        {
            $where['cate_id'] = $cate_id;
        }

        $data = DebrisGroup::find()->where($where);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data
            ->offset($pages->offset)
            ->orderBy('sort')
            ->limit($pages->limit)
            ->all();

        return $this->renderAddon('index',[
            'models'    => $models,
            'pages'     => $pages,
            'cate'      => DebrisGroupCate::getList(),
            'cate_id'   => $cate_id,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * 编辑/新增
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $id       = $request->get('id');
        $cate_id       = $request->get('cate_id');

        $model    = $this->findModel($id);
        $model->cate_id = $cate_id;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirectAddon(['index','cate_id'=>$cate_id]);
        }
        else
        {
            return $this->renderAddon('edit', [
                'model' => $model,
                'cate' => DebrisGroupCate::getOne($cate_id),
            ]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * 删除
     */
    public function actionDelete()
    {
        $cate_id = Yii::$app->request->get('cate_id');
        $id = Yii::$app->request->get('id');
        if($this->findModel($id)->delete())
        {
            $this->message("删除成功",$this->redirectAddon(['index','cate_id'=>$cate_id]));
        }
        else
        {
            $this->message("删除失败",$this->redirectAddon(['index','cate_id'=>$cate_id]),'error');
        }
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
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     * 返回模型
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            $model = new DebrisGroup;
            return $model->loadDefaultValues();
        }

        if (empty(($model = DebrisGroup::findOne($id))))
        {
            return new DebrisGroup;
        }

        return $model;
    }
}
            