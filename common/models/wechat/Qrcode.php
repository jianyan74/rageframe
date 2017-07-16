<?php

namespace common\models\wechat;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%wechat_qrcode}}".
 *
 * @property string $id
 * @property string $scene_id
 * @property string $name
 * @property string $keyword
 * @property integer $model
 * @property string $ticket
 * @property string $expire_seconds
 * @property string $subnum
 * @property integer $status
 * @property string $type
 * @property string $extra
 * @property string $url
 * @property string $scene_str
 * @property string $append
 * @property integer $updated
 */
class Qrcode extends ActiveRecord
{
    /**
     * 临时
     */
    const MODEL_TEM = 1;
    /**
     * 永久
     */
    const MODEL_PERPETUAL = 2;

    /**
     * 类别[扫描]
     */
    const TYPE_SCENE = 'scene';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_qrcode}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','keyword', 'model'], 'required'],
            [['scene_id', 'model','end_time', 'expire_seconds', 'subnum', 'status', 'append', 'updated'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['keyword'], 'string', 'max' => 100],
            [['ticket'], 'string', 'max' => 250],
            [['type'], 'string', 'max' => 10],
            [['url'], 'string', 'max' => 80],
            [['scene_str'], 'string', 'max' => 64],
            ['model', 'verifyModel'],
            ['expire_seconds', 'compare', 'compareValue' => 2592000, 'operator' => '<='],
            ['expire_seconds', 'compare', 'compareValue' => 60, 'operator' => '>='],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'scene_id'  => '场景ID',
            'name'      => '二维码名称',
            'keyword'   => '二维码触发的关键字 ',
            'model'     => '二维码类型',
            'ticket'    => 'Ticket',
            'expire_seconds' => '过期时间',
            'subnum'    => 'Subnum',
            'status'    => 'Status',
            'type'      => '类别',
            'extra'     => 'Extra',
            'url'       => 'url',
            'scene_str' => '场景字符串',
            'append'    => '生成时间',
            'updated'   => '修改时间',
        ];
    }

    /**
     * 验证提交的类别
     */
    public function verifyModel()
    {
        if($this->isNewRecord)
        {
            //临时
            if($this->model == self::MODEL_TEM)
            {
                if(empty($this->expire_seconds))
                {
                    $this->addError('expire_seconds', '临时二维码过期时间必填');
                }
            }
            else
            {
                !$this->scene_str && $this->addError('scene_str', '永久二维码场景字符串必填');
                if(Qrcode::find()->where(['scene_str' => $this->scene_str])->one())
                {
                    $this->addError('scene_str', '场景值已经存在');
                }
            }
        }
    }

    /**
     * 返回场景ID
     * @return int|mixed
     */
    public static function getSceneId()
    {
        $qrCode = Qrcode::find()
            ->where(['model' => self::MODEL_TEM])
            ->orderBy('append desc')
            ->one();

        return $qrCode ? $qrCode->scene_id + 1: 10001;
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
            $this->end_time = time() + $this->expire_seconds;
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
