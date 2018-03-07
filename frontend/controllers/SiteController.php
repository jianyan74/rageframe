<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\models\member\Member;
use common\models\member\Auth;
use frontend\models\LoginForm;
use frontend\models\RegisterForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        //第三方登录
        Yii::$app->set('authClientCollection', [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'qq' => [
                    'class' => 'common\widgets\QQClient',
                    'clientId' => Yii::$app->config->info('QQ_CLIENT_APPID'),
                    'clientSecret' => Yii::$app->config->info('QQ_CLIENT_APPKEY'),
                ],
                'weibo' => [
                    'class' => 'common\widgets\WeiboClient',
                    'clientId' => Yii::$app->config->info('WEIBO_CLIENT_APPID'),
                    'clientSecret' => Yii::$app->config->info('WEIBO_CLIENT_APPKEY'),
                ],
                'weixin' => [
                    'class' => 'common\widgets\WeiXinClient',
                    'clientId' => Yii::$app->config->info('WEIXIN_CLIENT_APPID'),
                    'clientSecret' => Yii::$app->config->info('WEIXIN_CLIENT_APPKEY'),
                ],
                'github' => [
                    'class' => 'yii\authclient\clients\GitHub',
                    'clientId' => Yii::$app->config->info('GITHUB_CLIENT_APPID'),
                    'clientSecret' => Yii::$app->config->info('GITHUB_CLIENT_APPKEY'),
                ],
            ],
        ]);
    }

    /**
     * @inheritdoc
     * 错误提示跳转页面
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * oauth登陆
     *
     * @param $client
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();

        /* @var $auth Auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->user->isGuest)
        {
            if ($auth)   // 登录
            {
                $member = $auth->member;
                Yii::$app->user->login($member);
            }
            else  // 注册
            {
                if (isset($attributes['email']) && Member::find()->where(['email' => $attributes['email']])->exists())
                {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $client->getTitle()]),
                    ]);
                }
                else
                {
                    $password = Yii::$app->security->generateRandomString(6);
                    $member = new Member([
                        'username' => $attributes['login'],
                        'email' => $attributes['email'],
                        'password' => $password,
                    ]);
                    $member->generateAuthKey();
                    $member->generatePasswordResetToken();
                    $transaction = $member->getDb()->beginTransaction();
                    if ($member->save())
                    {
                        $auth = new Auth([
                            'member_id' => $member->id,
                            'source' => $client->getId(),
                            'source_id' => (string)$attributes['id'],
                        ]);
                        if ($auth->save())
                        {
                            $transaction->commit();
                            Yii::$app->user->login($member);
                        }
                        else
                        {
                            print_r($auth->getErrors());
                        }
                    } else
                    {
                        print_r($member->getErrors());
                    }
                }
            }
        }
        else // 用户已经登陆
        {
            if (!$auth)
            {
                // 添加验证提供商（向验证表中添加记录）
                $auth = new Auth([
                    'member_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
    }

    /**
     * 登陆
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            return $this->goHome();
        }

        return $this->render('login', [
            'model'  => $model,
        ]);
    }

    /**
     * 注册
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($user = $model->signup())
            {
                Yii::$app->user->login($user);
                return $this->goHome();
            }
        }

        return $this->render('register', [
            'model'  => $model,
        ]);
    }

    /**
     * 退出登陆
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * 忘记密码
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->sendEmail())
            {
                Yii::$app->getSession()->setFlash('success', '请登陆您的邮箱查看.');

                return $this->goHome();
            }
            else
            {
                Yii::$app->getSession()->setFlash('error', '对不起,我们无法重置密码邮件提供');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * 修改密码
     *
     * @param $token
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try
        {
            $model = new ResetPasswordForm($token);
        }
        catch (InvalidParamException $e)
        {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword())
        {
            Yii::$app->session->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
