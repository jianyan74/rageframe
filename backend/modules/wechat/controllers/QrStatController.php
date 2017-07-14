<?php
namespace backend\modules\wechat\controllers;

use yii;
use yii\data\Pagination;
use common\models\wechat\QrcodeStat;
/**
 * Class QrStatController
 * @package backend\modules\wechat\controllers
 * 二维码扫描统计
 */
class QrStatController extends WController
{
    /**
     * 首页
     */
    public function actionIndex()
    {
        $request  = Yii::$app->request;
        $type     = $request->get('type',1);
        $keyword  = $request->get('keyword');
        $from_date  = $request->get('from_date',date('Y-m-d',strtotime("-60 day")));
        $to_date  = $request->get('to_date',date('Y-m-d',strtotime("+1 day")));

        $where = [];
        if($keyword)
        {
            if($type == 1)
            {
                $where = ['like', 'name', $keyword];//标题
            }
        }

        $data = QrcodeStat::find()->where($where)->andFilterWhere(['between','append',strtotime($from_date),strtotime($to_date)]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
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
     * @throws \Exception
     * 删除
     */
    public function actionDelete($id)
    {
        if(QrcodeStat::findOne($id)->delete())
        {
            return $this->message("删除成功",$this->redirect(['index']));
        }
        else
        {
            return $this->message("删除失败",$this->redirect(['index']),'error');
        }
    }
}
