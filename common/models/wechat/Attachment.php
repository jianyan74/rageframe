<?php

namespace common\models\wechat;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%wechat_attachment}}".
 *
 * @property string $id
 * @property string $manager_id
 * @property string $filename
 * @property string $attachment
 * @property string $media_id
 * @property string $width
 * @property string $height
 * @property string $type
 * @property string $model
 * @property string $tag
 * @property string $append
 */
class Attachment extends \yii\db\ActiveRecord
{
    const TYPE_NEWS = 'news';
    const TYPE_TEXT = 'text';
    const TYPE_VOICE = 'voice';
    const TYPE_IMAGE = 'image';
    const TYPE_CARD = 'card';
    const TYPE_VIDEO = 'video';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id', 'media_id', 'type'], 'required'],
            [['manager_id', 'width', 'height', 'append','updated'], 'integer'],
            [['file_name', 'attachment', 'media_id'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 15],
            [['model'], 'string', 'max' => 10],
            [['tag'], 'string', 'max' => 5000],
            [['width','height'], 'safe'],
            ['model', 'default', 'value' => 'perm'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manager_id' => '管理员id',
            'file_name' => '文件名称',
            'attachment' => '资源路径',
            'media_id' => '资源id',
            'width' => '宽度',
            'height' => '高度',
            'type' => '类别',
            'model' => '是否永久',
            'tag' => 'Tag',
            'append' => '创建时间',
            'updated' => '修改时间',
        ];
    }


    /**
     * 返回素材
     * @param $id
     * @return $this|Attachment|static
     */
    public static function getList($type)
    {
        return self::find()->where(['type'=>$type])
            ->with('news')
            ->orderBy('id desc')
            ->asArray()
            ->all();
    }

    /**
     * 返回素材
     * @param $id
     * @return $this|Attachment|static
     */
    public static function getOne($id)
    {
        return self::findOne($id);
    }

    /**
     * 返回关联的图文信息
     * @return $this
     */
    public function getNews()
    {
        return $this->hasMany(News::className(),['attach_id'=>'id'])->orderBy('id asc');
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        //删除文章详细详细
        if($this->type == self::TYPE_NEWS)
        {
            News::delAll($this->id);
        }

        return parent::beforeDelete();
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->manager_id = Yii::$app->user->id;
        return parent::beforeSave($insert);
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
