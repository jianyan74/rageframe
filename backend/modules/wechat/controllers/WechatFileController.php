<?php
namespace backend\modules\wechat\controllers;

use yii;
use yii\web\UploadedFile;
use common\helpers\FileHelper;
use common\helpers\StringHelper;

/**
 * 微信素材上传控制器
 * Class WechatFileController
 * @package backend\modules\wechat\controllers
 */
class WechatFileController extends WController
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
                'size' => 1048576,//1024 * 1024
                'errmsg' => '临时图片只支持jpg/logo格式,大小不超过为1M',
            ],
            'voice' => [
                'ext'  => ['amr', 'mp3'],
                'size' => 2097152,//2048 * 1024
                'errmsg' => '临时语音只支持amr/mp3格式,大小不超过为2M',
            ],
            'video' => [
                'ext'  => ['mp4'],
                'size' => 10485760,//10240 * 1024
                'errmsg' => '临时视频只支持mp4格式,大小不超过为10M',
            ],
            'thumb' => [
                'ext'  => ['jpg', 'logo'],
                'size' => 65536,//64 * 1024
                'errmsg' => '临时缩略图只支持jpg/logo格式,大小不超过为64K',
            ],
        ],
        //永久素材
        'perm' => [
            'image' => [
                'ext'   => ['bmp', 'png', 'jpeg', 'jpg', 'gif'],
                'size'  => 2097152,//2048 * 1024
                'max'   => 5000,
                'errmsg' => '永久图片只支持bmp/png/jpeg/jpg/gif格式,大小不超过为2M',
            ],
            'voice' => [
                'ext'  => ['amr', 'mp3', 'wma', 'wav', 'amr'],
                'size' => 5242880,//5120 * 1024
                'max'  => 1000,
                'errmsg' => '永久语音只支持mp3/wma/wav/amr格式,大小不超过为5M,长度不超过60秒',
            ],
            'video' => [
                'ext'  => ['rm', 'rmvb', 'wmv', 'avi', 'mpg', 'mpeg', 'mp4'],
                'size' => 20971520,//10240 * 1024 * 2
                'max'  => 1000,
                'errmsg' => '永久视频只支持rm/rmvb/wmv/avi/mpg/mpeg/mp4格式,大小不超过为20M',
            ],
            'thumb' => [
                'ext'  => ['bmp', 'png', 'jpeg', 'jpg', 'gif'],
                'size' => 2097152,//2048 * 1024
                'max'  => 5000,
                'errmsg' => '永久缩略图只支持bmp/png/jpeg/jpg/gif格式,大小不超过为2M',
            ],
        ],
        //卡卷封面
        'file_upload' => [
            'image' => [
                'ext'   => ['jpg'],
                'size'  => 1048576,//1024 * 1024
                'max'   => -1,
                'errmsg' => '图片只支持jpg格式,大小不超过为1M',
            ],
        ]
    ];

    /**
     * 当前上传的文件
     * @var
     */
    protected $_file;

    /**
     * 报错
     * @var
     */
    protected $_message;

    /**
     * 文件上传状态
     * @var
     */
    protected $_fileUplocadStatus;

    /**
     * 文件本地保存路径
     * @var
     */
    protected $_filePath;

    /**
     * @param yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        //上传的文件
        $this->_file = $_FILES['file'];
        if($this->_file)
        {
            //大小
            $file_size  = $this->_file['size'];
            //原名称
            $file_name  = $this->_file['name'];

            $action = Yii::$app->controller->action->id;
            //检测图片类型和大小
            if($file_size > $this->limit['perm'][$action]['size'] || !in_array(StringHelper::clipping($file_name,'.',1), $this->limit['perm'][$action]['ext']))//判定图片大小是否超出限制
            {
                $this->_message = $this->limit['perm'][$action]['errmsg'];
            }

            if($this->_message)
            {
                //默认返回状态
                $result = [];
                $result['flg'] = 2;
                $result['msg'] = $this->_message;
                echo json_encode($result);
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * 图片上传方法
     */
    public function actionImage()
    {
        //图片后缀
        $file_exc   = StringHelper::clipping($this->_file['name']);
        //相对路径
        $this->_filePath = $this->getImgPath().Yii::$app->params['imagesUpload']['imgPrefix'].StringHelper::random(10).$file_exc;
        //上传
        $UploadFile     = UploadedFile::getInstanceByName('file');//利用yii2自带的上传图片
        $this->_fileUplocadStatus  = $UploadFile->saveAs(Yii::getAlias("@attachment/").$this->_filePath);//保存图片
    }

    /**
     * 上传音频方法
     */
    public function actionVoice()
    {

    }

    /**
     * 上传视频方法
     */
    public function actionVideo()
    {

    }

    /**
     * 后置控制器
     * @param yii\base\Action $action
     * @param mixed $result
     * @return mixed
     */
    public function afterAction($action, $result)
    {
        //默认返回状态
        $result = [];
        $result['flg'] = 2;
        $result['msg'] = '未知错误';

        //上传到微信服务端
        $material = $this->_app->material;
        $wx_result = $material->uploadImage(Yii::getAlias("@attachment/").$this->_filePath);

        if($this->_fileUplocadStatus == true && !isset($wx_result['errcode']))
        {
            $result['flg'] = 1;
            $result['msg'] = "上传成功";
            $result['imgName']  = $this->_filePath;//图片上传地址
            $result['url']  = Yii::getAlias("@attachurl/").$this->_filePath."?".$wx_result['media_id'];
            $result['state']  = 'success';
        }
        else
        {
            $result['msg'] = $wx_result['errcode'];
        }

        return $result;
    }

    /**
     * 获取文件路径
     * @param null $thumb
     * @return string
     */
    public function getImgPath($thumb = null)
    {
        $file_path   = empty($thumb) ? Yii::$app->params['imagesUpload']['imgPath'] : Yii::$app->params['imagesUpload']['imgThumbPath'];//图片路径
        $ImgSubName  = Yii::$app->params['imagesUpload']['imgSubName'];//图片子路径
        $path    = $file_path.date($ImgSubName,time())."/";
        $addPath = Yii::getAlias("@attachment/").$path;
        FileHelper::mkdirs($addPath);//创建路径

        return $path;
    }
}