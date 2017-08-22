<?php
namespace addons\BottomMenu\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%addon_sys_bottom_menu}}".
 *
 * @property integer $single_id
 * @property string $manager_id
 * @property string $title
 * @property string $name
 * @property string $cover
 * @property string $description
 * @property string $content
 * @property string $link
 * @property integer $display
 * @property string $deadline
 * @property string $view
 * @property string $comment
 * @property string $bookmark
 * @property integer $sort
 * @property integer $status
 * @property string $append
 * @property string $updated
 */
class BottomMenu extends ActiveRecord
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
        return '{{%addon_sys_bottom_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id', 'display', 'deadline', 'view', 'comment', 'sort', 'status', 'append', 'updated'], 'integer'],
            [['title'], 'required'],
            [['content'], 'string'],
            [['title','seo_key'], 'string', 'max' => 50],
            [['seo_content'], 'string', 'max' => 1000],
            [['name'], 'string', 'max' => 40],
            [['cover', 'link'], 'string', 'max' => 100],
            [['link'],'url'],
            [['description'], 'string', 'max' => 140],
            [['pid'], 'default', 'value' => 0],
            [['level'], 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'single_id'     => '文章id',
            'manager_id'    => '创建者id',
            'title'         => '标题',
            'seo_key'       => 'SEO关键字',
            'seo_content'   => 'SEO内容',
            'name'          => '标示',
            'cover'         => '封面',
            'content'       => '内容',
            'link'          => '外链',
            'description'   => '描述',
            'display'       => '可见性',
            'deadline'      => '截至时间',
            'view'          => '浏览量',
            'comment'       => '评论数量',
            'bookmark'      => '收藏数量',
            'sort'          => '排序',
            'status'        => '显示状态',
            'append'        => '创建时间',
            'updated'       => '修改时间',
        ];
    }

    /**
     * @param $model
     * @return bool
     *  更新浏览记录
     */
    public static function updateView($model)
    {
        if($model)
        {
            $model->view = $model->view + 1;
            $model->save();
            return true;
        }

        return false;
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
            $this->manager_id = Yii::$app->user->id;
        }

        return parent::beforeSave($insert);
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
            