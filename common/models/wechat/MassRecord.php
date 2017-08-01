<?php

namespace common\models\wechat;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%wechat_mass_record}}".
 *
 * @property string $id
 * @property string $group_name
 * @property string $fans_num
 * @property string $msg_type
 * @property string $content
 * @property integer $group
 * @property string $attach_id
 * @property string $media_id
 * @property integer $type
 * @property integer $status
 * @property string $cron_id
 * @property string $send_time
 * @property string $final_send_time
 * @property string $append
 */
class MassRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_mass_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fans_num', 'group', 'attach_id', 'type', 'status', 'cron_id', 'send_time', 'final_send_time', 'append'], 'integer'],
            [['group_name'], 'string', 'max' => 50],
            [['msg_type'], 'string', 'max' => 10],
            [['content'], 'string', 'max' => 10000],
            [['media_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_name' => 'Group Name',
            'fans_num' => 'Fans Num',
            'msg_type' => 'Msg Type',
            'content' => 'Content',
            'group' => '分组',
            'attach_id' => 'Attach ID',
            'media_id' => 'Media ID',
            'type' => 'Type',
            'status' => 'Status',
            'cron_id' => 'Cron ID',
            'send_time' => 'Send Time',
            'final_send_time' => 'Final Send Time',
            'append' => 'Append',
        ];
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append'],
                ],
            ],
        ];
    }
}
