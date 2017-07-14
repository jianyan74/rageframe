<?php
namespace backend\modules\wechat\controllers;

use common\models\wechat\Rule;
use common\models\wechat\ReplyImages;
/**
 * Class RReplyImagesController
 * @package backend\modules\wechat\controllers
 * 图片回复控制器
 */
class ReplyImagesController extends RuleController
{
    public $_module = Rule::RULE_MODULE_IMAGES;

    /**
     * @param $id
     * @return array|ReplyImages|null|\yii\db\ActiveRecord
     * 返回模型
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            return new ReplyImages;
        }

        if (empty(($model = ReplyImages::find()->where(['rule_id'=>$id])->one())))
        {
            return new ReplyImages;
        }

        return $model;
    }
}
