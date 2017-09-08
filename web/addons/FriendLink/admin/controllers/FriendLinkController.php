<?php
namespace addons\FriendLink\admin\controllers;

use yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use common\components\Addons;
use addons\FriendLink\common\models\FriendLink;

/**
 * Class FriendLinkController
 * @package backend\controllers
 * 友情链接控制器
 */
class FriendLinkController extends Addons
{
    /**
     * 首页
     */
    public function actionIndex()
    {
        $request  = Yii::$app->request;
        $type = $request->get('type',0);

        //查询
        $where = [];
        if($type)
        {
            $where['type'] = $type;
        }

        $data = FriendLink::find()->where($where);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('sort')
            ->limit($pages->limit)
            ->all();

        return $this->renderAddon('index',[
            'models'    => $models,
            'pages'     => $pages,
            'type'      => $type,
            'linkType'  => FriendLink::$type,
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
        $model    = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirectAddon(['index']);
        }

        return $this->renderAddon('edit', [
            'model'     => $model,
            'linkType'  => FriendLink::$type,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * 删除
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete())
        {
            $this->message("删除成功",$this->redirect(['index']));
        }
        else
        {
            $this->message("删除失败",$this->redirect(['index']),'error');
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
            $model = new FriendLink;
            return $model->loadDefaultValues();
        }

        if (empty(($model = FriendLink::findOne($id))))
        {
            return new FriendLink;
        }

        return $model;
    }
}
            