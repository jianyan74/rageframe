<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\sys\Notify;
use common\models\sys\NotifyCate;

$this->title = '公告管理';
$this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="<?= Url::to(['notify-announce/index'])?>"> 公告管理</a></li>
                    <li><a href="<?= Url::to(['notify-cate/index'])?>"> 公告分类</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="panel-body">
                            <div class="ibox float-e-margins">
                                <div class="ibox-tools">
                                    <a class="btn btn-primary btn-xs" href="<?= Url::to(['edit'])?>">
                                        <i class="fa fa-plus"></i>  创建公告
                                    </a>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>标题</th>
                                            <th>分类</th>
                                            <th>发送人</th>
                                            <th>浏览量</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($models as $model){ ?>
                                            <tr id = <?= $model->id ?>>
                                                <td><?= $model->id ?></td>
                                                <td><?= $model->title ?></td>
                                                <td><?= NotifyCate::getTitle($model->announce_type) ?></td>
                                                <td><?= $model->manager->username ?></td>
                                                <td><?= $model->view?></td>
                                                <td>
                                                    <a href="<?= Url::to(['edit','id'=>$model->id])?>"><span class="btn btn-info btn-sm">编辑</span></a>&nbsp
                                                    <a href="<?= Url::to(['delete','id'=>$model->id,'type' => Notify::TYPE_ANNOUNCE])?>" onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
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