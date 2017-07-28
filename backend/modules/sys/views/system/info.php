<?php
use yii\helpers\Url;

$this->title = '系统信息';
$this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><i class="fa fa-cog"></i>  系统信息</h5>
            </div>
            <div class="ibox-content">
                <p>Yii2版本　　　　　　　　　　　　 <?php echo Yii::getVersion(); ?></p>
                <p>PHP版本　　　　　　　　　　　　<?= phpversion(); ?></p>
                <p>Mysql版本 　　　　　　　　　　　<?= Yii::$app->db->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION); ?></p>
                <p>GD库  　　　　　　　　　　　　　<?php if(!function_exists('gd_info')){ ?>未开启<?php }else{ ?>已开启<?php } ?></p>
                <p>数据库大小　　　　　　　　　　　<?= Yii::$app->formatter->asShortSize($mysqlSize); ?></p>
                <p>运行环境　　　　　　　　　　　　<?= $_SERVER['SERVER_SOFTWARE']; ?></p>
                <p>文件上传目录　　　　　　　　　　<?= Yii::$app->request->hostInfo . Yii::getAlias('@attachurl'); ?>/</p>
                <p>文件上传限制　　　　　　　　　　<?= ini_get('upload_max_filesize'); ?></p>
                <p>超时时间　　　　　　　　　　　　<?= ini_get('max_execution_time'); ?>秒</p>
                <p>当前服务器时间　　　　　　　　　<span id="divTime"></span></p>
                <p>访问客户端信息　　　　　　　　　<?= $_SERVER['HTTP_USER_AGENT'] ?></p>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><i class="fa fa-code"></i>  开发信息</h5>
            </div>
            <div class="ibox-content">
                <p>系统名称　　　　　　　　　　　　　<?= Yii::$app->params['exploitSysName']?></p>
                <p>系统版本　　　　　　　　　　　　　<?= Yii::$app->params['exploitVersions']?></p>
                <p>官网　　　　　　　　　　　　　　　<?= Yii::$app->params['exploitOfficialWebsite']?></p>
                <p>Git@OSC　　　　　　　　　　　　&nbsp;&nbsp;<?= Yii::$app->params['exploitGit@OSC']?></p>
                <p>GitHub　　　　　　　　　　　　　　<?= Yii::$app->params['exploitGitHub']?></p>
                <p>开发者　　　　　　　　　　　　　　<?= Yii::$app->params['exploitName']?></p>
                <p>问题反馈(QQ同号)　　　　　　　　　<?= Yii::$app->params['exploitEmail']?></p>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        setTime();
        setInterval(setTime, 1000);
    });
    function setTime(){
        var d = new Date(), str = '';
        str += d.getFullYear() + ' 年 '; //获取当前年份
        str += d.getMonth() + 1 + ' 月 '; //获取当前月份（0——11）
        str += d.getDate() + ' 日  ';
        str += d.getHours() + ' 时 ';
        str += d.getMinutes() + ' 分 ';
        str += d.getSeconds() + ' 秒 ';
        $("#divTime").text(str);
    }
</script>



