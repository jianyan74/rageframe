<?php

namespace common\models\wechat;

use Yii;

/**
 * This is the model class for table "{{%wechat_fans_stat}}".
 *
 * @property string $id
 * @property string $new_attention
 * @property string $cancel_attention
 * @property integer $cumulate_attention
 * @property string $date
 */
class FansStat extends \yii\db\ActiveRecord
{
    /**
     * 新关注
     */
    const NEW_ATTENTION = 1;
    /**
     * 取消关注
     */
    const CANCEL_ATTENTION = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_fans_stat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['new_attention', 'cancel_attention', 'cumulate_attention'], 'integer'],
            [['date'], 'required'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'new_attention' => '今日新关注',
            'cancel_attention' => '今日取消关注',
            'cumulate_attention' => '累计关注',
            'date' => '日期',
        ];
    }

    /**
     * 类别 1 关注 2 取消关注
     * @param $type
     */
    public static function addStat($type)
    {
        $date = date('Y-m-d');

        $model = self::findOne(['date' => $date]);
        if(!$model)
        {
            $model = new self;
            $model->loadDefaultValues();
            $model->date = $date;
        }

        $type == 1 ? $model->new_attention +=1 : $model->cancel_attention +=1;

        return $model->save();
    }
}
