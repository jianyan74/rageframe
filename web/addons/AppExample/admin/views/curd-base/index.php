<?php
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use common\helpers\AddonsUrl;

$this->title = '基本表格';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>基本表格</h5>
                    <div class="ibox-tools">
                        <a class="btn btn-primary btn-xs" href="<?= AddonsUrl::to(['edit'])?>">
                            <i class="fa fa-plus"></i>  创建
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>标题</th>
                            <th>简单介绍</th>
                            <th>排序</th>
                            <th>开始结束时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($models as $model){ ?>
                            <tr id = <?= $model->id; ?>>
                                <td><?= $model->id; ?></td>
                                <td><?= $model->title; ?></td>
                                <td><?= $model->description; ?></td>
                                <td class="col-md-1"><input type="text" class="form-control" value="<?= $model['sort']?>" onblur="sort(this)"></td>
                                <td>
                                    开始：<?= Yii::$app->formatter->asDatetime($model->stat_time); ?> <br>
                                    结束：<?= Yii::$app->formatter->asDatetime($model->end_time); ?>
                                </td>
                                <td>
                                    <a href="<?= AddonsUrl::to(['edit','id' => $model->id])?>"><span class="btn btn-info btn-sm">编辑</span></a>&nbsp
                                    <?php echo $model['status'] == -1 ? '<span class="btn btn-primary btn-sm" onclick="status(this)">启用</span>': '<span class="btn btn-default btn-sm"  onclick="status(this)">禁用</span>' ;?>
                                    <a href="<?= AddonsUrl::to(['delete','id'=> $model->id])?>" onclick="rfDelete(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
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
        var id = $(obj).parent().parent().attr('id');
        var status; self = $(obj);
        if(self.hasClass("btn-primary")){
            status = 1;
        } else {
            status = -1;
        }

        $.ajax({
            type:"get",
            url:"<?= AddonsUrl::to(['ajax-update'])?>",
            dataType: "json",
            data: {id:id,status:status},
            success: function(data){
                if(data.code == 200) {
                    if(self.hasClass("btn-primary")){
                        self.removeClass("btn-primary").addClass("btn-default");
                        self.text('禁用');
                    } else {
                        self.removeClass("btn-default").addClass("btn-primary");
                        self.text('启用');
                    }
                }else{
                    rfAffirm(data.message);
                }
            }
        });
    }

    function sort(obj){
        var id = $(obj).parent().parent().attr('id');
        var sort = $(obj).val();
        if(isNaN(sort)){
            rfAffirm('排序只能为数字');
            return false;
        }else{
            $.ajax({
                type:"get",
                url:"<?= AddonsUrl::to(['ajax-update'])?>",
                dataType: "json",
                data: {id:id,sort:sort},
                success: function(data){
                    if(data.code != 200) {
                        rfAffirm(data.message);
                    }
                }
            });
        }
    }
</script>
