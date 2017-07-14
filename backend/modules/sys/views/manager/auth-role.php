<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
<?php $form = ActiveForm::begin([
    'id' => 'item_name',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['auth-role','user_id' => $model['user_id']]),
]); ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">角色分配</h4>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'item_name')->dropDownList(ArrayHelper::map($role,'name','name')) ?>
                        <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
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