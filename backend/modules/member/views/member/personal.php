<?php
use yii\widgets\ActiveForm;
use backend\models\Provinces;

$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '信息编辑'];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>基本信息</h5>
                </div>
                <div class="ibox-content">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="col-sm-12">
                        <?= $form->field($model, 'realname')->textInput() ?>
                        <?= $form->field($model, 'mobile_phone')->textInput() ?>
                        <?= $form->field($model, 'email')->textInput() ?>
                        <?= $form->field($model,'birthday')->widget('kartik\date\DatePicker',[
                            'language'  => 'zh-CN',
                            'layout'=>'{picker}{input}',
                            'pluginOptions' => [
                                'format'         => 'yyyy-mm-dd',
                                'todayHighlight' => true,//今日高亮
                                'autoclose'      => true,//选择后自动关闭
                                'todayBtn'       => true,//今日按钮显示
                            ],
                            'options'=>[
                                'class'     => 'form-control no_bor',
                                'readonly'  => 'readonly',//禁止输入
                            ]
                        ]); ?>
                        <?= $form->field($model, 'sex')->radioList(['0'=>'男','1'=>'女']) ?>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-center">
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
