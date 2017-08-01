<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use kartik\daterange\DateRangePicker;
use common\models\wechat\MsgHistory;
use common\models\wechat\Rule;

$addon = <<< HTML
<span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
</span>
HTML;

$this->title = '聊天记录';
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
                            <label class="col-xs-12 col-sm-3 col-md-3 control-label"></label>
                            <div class="col-sm-8 col-lg-9 col-xs-12">
                                <div class="btn-group">
                                    <a href="<?= Url::to(['index'])?>" class="btn <?php if(!$type){ ?>btn-primary<?php }else{ ?>btn-white<?php } ?>">全部</a>
                                    <a href="<?= Url::to(['index','type'=>1])?>" class="btn <?php if($type == 1){ ?>btn-primary<?php }else{ ?>btn-white<?php } ?>">已有规则回复</a>
                                    <a href="<?= Url::to(['index','type'=>2])?>" class="btn <?php if($type == 2){ ?>btn-primary<?php }else{ ?>btn-white<?php } ?>">默认规则回复</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">日期范围</label>
                            <div class="col-sm-6">
                                <div class="input-group drp-container">
                                    <?php echo DateRangePicker::widget([
                                            'name'              => 'queryDate',
                                            'readonly'          => 'readonly',
                                            'useWithAddon'      => true,
                                            'convertFormat'     => true,
                                            'startAttribute'    => 'from_date',
                                            'endAttribute'      => 'to_date',
                                            'startInputOptions' => ['value' => $from_date ? $from_date : date('Y-m-d',strtotime("-60 day"))],
                                            'endInputOptions'   => ['value' => $to_date ? $to_date :  date('Y-m-d')],
                                            'pluginOptions'     => [
                                                'locale' => ['format' => 'Y-m-d'],
                                            ]
                                        ]) . $addon;?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">内容关键字</label>
                            <div class="col-sm-6">
                                <div class="input-group m-b">
                                    <input type="hidden" class="form-control" name="type" value="<?= $type?>" />
                                    <input type="text" class="form-control" name="keyword" value="" placeholder="<?= $keyword?>"/>
                                    <span class="input-group-btn">
                                    <button class="btn btn-white"><i class="fa fa-search"></i> 搜索</button>
                                </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>聊天记录</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>昵称</th>
                            <th>发送类别</th>
                            <th>内容</th>
                            <th>规则</th>
                            <th>触发回复</th>
                            <th>时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($models as $model){ ?>
                            <tr>
                                <td><?= $model->id?></td>
                                <td><?= isset($model->fans->nickname) ? $model->fans->nickname : '' ?></td>
                                <td><?= $model->type?></td>
                                <td style="max-width:515px; overflow:hidden; word-break:break-all; word-wrap:break-word;"><?= MsgHistory::readMessage($model->type,$model->message)?></td>
                                <td>
                                    <?php if(!$model->rule_id){ ?>
                                        <span class="label label-default">未触发</span>
                                    <?php }else{ ?>
                                        <span class="label label-info"><?= Rule::findRuleTitle($model->rule_id)?></span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if(!$model->module){ ?>
                                        <span class="label label-default">未触发</span>
                                    <?php }else{ ?>
                                        <span class="label label-info"><?= Rule::$moduleExplain[$model->module] ?></span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?= Yii::$app->formatter->asDatetime($model->append) ?>
                                </td>
                                <td>
                                    <a href="<?= Url::to(['delete','id'=> $model->id])?>" onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
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
