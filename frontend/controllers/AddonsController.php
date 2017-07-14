<?php
namespace frontend\controllers;

use common\controllers\AddonsBaseController;

/**
 * 微信插件渲染控制器
 * Class AddonsController
 * @package frontend\controllers
 */
class AddonsController extends AddonsBaseController
{
    /**
     * 前台关闭自动获取微信用户信息
     * @var bool
     */
    protected $openGetWechatUser = false;
}