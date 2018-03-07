<?php
namespace common\models\member;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $user_openid
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $password_reset_token
 * @property integer $type
 * @property string $nickname
 * @property string $realname
 * @property string $head_portrait
 * @property integer $sex
 * @property string $qq
 * @property string $email
 * @property string $birthday
 * @property string $user_money
 * @property string $accumulate_money
 * @property string $frozen_money
 * @property integer $user_integral
 * @property string $address_id
 * @property integer $visit_count
 * @property string $home_phone
 * @property string $mobile_phone
 * @property string $passwd_question
 * @property string $passwd_answer
 * @property integer $role
 * @property integer $status
 * @property integer $last_time
 * @property string $last_ip
 * @property integer $created_at
 * @property integer $updated_at
 */
class Member extends \common\models\base\User
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['password_hash','username'], 'required'],
            // ['username', 'unique','message'=>'用户账户已经占用'],
            [['type', 'sex', 'user_integral', 'address_id', 'visit_count', 'role', 'status', 'last_time', 'created_at', 'updated_at'], 'integer'],
            [['birthday'], 'safe'],
            [['user_money', 'accumulate_money', 'frozen_money'], 'number'],
            [['username', 'qq', 'home_phone', 'mobile_phone'], 'string', 'max' => 20],
            ['mobile_phone','match','pattern'=>'/^[1][3578][0-9]{9}$/','message'=>'不是一个有效的手机号码'],
            [['password_hash', 'password_reset_token', 'head_portrait', 'passwd_answer'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['nickname', 'realname'], 'string', 'max' => 10],
            [['email'], 'string', 'max' => 60],
            [['passwd_question'], 'string', 'max' => 50],
            [['city','province','country'], 'string', 'max' => 100],
            [['email'],'email'],
            [['last_ip'], 'string', 'max' => 16],
            ['last_ip','default', 'value' => '0.0.0.0'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username'              => '登陆账号',
            'password_hash'         => '登陆密码',
            'auth_key'              => 'auth登录秘钥',
            'password_reset_token'  => '密码重置秘钥',
            'type'                  => '类别',
            'nickname'              => '昵称',
            'realname'              => '真实姓名',
            'head_portrait'         => '头像',
            'sex'                   => '性别',
            'qq'                    => 'QQ',
            'email'                 => '邮箱',
            'birthday'              => '出生日期',
            'user_money'            => '当前余额',
            'accumulate_money'      => '累积消费',
            'frozen_money'          => '累积金额',
            'user_integral'         => '当前积分',
            'address_id'            => '默认收货地址',
            'visit_count'           => '访问次数',
            'home_phone'            => '家庭电话',
            'mobile_phone'          => '手机号码',
            'passwd_question'       => '密保问题',
            'passwd_answer'         => '密保答案',
            'role'                  => '权限',
            'status'                => '状态',
            'last_time'             => '最后登录时间',
            'last_ip'               => '最后登录IP',
            'created_at'            => '创建时间',
            'updated_at'            => '修改时间',
        ];
    }

    /**
     * @param $data
     * 快速插入会员信息
     */
    public static function add($data)
    {
        $model = new Member();
        $model->head_portrait = $data->headimgurl;
        $model->nickname = $data->nickname;
        isset($data->sex) && $model->sex = $data->sex;
        isset($data->city) && $model->city = $data->city;
        isset($data->province) && $model->province = $data->province;
        isset($data->country) && $model->country = $data->country;
        $model->save();

        return Yii::$app->db->getLastInsertID();
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->auth_key = Yii::$app->security->generateRandomString();
        }

        return parent::beforeSave($insert);
    }

    /**
     * 行为插入时间戳
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
}
