<?php
namespace api\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use common\enums\StatusEnum;
use common\controllers\ActiveController;

/**
 * 用户信息基类
 *
 * Class MController
 * @package api\controllers
 */
class MController extends ActiveController
{
    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        // 自定义数据indexDataProvider覆盖IndexAction中的prepareDataProvider()方法
        // $actions['index']['prepareDataProvider'] = [$this, 'indexDataProvider'];
        return $actions;
    }

    /**
     * 首页
     *
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $query = $modelClass::find()
            ->where(['status' => StatusEnum::ENABLED, 'member_id' => Yii::$app->user->identity->user_id])
            ->offset($this->_offset)
            ->limit($this->_limit)
            ->asArray()
            ->all();

        return $query;
    }

    /**
     * 创建
     *
     * @return bool
     */
    public function actionCreate()
    {
        $model = new $this->modelClass();
        $model->attributes = Yii::$app->request->post();
        $model->member_id = Yii::$app->user->identity->user_id;
        if (!$model->save())
        {
            // 返回数据验证失败
            return $this->setResponse($this->analysisError($model->getFirstErrors()));
        }

        return $model;
    }

    /**
     * 更新
     *
     * @param $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->attributes = Yii::$app->request->post();
        if (!$model->save())
        {
            // 返回数据验证失败
            return $this->setResponse($this->analysisError($model->getFirstErrors()));
        }

        return $model;
    }

    /**
     * 删除
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = StatusEnum::DELETE;
        return $model->save();
    }

    /**
     * 显示单个
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    /**
     * 返回模型
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            throw new NotFoundHttpException('请求的数据不存在.');
        }

        if ($model = $this->modelClass::find()->where(['id' => $id, 'status' => StatusEnum::ENABLED, 'member_id' => Yii::$app->user->identity->user_id])->one())
        {
            return $model;
        }

        throw new NotFoundHttpException('请求的数据不存在.');
    }
}
