<?php

namespace common\models\sys;

use Yii;

/**
 * This is the model class for table "{{%sys_addons_binding}}".
 *
 * @property integer $id
 * @property string $addons_name
 * @property string $entry
 * @property string $title
 * @property string $route
 * @property string $icon
 * @property integer $displayorder
 */
class AddonsBinding extends \yii\db\ActiveRecord
{
    /**
     *后台菜单
     */
    const ENTRY_MENU = 'menu';
    /**
     * 首页导航
     */
    const ENTRY_COVER = 'cover';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_addons_binding}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'route',], 'required'],
            [['addons_name', 'route'], 'string', 'max' => 30],
            [['entry'], 'string', 'max' => 10],
            [['title', 'icon'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'addons_name' => '插件名称',
            'entry' => '入口类型',
            'title' => '标题',
            'route' => '路由',
            'icon' => '图标',
        ];
    }

    /**
     * @param $data
     * 添加数据
     */
    public static function add($data,$addons_name)
    {
        foreach ($data as $key => $datum)
        {
            foreach ($datum as $vo)
            {
                $model = new AddonsBinding();
                $model->attributes = $vo;
                $model->entry = $key;
                $model->addons_name = $addons_name;
                $model->save();
            }
        }
    }

    /**
     * 批量删除
     * @param $addons_name
     */
    public static function deleted($addons_name)
    {
        AddonsBinding::deleteAll(['addons_name'=>$addons_name]);
    }


    /**
     * 获取菜单和导航列表
     * @param $addons_name
     * @return array
     */
    public static function getList($addons_name)
    {
        $list = AddonsBinding::find()
            ->where(['addons_name'=>$addons_name])
            ->orderBy('id asc')
            ->asArray()
            ->all();

        $data = [
            self::ENTRY_COVER => [],
            self::ENTRY_MENU => [],
        ];

        foreach ($list as $li)
        {
            $data[$li['entry']][] = $li;
        }

        return $data;
    }

    /**
     * 关联插件
     * @return \yii\db\ActiveQuery
     */
    public function getAddon()
    {
        return $this->hasOne(Addons::className(),['name' => 'addons_name']);
    }
}
