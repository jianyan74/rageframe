<?php

namespace frontend\widgets;

use yii;
use yii\base\Widget;
use backend\models\DeskMenu;

class MenuWidget extends Widget
{
    public function run()
    {
        $models = DeskMenu::find()
            ->where(['status' => DeskMenu::STATUS_ON])
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

?>