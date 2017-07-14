<?php
use yii\helpers\Url;
use common\helpers\AddonsHelp;

$this->title = '扩展模块';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="col-sm-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"><i class="fa fa-cubes"></i>全部模块</a></li>
                <?php foreach ($addonsType as $key => $v){ ?>
                    <li class=""><a data-toggle="tab" href="#tab-<?php echo $key?>" aria-expanded="false"><?php echo $v?></a></li>
                <?php } ?>
            </ul>
            <div class="tab-content  welcome-container">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <p><input type="text" class="form-control query" placeholder="请输入您要查找的内容..." id="all"></p>
                        <div class="shortcut clearfix">
                            <?php foreach ($models as $vo){ ?>
                                <a href="<?php echo Url::to(['binding','addon' => $vo['name']])?>">
                                    <?php if(file_exists(AddonsHelp::getAddons($vo['name']).'icon.jpg')){ ?>
                                        <img alt="image" class="img-rounded m-t-xs img-responsive" src="<?php echo "/addons/{$vo['name']}/icon.jpg"; ?>" title="<?php echo $vo['name'] ?>">
                                    <?php }else{ ?>
                                        <img alt="image" class="img-rounded m-t-xs img-responsive" src="/resource/backend/img/icon.jpg">
                                    <?php } ?>
                                    <span><?php echo $vo['title'] ?></span>
                                </a>
                            <?php } ?>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                </div>
                <?php foreach ($list as $key => $row){ ?>
                    <div id="tab-<?php echo $key?>" class="tab-pane">
                        <div class="panel-body">
                            <p><input type="text" class="form-control query" placeholder="请输入您要查找的内容..." id="<?php echo $key?>"></p>
                            <div class="shortcut clearfix">
                                <?php foreach ($row['list'] as $vo){ ?>
                                    <a href="<?php echo Url::to(['binding','addon' => $vo['name']])?>">
                                        <?php if(file_exists(AddonsHelp::getAddons($vo['name']).'icon.jpg')){ ?>
                                            <img alt="image" class="img-rounded m-t-xs img-responsive" src="<?php echo "/addons/{$vo['name']}/icon.jpg"; ?>" title="<?php echo $vo['name'] ?>">
                                        <?php }else{ ?>
                                            <img alt="image" class="img-rounded m-t-xs img-responsive" src="/resource/backend/img/icon.jpg">
                                        <?php } ?>
                                        <span><?php echo $vo['title'] ?></span>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="hr-line-dashed"></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!--列表-->
<script type="text/html" id="listModel">
    {{each list as value i}}
    <a href="{{value.link}}">
        <img alt="image" class="img-rounded m-t-xs img-responsive" src="{{value.cover}}">
        <span>{{value.title}}</span>
    </a>
    {{/each}}
</script>

<script>
    $('.query').keyup(function () {
        var value = $(this).val();
        var type = $(this).attr('id');

        $('#'+type).parent().parent().find('.shortcut').html('');

        var addonsName = type;
        if(type == 'all'){
            addonsName = '';
        }

        $.ajax({
            type:"get",
            url:"<?php echo  Url::to(['index'])?>",
            dataType: "json",
            data: {keyword:value,type:addonsName},
            success: function(data){
                if(data.flg == 1) {
                    $('#'+type).parent().parent().find('.shortcut').html('');
                    var html = template('listModel', data);
                    $('#'+type).parent().parent().find('.shortcut').append(html);
                }else{
                    alert(data.msg);
                }
            }
        });
    })
</script>
