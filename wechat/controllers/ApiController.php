<?php
namespace wechat\controllers;

use Yii;
use common\helpers\AddonsHelp;
use jianyan\basics\common\controllers\AddonsBaseController;

/**
 * api(小程序)转接控制器
 *
 * Class WxAppController
 * @package wechat\controllers
 */
class ApiController extends AddonsBaseController
{
    /**
     * 关闭csrf验证
     *
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * 渲染模块目录
     *
     * @var string
     */
    protected $apiSkipPath = 'api';

    /**
     * 前台和微信插件页面实现
     *
     * @param string $route
     * @param string $addon
     * @return bool
     * @throws \yii\web\UnauthorizedHttpException
     */
    public function actionExecute($route = null, $addon = null)
    {
        !$route && $route = Yii::$app->request->post('route','');
        !$addon && $addon = Yii::$app->request->post('addon','');

        return $this->skip(AddonsHelp::analysisBusinessRoute($route, $addon, $this->apiSkipPath));
    }
}
