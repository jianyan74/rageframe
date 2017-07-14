<?php
use yii\helpers\Url;

$this->title = '粉丝分组';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info">
                如果您的公众号类型为："认证订阅号" 或 "认证服务号",您可以使用粉丝分组功能。点击这里 <a href="<?= Url::to(['synchro'])?>">"同步粉丝分组"</a>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>粉丝分组</h5>
                </div>
                <form action="<?= Url::to(['update'])?>" method="post">
                    <div class="ibox-content">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>分组名称</th>
                                <th></th>
                                <th>分组id</th>
                                <th>分组内用户数量</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($groups as $key => $group){ ?>
                                <tr>
                                    <td class="col-md-2"><input type="text" class="form-control" value="<?= $group['name']?>" <?php if($key <= 2){ ?>readonly<?php }else{ ?>name="group_update[<?= $group['id']?>]"<?php } ?>></td>
                                    <td><?php if($key <= 2){ ?><span class='label label-danger'>系统分组,不能修改</span><?php } ?></td>
                                    <td><?= $group['id'] ?></td>
                                    <td><?= $group['count'] ?></td>
                                    <td>
                                        <?php if($key > 2){ ?>
                                            <a href="<?= Url::to(['delete','id'=> $group['id']])?>" onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr id="position">
                                <td colspan="5"><a href="javascript:;" id="addgroup"><i class="fa fa-plus-circle"></i> 添加新分组</a></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">　
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">保存内容</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#addgroup').click(function(){
        var html = '<tr>';
        html += '<td><input type="text" class="form-control" name="group_add[]" placeholder="请填写分组名称"></td>';
        html += '<td>  <a href="javascript:;" onclick="$(this).parent().parent().remove()"> <i class="fa fa-times-circle"></i></a></td>';
        html += '<td colspan="3"></td>';
        html += '</tr>';
        $('#position').before(html);
    })
</script>