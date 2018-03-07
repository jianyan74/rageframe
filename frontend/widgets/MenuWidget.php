<?php
namespace frontend\widgets;

use yii;
use yii\base\Widget;
use common\enums\StatusEnum;
use jianyan\basics\common\models\sys\DeskMenu;

/**
 * 前台导航widget
 * Class MenuWidget
 * @package frontend\widgets
 */
class MenuWidget extends Widget
{
    public function run()
    {
        $models = DeskMenu::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->orderBy('sort ASC')
            ->asArray()
            ->all();

        //控制器
        $controller = Yii::$app->controller->id;

        //判断当前控制器是在那个导航栏上面
        foreach ($models as &$value)
        {
            $action = explode("/",$value['url']);

            $value['present_action'] = false;
            if ($action[1] == $controller)
            {
                $value['present_action'] = true;
            }
        }

        return $this->render('menu/index', [
            'models'=>$models,
        ]);
    }
}