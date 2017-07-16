<?php

namespace common\models\sys;

use Yii;

/**
 * This is the model class for table "{{%action_log}}".
 *
 * @property string $id
 * @property string $action_id
 * @property string $user_id
 * @property string $action_ip
 * @property string $model
 * @property string $record_id
 * @property string $remark
 * @property integer $status
 * @property string $append
 */
class ActionLog extends \yii\db\ActiveRecord
{
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    const ACTION_FORBID_IP = 'forbid_ip';

    /**
     * @var array
     */
    public static $behavior = [
        self::ACTION_LOGIN => '登陆',
        self::ACTION_LOGOUT => '退出',
        self::ACTION_FORBID_IP => 'ip不正确',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_action_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action_ip'], 'required'],
            [['manager_id', 'action_ip', 'record_id', 'status', 'append'], 'integer'],
            [['model','country','province','city','action'], 'string', 'max' => 50],
            [['district'], 'string', 'max' => 150],
            [['remark','log_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'action'    => '行为',
            'manager_id'   => '用户ID',
            'action_ip' => 'IP',
            'model'     => '触发行为的表',
            'record_id' => '触发行为的数据id',
            'remark'    => '说明',
            'status'    => '状态',
            'append'    => '创建时间',
        ];
    }


    /**
     * 插入日志
     * @param $action
     * @param $model
     * @param null $remark
     * @param null $record_id
     */
    public function addLog($action,$model,$remark=NULL,$record_id = NULL)
    {
        //行为id
        !$record_id && $record_id = 0;
        $logModel = new ActionLog();
        //判断是否登录
        if (!\Yii::$app->user->isGuest)
        {
            $logModel->manager_id   = Yii::$app->user->identity->id;
            $logModel->username     = Yii::$app->user->identity->username;
        }

        $logModel->action_ip    = ip2long(Yii::$app->request->userIP);
        $logModel->action       = $action;
        $logModel->model        = $model;
        $logModel->record_id    = $record_id;
        $logModel->log_url      = Yii::$app->request->getUrl();
        $logModel->remark       = $remark;
        //IP地址信息来源
        $ipInfo = \common\helpers\ApiHelper::IpInfoSina(Yii::$app->request->userIP);
        $logModel->country = $ipInfo['country'];
        $logModel->province = $ipInfo['province'];
        $logModel->city = $ipInfo['city'];
        $logModel->district = $ipInfo['district'];

        $logModel->save();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Manager::className(), ['id' => 'manager_id']);
    }

    /**
     * 行为
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->append = time();
        }

        return parent::beforeSave($insert);
    }
}
