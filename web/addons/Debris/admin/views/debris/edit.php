<?php
use yii\widgets\ActiveForm;
use common\helpers\AddonsHelp;
use addons\Debris\common\models\Debris;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' =>  '碎片首页','url' => AddonsHelp::regroupUrl(['index'])];
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
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
                        <?= $form->field($model, 'name')->textInput() ?>
                        <?= $form->field($model, 'type')->radioList(Debris::$type,['onchange'  => 'display()']) ?>
                        <div style="display:<?php echo $model->type == Debris::TYPE_CHARACTER ? 'block' : 'none' ?>;" id="type_<?php echo Debris::TYPE_CHARACTER ?>" class="vessel">
                            <?= $form->field($model, 'character')->textarea()?>
                        </div>
                        <div style="display:<?php echo $model->type == Debris::TYPE_COVER ? 'block' : 'none' ?>;" id="type_<?php echo Debris::TYPE_COVER?>" class="vessel">
                            <?= $form->field($model, 'cover')->widget('backend\widgets\webuploader\Image', [
                                'boxId' => 'cover',
                                'options' => [
                                    'multiple'   => false,
                                ]
                            ])?>
                        </div>
                        <div style="display:<?php echo $model->type == Debris::TYPE_CONTENT ? 'block' : 'none' ?>;" id="type_<?php echo Debris::TYPE_CONTENT?>" class="vessel">
                            <?= $form->field($model,'content')->widget('kucha\ueditor\UEditor',[
                                'clientOptions' => [
                                    //编辑区域大小
                                    'initialFrameHeight' => '300',
                                    //定制菜单
                                    'toolbars' => [
                                        [
                                            'fullscreen', 'source', '|', 'undo', 'redo', '|',
                                            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                                            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                                            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                                            'directionalityltr', 'directionalityrtl', 'indent', '|',
                                            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                                            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                                            'simpleupload', 'insertimage', 'emotion', 'insertvideo', 'music', 'attachment', 'map', 'insertframe', 'insertcode', 'pagebreak', 'template', 'background', '|',
                                            'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
                                            'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                                            'searchreplace', 'help', 'drafts'
                                        ],
                                    ],
                                ]
                            ]);?>
                        </div>
                        <?= $form->field($model, 'link')->textInput() ?>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 col-sm-offset-2">
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

<script>
    function display(){
        var val=$('input:radio[name="Debris[type]"]:checked').val();
        $(".vessel").hide();
        $('#type_'+val).show();
    }
</script>
