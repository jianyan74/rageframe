<?php
namespace backend\modules\wechat\controllers;

use yii;
use yii\data\Pagination;
use common\models\wechat\Rule;

/**
 * Class ReplyController
 * @package backend\modules\wechat\controllers
 * 自动回复控制器
 */
class ReplyController extends WController
{
    /**
     * @return string
     * 首页
     */
    public function actionIndex()
    {
        $request  = Yii::$app->request;
        $module     = $request->get('module','');

        $type     = $request->get('type','');
        $keyword  = $request->get('keyword','');

        $where = [];
        switch ($type)
        {
            case '1':
                $where['status'] = 1;
                break;
            case '2':
                $where['status'] = -1;
                break;
        }

        $data   = Rule::find()->with('ruleKeyword')
            ->andFilterWhere(['module' => $module])
            ->andFilterWhere($where)
            ->andFilterWhere(['like', 'name', $keyword]);

        $pages  = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('displayorder desc,append desc')
            ->limit($pages->limit)
            ->all();

        return $this->render('index',[
            'modules'   => Rule::$module,
            'module'   => $module,
            'models'  => $models,
            'pages'   => $pages,
            'type'    => $type,
            'keyword' => $keyword,
        ]);
    }

    /**
     * @param $id
     * 删除
     */
    public function actionDelete($id)
    {
        if($this->findRuleModel($id)->delete())
        {
            return $this->message("删除成功",$this->redirect(['index']));
        }
        else
        {
            return $this->message("删除失败",$this->redirect(['index']),'error');
        }
    }
}
