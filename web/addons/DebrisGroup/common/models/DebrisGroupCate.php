<?php

namespace addons\DebrisGroup\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%addon_sys_debris_group_cate}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property integer $type
 * @property integer $append
 * @property integer $updated
 */
class DebrisGroupCate extends ActiveRecord
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
    /**
     * 图片+描述
     */
    const TYPE_COVER_TEXT = 4;

    public static $type = [
        self::TYPE_CHARACTER => '文字',
        self::TYPE_COVER => '图片',
        self::TYPE_CONTENT => '文章',
        self::TYPE_COVER_TEXT => '图片+描述',
    ];

    /**
     * @var array
     * 样式
     */
    public static $typeText = [
        self::TYPE_CHARACTER => '<span class="label">文字</span>',
        self::TYPE_COVER => '<span class="label label-primary">图片</span>',
        self::TYPE_CONTENT => '<span class="label label-info">文章</span>',
        self::TYPE_COVER_TEXT => '<span class="label label-info">图片+描述</span>',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%addon_sys_debris_group_cate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','name'], 'required'],
            [['name'], 'unique'],
            [['type','sort', 'append', 'updated'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'title'     => '标题',
            'name'      => '标识',
            'type'      => '类型',
            'sort'      => '排序',
            'append'    => '创建时间',
            'updated'   => '修改时间',
        ];
    }

    /**
     * 关联碎片
     * @return \yii\db\ActiveQuery
     */
    public function getDebrisGroup()
    {
        return $this->hasMany(DebrisGroup::className(),['cate_id'=>'id']);
    }

    /**
     * 返回列表
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getList()
    {
        $model = self::find()->orderBy('sort')->all();
        return ArrayHelper::map($model,'id','title');
    }

    /**
     * @param $id
     */
    public static function getOne($id)
    {
        $model = self::findOne($id);
        return $model;
    }

    /**
     * @param $id
     */
    public static function getTitle($id)
    {
        $model = self::findOne($id);
        return $model ? $model['title'] : false;
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }
}
