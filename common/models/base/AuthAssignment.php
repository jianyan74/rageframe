<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%auth_assignment}}".
 *
 * @property string $item_name
 * @property string $user_id
 * @property integer $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
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
            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => $this->auth_item, 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name'     => '角色名称',
            'user_id'       => '用户ID',
            'created_at'    => 'Created At',
        ];
    }

    /**
     * @param $user_id      -用户id
     * @param $item_name    -权限名称
     */
    public function setAuthRole($user_id,$item_name)
    {
        $this::deleteAll(['user_id'=>$user_id]);

        $authAssignment = new $this;
        $authAssignment->user_id    = $user_id;
        $authAssignment->item_name  = $item_name;

        return $authAssignment->save() ? true : false ;
    }

    /**
     * @param $user_id
     * 根据用户ID获取权限名称
     */
    public function getName($user_id)
    {
        $model = $this::find()
            ->where(['user_id'=>$user_id])
            ->one();

        return $model ? $model->item_name : false ;
    }

    /**
     * @return \yii\db\ActiveQuery
     *  关联
     */
    public function getItemName()
    {
        return $this->hasOne($this->auth_item, ['name' => 'item_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     *  关联
     */
    public function getItemNameChild()
    {
        return $this->hasMany($this->auth_item_child, ['parent' => 'item_name']);
    }

    /**
     * 插入前行为
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->created_at = time();
        }

        return parent::beforeSave($insert);
    }
}
