<?php

namespace common\models\sys;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%sys_config_cate}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $pid
 * @property integer $sort
 * @property integer $status
 * @property integer $level
 * @property integer $append
 * @property integer $updated
 */
class ConfigCate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_config_cate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['id', 'pid', 'sort', 'status', 'level', 'append', 'updated'], 'integer'],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'title'     => '分类名称',
            'status'    => '状态',
            'sort'      => '排序',
            'pid'       => '上级目录ID',
            'level'     => '级别',
            'append'    => '创建时间',
            'updated'   => '修改时间',
        ];
    }

    /**
     * 获取一级分类
     * @return array|ActiveRecord[]
     */
    public static function getListRoot()
    {
        return self::find()
            ->where(['pid' => 0])
            ->orderBy('sort asc')
            ->asArray()
            ->all();
    }

    /**
     * 获取全部分类
     * @return array|ActiveRecord[]
     */
    public static function getListAll()
    {
        return self::find()
            ->where(['status'=>1])
            ->orderBy('sort asc')
            ->asArray()
            ->all();
    }

    /**
     * 根据父级ID返回信息
     * @param int $pid
     * @return array
     */
    public static function getChildList($pid = 0)
    {
        $cates = self::find()
            ->where(['pid'=>$pid,'status'=>1])
            ->orderBy('sort asc')
            ->all();

        return ArrayHelper::map($cates,'id','title');
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
