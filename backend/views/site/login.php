<?php
$this->title = Yii::$app->params['siteTitle'];

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
?>

<?= Html::cssFile('/resource/backend/css/font-awesome.min.css'); ?>
<?= Html::cssFile('/resource/backend/css/animate.min.css'); ?>
<?= Html::cssFile('/resource/backend/css/style.min.css'); ?>
<?= Html::cssFile('/resource/backend/css/login.min.css'); ?>

<script>
    if(window.top!==window.self){window.top.location=window.location};
</script>
<body class="signin">
<div class="signinpanel">
    <div class="row">
        <div class="col-sm-7">
            <div class="signin-info">
                <div class="logopanel m-b">
                    <h1>[ <?= Yii::$app->params['abbreviation']?> ]</h1>
                </div>
                <div class="m-b"></div>
                <h4>欢迎使用<strong><?= Yii::$app->params['siteTitle']?></strong></h4>
                <ul class="m-b">
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势一：基于Yii2框架开发的开源系统</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势二：集成微信营销管理，可直接对接微信公众号</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势三：集成用户权限管理系统</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势四：丰富的扩展机制，插件和模块可卸载安装</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势五：模块支持小程序开发</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势六：整合第三方登录和支付</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势七：RESTful API可直接对接APP开发</li>
                </ul>
            </div>
        </div>
        <div class="col-sm-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <p class="no-margins">欢迎您登录到<?= Yii::$app->params['siteTitle']?></p>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder' => '用户名','class' => 'form-control uname'])->label(false) ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => '密码','class' => 'form-control pword m-b'])->label(false) ?>

            <?php if ($model->scenario == 'captchaRequired'){ ?>
                <?= $form->field($model,'verifyCode')->widget(Captcha::className(),[
                    'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-5">{image}</div></div>',
                    'imageOptions' => [
                        'alt' => '点击换图',
                        'title' => '点击换图',
                        'style' => 'cursor:pointer'
                    ],
                    'options' => [
                        'class' => 'form-control verifyCode',
                        'placeholder' => '验证码',
                    ],
                ])->label(false)?>
            <?php } ?>

            <?php $field = $form->field($model, 'rememberMe',['labelOptions' => ['class' => 'verifyCode']])->checkbox();$field->label(); $field->error(); ?>
            <div class="form-group text-left">
                <div class="checkbox i-checks">
                    <label class="no-padding">
                        <?= $field->parts['{input}']; ?><i></i> <?=$field->parts['{labelTitle}'];?>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton('立即登录', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="signup-footer">
        <div class="pull-left">
            <?= Yii::$app->config->info('WEB_COPYRIGHT_ALL')?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".i-checks").iCheck({
            checkboxClass   :"icheckbox_square-green",
            radioClass      :"iradio_square-green",
            increaseArea    : '20%' // optional
        })
    });
</script>

