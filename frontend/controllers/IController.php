<?php
namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\controllers\BaseController;

/**
 * 前台基类控制器
 *
 * Class IController
 * @package frontend\controllers
 */
class IController extends BaseController
{
    /**
     * csrf验证
     * @var bool
     */
    public $enableCsrfValidation = true;

    /**
     * @throws NotFoundHttpException
     */
    public function init()
    {
        //站点关闭信息
        if(Yii::$app->config->info('SYS_SITE_CLOSE') != 1)
        {
            throw new NotFoundHttpException('您访问的站点已经关闭');
        }
    }
}
