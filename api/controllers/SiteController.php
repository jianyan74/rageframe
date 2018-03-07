<?php
namespace api\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use api\models\LoginForm;
use common\models\base\AccessToken;

/**
 * 默认登录控制器
 *
 * Class SiteController
 * @package api\controllers
 */
class SiteController extends AController
{
    public $modelClass = '';

    /**
     * 登录根据用户信息返回accessToken
     *
     * 默认是系统会员
     * 其他类型自行扩展
     *
     * @param int $group 组别 默认是1
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionLogin($group = 1)
    {
        if(Yii::$app->request->isPost)
        {
            $model = new LoginForm();
            $model->attributes = Yii::$app->request->post();
            if($model->validate())
            {
                $user = $model->getUser();
                return AccessToken::setMemberInfo($group, $user['id']);
            }
            else
            {
                // 返回数据验证失败
                return $this->setResponse($this->analysisError($model->getFirstErrors()));
            }
        }

        throw new NotFoundHttpException('请求出错!');
    }

    /**
     * 重置令牌
     *
     * @param $refresh_token
     * @return array
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionRefresh($refresh_token)
    {
        $user = AccessToken::find()
            ->where(['refresh_token' => $refresh_token])
            ->one();

        if (!$user)
        {
            throw new NotFoundHttpException('令牌错误，找不到用户!');
        }

        return AccessToken::setMemberInfo($user['group'], $user['user_id']);
    }

    // ....可以是设置其他用户登陆
}
