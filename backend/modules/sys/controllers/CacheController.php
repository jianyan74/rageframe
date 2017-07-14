<?php
namespace backend\modules\sys\controllers;

use yii;
use backend\controllers\MController;

/**
 * Class CacheController
 * @package backend\modules\sys\controllers
 * 缓存清理控制器
 */
class CacheController extends MController
{
    /**
     * 清理缓存
     */
    public function actionClear()
    {
        //删除文件缓存
        Yii::$app->cache->flush();

        //删除备份缓存
        $path   = Yii::$app->params['dataBackupPath'];
        $lock   = realpath($path) . DIRECTORY_SEPARATOR.Yii::$app->params['dataBackLock'];
        array_map("unlink", glob($lock));

        return $this->render('clear',[
        ]);
    }
}