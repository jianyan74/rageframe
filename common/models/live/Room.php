<?php
namespace common\models\live;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\enums\StatusEnum;
use common\helpers\StringHelper;

/**
 * This is the model class for table "{{%live_room}}".
 *
 * @property int $id
 * @property int $member_id 会员id
 * @property string $title 房间名称
 * @property string $cover 封面
 * @property int $onlookers_num 房间号
 * @property int $recommend 推荐位
 * @property int $like_num 喜欢人数
 * @property int $watch_num 观看人数
 * @property int $sort 排序
 * @property int $status 状态(-1:已删除,0:禁用,1:正常)
 * @property int $append 创建时间
 * @property int $updated 修改时间
 */
class Room extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%live_room}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'room_num', 'like_num', 'watch_num', 'sort', 'append', 'updated'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['cover'], 'string', 'max' => 255],
            [['recommend', 'status'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '会员id',
            'title' => '房间名称',
            'cover' => '封面',
            'room_num' => '房间号',
            'recommend' => '推荐位',
            'like_num' => '喜欢人数',
            'watch_num' => '观看人数',
            'sort' => '排序',
            'status' => '状态',
            'append' => '创建时间',
            'updated' => '修改时间',
        ];
    }

    /**
     * @return array|ActiveRecord[]
     */
    public static function getList()
    {
        return self::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->orderBy('sort desc')
            ->asArray()
            ->all();
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->room_num = StringHelper::randomNum();

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
