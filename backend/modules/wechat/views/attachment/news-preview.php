<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<?php $form = ActiveForm::begin([]); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
    <h4 class="modal-title">图文手机预览</h4>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="col-sm-12">
                    <?= $form->field($model, 'type')->radioList(['1' => '微信号','2' => '粉丝标识(openid)']) ?>
                    <?= $form->field($model, 'content')->textInput() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
    <button class="btn btn-primary" type="submit">立即发送</button>
</div>
<?php ActiveForm::end(); ?>
