<?php
use yii\widgets\ActiveForm;
use common\helpers\AddonsHelp;
use yidashi\markdown\Markdown;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '文档管理', 'url' => AddonsHelp::regroupUrl(['index'])];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox-title">
                    <h5>上级目录:<?= $parent_title?></h5>
                </div>
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <?php $form = ActiveForm::begin(); ?>
                        <div class="col-sm-12">
                            <?= $form->field($model, 'title')->textInput() ?>
                            <?php if($model->pid > 0){ ?>
                                <?= $form->field($model, 'name')->textInput() ?>
                            <?php } ?>
                            <?= $form->field($model, 'sort')->textInput() ?>
                            <?php if($model->pid > 0){ ?>
                                <?= $form->field($model,'content')->widget(Markdown::className(),[
                                    'language' => 'zh',
                                    'useUploadImage' => true,
                                ]); ?>
                            <?php } ?>
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

<?php \yii\bootstrap\Modal::begin([
    'id' => 'imageModal',
    'header' => '<h3>上传图片</h3>',
    'footer' => \yii\helpers\Html::button('插入', ['class' => 'btn btn-success', 'data-dismiss' => 'modal'])
]) ?>

<?= \backend\widgets\webuploader\Image::widget([
    'boxId' => 'markdown',
    'name'  =>"markdown-image",
    'options' => [
        'multiple'   => false,
    ]
])?>
<?php \yii\bootstrap\Modal::end() ?>