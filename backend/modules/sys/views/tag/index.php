<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '标签管理';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>标签管理</h5>
                    <div class="ibox-tools">
                        <a class="btn btn-primary btn-xs" href="<?= Url::to(['edit'])?>">
                            <i class="fa fa-plus"></i>  创建标签
                        </a>
                    </div>
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
                                    <a href="<?= Url::to(['edit','id'=>$model->id])?>"><span class="btn btn-info btn-sm">编辑</span></a>&nbsp
                                    <?php echo $model['status'] == -1 ? '<span class="btn btn-primary btn-sm" onclick="status(this)">启用</span>': '<span class="btn btn-default btn-sm"  onclick="status(this)">禁用</span>' ;?>
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
    //status => 1:启用;-1禁用;
    function status(obj){
        var status = "";
        var id = $(obj).parent().parent().attr('id');
        var self = $(obj);

        if(self.hasClass("btn-primary")){
            status = 1;
        } else {
            status = -1;
        }

        $.ajax({
            type:"get",
            url:"<?= Url::to(['update-ajax'])?>",
            dataType: "json",
            data: {id:id,status:status},
            success: function(data){
                if(data.flg == 1) {
                    if(self.hasClass("btn-primary")){
                        self.removeClass("btn-primary").addClass("btn-default");
                        self.text('禁用');
                    } else {
                        self.removeClass("btn-default").addClass("btn-primary");
                        self.text('启用');
                    }
                }else{
                    alert(data.msg);
                }
            }
        });
    }

    function sort(obj){
        var id = $(obj).parent().parent().attr('id');
        var sort = $(obj).val();

        if(isNaN(sort)){
            alert('排序只能为数字');
            return false;
        }else{
            $.ajax({
                type:"get",
                url:"<?= Url::to(['update-ajax'])?>",
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
