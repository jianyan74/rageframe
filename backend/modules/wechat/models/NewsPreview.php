<?php
namespace backend\modules\wechat\models;

use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * @package common\models\sys
 */
class NewsPreview extends Model
{
    public $media_id;
    public $type;
    public $content;
    public $msg_type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['media_id', 'type','content'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'media_id'   => '素材id',
            'type' => '类别',
            'content'   => '微信号/openid',
        ];
    }
}
