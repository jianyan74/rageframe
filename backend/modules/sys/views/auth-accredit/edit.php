<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['edit','name' => $model['name']]),
]); ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">上级目录:<?= $parent_name?></h4>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'description')->textInput() ?>
                        <?= $form->field($model, 'name')->textInput()->hint('例如 main/index') ?>
                        <?= $form->field($model, 'sort')->textInput() ?>
                        <?= $form->field($model, 'parent_key')->hiddenInput(['value'=>$parent_key])->label(false) ?>
                        <?= $form->field($model, 'type')->hiddenInput(['value'=>backend\modules\sys\models\AuthItem::AUTH])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
        <button class="btn btn-primary" type="submit">保存内容</button>
    </div>
<?php ActiveForm::end(); ?>