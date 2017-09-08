<?php
namespace addons\Adv\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @property integer $id
 * @property string $title
 * @property integer $name
 * @property integer $status
 * @property integer $append
 * @property integer $updated
 */
class AdvLocation extends ActiveRecord
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
        return '{{%addon_sys_adv_location}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','name', 'status'], 'required'],
            ['name','unique'],
            [['sort', 'status', 'append', 'updated'], 'integer'],
            [['title','name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'title'       => '标题',
            'name'        => '标识',
            'sort'        => '排序',
            'status'      => '显示状态',
            'append'      => '创建时间',
            'updated'     => '修改时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     * 关联广告
     */
    public function getAdv()
    {
        return $this->hasOne(Adv::className(),['location_id'=>'id'])
            ->where(['status'=> Adv::STATUS_ON])
            ->andFilterWhere(['<=','start_time',time()])
            ->andFilterWhere(['>=','end_time',time()]);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     * 返回广告位
     */
    public static function getAdvLocationList()
    {
        $advLocation = AdvLocation::find()
            ->orderBy('sort')
            ->all();

        return ArrayHelper::map($advLocation,'id','title');
    }

    /**
     * @param $id
     */
    public static function getTitle($id)
    {
        $advLocation = AdvLocation::findOne($id);
        return $advLocation['title'];
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
