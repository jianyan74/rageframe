<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @package yii2-widgets
 * @subpackage yii2-widget-colorinput
 * @version 1.0.3
 */

namespace kartik\color;

/**
 * Asset bundle for ColorInput Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ColorInputAsset extends \kartik\base\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/spectrum', 'css/spectrum-kv']);
        $this->setupAssets('js', ['js/spectrum', 'js/spectrum-kv']);
        parent::init();
    }
}
