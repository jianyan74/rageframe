<?php
namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\filters\RateLimitInterface;
use common\models\member\Member;
use jianyan\basics\common\models\sys\Manager;

/**
 * Class AccessToken
 * @package common\models\base
 */
class AccessToken extends User implements RateLimitInterface
{
    const GROUP_MANAGER = 1;
    const GROUP_MEMBER = 2;

    /**
     * 组别
     * @var array
     */
    public static $groupExplain = [
        self::GROUP_MANAGER => '后台用户',
        self::GROUP_MEMBER => '会员',
    ];

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%api_access_token}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group', 'user_id', 'status', 'allowance', 'allowance_updated_at', 'updated_at', 'created_at'], 'integer'],
            [['allowance', 'allowance_updated_at'], 'required'],
            [['access_token'], 'string', 'max' => 60],
            [['access_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * 速度控制
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @return mixed
     */
    public function getRateLimit($request, $action)
    {
        return Yii::$app->params['user.rateLimit'];
    }

    /**
     * 返回剩余的允许的请求和相应的UNIX时间戳数 当最后一次速率限制检查时。
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @return array
     */
    public function loadAllowance($request, $action)
    {
        return [$this->allowance, $this->allowance_updated_at];
    }

    /**
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @param int $allowance 剩余请求次数
     * @param int $timestamp 当前的UNIX时间戳
     */
    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $this->allowance = $allowance;
        $this->allowance_updated_at = $timestamp;
        $this->save();
    }

    /**
     * access_token 找到identity
     * @param mixed $token
     * @param null $type
     * @return static
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * 获取token
     * @param $group 组别
     * @param $user_id 用户ID
     * @return string
     */
    public static function generateAccessToken($group, $user_id)
    {
        $access_token = Yii::$app->security->generateRandomString() . '_' . time();
        $model = self::find()
            ->where(['user_id' => $user_id, 'group' => $group])
            ->andWhere(['access_token' => $access_token])
            ->one();

        if($model)
        {
            $access_token = self::generateAccessToken($group, $user_id);
        }

        return $access_token;
    }

    /**
     * 获取当前用户的信息
     * @param $group
     * @return bool|mixed
     */
    public static function getMemberInfo($group)
    {
        $groupModel = [
            self::GROUP_MANAGER => Manager::find()->where(['user_id' => Yii::$app->user->identity->user_id, 'status' => self::STATUS_ACTIVE])->one(),
            self::GROUP_MEMBER => Member::find()->where(['user_id' => Yii::$app->user->identity->user_id, 'status' => self::STATUS_ACTIVE])->one(),
        ];

        return isset($groupModel[$group]) ? $groupModel[$group] : false;
    }

    /**
     * 创建用户信息
     * @param $group
     * @param $user_id
     */
    public static function setMemberInfo($group,$user_id)
    {
        if(!($model = self::find()->where(['user_id' => $user_id, 'group' => $group])->one()))
        {
            $model = new self;
        }

        $model->group = $group;
        $model->user_id = $user_id;
        $model->allowance = 2;
        $model->allowance_updated_at = time();
        $model->access_token = self::generateAccessToken($group, $user_id);
        return $model->save() ? $model->access_token : false;
    }
}