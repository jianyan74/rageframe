<?php

namespace common\models\wechat;

use Yii;

/**
 * This is the model class for table "{{%wechat_fans_groups}}".
 *
 * @property integer $id
 * @property string $groups
 */
class FansGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_fans_groups}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groups'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'groups'    => '分组',
        ];
    }

    /**
     * 获取分组信息
     * @return mixed
     */
    public static function getGroups()
    {
        if (empty(($model = FansGroups::find()->one())))
        {
            $app = Yii::$app->wechat->getApp();
            $list = $app->user_group->lists();
            $groups = $list['groups'];

            $model = new FansGroups();
            $model->groups = serialize($groups);
            $model->save();

            return $groups;
        }

        return unserialize($model->groups);
    }

    /**
     * 获取分组信息并保存到数据库
     */
    public static function updateGroupList()
    {
        $app = Yii::$app->wechat->getApp();
        $list = $app->user_group->lists();

        $groups = $list['groups'];
        if (empty(($model = FansGroups::find()->one())))
        {
            $model = new FansGroups;
        }

        $model->groups = serialize($groups);
        $model->save();

        return $groups;
    }
}
