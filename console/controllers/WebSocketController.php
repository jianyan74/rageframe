<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;
use common\components\WebSocket;

/**
 * WebSocket
 * 启动 php ./yii web-socket/start
 * 停止 php ./yii web-socket/stop
 * 重启 php ./yii web-socket/restart
 *
 * Class WebSocketController
 * @package console\controllers
 */
class WebSocketController extends Controller
{
    /**
     * 监听地址
     *
     * @var string
     */
    public $host = '0.0.0.0';

    /**
     * 监听端口
     *
     * @var string
     */
    public $port = 9501;

    /**
     * swoole 配置
     *
     * @var array
     */
    public $config = [
        'daemonize' => false, // 守护进程执行
        'ssl_cert_file' => '',
        'ssl_key_file' => '',
        'pid_file' => '',
    ];

    /**
     * 启动
     *
     * @throws \yii\base\Exception
     */
    public function actionStart()
    {
        if ($this->getPid() !== false)
        {
            $this->stderr("服务已经启动");
            exit(1);
        }

        // 写入进程
        $this->setPid();

        // 运行
        $ws = new WebSocket($this->host, $this->port, $this->config);
        $ws->run();

        $this->stdout("服务正在运行,监听 {$this->host}:{$this->port}" . PHP_EOL);
    }

    /**
     * 关闭进程
     */
    public function actionStop()
    {
        $this->sendSignal(SIGTERM);
        $this->stdout("服务已经停止, 停止监听 {$this->host}:{$this->port}" . PHP_EOL);
    }

    /**
     * 重启进程
     *
     * @throws \yii\base\Exception
     */
    public function actionRestart()
    {
        $this->sendSignal(SIGTERM);
        $time = 0;
        while (posix_getpgid($this->getPid()) && $time <= 10)
        {
            usleep(100000);
            $time++;
        }

        if ($time > 100)
        {
            $this->stderr("服务停止超时" . PHP_EOL);
            exit(1);
        }

        if( $this->getPid() === false )
        {
            $this->stdout("服务重启成功" . PHP_EOL);
        }
        else
        {
            $this->stderr("服务停止错误, 请手动处理杀死进程" . PHP_EOL);
        }

        $this->actionStart();
    }

    /**
     * 发送信号
     *
     * @param $sig
     */
    private function sendSignal($sig)
    {
        if ($pid = $this->getPid())
        {
            posix_kill($pid, $sig);
        }
        else
        {
            $this->stdout("服务未运行!" . PHP_EOL);
            exit(1);
        }
    }

    /**
     * 获取pid进程
     *
     * @return bool|string
     */
    private function getPid()
    {
        $pid_file = $this->config['pid_file'];
        if (file_exists($pid_file))
        {
            $pid = file_get_contents($pid_file);
            if (posix_getpgid($pid))
            {
                return $pid;
            }
            else
            {
                unlink($pid_file);
            }
        }

        return false;
    }

    /**
     * 写入pid进程
     *
     * @throws \yii\base\Exception
     */
    private function setPid()
    {
        $parentPid = getmypid();
        $pidDir = dirname($this->config['pid_file']);
        if(!file_exists($pidDir)) FileHelper::createDirectory($pidDir);
        file_put_contents($this->config['pid_file'], $parentPid + 1);
    }
}