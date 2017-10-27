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
class FileAsset extends AssetBundle {

    public $sourcePath = '@backend/widgets/webuploader/statics/';

    public $css = [
        'css/file.css',
    ];

    public $js = [
        'js/uploader.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}