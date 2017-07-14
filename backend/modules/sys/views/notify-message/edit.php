<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\sys\Manager;
use kartik\select2\Select2;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
$this->params['breadcrumbs'][] = ['label' => '系统私信', 'url' => ['index']];
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
                        <?php $form = ActiveForm::begin([]); ?>
                        <?php echo $form->field($model, 'target')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Manager::getManagers(),'id','username'),
                            'options' => ['placeholder' => '请输入用户名 ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('接收人');?>
                        <?= $form->field($model,'content')->textarea() ?>
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
