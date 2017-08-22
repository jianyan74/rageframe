<?php
use yii\widgets\ActiveForm;
use common\helpers\AddonsHelp;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '投诉留言', 'url'=> AddonsHelp::regroupUrl(['index'])];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>基本信息</h5>
                </div>
                <div class="ibox-content">
                    <div class="col-sm-12">
                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                        <?= $form->field($model, 'realname')->textInput() ?>
                        <?= $form->field($model, 'mobile')->textInput()?>
                        <?= $form->field($model, 'home_phone')->textInput()?>
                        <?= $form->field($model, 'content')->textarea()?>
                        <?= $form->field($model, 'status')->radioList(['1'=>'已处理','-1'=>'未处理']) ?>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div class="form-group">　
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-primary" type="submit">保存内容</button>
                            <span class="btn btn-white" onclick="history.go(-1)">返回</span>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
