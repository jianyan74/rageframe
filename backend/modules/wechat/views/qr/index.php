<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\wechat\Qrcode;

$this->title = '二维码管理';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="<?= Url::to(['index'])?>"> 二维码管理</a></li>
                    <li><a href="<?= Url::to(['/wechat/qr-stat/index'])?>"> 扫描统计</a></li>
                    <li><a href="<?= Url::to(['long-qr'])?>"> 长链接转二维码</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="panel-body">
                            <div class="ibox float-e-margins">
                                <div class="col-sm-3">
                                    <form action="" method="get" class="form-horizontal" role="form" id="form">
                                        <div class="input-group m-b">
                                            <input type="text" class="form-control" name="keyword" value="" placeholder="<?= $keyword ? $keyword : '场景名称'?>"/>
                                            <span class="input-group-btn">
                                                    <button class="btn btn-white"><i class="fa fa-search"></i> 搜索</button>
                                                </span>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-9">
                                    <div class="ibox-tools">
                                        <a class="btn btn-primary btn-xs" href="<?= Url::to(['add'])?>" data-toggle='modal' data-target='#ajaxModal'>
                                            <i class="fa fa-plus"></i>  创建二维码
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>二维码</th>
                                            <th>场景名称</th>
                                            <th>对应关键字</th>
                                            <th>场景ID/场景字符串</th>
                                            <th>开始时间</th>
                                            <th>结束时间</th>
                                            <th>状态</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($models as $model){ ?>
                                            <tr>
                                                <td>
                                                    <a href="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=<?= $model->ticket ?>" target="_blank">
                                                        <img src="<?= Url::to(['qr','shortUrl'=>Yii::$app->request->hostInfo])?>" alt="" width="45">
                                                    </a>
                                                </td>
                                                <td><?= $model->name ?></td>
                                                <td><?= $model->keyword ?></td>
                                                <td><?= $model->model == Qrcode::MODEL_TEM ? $model->scene_id : $model->scene_str ;?></td>
                                                <td><?= Yii::$app->formatter->asDatetime($model->append) ?></td>
                                                <td>
                                                    <?php if($model->model == Qrcode::MODEL_TEM){ ?>
                                                        <?= Yii::$app->formatter->asDatetime($model->append + $model->expire_seconds) ?>
                                                    <?php }else{ ?>
                                                        <font color="green">永不</font>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if($model->model == Qrcode::MODEL_PERPETUAL){ ?>
                                                        <span class='label label-primary'>永不</span>
                                                    <?php }else{ ?>
                                                        <?= $model->end_time < time() ? "<span class='label label-danger'>已过期</span>" : "<span class='label label-primary'>未过期</span>" ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="<?= Url::to(['down-qr','id'=>$model->id])?>"><span class="btn btn-info btn-sm">下载</span></a>&nbsp
                                                    <a href="<?= Url::to(['edit','id'=>$model->id])?>" data-toggle='modal' data-target='#ajaxModal'><span class="btn btn-info btn-sm">编辑</span></a>&nbsp
                                                    <?php if($model->model == Qrcode::MODEL_PERPETUAL){ ?>
                                                        <a href="<?= Url::to(['delete','id'=>$model->id])?>" onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="11">
                                                <a href="<?= Url::to(['delete-all'])?>"><span class="btn btn-warning btn-sm">删除过期二维码</span></a>
                                                <span style="vertical-align:super">注意：永久二维码无法在微信平台删除，但是您可以点击<a href="javascript:;" class="color-default">【删除】</a>来删除本地数据。</span>
                                            </td>
                                        </tr>
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