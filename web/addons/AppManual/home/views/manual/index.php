<?php
use yii\helpers\Html;
use common\helpers\AddonsUrl;
use addons\AppManual\common\components\Parser;

$parser = new Parser;

echo Html::cssFile($path . 'resource/css/app-manual.css');
echo Html::cssFile($path . 'resource/css/highlight/solarized-light-clone.css');
?>

<div class="span2 col-xs-12 col-sm-2 col-md-2">
    <div class="inner">
        <?php foreach ($models as $vo){ ?>
            <strong class="sidebar-title"><?= $vo['title'] ?></strong>
            <?php foreach ($vo['-'] as $v){ ?>
                <a href="<?= AddonsUrl::to(['index','name'=>$v['name']])?>" class="sidebar-link <?php if($v['name'] == $name){ ?>current<?php } ?>"><?= $v['title'] ?></a>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<div class="col-xs-12 col-sm-3 col-md-10">
    <?php if(isset($manual['content'])){ ?>
        <?= $parser->makeHtml($manual['content']);?>
    <?php } ?>
    <div class="col-sm-12 text-center">
        <hr>
        上次更新：<?php if(isset($manual['updated'])){ ?><?= Yii::$app->formatter->asDate($manual['updated'])?><?php } ?>
    </div>
</div>

<?= Html::jsFile($path . 'resource/js/highlight/highlight.min.js'); ?>
<script >hljs.initHighlightingOnLoad();</script>