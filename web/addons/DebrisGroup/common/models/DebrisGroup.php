<?php

namespace addons\DebrisGroup\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%addon_sys_debris_group}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property integer $group
 * @property string $cover
 * @property string $link
 * @property string $content
 * @property string $character
 * @property integer $append
 * @property integer $updated
 */
class DebrisGroup extends ActiveRecord
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
        return '{{%addon_sys_debris_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'append', 'updated','cate_id'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['cover', 'character'], 'string', 'max' => 255],
            [['link','description'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'title'     => '标题',
            'cover'     => '图片',
            'link'      => '链接',
            'sort'      => '排序',
            'cate_id'    => '分类id',
            'description' => '描述',
            'content'   => '文章内容',
            'character' => '文字',
            'append'    => '创建时间',
            'updated'   => '修改时间',
        ];
    }

    /**
     * 行为插入时间戳
     * @return array
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
