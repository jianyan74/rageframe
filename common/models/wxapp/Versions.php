<?php

namespace common\models\wxapp;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%wxapp_versions}}".
 *
 * @property string $id
 * @property integer $account_id
 * @property string $version
 * @property string $description
 * @property string $modules
 * @property integer $design_method
 * @property string $quickmenu
 * @property integer $append
 */
class Versions extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wxapp_versions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'design_method', 'append'], 'integer'],
            [['version'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 255],
            [['modules'], 'string', 'max' => 1000],
            [['quickmenu'], 'string', 'max' => 2500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'version' => '版本号',
            'description' => '小程序描述',
            'modules' => 'Modules',
            'design_method' => 'Design Method',
            'quickmenu' => 'Quickmenu',
            'append' => 'Append',
        ];
    }

    /**
     * 插入时间戳
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append'],
                ],
            ],
        ];
    }
}
