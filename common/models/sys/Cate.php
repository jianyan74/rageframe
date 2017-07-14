<?php

namespace common\models\sys;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cate}}".
 *
 * @property integer $cate_id
 * @property string $title
 * @property integer $pid
 * @property integer $sort
 * @property integer $status
 * @property integer $level
 * @property string $groups
 * @property integer $append
 * @property integer $updated
 */
class Cate extends ActiveRecord
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
        return '{{%sys_cate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','status'], 'required'],
            [['pid', 'sort', 'status', 'level', 'append', 'updated'], 'integer'],
            [['title', 'group'], 'string', 'max' => 50],
            [['pid','sort', 'group'], 'default', 'value' => 0],
            [['level'], 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cate_id'   => 'Cate ID',
            'title'     => '分类名称',
            'pid'       => 'Pid',
            'sort'      => '排序',
            'status'    => '显示状态',
            'level'     => '级别',
            'group'     => '分组',
            'append'    => '创建时间',
            'updated'   => '修改时间',
        ];
    }

    /**
     * @param $cate_id
     */
    public static function getTitle($cate_id)
    {
        $cate = Cate::findOne($cate_id);
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
     * @param int $parentid
     * @return array
     * 根据父级ID返回信息
     */
    public static function getList($pid = 0)
    {
        $cates = Cate::find()->where(['pid'=>$pid,'status'=>1])->all();

        return ArrayHelper::map($cates,'cate_id','title');
    }

    /**
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
