<?php

namespace common\models\wechat;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%wechat_qrcode_stat}}".
 *
 * @property string $id
 * @property string $qrcord_id
 * @property string $openid
 * @property integer $type
 * @property string $qr_cid
 * @property string $name
 * @property string $scene_str
 * @property string $append
 */
class QrcodeStat extends ActiveRecord
{
    /**
     * 关注
     */
    const TYPE_ATTENTION = 1;
    /**
     * 扫描
     */
    const TYPE_SCAN = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_qrcode_stat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qrcord_id', 'type', 'scene_id', 'append'], 'integer'],
            [['qrcord_id', 'scene_str'], 'safe'],
            [['openid', 'name'], 'string', 'max' => 50],
            [['scene_str'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qrcord_id' => '二维码id',
            'openid' => '用户openid',
            'type' => '；二维码类别',
            'scene_id' => 'Qr Cid',
            'name' => 'Name',
            'scene_str' => 'Scene Str',
            'append' => '创建时间',
        ];
    }

    /**
     * 判断二维码扫描事件
     * @param $message
     * @return bool|mixed
     */
    public static function scan($message)
    {
        if($message->Event == Account::TYPE_SUBSCRIBE && !empty($message->Ticket))//关注
        {
            $ticket = trim($message->Ticket);
            $qrCode = Qrcode::find()->where(['ticket'=>$ticket])->one();
            if($qrCode)
            {
                static::insertStat($qrCode,$message->FromUserName,self::TYPE_ATTENTION);
                return $qrCode->keyword;
            }
        }
        elseif($message->Event == Account::TYPE_SCAN)//扫描
        {
            if(is_numeric($message->EventKey))
            {
                $where = ['scene_id'=> $message->EventKey];
            }
            else
            {
                $where = ['scene_str'=> $message->EventKey];
            }

            $qrCode = Qrcode::find()->where($where)->one();
            if($qrCode)
            {
                static::insertStat($qrCode,$message->FromUserName,self::TYPE_SCAN);
                return $qrCode->keyword;
            }
        }

        return false;
    }

    /**
     * 插入扫描记录
     * @param $qrCode
     * @param $openid
     * @param $type
     */
    public static function insertStat($qrCode,$openid,$type)
    {
        $model = new QrcodeStat();
        $model->qrcord_id = $qrCode->id;
        $model->scene_str = $qrCode->scene_str;
        $model->scene_id = $qrCode->scene_id;
        $model->name = $qrCode->name;
        $model->type = $type;
        $model->openid = $openid;
        $model->save();
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
