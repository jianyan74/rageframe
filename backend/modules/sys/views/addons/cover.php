<?php
use yii\helpers\Url;
use common\helpers\AddonsUrl;

$this->title = $model['title'];
$this->params['breadcrumbs'][] = ['label' =>  '扩展模块','url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>  $model['addon']['title'],'url' => ['binding','addon' => $model['addon']['name']]];
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="panel-body">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="menu-title">微信入口直接链接</label>
                                    <input class="form-control" type="text" value="<?= AddonsUrl::toWechat([$model['route'],'addon'=>$model['addon']['name']]) ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="menu-title">二维码</label><br>
                                        <div class="row" style="padding-left: 15px">
                                            <img src="<?= Url::to(['qr','shortUrl'=> AddonsUrl::toWechat([$model['route'],'addon'=>$model['addon']['name']])])?>" style="border:1px solid #CCC;border-radius:4px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="menu-title">前台入口直接链接</label>
                                    <input class="form-control" type="text" value="<?= AddonsUrl::toFront([$model['route'],'addon'=>$model['addon']['name']]); ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="menu-title">二维码</label><br>
                                        <div class="row" style="padding-left: 15px">
                                            <img src="<?= Url::to(['qr','shortUrl'=> AddonsUrl::toFront([$model['route'],'addon'=>$model['addon']['name']])])?>" style="border:1px solid #CCC;border-radius:4px;">
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
