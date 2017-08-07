<?php
use yii\widgets\ActiveForm;
use common\helpers\AddonsUrl;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
$this->params['breadcrumbs'][] = ['label' => '小程序管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([]); ?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-8">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="col-sm-12">
                        <h2>基本信息</h2>
                        <?= $form->field($model, 'name')->textInput() ?>
                        <?= $form->field($model, 'account')->textInput()?>
                        <?= $form->field($model, 'original')->textInput()?>
                    </div>
                    <div class="col-sm-12">
                        <h2>开发者ID</h2>
                        <?= $form->field($model, 'key')->textInput()?>
                        <?= $form->field($model, 'secret')->textInput()?>
                    </div>
                    <div class="col-sm-12">
                        <h2>消息推送</h2>
                        <div class="form-group field-account-token">
                            <label class="control-label" for="account-token">URL(服务器地址)</label>
                            <input class="form-control" value="<?= AddonsUrl::toWechat(['pages/index','account_id' => $model->id,'addon'=>$model->addon_name]) ?>" type="text" >
                            <div class="help-block"></div>
                        </div>
                        <div class="form-group field-account-token">
                            <label class="control-label" for="account-token">Token(令牌)</label>
                            <div class="input-group">
                                <input id="account-token" class="form-control" name="Account[token]" value="<?= $model->token ?>" type="text" >
                                <span class="input-group-btn">
                                    <span class="btn btn-white" onclick="createKey(32,'account-token')">生成新的</span>
                                </span>
                            </div>
                            <div class="help-block"></div>
                        </div>
                        <div class="form-group field-account-encodingaeskey">
                            <label class="control-label" for="account-encodingaeskey">Encodingaeskey(消息加解密密钥)</label>
                            <div class="input-group">
                                <input id="account-encodingaeskey" class="form-control" name="Account[encodingaeskey]" value="<?= $model->encodingaeskey ?>" type="text" >
                                <span class="input-group-btn">
                                    <span class="btn btn-white" onclick="createKey(43,'account-encodingaeskey')">生成新的</span>
                                </span>
                            </div>
                            <div class="help-block"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-primary" type="submit">保存内容</button>
                            <span class="btn btn-white" onclick="history.go(-1)">返回</span>
                        </div>　
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox float-e-margins">
                <h2>服务器配置信息</h2>
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td>request合法域名</td>
                        <td><?= Yii::$app->request->hostInfo ?></td>
                    </tr>
                    <tr>
                        <td>socket合法域名</td>
                        <td><?= $socket ?></td>
                    </tr>
                    <tr>
                        <td>uploadFile合法域名</td>
                        <td><?= Yii::$app->request->hostInfo ?></td>
                    </tr>
                    <tr>
                        <td>downloadFile合法域名</td>
                        <td><?= Yii::$app->request->hostInfo ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="ibox float-e-margins">
                <h2>版本控制</h2>
            </div>
            <div id="vertical-timeline" class="vertical-container light-timeline">
                <?php foreach ($versions as $vo){ ?>
                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon blue-bg">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <div class="vertical-timeline-content">
                            <h2><?= $vo->version ?></h2>
                            <p><?= $vo->description ?></p>
<!--                            <a href="#" class="btn btn-sm btn-success"> 下载 </a>-->
                            <span class="vertical-date">
                            <?= Yii::$app->formatter->asRelativeTime($vo['append'])?> <br>
                            <small><?= Yii::$app->formatter->asDate($vo['append']) ?></small>
                        </span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>

<script type="text/javascript">

    function createKey(num,id){
        var letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        var token = '';
        for(var i = 0; i < num; i++) {
            var j = parseInt(Math.random() * 61 + 1);
            token += letters[j];
        }
        $("#"+id).val(token);
    }
</script>
