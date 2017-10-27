<?php
namespace addons\AppExample\common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%addon_app_example_curd}}".
 *
 * @property string $id
 * @property string $title
 * @property string $cate_id
 * @property string $manager_id
 * @property integer $sort
 * @property integer $position
 * @property integer $sex
 * @property string $content
 * @property string $cover
 * @property string $covers
 * @property string $attachfile
 * @property string $keywords
 * @property string $description
 * @property double $price
 * @property string $views
 * @property integer $stat_time
 * @property integer $end_time
 * @property integer $status
 * @property string $email
 * @property string $provinces
 * @property string $city
 * @property string $area
 * @property string $ip
 * @property string $append
 * @property string $updated
 */
class Curd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%addon_app_example_curd}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cate_id', 'manager_id', 'sort', 'position', 'sex', 'views', 'status', 'append', 'updated'], 'integer'],
            [['content','title','sort','status'], 'required'],
            [['stat_time', 'end_time'], 'safe'],
            [['content'], 'string'],
            [['price'], 'number'],
            [['title'], 'string', 'max' => 50],
            [['cover', 'attachfile', 'keywords'], 'string', 'max' => 100],
            [['covers'], 'string', 'max' => 1500],
            [['description'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 60],
            [['email'], 'email'],
            [['provinces', 'city', 'area'], 'string', 'max' => 10],
            [['ip'], 'string', 'max' => 16],
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
            'cate_id' => '分类ID',
            'manager_id' => '创建者ID',
            'sort' => '排序',
            'position' => '推荐位',
            'sex' => '性别',
            'content' => '内容',
            'cover' => '封面',
            'covers' => '轮播图',
            'attachfile' => '附件',
            'keywords' => '关键字',
            'description' => '简单介绍',
            'price' => '价格',
            'views' => '浏览量',
            'stat_time' => '开始时间',
            'end_time' => '结束时间',
            'status' => '状态',
            'email' => '邮箱',
            'provinces' => '省',
            'city' => '市',
            'area' => '区',
            'ip' => 'ip',
            'append' => '创建时间',
            'updated' => '修改时间',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        //创建时候插入
        if($this->isNewRecord)
        {
            $this->ip = Yii::$app->request->userIP;
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
