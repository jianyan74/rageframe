<?php
/**
 *
 * hbshop
 *
 * @package   MultiImageAsset
 * @copyright Copyright (c) 2010-2016, HuiBer
 * @link      http://huiber.cn
 * @author    Alex Liu<lxiangcn@gmail.com>
 */
namespace backend\widgets\webuploader\assets;

use yii\web\AssetBundle;

/**
 * @author Shiyang <dr@shiyang.me>
 */
class ImageAsset extends AssetBundle {

    public $sourcePath = '@backend/widgets/webuploader/statics/';

    public $css = [
        'css/image.css',
        'fancybox/jquery.fancybox.min.css',// 弹出图片css
    ];

    public $js = [
        'js/uploader.js',
        'fancybox/jquery.fancybox.min.js',// 图片弹出js
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}