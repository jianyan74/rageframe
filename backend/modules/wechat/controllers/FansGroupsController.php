<?php
namespace backend\modules\wechat\controllers;

use yii;
use common\models\wechat\FansGroups;
use yii\web\NotFoundHttpException;

/**
 * 粉丝分组
 * Class FansGroupsController
 * @package backend\modules\wechat\controllers
 */
class FansGroupsController extends WController
{
    /**
     * 分组首页
     * @return string
     */
    public function actionList()
    {
        return $this->render('index',[
            'groups' => FansGroups::getGroups()
        ]);
    }

    /**
     * 删除
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->_app->user_group->delete($id))
        {
            FansGroups::updateGroupList();
            return $this->message("删除成功",$this->redirect(['list']));
        }
        else
        {
            return $this->message("删除失败",$this->redirect(['list']),'error');
        }
    }

    /**
     * 更新修改数据
     * @return yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate()
    {
        $request = Yii::$app->request;

        if($request->isPost)
        {
            $group_add = $request->post('group_add','');
            $group_update = $request->post('group_update','');

            //更新分组
            if($group_update)
            {
                foreach ($group_update as $key => $value)
                {
                    if($value)
                    {
                        $this->_app->user_group->update($key,$value);
                    }
                    else
                    {
                        $this->message("分组名称不能为空",$this->redirect(['list'],'error'));
                    }
                }
            }

            //插入分组
            if($group_add)
            {
                foreach ($group_add as $value)
                {
                    $this->_app->user_group->create($value);
                }
            }
            FansGroups::updateGroupList();
            return $this->redirect(['list']);
        }
        else
        {
            throw new NotFoundHttpException('请求失败.');
        }
    }

    /**
     * 同步粉丝
     * @return mixed
     */
    public function actionSynchro()
    {
        FansGroups::updateGroupList();
        return $this->message("粉丝同步成功",$this->redirect(['list']));
    }

    /**
     * 返回分组模型
     * @return array|FansGroups|null|yii\db\ActiveRecord
     */
    protected function findModel()
    {
        if (empty(($model = FansGroups::find()->one())))
        {
            return new FansGroups;
        }

        return $model;
    }
}
