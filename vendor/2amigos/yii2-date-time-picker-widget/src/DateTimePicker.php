<?php
/**
 * @copyright Copyright (c) 2013-2017 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\datetimepicker;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * DateTimePicker renders a DateTimePicker input.
 * @see http://www.malot.fr/bootstrap-datetimepicker/
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package common\extensions\widgets\datetimepicker
 */
class DateTimePicker extends InputWidget
{
    /**
     * @var string the language to use
     */
    public $language;
    /**
     * @var array the options for the Bootstrap DatePicker plugin.
     * Please refer to the Bootstrap DatePicker plugin Web page for possible options.
     * @see http://bootstrap-datepicker.readthedocs.org/en/release/options.html
     */
    public $clientOptions = [];
    /**
     * @var array the event handlers for the underlying Bootstrap Switch 3 input JS plugin.
     * Please refer to the [DatePicker](http://bootstrap-datepicker.readthedocs.org/en/release/events.html) plugin
     * Web page for possible events.
     */
    public $clientEvents = [];
    /**
     * @var string the size of the input ('lg', 'md', 'sm', 'xs')
     */
    public $size;
    /**
     * @var array HTML attributes to render on the container if its used as a component.
     */
    public $containerOptions = [];
    /**
     * @var string the template to render the input. By default, renders as a component, you can render a simple
     * input field without pickup and/or reset buttons by modifying the template to `{input}`. `{button}` must exist for
     * a component type of datepicker. The following template is invalid `{input}{reset}` and will be treated as `{input}`
     */
    public $template = "{input}{reset}{button}";
    /**
     * @var string the icon to use on the reset button
     */
    public $resetButtonIcon = 'glyphicon glyphicon-remove';
    /**
     * @var string the icon to use on the pickup button. Defaults to `glyphicon-th`. Other uses are `glyphicon-time` and
     * `glyphicon-calendar`.
     */
    public $pickButtonIcon = 'glyphicon glyphicon-th';
    /**
     * @var bool whether to render the input as an inline calendar
     */
    public $inline = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->containerOptions, 'input-group date');
        Html::addCssClass($this->options, 'form-control');
        $this->options['readonly'] = 'readonly';
        if ($this->size !== null) {
            $size = 'input-' . $this->size;
            Html::addCssClass($this->options, $size);
            Html::addCssClass($this->containerOptions, $size);
        }
        if ($this->inline) {
            $this->clientOptions['linkField'] = $this->options['id'];
            Html::removeCssClass($this->containerOptions, 'date');
            Html::removeCssClass($this->containerOptions, 'input-group');
            Html::addCssClass($this->options, 'text-center');
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {

        $input = $this->hasModel()
            ? Html::activeTextInput($this->model, $this->attribute, $this->options)
            : Html::textInput($this->name, $this->value, $this->options);

        if (!$this->inline) {
            $resetIcon = Html::tag('span', '', ['class' => $this->resetButtonIcon]);
            $pickIcon = Html::tag('span', '', ['class' => $this->pickButtonIcon]);
            $resetAddon = Html::tag('span', $resetIcon, ['class' => 'input-group-addon']);
            $pickerAddon = Html::tag('span', $pickIcon, ['class' => 'input-group-addon']);
        } else {
            $resetAddon = $pickerAddon = '';
        }

        if (strpos($this->template, '{button}') !== false || $this->inline) {
            $input = Html::tag(
                'div',
                strtr($this->template, ['{input}' => $input, '{reset}' => $resetAddon, '{button}' => $pickerAddon]),
                $this->containerOptions
            );
        }
        echo $input;
        $this->registerClientScript();
    }

    /**
     * Registers required script for the plugin to work as a DateTimePicker
     */
    public function registerClientScript()
    {
        $js = [];
        $view = $this->getView();

        // @codeCoverageIgnoreStart
        if ($this->language !== null) {
            $this->clientOptions['language'] = $this->language;
            DateTimePickerAsset::register(
                $view
            )->js[] = 'js/locales/bootstrap-datetimepicker.' . $this->language . '.js';
        } else {
            DateTimePickerAsset::register($view);
        }
        // @codeCoverageIgnoreEnd

        $id = $this->options['id'];
        $selector = ";jQuery('#$id')";

        if (strpos($this->template, '{button}') !== false || $this->inline) {
            $selector .= ".parent()";
        }

        $options = !empty($this->clientOptions) ? Json::encode($this->clientOptions) : '';

        $js[] = "$selector.datetimepicker($options);";

        if ($this->inline) {
            $js[] = "$selector.find('.datetimepicker-inline').addClass('center-block');";
            $js[] = "$selector.find('table.table-condensed').attr('align','center').css('margin','auto');";
        }

        // @codeCoverageIgnoreStart
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "$selector.on('$event', $handler);";
            }
        }
        // @codeCoverageIgnoreEnd

        $view->registerJs(implode("\n", $js));
    }
}
