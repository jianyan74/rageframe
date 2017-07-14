<?php

namespace common\models\sys;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\helpers\AddonsHelp;
/**
 * This is the model class for table "{{%sys_addons}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $cover
 * @property string $description
 * @property integer $status
 * @property string $config
 * @property integer $is_setting
 * @property string $author
 * @property string $version
 * @property integer $sort
 * @property integer $has_adminlist
 * @property string $append
 */
class Addons extends ActiveRecord
{
    /**
     * 配置启用
     */
    const SETTING_TRUE = 1;
    /**
     * 配置关闭
     */
    const SETTING_FALSE = -1;
    /**
     * 钩子启用
     */
    const HOOK_TRUE = 1;
    /**
     * 钩子关闭
     */
    const HOOK_FALSE = -1;
    /**
     * 模块启用
     */
    const STATUS_ON = 1;
    /**
     * 模块关闭
     */
    const STATUS_OFF = -1;

    public $install;
    public $uninstall;
    public $upgrade;
    public $wechatMessage;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_addons}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name','unique','message'=>'该模块已经存在'],
            ['name','match','pattern'=>'/^[_a-zA-Z]+$/','message'=>'标识由英文和下划线组成'],
            [['name','title','version', 'description','install','uninstall','upgrade'], 'trim'],
            [['name','title', 'type','version', 'description','author'], 'required'],
            [['description', 'config'], 'string'],
            [['status', 'setting', 'hook','updated', 'append'], 'integer'],
            [['name', 'author'], 'string', 'max' => 40],
            [['title', 'version'], 'string', 'max' => 10],
            [['cover','wechat_message'], 'string', 'max' => 1000],
            [['group'], 'safe'],
            [['install','uninstall','upgrade'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '模块标识',
            'title' => '模板名称',
            'cover' => '封面',
            'group' => '组别',
            'type' => '类别',
            'description' => '模块说明',
            'status' => '状态',
            'config' => '配置信息',
            'hook' => '钩子',
            'setting' => '存在全局设置项',
            'author' => '作者',
            'version' => '版本',
            'wechatMessage' => '微信公众平台消息处理选项',
            'install' => '模块安装脚本',
            'uninstall' => '模块卸载脚本',
            'upgrade' => '模块升级脚本',
            'append' => '创建时间',
            'updated' => '更新',
        ];
    }

    /**
     * @param string $addon_dir
     * @return array
     * 获取插件列表
     */
    public function getList()
    {
        $addon_dir = Yii::getAlias('@addons');

        //获取插件列表
        $dirs = array_map('basename',glob($addon_dir.'/*'));

        $addons = [];
        $where = ['in','name',$dirs];
        $list =	$this->find()->where($where)->asArray()->all();

        foreach($list as $addon)
        {
            $addon['uninstall']		=	0;
            $addons[$addon['name']]	=	$addon;
        }

        foreach ($dirs as $value)
        {
            //判断是否安装
            if(!isset($addons[$value]))
            {
                $class = AddonsHelp::getAddonsClass($value);
                // 实例化插件失败忽略执行
                if(class_exists($class))
                {
                    $obj    =   new $class;
                    $addons[$value]	= $obj->info;

                    if($addons[$value])
                    {
                        $addons[$value]['uninstall'] = 1;
                        unset($addons[$value]['status']);
                    }
                }
            }
        }

        return $addons;
    }

    /**
     * @param $data
     * @return array
     * 重组数组
     */
    public static function regroupType($data)
    {
        $addonsType = Yii::$app->params['addonsType']['addon']['child'];

        $arr = [];
        foreach ($data as $vo)
        {
            $type = $vo['type'];
            $arr[$type][] = $vo;
        }

        $list = [];
        foreach ($addonsType as $key => &$item)
        {
            $list[$key]['title'] = $item;
            $list[$key]['list'] = [];
            if(isset($arr[$key]))
            {
                $list[$key]['list'] = $arr[$key];
            }
        }

        return $list;
    }


    /**
     * @param $name
     * @return array|null|ActiveRecord
     * 根据模块标识获取模块
     */
    public static function getAddon($name)
    {
        return Addons::find()->where(['name' => $name])->one();
    }

    /**
     * 获取插件列表
     * @param $name
     * @return array|null|ActiveRecord
     */
    public static function getPlugList()
    {
        $models = Addons::find()
            ->where(['status'=>Addons::STATUS_ON])
            ->andWhere(['type' => 'plug'])
            ->asArray()
            ->all();

        return $models ? $models : [];
    }

    /**
     * 卸载插件的时候清理安装的信息
     */
    public function afterDelete()
    {
        AddonsBinding::deleted($this->name);
        parent::afterDelete();
    }

    /**
     * @return array
     * 插入时间戳
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
