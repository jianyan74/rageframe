<?php
namespace backend\rbac;

use Yii;
use yii\rbac\Rule;
use jianyan\basics\common\models\sys\Article;

/**
 * Class ArticleRule
 * @package backend\controllers
 */
class ArticleRule extends Rule
{
    public $name = 'article';

    /**
     * @param int|string $user当前登录用户的uid
     * @param \yii\rbac\Item $item 所属规则rule，也就是我们后面要进行的新增规则
     * @param array $params 当前请求携带的参数.
     * @return bool true用户可访问 false用户不可访问
     */
    public function execute($user, $item, $params)
    {
        $id = Yii::$app->request->get('id','');
        if ($id)
        {
            $model = Article::findOne($id);
            if ($model)
            {
                //管理员是否不受限制
                //$role = Yii::$app->user->identity->role;
                //if ($role == Manager::ROLE_ADMIN)
                //{
                //    return true;
                //}

                if ($user == $model->manager_id)
                {
                    return true;
                }
            }

            return false;
        }

        return true;
    }
}