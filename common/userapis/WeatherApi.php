<?php
namespace common\userapis;

use linslin\yii2\curl\Curl;
use common\helpers\StringHelper;

/**
 * 系统默认天气Api案例
 *
 * Class WeatherApi
 * @package common\userapis
 */
class WeatherApi implements \jianyan\basics\common\interfaces\WxMsgInterface
{
    /**
     * 天气接口
     *
     * 请在自定义接口设置匹配关键字  (.+)天气$
     * @param array $message 微信用户传递过来的消息
     * @return string
     */
    public function run($message)
    {
        $ret = preg_match('/(.+)天气/i', $message['Content'], $matchs);
        if(!$ret)
        {
            return '请输入合适的格式, 城市+天气, 例如: 北京天气';
        }

        $city = $matchs[1];
        $url = 'http://php.weather.sina.com.cn/xml.php?city=%s&password=DJOYnieT8234jlsK&day=0';
        $url = sprintf($url, urlencode(iconv('utf-8', 'gb2312', $city)));

        $curl = new Curl();
        $resp = $curl->get($url);
        $obj = StringHelper::simplexmlLoadString($resp, 'SimpleXMLElement', LIBXML_NOCDATA);

        $response = '';
        if (isset($obj->Weather->city))
        {
            $data = $obj->Weather;
            $response = $data->city . '今日天气' . PHP_EOL .
                '今天白天'.$data->status1.'，'. $data->temperature1 . '摄氏度。' . PHP_EOL .
                $data->direction1 . '，' . $data->power1 . PHP_EOL .
                '今天夜间'.$data->status2.'，'. $data->temperature2 . '摄氏度。' . PHP_EOL .
                $data->direction2 . '，' . $data->power2 . PHP_EOL .
                '==================' . PHP_EOL .
                '【穿衣指数】：' . $data->chy_shuoming . PHP_EOL .
                '【感冒指数】：' . $data->gm_l . $data->gm_s . PHP_EOL .
                '【空调指数】：' . $data->ktk_s . PHP_EOL .
                '【污染物扩散条件】：' . $data->pollution_l . $data->pollution_s . PHP_EOL .
                '【洗车指数】：' . $data->xcz_l . $data->xcz_s . PHP_EOL .
                '【运动指数】：' . $data->yd_l . $data->yd_s . PHP_EOL .
                '【紫外线指数】：' . $data->zwx_l . $data->zwx_s . PHP_EOL .
                '【体感度指数】：' . $data->ssd_l . $data->ssd_s . PHP_EOL ;
        }

        return $response;
    }
}
