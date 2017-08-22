<?php
namespace addons\Adv\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%slide}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $silder
 * @property string $silder_text
 * @property string $start_time
 * @property string $end_time
 * @property string $jump_link
 * @property integer $jump_type
 * @property integer $priorityr
 * @property integer $status
 * @property integer $append
 * @property integer $updated
 */
class Adv extends ActiveRecord
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
        return '{{%addon_sys_adv}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status','location_id'], 'required'],
            [['jump_link'],'url'],
            [['jump_type', 'sort', 'status','location_id', 'append', 'updated'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['title'], 'string', 'max' => 30],
            [['cover'], 'string', 'max' => 100],
            [['silder_text', 'jump_link'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'title'       => '标题',
            'cover'       => '图片',
            'silder_text' => '图片描述',
            'location_id' => '广告位置',
            'start_time'  => '开始时间',
            'end_time'    => '结束时间',
            'jump_link'   => '跳转链接',
            'jump_type'   => '跳转方式',
            'sort'        => '排序',
            'status'      => '显示状态',
            'append'      => 'Append',
            'updated'     => 'Updated',
        ];
    }


    /**
     * @param $start_time -开始时间
     * @param $end_time   -结束时间
     * @return mixed
     * 根据开始时间和结束时间发回当前状态
     */
    static public function getTimeStatus($start_time,$end_time)
    {
        $time = time();
        if($start_time > $end_time)
        {
            return "<span class='label label-danger'>有效期错误</span>";
        }
        elseif($start_time > $time)
        {
            return "<span class='label label-default'>未开始</span>";
        }
        elseif($start_time < $time && $end_time > $time)
        {
            return "<span class='label label-primary'>进行中</span>";
        }
        elseif($end_time < $time)
        {
            return "<span class='label label-default'>已结束</span>";
        }

        return false;
    }

    /**
     * @return array
     * 行为插入时间戳
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