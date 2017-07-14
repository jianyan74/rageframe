<?php
namespace backend\modules\sys\controllers;

use yii;
use common\models\sys\Provinces;
use yii\helpers\Html;
use backend\controllers\MController;

/**
 * 省市区联动控制器
 * Class ProvincesController
 * @package backend\modules\sys\controllers
 */
class ProvincesController extends MController
{
    /**
     * 首页
     */
    public function actionIndex($pid, $typeid = 0)
    {
        $str = "--请选择市--";

        $model = Provinces::getCityList($pid);
        if($typeid == 1 && !$pid)
        {
            return Html::tag('option','--请选择市--', ['value'=>'']) ;
        }
        else if($typeid == 2 && !$pid)
        {
            return Html::tag('option','--请选择区--', ['value'=>'']) ;
        }
        else if($typeid == 2 && $model)
        {
            $str = "--请选择区--";
        }

        echo Html::tag('option',$str, ['value'=>'']) ;
        foreach($model as $value=>$name)
        {
            echo Html::tag('option',Html::encode($name),array('value'=>$value));
        }
    }
}