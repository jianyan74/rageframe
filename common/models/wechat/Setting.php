<?php

namespace common\models\wechat;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%wechat_setting}}".
 *
 * @property integer $id
 * @property integer $is_msg_history
 * @property integer $msg_history_date
 * @property integer $is_utilization_stat
 * @property integer $append
 * @property integer $updated
 */
class Setting extends ActiveRecord
{
    /**
     * 关闭历史消息记录
     */
    const MSG_HISTORY_OFF = -1;
    /**
     * 默认历史消息记录
     */
    const MSG_HISTORY_ON = 1;

    /**
     * 关闭利用率统计
     */
    const UTILZATION_STAT_OFF = -1;
    /**
     * 默认利用率统计
     */
    const UTILZATION_STAT_ON = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['history','special'],'string'],
            [['append', 'updated'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                    => 'ID',
            'history'               => '参数',
            'special'               => '特殊消息回复',
            'append'                => 'Append',
            'updated'               => 'Updated',
        ];
    }

    /**
     * 特殊消息回复类别-关键字
     */
    const SPECIAL_TYPE_KEYWORD = 1;
    /**
     * 特殊消息回复类别-模块
     */
    const SPECIAL_TYPE_MODUL = 2;
    /**
     * @param $name
     * @return bool|mixed
     * 获取参数消息
     */
    public static function getSetting($name)
    {
        $defaultList = [];
        switch ($name)
        {
            //历史消息参数设置
            case 'history' :
                $defaultList = [
                    'is_msg_history' => [
                        'title'  => '开启历史消息记录',
                        'status' => self::MSG_HISTORY_ON,
                    ],
                    'is_utilization_stat' => [
                        'title'  => '开启利用率统计',
                        'status' => self::UTILZATION_STAT_ON,
                    ],
                    'msg_history_date' => [
                        'title'  => '历史消息记录天数',
                        'value'  => 0,
                    ],
                ];
                break;
            //特殊消息回复
            case 'special' :
                $list = Account::$mtype;
                $defaultList = [];
                foreach ($list as $key => $value)
                {
                    $defaultList[$key]['title'] = $value;
                    $defaultList[$key]['type'] = self::SPECIAL_TYPE_KEYWORD;
                    $defaultList[$key]['content'] = '';
                    $defaultList[$key]['module'] = '';
                }
                break;
        }

        $model = self::findModel();
        if($model[$name])
        {
            $defaultList = ArrayHelper::merge($defaultList,unserialize($model[$name]));
        }
        return $defaultList;
    }

    /**
     * @return array|Setting|null|ActiveRecord
     */
    public static function findModel()
    {
        if (empty(($model = Setting::find()->one())))
        {
            return new Setting;
        }

        return $model;
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append','updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }
}
