<?php

namespace common\models\wechat;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%wechat_news}}".
 *
 * @property integer $id
 * @property string $attach_id
 * @property string $title
 * @property string $thumb_media_id
 * @property string $thumb_url
 * @property string $author
 * @property string $digest
 * @property string $show_cover_pic
 * @property string $content
 * @property string $content_source_url
 * @property integer $sort
 * @property string $media_id
 * @property integer $append
 * @property integer $updated
 */
class News extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attach_id', 'append', 'updated','show_cover_pic','sort'], 'integer'],
            [['title'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['thumb_media_id', 'thumb_url', 'digest', 'content_source_url', 'url'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attach_id' => '资源id',
            'title' => '标题',
            'thumb_media_id' => '微信缩略图id',
            'thumb_url' => '微信缩略图Url',
            'author' => '作者',
            'digest' => '说明',
            'show_cover_pic' => '文章是否显示封面',
            'content' => '内容',
            'content_source_url' => '原文链接',
            'sort' => '排序',
            'url' => '文章Url地址',
            'append' => '创建时间',
            'updated' => '修改时间',
        ];
    }

    /**
     * 返回素材列表
     * @param $id
     * @return $this|Attachment|static
     */
    public static function getList($attach_id)
    {
        $list = self::find()->where(['attach_id'=>$attach_id])
            ->orderBy('sort asc')
            ->asArray()
            ->all();

        foreach ($list as &$item)
        {
            $item['thumb_url'] = urldecode(Url::to(['we-code/image','attach'=>$item['thumb_url']]));
            preg_match_all('/<img[^>]*src\s*=\s*([\'"]?)([^\'" >]*)\1/isu', $item['content'],$match);

            $match_arr = [];
            foreach ($match[2] as $vo)
            {
                $match_arr[$vo] = $vo;
            }

            foreach ($match_arr as $src)
            {
                $url = Url::to(['we-code/image','attach' => $src]);
                $url = urldecode($url);
                $item['content'] =  str_replace($src,$url,$item['content']);
            }
        }

        return $list;
    }

    /**
     * 返回素材列表
     * @param $id
     * @return $this|Attachment|static
     */
    public static function getNewsList($sort=0)
    {
        $list = self::find()->where(['sort' => $sort])
            ->orderBy('id asc')
            ->asArray()
            ->all();

        return $list;
    }

    /**
     * 删除全部文章
     * @param $attach_id
     * @return int
     */
    public static function delAll($attach_id)
    {
        return self::deleteAll(['attach_id' => $attach_id]);
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
