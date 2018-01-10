<?php
namespace backend\widgets\webuploader;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;
use backend\widgets\webuploader\assets\FileAsset;
use backend\widgets\webuploader\assets\WebuploaderAsset;

/**
 * 多文件上传
 *
 * Class File
 * @package backend\widgets\webuploader
 */
class File extends InputWidget
{
    /**
     * 基础属性
     * @var array
     */
    public $options = [];

    /**
     * 更多属性
     * @var array
     */
    public $pluginOptions = [];

    /**
     * 盒子ID
     * @var
     */
    public $boxId;

    /**
     * 默认名称
     * @var string
     */
    public $name = 'fileinput';

    /**
     * @var string
     */
    public $value = '';

    /**
     * 隐藏按钮
     */
    protected $hiddenInput;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $_options = [
            'multiple'   => true,
            'mimeTypes'  => '*',
            'extensions' => null,
        ];

        $_pluginOptions = [
            'uploadUrl'        => !empty(Yii::$app->params['uploadDefaultFileUrl']) ? Yii::$app->params['uploadDefaultFileUrl'] :  Url::to(['/file/upload-files']),
            'uploadMaxSize'    => Yii::$app->params['filesUpload']['maxSize'],
        ];

        $this->options = ArrayHelper::merge($_options, $this->options);
        $this->pluginOptions = ArrayHelper::merge($_pluginOptions, $this->pluginOptions);
        $this->options['uploadType'] = 'filesUpload';

        if ($this->hasModel())
        {
            $this->hiddenInput = Html::activeHiddenInput($this->model, $this->attribute);
        }
        else
        {
            $this->hiddenInput = Html::hiddenInput($this->name, $this->value);
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->registerClientScript();
        $attribute = str_replace("[]","",$this->attribute);
        $value = trim($this->hasModel() ? Html::getAttributeValue($this->model, $attribute) : $this->value);

        $name = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->name;
        $config = [
            'boxId' => $this->boxId,
            'name' => $name,
            'filesize' => $this->pluginOptions['uploadMaxSize'],
            'server' => $this->pluginOptions['uploadUrl'],
            'mimeTypes' => $this->options['mimeTypes'],
            'multiple'  => $this->options['multiple'],
            'extensions' => $this->options['extensions'],
            'uploadType' => $this->options['uploadType'],
        ];

        return $this->render('file', [
            'name' => $name,
            'value' => $this->options['multiple'] == true ? unserialize($value) : $value,
            'options' => $this->options,
            'boxId' => $this->boxId,
            'hiddenInput' => $this->hiddenInput,
            'config'=> json_encode($config),
        ]);
    }

    /**
     * 注册资源
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        WebuploaderAsset::register($view);
        FileAsset::register($view);
    }
}