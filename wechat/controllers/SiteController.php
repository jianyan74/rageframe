<?php
namespace wechat\controllers;

/**
 * Site controller
 */
class SiteController extends WController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 微信首页
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 验证登录根据openid
     */
    public function actionLogin()
    {

    }
}
