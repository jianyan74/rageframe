<?php

namespace common\models\sys;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%sys_notify}}".
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property integer $type
 * @property integer $target
 * @property string $target_type
 * @property string $action
 * @property integer $sender
 * @property integer $view
 * @property integer $updated
 * @property integer $append
 */
class Notify extends \yii\db\ActiveRecord
{
    /**
     * 公告
     */
    const TYPE_ANNOUNCE = 1;
    /**
     * 提醒
     */
    const TYPE_REMIND = 2;
    /**
     * 信息
     */
    const TYPE_MESSAGE = 3;

    /**
     * 显示状态
     */
    const DISPLAY_ON  = 1;
    /**
     * 显示状态
     */
    const DISPLAY_OFF = -1;

    /**
     * 用户消息-私信
     */
    const TARGET_TYPE_MANAGER = 'manager';

    public static $type = [
        self::TYPE_ANNOUNCE => 'announce',
        self::TYPE_REMIND => 'remind',
        self::TYPE_MESSAGE => 'message',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_notify}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required', 'on' => ['announce', 'message']],
            [['title','announce_type'], 'required', 'on' => 'announce'],
            [['target'], 'required', 'on' => 'message'],
            [['content'], 'string'],
            [['type', 'target', 'sender', 'view','announce_type','sender_display','is_withdraw','target_display', 'updated', 'append'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['target_type', 'action'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'title'         => '标题',
            'content'       => '消息内容',
            'type'          => '消息类型',
            'announce_type' => '消息类型-广告类型',
            'target'        => '目标id',
            'target_type'   => '目标类型',
            'action'        => '动作类型',
            'sender'        => '发送者id',
            'view'          => '浏览量',
            'sender_display' => '发送者删除状态',
            'target_display' => '接收者删除状态',
            'is_withdraw'   => '是否撤回',
            'updated'       => 'Updated',
            'append'        => 'Append',
        ];
    }

    /**
     * 关联用户
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Manager::className(),['id'=>'sender']);
    }

    /**
     * 关联用户
     * @return \yii\db\ActiveQuery
     */
    public function getManagerTarget()
    {
        return $this->hasOne(Manager::className(),['id'=>'target']);
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
