<?php
use yii\widgets\LinkPager;
use addons\Adv\common\models\Adv;
use addons\Adv\common\models\AdvLocation;
use common\helpers\AddonsUrl;

$this->title = '广告管理';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="btn-group">
        <a class="btn <?php echo empty($location_id) ? 'btn-primary': 'btn-white' ;?>" href="<?= AddonsUrl::to(['index'])?>">全部</a>
        <?php $AdvLocation = AdvLocation::getAdvLocationList();
        foreach ($AdvLocation as $key => $location){ ?>
            <a class="btn <?php echo $location_id == $key ? 'btn-primary': 'btn-white' ;?>" href="<?= AddonsUrl::to(['index','location_id' => $key])?>"><?= $location?></a>
        <?php } ?>
    </div>
    <p></p>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>广告管理</h5>
                    <div class="ibox-tools">
                        <a class="btn btn-primary btn-xs" href="<?= AddonsUrl::to(['edit'])?>">
                            <i class="fa fa-plus"></i>  创建广告
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>标题</th>
                            <th>广告位置</th>
                            <th>排序</th>
                            <th>有效期</th>
                            <th>当前状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($models as $model){ ?>
                            <tr id = <?= $model->id?>>
                                <td><?= $model->id?></td>
                                <td><a href="<?= $model->jump_link?>"  target="_blank"><?= $model->title?></a></td>
                                <td><span class="badge badge-info"><?= AdvLocation::getTitle($model->location_id)?></span></td>
                                <td class="col-md-1"><input type="text" class="form-control" value="<?= $model['sort']?>" onblur="sort(this)"></td>
                                <td>
                                    开始:<?= Yii::$app->formatter->asDatetime($model->start_time)?><br>
                                    结束:<?= Yii::$app->formatter->asDatetime($model->end_time)?>
                                </td>
                                <td>
                                    <?= Adv::getTimeStatus($model->start_time,$model->end_time)?>
                                </td>
                                <td>
                                    <a href="<?= AddonsUrl::to(['edit','id'=>$model->id])?>"><span class="btn btn-info btn-sm">编辑</span></a>&nbsp
                                    <?php echo $model['status'] == -1 ? '<span class="btn btn-primary btn-sm" onclick="status(this)">启用</span>': '<span class="btn btn-default btn-sm"  onclick="status(this)">禁用</span>' ;?>
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
            url:"<?= AddonsUrl::to(['update-ajax'])?>",
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
