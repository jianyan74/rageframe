<?php
namespace common\helpers;

use Ramsey\Uuid\Uuid;

/**
 * 字符串操作类
 *
 * Class StringHelper
 * @package common\helpers
 */
class StringHelper
{
    /**
     * 生成Uuid
     *
     * @param int $type
     * @return string
     */
    public static function uuid($type = 'time', $name = 'php.net')
    {
        switch ($type)
        {
            // 生成版本1（基于时间的）UUID对象
            case  'time' :
                $uuid = Uuid::uuid1();

                break;
            // 生成第三个版本（基于名称的和散列的MD5）UUID对象
            case  'md5' :
                $uuid = Uuid::uuid3(Uuid::NAMESPACE_DNS, $name);

                break;
            // 生成版本4（随机）UUID对象
            case  'random' :
                $uuid = Uuid::uuid4();

                break;
            // 产生一个版本5（基于名称和散列的SHA1）UUID对象
            case  'sha1' :
                $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, $name);

                break;
        }

        return $uuid->toString();
    }

    /**
     * XML 字符串载入对象中
     *
     * @param string $string 必需。规定要使用的 XML 字符串
     * @param string $class_name 可选。规定新对象的 class
     * @param int $options 可选。规定附加的 Libxml 参数
     * @param string $ns
     * @param bool $is_prefix
     * @return bool|\SimpleXMLElement
     */
    public static function simplexmlLoadString($string, $class_name = 'SimpleXMLElement', $options = 0, $ns = '', $is_prefix = false)
    {
        libxml_disable_entity_loader(true);
        if (preg_match('/(\<\!DOCTYPE|\<\!ENTITY)/i', $string))
        {
            return false;
        }

        return simplexml_load_string($string, $class_name, $options, $ns, $is_prefix);
    }

    /**
     * 字符串提取汉字
     *
     * @param $string
     * @return mixed
     */
    public static function strToChineseCharacters($string)
    {
        preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", $string, $chinese);

        return $chinese;
    }

    /**
     * 返回字符串在另一个字符串中第一次出现的位置
     *
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
     *
     * @param $str
     * @return mixed
     */
    public static function strUcwords($str)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $str)));
    }

    /**
     * 驼峰命名法转下划线风格
     *
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
                if($i > 0)
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
     *
     * @param $str
     * @return string
     */
    public static function toCamelCase($str)
    {
        $array = explode('_', $str);
        $result = '';
        foreach($array as $value)
        {
            $result .= ucfirst($value);
        }

        return $result;
    }

    /**
     * 获取随机字符串
     *
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
     *
     * @param bool $prefix 判断是否需求前缀
     * @param int $length 长度
     * @return string
     */
    public static function randomNum($prefix = false, $length = 8)
    {
        $str = $prefix ? $prefix : '';
        return $str . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, $length);
    }

    /**
     * 获取字符串后面的字符串
     *
     * @param $fileName
     * @param string $type
     * @param int $length
     * @return bool|string
     */
    public static function clipping($fileName, $type = '.', $length = 0)
    {
        return substr(strtolower(strrchr($fileName, $type)), $length);
    }
}