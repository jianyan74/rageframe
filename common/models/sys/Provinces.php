<?php

namespace common\models\sys;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%provinces}}".
 *
 * @property integer $id
 * @property string $areaname
 * @property integer $parentid
 * @property string $shortname
 * @property integer $areacode
 * @property integer $zipcode
 * @property string $pinyin
 * @property string $lng
 * @property string $lat
 * @property integer $level
 * @property string $position
 * @property integer $sort
 */
class Provinces extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%common_provinces}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'areaname', 'parentid', 'level', 'position'], 'required'],
            [['id', 'parentid', 'areacode', 'zipcode', 'level', 'sort'], 'integer'],
            [['areaname', 'shortname'], 'string', 'max' => 50],
            [['pinyin'], 'string', 'max' => 100],
            [['lng', 'lat'], 'string', 'max' => 20],
            [['position'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'areaname'  => '名称',
            'parentid'  => '父级ID',
            'shortname' => '简称',
            'areacode'  => '区域编号',
            'zipcode'   => '邮编',
            'pinyin'    => '拼音',
            'lng'       => 'Lng',
            'lat'       => 'Lat',
            'level'     => '级别',
            'position'  => '位置',
            'sort'      => '排序',
        ];
    }

    /**
     * 根据父级ID返回信息
     * @param int $parentid
     * @return array
     */
    public static function getCityList($parentid = 0)
    {
        //获取缓存信息
        $key = "_provinces_".$parentid;
        $model = Yii::$app->cache->get($key);
        if(!$model)
        {
            $model = Provinces::findAll(['parentid'=>$parentid]);
            //设置缓存
            Yii::$app->cache->set($key,$model);
        }

        return ArrayHelper::map($model,'id','areaname');
    }

    /**
     * 根据id获取区域名称
     * @param $id
     * @return mixed
     */
    public static function getCityName($id)
    {
       if($provinces =  Provinces::findOne($id))
       {
           return $provinces['areaname'];
       }

       return false;
    }
}
