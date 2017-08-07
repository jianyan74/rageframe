<?php

namespace common\models\wxapp;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\helpers\StringHelper;

/**
 * This is the model class for table "{{%wxapp_account}}".
 *
 * @property string $id
 * @property string $addon_name
 * @property string $token
 * @property string $encodingaeskey
 * @property integer $level
 * @property string $account
 * @property string $original
 * @property string $key
 * @property string $secret
 * @property string $name
 * @property integer $status
 * @property integer $append
 * @property integer $updated
 */
class Account extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wxapp_account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'status', 'append', 'updated'], 'integer'],
            [['addon_name'], 'string', 'max' => 20],
            [['token'], 'string', 'max' => 32],
            [['encodingaeskey'], 'string', 'max' => 43],
            [['account', 'name'], 'string', 'max' => 30],
            [['original', 'key', 'secret'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'addon_name' => '添加模块',
            'token' => 'Token',
            'encodingaeskey' => 'Encodingaeskey',
            'level' => 'Level',
            'account' => '小程序账号',
            'original' => '原始ID',
            'key' => 'AppId',
            'secret' => 'AppSecret',
            'name' => '小程序名称',
            'status' => '状态',
            'append' => '创建时间',
            'updated' => '修改时间',
        ];
    }

    /**
     * 获取小程序
     * @param $addon_name 模块名称
     * @return array|Account|null|\yii\db\ActiveRecord
     */
    public static function getAccount($id,$addon_name)
    {
        if (empty($id) || empty($addon_name))
        {
            return false;
        }

        if (empty(($model = self::find()->where(['addon_name' => $addon_name,'id'=>$id])->one())))
        {
            return false;
        }

        return $model;
    }

    /**
     * 关联版本号
     * @return \yii\db\ActiveQuery
     */
    public function getVersions()
    {
        return $this->hasMany(Versions::className(),['account_id'=>'id']);
    }

    /**
     * 插入token
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->token = StringHelper::random(32);
            $this->encodingaeskey = StringHelper::random(43);
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        Versions::deleteAll(['account_id' => $this->id]);
        return parent::beforeDelete();
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }
}
