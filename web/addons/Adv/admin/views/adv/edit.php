<?php
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;
use addons\Adv\common\models\AdvLocation;
use common\helpers\AddonsHelp;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '广告管理', 'url'=> AddonsHelp::regroupUrl(['index'])];
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
                        <?php $form = ActiveForm::begin([
                            'options' => [
                                'enctype' => 'multipart/form-data'
                            ]
                        ]); ?>
                        <?= $form->field($model, 'title')->textInput() ?>
                        <?= $form->field($model, 'location_id')->dropDownList(AdvLocation::getAdvLocationList()) ?>
                        <?= $form->field($model, 'cover')->widget('backend\widgets\webuploader\Image', [
                            'boxId' => 'cover',
                            'options' => [
                                'multiple'   => false,
                            ]
                        ])?>
                        <?= $form->field($model, 'sort')->textInput()?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($model, 'start_time')->widget(DateTimePicker::className(), [
                                    'language' => 'zh-CN',
                                    'template' => '{button}{reset}{input}',
                                    'options'   => [
                                        'value'     => $model->isNewRecord ? '' : date('Y-m-d H:i:s',$model->start_time),
                                    ],
                                    'clientOptions' => [
                                        'format'         => 'yyyy-mm-dd hh:ii:ss',
                                        'todayHighlight' => true,//今日高亮
                                        'autoclose'      => true,//选择后自动关闭
                                        'todayBtn'       => true,//今日按钮显示
                                    ]

                                ]);?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'end_time')->widget(DateTimePicker::className(), [
                                    'language' => 'zh-CN',
                                    'template' => '{button}{reset}{input}',
                                    'options'  => [
                                        'value'     => $model->isNewRecord ? '' : date('Y-m-d H:i:s',$model->end_time),
                                    ],
                                    'clientOptions' => [
                                        'format'         => 'yyyy-mm-dd hh:ii:ss',
                                        'todayHighlight' => true,//今日高亮
                                        'autoclose'      => true,//选择后自动关闭
                                        'todayBtn'       => true,//今日按钮显示
                                    ]
                                ]);?>
                            </div>
                        </div>
                        <?= $form->field($model, 'jump_link')->textInput()?>
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

