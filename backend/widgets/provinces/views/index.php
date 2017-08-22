<?php
use yii\helpers\Html;
use jianyan\basics\common\models\sys\Provinces;

?>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($model,$provincesName)->dropDownList(Provinces::getCityList(),
            [
                'prompt'    =>'--请选择省--',
                'onchange'  =>'widget_provinces(this,1,"'.Html::getInputId($model,$cityName).'","'.Html::getInputId($model,$areaName).'")',
            ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, $cityName)->dropDownList(Provinces::getCityList($model->$provincesName),
            [
                'prompt'    =>'--请选择市--',
                'onchange'  =>'widget_provinces(this,2,"'.Html::getInputId($model,$areaName).'","'.Html::getInputId($model,$areaName).'")',
            ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, $areaName)->dropDownList(Provinces::getCityList($model->$cityName),[
                'prompt'=>'--请选择区--',
            ]) ?>
    </div>
</div>

<script>
    function widget_provinces(obj,type_id,cityId,areaId) {
        $(".form-group.field-"+areaId).hide();
        var pid = $(obj).val();
        $.ajax({
            type     :"get",
            url      : "<?= Yii::$app->urlManager->createUrl('sys/provinces/index'); ?>",
            dataType : "json",
            data     : {type_id:type_id,pid:pid},
            success: function(data){
                if(type_id == 2){
                    $(".form-group.field-"+areaId).show();
                }

                $("select#"+cityId+"").html(data);
            }
        });
    }
</script>