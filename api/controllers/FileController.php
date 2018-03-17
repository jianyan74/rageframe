<?php
namespace api\controllers;

use yii;
use yii\web\UploadedFile;
use common\helpers\FileHelper;
use common\helpers\StringHelper;
use crazyfd\qiniu\Qiniu;
use OSS\OssClient;

/**
 * 文件上传控制器
 *
 * Class FileController
 * @package api\controllers
 */
class FileController extends AController
{
    public $modelClass = '';

    /**
     * 图片配置名称
     */
    const IMAGES_CONFIG = 'imagesUpload';

    /**
     * 视频配置名称
     */
    const VIDEOS_CONFIG = 'videosUpload';

    /**
     * 语音配置名称
     */
    const VOICE_CONFIG = 'voicesUpload';

    /**
     * 文件配置名称
     */
    const FILES_CONFIG = 'filesUpload';

    /**
     * 图片上传
     */
    public function actionUploadImages()
    {
        return $this->upload(self::IMAGES_CONFIG);
    }

    /**
     * 视频上传方法
     */
    public function actionUploadVideos()
    {
        return $this->upload(self::VIDEOS_CONFIG);
    }

    /**
     * 语音上传方法
     */
    public function actionUploadVoices()
    {
        return $this->upload(self::VOICE_CONFIG);
    }

    /**
     * 文件上传方法
     */
    public function actionUploadFiles()
    {
        return $this->upload(self::FILES_CONFIG);
    }

    /**
     * base64编码的图片上传
     * 头像上传
     */
    public function actionUploadBase64Img()
    {
        $type = self::IMAGES_CONFIG;

        $base64Data = Yii::$app->request->post('img');
        $img = base64_decode($base64Data);
        $file_exc = ".jpg";// 图片后缀
        if(!($file_path = $this->getPath($type)))
        {
            return $this->setResponse('文件夹创建失败，请确认是否开启attachment文件夹写入权限');
        }

        $file_new_name = Yii::$app->params[$type]['prefix'] . StringHelper::random(10) . $file_exc;// 保存的图片名
        $filePath = Yii::getAlias("@attachment/") . $file_path . $file_new_name;
        // 移动文件
        if (!(file_put_contents($filePath, $img) && file_exists($filePath))) // 移动失败
        {
            return $this->setResponse('上传失败');
        }
        else // 移动成功
        {
            return [
                'path' => $file_path . $file_new_name,
                'urlPath' => Yii::getAlias("@attachurl/") . $file_path . $file_new_name,
            ];
        }
    }

    /**
     * 七牛云存储
     *
     * @return array
     */
    public function actionQiniu()
    {
        $ak = Yii::$app->config->info('STORAGE_QINIU_ACCESSKEY');
        $sk = Yii::$app->config->info('STORAGE_QINIU_SECRECTKEY');
        $domain = Yii::$app->config->info('STORAGE_QINIU_DOMAIN');
        $bucket = Yii::$app->config->info('STORAGE_QINIU_BUCKET');

        try
        {
            $file = $_FILES['file'];
            $qiniu = new Qiniu($ak, $sk, $domain, $bucket);
            $key = 'rf_qiniu_' . time() . StringHelper::randomNum();
            $qiniu->uploadFile($file['tmp_name'], $key);
            $url = $qiniu->getLink($key);

            return [
                'path' => 'http://' . $url,
                'urlPath' => 'http://' . $url,
            ];
        }
        catch (\Exception $e)
        {
            return $this->setResponse($e->getMessage());
        }
    }

    /**
     * 阿里云OSS上传
     *
     * @return array
     */
    public function actionAliOss()
    {
        $accessKeyId = Yii::$app->config->info('STORAGE_ALI_ACCESSKEYID');
        $accessKeySecret = Yii::$app->config->info('STORAGE_ALI_ACCESSKEYSECRET');
        $endpoint =  Yii::$app->config->info('STORAGE_ALI_ENDPOINT');
        $bucket = Yii::$app->config->info('STORAGE_ALI_BUCKET');

        try
        {
            $file = $_FILES['file'];
            $file_name = $file['name'];// 原名称
            $file_exc = StringHelper::clipping($file_name);// 后缀
            $name = 'rf_alioss_' . time() . StringHelper::randomNum() . $file_exc;
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $oosResult = $ossClient->uploadFile($bucket,$name,$file['tmp_name']);
            // 私有获取图片信息
            // $singUrl = $ossClient->signUrl($bucket, $name, 60*60*24);

            return [
                'path' => $oosResult['info']['url'],
                'urlPath' => $oosResult['info']['url'],
            ];
        }
        catch (\Exception $e)
        {
            return $this->setResponse($e->getMessage());
        }
    }

    /**
     * 通用上传 支持文件，图片，语音等格式等上传
     *
     * @param $type
     */
    public function upload($type)
    {
        // 错误状态表
        $stateMap = Yii::$app->params['uploadState'];
        // 图片上传配置
        $uploadConfig = Yii::$app->params[$type];

        if ($file = $_FILES['file'])
        {
            $file_size = $file['size'];// 大小
            $file_name = $file['name'];// 原名称
            $file_exc = StringHelper::clipping($file_name);// 后缀

            if($file_size > $uploadConfig['maxSize'])// 判定大小是否超出限制
            {
                return $this->setResponse($stateMap['ERROR_SIZE_EXCEED']);
            }
            else if(!$this->checkType($file_exc, $type))// 检测类型
            {
                return $this->setResponse($stateMap['ERROR_TYPE_NOT_ALLOWED']);
            }
            else
            {
                // 相对路径
                if(!($path = $this->getPath($type)))
                {
                    return $this->setResponse('文件夹创建失败，请确认是否开启attachment文件夹写入权限');
                }

                $filePath = $path . $uploadConfig['prefix'] . StringHelper::random(10) . $file_exc;
                // 利用yii2自带的上传
                $uploadFile = UploadedFile::getInstanceByName('file');
                if($uploadFile->saveAs(Yii::getAlias("@attachment/") . $filePath))
                {
                    return [
                        'path' => $filePath,
                        'urlPath' => Yii::getAlias("@attachurl/") . $filePath,
                    ];
                }

                return $this->setResponse('文件移动错误');
            }
        }

        return $this->setResponse($stateMap['ERROR_UNKNOWN']);
    }

    /**
     * 文件类型检测
     *
     * @param $ext
     * @param $type
     * @return bool
     */
    private function checkType($ext, $type)
    {
        if(empty(Yii::$app->params[$type]['maxExc']))
        {
            return true;
        }

        return in_array($ext, Yii::$app->params[$type]['maxExc']);
    }

    /**
     * 获取文件路径
     *
     * @param $type
     * @return string
     */
    public function getPath($type)
    {
        // 文件路径
        $file_path = Yii::$app->params[$type]['path'];
        // 子路径
        $sub_name = Yii::$app->params[$type]['subName'];
        $path = $file_path . date($sub_name,time()) . "/";
        $add_path = Yii::getAlias("@attachment/") . $path;
        // 创建路径
        FileHelper::mkdirs($add_path);
        return $path;
    }
}