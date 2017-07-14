<?php
use yii\helpers\Url;
use common\helpers\AddonsUrl;
use common\models\sys\Addons;
use common\models\sys\AddonsBinding;

if(Yii::$app->params['addon']['info']['type'] != 'plug')
{
    $this->params['breadcrumbs'][] = ['label' =>  '扩展模块','url' => ['index']];
}

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-content welcome-container">
            <?php if($model->setting  == Addons::SETTING_TRUE || !empty($list[AddonsBinding::ENTRY_COVER])){ ?>
                <div class="col-sm-12">
                    <div class="page-header">
                        <h3><i class="fa fa-plane"></i> 核心功能设置</h3>
                    </div>
                    <div class="shortcut clearfix">
                        <?php foreach ($list[AddonsBinding::ENTRY_COVER] as $vo){ ?>
                            <a href="<?php echo Url::to(['cover','id' => $vo['id']])?>" title="<?php echo $vo['title'] ?>">
                                <i class="<?php echo $vo['icon'] ? $vo['icon'] : 'fa fa-external-link-square';?>"></i>
                                <span><?php echo $vo['title'] ?></span>
                            </a>
                        <?php } ?>
                        <?php if($model->setting == Addons::SETTING_TRUE){ ?>
                            <a href="<?php echo AddonsUrl::toRoot(['setting/display'])?>" title="参数设置">
                                <i class="fa fa-cog"></i>
                                <span>参数设置</span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <div class="col-sm-12">
                <div class="page-header">
                    <h3><i class="fa fa-plane"></i> 业务功能菜单</h3>
                </div>
                <div class="shortcut clearfix">
                    <?php foreach ($list[AddonsBinding::ENTRY_MENU] as $vo){ ?>
                        <a href="<?php echo AddonsUrl::to([$vo['route']])?>" title="<?php echo $vo['title'] ?>">
                            <i class="<?php echo $vo['icon'] ? $vo['icon'] : 'fa fa-puzzle-piece';?>"></i>
                            <span><?php echo $vo['title'] ?></span>
                        </a>
                    <?php } ?>
                </div>
            </div>　
        </div>
    </div>
</div>