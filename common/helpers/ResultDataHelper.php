<?php
namespace common\helpers;

/**
 * ajax数据格式返回
 * Class ResultDataHelper
 * @package common\helpers
 */
class ResultDataHelper
{
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
     * 状态码
     * @var
     */
    public $code = 404;
}