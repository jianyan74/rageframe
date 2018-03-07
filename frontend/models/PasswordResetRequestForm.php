<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\member\Member;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        Yii::$app->set('mailer', [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => Yii::$app->config->info('MAILER_HOST'),
                'username' => Yii::$app->config->info('MAILER_USERNAME'),
                'password' => Yii::$app->config->info('MAILER_PASSWORD'),
                'port' => Yii::$app->config->info('MAILER_PORT'),
                'encryption' => empty(Yii::$app->config->info('MAILER_ENCRYPTION')) ? 'tls' : 'ssl',
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\member\Member',
                'filter' => ['status' => Member::STATUS_ACTIVE],
                'message' => '找不到该邮箱.'
            ],
        ];
    }

    /**
     * 发送密码到邮箱
     *
     * @return bool
     * @throws \yii\base\Exception
     */
    public function sendEmail()
    {
        /* @var $user Member */
        $user = Member::findOne([
            'status' => Member::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user)
        {
            if (!Member::isPasswordResetTokenValid($user->password_reset_token))
            {
                $user->generatePasswordResetToken();
            }

            if ($user->save())
            {
                return Yii::$app->mailer->compose('passwordResetToken', ['user' => $user])
                    ->setFrom([Yii::$app->config->info('MAILER_USERNAME') => Yii::$app->config->info('MAILER_NAME')])
                    ->setTo($this->email)
                    ->setSubject(Yii::$app->config->info('MAILER_NAME').'密码重置信息')
                    ->send();
            }
        }

        return false;
    }
}
