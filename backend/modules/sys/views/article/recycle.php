<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use common\models\sys\Cate;
use common\models\sys\Article;

$this->title = '回收站';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>查询</h5>
                </div>
                <div class="ibox-content">
                    <form action="" method="get" class="form-horizontal" role="form" id="form">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 control-label">关键字</label>
                            <div class="col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="keyword" value="" placeholder="<?= $keyword ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 control-label">文章分类</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
                                <div class="row row-fix tpl-category-container">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <?= Html::dropDownList('cate_stair',$cate_stair,Cate::getList(),['class' => 'form-control tpl-category-parent','prompt' =>'请选择一级分类']); ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <?= Html::dropDownList('cate_second',$cate_second,Cate::getList($cate_stair),['class' => 'form-control tpl-category-parent','prompt' =>'请选择二级分类']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="pull-right col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                <input type="hidden" class="form-control" name="type" value="<?= $type?>" />
                                <button class="btn btn-white"><i class="fa fa-search"></i> 搜索</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <p>
                <a href="<?= Url::to(['delete-all'])?>"><span class="btn btn-info btn-sm">一键清空</span></a>&nbsp
            </p>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>回收站</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>文章标题</th>
                            <th>作者</th>
                            <th>浏览量</th>
                            <th>推荐位</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($models as $model){ ?>
                            <tr id = <?= $model->id ?>>
                                <td><?= $model->id ?></td>
                                <td><?= $model->title ?></td>
                                <td><?= $model->author ?></td>
                                <td><?= $model->view ?></td>
                                <td>
                                    <?php foreach (Yii::$app->params['recommend'] as $key => $value){ ?>
                                        <?php if(Article::checkPosition($key,$model->position)){ ?><span class="label label-info"><?= $value ?></span><?php } ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="<?= Url::to(['show','id'=>$model->id])?>"><span class="btn btn-info btn-sm">还原</span></a>&nbsp
                                    <a href="<?= Url::to(['delete','id'=>$model->id])?>" onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= LinkPager::widget([
                                'pagination'        => $pages,
                                'maxButtonCount'    => 5,
                                'firstPageLabel'    => "首页",
                                'lastPageLabel'     => "尾页",
                                'nextPageLabel'     => "下一页",
                                'prevPageLabel'     => "上一页",
                            ]);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("select[name='cate_stair']").change(function(){
        var pid = $(this).val();
        $.ajax({
            type:"get",
            url:"<?= Url::to(['cate/list'])?>",
            dataType: "json",
            data: {pid:pid},
            success: function(data){
                $("select[name='cate_second']").html(data);
            }
        });
    })
</script>
