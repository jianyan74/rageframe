<?php
namespace common\helpers;

/**
 * 字符串操作类
 * Class StringHelper
 * @package common\helpers
 */
class StringHelper
{
    /**
     * 返回字符串在另一个字符串中第一次出现的位置
     * @param $string
     * @param $find
     * @return bool
     * true | false
     */
    public static function strExists($string, $find)
    {
        return !(strpos($string, $find) === false);
    }

    /**
     * 字符首字母转大小写
     * @param $str
     * @return mixed
     */
    public static function strUcwords($str)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $str)));
    }

    /**
     * 驼峰命名法转下划线风格
     * @param $str
     * @return string
     */
    public static function toUnderScore($str)
    {
        $array = [];
        for($i=0;$i<strlen($str);$i++)
        {
            if($str[$i] == strtolower($str[$i]))
            {
                $array[] = $str[$i];
            }
            else
            {
                if($i>0)
                {
                    $array[] = '-';
                }
                $array[] = strtolower($str[$i]);
            }
        }

        $result = implode('',$array);
        return $result;
    }

    /**
     * 下划线风格转驼峰命名法
     * @param $str
     * @return string
     */
    public static function toCamelCase($str)
    {
        $array = explode('_', $str);
        $result = '';
        foreach($array as $value)
        {
            $result.= ucfirst($value);
        }

        return $result;
    }

    /**
     * 获取随机字符串
     * @param $length
     * @param bool $numeric
     * @return string
     */
    public static function random($length, $numeric = false)
    {
        $seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));

        if ($numeric)
        {
            $hash = '';
        }
        else
        {
            $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
            $length--;
        }

        $max = strlen($seed) - 1;
        for ($i = 0; $i < $length; $i++)
        {
            $hash .= $seed{mt_rand(0, $max)};
        }
        return $hash;
    }

    /**
     * 获取数字随机字符串
     * @param null $prefix 判断是否需求前缀
     * @return string
     */
    public static function randomNum($prefix = false, $length = 8)
    {
        $str = $prefix ? $prefix : '';
        return $str.substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, $length);
    }

    /**
     * 获取字符串后面的字符串
     * @param $fileName
     * @param string $type
     * @return string
     */
    public static function clipping($fileName, $type = '.', $length = 0)
    {
        return substr(strtolower(strrchr($fileName, $type)), $length);
    }
}