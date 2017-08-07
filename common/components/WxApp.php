<?php
namespace common\components;

use yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use EasyWeChat\Foundation\Application;
use common\controllers\BaseController;
use common\models\wxapp\Account;
use common\models\wechat\Fans;

/**
 * 微信小程序基类
 * Class WxApp
 * @package common\components
 */
class WxApp extends BaseController
{
    /**
     * @var
     */
    protected $_app;

    /**
     * 当前模块名称
     * @var
     */
    protected $_addon_name;

    /**
     * @var
     */
    protected $_account;

    /**
     * @var
     */
    protected $_account_id;

    /**
     * 自动运行
     */
    public function init()
    {
        $request  = Yii::$app->request;
        $this->_addon_name = $request->get('addon','');
        $this->_account_id = $request->get('account_id','');
        !$this->_addon_name && $this->_addon_name = $request->post('addon','');
        !$this->_account_id && $this->_account_id = $request->post('account_id','');

        $this->_account = Account::getAccount($this->_account_id,$this->_addon_name);
        if($this->_account)
        {
            $options = [
                'mini_program' => [
                    'app_id'   => $this->_account['key'],
                    'secret'   => $this->_account['secret'],
                    // token 和 aes_key 开启消息推送后可见
                    'token'    => $this->_account['token'],
                    'aes_key'  => $this->_account['encodingaeskey']
                ],
            ];

            $this->_app = new Application($options);
        }

        return true;
    }

    /**
     * 通过 Code 换取 SessionKey
     * @return mixed
     */
    public function actionGetSessionKey()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $code = Yii::$app->request->get('code','');
        if(!$code)
        {
            $this->result['message'] = '通信错误,请在微信重新发起请求';
            return $this->result;
        }

        if($this->_app)
        {
            $oauth = $this->_app->mini_program->sns->getSessionKey($code);

            $this->result['code'] = 0;
            $this->result['message'] = '获取成功';
            $this->result['data'] = $this->setAuth($oauth);
            return $this->result;
        }

        $this->result['message'] = '小程序找不到了';
        return $this->result;
    }

    /**
     * 加密数据进行解密
     */
    public function actionDecode()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request  = Yii::$app->request;

        $iv = $request->post('iv','');
        $encryptedData = $request->post('encryptedData','');
        $auth_key = $request->post('auth_key','');
        $oauth = $this->getAuth($auth_key);

        if(!$this->_app)
        {
            $this->result['message'] = '小程序找不到了';
            return $this->result;
        }

        if(empty($iv) || empty($encryptedData) || empty($oauth))
        {
            $this->result['message'] = '请先登录';
            return $this->result;
        }

        $sign = sha1(htmlspecialchars_decode($request->post('rawData').$oauth['session_key']));
        if ($sign !== $request->post('signature'))
        {
            $this->result['message'] = '签名错误';
            return $this->result;
        }

        $miniProgram = $this->_app->mini_program;
        $userinfo = $miniProgram->encryptor->decryptData($oauth['session_key'], $iv, $encryptedData);

        $openid = $userinfo['openId'];
        if(empty($fans = Fans::getFans($openid)))
        {
            Fans::addWxAppFans($userinfo);
        }

        unset($userinfo['watermark']);

        $this->result['code'] = 0;
        $this->result['message'] = '获取成功';
        $this->result['data'] = $userinfo;
        return $this->result;
    }

    /**
     * 生成auth_key并缓存
     * @param $oauth
     * @return int
     */
    protected function setAuth($oauth)
    {
        $auth_key = Yii::$app->security->generateRandomString();

        Yii::$app->cache->set($auth_key,ArrayHelper::toArray($oauth));

        return $auth_key;
    }

    /**
     * 获取用户信息
     * @param $auth_key
     * @return mixed
     */
    protected function getAuth($auth_key)
    {
       return Yii::$app->cache->get($auth_key);
    }
}