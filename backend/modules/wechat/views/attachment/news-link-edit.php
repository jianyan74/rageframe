<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use \kucha\ueditor\UEditor;

$this->title = $attachment->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '微信图文', 'url' => ['news-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Html::cssFile('/resource/backend/css/common.css')?>
<?=Html::jsFile('/resource/backend/js/vue.min.js')?>

<style>
    .leftArea{
        width: 180px; box-sizing: content-box;
    }
    .postList > *{
        height: 140px;
    }
    .addPostBtn{
        background-color: transparent;
        text-align: center;
        line-height: 140px;
    }
    .addPostBtn:before{
        content: '+';
        font-size: 45px;
        font-weight: bold;
    }
    .uploaderPlaceHolder{
        display: inline-block;
        width: 160px; height: 160px;
        line-height: 160px; text-align: center;
        background-color: #eee;
    }
    .postItem{
        border: 4px inset transparent;
    }
    .postItem.active{
        border: 2px solid #1ab394 !important;
    }
    .subPostCover{
        position: absolute; right: 10px; bottom: 10px;
    }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12" id="vueArea">
            <div class="ibox-title">
                <h5>回复内容</h5>
            </div>
            <div class="ibox-content overflowHidden">
                <div class="col-sm-12 noHorizontalPadding"><div class="flex-row">
                        <div class="leftArea farPaddingJustH">
                            <div class="separateFromNextBlock">图文列表</div>
                            <div class="postList borderColorGray separateChildrenWithLine">
                                <!-- 文章列表 -->
                                <div class="normalPadding postItem" v-for="(item, index) in postList" :class="{active:crtPost === item}" @click="crtPost = item">
                                    <!-- 头条文章 -->
                                    <div v-if="index == 0" class="mainPostCover fullHeight relativePosition backgroundCover" :style="{backgroundImage:'url(' + item.thumb_url + ')'}">
                                        <div class="bottomBar">{{item.title}}</div>
                                    </div>
                                    <!-- 次条文章 -->
                                    <div v-else class="relativePosition fullHeight">
                                        <div>{{item.title}}</div>
                                        <div class="subPostCover backgroundCover" :style="{backgroundImage:'url(' + item.thumb_url + ')'}">
                                        </div>
                                        <div class="bottomBar flex-row flex-hAlignBalance" v-show="item === crtPost">
                                            <div class="separateInlineChildren">
                                                <a @click="moveForward(index)"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                                                <a v-show="index < postList.length - 1" @click="moveBackward(index)"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                                            </div>
                                            <div v-show="!isEditMode"><a @click="removePost(index)"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="addPostBtn" v-show="postList.length < postMaximum && !isEditMode" @click="addPost"></div>
                            </div>
                        </div>
                        <div class="flex-col borderColorGray">
                            <div class="flex-row">
                                <div class="borderRightColorGray flex-col">
                                    <div><input class="appInput largeSize fullWidth borderBottomColorGray" placeholder="请输入标题" v-model="crtPost.title"></div>
                                    <div><input class="appInput fullWidth borderBottomColorGray" placeholder="请输入连接地址" v-model="crtPost.content_source_url"></div>
                                </div>
                                <div style="width:200px;">
                                    <div class="borderBottomColorGray farPadding">
                                        <div class="separateFromNextBlockFar">发布样式编辑</div>
                                        <div class="separateFromNextBlock">
                                            <div>封面<span class="fontColorGray">(小图片建议尺寸：200像素x200像素)</span></div>
                                            <div @click="uploadNewthumb_url" class="cursorPointer">
                                                <div class="uploaderPlaceHolder borderColorGray fontSizeL" v-if="!crtPost.thumb_url">点击上传图片</div>
                                                <img :src="crtPost.thumb_url" style="max-width:100%;" v-else/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="borderBottomColorGray farPadding">
                                        <div class="separateFromNextBlock">摘要<span class="fontColorGray">(选填，如果不填写会默认抓取正文前54个字)</span></div>
                                        <textarea class="appTextarea fullWidth" rows="4" v-model="crtPost.digest"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group normalPadding">
                        <div class="hAlignCenter">
                            <a class="btn btn-primary" @click="submitForm">保存内容</a>
                            <a class="btn btn-white" onclick="history.go(-1)">返回</a>
                        </div>
                    </div>
                </div></div>
        </div>
        <!-- 上传组件不需要显示出来，我只需要使用它的功能即可 -->
        <div hidden>
            <?= \backend\widgets\wechatuploader\Image::widget([
                'boxId' => 'thumb_url',
                'name'  =>"thumb_url",
                'value' =>  '',
                'options' => [
                    'multiple'   => false,
                ],
                'pluginOptions' => [
                    'uploadMaxSize' => 1024,
                ]
            ])?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    function DataPost(){
        this.title = '';
        this.thumb_url = '';
        this.digest = '';
        this.content_source_url = '';
    }

    $(function(){
        var ue, thumb_urlImagePreview = $('.uploadedImg'), ueReadyHandlers = [];
        function init(){
            var vueArea = new Vue({
                el: '#vueArea',
                data:{
                    postMaximum: 8,
                    postList: [],
                    crtPost: new DataPost(),
                    isEditMode: false
                },
                methods: {
                    addPost: function(){
                        var d = new DataPost();
                        this.postList.push(d);
                        this.crtPost = d;
                    },
                    removePost: function(index){
                        if(this.crtPost === this.postList[index])
                        {
                            this.crtPost = this.postList[index - 1];
                        }
                        this.postList.splice(index, 1);
                    },
                    moveForward: function(index){
                        var preIndex = index - 1;
                        var newArray = this.postList.concat();
                        newArray[preIndex] = newArray.splice(index, 1, newArray[preIndex])[0];
                        this.postList = newArray;
                        this.crtPost = this.postList[preIndex];
                    },
                    moveBackward: function(index){
                        var nextIndex = index + 1;
                        var newArray = this.postList.concat();
                        newArray[nextIndex] = newArray.splice(index, 1, newArray[nextIndex])[0];
                        this.postList = newArray;
                        this.crtPost = this.postList[nextIndex];
                    },
                    submitForm: function(){

                        for(var i=0; i<this.postList.length; i++)
                        {
                            var p = this.postList[i];
                            if(!this.validateFileds([p.title, p.thumb_url], ["图文标题不能留空", "请设置图文封面"]))
                            {
                                return;
                            }
                        }

                        swalAlert('同步到微信中,请不要关闭当前页面');

                        //ajax提交
                        $.ajax({
                            type:"post",
                            url:"<?= Url::to(['news-link-edit'])?>",
                            dataType: "json",
                            data: {
                                attach_id : "<?= $attach_id ?>",
                                list:JSON.stringify(this.postList) //图文列表数据
                            },
                            success: function(data){
                                if(data.flg == 1){
                                    window.location.href = "<?= Url::to(['news-index'])?>";
                                }
                            }
                        });
                    },
                    uploadNewthumb_url: function(){
                        $('.webuploader-container input').trigger('click');//触发上传组件的选图功能
                    },
                    validateFileds: function(valueList, errorMsgList){
                        for(var i=0; i<valueList.length; i++)
                        {
                            if(!valueList[i])
                            {
                                alert(errorMsgList[i]);
                                return false;
                            }
                        }
                        return true;
                    }
                },
                mounted: function(){
                    var self = this;
                    var list = <?= $list ?>;

                    //上传组件上传完图片后会抛送此事件，此时将图片在服务器上的地址给到我们的crtPost.thumb_url里面
                    $(document).on('setUploadedImg', function(e, uploaderName, imgSrc){
                        if(uploaderName == 'thumb_url')
                        {
                            self.crtPost.thumb_url = imgSrc;
                        }
                    });

                    if(list && list.length > 0)
                    {
                        self.postList = list;

                        self.isEditMode = true;
                    }
                    //新建回复规则的情况
                    else
                    {
                        self.addPost();
                        self.isEditMode = false;
                    }

                    self.crtPost = self.postList[0];
                },
                watch: {
                    crtPost: function(v, old){
                        function visitUE(){
                        }
                        ue ? visitUE() : ueReadyHandlers.push(visitUE);
                    }
                }
            });
        };

        setTimeout(init, 0);//延迟一帧执行，为了让后面的UEditor.php中的那句UE.getEditor先执行，这样我们才能在init中通过UE.getEditor语句拿到已经初始化好的editor实例
    });
</script>
