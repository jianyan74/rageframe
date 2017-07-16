<?php

namespace common\models\wechat;

use Yii;

/**
 * This is the model class for table "{{%wechat_reply_basic}}".
 *
 * @property integer $id
 * @property integer $rule_id
 * @property string $content
 */
class ReplyBasic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_reply_basic}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rule_id'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string', 'max' => 1000],
        ];
    }

    /**
     * 行为
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->content = htmlspecialchars_decode($this->content);
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'rule_id'   => '规则ID',
            'content'   => '回复内容',
        ];
    }
}
