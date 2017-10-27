<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class HeadJsAsset
 * @package backend\assets
 */
class HeadJsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        '/resource/backend/js/jquery-2.0.3.min.js',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}
