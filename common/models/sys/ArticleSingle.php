<?php

namespace common\models\sys;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%article_single}}".
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
class ArticleSingle extends ActiveRecord
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
        return '{{%sys_article_single}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','status','view','display','content'], 'required'],
            [['manager_id', 'display', 'deadline', 'view', 'comment', 'sort', 'status', 'append', 'updated'], 'integer'],
            [['title','name'], 'required'],
            [['name'], 'unique'],
            [['content'], 'string'],
            [['title','seo_key'], 'string', 'max' => 50],
            [['seo_content'], 'string', 'max' => 1000],
            [['name','author'], 'string', 'max' => 40],
            [['cover', 'link'], 'string', 'max' => 100],
            [['link'],'url'],
            [['description'], 'string', 'max' => 140],
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
            'name'          => '标识',
            'cover'         => '封面',
            'content'       => '内容',
            'link'          => '外链',
            'description'   => '描述',
            'author'        => '作者',
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
     * 行为
     * @param bool $insert
     * @return bool
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
     * 行为
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
