<?php

namespace backend\modules\sys\controllers;

use yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use common\models\sys\Article;
use common\models\sys\Tag;
use common\models\sys\TagMap;
use backend\controllers\MController;

/**
 * 文章管理控制器
 * Class ArticleController
 * @package backend\modules\sys\controllers
 */
class ArticleController extends MController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'upload' => Yii::$app->params['ueditorConfig']
        ];
    }

    /**
     * 首页
     */
    public function actionIndex()
    {
        $request  = Yii::$app->request;
        $type     = $request->get('type',1);
        $keyword  = $request->get('keyword');
        $cate_stair  = $request->get('cate_stair','');
        $cate_second  = $request->get('cate_second','');

        $where = [];
        if($keyword)
        {
            if($type == 1)
            {
                $where = ['like', 'title', $keyword];//标题
            }
        }

        $data = Article::find()->where($where)->andFilterWhere(['display'=>Article::DISPLAY_ON]);
        !empty($cate_stair) && $data->andWhere(['cate_stair'=>$cate_stair]);
        !empty($cate_second) && $data->andWhere(['cate_second'=>$cate_second]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('sort asc,append desc')
            ->limit($pages->limit)
            ->all();

        return $this->render('index',[
            'models'  => $models,
            'pages'   => $pages,
            'type'    => $type,
            'keyword' => $keyword,
            'cate_stair' => $cate_stair,
            'cate_second' => $cate_second,

        ]);
    }

    /**
     * 编辑/新增
     * @return string|\yii\web\Response
     */
    public function actionEdit()
    {
        $request        = Yii::$app->request;
        $article_id     = $request->get('article_id');
        $model          = $this->findModel($article_id);

        //文章标签
        $tags = Tag::find()->with([
            'tagMap' => function($query) {
                $article_id  = Yii::$app->request->get('article_id');
                $query->andWhere(['article_id' => $article_id]);
            },])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            //更新文章标签
            $article_id = $article_id ? $article_id : Yii::$app->db->getLastInsertID();

            TagMap::addTags($article_id,$request->post('tag'));

            return $this->redirect(['index']);
        }

        return $this->render('edit', [
            'model'     => $model,
            'tags'      => $tags,
        ]);
    }

    /**
     * ajax修改
     * @return array
     */
    public function actionUpdateAjax()
    {
        $id = Yii::$app->request->get('id');
        return $this->updateModelData($this->findModel($id));
    }

    /**
     * 逻辑删除
     * @param $article_id
     * @return mixed
     */
    public function actionHide($article_id)
    {
        $model = $this->findModel($article_id);
        $model->display = Article::DISPLAY_OFF;

        if($model->save())
        {
            return $this->message("删除成功",$this->redirect(['index']));
        }
        else
        {
            return $this->message("删除失败",$this->redirect(['index']),'error');
        }
    }

    /**
     * 还原
     * @param $article_id
     * @return mixed
     */
    public function actionShow($article_id)
    {
        $model = $this->findModel($article_id);
        $model->display = Article::DISPLAY_ON;

        if($model->save())
        {
            return $this->message("还原成功",$this->redirect(['recycle']));
        }
        else
        {
            return $this->message("还原失败",$this->redirect(['recycle']),'error');
        }
    }

    /**
     * 回收站
     * @return string
     */
    public function actionRecycle()
    {
        $request  = Yii::$app->request;
        $type     = $request->get('type',1);
        $keyword  = $request->get('keyword');
        $cate_stair  = $request->get('cate_stair','');
        $cate_second  = $request->get('cate_second','');

        $where = [];
        if($keyword)
        {
            if($type == 1)
            {
                $where = ['like', 'title', $keyword];//标题
            }
        }

        $data = Article::find()->where($where)->andFilterWhere(['display'=>Article::DISPLAY_OFF]);
        !empty($cate_stair) && $data->andWhere(['cate_stair'=>$cate_stair]);
        !empty($cate_second) && $data->andWhere(['cate_second'=>$cate_second]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('sort asc,append desc')
            ->limit($pages->limit)
            ->all();

        return $this->render('recycle',[
            'models'  => $models,
            'pages'   => $pages,
            'type'    => $type,
            'keyword' => $keyword,
            'cate_stair' => $cate_stair,
            'cate_second' => $cate_second,

        ]);
    }

    /**
     * 删除
     * @param null $article_id
     * @return mixed
     */
    public function actionDelete($article_id)
    {
        if($this->findModel($article_id)->delete())
        {
            return $this->message("删除成功",$this->redirect(['recycle']));
        }
        else
        {
            return $this->message("删除失败",$this->redirect(['recycle']),'error');
        }
    }

    /**
     * 一键清空
     * @return mixed
     */
    public function actionDeleteAll()
    {
        Article::deleteAll(['display'=>Article::DISPLAY_OFF]);
        return $this->message("清空成功",$this->redirect(['recycle']));
    }

    /**
     * 返回模型
     * @param $id
     * @return $this|Article|static
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            $model = new Article;
            return $model->loadDefaultValues();
        }

        if (empty(($model = Article::findOne($id))))
        {
            return new Article;
        }

        return $model;
    }
}