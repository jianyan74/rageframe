<?php
namespace wechat\controllers;

use Yii;
use yii\web\Response;
use common\helpers\StringHelper;
use common\helpers\FileHelper;

/**
 * 微信文件上传控制器
 * Class WeFileController
 * @package wechat\controllers
 */
class WeFileController extends WController
{
    public function init()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    }

    /**
     * 下载微信图片
     * @param $media_id
     * @return array
     */
    public function actionDownloadImage()
    {
        $media_id = Yii::$app->request->post('media_id');

        $temporary = $this->_app->material_temporary;
        $content = $temporary->getStream($media_id);

        $file_exc   = ".jpg";//图片后缀
        $file_path      = $this->getImgPath();//图片路径
        $file_new_name  = Yii::$app->params['imagesUpload']['imgPrefix'].StringHelper::random(10).$file_exc;//保存的图片名

        $filePath = Yii::getAlias("@attachment/").$file_path.$file_new_name;

        //移动文件
        if (!(file_put_contents($filePath, $content) && file_exists($filePath))) //移动失败
        {
            $this->result['data'] = '上传失败';
            return $this->result;
        }
        else //移动成功
        {
            $model = Yii::$app->user->identity;
            $model->student_cover = Yii::getAlias("@attachurl/").$file_path.$file_new_name;
            $model->save();

            $this->result = [
                'code' => 0,
                'message' => '上传成功',
                'data' => Yii::getAlias("@attachurl/").$file_path.$file_new_name,
            ];
        }

        return $this->result;
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
}
