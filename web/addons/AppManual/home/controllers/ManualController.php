<?php
namespace addons\AppManual\home\controllers;

use yii;
use common\components\Addons;
use common\helpers\SysArrayHelper;
use addons\AppManual\common\models\AppManual;

/**
 * 开发手册(文档)控制器
 * Class ManualController
 * @package addons\AppManual\home\controllers
 */
class ManualController extends Addons
{
    public $name;

    /**
     * @return string
     * 首页
     */
    public function actionIndex()
    {
        $this->name = Yii::$app->request->get('name','');

        //导航
        $models = AppManual::find()
            ->where(['status' => 1])
            ->orderBy('pid asc,sort asc,append asc')
            ->asArray()
            ->all();

        //当前的记录
        $manual = [];
        foreach ($models as $model)
        {
            if($this->name == $model['name'])
            {
                $manual = $model;
            }
        }

        if(!$this->name)
        {
            $model = AppManual::find()
                ->where(['status' => 1])
                ->andWhere(['>','pid',0])
                ->orderBy('append asc')
                ->asArray()
                ->one();

            $manual = $model;
            $this->name = $model['name'];
        }

        AppManual::updateAllCounters(['view' => 1],['name' => $this->name]);

        return $this->renderAddon('index', [
            'models' => SysArrayHelper::itemsMerge($models,'id'),
            'name' => $this->name,
            'manual' => $manual,
            'path' => $this->_path,
        ]);
    }
}
