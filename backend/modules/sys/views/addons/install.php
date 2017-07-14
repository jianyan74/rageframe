<?php
use yii\helpers\Url;
use common\helpers\AddonsHelp;

$this->title = '安装插件';
$this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li><a href="<?= Url::to(['uninstall'])?>"> 已安装的插件</a></li>
                    <li class="active"><a href="<?= Url::to(['install'])?>"> 安装插件</a></li>
                    <li><a href="<?= Url::to(['create'])?>"> 设计新插件</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tbody>
                                <?php foreach ($list as $key => $vo){ ?>
                                    <?php if($vo['uninstall'] == 1){ ?>
                                        <tr>
                                            <td class="feed-element" style="width: 70px;">
                                                <?php if(file_exists(AddonsHelp::getAddons($vo['name']).'icon.jpg')){ ?>
                                                    <img alt="image" class="img-rounded m-t-xs img-responsive" src="<?php echo "/addons/{$vo['name']}/icon.jpg"; ?>" width="64" height="64">
                                                <?php }else{ ?>
                                                    <img alt="image" class="img-rounded m-t-xs img-responsive" src="/resource/backend/img/icon.jpg" width="64" height="64">
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <h3><?php echo $vo['title'] ?></h3>
                                                ( 标识：<?php echo $vo['name'] ?> 版本：<?php echo $vo['version'] ?> 作者：<?php echo $vo['author'] ?> )
                                            </td>
                                            <td>
                                                <a href="<?php echo Url::to(['install','name' => $vo['name']])?>" data-method="post"><span class="btn btn-info btn-sm">安装插件</span></a>&nbsp
                                            </td>
                                        </tr>
                                    <?php } ?>
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
