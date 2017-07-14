<?php
namespace addons\Debris\common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%addons_sys_debris}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $type
 * @property string $cover
 * @property string $link
 * @property string $content
 * @property string $character
 * @property integer $append
 * @property integer $updated
 */
class Debris extends ActiveRecord
{
    /**
     * 文字
     */
    const TYPE_CHARACTER = 1;
    /**
     * 图片
     */
    const TYPE_COVER = 2;
    /**
     * 文章
     */
    const TYPE_CONTENT = 3;

    public static $type = [
        self::TYPE_CHARACTER => '文字',
        self::TYPE_COVER => '图片',
        self::TYPE_CONTENT => '文章',
    ];

    /**
     * @var array
     * 样式
     */
    public static $typeText = [
        self::TYPE_CHARACTER => '<span class="label">文字</span>',
        self::TYPE_COVER => '<span class="label label-primary">图片</span>',
        self::TYPE_CONTENT => '<span class="label label-info">文章</span>',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%addon_sys_debris}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','name'], 'required'],
            [['name'], 'unique'],
            [['type', 'append', 'updated'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['cover', 'character'], 'string', 'max' => 255],
            [['link'], 'string', 'max' => 1000],
            [['link'], 'url'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'name' => '标识',
            'type' => '类别',
            'cover' => '图片',
            'link' => '链接',
            'content' => '文章内容',
            'character' => '文字',
            'append' => '创建时间',
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
            