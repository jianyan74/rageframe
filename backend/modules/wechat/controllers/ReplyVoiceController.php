<?php
namespace backend\modules\wechat\controllers;

use common\models\wechat\Rule;
use common\models\wechat\ReplyVoice;
/**
 * Class RReplyImagesController
 * @package backend\modules\wechat\controllers
 * 语音回复控制器
 */
class ReplyVoiceController extends RuleController
{
    public $_module = Rule::RULE_MODULE_VOICE;

    /**
     * @param $id
     * @return array|ReplyVoice|null|\yii\db\ActiveRecord
     * 返回模型
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
