<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%auth_item_child}}".
 *
 * @property string $parent
 * @property string $child
 *
 * @property AuthItem $parent0
 * @property AuthItem $child0
 */
class AuthItemChild extends \yii\db\ActiveRecord
{
    /**
     * 规则类名
     * @var
     */
    protected $auth_rule;
    /**
     * 角色授权用户类
     * @var
     */
    protected $auth_assignment;
    /**
     * 角色路由类
     * @var
     */
    protected $auth_item;
    /**
     * 路由授权角色类
     * @var
     */
    protected $auth_item_child;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => $this->auth_item, 'targetAttribute' => ['parent' => 'name']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => $this->auth_item, 'targetAttribute' => ['child' => 'name']],
        ];
    }

    /**
     * @param $parent  -角色名称
     * @param $auth    -所有权限
     * @return bool
     */
    public function accredit($parent,$auth)
    {
        //删除原先所有权限
        $this::deleteAll(['parent' => $parent]);

        foreach ($auth as $value)
        {
            $AuthItemChild = new $this;
            $AuthItemChild->parent = $parent;
            $AuthItemChild->child  = $value;
            $AuthItemChild->save();
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => 'Parent',
            'child' => 'Child',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne($this->auth_item, ['name' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
        return $this->hasOne($this->auth_item, ['name' => 'child']);
    }
}
