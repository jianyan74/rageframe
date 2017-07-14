<?php
namespace backend\modules\member\controllers;

/**
 * Class DefaultController
 * @package backend\modules\member\controllers
 */
class DefaultController extends UController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
