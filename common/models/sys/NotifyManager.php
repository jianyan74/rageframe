<?php

namespace common\models\sys;

use Yii;

/**
 * This is the model class for table "{{%sys_notify_manager}}".
 *
 * @property integer $id
 * @property integer $manager_id
 * @property integer $last_announce_time
 * @property integer $last_message_time
 */
class NotifyManager extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_notify_manager}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id'], 'required'],
            [['manager_id', 'last_announce_time', 'last_message_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manager_id' => 'Manager ID',
            'last_announce_time' => 'Last Announce Time',
            'last_message_time' => 'Last Message Time',
        ];
    }

    /**
     * 更新用户查看公告时间
     * @param string $field
     */
    public static function updateTime($field = 'last_announce_time')
    {
        $notifyManager = NotifyManager::find()
            ->where(['manager_id'=>Yii::$app->user->getId()])
            ->one();

        $notifyManager->$field = time();
        $notifyManager->save();
    }

    /**
     * 获取最后获取时间
     */
    public static function getNotifyManager()
    {
        $notifyManager = NotifyManager::find()
            ->where(['manager_id'=>Yii::$app->user->getId()])
            ->one();

        if($notifyManager)
        {
            return $notifyManager;
        }

        $mobile = new NotifyManager();
        $mobile->manager_id = Yii::$app->user->getId();
        $mobile->save();

        return ['last_announce_time'=>0,'last_message_time'=>0];
    }
}
