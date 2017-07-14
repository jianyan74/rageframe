<?php

namespace backend\modules\sys\models;

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
class AuthItemChild extends \common\models\base\AuthItemChild
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
    public static function tableName()
    {
        return '{{%sys_auth_item_child}}';
    }

    public function init()
    {
        $this->auth_rule = AuthRule::className();
        $this->auth_assignment = AuthAssignment::className();
        $this->auth_item = AuthItem::className();
        $this->auth_item_child = AuthItemChild::className();

        parent::init();
    }
}
