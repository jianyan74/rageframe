<?php
namespace api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;

/**
 * Index controller
 */
class AController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        /*
        $behaviors['authenticator'] = [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                        # 下面是三种验证access_token方式
                        //HttpBasicAuth::className(),
                        //HttpBearerAuth::className(),
                        # 这是GET参数验证的方式
                        # http://10.10.10.252:600/user/index/index?access-token=xxxxxxxxxxxxxxxxxxxx
                        QueryParamAuth::className(),
                ],

        ];
        */

        #定义返回格式是：JSON
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }
}
