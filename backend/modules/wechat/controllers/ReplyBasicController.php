<?php
namespace backend\modules\wechat\controllers;

use common\models\wechat\Rule;
use common\models\wechat\ReplyBasic;

/**
 * 文字回复控制器
 * Class ReplyBasicController
 * @package backend\modules\wechat\controllers
 */
class ReplyBasicController extends RuleController
{
    public $_module = Rule::RULE_MODULE_BASE;

    /**
     * 返回模型
     * @param $id
     * @return array|ReplyBasic|null|\yii\db\ActiveRecord
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            return new ReplyBasic;
        }

        if (empty(($model = ReplyBasic::find()->where(['rule_id'=>$id])->one())))
        {
            return new ReplyBasic;
        }

        return $model;
    }
}
