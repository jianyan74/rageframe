<?php
namespace common\models\sys;

use Yii;
use backend\modules\sys\models\AuthAssignment;

/**
 * This is the model class for table "yl_manager".
 *
 * @property integer $id
 * @property string $openid
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $password_reset_token
 * @property integer $type
 * @property string $realname
 * @property string $head_portrait
 * @property integer $sex
 * @property string $qq
 * @property string $email
 * @property string $birthday
 * @property integer $user_integral
 * @property string $address
 * @property integer $visit_count
 * @property string $home_phone
 * @property string $mobile_phone
 * @property integer $role
 * @property integer $status
 * @property integer $last_time
 * @property string $last_ip
 * @property integer $created_at
 * @property integer $updated_at
 */
class Manager extends \common\models\base\User
{

    /**
     * 超级管理员
     */
    const TYPE_MANAGER  = 10;
    /**
     * 普通管理员
     */
    const TYPE_USER = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_manager}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['password_hash','username'], 'required'],
            ['username', 'unique','message'=>'用户账户已经占用'],
            [['type', 'sex', 'user_integral', 'visit_count', 'role', 'status', 'last_time', 'created_at', 'updated_at'], 'integer'],
            [['birthday'], 'safe'],
            [['username', 'qq', 'home_phone', 'mobile_phone'], 'string', 'max' => 15],
            ['mobile_phone','match','pattern'=>'/^[1][3578][0-9]{9}$/','message'=>'不是一个有效的手机号码'],
            [['password_hash', 'password_reset_token', 'head_portrait'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['realname'], 'string', 'max' => 10],
            [['provinces','city','area'], 'string', 'max' => 10],
            [['address'], 'string', 'max' => 100],
            [['email'],'email'],
            [['email'], 'string', 'max' => 60],
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
            'id'                      => 'ID',
            'username'                => '登录名',
            'password_hash'           => '登录密码',
            'auth_key'                => 'Auth Key',
            'password_reset_token'    => 'Password Reset Token',
            'type'                    => '管理员类型',
            'nickname'                => '昵称',
            'realname'                => '真实姓名',
            'head_portrait'           => '个人头像',
            'sex'                     => '性别',
            'qq'                      => 'qq',
            'email'                   => '邮箱',
            'birthday'                => '出生日期',
            'user_integral'           => '用户积分',
            'address'                 => '详细地址',
            'provinces'               => '省份',
            'city'                    => '城市',
            'area'                    => '区',
            'visit_count'             => '登陆次数',
            'home_phone'              => '家庭电话',
            'mobile_phone'            => '手机号码',
            'role'                    => 'Role',
            'status'                  => '状态',
            'last_time'               => '最后登录的时间',
            'last_ip'                 => '最后登录的IP地址',
            'created_at'              => '创建时间',
            'updated_at'              => '修改时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignment()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getManagers()
    {
        return self::find()->where(['<>','id',Yii::$app->user->id])->asArray()->all();
    }

    /**
     * @param bool $insert
     * @return bool
     * 自动插入
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
            $this->auth_key   = Yii::$app->security->generateRandomString();
        }
        else
        {
            //验证密码是否修改
            $old_pwd = Yii::$app->user->identity['password_hash'];
            $new_pwd = $this->password_hash;

            if($old_pwd != $new_pwd)
            {
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
            }
        }
        return parent::beforeSave($insert);
    }


}
