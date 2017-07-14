<?php
use yii\helpers\Html;
use addons\AppManual\common\components\Parser;
$parser = new Parser;

Html::cssFile($path . 'resource/css/app-manual.css');
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
    <h4 class="modal-title"><?= $model->title ?> - 预览</h4>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="col-sm-12" style="overflow : hidden">
                    <?= $parser->makeHtml($model->content);?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
</div>