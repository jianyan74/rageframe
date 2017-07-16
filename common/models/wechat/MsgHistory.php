<?php

namespace common\models\wechat;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%wechat_msg_history}}".
 *
 * @property string $id
 * @property string $rule_id
 * @property integer $keyword_id
 * @property string $openid
 * @property string $module
 * @property string $message
 * @property string $type
 * @property string $append
 */
class MsgHistory extends ActiveRecord
{
    /**
     * 默认规则
     */
    const DEFAULT_RULE = 0;
    /**
     * 默认关键字
     */
    const DEFAULT_KWYWORD = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_msg_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rule_id', 'keyword_id', 'append'], 'integer'],
            [['openid', 'module'], 'string', 'max' => 50],
            [['message'], 'string', 'max' => 1000],
            [['type'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'rule_id'   => '规则id',
            'keyword_id' => '关键字id',
            'openid'    => 'Openid',
            'module'    => '模块id',
            'message'   => '内容',
            'type'      => '类别',
            'append'    => '创建时间',
        ];
    }

    /**
     * 插入历史消息
     * @param $message
     * @param $msg_history
     * @param $reply
     */
    public static function add($message,$msg_history,$reply)
    {
        $add = $reply ? ArrayHelper::merge($msg_history, $reply) : $msg_history;

        //历史记录状态
        $setting = Setting::getSetting('history');
        if($setting['is_msg_history']['status'] != Setting::MSG_HISTORY_OFF)
        {
            $msgHistory = new MsgHistory();
            if($msg_history['type'] == 'text')
            {
                $add['message'] = $message->Content;
            }
            else
            {
                $add['message'] = self::filtrate($message);
            }

            $msgHistory->attributes = $add;
            $msgHistory->save();
        }

        //统计状态
        if($setting['is_utilization_stat']['status'] != Setting::UTILZATION_STAT_OFF)
        {
            //插入规则统计
            !empty($add['rule_id']) && RuleStat::setStat($add['rule_id']);
            //插入关键字统计
            !empty($add['keyword_id']) && RuleKeywordStat::setStat($add['rule_id'],$add['keyword_id']);
        }
    }

    /**
     * 过滤消息信息
     * @param $message
     * @return string
     */
    public static function filtrate($message)
    {
        $arr = [];
        $filtrate = ['ToUserName','FromUserName','MsgId','CreateTime','MsgType'];
        foreach ($message as $key => $value)
        {
            if(!in_array($key,$filtrate))
            {
                $arr[$key] = $value;
            }
        }

        return serialize($arr);
    }

    /**
     * 解析微信发过来的消息内容
     * @param $type
     * @param $messgae
     * @return mixed|string
     */
    public static function readMessage($type,$messgae)
    {
        switch ($type)
        {
            case Account::TYPE_TEXT :
                return $messgae;
                break;

            case Account::TYPE_IMAGE :
                $messgae = unserialize($messgae);
                return $messgae['PicUrl'];
                break;

            case Account::TYPE_VIDEO :
                $messgae = unserialize($messgae);
                return "MediaId【".$messgae['MediaId']."】";
                break;

            case Account::TYPE_LOCATION :
                $messgae = unserialize($messgae);
                return '经纬度【'.$messgae['Location_X'].','.$messgae['Location_Y']."】地址:".$messgae['Label'];
                break;

            case Account::TYPE_CILCK :
                $messgae = unserialize($messgae);
                return '单击菜单触发：' . $messgae['EventKey'];
                break;

            case Account::TYPE_SUBSCRIBE :
                return '关注公众号';
                break;

                //触发事件
            case Account::TYPE_EVENT :

                $messgae = unserialize($messgae);
                switch ($messgae['Event'])
                {
                    case Account::TYPE_UN_SUBSCRIBE :
                        return '取消关注公众号';
                        break;

                    case Account::TYPE_EVENT_LOCATION :
                        return '经纬度【'.$messgae['Latitude'].','.$messgae['Longitude']."】精度:".$messgae['Precision'];
                        break;
                    case Account::TYPE_EVENT_VIEW :
                        return "单击菜单访问：" . $messgae['EventKey'];
                        break;

                    default :
                        return serialize($messgae);
                        break;
                }

                break;

            default :

                return $messgae;

                break;
        }
    }

    /**
     * 关联粉丝
     */
    public function getFans()
    {
        return $this->hasOne(Fans::className(), ['openid' => 'openid']);
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append'],
                ],
            ],
        ];
    }
}
