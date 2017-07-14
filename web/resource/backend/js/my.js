//复选框
$(".i-checks").iCheck({
    checkboxClass:"icheckbox_square-green",
    radioClass:"iradio_square-green",
});

//删除确认
function deleted(obj){
    appConfirm("您确定要删除这条信息吗?", "删除后将无法恢复，请谨慎操作！", function (){
        var link = $(obj).attr('href');
        window.location = link;
    })
}

//弹出框提示
function swalAlert(msg){
    swal({
        title   : msg,
        text    :"小手一抖就打开了一个框",
        //type    : type,
        confirmButtonText : "确定"
    })
}

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

//倒计时
setInterval("closeCountDown()",1000);//1000为1秒钟
function closeCountDown()
{
    var closeTime = $('.closeTimeYl').text();
    closeTime--;
    $('.closeTimeYl').text(closeTime);
    if(closeTime <= 0){
        $('.alert').children('.close').click();
    }
}