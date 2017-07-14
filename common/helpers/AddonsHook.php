<?php
namespace common\helpers;

use yii;

/**
 * 钩子实现类
 * Class AddonsHook
 * @package common\helpers
 */
class AddonsHook
{
    /**
     * 钩子渲染路径
     * @var string
     */
    const hookPath = 'Setting/hook';

    /**
     * @param $addonsName 模块名字
     * @param $params 传递的数组
     */
    public static function to($addonsName, $params=false)
    {
        return self::skip(AddonsHelp::analysisBaseRoute(self::hookPath,$addonsName),$params);
    }

    /**
     * 实现钩子
     * @param $through
     * @param $params
     * @return bool
     */
    public static function skip($through,$params)
    {
        $class = $through['class'];
        $actionName = $through['actionName'];

        if(!class_exists($class))
        {
            return false;
        }

        $list = new $class($through['controller'],Yii::$app->module);
        if(!method_exists($list,$actionName))
        {
            return false;
        }

        return $list->$actionName($through['addon'],$params);
    }
}
