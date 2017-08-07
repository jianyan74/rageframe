<?php
use yii\widgets\ActiveForm;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
$this->params['breadcrumbs'][] = ['label' => '小程序管理', 'url' => ['index']];
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
                        <?php $form = ActiveForm::begin([]); ?>
                        <?= $form->field($model, 'name')->textInput() ?>
                        <?= $form->field($versions, 'description')->textInput()?>
                        <?= $form->field($model, 'account')->textInput()?>
                        <?= $form->field($model, 'original')->textInput()?>
                        <?= $form->field($model, 'key')->textInput()?>
                        <?= $form->field($model, 'secret')->textInput()?>
                        <?= $form->field($versions, 'version')->textInput()->hint('版本号只能是字母/数字。例如：v1.2.1') ?>
                        <?= $form->field($model, 'addon_name')->dropDownList($addon_names) ?>
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
