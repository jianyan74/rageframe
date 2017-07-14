<?php
namespace common\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use common\helpers\StringHelper;

/**
 * 插件帮助类
 * Class AddonsHelp
 * @package common\helpers
 */
class AddonsHelp
{
    /**
     * 渲染模块目录
     */
    public static $skipPath = 'admin';

    /**
     * @param $name
     * @return string
     * 获取插件类
     */
    public static function getAddonsClass($name)
    {
        $class = "addons\\{$name}\\{$name}Addon";
        return $class;
    }

    /**
     * 获取插件的根目录目录
     * @param $name
     * @return string
     */
    public static function getAddons($name)
    {
        return Yii::getAlias('@addons')."\\{$name}\\";
    }

    /**
     * 解析模块地址
     * @param $route -路由
     * @param $addonName -模块名称
     * @param string $address -模块目录[admin,home]
     * @return array
     */
    public static function analysisBusinessRoute($route,$addonName,$address = null)
    {
        $address = !empty($address) ? $address : self::$skipPath;

        Yii::$app->params['addon']['skipPath'] = $address;
        $result = self::analysisRoute($route);

        //实例化对象地址
        $class = "\\addons\\{$addonName}\\{$address}\\controllers\\".$result['controllerName'];
        $result['class'] = $class;
        $result['addon'] = $addonName;
        Yii::$app->params['addon'] = ArrayHelper::merge(Yii::$app->params['addon'],$result);

        return $result;
    }

    /**
     * 配置基类路由解析
     * @param $route -路由
     * @param $addonsName -模块名称
     * @return array
     */
    public static function analysisBaseRoute($route,$addonsName)
    {
        Yii::$app->params['addon']['skipPath'] = self::$skipPath;
        $result = self::analysisRoute($route);

        //实例化对象地址
        $class = "\\addons\\{$addonsName}\\".$result['controller'];
        $result['class'] = $class;
        $result['addon'] = $addonsName;
        Yii::$app->params['addon'] = ArrayHelper::merge(Yii::$app->params['addon'],$result);

        return $result;
    }

    /**
     * 地址解析
     * @param $route
     * @return array
     */
    public static function analysisRoute($route)
    {
        $route = explode('/',$route);
        $controller = StringHelper::strUcwords($route[0]);
        $action = StringHelper::strUcwords($route[1]);

        return [
            'oldController' => $route[0],
            'oldAction' => $route[1],
            'controller' => $controller,
            'action' => $action,
            'controllerName' => $controller . 'Controller',
            'actionName' => "action".$action,
        ];
    }

    /**
     * 重组url
     * @param $url -重组地址
     * @param bool $type -地址类型
     * @return array|bool
     */
    public static function regroupUrl(array $url,$type = false)
    {
        $addonsUrl = $type ? ['addons/centre'] : ['addons/execute'];
        $addonsUrl['route'] = self::regroupRoute($url);
        $addonsUrl['addon'] = Yii::$app->request->get('addon');

        //删除默认跳转url
        unset($url[0]);
        foreach ($url as $key => $vo)
        {
            $addonsUrl[$key] = $vo;
        }

        return $addonsUrl;
    }

    /**
     * 重组路由
     * @param $url
     * @return string
     */
    public static function regroupRoute($url)
    {
        $oldRoute = Yii::$app->request->get('route');

        $route = $url[0];
        //如果只填写了方法转为控制器方法
        if(count(explode('/',$route)) < 2)
        {
            $oldRoute = explode('/',$oldRoute);
            $oldRoute[1] = $url[0];
            $route = implode('/',$oldRoute);
        }

        return $route;
    }

    /**
     * 基于数组创建目录
     * @param $files
     */
    public static function createDirOrFiles($files)
    {
        foreach ($files as $key => $value)
        {
            if(substr($value, -1) == '/')
            {
                @mkdir($value);
            }
            else
            {
                @file_put_contents($value, '');
            }
        }
    }

    /**
     * 生成导航菜单
     * @param $data
     * @param $field
     * @return string
     */
    public static function bindingsToString($data,$field)
    {
        $str = "";
        if(isset($data[$field]))
        {
        $str = "'{$field}' => [";
            $countCover = count($data[$field]['title']);
            for ($i = 0; $i < $countCover; $i++)
            {
                if($data[$field]['title'][$i])
                {
                    $temporaryArr = "
            [
                'title' => '{$data[$field]['title'][$i]}',
                'route' => '{$data[$field]['route'][$i]}',
                'icon' => '{$data[$field]['icon'][$i]}'
            ]";
                    $i <= $countCover && $temporaryArr .= ",";
                    $str .= $temporaryArr;
                }
            }
            $str .= "
        ]";
        }

        return $str;
    }
}