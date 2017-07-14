<?php
namespace common\helpers;

/**
 * 数组帮助类
 * Class ArrayHelper
 * @package common\helpers
 */
class SysArrayHelper
{
    /**
     * 递归数组
     * @param $items
     * @param string $id
     * @param int $pid
     * @param string $pidName
     * @return array
     */
    public static function itemsMerge($items,$id="id",$pid = 0,$pidName='pid')
    {
        $arr = array();
        foreach($items as $v)
        {
            if($v[$pidName] == $pid)
            {
                $v['-'] = self::itemsMerge($items,$id,$v[$id],$pidName);
                $arr[] = $v;
            }
        }
        return $arr;
    }

    /**
     * 传递一个子分类ID返回所有的父级分类
     * @param $cate
     * @param int $pid
     * @return array
     */
    public static function getParents($items,$id)
    {
        $arr = array();
        foreach ($items as $v)
        {
            if ($v['id'] == $id)
            {
                $arr[] = $v;
                $arr = array_merge(self::getParents($items, $v['pid']), $arr);
            }
        }
        return $arr;
    }

    /**
     * 传递一个父级分类ID返回所有子分类ID
     * @param $cate
     * @param int $pid
     * @return array
     */
    public static function getChildsId($cate,$pid)
    {
        $arr = array();
        foreach ($cate as $v)
        {
            if ($v['pid'] == $pid)
            {
                $arr[] = $v['id'];
                $arr = array_merge($arr, self::getChildsId($cate, $v['id']));
            }
        }
        return $arr;
    }

    /**
     * 传递一个父级分类ID返回所有子分类
     * @param $cate
     * @param int $pid
     * @return array
     */
    public static function getChilds($cate,$pid)
    {
        $arr = array();
        foreach ($cate as $v)
        {
            if ($v['pid'] == $pid)
            {
                $arr[] = $v;
                $arr = array_merge($arr, self::getChilds($cate, $v['id']));
            }
        }
        return $arr;
    }

    /**
     * php二维数组排序 按照指定的key 对数组进行排序
     * @param array $arr 将要排序的数组
     * @param string $keys 指定排序的key
     * @param string $type 排序类型 asc | desc
     * @return array
     */
    public static function arraySort($arr, $keys, $type = 'asc')
    {
        $count = count($arr);
        if($count <= 1)
        {
            return $arr;
        }
        else
        {
            $keysvalue = array();
            $new_array = array();

            foreach ($arr as $k => $v)
            {
                $keysvalue[$k] = $v[$keys];
            }
            $type == 'asc' ? asort($keysvalue) : arsort($keysvalue);
            reset($keysvalue);

            foreach ($keysvalue as $k => $v)
            {
                $new_array[$k] = $arr[$k];
            }

            return $new_array;
        }
    }
}