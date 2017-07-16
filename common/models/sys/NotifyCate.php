<?php

namespace common\models\sys;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%tag}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $sort
 * @property integer $status
 * @property integer $append
 * @property integer $updated
 */
class NotifyCate extends ActiveRecord
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
        return '{{%sys_notify_cate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['sort', 'append', 'updated'], 'integer'],
            [['title'], 'string', 'max' => 20],
        ];
    }

    /**
     * 关联中间表
     * @return \yii\db\ActiveQuery
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
            'id'        => 'Tag ID',
            'title'     => '标题',
            'sort'      => '排序',
            'append'    => '创建时间',
            'updated'   => '修改时间',
        ];
    }

    /**
     * 根据分类id获取分类信息
     * @param $id
     * @return string
     */
    public static function getTitle($id)
    {
        $cate = self::findOne($id);
        if($cate)
        {
            return $cate['title'];
        }
        else
        {
            return "未选择";
        }
    }

    /**
     * 返回公告分类
     * @return array
     */
    public static function getList()
    {
        $cates = self::find()->orderBy('sort asc')->all();
        return ArrayHelper::map($cates,'id','title');
    }

    /**
     * 行为
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
