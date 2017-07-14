<?php
namespace backend\modules\sys\models;

use Yii;
use yii\base\Model;
use common\models\sys\Manager;

/**
 * 修改密码
 */
class PasswdForm extends Model
{
    public $passwd;
    public $passwd_new;
    public $passwd_repetition;

    private $_user;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['passwd', 'passwd_new', 'passwd_repetition'], 'filter', 'filter' => 'trim'],
            [['passwd', 'passwd_new', 'passwd_repetition'], 'required'],
            [['passwd', 'passwd_new', 'passwd_repetition'], 'string', 'min' => 6, 'max' => 15],
            [['passwd_repetition'], 'compare','compareAttribute'=>'passwd_new'],//验证新密码和重复密码是否相等
            ['passwd', 'validatePassword'],
            ['passwd_new', 'notCompare'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'passwd'            => '原密码',
            'passwd_new'        => '新密码',
            'passwd_repetition' => '重复密码',
        ];
    }

    public function notCompare($attribute)
    {
        if ($this->passwd == $this->passwd_new)
        {
            $this->addError($attribute, '新密码不能和原密码相同');
        }
    }

    /**
     * @param $attribute
     * @param $params
     * 验证原密码是否正确
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->passwd))
            {
                $this->addError($attribute, '原密码不正确');
            }
        }
    }

    /**
     * @return mixed|null|static
     * 获取用户信息
     */
    protected function getUser()
    {
        $username = Yii::$app->user->identity->username;

        if ($this->_user === null)
        {
            $this->_user = Manager::findByUsername($username);
        }

        return $this->_user;
    }
}
