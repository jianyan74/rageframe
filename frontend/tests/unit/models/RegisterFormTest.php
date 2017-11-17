<?php
namespace frontend\tests\unit\models;

use frontend\fixtures\UserFixture;
use frontend\models\RegisterForm;

class RegisterFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    /**
     * 插入数据
     */
    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    /**
     * 测试正确的注册
     */
    public function testCorrectSignup()
    {
        $model = new RegisterForm([
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
        ]);

        $user = $model->signup();

        expect($user)->isInstanceOf('common\models\member\Member');

        expect($user->username)->equals('some_username');
        expect($user->email)->equals('some_email@example.com');
        expect($user->validatePassword('some_password'))->true();
    }

    /**
     * 测试不正确的注册
     */
    public function testNotCorrectSignup()
    {
        $model = new RegisterForm([
            'username' => 'troy.becker',
            'email' => 'nicolas.dianna@hotmail.com',
            'password' => 'some_password',
        ]);

        expect_not($model->signup());
        expect_that($model->getErrors('username'));
        expect_that($model->getErrors('email'));

        expect($model->getFirstError('username'))
            ->equals('此用户名已被占用.');
        expect($model->getFirstError('email'))
            ->equals('这个电子邮件地址已被占用.');
    }
}
