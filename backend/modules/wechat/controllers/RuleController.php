<?php
namespace backend\modules\wechat\controllers;

use yii;
use yii\data\Pagination;
use common\models\wechat\Rule;
use common\models\wechat\RuleKeyword;

/**
 * 规则控制器
 * Class RuleController
 * @package backend\modules\wechat\controllers
 */
class RuleController extends WController
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
            'modules'   => Rule::$moduleExplain,
            'module'   => $module,
            'models'  => $models,
            'pages'   => $pages,
            'type'    => $type,
            'keyword' => $keyword,
        ]);
    }

    /**
     * 编辑
     * @return mixed|string|yii\web\Response
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $id       = $request->get('id');

        //回复规则
        $rule    = $this->findRuleModel($id);
        //默认关键字
        $keyword = new RuleKeyword();
        //基础
        $model     = $this->findModel($id);

        //关键字列表
        $ruleKeywords = [
            RuleKeyword::TYPE_MATCH => [],
            RuleKeyword::TYPE_REGULAR => [],
            RuleKeyword::TYPE_INCLUDE => [],
            RuleKeyword::TYPE_TAKE => [],
        ];

        if($rule['ruleKeyword'])
        {
            foreach ($rule['ruleKeyword'] as  $value)
            {
                $ruleKeywords[$value['type']][] = $value['content'];
            }
        }

        if ($rule->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post()) && $keyword->load(Yii::$app->request->post()))
        {
            $transaction = Yii::$app->db->beginTransaction();
            try
            {
                //编辑
                if($rule->save())
                {
                    //获取规则ID
                    $rule_id = $rule->isNewRecord ?  Yii::$app->db->getLastInsertID() : $rule->id;
                    $model->rule_id = $rule_id;
                    //其他匹配包含关键字
                    $otherKeywords = Yii::$app->request->post('ruleKey',[]);
                    $resultKeywords = $keyword->updateKeywords($keyword->content,$otherKeywords,$ruleKeywords,$rule_id,$this->_module,$rule);

                    if($model->save() && $resultKeywords)
                    {
                        $transaction->commit();
                        return $this->redirect(['reply/index','module'=>$rule->module]);
                    }
                }
            }
            catch (\Exception $e)
            {
                $transaction->rollBack();
                return $this->message($e->getMessage(),$this->redirect(['reply/index']),'error');
            }
        }

        return $this->render('edit',[
            'rule'          => $rule,
            'model'         => $model,
            'keyword'       => $keyword,
            'title'         => Rule::$moduleExplain[$this->_module],
            'ruleKeywords'  => $ruleKeywords,
        ]);
    }

    /**
     * ajax修改
     * @return array
     */
    public function actionUpdateAjax()
    {
        $id = Yii::$app->request->get('id');
        return $this->updateModelData($this->findRuleModel($id));
    }

    /**
     * 删除
     * @param $id
     * @return mixed
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

    /**
     * 返回模型
     * @param $id
     * @return $this|Rule|static
     */
    protected function findRuleModel($id)
    {
        if (empty($id))
        {
            $model = new Rule;
            $model->module = $this->_module;
            return $model->loadDefaultValues();
        }

        if (empty(($model = Rule::findOne($id))))
        {
            $model = new Rule;
            $model->module = $this->_module;
            return $model->loadDefaultValues();
        }

        return $model;
    }
}
