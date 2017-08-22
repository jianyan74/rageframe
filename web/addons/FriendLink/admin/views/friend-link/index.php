<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use addons\FriendLink\common\models\FriendLink;
use common\helpers\AddonsUrl;

$this->title = '链接管理';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group">
                <a class="btn <?php echo empty($type) ? 'btn-primary': 'btn-white' ;?>" href="<?= AddonsUrl::to(['index'])?>">全部</a>
                <?php foreach ($linkType as $key => $title){ ?>
                    <a class="btn <?php echo $type == $key ? 'btn-primary': 'btn-white' ;?>" href="<?= AddonsUrl::to(['index','type' => $key])?>"><?= $title?></a>
                <?php } ?>
            </div>
            <p></p>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>友情链接</h5>
                    <div class="ibox-tools">
                        <a class="btn btn-primary btn-xs" href="<?= AddonsUrl::to(['edit'])?>">
                            <i class="fa fa-plus"></i>  创建链接
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>标题</th>
                            <th>类型</th>
                            <th>排序</th>
                            <th>说明</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($models as $model){ ?>
                            <tr id = <?= $model->id?>>
                                <td><?= $model->id?></td>
                                <td><a href="<?= $model->link?>"  target="_blank"><?= $model->title?></a></td>
                                <td><?= $linkType[$model->type] ?></td>
                                <td class="col-md-1"><input type="text" class="form-control" value="<?= $model['sort']?>" onblur="sort(this)"></td>
                                <td><?= $model->summary?></td>
                                <td>
                                    <a href="<?= AddonsUrl::to(['edit','id'=>$model->id])?>"><span class="btn btn-info btn-sm">编辑</span></a>&nbsp
                                    <?= Html::tag('span', FriendLink::$statuses[$model->status], [
                                        'class' => 'btn btn-' . ($model->status == FriendLink::STATUS_ON ? 'default' : 'primary') .' btn-sm',
                                        'onclick' => "status(this)"
                                    ]);?>
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
