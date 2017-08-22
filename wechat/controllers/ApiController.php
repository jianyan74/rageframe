<?php
namespace wechat\controllers;

use Yii;
use common\helpers\AddonsHelp;
use common\controllers\AddonsBaseController;

/**
 * api(小程序)转接控制器
 * Class WxAppController
 * @package wechat\controllers
 */
class ApiController extends AddonsBaseController
{
    /**
     * 关闭csrf验证
     * @var bool
     */
    public $enableCsrfValidation = false;
    /**
     * 渲染模块目录
     */
    protected $apiSkipPath = 'api';

    /**
     * 前台和微信插件页面实现
     */
    public function actionExecute($route,$addon)
    {
        return $this->skip(AddonsHelp::analysisBusinessRoute($route,$addon,$this->apiSkipPath));
    }
}
