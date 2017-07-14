<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:15
 */
namespace yidashi\markdown;

use yii;
use yii\helpers\Html;

class Markdown extends yii\widgets\InputWidget{

    public $language = 'zh';

    public $useUploadImage = false;

    public function init(){
        $this->options['data-provide']='markdown-textarea';
        parent::init();
    }
    public function run(){
        MarkdownAsset::register($this->view)->js[] = 'js/locale/bootstrap-markdown.' . $this->language . '.js';
        $options = [
            'autofocus' => false,
            'language' => $this->language,
            'footer' => "本站编辑器使用了 GFM (GitHub Flavored Markdown) 语法，关于此语法的说明，请 <a href=\"https://help.github.com/articles/github-flavored-markdown\" target=\"_blank\">点击此处</a> 获得更多帮助。"
        ];
        $clientOptions = yii\helpers\Json::htmlEncode($options);
        if (!$this->useUploadImage) {
            $js = "$(\"[data-provide=markdown-textarea]\").markdown($clientOptions)";
        } else {
            $js = <<<JS
$("[data-provide=markdown-textarea]").markdown({
    autofocus:false,
    language:'{$this->language}',
    footer:"本站编辑器使用了 GFM (GitHub Flavored Markdown) 语法，关于此语法的说明，请 <a href=\"https://help.github.com/articles/github-flavored-markdown\" target=\"_blank\">点击此处</a> 获得更多帮助。",
    buttons: [
        [{},{
            name: "groupLink",
            data: [{},{
                name: "cmdImage",
                callback: function(e) {
                    $('#imageModal').modal();
                    var chunk, cursor, selected = e.getSelection(), content = e.getContent(), link;
                    $('#imageModal .btn-success').on('click', function(){
                        link = $('#imageModal img').attr('src');
                        chunk = '图片描述';
                        var images = '';
                        if(link !== null && link !== '' && link !== 'http://') {
                            var sanitizedLink = $('<div>'+link+'</div>').text();
                            images = '!['+chunk+']('+sanitizedLink+' "'+chunk+'")\\n\\n';
                        }
                        e.replaceSelection(images);
                        cursor = selected.start+2;
                        e.setSelection(cursor,cursor+chunk.length);
                        $(this).off('click');
                    })
                }
            }]
        }]
    ],
});
JS;
        }
        $this->view->registerJs($js);
        $html = '';
        if($this->hasModel()){
            $html = Html::activeTextarea($this->model,$this->attribute,$this->options);
        }else{
            $html = Html::textarea($this->name,$this->value,$this->options);
        }
        if ($this->useUploadImage) {
            $html .= $this->render('modal');
        }
        return $html;
    }
}