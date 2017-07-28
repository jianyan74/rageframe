<?php
namespace common\models\sys;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property string $id
 * @property string $name
 * @property integer $type
 * @property string $title
 * @property integer $cate
 * @property string $extra
 * @property string $remark
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property string $value
 * @property integer $sort
 */
class Config extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'unique','message'=>'标识已经占用'],
            [['title','name','cate','cate_child','type'],'required'],
            [['type', 'cate', 'append', 'updated', 'status', 'sort','is_hide_remark'], 'integer'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 30],
            [['title'], 'string', 'max' => 50],
            [['extra'], 'string', 'max' => 255],
            [['remark'], 'string', 'max' => 1000],
            [['name'], 'unique'],
            [['sort'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'name'      => '配置标识',
            'type'      => '配置类型',
            'title'     => '配置标题',
            'cate'      => '分类',
            'cate_child' => '具体分类',
            'extra'     => '配置项',
            'remark'    => '说明',
            'status'    => '状态',
            'value'     => '配置值',
            'sort'      => '排序',
            'is_hide_remark' => '是否隐藏说明',
            'append'    => '创建时间',
            'updated'   => '修改时间',
        ];
    }

    /**
     * 返回配置名称
     * @param $name
     * @return bool|mixed
     */
    public function info($name)
    {
        //获取缓存信息
        $info = $this->getConfigInfo();
        return isset($info[$name]) ? trim($info[$name]) : false;
    }

    /**
     * 返回配置名称
     * @param $name
     * @return bool|mixed
     */
    public function infoAll()
    {
        $info = $this->getConfigInfo();
        return $info ? $info : false;
    }

    /**
     * 获取全部配置信息
     * @return array|mixed
     */
    protected function getConfigInfo()
    {
        //获取缓存信息
        $key = "_siteConfigInfo";
        $info = Yii::$app->cache->get($key);
        if(!$info)
        {
            $config = Config::find()->all();
            $info = [];
            foreach ($config as $row)
            {
                $info[$row['name']] = $row['value'];
            }

            //设置缓存
            Yii::$app->cache->set($key,$info);
        }

        return $info;
    }

    /**
     * 分析枚举类型配置值 格式 a:名称1,b:名称2
     * @param $string
     * @return array
     */
    public static function parseConfigAttr($string)
    {
        $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
        if(strpos($string,':'))
        {
            $value = [];
            foreach ($array as $val)
            {
                list($k, $v) = explode(':', $val);
                $value[$k]   = $v;
            }
        }
        else
        {
            $value  =   $array;
        }

        return $value;
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        //清除缓存
        Yii::$app->cache->delete("_siteConfigInfo");
        return parent::beforeSave($insert);
    }

    /**
     * 行为
     * @return bool
     */
    public function beforeDelete()
    {
        Yii::$app->cache->delete("_siteConfigInfo");
        return parent::beforeDelete();
    }

    /**
     * 关联具体分类
     * @return \yii\db\ActiveQuery
     */
    public function getCateChild()
    {
        return $this->hasOne(ConfigCate::className(), ['id' => 'cate_child']);
    }

    /**
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
