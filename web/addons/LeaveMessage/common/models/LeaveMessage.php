<?php
namespace addons\LeaveMessage\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $id
 * @property string $realname
 * @property string $mobile
 * @property string $home_phone
 * @property string $content
 * @property integer $status
 * @property integer $group
 * @property string $address
 * @property string $ip
 * @property integer $append
 * @property integer $updated
 */
class LeaveMessage extends ActiveRecord
{
    /**
     * 状态启用
     */
    const STATUS_ON  = 1;
    /**
     * 状态禁用
     */
    const STATUS_OFF = -1;
    /**
     * 留言建议
     */
    const TYPE_MSG = 1;
    /**
     * @var array
     * 状态枚举
     */
    public static $types = [
        self::TYPE_MSG => '<span class="badge badge-info">留言建议</span>',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%addon_sys_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'type', 'append', 'updated'], 'integer'],
            [['realname'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 11],
            [['home_phone'], 'string', 'max' => 20],
            [['content'], 'string', 'max' => 1000],
            [['address'], 'string', 'max' => 100],
            [['ip'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'realname'      => '真实姓名',
            'mobile'        => '手机号码',
            'home_phone'    => '家庭号码',
            'content'       => '内容',
            'status'        => '状态',
            'type'          => '类别',
            'address'       => '地址',
            'ip'            => 'Ip',
            'append'        => '创建时间',
            'updated'       => '修改时间',
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * 插入前操作
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->action_ip    = ip2long(Yii::$app->request->userIP);
        }

        return parent::beforeSave($insert);
    }
}
            