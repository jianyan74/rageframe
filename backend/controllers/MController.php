<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\controllers\BaseController;

/**
 * 后台基类控制器
 * Class MController
 * @package backend\controllers
 */
class MController extends BaseController
{
    /**
     * csrf验证
     * @var bool
     */
    public $enableCsrfValidation = true;

    /**
     * 自动运行
     */
    public function init()
    {
        //分页
        Yii::$app->config->info('SYS_PAGE') && $this->_pageSize = Yii::$app->config->info('SYS_PAGE');
    }

    /**
     * 统一加载
     * @inheritdoc
     */
    public function actions()
    {
        return [
            //错误提示跳转页面
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 行为控制
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],//登录
                    ],
                ],
            ],
        ];
    }

    /**
     * RBAC验证
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        //验证是否登录
        if (!\Yii::$app->user->isGuest)
        {
            //验证是否超级管理员
            if(Yii::$app->user->identity->id === Yii::$app->params['adminAccount'])
            {
                return true;
            }
        }

        if (!parent::beforeAction($action))
        {
            return false;
        }

        //控制器+方法
        $permissionName = Yii::$app->controller->id.'/'.Yii::$app->controller->action->id;
        //加入模块验证
        if(Yii::$app->controller->module->id != "app-backend")
        {
            $permissionName = Yii::$app->controller->module->id.'/'.$permissionName;
        }

        //验证不需要RBAC判断的控制器
        $noAuthController = ['wechat/default/index'];
        if(in_array($permissionName,$noAuthController))
        {
            return true;
        }

        if(!Yii::$app->user->can($permissionName) && Yii::$app->getErrorHandler()->exception === null)
        {
            throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
        }

        return true;
    }

    /**
     * 错误提示信息
     * @param $msgText  -错误内容
     * @param $skipUrl  -跳转链接
     * @param $msgType  -提示类型
     * @param int $closeTime -提示关闭时间
     * @return mixed
     */
    public function message($msgText,$skipUrl,$msgType="",$closeTime=5)
    {
        $closeTime = (int)$closeTime;

        //如果是成功的提示则默认为3秒关闭时间
        if(!$closeTime && $msgType == "success" || !$msgType)
        {
            $closeTime = 3;
        }

        $html = $this->hintText($msgText,$closeTime);

        switch ($msgType)
        {
            case "success" :

                Yii::$app->getSession()->setFlash('success',$html);

                break;

            case "error" :

                Yii::$app->getSession()->setFlash('error',$html);

                break;

            case "info" :

                Yii::$app->getSession()->setFlash('info',$html);

                break;

            case "warning" :

                Yii::$app->getSession()->setFlash('warning',$html);

                break;

            default :

                Yii::$app->getSession()->setFlash('success',$html);

                break;
        }

        return $skipUrl;
    }

    /**
     * @param $msg
     * @param $closeTime
     * @return string
     */
    public function hintText($msg,$closeTime)
    {
        $text = $msg." <span class='closeTimeYl'>".$closeTime."</span>秒后自动关闭...";
        return $text;
    }

    /**
     * @var array
     */
    public static $result = [
        'flg' => 2,
        'msg' => '修改失败',
    ];

    /**
     * 公用的修改排序或者状态
     * @param $model
     * @return array
     */
    public function updateModelData($model)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result = static::$result;

        $model->attributes = Yii::$app->request->get();
        if(!$model->save())
        {
            $result['msg'] = $this->analysisError($model->getFirstErrors());
            return $result;
        }

        $result['flg'] = 1;
        $result['msg'] = "修改成功!";
        return $result;
    }
}