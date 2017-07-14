<?php
namespace common\controllers;

use yii;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use crazyfd\qiniu\Qiniu;
use common\helpers\FileHelper;
use common\helpers\StringHelper;

/**
 * 文件图片上传控制器
 * Class FileBaseController
 * @package backend\controllers
 */
class FileBaseController extends BaseController
{
    /**
     * 关闭csrf验证
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * 行为控制
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],//登录
                    ],
                ],
            ],
        ];
    }

    /**
     * 图片上传方法
     */
    public function actionUploadImages()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

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
            $file_exc   = StringHelper::clipping($file_name);//图片后缀

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
                $filePath = $this->getImgPath().Yii::$app->params['imagesUpload']['imgPrefix'].StringHelper::random(10).$file_exc;
                //上传
                $UploadFile     = UploadedFile::getInstanceByName('file');//利用yii2自带的上传图片
                $file_status    = $UploadFile->saveAs(Yii::getAlias("@attachment/").$filePath);//保存图片

                if($file_status == true)
                {
                    $result['flg'] = 1;
                    $result['msg'] = "上传成功";
                    $result['imgName']  = $filePath;//图片上传地址
                    $result['url']  = Yii::getAlias("@attachurl/").$filePath;
                    $result['state']  = 'success';
                }
            }
        }

        return $result;
    }

    /**
     * base64编码的图片上传
     * 头像上传
     */
    public function actionUploadBase64Img()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $result = [];
        $base64Data = $_POST['img'];
        $img = base64_decode($base64Data);
        $file_exc   = ".jpg";//图片后缀
        $file_path      = $this->getImgPath();//图片路径
        $file_new_name  = Yii::$app->params['imagesUpload']['imgPrefix'].StringHelper::random(10).$file_exc;//保存的图片名

        $filePath = Yii::getAlias("@attachment/").$file_path.$file_new_name;
        //移动文件
        if (!(file_put_contents($filePath, $img) && file_exists($filePath))) //移动失败
        {
            $result['flg'] = 2;
            $result['msg'] = "上传失败";
        }
        else //移动成功
        {
            $result['flg'] = 1;
            $result['msg'] = "上传成功";
            $result['imgName']  = $file_path.$file_new_name;//图片上传地址
            $result['imgPath']  = Yii::getAlias("@attachurl/").$file_path.$file_new_name;
            $result['url']  = Yii::getAlias("@attachurl/").$file_path.$file_new_name;
        }

        return $result;
    }

    /**
     * 七牛云存储
     */
    public function actionQiniu()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $ak = Yii::$app->config->info('STORAGE_QINIU_ACCESSKEY');
        $sk = Yii::$app->config->info('STORAGE_QINIU_SECRECTKEY');
        $domain = Yii::$app->config->info('STORAGE_QINIU_DOMAIN');
        $bucket = Yii::$app->config->info('STORAGE_QINIU_BUCKET');

        $file = $_FILES['file'];

        $qiniu = new Qiniu($ak, $sk,$domain, $bucket);
        $key = 'yl_'.time().substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);;
        $qiniu->uploadFile($file['tmp_name'],$key);
        $url = $qiniu->getLink($key);

        $result['flg'] = 1;
        $result['msg'] = "上传成功";
        $result['url'] = 'http://'.$url;
        $result['state']  = 'success';

        return $result;
    }

    /**
     * 上传文件方法
     */
    public function actionUploadFile()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
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
        FileHelper::mkdirs($addPath);//创建路径

        return $path;
    }

    /**
     * 文件类型检测
     * @return bool
     */
    private function checkType($ext)
    {
        return in_array($ext, Yii::$app->params['imagesUpload']['imgMaxExc']);
    }
}