<?php
use yii\widgets\ActiveForm;
use common\models\sys\ConfigCate;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
$this->params['breadcrumbs'][] = ['label' => '配置管理', 'url' => ['index']];
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
                    <?php $form = ActiveForm::begin([]); ?>
                    <div class="col-sm-12">
                        <?= $form->field($model, 'name')->textInput() ?>
                        <?= $form->field($model, 'title')->textInput() ?>
                        <?= $form->field($model, 'sort')->textInput()?>
                        <?= $form->field($model, 'type')->dropDownList($configTypeList)?>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'cate')->dropDownList(ConfigCate::getChildList(),['prompt'=>'请选择分类',]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'cate_child')->dropDownList(ConfigCate::getChildList($model->cate), ['prompt'=>'请选择具体分类']) ?>
                            </div>
                        </div>
                        <?= $form->field($model, 'extra')->textarea()->hint('如果是枚举型 需要配置该项')?>
                        <?= $form->field($model, 'remark')->textarea()?>
                        <?= $form->field($model, 'is_hide_remark')->checkbox() ?>
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
<script>
    $("select[name='Config[cate]']").change(function(){
        var pid = $(this).val();
        $.ajax({
            type:"get",
            url:"<?= \yii\helpers\Url::to(['config-cate/list'])?>",
            dataType: "json",
            data: {pid:pid},
            success: function(data){
                $("#config-cate_child").html(data);
            }
        });
    })
</script>
