<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;

$this->title = '微信图文';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<?= Html::cssFile('/resource/backend/css/common.css')?>
<?= Html::jsFile('/resource/backend/js/plugins/layer/layer.min.js')?>

<style>
    .postToolbar{
        font-size: 15px;
    }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row separateFromNextBlock">
        <div class="col-sm-12">
            <div class="btn-group">
                <?php foreach ($wechatMediaType as $key => $mo){ ?>
                    <a class="btn <?php echo $mediaType == $key ? 'btn-primary': 'btn-white' ;?>" href="<?= Url::to([$key.'-index'])?>"><?= $mo ?></a>
                <?php } ?>
            </div>
            <div class="ibox-tools">
                <a class="btn btn-primary btn-xs" id="getAllAttachment">
                    <i class="fa fa-cloud-download"></i>  同步图文
                </a>
                <a id="createPostBtn" class="btn btn-primary btn-xs">
                    <i class="fa fa-plus"></i>  创建图文
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="inlineBlockContainer col5 vAlignTop separateChildren">
                <?php foreach ($attachment as $item){ ?>
                    <div class="normalPaddingRight">
                        <div class="borderColorGray separateChildrenWithLine whiteBG" style="margin-bottom: 30px;">
                            <?php foreach ($item['news'] as $index => $news){ ?>
                                <div class="normalPadding relativePosition postItem">
                                    <?php if($index == 0){ ?>
                                        <div style="background-image: url(<?= Url::to(['we-code/image','attach'=>$news['thumb_url']]) ?>); height: 160px" class="backgroundCover relativePosition mainPostCover">
                                            <div class="bottomBar"><?= $news['title'] ?></div>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="flex-row">
                                            <div class="flex-col normalPadding"><?= $news['title'] ?></div>
                                            <div style="background-image: url(<?= Url::to(['we-code/image','attach'=>$news['thumb_url']]) ?>);" class="backgroundCover subPostCover"></div>
                                        </div>
                                    <?php } ?>
                                    <div class="halfOpacityBlackBG absoluteFullSize" style="display: none;">
                                        <?php if($item['link_type'] == 1){ ?>
                                            <?php if($index == 0){ ?>
                                                <a class="fontColorWhite" href="<?= $news['url'] ?>" target="_blank" style="left:25%;top: 50%;position: absolute;">文章预览</a>
                                                <a class="fontColorWhite" href="<?= Url::to(['news-preview','attach_id' => $item['id']])?>"  data-toggle='modal' data-target='#ajaxModal' style="right:25%;top: 50%;position: absolute;">手机预览</a>
                                            <?php }else{ ?>
                                                <a class="absoluteCenter fontColorWhite" href="<?= $news['url'] ?>" target="_blank">文章预览</a>
                                            <?php } ?>
                                        <?php }else{ ?>
                                            <a class="absoluteCenter fontColorWhite" href="<?= $news['url'] ?>" target="_blank">本地预览 <i class="fa fa-question-circle" title="本地文章,不可以群发"></i></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="flex-row hAlignCenter normalPadding postToolbar">
                                <?php if($item['link_type'] == 1){ ?>
                                    <div class="flex-col"><a href="<?= Url::to(['mass-record/send-fans','attach_id'=> $item['id']])?>"  title="群发" data-toggle='modal' data-target='#ajaxModal'><i class="fa fa-send"></i></a></div>
                                    <div class="flex-col"><a href="<?= Url::to(['news-edit','attach_id'=> $item['id']])?>" title="编辑"><i class="fa fa-edit"></i></a></div>
                                <?php }else{ ?>
                                    <div class="flex-col"><a href="<?= Url::to(['news-link-edit','attach_id'=> $item['id']])?>" title="编辑"><i class="fa fa-edit"></i></a></div>
                                <?php } ?>
                                <div class="flex-col"><a href="<?= Url::to(['delete','attach_id'=> $item['id']])?>" onclick="deleted(this);return false;" title="删除"><i class="fa fa-trash"></i></a></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        //显示/隐藏“预览文章”按钮
        $('.postItem').mouseenter(function(e){
            $(e.currentTarget).find('.halfOpacityBlackBG').show();
        });
        $('.postItem').mouseleave(function(e){
            $(e.currentTarget).find('.halfOpacityBlackBG').hide();
        });

        //弹出框选择新建图文类型
        var postType1Link = "<?php echo Url::to(['news-edit','model'=>'perm'])?>";
        var postType2Link = "<?php echo Url::to(['news-link-edit','model'=>'perm'])?>";
        $('#createPostBtn').click(function(){
            layer.open({
                type: 1,
                title: '新建图文消息',
                area: ['500px', '340px'],
                shadeClose: true,
                content: '<div class="farPadding separateChildren further">' +
                '<a class="farPadding borderColorGray displayAsBlock" href="' + postType1Link + '">' +
                '<div class="fontSizeL">创建微信图文</div>' +
                '<div class="fontColorGray">微信图文消息会自动同步至微信素材库，并可以直接群发给粉丝</div>' +
                '</a>' +
                '<a class="farPadding borderColorGray displayAsBlock" href="' + postType2Link + '">' +
                '<div class="fontSizeL">创建图文连接</div>' +
                '<div class="fontColorGray">点击图文直接跳转至指定链接，可用于自动回复及认证号菜单配置，不能同步至微信素材库。</div>' +
                '</a>' +
                '</div>'
            });
        });
        //
    })
</script>

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
