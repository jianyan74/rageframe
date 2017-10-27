<?php
namespace api\modules\v1\controllers;

use api\controllers\AController;

/**
 * Class DefaultController
 * @package api\modules\v1\controllers
 */
class DefaultController extends AController
{
    public $modelClass = 'common\models\member\Member';

    /**
     * 测试
     * @return string
     */
    public function actionSearch()
    {
        return '测试查询';
    }
}
