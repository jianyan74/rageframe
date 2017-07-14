<?php
namespace common\helpers;

use yii;
use yii\helpers\Url;
/**
 * Class Url
 * @package common\helpers
 * 插件Url生成辅助类
 */
class AddonsUrl
{
    /**
     * 生成模块Url
     * @param string $url
     * @param bool $scheme
     * @return bool|string
     */
    public static function to(array $url, $scheme = false)
    {
        return urldecode(Url::to(AddonsHelp::regroupUrl($url),$scheme));
    }

    /**
     * 生成插件前台Url
     * @return string
     */
    public static function toFront(array $url, $scheme = false)
    {
        return urldecode(Yii::$app->urlManagerFrontend->createAbsoluteUrl(AddonsHelp::regroupUrl($url),$scheme));
    }

    /**
     * 生成插件微信Url
     * @return string
     */
    public static function toWechat(array $url, $scheme = false)
    {
        return urldecode(Yii::$app->urlManagerWechat->createAbsoluteUrl(AddonsHelp::regroupUrl($url),$scheme));
    }

    /**
     * 生成插件基类跳转链接
     * @return string
     */
    public static function toRoot(array $url, $scheme = false)
    {
        return urldecode(Url::to(AddonsHelp::regroupUrl($url,true),$scheme));
    }
}
