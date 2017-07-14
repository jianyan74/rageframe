<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = '参数设置';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data'
            ]
        ]); ?>
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>参数设置</h5>
                </div>
                <div>
                    <div class="ibox-content">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= Html::label('文档名称','',['class' => 'control-label']);?>
                                <?= Html::input('text','config[site_title]',isset($config['site_title']) ? $config['site_title'] : '',['class' => 'form-control']);?>
                            </div>
                            <div class="hr-line-dashed"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-primary" type="submit">保存内容</button>
                                <span class="btn btn-white" onclick="history.go(-1)">返回</span>
                            </div>
                        </div>　
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
