<?php

namespace common\models\sys;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%tag}}".
 *
 * @property integer $tag_id
 * @property string $title
 * @property integer $sort
 * @property integer $status
 * @property integer $append
 * @property integer $updated
 */
class Tag extends ActiveRecord
{
    /**
     * 状态启用
     */
    const STATUS_ON  = 1;
    /**
     * 状态禁用
     */
    const STATUS_OFF = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'status', 'append', 'updated'], 'integer'],
            [['title'], 'string', 'max' => 20],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     * 关联中间表
     */
    public function getTagMap()
    {
        return $this->hasOne(TagMap::className(), ['tag_id' => 'tag_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id'    => 'Tag ID',
            'title'     => '标题',
            'sort'      => '排序',
            'status'    => '状态',
            'append'    => '创建时间',
            'updated'   => '修改时间',
        ];
    }

    /**
     * @return array
     * 插入时间戳
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }
}
