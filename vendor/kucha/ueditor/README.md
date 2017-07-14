百度UEditor
===========
[![Latest Stable Version](https://poser.pugx.org/kucha/ueditor/v/stable)](https://packagist.org/packages/kucha/ueditor) [![Total Downloads](https://poser.pugx.org/kucha/ueditor/downloads)](https://packagist.org/packages/kucha/ueditor) 
### 安装
Either run

```
$ php composer.phar require kucha/ueditor "*"
```

or add

```
"kucha/ueditor": "*"
```

to the ```require``` section of your `composer.json` file.

### 应用

controller:  

```
public function actions()
{
    return [
        'upload' => [
            'class' => 'kucha\ueditor\UEditorAction',
        ]
    ];
}
```

view:  

```
echo \kucha\ueditor\UEditor::widget([]);
```

或者：

```
echo $form->field($model,'colum')->widget('kucha\ueditor\UEditor',[]);
```
### 说明
 `ueditor`只支持2种语言，`en-us`和`zh-cn`,默认跟随系统语言 `Yii::$app->language`,可以通过2种方式设置，1.修改系统语言，在`main.php`(高级版) 或者`web.php`(基础版)添加`'language' => 'zh-CN',`。2.实例化的时候配置语言选项，见下边配置
 
### 配置相关

##### 编辑器相关配置，请在`view` 中配置，参数为`clientOptions`，比如定制菜单，编辑器大小等等，具体参数请查看[UEditor官网文档](http://fex-team.github.io/ueditor/)。

简单实例:  
```php
use \kucha\ueditor\UEditor;
echo UEditor::widget([
    'clientOptions' => [
        //编辑区域大小
        'initialFrameHeight' => '200',
        //设置语言
        'lang' =>'en', //中文为 zh-cn
        //定制菜单
        'toolbars' => [
            [
                'fullscreen', 'source', 'undo', 'redo', '|',
                'fontsize',
                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                'forecolor', 'backcolor', '|',
                'lineheight', '|',
                'indent', '|'
            ],
        ]
]);
```

##### 文件上传相关配置，请在`controller`中配置，参数为`config`,例如文件上传路径等；更多参数请参照 [config.php](https://github.com/BigKuCha/yii2-ueditor-widget/blob/master/config.php) (跟UEditor提供的config.json一样)

简单实例:  
```php
public function actions()
{
    return [
        'upload' => [
            'class' => 'kucha\ueditor\UEditorAction',
            'config' => [
                "imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
                "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                "imageRoot" => Yii::getAlias("@webroot"),
            ],
        ]
    ];
}
```
