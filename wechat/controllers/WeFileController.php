<?php
namespace wechat\controllers;

use Yii;
use common\helpers\StringHelper;
use common\helpers\FileHelper;

/**
 * 微信文件上传控制器
 *
 * Class WeFileController
 * @package wechat\controllers
 */
class WeFileController extends WController
{
    /**
     * 图片配置名称
     */
    const IMAGES_CONFIG = 'imagesUpload';

    /**
     * 下载微信图片
     *
     * @param $media_id
     * @return array
     */
    public function actionDownloadImage()
    {
        $result = $this->setResult();
        $uploadConfig = Yii::$app->params[self::IMAGES_CONFIG];

        $media_id = Yii::$app->request->post('media_id');
        $stream = $this->_app->media->get($media_id);

        // 图片后缀
        $file_exc = ".jpg";
        // 图片路径
        $file_path = $this->getPath(self::IMAGES_CONFIG);
        // 保存的图片名
        $file_new_name  = $uploadConfig['prefix'] . StringHelper::random(10) . $file_exc;
        // 完整路径
        $file_path_full = Yii::getAlias("@attachment/") . $file_path;

        // 移动文件
        if (! $stream->save($file_path_full, $file_new_name)) // 移动失败
        {
            $result->message = '上传失败';
        }
        else // 移动成功
        {
            $result->code = 200;
            $result->message = '上传成功';
            $result->data = [
                'path' => Yii::getAlias("@attachurl/") . $file_path . $file_new_name
            ];
        }

        return $this->getResult();
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
