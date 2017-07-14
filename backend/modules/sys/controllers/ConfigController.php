<?php
namespace backend\modules\sys\controllers;

use yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use common\models\sys\Config;
use common\models\sys\ConfigCate;
use common\helpers\SysArrayHelper;
use backend\controllers\MController;

/**
 * 系统配置控制器
 * Class ConfigController
 * @package backend\modules\sys\controllers
 */
class ConfigController extends MController
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
        $cate  = Yii::$app->request->get('cate',0);

        $where = [];
        if($cate)
        {
            $where['cate'] = $cate;
        }

        $data = Config::find()
            ->where($where)
            ->with('cateChild');
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('cate asc,sort asc')
            ->limit($pages->limit)
            ->all();

        return $this->render('index',[
            'models'    => $models,
            'pages'     => $pages,
            'cate'     => $cate,
            'configCate' => ConfigCate::getListRoot(),
        ]);
    }

    /**
     * 编辑/新增
     * @return string|\yii\web\Response
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $id       = $request->get('id');
        $model    = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index','cate' => $model->cate]);
        }

        return $this->render('edit', [
            'model'           => $model,
            'configTypeList'  => Yii::$app->params['configTypeList'],
        ]);
    }

    /**
     * 编辑全部
     * @return string|\yii\web\Response
     */
    public function actionEditAll()
    {
        //所有的配置信息
        $list = Config::find()
            ->orderBy('sort asc')
            ->asArray()
            ->all();

        //获取全部分类并压缩到分类中
        $configCateAll = ConfigCate::getListAll();
        foreach ($configCateAll as &$item)
        {
            foreach ($list as $vo)
            {
                if($item['id'] == $vo['cate_child'])
                {
                    $item['config'][] = $vo;
                }
            }
        }

        return $this->render('edit-all', [
            'configCateAll' => SysArrayHelper::itemsMerge($configCateAll),
        ]);
    }

    /**
     * 删除
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete())
        {
            return $this->message("删除成功",$this->redirect(['index']));
        }
        else
        {
            return $this->message("删除失败",$this->redirect(['index']),'error');
        }
    }

    /**
     * ajax批量更新数据
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionUpdateInfo()
    {
        $request = Yii::$app->request;
        if($request->isAjax)
        {
            Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

            $result = [];
            $result['flg'] = 1;
            $result['msg'] = "保存成功";

            $config    = $request->post('config');

            foreach ($config as $key => $value)
            {
                $model = Config::find()->where(['name'=>$key])->one();

                if($model)
                {
                    $model->value = is_array($value) ? serialize($value) : $value;
                    if(!$model->save())
                    {
                        $result['flg'] = 2;
                        $result['msg'] = $this->analysisError($model->getFirstErrors());
                        return $result;
                    }
                }
                else
                {
                    $result['flg'] = 2;
                    $result['msg'] = "配置不存在,请刷新页面";
                    return $result;
                }
            }

            return $result;
        }
        else
        {
            throw new NotFoundHttpException('请求出错!');
        }
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
     * 返回模型
     * @param $id
     * @return $this|Config|static
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            $model = new Config;
            return $model->loadDefaultValues();
        }

        if (empty(($model = Config::findOne($id))))
        {
            return new Config;
        }

        return $model;
    }

}