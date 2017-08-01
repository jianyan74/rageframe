<?php

namespace common\widgets;

use yii\authclient\OAuth2;

class QQClient extends OAuth2
{
    public $authUrl = 'https://graph.qq.com/oauth2.0/authorize';

    public $tokenUrl = 'https://graph.qq.com/oauth2.0/token';

    public $apiBaseUrl = 'https://graph.qq.com';


    protected function initUserAttributes()
    {
        $user = $this->api('user/get_user_info', 'GET', ['oauth_consumer_key' => $this->user->client_id, 'openid' => $this->user->openid]);

        return [
            'client' => 'qq',
            'openid' => $this->user->openid,
            'nickname' => $user['nickname'],
            'gender' => $user['gender'],
            'location' => $user['province'] . $user['city'],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getUser()
    {
        $str = file_get_contents('https://graph.qq.com/oauth2.0/me?access_token=' . $this->accessToken->token);

        if (strpos($str, "callback") !== false) {
            $lpos = strpos($str, "(");
            $rpos = strrpos($str, ")");
            $str = substr($str, $lpos + 1, $rpos - $lpos -1);
        }

        return json_decode($str);
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'QQ';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return 'QQ 登录';
    }
}