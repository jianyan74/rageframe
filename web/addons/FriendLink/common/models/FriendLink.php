<?php
namespace addons\FriendLink\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%links}}".
 * 友情链接
 * @property string $id
 * @property string $title
 * @property string $cover
 * @property string $link
 * @property string $summary
 * @property string $sort
 * @property integer $type
 * @property integer $status
 * @property string $append
 * @property integer $updated
 */
class FriendLink extends ActiveRecord
{
    const STATUS_ON     = 1;
    const STATUS_OFF    = -1;

    /**
     * 状态枚举
     * @var array
     */
    public static $statuses = [
        self::STATUS_OFF => '启用',
        self::STATUS_ON  => '禁用'
    ];


    const BLOGROLL     = 1;
    const COOPERATION  = 2;

    /**
     * 类别枚举
     * @var array
     */
    public static $type = [
        self::BLOGROLL => '友情链接',
        self::COOPERATION  => '合作商家'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%addon_sys_links}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','link','status'],'required'],
            [['link'],'url'],
            [['sort', 'type', 'status', 'append', 'updated'], 'integer'],
            [['title'], 'string', 'max' => 80],
            [['link'], 'string', 'max' => 140],
            [['sort'], 'default', 'value' => 0],
            [['summary','cover'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'title'   => '链接名称',
            'cover'   => '封面',
            'link'    => '链接地址',
            'summary' => '说明',
            'sort'    => '排序',
            'type'    => '链接类型',
            'status'  => '状态',
            'append'  => '创建时间',
            'updated' => '修改时间',
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
}
            