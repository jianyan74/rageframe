<?php

namespace common\models\wechat;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%wechat_custom_menu}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $title
 * @property integer $sex
 * @property integer $group_id
 * @property integer $client_platform_type
 * @property string $area
 * @property string $data
 * @property integer $status
 * @property integer $is_deleted
 * @property string $append
 * @property integer $updated
 */
class CustomMenu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_custom_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['id', 'type', 'sex', 'group_id', 'client_platform_type', 'status', 'append', 'updated'], 'integer'],
            [['data','menu_data'], 'string'],
            [['title'], 'string', 'max' => 30],
            [['area'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id' => '菜单id',
            'type' => '菜单类型',
            'title' => '菜单名称',
            'sex' => '性别',
            'group_id' => '分组',
            'client_platform_type' => 'Client Platform Type',
            'area' => '地区',
            'data' => '数据',
            'status' => '状态',
            'menu_data' => '微信数据',
            'append' => '创建时间',
            'updated' => '修改时间',
        ];
    }

    /**
     * 修改默认菜单状态
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->status = 1;
        return parent::beforeSave($insert);
    }

    /**
     * 修改其他菜单状态
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        CustomMenu::updateAll(['status'=>-1],['not in','id',[$this->id]]);
        parent::afterSave($insert, $changedAttributes);
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
