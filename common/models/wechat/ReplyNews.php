<?php

namespace common\models\wechat;

use Yii;

/**
 * This is the model class for table "{{%wechat_reply_images}}".
 *
 * @property integer $id
 * @property integer $rule_id
 * @property string $title
 * @property string $description
 * @property string $mediaid
 */
class ReplyNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_reply_news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rule_id'], 'integer'],
            [['attach_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'rule_id'       => '规则ID',
            'attach_id'       => '文章',
        ];
    }

    public function getNews()
    {
        return $this->hasMany(News::className(),['attach_id'=>'attach_id'])->orderBy('id asc');
    }
}
