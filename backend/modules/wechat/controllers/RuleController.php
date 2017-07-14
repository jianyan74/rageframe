<?php
namespace backend\modules\wechat\controllers;

use yii;
use common\models\wechat\Rule;
use common\models\wechat\RuleKeyword;
/**
 * Class ReplyController
 * @package backend\modules\wechat\controllers
 * 回复基础控制器
 */
abstract class RuleController extends WController
{
    /**
     * @return string|yii\web\Response
     * 编辑
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
            'title'         => Rule::$module[$this->_module],
            'ruleKeywords'  => $ruleKeywords,
        ]);
    }

    /**
     * @param $id
     * @return $this|Rule|static
     * 返回模型
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
