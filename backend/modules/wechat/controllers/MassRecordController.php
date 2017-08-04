<?php
namespace backend\modules\wechat\controllers;

use Yii;
use common\models\wechat\Attachment;
use common\models\wechat\MassRecord;
use common\models\wechat\FansGroups;

/**
 * 群发记录控制器
 * Class MassRecordController
 * @package backend\modules\wechat\controllers
 */
class MassRecordController extends WController
{
    /**
     * 获取粉丝分组 - 群发
     * @return string
     */
    public function actionSendFans($attach_id)
    {
        $attachment = Attachment::getOne($attach_id);

        $model = $this->findModel('');
        $model->attach_id = $attachment->id;
        $model->media_id = $attachment->media_id;
        $model->type = $attachment->type;

        if ($model->load(Yii::$app->request->post()))
        {
            $broadcast = $this->_app->broadcast;

            if(!$model['group'])
            {
                $model->group_name = '全部粉丝';
                $result = $broadcast->send($model['type'], $model['media_id']);
            }
            else
            {
                $model->group = $model['group'];
                $result = $broadcast->send($model['type'], $model['media_id'], $model['group']);

                //获取分组信息
                $group = FansGroups::getGroup($model['group']);
                $model->group_name = $group['name'];
                $model->fans_num = $group['count'];
            }

            $model->final_send_time = time();
            $model->msg_id = $result['msg_id'];
            $model->save();

            return $this->message("发送成功",$this->redirect(['attachment/'.$model['type'].'-index']));
        }

        $groups = FansGroups::updateGroupList();
        unset($groups[0]);
        unset($groups[1]);

        return $this->renderAjax('send-fans',[
            'model' => $model,
            'groups' => $groups,
        ]);
    }

    /**
     * 返回模型
     * @param $id
     * @return $this|MassRecord|static
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            $model = new MassRecord;
            return $model->loadDefaultValues();
        }

        if (empty(($model = MassRecord::findOne($id))))
        {
            return new MassRecord;
        }

        return $model;
    }
}
