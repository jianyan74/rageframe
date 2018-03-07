
<div>直播间</div>
<div>消息</div>
<div style="width: 100%;height: 500px" id="msg"></div>
<div>
    <input type="text" id="conent">
    <input type="button" value="提交" id="sub">
</div>

<script>
    var wsl = 'wss://cook.yllook.com:9501';
    ws = new WebSocket(wsl);//新建立一个连接
    //如下指定事件处理
    ws.onopen = function () {
        //ws.send('Test!');
    };
    //接收消息
    ws.onmessage = function (evt) {
        console.log(evt.data);
        var html = "<div>"+evt.data+"</div> ";
        $("#msg").append(html);
        /*ws.close();*/
    };
    ws.onclose = function (evt) {
        console.log('WebSocketClosed!');
    };
    ws.onerror = function (evt) {
        console.log('WebSocketError!');
    };

    $("#sub").click(function(){
        var msg = $("#conent").val();

        ws.send(msg);
    })
</script>