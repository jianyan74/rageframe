<?php
use yii\widgets\ActiveForm;
use common\models\sys\Article;
use common\models\sys\Cate;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data'
            ]
        ]); ?>
        <div class="col-sm-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>文章编辑</h5>
                </div>
                <div>
                    <div class="ibox-content">
                        <div class="col-md-12">
                            <?= $form->field($model, 'title')->textInput() ?>
                            <?= $form->field($model, 'sort')->textInput()?>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'cate_stair')->dropDownList(Cate::getList(),['prompt'=>'请选择一级分类',]) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'cate_second')->dropDownList(Cate::getList($model->cate_stair), ['prompt'=>'请选择二级分类']) ?>
                                </div>
                            </div>
                            <?= $form->field($model, 'cover')->widget('backend\widgets\webuploader\Image', [
                                'boxId' => 'cover',
                                'options' => [
                                    'multiple'   => false,
                                ]
                            ])?>
                            <?= $form->field($model, 'incontent')->checkbox() ?>
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
                            <div class="form-group field-article-position">
                                <label class="control-label">推荐位</label>
                                <input type="hidden" name="Article[position]" value="">
                                <div id="article-position">
                                    <?php foreach (Yii::$app->params['recommend'] as $key => $value){ ?>
                                        <label class="checkbox-inline i-checks">
                                            <input type="checkbox" name="Article[position][]" value="<?= $key?>" <?php if(Article::checkPosition($key,$model->position)){ ?>checked<?php } ?>> <?= $value?>
                                        </label>
                                    <?php } ?>
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <?php if($tags){ ?>
                                <div class="form-group">
                                    <label class="control-label">文章标签</label>
                                    <div>
                                        <?php foreach($tags as $item){ ?>
                                            <label class="checkbox-inline i-checks">
                                                <div class="icheckbox_square-green" style="position: relative;">
                                                    <input type="checkbox" value="<?= $item['id']?>" name="tag[]" <?php if(!empty($item['tagMap'])){?>checked="checked"<?php } ?>>
                                                </div><?= $item['title']?>
                                            </label>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?= $form->field($model, 'description')->textarea()?>
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
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div>
                    <div class="ibox-content">
                        <?= $form->field($model, 'seo_key')->textInput()?>
                        <?= $form->field($model, 'seo_content')->textarea()?>
                        <?= $form->field($model, 'author')->textInput()?>
                        <?= $form->field($model, 'view')->textInput()?>
                        <?= $form->field($model, 'link')->textInput()?>
                        <?= $form->field($model, 'status')->radioList(['1'=>'启用','-1'=>'禁用']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<script>
    $("select[name='Article[cate_stair]']").change(function(){
        var pid = $(this).val();
        $.ajax({
            type:"get",
            url:"<?= \yii\helpers\Url::to(['cate/list'])?>",
            dataType: "json",
            data: {pid:pid},
            success: function(data){
                $("select[name='Article[cate_second]']").html(data);
            }
        });
    })
</script>