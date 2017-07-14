<?php

namespace common\models\wechat;

use Yii;

/**
 * This is the model class for table "{{%wechat_reply_video}}".
 *
 * @property integer $id
 * @property integer $rule_id
 * @property string $title
 * @property string $description
 * @property string $mediaid
 */
class ReplyVideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_reply_video}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rule_id'], 'integer'],
            [['title', 'description', 'mediaid'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['description', 'mediaid'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rule_id' => '规则ID',
            'title' => '视频名称',
            'description' => '视频说明',
            'mediaid' => '上传视频',
        ];
    }
}
