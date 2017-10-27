//错误提示
function rfError(title,text) {
    var dialogText = rfText(text);
    swal({
        title : title,
        text  : dialogText,
        type  : "error"
    })
}

//警告提示
function rfWarning(title,text) {
    var dialogText = rfText(text);
    swal({
        title : title,
        text  : dialogText,
        type  : "warning"
    })
}

//普通提示
function rfAffirm(title,text) {
    var dialogText = rfText(text);
    swal({
        title : title,
        text  : dialogText
    })
}

//信息提示
function rfInfo(title,text) {
    var dialogText = rfText(text);
    swal({
        title : title,
        text  : dialogText,
        type  : "info"
    })
}

//成功提示
function rfSuccess(title,text) {
    var dialogText = rfText(text);
    swal({
        title : title,
        text  : dialogText,
        type  : "success"
    })
}

//删除提示
function rfDelete(obj) {
    appConfirm("您确定要删除这条信息吗?", "删除后将无法恢复，请谨慎操作！", function (){
        var link = $(obj).attr('href');
        window.location = link;
    })
}

//删除确认提示
function appConfirm(title, txt, onConfirm){
	swal({
        title: title,
        text: txt,
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "删除",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: '取消',
        closeOnConfirm: true
  }, onConfirm);
}

function rfText(text) {

    if(text){
        return text;
    }else{
        return '小手一抖就打开了一个框';
    }
}

//复选框
$(".i-checks").iCheck({
    checkboxClass:"icheckbox_square-green",
    radioClass:"iradio_square-green"
});

//倒计时
setInterval("closeCountDown()",1000);//1000为1秒钟
function closeCountDown() {
    var closeTime = $('.closeTimeYl').text();
    closeTime--;
    $('.closeTimeYl').text(closeTime);
    if(closeTime <= 0){
        $('.alert').children('.close').click();
    }
}