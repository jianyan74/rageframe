<?php
namespace backend\modules\wechat\controllers;

/**
 * 图文控制器
 * Class NewsController
 * @package backend\modules\wechat\controllers
 */
class NewsController extends WController
{
    /**
     * @return string
     * 首页
     */
    public function actionIndex()
    {
        return $this->render('index',[
        ]);
    }
}
