<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;

$this->title = '图片';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<?= Html::cssFile('/resource/backend/css/common.css')?>

<style>
    .postToolbar{
        font-size: 15px;
    }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group">
                <?php foreach ($wechatMediaType as $key => $mo){ ?>
                    <a class="btn <?php echo $mediaType == $key ? 'btn-primary': 'btn-white' ;?>" href="<?= Url::to([$key.'-index'])?>"><?= $mo ?></a>
                <?php } ?>
            </div>
            <div class="ibox-tools">
                <a class="btn btn-primary btn-xs" id="getAllAttachment">
                    <i class="fa fa-cloud-download"></i>  同步图片
                </a>
                <a class="btn btn-primary btn-xs" href="<?php echo Url::to(['image-add','model'=>'perm'])?>"  data-toggle='modal' data-target='#ajaxModal'>
                    <i class="fa fa-plus"></i>  创建图片
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="inlineBlockContainer col3 vAlignTop">
                <?php foreach ($models as $model){ ?>
                    <div class="normalPaddingRight" style="width:20%;margin-top: 10px;">
                        <div class="borderColorGray separateChildrenWithLine whiteBG" style="margin-bottom: 30px;">
                            <div class="normalPadding">
                                <div style="background-image: url(<?= Url::to(['we-code/image','attach'=>$model['tag']]) ?>); height: 160px" class="backgroundCover relativePosition mainPostCover">
                                    <div class="bottomBar"><?= $model['file_name'] ?></div>
                                </div>
                            </div>
                            <div class="flex-row hAlignCenter normalPadding postToolbar">
                                <div class="flex-col"><a href="<?= Url::to(['mass-record/send-fans','attach_id'=> $model['id']])?>"  title="群发" data-toggle='modal' data-target='#ajaxModal'><i class="fa fa-send"></i></a></div>
                                <div class="flex-col"><a href="<?= Url::to(['delete','attach_id'=> $model['id']])?>" onclick="deleted(this);return false;" title="删除"><i class="fa fa-trash"></i></a></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= LinkPager::widget([
                'pagination'        => $pages,
                'maxButtonCount'    => 5,
                'firstPageLabel'    => "首页",
                'lastPageLabel'     => "尾页",
                'nextPageLabel'     => "下一页",
                'prevPageLabel'     => "上一页",
            ]);?>
        </div>
    </div>
</div>

<script>
    //获取资源
    $("#getAllAttachment").click(function(){
        swalAlert('同步中,请不要关闭当前页面');
        sync();
    });

    //同步粉丝资料
    function sync(offset=0,count=20){
        $.ajax({
            type:"get",
            url:"<?= Url::to(['get-all-attachment','type' => $mediaType])?>",
            dataType: "json",
            data: {offset:offset,count:count},
            success: function(data){
                if(data.flg == 1) {
                    sync(data.offset,data.count);
                }else{
                    swalAlert(data.msg);
                    window.location.reload();
                }
            }
        });
    }
</script>