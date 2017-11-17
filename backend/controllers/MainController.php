<?php
namespace backend\controllers;

use Yii;
use jianyan\basics\common\models\sys\Manager;

/**
 * 主控制器
 *
 * Class MainController
 * @package backend\controllers
 */
class MainController extends MController
{
    /**
     * 主体框架
     */
    public function actionIndex()
    {
        // 用户ID
        $id = Yii::$app->user->id;
        $user = Manager::find()
            ->where(['id' => $id])
            ->with('assignment')
            ->asArray()
            ->one();

        return $this->renderPartial('@basics/backend/views/main/index',[
            'user'  => $user,
        ]);
    }

    /**
     * 系统首页
     */
    public function actionSystem()
    {
        return $this->render('system',[

        ]);
    }

}