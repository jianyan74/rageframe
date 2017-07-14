<?php

if(Yii::$app->params['addon']['info']['type'] != 'plug')
{
    $this->params['breadcrumbs'][] = ['label' =>  '扩展模块','url' => ['index']];
}

$this->params['breadcrumbs'][] = ['label' => $addonModel['title'],'url' => ['binding','addon' => $addon]];
echo $this->render($view,$params);