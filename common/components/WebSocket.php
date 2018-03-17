<?php
namespace common\components;

/**
 * 长连接
 *
 * Class WebSocketController
 * @package console\controllers
 */
class WebSocket extends \jianyan\websocket\WebSocketServer
{
    /**
     * 开启连接
     *
     * @param $server
     * @param $frame
     */
    public function onOpen($server, $frame)
    {
        echo "server: handshake success with fd{$frame->fd}\n";
        echo "server: {$frame->data}\n";

        $this->_table->set($frame->fd, ['fd'=>$frame->fd]);
    }

    /**
     * 消息
     *
     * @param $server
     * @param $frame
     */
    public function onMessage($server, $frame)
    {
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        // 消息发送给自己
        $server->push($frame->fd, $frame->data);
        // 消息发送给别人
        $this->broadcast($frame->fd, $frame->data);
    }

    /**
     * 关闭连接
     *
     * @param $ser
     * @param $fd
     */
    public function onClose($ser, $fd)
    {
        echo "client {$fd} closed\n";
        // 删除
        $this->_table->del($fd);
    }

    /**
     * 广播进程
     *
     * @param integer $client_id 客户端id
     * @param string $msg 广播消息
     */
    public function broadcast($client_id, $msg)
    {
        //广播
        foreach ($this->_table as $cid => $info)
        {
            if ($client_id != $cid)
            {
                $this->_server->push($cid, $msg);
            }
        }
    }
}