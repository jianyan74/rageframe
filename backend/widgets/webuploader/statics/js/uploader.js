$(function() {
    //初始化绑定默认的属性
    $.upLoadDefaults = $.upLoadDefaults || {};
    $.upLoadDefaults.property = {
        water       : false, //是否加水印InitMultiUploader
        thumbnail   : false, //是否生成缩略图
        btntext     : "", //上传按钮的文字
        swf         : null //SWF上传控件相对地址
    };

    //初始化上传控件
    $.fn.InitMultiUploader = function(b) {
        var fun = function(parentObj) {
            var p = $.extend({}, $.upLoadDefaults.property, b || {});
            var btnObj = $('<div class="upload-btn">' + p.btntext + '</div>').appendTo(parentObj);

            //初始化WebUploader
            var uploader = WebUploader.create({
                compress: false, //不压缩
                auto    : true, //自动上传
                swf     : p.swf, //SWF路径
                server  : p.server, //上传地址
                pick    : {
                    id      : btnObj,
                    multiple: p.multiple
                },
                accept  : {
                    /*title: 'Images',*/
                    extensions  : p.extensions,
                    mimeTypes   : p.mimeTypes
                },
                formData: {
                    // 'DelFilePath': '' //定义参数
                },
                fileVal             : 'file', //上传域的名称
                fileSingleSizeLimit : p.filesize //文件大小
            });

            //当validate不通过时，会以派送错误事件的形式通知
            uploader.on('error', function(type) {
                switch (type) {
                    case 'Q_EXCEED_NUM_LIMIT':
                        alert("错误：上传文件数量过多！");
                        break;
                    case 'Q_EXCEED_SIZE_LIMIT':
                        alert("错误：文件总大小超出限制！");
                        break;
                    case 'F_EXCEED_SIZE':
                        alert("错误：文件大小超出限制！");
                        break;
                    case 'Q_TYPE_DENIED':
                        alert("错误：禁止上传该类型文件！");
                        break;
                    case 'F_DUPLICATE':
                        alert("错误：请勿重复上传该文件！");
                        break;
                    default:
                        alert('错误代码：' + type);
                        break;
                }
            });

            //当有文件添加进来的时候
            uploader.on('fileQueued', function(file) {
                //如果是单文件上传，把旧的文件地址传过去
                if (!p.multiple) {
                    uploader.options.formData.DelFilePath = parentObj.siblings(".upload-path").val();
                }
                //防止重复创建
                if (parentObj.children(".upload-progress").length == 0) {
                    //创建进度条
                    var fileProgressObj = $('<div class="upload-progress"></div>').appendTo(parentObj);
                    var progressText = $('<span class="txt">正在上传...</span>').appendTo(fileProgressObj);
                    var progressBar = $('<span class="bar"><b></b></span>').appendTo(fileProgressObj);
                    var progressCancel = $('<a class="close " title="取消上传" style="font-size:14px;color: #000000">关闭</a>').appendTo(fileProgressObj);
                    //绑定点击事件
                    progressCancel.click(function() {
                        uploader.cancelFile(file);
                        fileProgressObj.remove();
                    });
                }
            });

            //文件上传过程中创建进度条实时显示
            uploader.on('uploadProgress', function(file, percentage) {
                var progressObj = parentObj.children(".upload-progress");
                //progressObj.children(".txt").html(file.name);
                progressObj.find(".bar b").width(percentage * 100 + "%");
            });

            //当文件上传出错时触发
            uploader.on('uploadError', function(file, reason) {
                uploader.removeFile(file); //从队列中移除
                alert("上传失败，错误代码：" + reason);
            });

            //当文件上传成功时触发
            uploader.on('uploadSuccess', function(file, data) {
                if (data.code != 200) {
                    var progressObj = parentObj.children(".upload-progress");
                    progressObj.children(".txt").html(data.message);
                    alert(data.message);
                }else{
                    data = data.data;
                    //如果是单文件上传，则赋值相应的表单
                    if(p.uploadType == 'filesUpload'){
                        addFile(parentObj, data.urlPath, data.urlPath, p.name,p.multiple);
                    }else if(p.uploadType == 'imagesUpload'){
                        if(p.vueMaterial == true){
                            //vue绑定
                            $(document).trigger('setUploadedImg', [p.name, data.urlPath]);
                        }

                        addImage(parentObj, data.urlPath, data.urlPath, p.name,p.multiple);
                    }

                    var progressObj = parentObj.children(".upload-progress");
                    progressObj.children(".txt").html("上传成功");
                }

                uploader.removeFile(file); //从队列中移除
            });

            //不管成功或者失败，文件上传完成时触发
            uploader.on('uploadComplete', function(file) {
                var progressObj = parentObj.children(".upload-progress");
                progressObj.children(".txt").html("上传完成");
                //如果队列为空，则移除进度条
                if (uploader.getStats().queueNum == 0) {
                    progressObj.remove();
                }
            });
        };
        return $(this).each(function() {
            fun($(this));
        });
    }
});

/*图片相册处理事件*/
function addImage(targetObj, originalSrc, thumbSrc, hidden_photo,multiple) {
    var newLi = $('<li class="social-avatar">'
        + '<input type="hidden" name="'+hidden_photo+'" value="'+originalSrc+'" />'
        + '<div class="img-box">'
        + '<a data-fancybox="gallery" href="'+ originalSrc +'">'
        + '<img src="' + thumbSrc + '"/>'
        + '</a>'
        + '<i class="delimg" data-multiple="'+ multiple +'"></i>'
        + '</div>'
        + '</li>');

    //判断是否是多图上传
    if(multiple == 'false' || multiple == false){
        targetObj.hide();
    }

    //查找文本框并移除
    var name = targetObj.parent().attr('data-name');
    var boxId = targetObj.parent().attr('data-boxId');
    targetObj.parent().find('#'+boxId).remove();

    targetObj.before(newLi);
}

//删除图片节点
$(document).on("click",".delimg",function(){
    var parentObj = $(this).parent().parent();
    var multiple =  $(this).attr('data-multiple');
    var name = $(this).parent().parent().parent().attr('data-name');
    var boxId = $(this).parent().parent().parent().attr('data-boxId');
    var input = '<input type="hidden" name="' + name + '" value="" id="'+boxId +'"/>';

    //判断是否是多图上传
    if(multiple == 'false' || multiple == false){
        //增加值为空的隐藏域
        $(this).parent().parent().parent().append(input);
        //显示上传图片按钮
        $(this).parent().parent().parent().find("li").show();
    }else{
        //增加值为空的隐藏域
        var length = $(this).parent().parent().parent().find('li').length;
        if(length == 2){
            $(this).parent().parent().parent().append(input);
        }
    }

    parentObj.remove();
});

/* 文件处理事件*/
function addFile(targetObj, originalSrc, thumbSrc, hidden_photo,multiple) {

    console.log(targetObj);
    var newDiv = '<div class="file-default-box">'
        + '<input type="hidden" name="'+hidden_photo+'" value="'+originalSrc+'" />'
        + '<i class="fa fa-file"></i>'
        + '<div class="file-delimg" data-multiple="'+ multiple +'"></div>'
        + '</div>';

    //查找文本框并移除
    var name = targetObj.parent().parent().parent().attr('data-name');
    var boxId = targetObj.parent().parent().parent().attr('data-boxId');
    //判断是否是多图上传
    if(multiple == false){
        targetObj.parent().parent().parent().find('#'+boxId).html('');
    }

    targetObj.parent().parent().parent().find('.file-default').remove();
    targetObj.parent().parent().parent().find('#'+boxId).prepend(newDiv);

    var length = targetObj.parent().parent().parent().find('.file-default-box').length;
    $('#file-default-' + boxId).val('已选择' + length + '个文件');
}

//删除文件节点
$(document).on("click",".file-delimg",function(){

    var name = $(this).parent().parent().parent().attr('data-name');
    var boxId = $(this).parent().parent().parent().attr('data-boxId');
    var html = '<div class="file-default-box file-default">'
            +'<input type="hidden" name="' + name + '" value=""/>'
        +'<i class="fa fa-cloud-upload"></i>'
        +'</div>';
    //移除当前的选择
    var parentObj = $(this).parent();

    //判断增加默认数据
    var length = parentObj.parent().find('.file-default-box').length;
    if(length == 1){
        parentObj.parent().html(html);
    }else{
        parentObj.remove();
    }

    var sum = length - 1;
    if(sum == 0){
        $('#file-default-' + boxId).val('');
    }else{
        $('#file-default-' + boxId).val('已选择' + sum + '个文件');
    }
});