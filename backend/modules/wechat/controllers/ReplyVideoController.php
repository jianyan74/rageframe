<?php
namespace backend\modules\wechat\controllers;

use common\models\wechat\Rule;
use common\models\wechat\ReplyVideo;
/**
 * Class ReplyVideoController
 * @package backend\modules\wechat\controllers
 * 视频回复控制器
 */
class ReplyVideoController extends RuleController
{
    public $_module = Rule::RULE_MODULE_VIDEO;

    /**
     * @param $id
     * @return array|ReplyVideo|null|\yii\db\ActiveRecord
     * 返回模型
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            return new ReplyVideo;
        }

        if (empty(($model = ReplyVideo::find()->where(['rule_id'=>$id])->one())))
        {
            return new ReplyVideo;
        }

        return $model;
    }
}
