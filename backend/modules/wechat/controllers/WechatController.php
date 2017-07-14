<?php
namespace backend\modules\wechat\controllers;

use yii;
use yii\web\UploadedFile;
/**
 * Class WechatController
 * @package backend\modules\wechat\controllers
 * 微信操作控制器
 */
class WechatController extends WController
{
    /**
     * @var array
     * 微信上传配置
     */
    protected $limit = [
        //临时素材
        'temp' => [
            'image' => [
                'ext'  => ['jpg', 'logo'],
                'size' => 1024 * 1024,
                'errmsg' => '临时图片只支持jpg/logo格式,大小不超过为1M',
            ],
            'voice' => [
                'ext'  => ['amr', 'mp3'],
                'size' => 2048 * 1024,
                'errmsg' => '临时语音只支持amr/mp3格式,大小不超过为2M',
            ],
            'video' => [
                'ext'  => ['mp4'],
                'size' => 10240 * 1024,
                'errmsg' => '临时视频只支持mp4格式,大小不超过为10M',
            ],
            'thumb' => [
                'ext'  => ['jpg', 'logo'],
                'size' => 64 * 1024,
                'errmsg' => '临时缩略图只支持jpg/logo格式,大小不超过为64K',
            ],
        ],
        //永久素材
        'perm' => [
            'image' => [
                'ext'   => ['bmp', 'png', 'jpeg', 'jpg', 'gif'],
                'size'  => 2048 * 1024,
                'max'   => 5000,
                'errmsg' => '永久图片只支持bmp/png/jpeg/jpg/gif格式,大小不超过为2M',
            ],
            'voice' => [
                'ext'  => ['amr', 'mp3', 'wma', 'wav', 'amr'],
                'size' => 5120 * 1024,
                'max'  => 1000,
                'errmsg' => '永久语音只支持mp3/wma/wav/amr格式,大小不超过为5M,长度不超过60秒',
            ],
            'video' => [
                'ext'  => ['rm', 'rmvb', 'wmv', 'avi', 'mpg', 'mpeg', 'mp4'],
                'size' => 10240 * 1024 * 2,
                'max'  => 1000,
                'errmsg' => '永久视频只支持rm/rmvb/wmv/avi/mpg/mpeg/mp4格式,大小不超过为20M',
            ],
            'thumb' => [
                'ext'  => ['bmp', 'png', 'jpeg', 'jpg', 'gif'],
                'size' => 2048 * 1024,
                'max'  => 5000,
                'errmsg' => '永久缩略图只支持bmp/png/jpeg/jpg/gif格式,大小不超过为2M',
            ],
        ],
        //卡卷封面
        'file_upload' => [
            'image' => [
                'ext'   => ['jpg'],
                'size'  => 1024 * 1024,
                'max'   => -1,
                'errmsg' => '图片只支持jpg格式,大小不超过为1M',
            ],
            ]
    ];
    /**
     * @var array
     * 返回状态
     */
    protected $result = [
        'flg' => 2,
        'msg' => "",
    ];

    /**
     * 图片上传方法
     */
    public function actionUploadImages()
    {
        //错误状态表
        $stateMap = Yii::$app->params['uploadState'];
        //默认返回状态
        $result = [];
        $result['flg'] = 2;
        $result['msg'] = $stateMap['ERROR_UNKNOWN'];

        $file = $_FILES['file'];
        if ($_FILES['file'])
        {
            $file_size  = $file['size'];//图片大小
            $file_name  = $file['name'];//图片原名称
            $file_exc   = $this->getFileExt($file_name);//图片后缀

            if($file_size > Yii::$app->params['imagesUpload']['imgMaxSize'])//判定图片大小是否超出限制
            {
                $result['msg'] = $stateMap['ERROR_SIZE_EXCEED'];
            }
            else if(!$this->checkType($file_exc))//检测图片类型
            {
                $result['msg'] = $stateMap['ERROR_TYPE_NOT_ALLOWED'];
            }
            else
            {
                //相对路径
                $filePath = $this->getImgPath().Yii::$app->params['imagesUpload']['imgPrefix'].$this->random(10).$file_exc;
                //上传
                $UploadFile     = UploadedFile::getInstanceByName('file');//利用yii2自带的上传图片
                $file_status    = $UploadFile->saveAs(Yii::getAlias("@attachment/").$filePath);//保存图片

                //上传到微信服务端
                $material = $this->_app->material;
                $wx_result = $material->uploadImage(Yii::getAlias("@attachment/").$filePath);

                if($file_status == true && !isset($wx_result['errcode']))
                {
                    $result['flg'] = 1;
                    $result['msg'] = "上传成功";
                    $result['imgName']  = $filePath;//图片上传地址
                    $result['url']  = Yii::getAlias("@attachurl/").$filePath."?".$wx_result['media_id'];
                    $result['state']  = 'success';
                }
                else
                {
                    $result['msg'] = $wx_result['errcode'];
                }
            }
        }

        echo json_encode($result);
    }

    /**
     * @param null $Thumb 是否获取缩略图地址
     * @return string
     * 获取文件路径
     */
    public function getImgPath($thumb = null)
    {
        $file_path   = empty($thumb) ? Yii::$app->params['imagesUpload']['imgPath'] : Yii::$app->params['imagesUpload']['imgThumbPath'];//图片路径
        $ImgSubName  = Yii::$app->params['imagesUpload']['imgSubName'];//图片子路径
        $path    = $file_path.date($ImgSubName,time())."/";
        $addPath = Yii::getAlias("@attachment/").$path;
        $this->mkdirs($addPath);//创建路径

        return $path;
    }

    /**
     * 获取文件扩展名
     * @return string
     */
    public function getFileExt($fileName)
    {
        return strtolower(strrchr($fileName, '.'));
    }

    /**
     * 文件类型检测
     * @return bool
     */
    private function checkType($ext)
    {
        return in_array($ext, Yii::$app->params['imagesUpload']['imgMaxExc']);
    }

    /**
     * 获取随机字符串
     */
    public function random($length, $numeric = FALSE)
    {
        $seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));

        if ($numeric)
        {
            $hash = '';
        }
        else
        {
            $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
            $length--;
        }

        $max = strlen($seed) - 1;
        for ($i = 0; $i < $length; $i++)
        {
            $hash .= $seed{mt_rand(0, $max)};
        }
        return $hash;
    }

    /**
     * 检测目录并循环创建目录
     * @param $path
     */
    public function mkdirs($path)
    {
        if (!file_exists($path))
        {
            $this->mkdirs(dirname($path));
            mkdir($path, 0777);
        }
    }
}
