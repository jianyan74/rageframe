<?php
namespace backend\modules\wechat\controllers;

use yii;
use common\models\wechat\FansGroups;
use yii\web\NotFoundHttpException;
/**
 * Class FansGroupsController
 * @package backend\modules\wechat\controllers
 * 粉丝分组
 */
class FansGroupsController extends WController
{
    /**
     * @return string
     * 分组列表
     */
    public function actionList()
    {
        $model = new FansGroups();
        return $this->render('index',[
            'groups' => $model->getGroups()
        ]);
    }

    /**
     * @return string
     * 删除分组
     */
    public function actionDelete($id)
    {
        if($this->_app->user_group->delete($id))
        {
            $this->updateGroupList();
            return $this->message("删除成功",$this->redirect(['list']));
        }
        else
        {
            return $this->message("删除失败",$this->redirect(['list']),'error');
        }
    }


    /**
     * @return yii\web\Response
     * @throws NotFoundHttpException
     * 更新修改数据
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
            $this->updateGroupList();
            return $this->redirect(['list']);
        }
        else
        {
            throw new NotFoundHttpException('请求失败.');
        }
    }

    /**
     * @return yii\web\Response
     * 同步
     */
    public function actionSynchro()
    {
        $this->updateGroupList();
        return $this->message("粉丝同步成功",$this->redirect(['list']));
    }

    /**
     * 获取分组信息并保存到数据库
     */
    public function updateGroupList()
    {
        $list = $this->_app->user_group->lists();
        $groups = $list['groups'];
        $model = $this->findModel();
        $model->groups = serialize($groups);
        $model->save();

        return $groups;
    }

    /**
     * @param $id
     * @return array|FansGroups|null|\yii\db\ActiveRecord
     * 返回模型
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
