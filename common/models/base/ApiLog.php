<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%api_log}}".
 *
 * @property int $id
 * @property string $url
 * @property string $method
 * @property string $get_data
 * @property string $post_data
 * @property string $ip ip地址
 * @property int $append
 */
class ApiLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['get_data', 'post_data'], 'string'],
            [['append'], 'integer'],
            [['url'], 'string', 'max' => 100],
            [['method'], 'string', 'max' => 20],
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
            'method' => '提交类型',
            'url' => '提交的url',
            'get_data' => 'get数据',
            'post_data' => 'post数据',
            'ip' => 'IP地址',
            'append' => '创建时间',
        ];
    }
}