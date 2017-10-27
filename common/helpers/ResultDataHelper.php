<?php
namespace common\helpers;

use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * ajax数据格式返回
 * Class ResultDataHelper
 * @package common\helpers
 */
class ResultDataHelper
{
    /**
     * 状态码
     * @var
     */
    public $code = 404;

    /**
     * 返回的数据格式
     * @var string
     */
    public $message = '未知错误';

    /**
     * 返回的数据结构
     * @var array|object|string
     */
    public $data = [];

    /**
     * 直接返回数据格式
     * @param int $code
     * @param string $message
     * @param array $data
     */
    public static function result($code = 404, $message = '未知错误', array $data = [])
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = [
            'code' => strval($code),
            'message' => trim($message),
            'data' => $data ? ArrayHelper::toArray($data) : [],
        ];

        return $result;
    }
}