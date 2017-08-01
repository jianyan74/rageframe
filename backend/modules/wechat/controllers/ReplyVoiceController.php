<?php
namespace backend\modules\wechat\controllers;

use common\models\wechat\Rule;
use common\models\wechat\ReplyVoice;

/**
 * 语音回复控制器
 * Class ReplyVoiceController
 * @package backend\modules\wechat\controllers
 */
class ReplyVoiceController extends RuleController
{
    public $_module = Rule::RULE_MODULE_VOICE;

    /**
     * 返回模型
     * @param $id
     * @return array|ReplyVoice|null|\yii\db\ActiveRecord
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            return new ReplyVoice;
        }

        if (empty(($model = ReplyVoice::find()->where(['rule_id'=>$id])->one())))
        {
            return new ReplyVoice;
        }

        return $model;
    }
}
