<?php

namespace common\models\sys;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $title
 * @property string $name
 * @property string $cover
 * @property string $cate_id
 * @property string $description
 * @property integer $position
 * @property string $content
 * @property string $link_id
 * @property integer $display
 * @property string $deadline
 * @property string $view
 * @property string $comment
 * @property string $bookmark
 * @property integer $scort
 * @property integer $status
 * @property string $append
 * @property string $updated
 */
class Article extends ActiveRecord
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
     * 正常
     */
    const DISPLAY_ON  = 1;
    /**
     * 逻辑删除
     */
    const DISPLAY_OFF = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id', 'display', 'deadline', 'view', 'comment', 'bookmark', 'incontent','sort', 'status', 'append', 'updated'], 'integer'],
            [['title','status'], 'required'],
            [['content'], 'string'],
            [['cate_stair','cate_second'],'safe'],
            [['title','seo_key'], 'string', 'max' => 50],
            [['name','author'], 'string', 'max' => 40],
            [['seo_content'], 'string', 'max' => 1000],
            [['cover', 'link'], 'string', 'max' => 100],
            [['link'],'url'],
            [['description'], 'string', 'max' => 140],
            [['position'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => 'Article ID',
            'manager_id'    => '创建者id',
            'title'         => '文章名称',
            'seo_key'       => 'SEO关键字',
            'seo_content'   => 'SEO内容',
            'cate_stair'    => '一级分类',
            'cate_second'   => '二级分类',
            'name'          => '标示',
            'cover'         => '封面',
            'description'   => '描述',
            'position'      => '推荐位',
            'content'       => '内容',
            'author'        => '作者',
            'link'          => '外链',
            'display'       => '可见性',
            'deadline'      => '截至时间',
            'view'          => '浏览量',
            'comment'       => '评论数量',
            'bookmark'      => '收藏数量',
            'incontent'     => '封面图片显示在正文中 ',
            'sort'          => '排序',
            'status'        => '显示状态',
            'append'        => '创建时间',
            'updated'       => '修改时间',
        ];
    }

    /**
     * 获取推荐位
     * @param $position Yii::$app->params['recommend']
     * @return string
     */
    public static function position($position)
    {
        return "position & {$position} = {$position}";
    }

    /**
     * 将两个参数进行按位与运算，不为0则表示$contain属于$pos
     * @param $pos
     * @param int $contain
     * @return bool
     */
    public static function checkPosition($pos, $contain = 0)
    {
        $res = $pos & $contain;
        return $res !== 0 ? true : false;
    }

    /**
     * 上一篇
     * @param $id 当前文章id
     * @return false|null|string
     */
    public static function getPrev($id)
    {
        return self::find()->where(['<','id',$id])->select('id')->orderBy('id asc')->scalar();
    }

    /**
     * 下一篇
     * @param $id 当前文章id
     * @return false|null|string
     */
    public static function getNext($id)
    {
        return self::find()->where(['>','id',$id])->select('id')->orderBy('id asc')->scalar();
    }

    /**
     * 生成推荐位的值
     * @return int|mixed
     */
    protected function getPosition()
    {
        $position = $this->position;

        $pos = 0;
        if(!is_array($position))
        {
            if($position > 0)
            {
                return $position;
            }
        }
        else
        {
            foreach ($position as $key => $value)
            {
                //将各个推荐位的值相加
                $pos += $value;
            }
        }
        
        return $pos;
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

        //推荐位
        $this->position = $this->getPosition();

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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }
}
