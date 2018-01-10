<?php
use jianyan\basics\backend\widgets\menu\AddonLeftWidget;

if(Yii::$app->params['addon']['info']['type'] != 'plug')
{
    $this->params['breadcrumbs'][] = ['label' =>  '扩展模块','url' => ['index']];
}

$this->params['breadcrumbs'][] = ['label' => $addonModel['title'],'url' => ['binding','addon' => $addon]];
?>

<div class="col-sm-2" style="width: 15%; height: 100%;background:#fff;">
    <?= AddonLeftWidget::widget(); ?>
</div>
<div class="col-sm-10" style="width: 85%;padding-left: 0;padding-right: 0;">
    <?= $this->render($view,$params); ?>
</div>