<?php
namespace common\components;

use Yii;
use swoole_table;
use swoole_websocket_server;

/**
 * 长连接
 *
 * Class WebSocketController
 * @package console\controllers
 */
class WebSocket
{
    protected $_host;

    protected $_port;

    protected $_config;

    /**
     * 服务
     *
     * @var
     */
    protected $_server;

    /**
     * 基于共享内存和锁实现的超高性能，并发数据结构
     *
     * @var
     */
    protected $_table;

    /**
     * WebSocket constructor.
     * @param $host
     * @param $port
     * @param $config
     */
    public function __construct($host, $port, $config)
    {
        $this->_host = $host;
        $this->_port = $port;
        $this->_config = $config;

        // 创建内存表
        $this->createTable();
    }

    public function run()
    {
        // 启动进程
        $this->_server = new swoole_websocket_server($this->_host, $this->_port);
        $this->_server->set([
            // 以非守护进程执行
            'daemonize' => $this->_config['daemonize'],
            // 配置wss
            'ssl_cert_file' => $this->_config['ssl_cert_file'],
            'ssl_key_file' => $this->_config['ssl_key_file'],
        ]);

        $this->_server->on('open', [$this, 'onOpen']);
        $this->_server->on('message', [$this, 'onMessage']);
        $this->_server->on('close', [$this, 'onClose']);
        $this->_server->start();
    }

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
        $server->push($frame->fd, "this is server receive");
        $this->broadcast($frame->fd, "broadcast test." . $frame->fd);
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

    /**
     * 创建内存表
     *
     * 数指定表格的最大行数，如果$size不是为2的N次方，如1024、8192,65536等，底层会自动调整为接近的一个数字
     * 占用的内存总数为 (结构体长度 + KEY长度64字节 + 行尺寸$size) * (1.2预留20%作为hash冲突) * (列尺寸)，如果机器内存不足table会创建失败
     */
    private function createTable()
    {
        $this->_table = new swoole_table(1024);
        $this->_table->column('fd', swoole_table::TYPE_INT);
        //$this->_table->column('name', swoole_table::TYPE_STRING, 255);
        //$this->_table->column('avatar', swoole_table::TYPE_STRING, 255);
        $this->_table->create();
    }
}