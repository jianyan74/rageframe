<?php
use yii\widgets\ActiveForm;
use common\helpers\AddonsHelp;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '链接管理', 'url'=> AddonsHelp::regroupUrl(['index'])];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wrapper animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>基本信息</h5>
                </div>
                <div class="ibox-content">
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data'
                        ]
                    ]); ?>
                    <div class="col-sm-12">
                        <?= $form->field($model, 'title')->textInput() ?>
                        <?= $form->field($model, 'type')->dropDownList($linkType) ?>
                        <?= $form->field($model, 'cover')->widget('backend\widgets\webuploader\Image', [
                            'boxId' => 'cover',
                            'options' => [
                                'multiple'   => false,
                            ]
                        ])?>
                        <?= $form->field($model, 'sort')->textInput()?>
                        <?= $form->field($model, 'link')->textInput()?>
                        <?= $form->field($model, 'summary')->textarea() ?>
                        <?= $form->field($model, 'status')->radioList(['1'=>'启用','-1'=>'禁用']) ?>
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
