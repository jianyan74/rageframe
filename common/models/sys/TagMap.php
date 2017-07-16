<?php

namespace common\models\sys;

use Yii;

/**
 * This is the model class for table "{{%tag_map}}".
 *
 * @property integer $tag_id
 * @property integer $id
 */
class TagMap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_article_tag_map}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'article_id'], 'integer'],
        ];
    }


    /**
     * @param $article_id
     * @param $tags
     */
    static public function addTags($article_id,$tags)
    {
        //删除原有标签关联
        TagMap::deleteAll(['article_id' => $article_id]);
        if($article_id && $tags)
        {
            $data = [];
            foreach ($tags as $v)
            {
                $data[] = [$v,$article_id];
            }

            $field = ['tag_id', 'article_id'];
            //批量插入数据
            Yii::$app->db->createCommand()->batchInsert(TagMap::tableName(),$field, $data)->execute();

            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id'     => '标签ID',
            'article_id' => '文章ID',
        ];
    }
}
