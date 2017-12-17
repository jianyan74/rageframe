<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package backend\assets
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        '/resource/backend/css/bootstrap.min.css?v=3.3.5',
        '/resource/backend/css/font-awesome.min.css?v=4.4.0',
        '/resource/backend/css/animate.min.css',
        '/resource/backend/css/style.css?v=4.1.0',
        '/resource/backend/css/plugins/sweetalert/sweetalert.css?v=1',// 弹出框css
        // 复选框样式
        '/resource/backend/css/plugins/iCheck/custom.css',
        '/resource/backend/css/plugins/iCheck/grey.css',
        '/resource/backend/css/base.css',
    ];

    public $js = [
        '/resource/backend/js/bootstrap.min.js?v=3.3.5',
        '/resource/backend/js/plugins/metisMenu/jquery.metisMenu.js',
        '/resource/backend/js/plugins/slimscroll/jquery.slimscroll.min.js',
        '/resource/backend/js/plugins/layer/layer.min.js',
        '/resource/backend/js/plugins/pace/pace.min.js',
        '/resource/backend/js/plugins/sweetalert/sweetalert.min.js',// 弹出框js
        '/resource/backend/js/plugins/iCheck/icheck.min.js',// 基础表单js
        '/resource/backend/js/hplus.min.js?v=4.0.0',
        '/resource/backend/js/contabs.min.js',
        '/resource/backend/js/template.js',
        '/resource/backend/js/rageframe.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'backend\assets\HeadJsAsset',
    ];
}
