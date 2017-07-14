<?php

namespace common\models\wechat;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\member\Member;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%wechat_fans}}".
 *
 * @property string $fan_id
 * @property string $unionid
 * @property string $user_id
 * @property string $openid
 * @property string $salt
 * @property integer $follow
 * @property string $followtime
 * @property string $unfollowtime
 * @property string $tag
 * @property string $group_id
 * @property string $nickname
 * @property string $last_longitude
 * @property string $last_latitude
 * @property string $last_address
 * @property integer $last_updated
 * @property string $append
 * @property integer $updated
 */
class Fans extends ActiveRecord
{
    const FOLLOW_ON = 1;
    const FOLLOW_OFF = -1;

    /**
     * 关注状态
     * @var array
     */
    public static $followStatus = [
        self::FOLLOW_ON  => '已关注',
        self::FOLLOW_OFF => '未关注',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_fans}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex','user_id', 'follow', 'followtime', 'unfollowtime', 'group_id', 'last_updated', 'append', 'updated'], 'integer'],
            [['openid'], 'required'],
            [['unionid'], 'string', 'max' => 64],
            [['openid', 'nickname'], 'string', 'max' => 50],
            [['city', 'province','country'], 'string', 'max' => 100],
            [['tag'], 'string', 'max' => 1000],
            [['last_longitude', 'last_latitude'], 'string', 'max' => 10],
            [['last_address'], 'string', 'max' => 100],
            [['headimgurl'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fan_id'            => 'Fan ID',
            'unionid'           => 'Unionid',
            'user_id'           => '用户id',
            'openid'            => 'Openid',
            'sex'               => '性别',
            'headimgurl'        => '头像',
            'follow'            => '是否关注',
            'followtime'        => '关注时间',
            'unfollowtime'      => '取消关注时间',
            'tag'               => '标签',
            'group_id'          => '分组id',
            'nickname'          => '昵称',
            'country'           => '国家',
            'province'          => '省份',
            'city'              => '城市',
            'last_longitude'    => '最后一次上报经度',
            'last_latitude'     => '最后一次上报纬度',
            'last_address'      => '最后一次上报地址',
            'last_updated'      => '最后一次上报时间',
            'append'            => '创建时间',
            'updated'           => '修改时间',
        ];
    }

    /**
     * 关联会员
     */
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['id' => 'user_id']);
    }

    /**
     * @param $openid
     * @param $app
     * 关注
     */
    public static function follow($openid,$app)
    {
        $fans = static::findModel($openid);

        //获取用户信息
        $user = $app->user->get($openid);
        $user = ArrayHelper::toArray($user);

        $fans->attributes = $user;
        $fans->group_id = $user['groupid'];
        $fans->followtime = $user['subscribe_time'];
        $fans->follow = self::FOLLOW_ON;
        $fans->save();
    }

    /**
     * @param $openid
     * 取消关注
     */
    public static function unFollow($openid)
    {
        $fans = Fans::find()->where(['openid'=>$openid])->one();
        $fans->follow = self::FOLLOW_OFF;
        $fans->unfollowtime = time();
        $fans->save();
    }

    /**
     * 同步关注的用户信息
     * @param $openid
     * @param $app
     */
    public static function sync($openid,$app)
    {
        $user = $app->user->get($openid);
        $user = ArrayHelper::toArray($user);

        if($user['subscribe'] == 1)
        {
            $fans = static::findModel($openid);
            $fans->attributes = $user;
            $fans->group_id = $user['groupid'];
            $fans->followtime = $user['subscribe_time'];
            $fans->follow = self::FOLLOW_ON;
            $fans->save();
        }
    }

    /**
     * 返回模型
     * @param $openid
     * @return array|Fans|null|ActiveRecord
     */
    protected static function findModel($openid)
    {
        if (empty($openid))
        {
            return new self;
        }

        if (empty(($model = self::find()->where(['openid' => $openid])->one())))
        {
            return new self;
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }
}
