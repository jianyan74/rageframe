
<div>直播间</div>
<div>消息</div>
<div style="width: 100%;height: 500px" id="msg"></div>
<div>
    <input type="text" id="conent">
    <input type="button" value="提交" id="sub">
</div>

<script>

    // 连接websocket
    reconnect();

    function reconnect(){
        var wsl = 'wss://www.yllook.com:9501';
        ws = new WebSocket(wsl);//新建立一个连接
        // 如下指定事件处理
        ws.onopen = function () {
            var login_data = '{"type":"login","nickname":"隔壁老王","head_portrait":"123","room_id":10001}';
            ws.send(login_data);

            // 开始心跳
            // window.setInterval(pong, 3000);
        };

        // 接收消息
        ws.onmessage = function (evt)
        {
            console.log(evt.data);
            var data = JSON.parse(evt.data);
            var html = '';

            if(data.type == 'login'){
                html = "<div>"+data.member.nickname+"加入了聊天....</div> ";
            }else{
                html = "<div>"+data.nickname+":"+data.content+";</div> ";
            }

            $("#msg").append(html);
        };

        // 关闭
        ws.onclose = function (evt) {
            // 重新连接
            wsConnect();
            console.log('WebSocketClosed!');
        };

        // 报错
        ws.onerror = function (evt) {
            // 重新连接
            wsConnect();
            console.log('WebSocketError!');
        };
    }

    $("#sub").click(function()
    {
        var msg = $("#conent").val();
        if(msg){
            var data = '{"type":"say","to_client_id":"all","content":'+ msg +'}';
            // console.log(data);
            ws.send(data);
        }
    });

    // 心跳
    function pong(){
        var data = '{"type":"pong"}';
        ws.send(data);
    }

    // 重连
    function wsConnect(){
        // 10秒后重新连接，实际效果：每10秒重连一次，直到连接成功
        setTimeout(function () {
            console.log('重连中...');
            reconnect();
        }, 10000);
    }
</script>