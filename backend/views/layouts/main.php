<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="/resource/backend/js/jquery-2.0.3.min.js"></script>
</head>
<body class="fixed-sidebar full-height-layout gray-bg">
<?php $this->beginBody() ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4" style="margin-top: 15px;">
        <ol class="breadcrumb">
            <?= Breadcrumbs::widget([
                'homeLink'=>[
                    'label' => Yii::$app->params['acronym'],
                    'url' => "",
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </ol>
    </div>
    <div class="col-sm-8" style="margin-top: 16px;">
        <div class="ibox-tools">
            <a href="javascript:history.go(-1)">
                <i><img src="/resource/backend/img/return.png"></i> 返回上一页
            </a>
            <a href="">
                <i class="glyphicon glyphicon-refresh"></i> 刷新
            </a>
        </div>
    </div>
</div>
<!--massage提示-->
<div style="margin:15px 15px -15px 15px">
    <?= Alert::widget() ?>
</div>
<?= $content ?>
<?php $this->endBody() ?>

<!--ajax模拟框加载-->
<div class="modal fade" id="ajaxModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="/resource/backend/img/loading.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>

<!--ajax大模拟框加载-->
<div class="modal fade" id="ajaxModalLg" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="/resource/backend/img/loading.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#ajaxModal').on('hide.bs.modal', function () {
            $(this).removeData("bs.modal");
        });
        $('#ajaxModalLg').on('hide.bs.modal', function () {
            $(this).removeData("bs.modal");
        })
    });
</script>
</body>
</html>
<?php $this->endPage() ?>
