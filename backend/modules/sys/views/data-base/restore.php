<?php
use yii\helpers\Url;

$this->title = '数据还原';
$this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <blockquote class="text-primary" style="display: none;font-size:16px" id="reminder"></blockquote>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>备份列表</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>备份名称</th>
                            <th>卷数</th>
                            <th>压缩</th>
                            <th>数据大小</th>
                            <th>备份时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list as $key => $row){ ?>
                            <tr data-time="<?= $row['time']?>">
                                <td><?= date('Ymd-His',$row['time'])?></td>
                                <td><?= $row['part']?></td>
                                <td><?= $row['compress']?></td>
                                <td><?= Yii::$app->formatter->asShortSize($row['size'])?></td>
                                <td><?= Yii::$app->formatter->asDatetime($row['time'])?></td>
                                <td>
                                    <a href="javascript:;"><span class="btn btn-info btn-sm table-restore">还原</span></a>&nbsp
                                    <a href="<?= Url::to(['delete','time'=>$row['time']])?>" onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){

        var time;
        //优化表单击
        $(".table-restore").click(function () {

            time = $(this).parent().parent().parent().attr('data-time');

            $.ajax({
                type: "post",
                url: "<?= Url::to(['restore-init'])?>",
                dataType: 'json',
                data: {time:time},
                success: function(data) {
                    if(data.flg == 1){
                        var part    = data.part;
                        var start   = data.start;
                        startRestore(part,start);
                        $('#reminder').text('还原中,请不要关闭本页面,可能会造成服务器卡顿......');
                        $('#reminder').show();
                    }else{
                        alert(data.msg);
                    }
                }
            })

        });


        //开始备份
        function startRestore(part,start)
        {
            $.ajax({
                type: "post",
                url: "<?= Url::to(['restore-start'])?>",
                dataType: 'json',
                data: {part:part,start:start},
                success: function(data) {
                    if(data.flg == 1){

                        var achieveStatus = data.achieveStatus;

                        if(achieveStatus == 0){
                            startRestore(data.part,data.start);
                            $('#reminder').text('还原中,请不要关闭本页面,可能会造成服务器卡顿['+data.start+']......');
                            //alert(data.msg);
                        }else{
                            $('#reminder').hide();
                            alert(data.msg);
                        }
                    }else{
                        alert(data.msg);
                    }
                }
            })
        }

    })
</script>