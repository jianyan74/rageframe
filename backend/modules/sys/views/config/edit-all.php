<?php
use yii\helpers\Url;
use yii\helpers\Html;
use \kucha\ueditor\UEditor;
use common\models\sys\Config;

$this->title = '系统配置';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-9">
            <div class="tabs-container">
                <div class="tabs-left">
                    <ul class="nav nav-tabs">
                        <?php foreach ($configCateAll as $k => $cate){ ?>
                            <li <?php if($k == 0){ ?>class="active"<?php } ?>>
                                <a aria-expanded="false" href="#tab-<?= $cate['id'] ?>" data-toggle="tab"> <?= $cate['title'] ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <?php foreach ($configCateAll as $k => $cate){ ?>
                            <div class="tab-pane <?php if($k == 0){ ?>active<?php } ?>" id="tab-<?= $cate['id'] ?>">
                                <div class="panel-body">
                                    <div class="col-sm-12">
                                        <form class="form-horizontal" method="post" action="" id="form-tab-<?= $cate['id'] ?>">
                                            <?php foreach ($cate['-'] as $item){ ?>
                                                <h2><?= $item['title']?></h2>
                                                <?php if(isset($item['config'])){ ?>
                                                    <div class="col-sm-12">
                                                        <?php foreach ($item['config'] as $row){ ?>
                                                            <?php if($row['type'] == 1){ ?>
                                                                <div class="form-group">
                                                                    <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                    <?= Html::input('text','config[' . $row['name'] . ']',$row['value'],['class' => 'form-control']);?>
                                                                </div>
                                                            <?php }elseif($row['type'] == 2){ ?>
                                                                <div class="form-group">
                                                                    <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                    <?= Html::input('password','config[' . $row['name'] . ']',$row['value'],['class' => 'form-control']);?>
                                                                </div>
                                                            <?php }elseif($row['type'] == 3){ ?>
                                                                <div class="form-group">
                                                                    <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                    <div class="input-group">
                                                                        <?= Html::input('text','config[' . $row['name'] . ']',$row['value'],['class' => 'form-control','id' => $row['id']]);?>
                                                                        <span class="input-group-btn">
                                                                            <span class="btn btn-white" onclick="createKey(<?= $row['extra']?>,<?= $row['id']?>)">生成新的</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            <?php }elseif($row['type'] == 4){ ?>
                                                                <div class="form-group">
                                                                    <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                    <?= Html::textarea('config[' . $row['name'] . ']',$row['value'],['class'=>'form-control']);?>
                                                                </div>
                                                            <?php }elseif($row['type'] == 5){
                                                                //获取数组
                                                                $option = Config::parseConfigAttr($row['extra']);
                                                                ?>
                                                                <div class="form-group">
                                                                    <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                    <?= Html::dropDownList('config[' . $row['name'] . ']',$row['value'],$option,['class'=>'form-control']);?>
                                                                </div>
                                                            <?php }elseif($row['type'] == 6){
                                                                //获取数组
                                                                $option = Config::parseConfigAttr($row['extra']);
                                                                ?>
                                                                <div class="form-group">
                                                                    <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                    <div class="col-sm-push-10">
                                                                        <?php foreach ($option as $key => $v){ ?>
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="config[<?= $row['name']?>]" class="radio" value="<?= $key?>" <?php if($key == $row['value']){ ?>checked<?php } ?>><?= $v?>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            <?php }elseif($row['type'] == 7){ ?>
                                                                <div class="form-group">
                                                                    <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                    <?= UEditor::widget([
                                                                        'id' => "config[".$row['name']."]",
                                                                        'attribute' => $row['name'],
                                                                        'name' => $row['name'],
                                                                        'value' => $row['value'],
                                                                        'clientOptions' => [
                                                                            //编辑区域大小
                                                                            'initialFrameHeight' => '200',
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
                                                            <?php }elseif($row['type'] == 8){ ?>
                                                                <div class="form-group">
                                                                    <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                    <div class="col-sm-push-10">
                                                                        <?= \backend\widgets\webuploader\Image::widget([
                                                                            'boxId' => $row['name'],
                                                                            'name'  =>"config[".$row['name']."]",
                                                                            'value' => $row['value'],
                                                                            'options' => [
                                                                                'multiple'   => false,
                                                                            ]
                                                                        ])?>
                                                                    </div>
                                                                </div>
                                                            <?php }elseif($row['type'] == 9){ ?>
                                                                <div class="form-group" style="padding-left: -15px">
                                                                    <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                    <div class="col-sm-push-10">
                                                                        <?= \backend\widgets\webuploader\Image::widget([
                                                                            'boxId' => $row['name'],
                                                                            'name'  => "config[".$row['name']."][]",
                                                                            'value' => $row['value'],
                                                                            'options' => [
                                                                                'multiple'   => true,
                                                                            ]
                                                                        ])?>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                        }
                                                        ?>
                                                    </div>
                                                <?php }
                                            } ?>
                                            <?= Html::input('hidden','_csrf',Yii::$app->request->csrfToken,['id' => '_csrf']);?>
                                            <div class="form-group">
                                                <div class="col-sm-12 text-center">
                                                    <span type="submit" class="btn btn-primary" onclick="present(<?= $cate['id'] ?>)">保存内容</span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="file-manager">
                        <h4>说明：</h4>
                        <h5>单击标题名称获取配置标识</h5>
                        <div class="hr-line-dashed"></div>
                        <h5 class="tag-title"></h5>
                        <?= Html::input('text','demo','',['class' => 'form-control','id'=>'demo','readonly' => 'readonly']);?>
                        <div class="hr-line-dashed"></div>
                        <div class="clearfix">当前显示 ： <span id="demo-title"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    //单击
    $('.demo').click(function(){
        $('#demo').val($(this).attr('for'));
        $('#demo-title').text($(this).text());
    });

    function present(obj){
        //获取表单内信息
        var values = $("#form-tab-"+obj).serialize();

        $.ajax({
            type:"post",
            url:"<?= Url::to(['update-info'])?>",
            dataType: "json",
            data: values,
            success: function(data){
                if(data.flg == 2) {
                    swalAlert(data.msg,'warning');
                }else{
                    swalAlert(data.msg);
                }
            }
        });
    }

    function createKey(num,id){
        var letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        var token = '';
        for(var i = 0; i < num; i++) {
            var j = parseInt(Math.random() * 61 + 1);
            token += letters[j];
        }
        $("#"+id).val(token);
    }
</script>