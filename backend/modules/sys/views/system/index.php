<?php
use yii\helpers\Url;

$this->title = '系统';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];

?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-content welcome-container">
            <?php foreach ($models as $vo){ ?>
            <div class="col-sm-12">
                <div class="page-header">
                    <h4><i class="fa fa-th-list"></i> <?php echo $vo['title'] ?></h4>
                </div>
                <div class="clearfix">
                    <?php foreach ($vo['-'] as $v){ ?>
                        <a href="<?php echo Url::to([$v['url']])?>" title="<?php echo $v['title'] ?>" class="tile img-rounded">
                            <i class="<?php echo $v['menu_css'] ? 'fa '.$v['menu_css'] : 'fa fa-puzzle-piece';?>"></i>
                            <span><?php echo $v['title'] ?></span>
                        </a>
                    <?php } ?>　
                </div>
            </div>
            <?php } ?>　
        </div>
    </div>
</div>
