<?php
namespace backend\modules\wechat\controllers;

use yii;
use yii\data\Pagination;
use common\models\wechat\MsgHistory;
use common\models\wechat\Rule;
use yii\web\NotFoundHttpException;
/**
 * Class MsgHistoryController
 * @package backend\modules\wechat\controllers
 * 粉丝
 */
class MsgHistoryController extends WController
{
    /**
     * @return string
     * 粉丝列表
     */
    public function actionIndex()
    {
        $request  = Yii::$app->request;

        $type     = $request->get('type','');
        $keyword  = $request->get('keyword','');
        $from_date  = $request->get('from_date',date('Y-m-d',strtotime("-60 day")));
        $to_date  = $request->get('to_date',date('Y-m-d',strtotime("+1 day")));

        $where = [];
        switch ($type)
        {
            case '1':
                $where = ['>', 'rule_id', 0];
                break;
            case '2':
                $where['module'] = Rule::RULE_MODULE_DEFAULT;
                break;
        }
        //关联角色查询
        $data   = MsgHistory::find()->with('fans')
            ->where($where)
            ->andFilterWhere(['between','append',strtotime($from_date),strtotime($to_date)])
            ->andFilterWhere(['message' => $keyword]);

        $pages  = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('append desc')
            ->limit($pages->limit)
            ->all();

        return $this->render('index',[
            'models'  => $models,
            'pages'   => $pages,
            'type'    => $type,
            'keyword' => $keyword,
            'from_date' => $from_date,
            'to_date' => $to_date,
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
            return new MsgHistory;
        }

        if (empty(($model = MsgHistory::findOne($id))))
        {
            return new MsgHistory;
        }

        return $model;
    }
}