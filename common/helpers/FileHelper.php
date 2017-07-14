<?php
namespace common\helpers;

/**
 * 文件帮助类
 * Class FileHelper
 * @package common\helpers
 */
class FileHelper
{
    /**
     * 检测目录并循环创建目录
     * @param $path
     */
    public static function mkdirs($path)
    {
        if (!file_exists($path))
        {
            self::mkdirs(dirname($path));
            mkdir($path, 0777);
        }
    }

    /**
     * 写入日志
     * @param $path
     * @param $content
     */
     public static function writeLog($path,$content)
     {
         file_put_contents($path, "\r\n".$content, FILE_APPEND);
     }
}