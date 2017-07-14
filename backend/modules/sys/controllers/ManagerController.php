<?php
namespace backend\modules\sys\controllers;

use yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use common\models\sys\Manager;
use backend\controllers\MController;
use backend\modules\sys\models\PasswdForm;
use backend\modules\sys\models\AuthItem;
use backend\modules\sys\models\AuthAssignment;

/**
 * 后台用户控制器
 * Class ManagerController
 * @package backend\modules\sys\controllers
 */
class ManagerController extends MController
{
    /**
     * 首页
     */
    public function actionIndex()
    {
        $request  = Yii::$app->request;
        $type     = $request->get('type',1);
        $keyword  = $request->get('keyword','');

        switch ($type)
        {
            case '1':
                $where = ['like', 'username', $keyword];
                break;
            case '2':
                $where = ['like', 'realname', $keyword];
                break;
            case '3':
                $where = ['like', 'mobile_phone', $keyword];
                break;
            default:
                $where = [];
                break;
        }

        //验证是否超级管理员
        $manager = [];
        if(Yii::$app->user->identity->id != Yii::$app->params['adminAccount'])
        {
            $manager = ['type' => Manager::TYPE_USER];
        }

        //关联角色查询
       $data   = Manager::find()->with('assignment')->where($where)->andWhere($manager);
       $pages  = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
       $models = $data->offset($pages->offset)->orderBy('type desc,created_at desc')->limit($pages->limit)->all();

       return $this->render('index',[
           'models'  => $models,
           'pages'   => $pages,
           'type'    => $type,
           'keyword' => $keyword,
       ]);

    }

    /**
     * 编辑/新增
     * @return string|\yii\web\Response
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $id       = $request->get('id');

        //总管理员权限验证
        $this->auth($id);
        $model    = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }


    /**
     * 用户账号
     * @return string|yii\web\Response
     */
    public function actionEditPersonal()
    {
        $request  = Yii::$app->request;
        $id       = $request->get('id');

        //总管理员权限验证
        $this->auth($id);
        $model    = $this->findModel($id);

        //提交表单
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }

        return $this->render('personal', [
            'model' => $model,
            'admin' => true,
        ]);
    }


    /**
     * 删除
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //总管理员权限验证
        $this->auth($id);

        if($this->findModel($id)->delete())
        {
            return $this->message('用户删除成功',$this->redirect(['index']));
        }
        else
        {
            return $this->message('用户删除失败',$this->redirect(['index']),'error');
        }
    }

    /**
     * 用户角色设置
     */
    public function actionAuthRole()
    {
        $request  = Yii::$app->request;
        //用户id
        $user_id  = $request->get('user_id');
        //角色
        $role     = AuthItem::find()->where(['type'=>AuthItem::ROLE])->all();
        //模型
        $model = AuthAssignment::find()->where(['user_id'=>$user_id])->one();

        if(!$model)
        {
            $model = new AuthAssignment();
            $model->user_id = $user_id;
        }

        if($model->load($request->post()))
        {
            if($request->isAjax)
            {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
            }
            else
            {
                $AuthAssignment = new AuthAssignment();
                //返回状态
                if($AuthAssignment->setAuthRole($model->user_id,$model->item_name))
                {
                    return $this->message('角色分配成功',$this->redirect(['index']));
                }
                else
                {
                    return $this->message('分配失败,角色可能已经被删除！',$this->redirect(['index']),'error');
                }
            }
        }

        return $this->renderAjax('auth-role', [
            'model'  => $model,
            'role'   => $role,
            'user_id'=> $user_id,
        ]);
    }

    /**
     * 修改个人资料
     * @return string|yii\web\Response
     */
    public function actionPersonal()
    {
        $id       = Yii::$app->user->identity->id;
        $model    = $this->findModel($id);

        //提交表单
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['personal','id'=>$id]);
        }

        return $this->render('personal', [
            'model' => $model,
            'admin' => false,
        ]);
    }


    /**
     * 修改密码
     * @return string|yii\web\Response
     */
    public function actionUpPasswd()
    {
        $request  = Yii::$app->request;
        $model    = new PasswdForm();

        if($model->load($request->post()) && $model->validate())
        {
            $id       = Yii::$app->user->identity->id;
            $manager  = $this->findModel($id);
            $manager->password_hash = $model->passwd_new;

            if($manager->save())
            {
                //退出登陆
                Yii::$app->user->logout();
                return $this->goHome();
            }
        }

        return $this->render('up_passwd', [
            'model' => $model,
        ]);
    }


    /**
     * 验证是否非总管理员用户来修改管理员信息
     * @param $id
     * @return bool
     * @throws NotFoundHttpException
     */
    public function auth($id)
    {
        if($id == Yii::$app->params['adminAccount'] && Yii::$app->user->identity->id != Yii::$app->params['adminAccount'])
        {
            throw new NotFoundHttpException('您没有权限更改超级管理员信息!');
        }
        else
        {
            return true;
        }
    }

    /**
     * 返回模型
     * @param $id
     * @return Manager|static
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            return new Manager;
        }

        if (empty(($model = Manager::findOne($id))))
        {
            return new Manager;
        }

        return $model;
    }

}