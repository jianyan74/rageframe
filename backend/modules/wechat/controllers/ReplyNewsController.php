<?php
namespace backend\modules\wechat\controllers;

use common\models\wechat\Rule;
use common\models\wechat\ReplyNews;

/**
 * Class ReplyNewsController
 * @package backend\modules\wechat\controllers
 * 文章回复控制器
 */
class ReplyNewsController extends RuleController
{
    public $_module = Rule::RULE_MODULE_NEWS;

    /**
     * @param $id
     * @return array|ReplyImages|null|\yii\db\ActiveRecord
     * 返回模型
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            return new ReplyNews;
        }

        if (empty(($model = ReplyNews::find()->where(['rule_id'=>$id])->one())))
        {
            return new ReplyNews;
        }

        return $model;
    }
}
