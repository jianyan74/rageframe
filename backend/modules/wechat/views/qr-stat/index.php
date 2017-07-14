<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use kartik\daterange\DateRangePicker;
use common\models\wechat\QrcodeStat;

$addon = <<< HTML
<span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
</span>
HTML;

$this->title = '扫描统计';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class=""><a href="<?= Url::to(['/wechat/qr/index'])?>"> 二维码管理</a></li>
                    <li class="active"><a href="<?= Url::to(['index'])?>"> 扫描统计</a></li>
                    <li><a href="<?= Url::to(['/wechat/qr/long-qr'])?>"> 长链接转二维码</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="panel-body">
                            <div class="ibox float-e-margins">
                                <div class="col-sm-6">
                                    <form action="" method="get" class="form-horizontal" role="form" id="form">
                                        <div class="col-sm-6">
                                            <div class="input-group drp-container">
                                                <?php echo DateRangePicker::widget([
                                                        'name'              => 'queryDate',
                                                        'readonly'          => 'readonly',
                                                        'useWithAddon'      => true,
                                                        'convertFormat'     => true,
                                                        'startAttribute'    => 'from_date',
                                                        'endAttribute'      => 'to_date',
                                                        'startInputOptions' => ['value' => $from_date ? $from_date : date('Y-m-d',strtotime("-30 day"))],
                                                        'endInputOptions'   => ['value' => $to_date ? $to_date :  date('Y-m-d')],
                                                        'pluginOptions'     => [
                                                            'locale' => ['format' => 'Y-m-d'],
                                                        ]
                                                    ]) . $addon;?>
                                            </div>
                                        </div>
                                        <div class="input-group m-b">
                                            <input type="text" class="form-control" name="keyword" value="" placeholder="<?= $keyword ? $keyword : '场景名称'?>"/>
                                            <span class="input-group-btn">
                                                    <button class="btn btn-white"><i class="fa fa-search"></i> 搜索</button>
                                                </span>
                                        </div>
                                    </form>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>粉丝</th>
                                            <th>场景名称</th>
                                            <th>场景ID/场景值</th>
                                            <th>关注扫描</th>
                                            <th>扫描时间</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($models as $model){ ?>
                                            <tr>
                                                <td><?= $model->id ?></td>
                                                <td><?= $model->fans->nickname ?></td>
                                                <td><?= $model->name ?></td>
                                                <td><?= $model->scene_id ? $model->scene_id : $model->scene_str ;?></td>
                                                <td><?= $model->type == QrcodeStat::TYPE_ATTENTION ? '关注' : '扫描' ;?></td>
                                                <td><?= Yii::$app->formatter->asDatetime($model->append) ?></td>
                                                <td>
                                                    <a href="<?= Url::to(['delete','id'=>$model->id])?>"><span class="btn btn-warning btn-sm">删除</span></a>
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
            </div>
        </div>
    </div>
</div>
