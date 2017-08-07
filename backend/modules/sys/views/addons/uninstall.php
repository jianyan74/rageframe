<?php
use yii\helpers\Url;
use common\helpers\AddonsHelp;

$this->title = '已安装的插件';
$this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="<?= Url::to(['uninstall'])?>"> 已安装的插件</a></li>
                    <li><a href="<?= Url::to(['install'])?>"> 安装插件</a></li>
                    <li><a href="<?= Url::to(['create'])?>"> 设计新插件</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="panel-body">
                            <p><input type="text" class="form-control query" placeholder="请输入您要查找的内容..." id="all"></p>
                            <table class="table table-hover">
                                <tbody id="listAddons">
                                <?php foreach ($list as $key => $vo){ ?>
                                    <tr>
                                        <td class="feed-element" style="width: 70px;">
                                            <?php if(file_exists(AddonsHelp::getAddons($vo['name']).'icon.jpg')){ ?>
                                                <img alt="image" class="img-rounded m-t-xs img-responsive" src="<?php echo "/addons/{$vo['name']}/icon.jpg"; ?>" width="64" height="64">
                                            <?php }else{ ?>
                                                <img alt="image" class="img-rounded m-t-xs img-responsive" src="/resource/backend/img/icon.jpg" width="64" height="64">
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <h3><?php echo $vo['title'] ?> <?php if($vo['wxapp_support'] == true){ ?><span class="label label-info">小程序</span><?php } ?> <?php if($vo['type'] == 'plug'){ ?><span class="label label-info">功能插件</span><?php } ?> <?php if($vo['hook'] == 1){ ?><span class="label label-info">钩子</span><?php } ?></h3>
                                            ( 标识：<?php echo $vo['name'] ?> 版本：<?php echo $vo['version'] ?> 作者：<?php echo $vo['author'] ?> )
                                        </td>
                                        <td>
                                            <a href="<?php echo Url::to(['upgrade','name' => $vo['name']])?>"><span class="btn btn-info btn-sm">更新</span></a>&nbsp
                                            <a href="<?php echo Url::to(['uninstall','name' => $vo['name']])?>" data-method="post"><span class="btn btn-info btn-sm">卸载</span></a>&nbsp
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-12">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--列表-->
<script type="text/html" id="listModel">
    {{each list as value i}}
    <tr>
        <td class="feed-element" style="width: 70px;">
            <img alt="image" class="img-rounded m-t-xs img-responsive" src="{{value.cover}}" width="64" height="64">
        </td>
        <td>
            <h3>{{value.title}}</h3>
            ( 标识：{{value.name}} 版本：{{value.version}} 作者：{{value.author}} )
        </td>
        <td>
            <a href="{{value.upgrade}}"><span class="btn btn-info btn-sm">更新</span></a>&nbsp
            <a href="{{value.uninstall}}" data-method="post"><span class="btn btn-info btn-sm">卸载</span></a>&nbsp
        </td>
    </tr>
    {{/each}}
</script>

<script>
    $('.query').keyup(function () {
        var value = $(this).val();
        $('#listAddons').html('');
        $.ajax({
            type:"get",
            url:"<?php echo  Url::to(['index'])?>",
            dataType: "json",
            data: {keyword:value},
            success: function(data){
                if(data.flg == 1) {
                    $('#listAddons').html('');
                    var html = template('listModel', data);
                    $('#listAddons').append(html);
                }else{
                    alert(data.msg);
                }
            }
        });
    })
</script>
