<?php

namespace common\models\wechat;

use Yii;

class Account extends \yii\db\ActiveRecord
{
    /**
     * 事件
     */
    const TYPE_EVENT = "event";
    /**
     * 关注事件
     */
    const TYPE_SUBSCRIBE = "subscribe";
    /**
     * 取消关注事件
     */
    const TYPE_UN_SUBSCRIBE = "unsubscribe";

    /**
     * 上传地址事件
     */
    const TYPE_EVENT_LOCATION = "LOCATION";

    /**
     * 访问链接事件
     */
    const TYPE_EVENT_VIEW = "VIEW";

    /**
     * 点击事件
     */
    const TYPE_CILCK = "CLICK";

    /**
     * 二维码扫描事件
     */
    const TYPE_SCAN = "SCAN";
    /**
     * 文本消息
     */
    const TYPE_TEXT = "text";
    /**
     * 图片消息
     */
    const TYPE_IMAGE = "image";
    /**
     *语音消息
     */
    const TYPE_VOICE = "voice";
    /**
     * 视频消息
     */
    const TYPE_VIDEO = "video";
    /**
     * 地理位置消息
     */
    const TYPE_LOCATION = "location";
    /**
     * 链接消息
     */
    const TYPE_LINK = "link";

    /***************************************************其他消息**************************************************/

    /**
     * 小视频消息
     */
    const TYPE_SHORTVIDEO = "shortvideo";
    /**
     * 上报地理位置
     */
    const TYPE_TRACE = "trace";
    /**
     * 微小店消息
     */
    const TYPE_MERCHANT_ORDER = "merchant_order";
    /**
     * 摇一摇:开始摇一摇消息
     */
    const TYPE_SHAKEAROUND_USER_SHAKE = "ShakearoundUserShake";
    /**
     * 摇一摇:摇到了红包消息
     */
    const TYPE_SHAKEAROUND_LOTTERY_BIND = "ShakearoundLotteryBind";
    /**
     * Wifi连接成功消息
     */
    const TYPE_WIFI_CONNECTED = "WifiConnected";

    /**
     * @var array
     * 特殊消息类型
     */
    public static $mtype = [
        self::TYPE_IMAGE => "图片消息",
        self::TYPE_VOICE => "语音消息",
        self::TYPE_VIDEO => "视频消息",
        self::TYPE_SHORTVIDEO => "小视频消息",
        self::TYPE_LOCATION => "位置消息",
        self::TYPE_TRACE => "上报地理位置",
        self::TYPE_LINK => "链接消息",
        self::TYPE_MERCHANT_ORDER => "微小店消息",
        self::TYPE_SHAKEAROUND_USER_SHAKE => "摇一摇:开始摇一摇消息",
        self::TYPE_SHAKEAROUND_LOTTERY_BIND => "摇一摇:摇到了红包消息",
        self::TYPE_WIFI_CONNECTED => "Wifi连接成功消息",
    ];

    /**
     * 验证token是否一致
     * @param $signature -微信加密签名，signature结合了开发者填写的token参数和请求中的timestamp参数、nonce参数
     * @param $timestamp -时间戳
     * @param $nonce -随机数
     * @return bool
     */
    public static function verifyToken($signature,$timestamp,$nonce)
    {
        $token = Yii::$app->config->info('WECHAT_TOKEN');
        $tmpArr = [$token,$timestamp,$nonce];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        return $tmpStr == $signature ? true : false;
    }
}
