<?php
namespace frontend\models;

use Yii;
use common\models\member\Member;

/**
 * Login form
 */
class RegisterForm extends \common\models\base\LoginForm
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => '{attribute}只能为数字和字母'],
            ['username', 'unique', 'targetClass' => '\common\models\member\Member', 'message' => '此{attribute}已经被使用'],
            ['username', 'string', 'min' => 4, 'max' => 12],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\member\Member', 'message' => '此{attribute}已经被使用'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'   => '账号',
            'password'   => '登录密码',
            'email'   => '邮箱',
        ];
    }

    /**
     * @param $attribute
     */
    public function validateUser($attribute)
    {
        if($this->getUser())
        {
            if($this->_user)
            {
                $this->addError($attribute,'该账号已经被注册');
            }
        }
    }

    /**
     * @return mixed
     */
    protected function getUser()
    {
        if ($this->_user === null)
        {
            $this->_user = Member::findByUsername($this->username);
        }

        return $this->_user;
    }
}
