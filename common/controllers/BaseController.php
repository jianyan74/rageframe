<?php
namespace common\controllers;

use Yii;
use yii\web\Controller;

/**
 * 基类控制器
 * Class BaseController
 * @package common\controllers
 */
class BaseController extends Controller
{
    /**
     * 分页大小
     * @var int
     */
    public $_pageSize = 20;

    /**
     * 解析Yii2错误信息
     * @param $errors
     * @return string
     */
    public function analysisError($errors)
    {
        $errors = array_values($errors)[0];
        return $errors ? $errors : '操作失败';
    }

    /**
     * 打印调试
     * @param $array
     */
    public static function p($array)
    {
        echo "<pre>";
        print_r($array);
    }
}