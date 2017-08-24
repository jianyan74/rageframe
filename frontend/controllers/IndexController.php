<?php
namespace frontend\controllers;

use Yii;

/**
 * Index controller
 */
class IndexController extends IController
{
    /**
     * @return string
     * 默认首页
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
