<?php
use yii\helpers\Url;

$this->title = '数据备份';
$this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <p>
        <a class="btn btn-primary table-list-database" href="javascript:;" data-type="1">
            立即备份
        </a>
        <a class="btn btn-primary table-list-database" href="javascript:;" data-type="2">
            修复表
        </a>
        <a class="btn btn-primary table-list-database" href="javascript:;" data-type="3">
            优化表
        </a>
    <p>
    <blockquote class="text-primary" style="display: none;font-size:16px" id="reminder"></blockquote>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>数据备份</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th><input type="checkbox" checked="checked" class="check-all"></th>
                            <th>数据表名</th>
                            <th>类型</th>
                            <th>记录总数</th>
                            <th>数据大小</th>
                            <th>编码</th>
                            <th>表说明</th>
                            <th>创建时间</th>
                            <th>备份状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="list">
                        <?php foreach($models as $model){ ?>
                            <tr name = "<?= $model['name']?>">
                                <td><input type="checkbox" name="table[]" checked="checked" value="<?= $model['name']?>"></td>
                                <td><?= $model['name']?></td>
                                <td><?= $model['engine']?></td>
                                <td><?= $model['rows']?></td>
                                <td><?= Yii::$app->formatter->asShortSize($model['data_length'])?></td>
                                <td><?= $model['collation']?></td>
                                <td><?= $model['comment']?></td>
                                <td><?= $model['create_time']?></td>
                                <td id="<?= $model['name']?>">未备份</td>
                                <td>
                                    <a href="#" class="table-list-optimize">优化表</a>
                                    <a href="#" class="table-list-repair">修复表</a>
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

        var tablename = [];
        //dataType = 1:备份;2:修复;3:优化
        $(".table-list-database").click(function () {
            tablename = [];
            $("#list :checkbox").each(function () {
                if(this.checked){
                    var table = $(this).val();
                    tablename.push(table);
                }
            });
            var dataType = $(this).attr('data-type');

            if(dataType == 1){
                $('#reminder').text('备份中,请不要关闭本页面......');
                Export();
            }else if(dataType == 2){
                $('#reminder').text('修复中,请不要关闭本页面......');
                repair();
            }else if(dataType == 3){
                $('#reminder').text('优化中,请不要关闭本页面......');
                optimize();
            }
            $('#reminder').show();
        });

        //优化表单击
        $(".table-list-optimize").click(function () {
            tablename = $(this).parent().parent().attr('name');

            $('#reminder').text('优化中,请不要关闭本页面......');
            $('#reminder').show();
            optimize();
        });

        //修复表表单击
        $(".table-list-repair").click(function () {
            tablename = $(this).parent().parent().attr('name');
            repair();
        });

        //备份表
        function Export(){

            tablename = [];
            $("#list :checkbox").each(function () {
                if(this.checked){
                    var table = $(this).val();
                    tablename.push(table);
                }
            });

            $.ajax({
                type: "post",
                url: "<?= Url::to(['export'])?>",
                dataType: 'json',
                data: {tables:tablename},
                success: function(data) {
                    if(data.flg == 1){
                        var id    = data.tab.id;
                        var start = data.tab.start;
                        startExport(id,start);
                    }else{
                        swalAlert(data.msg);
                    }
                }
            })
        }

        //开始备份
        function startExport(id,start)
        {
            $.ajax({
                type: "post",
                url: "<?= Url::to(['export-start'])?>",
                dataType: 'json',
                data: {id:id,start:start},
                success: function(data) {
                    if(data.flg == 1){

                        var achieveStatus = data.achieveStatus;
                        var tabName = data.tablename;
                        $("#"+tabName).text(data.msg);

                        if(achieveStatus == 0){
                            startExport(data.tab.id,data.tab.start);
                        }else{
                            $('#reminder').hide();
                            swalAlert(data.msg);
                        }

                    }else{
                        swalAlert(data.msg);
                    }
                }
            })
        }

        //优化表
        function optimize() {

            $.ajax({
                type: "post",
                url: "<?= Url::to(['optimize'])?>",
                dataType: 'json',
                data: {tables:tablename},
                success: function(data) {
                    $('#reminder').hide();
                    swalAlert(data.msg);
                }
            })
        }

        //修复表
        function repair() {
            $.ajax({
                type: "post",
                url: "<?= Url::to(['repair'])?>",
                dataType: 'json',
                data: {tables:tablename},
                success: function(data) {
                    $('#reminder').hide();
                    swalAlert(data.msg);
                }
            })
        }

        //多选框选择
        $(".check-all").click(function(){
            if(this.checked){
                $("#list :checkbox").prop("checked", true);
            }else{
                $("#list :checkbox").attr("checked", false);
            }
        });

    })
</script>
