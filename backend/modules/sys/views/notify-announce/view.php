<?php

$this->title = '详情';
$this->params['breadcrumbs'][] = ['label' => '全部公告', 'url' => ['personal']];
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="text-center article-title">
                        <h1>
                            <?= $model->title ?>
                        </h1>
                        <small>浏览量 <?= $model->view ?></small>
                        <small>    <i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asDatetime($model->append) ?></small>
                    </div>
                    <?= $model->content ?>
                    <hr>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <span class="btn btn-white" onclick="history.go(-1)">返回</span>
                        </div>
                    </div>　
                </div>
            </div>
        </div>
    </div>
</div>