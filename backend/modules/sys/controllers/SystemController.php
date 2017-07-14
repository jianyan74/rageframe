<?php
namespace backend\modules\sys\controllers;

use Yii;
use backend\controllers\MController;
use backend\modules\sys\models\Menu;

/**
 * 系统菜单控制器
 * Class SystemController
 * @package backend\modules\sys\controllers
 */
class SystemController extends MController
{
    /**
     * 主体框架
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'models' => Menu::getMenus(Menu::TYPE_SYS,Menu::STATUS_ON),
        ]);
    }

    /**
     * 系统信息
     */
    public function actionInfo()
    {
        $db      = Yii::$app->db;
        $models  = $db->createCommand('SHOW TABLE STATUS')->queryAll();
        $models  = array_map('array_change_key_case', $models);

        //数据库大小
        $mysqlSize = 0;
        foreach ($models as $model)
        {
            $mysqlSize += $model['data_length'];
        }

        return $this->render('info', [
            'models' => Menu::getMenus(Menu::TYPE_SYS,Menu::STATUS_ON),
            'mysqlSize' => $mysqlSize,
        ]);
    }
}