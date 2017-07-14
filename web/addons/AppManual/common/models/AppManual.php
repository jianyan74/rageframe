<?php
namespace addons\AppManual\common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class AppManual extends ActiveRecord
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%addon_app_manual}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name','unique'],
            [['title','status'], 'required'],
            [['status','name','append', 'updated'], 'trim'],
            ['sort', 'number'],
            ['content', 'string'],
            [['pid','sort'], 'default', 'value' => 0],
            [['level'], 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'title'    => '标题',
            'name'     => '标识',
            'content'  => '内容',
            'pid'      => '上级id',
            'url'      => '路由',
            'menu_css' => '样式图标',
            'sort'     => '排序',
            'status'   => '状态',
            'append'   => '创建时间',
            'updated'  => '修改时间',
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
            