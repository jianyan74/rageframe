<?php
namespace common\controllers;

use Yii;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\BadRequestHttpException;

/**
 * Class ActiveController
 * @package common\controllers
 */
class ActiveController extends \yii\rest\ActiveController
{
    /**
     * 行为验证
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        //跨域支持
        $behaviors['class'] = Cors::className();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                /*下面是三种验证access_token方式*/
                //1.HTTP 基本认证: access token 当作用户名发送，应用在access token可安全存在API使用端的场景，例如，API使用端是运行在一台服务器上的程序。
                //HttpBasicAuth::className(),
                //2.OAuth : 使用者从认证服务器上获取基于OAuth2协议的access token，然后通过 HTTP Bearer Tokens 发送到API 服务器。
                //HttpBearerAuth::className(),
                //3.请求参数: access token 当作API URL请求参数发送，这种方式应主要用于JSONP请求，因为它不能使用HTTP头来发送access token
                //http://rageframe.com/user/index/index?access-token=123
                [
                    'class' => QueryParamAuth::className(),
                    'tokenParam' => 'accessToken'
                ],
            ],
            'optional' => [
                'login',
            ],
        ];

        /**
         * limit部分，速度的设置是在User::getRateLimit($request, $action)
         * 当速率限制被激活，默认情况下每个响应将包含以下HTTP头发送 目前的速率限制信息：
         * X-Rate-Limit-Limit: 同一个时间段所允许的请求的最大数目;
         * X-Rate-Limit-Remaining: 在当前时间段内剩余的请求的数量;
         * X-Rate-Limit-Reset: 为了得到最大请求数所等待的秒数。
         * 你可以禁用这些头信息通过配置 yii\filters\RateLimiter::enableRateLimitHeaders 为false, 就像在上面的代码示例所示。
         */
        $behaviors['rateLimiter']['enableRateLimitHeaders'] = false;
        //定义返回格式是：JSON
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
     * 前置操作验证token有效期
     * @param \yii\base\Action $action
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);

        $token = Yii::$app->request->get('accessToken');
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.accessTokenExpire'];

        //判断验证token有效性是否开启
        if(Yii::$app->params['user.accessTokenValidity'] == true)
        {
            //验证有效期
            if($timestamp + $expire >= time())
            {
                throw new BadRequestHttpException('请重新登陆');
            }
        }

        return true;
    }

    /**
     * 返回模型验证失败
     * @param $message
     */
    public function setResponse($message)
    {
        $this->response = Yii::$app->getResponse();
        $this->response->setStatusCode(422, $message);
    }

    /**
     * 解析Yii2错误信息
     * @param $errors
     * @return string
     */
    protected function analysisError($errors)
    {
        $errors = array_values($errors)[0];
        return $errors ? $errors : '操作失败';
    }

    /**
     * 打印调试
     * @param $array
     */
    protected function p($array)
    {
        echo "<pre>";
        print_r($array);
    }
}
