<?php
namespace backend\controllers;

use common\helpers\ResultDataHelper;
use common\helpers\StringHelper;
use jianyan\basics\common\models\sys\Article;
use yii;
use common\helpers\ArithmeticHelper;
use common\helpers\DataDictionaryHelper;
use common\helpers\RsaEncryptionHelper;
use jianyan\basics\common\models\sys\Config;
use jianyan\basics\common\models\sys\ConfigCate;
use jianyan\basics\common\models\sys\Manager;
use jianyan\basics\common\payment\AliPay;
use jianyan\websocket\live\Room;

/**
 * 测试控制器
 *
 * Class FileController
 * @package backend\modules\sys\controllers
 */
class TestController extends MController
{
    /**
     * 默认禁止使用测试
     *
     * @var bool
     */
    public $visitAuth = true;

    public function init()
    {
        if($this->visitAuth == false)
        {
            die();
        }

        parent::init();
    }

    public function actionPay()
    {
        $order = [
            'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
            'total_amount' => 0.01,
            'subject'      => 'test',
        ];

        $config = [

        ];

        $order = [
            'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
            'total_fee' => 100,
            'body'      => 'test',
        ];

        $config = Yii::$app->pay->wechat($config)->mweb($order,true);

        p($config);die();
    }

    public function actionConfig()
    {
        // 所有的配置信息
        $list = Config::find()
            ->where(['status' => 1])
            ->orderBy('cate asc,sort asc')
            ->asArray()
            ->all();

        // 获取全部分类并压缩到分类中
        $configCateAll = ConfigCate::getListAll();
        foreach ($configCateAll as &$item)
        {
            foreach ($list as $vo)
            {
                if($item['id'] == $vo['cate_child'])
                {
                    $item['config'][] = $vo;
                }
            }
        }

        $str = '';
        $i = 0;
        foreach ($configCateAll as $key => $datum)
        {
            if(isset($datum['config']))
            {
                $str .= "### {$datum['title']}" . "\n\r";
                $str .= "参数 | 描述 " . "\n";
                $str .= "---|---" . "\n";

                foreach ($datum['config'] as $item)
                {
                    $str .= "{$item['title']} | {$item['name']}" . "\n";
                }

                $str .= "\r";
                $i++;
            }
        }

        echo "<pre>";
        echo $str;
        exit();


    }

    /**
     * 测试输出马克笔记格式的数据
     */
    public function actionStoredProcedure()
    {
        /**
         * 创建的存储过程
         */

        $reg = "davafy@davafy.com";
        $cmd = Yii::$app->db->createCommand("call test_table(:reg, @s)");
        $cmd->bindParam(':reg',$reg,\PDO::PARAM_STR,50);
        $res = $cmd->queryOne();

        $ret = Yii::$app->db->createCommand("select @s")->queryOne();
    }

    /**
     * 导出马克笔记
     */
    public function actionDataDictionary()
    {
        $model = new DataDictionaryHelper();
        $model->getMarkTableData();
    }

    /**
     * 队列测试
     */
    public function actionQueue()
    {
//        Yii::$app->queue->push(new DownloadJob([
//            'url' => 'http://example.com/image.jpg',
//            'file' => '/tmp/rageframe/image.jpg',
//        ]));

        echo '推送队列成功';

        // 将作业推送到队列中延时5分钟运行:
//        Yii::$app->queue->delay(5 * 60)->push(new DownloadJob([
//            'url' => 'http://example.com/image.jpg',
//            'file' => '/tmp/image.jpg',
//        ]));
    }

    /**
     * 上传图片测试
     *
     * @return string
     */
    public function actionUploadImg()
    {
        $model = new Manager();

        return $this->render('upload-img', [
            'model'  => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionWebsocket()
    {
        return $this->render('websocket', [

        ]);
    }

    /**
     * 上传文件测试
     *
     * @return string
     */
    public function actionUploadFile()
    {
        $model = new Manager();

        if(Yii::$app->request->isPost)
        {
            $this->p(Yii::$app->request->post());die();
        }

        return $this->render('upload-file', [
            'model'  => $model,
        ]);
    }

    /**
     * 红包生成测试
     */
    public function actionRedPacket()
    {
        // 切记如果红包数量太多，不要设置为0.1 会导致最后红包金额不对
        $data = ArithmeticHelper::getRedPackage(100,998,0.01,3);

        $all_money = 0;
        foreach ($data as $datum)
        {
            $all_money += $datum;
        }

        $this->p($all_money);
        $this->p($data);
    }

    /**
     * 测试接口返回时间
     * @return array
     */
    public function actionApiResult()
    {
        $this->setResult();
        $this->_result->code = 200;

        $data = [];
        for ($i = 0; $i < 50; $i++)
        {
            $user   = Manager::find()
                ->with('assignment')
                ->asArray()
                ->all();
        }

        $this->_result->data = $data;

        return $this->getResult();
    }

    /**
     * 写入缓存
     * 经过测试如果设置了缓存为yii系统组件则可以进行写入例下
     *    'cache'      => [
     *        'class' => 'yii\redis\Cache',
     *     ],
     * 一般数据0.0001秒
     * @param $key
     * @param $value
     */
    public function actionSetRedis($key, $value, $time = 60)
    {
        $startTime = microtime(true);
        Yii::$app->redis->set($key, $value);
        // 配置过成为yii系统组件可用
        // Yii::$app->cache->set($key, $value, $time);
        $endTime = microtime(true);
        $elapsed = number_format($endTime - $startTime, 4);

        $this->p('写入缓存成功');
        $this->p($elapsed);
    }

    /**
     * 输出redis并获取获得速度
     * @param $key
     */
    public function actionGetRedis($key)
    {
        $startTime = microtime(true);
        $rsp = Yii::$app->redis->get($key);
        $endTime = microtime(true);
        $elapsed = number_format($endTime - $startTime, 4);

        $this->p($rsp);
        $this->p($elapsed);
    }

    /**
     * memcache写入缓存
     * 一般数据0.0005左右
     * @param $key
     * @param $value
     */
    public function actionSetMemCache($key, $value, $time = 60)
    {
        $startTime = microtime(true);
        Yii::$app->memcache->set($key, $value, $time);
        $endTime = microtime(true);
        $elapsed = number_format($endTime - $startTime, 4);

        $this->p('写入缓存成功');
        $this->p($elapsed);
    }

    /**
     * memcache输出测试
     * @param $key
     */
    public function actionGetMemCache($key)
    {
        $startTime = microtime(true);
        $rsp = Yii::$app->memcache->get($key);
        $endTime = microtime(true);
        $elapsed = number_format($endTime - $startTime, 4);

        $this->p($rsp);
        $this->p($elapsed);
    }

    /**
     * 输出phpinfo
     */
    public function actionPhpInfo()
    {
        echo phpinfo();
    }
}