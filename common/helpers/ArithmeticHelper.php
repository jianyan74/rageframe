<?php
namespace common\helpers;

/**
 * 算法辅助类
 * Class ArrayHelper
 * @package common\helpers
 */
class ArithmeticHelper
{
    /**
     * 生成红包算法
     * @param $money - 红包总金额
     * @param $num - 生成的红包数量
     * @param $min - 红包最小金额
     * @param $max - 红包最大金额
     * @return array
     */
    public static function getRedPackage($money, $num, $min, $max)
    {
        $data = [];

        //判断最小红包乘数量是否大于总金额
        if ($min * $num > $money)
        {
            return $data;
        }

        //判断最大红包乘数量是否小于总金额
        if($max * $num < $money)
        {
            return $data;
        }

        while ($num >= 1)
        {
            $num--;
            $kmix = max($min, $money - $num * $max);
            $kmax = min($max, $money - $num * $min);
            $kAvg = $money / ($num + 1);
            //获取最大值和最小值的距离之间的最小值
            $kDis = min($kAvg - $kmix, $kmax - $kAvg);
            //获取0到1之间的随机数与距离最小值相乘得出浮动区间，这使得浮动区间不会超出范围
            $r = ((float)(rand(1, 10000) / 10000) - 0.5) * $kDis * 2;
            $k = round($kAvg + $r, 2);

            $money -= $k;
            $data[] = $k;
        }

        shuffle($data);
        return $data;
    }
}