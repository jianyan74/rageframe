<?php
use yii\widgets\LinkPager;
use common\helpers\AddonsUrl;

$this->title = '内容列表';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="btn-group">
        <a class="btn <?php echo empty($cate_id) ? 'btn-primary': 'btn-white' ;?>" href="<?= AddonsUrl::to(['index'])?>">全部</a>
        <?php foreach ($cate as $key => $value){ ?>
            <a class="btn <?php echo $cate_id == $key ? 'btn-primary': 'btn-white' ;?>" href="<?= AddonsUrl::to(['index','cate_id' => $key])?>"><?= $value ?></a>
        <?php } ?>
    </div>
    <p></p>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>内容列表</h5>
                    <?php if(!empty($cate_id)){ ?>
                    <div class="ibox-tools">
                        <a class="btn btn-primary btn-xs" href="<?= AddonsUrl::to(['edit','cate_id'=>$cate_id])?>">
                            <i class="fa fa-plus"></i>  创建内容
                        </a>
                    </div>
                    <?php } ?>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>标题</th>
                            <th>排序</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($models as $model){ ?>
                            <tr id = <?= $model->id?>>
                                <td><?= $model->id?></td>
                                <td><?= $model->title?></td>
                                <td class="col-md-1"><input type="text" class="form-control" value="<?= $model['sort']?>" onblur="sort(this)"></td>
                                <td>
                                    <a href="<?= AddonsUrl::to(['edit','id'=>$model->id,'cate_id'=>$model->cate_id])?>"><span class="btn btn-info btn-sm">编辑</span></a>&nbsp
                                    <a href="<?= AddonsUrl::to(['delete','id'=>$model->id])?>" onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
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
    function sort(obj){
        var id = $(obj).parent().parent().attr('id');
        var sort = $(obj).val();

        if(isNaN(sort)){
            alert('排序只能为数字');
            return false;
        }else{
            $.ajax({
                type:"get",
                url:"<?= AddonsUrl::to(['update-ajax'])?>",
                dataType: "json",
                data: {id:id,sort:sort},
                success: function(data){

                    if(data.flg == 2) {
                        alert(data.msg);
                    }
                }
            });
        }
    }
</script>
