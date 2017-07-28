<?php
namespace backend\modules\wechat\controllers;

use yii;
use linslin\yii2\curl;

/**
 * 获取图片信息
 * Class WeCodeController
 * @package backend\modules\wechat\controllers
 */
class WeCodeController extends WController
{
    /**
     * 获取微信图片
     */
    public function actionImage()
    {
        $image = Yii::$app->request->get('attach');
        $curl = new curl\Curl();
        $response = $curl->get($image);
        header('Content-Type:image/jpg');
        echo $response;
        exit();
    }
}