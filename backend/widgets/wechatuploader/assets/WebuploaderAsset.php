<?php

namespace backend\widgets\wechatuploader\assets;

use yii\web\AssetBundle;

class WebuploaderAsset extends AssetBundle {

    public $sourcePath = '@backend/widgets/wechatuploader/statics/wechatuploader/';

    public $css = [
        'webuploader.css',
    ];

    public $js = [
        'webuploader.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}