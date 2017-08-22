<?php
namespace addons\LeaveMessage\admin\controllers;

use yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use common\components\Addons;
use addons\LeaveMessage\common\models\LeaveMessage;
/**
 * Class LeaveMessageController
 * @package backend\controllers
 * 留言管理控制器
 */
class LeaveMessageController extends Addons
{
    /**
     * 首页
     */
    public function actionIndex()
    {
        $request  = Yii::$app->request;
        $type     = $request->get('type',1);
        $keyword  = $request->get('keyword');

        $where = [];
        if($keyword)
        {
            if($type == 1)
            {
                //真实姓名
                $where = ['like', 'realname', $keyword];
            }
            elseif($type == 2)
            {
                //手机号码
                $where = ['like', 'mobile', $keyword];
            }
            elseif($type == 3)
            {
                //内容
                $where = ['like', 'content', $keyword];
            }
        }

        $data = LeaveMessage::find()->where($where);
        $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => $this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('append')
            ->limit($pages->limit)
            ->all();

        return $this->renderAddon('index',[
            'models'    => $models,
            'pages'     => $pages,
            'type'      => $type,
            'keyword'   => $keyword,
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
            'model'    => $model,
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
            $this->message("删除成功",$this->redirectAddon(['index']));
        }
        else
        {
            $this->message("删除失败",$this->redirectAddon(['index']),'error');
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
            $model = new LeaveMessage;
            return $model->loadDefaultValues();
        }

        if (empty(($model = LeaveMessage::findOne($id))))
        {
            return new LeaveMessage;
        }

        return $model;
    }
}
            