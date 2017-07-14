<?php
$this->title = '首页';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content">
    <div class="row">
        <?= backend\widgets\baseinfo\InfoWidget::widget() ?>
    </div>
</div>

