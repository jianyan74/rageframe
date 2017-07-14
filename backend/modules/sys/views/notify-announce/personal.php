<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\sys\NotifyCate;

$this->title = '全部公告';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>全部公告</h5>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-12">
                            <form action="" method="get" class="form-horizontal" role="form" id="form">
                                <div class="input-group">
                                    <input placeholder="请输入公告名称" class="input-sm form-control" type="text" name="keywords" value="<?= $keywords ?>"> <span class="input-group-btn">
                             <button type="submit" class="btn btn-sm btn-primary"> 搜索</button> </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="project-list">
                        <table class="table table-hover">
                            <tbody>
                            <?php foreach($models as $model){ ?>
                                <tr>
                                    <td class="project-title">
                                        <a href="<?= Url::to(['announce-view','id'=>$model->id])?>"><?= $model->title ?></a>
                                        <br>
                                        <small><i class="fa fa-clock-o"></i> <?php echo Yii::$app->formatter->asDatetime($model->append)?></small>
                                    </td>
                                    <td class="project-status">
                                        <span class="label label-primary"><?= NotifyCate::getTitle($model->announce_type) ?></span>
                                    </td>
                                    <td class="project-completion">
                                        <small><?php echo Yii::$app->formatter->asRelativeTime($model['append'])?></small>
                                    </td>
                                    <td class="project-actions">
                                        <a href="<?= Url::to(['view','id'=>$model->id])?>" class="btn btn-white btn-sm"><i class="fa fa-eye"></i> 查看 </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
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