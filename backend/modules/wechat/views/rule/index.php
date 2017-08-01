<?php
use yii\helpers\Url;
use common\models\wechat\Rule;
use common\models\wechat\RuleKeyword;
use yii\widgets\LinkPager;

$this->title = '自动回复';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="<?= Url::to(['rule/index'])?>"> 关键字自动回复</a></li>
                    <li><a href="<?= Url::to(['setting/special-message'])?>"> 非文字消息回复</a></li>
                    <li><a href="<?= Url::to(['reply-default/index'])?>"> 关注/默认回复</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="panel-body">
                            <div class="ibox float-e-margins">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <form action="" method="get" class="form-horizontal" role="form" id="form">
                                            <div class="input-group m-b">
                                                <input type="text" class="form-control" name="keyword" value="" placeholder="<?= $keyword ? $keyword : '请输入规则名称'?>"/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-white"><i class="fa fa-search"></i> 搜索</button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="ibox-tools">
                                            <div class="input-group m-b">
                                                <div class="input-group-btn">
                                                    <button tabindex="-1" class="btn btn-white" type="button">添加回复</button>
                                                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button"><span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php foreach ($modules as $key => $mo){ ?>
                                                            <li><a href="<?= Url::to(['reply-'.$key.'/edit'])?>"><?= $mo?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div class="btn-group">
                                        <a class="btn <?= !$module ? 'btn-primary': 'btn-white' ;?>" href="<?= Url::to(['index'])?>">全部</a>
                                        <?php foreach ($modules as $key => $mo){ ?>
                                            <a class="btn <?php echo $module == $key ? 'btn-primary': 'btn-white' ;?>" href="<?= Url::to(['index','module'=>$key])?>"><?= $mo?></a>
                                        <?php } ?>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <?php foreach($models as $model){ ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <span class="collapsed"><?= $model->name ?></span>
                                                <span class="pull-right" id="<?= $model->id ?>">
                                                   <?php if(RuleKeyword::verifyTake($model->ruleKeyword)){ ?>
                                                       <?php if($model->status == Rule::STATUS_ON){ ?>
                                                           <span class="label label-info">直接接管</span>
                                                       <?php } ?>
                                                   <?php } ?>
                                                    <?php if($model->status == Rule::STATUS_OFF){ ?>
                                                        <span class="label label-danger" onclick="status(this)">已禁用</span>
                                                    <?php }else{ ?>
                                                        <span class="label label-info" onclick="status(this)">已启用</span>
                                                    <?php } ?>
                                                </span>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true" style="">
                                                <div class="panel-body">
                                                    <?php if($model->ruleKeyword){ ?>
                                                        <?php foreach($model->ruleKeyword as $rule){
                                                            if($rule->type != RuleKeyword::TYPE_TAKE){ ?>
                                                                <span class="label label-default"><?= $rule->content?></span>
                                                            <?php }
                                                        }
                                                    } ?>
                                                </div>
                                            </div>
                                            <div class="panel-footer clearfix">
                                                <div class="btn-group pull-right">
                                                    <a class="btn btn-white btn-sm" href="<?= Url::to(['reply-'.$model->module.'/edit','id'=>$model->id])?>"><i class="fa fa-edit"></i> 编辑</a>
                                                    <a class="btn btn-white btn-sm" href="<?= Url::to(['delete','id'=>$model->id])?>" onclick="deleted(this);return false;"><i class="fa fa-times"></i> 删除</a>
                                                    <a class="btn btn-white btn-sm" href="#"><i class="fa fa-bar-chart-o"></i> 使用率走势</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= LinkPager::widget([
                                                'pagination' => $pages,
                                                'maxButtonCount' => 5,
                                                'firstPageLabel' => "首页",
                                                'lastPageLabel' => "尾页",
                                                'nextPageLabel' => "下一页",
                                                'prevPageLabel' => "上一页",
                                            ]);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

        var id = $(obj).parent().attr('id');
        var self = $(obj);
        var status = self.hasClass("label-danger") ? 1 : -1;

        $.ajax({
            type:"get",
            url:"<?= Url::to(['update-ajax'])?>",
            dataType: "json",
            data: {id:id,status:status},
            success: function(data){
                if(data.flg == 1) {
                    if(self.hasClass("label-danger")){
                        self.removeClass("label-danger").addClass("label-info");
                        self.text('已启用');
                    } else {
                        self.removeClass("label-info").addClass("label-danger");
                        self.text('已禁用');
                    }
                }else{
                    alert(data.msg);
                }
            }
        });
    }
</script>