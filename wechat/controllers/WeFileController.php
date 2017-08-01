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
        //获取图片信息
        $content = $temporary->getStream($media_id);
        //图片后缀
        $file_exc   = ".jpg";
        //图片路径
        $file_path      = $this->getImgPath();
        //保存的图片名
        $file_new_name  = Yii::$app->params['imagesUpload']['imgPrefix'].StringHelper::random(10).$file_exc;
        //完整路径
        $file_path_full = Yii::getAlias("@attachment/").$file_path.$file_new_name;

        //移动文件
        if (!(file_put_contents($file_path_full, $content) && file_exists($file_path_full))) //移动失败
        {
            $this->result['data'] = '上传失败';
            return $this->result;
        }
        else //移动成功
        {
            $this->result = [
                'code' => 0,
                'message' => '上传成功',
                'data' => Yii::getAlias("@attachurl/").$file_path.$file_new_name,
            ];
        }

        return $this->result;
    }

    /**
     * 获取图片路径
     * @param null $thumb
     * @return string
     */
    public function getImgPath($thumb = null)
    {
        $file_path   = empty($thumb) ? Yii::$app->params['imagesUpload']['imgPath'] : Yii::$app->params['imagesUpload']['imgThumbPath'];//图片路径
        $img_sub_name  = Yii::$app->params['imagesUpload']['imgSubName'];//图片子路径
        $path    = $file_path.date($img_sub_name,time())."/";
        $addPath = Yii::getAlias("@attachment/").$path;
        FileHelper::mkdirs($addPath);//创建路径

        return $path;
    }
}
