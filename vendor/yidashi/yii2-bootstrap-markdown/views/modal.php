<?php \yii\bootstrap\Modal::begin([
    'id' => 'imageModal',
    'header' => '<h3>上传图片</h3>',
    'footer' => \yii\helpers\Html::button('插入', ['class' => 'btn btn-success', 'data-dismiss' => 'modal'])
]) ?>
<?= \yidashi\webuploader\Webuploader::widget(['name' => 'markdown-image']) ?>

<?php \yii\bootstrap\Modal::end() ?>
