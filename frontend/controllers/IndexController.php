<?php
namespace frontend\controllers;

use Yii;

/**
 * Index controller
 */
class IndexController extends IController
{
    /**
     * 系统首页
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
