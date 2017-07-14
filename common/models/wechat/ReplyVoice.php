<?php

namespace common\models\wechat;

use Yii;

/**
 * This is the model class for table "{{%wechat_reply_voice}}".
 *
 * @property integer $id
 * @property integer $rule_id
 * @property string $title
 * @property string $mediaid
 */
class ReplyVoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_reply_voice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rule_id'], 'integer'],
            [['title', 'mediaid'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['mediaid'], 'string', 'max' => 255],
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
            'title' => '语音名称',
            'mediaid' => '上传语音',
        ];
    }
}
