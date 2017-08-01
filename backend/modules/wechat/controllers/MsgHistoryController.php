<?php
namespace backend\modules\wechat\controllers;

use yii;
use yii\data\Pagination;
use common\models\wechat\MsgHistory;
use common\models\wechat\Rule;

/**
 * 历史消息控制器
 * Class MsgHistoryController
 * @package backend\modules\wechat\controllers
 */
class MsgHistoryController extends WController
{
    /**
     * 消息列表
     * @return string
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
     * 删除消息
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
     * 返回模型
     * @param $id
     * @return MsgHistory|static
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