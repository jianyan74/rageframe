<?php
namespace backend\modules\sys\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\models\sys\Addons;
use common\models\sys\AddonsBinding;
use common\helpers\AddonsHelp;
use common\helpers\StringHelper;
use backend\controllers\MController;

/**
 * 插件控制器
 * Class AddonsController
 * @package backend\modules\sys\controllers
 */
class AddonsController extends MController
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
     * 已安装模块列表
     * @return mixed|string
     */
    public function actionUninstall()
    {
        $request  = Yii::$app->request;

        if($request->isPost)
        {
            $addonName = $request->get('name');
            //删除数据库
            $this->findModel($addonName)->delete();
            //验证模块信息
            $class = AddonsHelp::getAddonsClass($addonName);

            if(!class_exists($class))
            {
                return $this->message('卸载成功',$this->redirect(['uninstall']));
            }

            //卸载
            $addons = new $class;
            if(StringHelper::strExists($addons->uninstall,'.php'))
            {
                if($addons->uninstall && file_exists(AddonsHelp::getAddons($addonName) . $addons->uninstall))
                {
                    include_once AddonsHelp::getAddons($addonName).$addons->uninstall;
                }
            }

            return $this->message('卸载成功',$this->redirect(['uninstall']));
        }

        return $this->render('uninstall',[
            'list' => Addons::find()->all(),
        ]);
    }

    /**
     * 安装插件
     */
    public function actionInstall()
    {
        $request  = Yii::$app->request;

        $model = new Addons();
        if($request->isPost)
        {
            //开启事物
            $transaction = Yii::$app->db->beginTransaction();
            try
            {
                $addonName = $request->get('name');
                $class = AddonsHelp::getAddonsClass($addonName);

                if(!class_exists($class))
                {
                    throw new \Exception('实例化失败,插件不存在或检查插件名称');
                }

                $addons = new $class;
                //安装
                if(StringHelper::strExists($addons->install,'.php'))
                {
                    if($addons->install && file_exists(AddonsHelp::getAddons($addonName) . $addons->install))
                    {
                        include_once AddonsHelp::getAddons($addonName).$addons->install;
                    }
                }

                //添加入口
                isset($addons->bindings) && AddonsBinding::add($addons->bindings,$addonName);
                $model->attributes = $addons->info;
                $model->type = $addons->type ? $addons->type : 'other';
                $model->setting = $addons->setting ? Addons::SETTING_TRUE : Addons::SETTING_FALSE;
                $model->hook = $addons->hook ? Addons::HOOK_TRUE : Addons::HOOK_FALSE;
                $model->wechat_message = serialize($addons->wechatMessage);

                if($model->save())
                {
                    $transaction->commit();
                    return $this->message('安装成功',$this->redirect(['uninstall']));
                }
                else
                {
                    $error = $this->analysisError($model->getFirstErrors());
                    throw new \Exception($error);
                }
            }
            catch (\Exception $e)
            {
                $transaction->rollBack();
                return $this->message($e->getMessage(),$this->redirect(['install']),'error');
            }
        }

        return $this->render('install',[
            'list' => $model->getList()
        ]);
    }


    /**
     * 更新
     * @return mixed
     */
    public function actionUpgrade()
    {
        $request  = Yii::$app->request;
        $addonName = $request->get('name');
        $class = AddonsHelp::getAddonsClass($addonName);

        if(!class_exists($class))
        {
            return $this->message('实例化失败,插件不存在或检查插件名称',$this->redirect(['uninstall']),'error');
        }

        $addons = new $class;
        //更新
        if(StringHelper::strExists($addons->upgrade,'.php'))
        {
            if($addons->upgrade && file_exists(AddonsHelp::getAddons($addonName) . $addons->upgrade))
            {
                include_once AddonsHelp::getAddons($addonName).$addons->upgrade;
            }
        }

        return $this->message('更新数据成功',$this->redirect(['uninstall']));
    }

    /**
     * 创建
     * @return mixed|string
     */
    public function actionCreate()
    {
        $request  = Yii::$app->request;

        $model = new Addons();
        if($model->load($request->post()))
        {
            //全部post
            $allPost = $request->post();
            if(!is_writable(Yii::getAlias('@addons')))
            {
                return $this->message('您没有创建目录写入权限，无法使用此功能',$this->redirect(['create']),'error');
            }

            $model->name   =   trim($model->name);
            $addons_dir    =  Yii::getAlias('@addons');
            //创建目录结构
            $files          =   array();
            $addon_dir      =   "$addons_dir/{$model->name}/";
            $addon_name     =   "{$model->name}Addon.php";
            $files[]        =   $addon_dir;
            $files[]        =   "{$addon_dir}{$addon_name}";

            /**
             * 微信消息
             */
            $wechatMessage = '[';
            if($model->wechatMessage)
            {
                $files[] = "{$addon_dir}WechatMessage.php";

                foreach ($model->wechatMessage as $key => $value)
                {
                    $key >= 1 && $wechatMessage .= ',';
                    $wechatMessage .= "'{$value}'";
                }
            }
            $wechatMessage .= ']';

            $files[]    =   "{$addon_dir}Setting.php";
            $files[]    =   "{$addon_dir}common/";
            $files[]    =   "{$addon_dir}common/models/";
            $files[]    =   "{$addon_dir}common/models/{$model->name}.php";
            $files[]    =   "{$addon_dir}admin/";
            $files[]    =   "{$addon_dir}admin/controllers/";
            $files[]    =   "{$addon_dir}admin/controllers/{$model->name}Controller.php";
            $files[]    =   "{$addon_dir}admin/views/";
            $files[]    =   "{$addon_dir}home/";
            $files[]    =   "{$addon_dir}home/controllers/";
            $files[]    =   "{$addon_dir}home/controllers/{$model->name}Controller.php";
            $files[]    =   "{$addon_dir}home/views/";
            $model['install'] && $files[] = "{$addon_dir}{$model['install']}";
            $model['uninstall'] && $files[] = "{$addon_dir}{$model['uninstall']}";
            $model['upgrade'] && $files[] = "{$addon_dir}{$model['upgrade']}";
            AddonsHelp::createDirOrFiles($files);

            //钩子
            $hook = 'false';
            $hookStr = "";
            if($model->hook)
            {
                $hook = 'true';
                $hookStr = "
    /**
    * @param \$addons 模块名字
    * @param null \$config 参数
    * @return string
    */
    public function actionHook(\$addon,\$config = null)
    {
        return \$this->rederHook(\$addon,[
        ]);
    }";
            }

            //参数
            $setting = 'false';
            $settingStr = "";
            if($model->setting)
            {
                $setting = 'true';
                $settingStr = "
    /**
     * 配置默认首页
     * @return string
     */
    public function actionDisplay()
    {
        \$request  = Yii::\$app->request;
        if(\$request->isPost)
        {
            \$config = \$request->post();
            \$this->setConfig(\$config);
        }
        
        return \$this->renderAddon('index',[
            'config' => \$this->getConfig()
        ]);
    }
                ";
            }

            /*********************************必要配置文件*********************************/

            //导航
            $bindings = AddonsHelp::bindingsToString($allPost['bindings'],'cover');
            !empty($bindings) && $bindings .=",
            ";
            $bindings .= AddonsHelp::bindingsToString($allPost['bindings'],'menu');

            //配置信息
            $Addon = "<?php 
namespace addons\\{$model->name};

class {$model->name}Addon
{
    /**
     * 参数配置 
     * [true,false] 开启|关闭
     * 使用方法在当前文件下的Setting.php
     * @var bool
     */
    public \$setting = {$setting};
    
    /**
     * 钩子
     * [true,false] 开启|关闭
     * 使用方法在当前文件下的Setting.php
     * @var bool
     */
    public \$hook = {$hook};
    
    /**
     * 类别
     * @var string 
     * [
     *      'plug'      => \"功能插件\",  
     *      'business'  => \"主要业务\",
     *      'customer'  => \"客户关系\",
     *      'activity'  => \"营销及活动\",
     *      'services'  => \"常用服务及工具\",
     *      'biz'       => \"行业解决方案\",
     *      'h5game'    => \"H5游戏\",
     *      'other'     => \"其他\",
     * ]
     */
    public \$type = '{$model->type}';
    
     /**
     * 微信接收消息类别
     * @var array 
     */
    public \$wechatMessage = {$wechatMessage};
    
    /**
     * 配置信息
     * @var array
     */
    public \$info = [
        'name' => '{$model->name}',
        'title' => '{$model->title}',
        'description' => '{$model->description}',
        'author' => '{$model->author}',
        'version' => '{$model->version}'
    ];
    
    /**
     * 后台菜单
     * 例如
     *     public \$bindings = [
     *          'cover' => [
     *          ]，
     *         'menu' => [
     *             [
     *                  'title' => '碎片列表',
     *                  'route' => 'Debris/index',
     *                  'icon' => 'fa fa-weixin',
     *              ]
     *           ...
     *         ],
     *     ];
     * @var array
     */
    public \$bindings = [
            {$bindings}
    ];
    
    /**
     * 保存在当前模块的根目录下面
     * 例如 public \$install = 'install.php';
     * 安装SQL,只支持php文件
     * @var string
     */
    public \$install = '{$model['install']}';
    
    /**
     * 卸载SQL
     * @var string
     */
    public \$uninstall = '{$model['uninstall']}';
    
    /**
     * 更新SQL
     * @var string
     */
    public \$upgrade = '{$model['upgrade']}';
}
            ";

            /*********************************后台控制器*********************************/

            $AdminController = "<?php
namespace addons\\{$model->name}\\admin\\controllers;

use yii;
use common\\components\\Addons;
use addons\\{$model->name}\\common\\models\\{$model->name};

/**
 * {$model->title}控制器
 * Class {$model->name}Controller
 * @package addons\\{$model->name}\\admin\\controllers
 */
class {$model->name}Controller extends Addons
{
    /**
    * 首页
    */
    public function actionIndex()
    {
        return \$this->renderAddon('index',[
        ]);
    }
}
            ";

            /*********************************后台模型*********************************/

            $CommonModel = "<?php
namespace addons\\{$model->name}\\common\\models;

use Yii;
use yii\\db\\ActiveRecord;

class {$model->name} extends ActiveRecord
{

}
            ";

            /*********************************配置信息*********************************/

            $Setting = "<?php
namespace addons\\{$model->name};

use yii;
use common\\components\\Addons;
use addons\\{$model->name}\\common\\models\\{$model->name};

/**
 * 全局配置
 * Class Setting
 * @package addons\\{$model->name}
 */
class Setting extends Addons
{
    {$settingStr}
    {$hookStr}
}
            ";

            $WechatInfo = "<?php
namespace addons\\{$model->name};

use Yii;
use common\\components\\Addons;

/**
 * 微信消息控制箱
 * Class WechatMessage
 * @package addons\\{$model->name}
 */
class WechatMessage extends Addons
{
    /**
    * \$message -消息 
    */
    public function actionRespond(\$message)
    {
    	//这里定义此模块进行消息处理时的具体过程, 请查看有料文档来编写你的代码
    }
}
            
            ";
            //写入模块配置
            file_put_contents("{$addon_dir}{$model->name}Addon.php", $Addon);
            //写入控制器
            file_put_contents("{$addon_dir}admin/controllers/{$model->name}Controller.php", $AdminController);
            //写入模型
            file_put_contents("{$addon_dir}common/models/{$model->name}.php", $CommonModel);
            //写入参数
            file_put_contents($addon_dir.'Setting.php', $Setting);
            //写入文件
            $model['install'] && file_put_contents("{$addon_dir}/{$model['install']}", '<?php');
            $model['uninstall'] && file_put_contents("{$addon_dir}/{$model['uninstall']}", '<?php');
            $model['upgrade'] && file_put_contents("{$addon_dir}/{$model['upgrade']}", '<?php');
            $model->wechatMessage && file_put_contents($addon_dir.'WechatMessage.php', $WechatInfo);

            //移动图标
            if($model->cover)
            {
                copy(Yii::getAlias('@rootPath').'\web'.$model->cover,$addon_dir.'icon.jpg'); //拷贝到新目录
            }

            return $this->message('生成模块成功',$this->redirect(['install']));
        }

        return $this->render('create',[
            'model' => $model,
            'addonsType' => Yii::$app->params['addonsType']
        ]);
    }

    /**
     * 插件首页
     * @return string
     */
    public function actionIndex()
    {
        $request  = Yii::$app->request;
        if($request->isAjax)
        {
            $keyword = $request->get('keyword');
            $type = $request->get('type');

            $list = Addons::find()
                ->where(['status' => Addons::STATUS_ON])
                ->andFilterWhere(['like','title',$keyword])
                ->andFilterWhere(['type' => $type])
                ->andFilterWhere(['<>','type','plug'])
                ->asArray()
                ->all();

            foreach ($list as &$vo)
            {
                if(file_exists(AddonsHelp::getAddons($vo['name']).'icon.jpg'))
                {
                    $vo['cover'] = "/addons/{$vo['name']}/icon.jpg";
                }
                else
                {
                    $vo['cover'] = "/resource/backend/img/icon.jpg";
                }

                $vo['link'] = Url::to(['binding','addons'=>$vo['name']]);
                $vo['upgrade'] = Url::to(['upgrade','name'=>$vo['name']]);
                $vo['uninstall'] = Url::to(['uninstall','name'=>$vo['name']]);
            }

            $res = [];
            $res['flg'] = 1;
            $res['msg'] = '获取成功';
            $res['list'] = $list;

            echo json_encode($res);
        }
        else
        {
            $models = Addons::find()
                ->where(['status'=>Addons::STATUS_ON])
                ->andWhere(['<>','type','plug'])
                ->asArray()
                ->all();

            $addonsType = Yii::$app->params['addonsType']['addon']['child'];

            return $this->render('index',[
                'list' => Addons::regroupType($models),
                'models' => $models,
                'addonsType' => $addonsType,
            ]);
        }
    }

    /**
     * 插件后台导航页面
     * @return bool|string
     */
    public function actionBinding()
    {
        $request  = Yii::$app->request;
        $addonName = $request->get('addon');
        if(!($model = Addons::getAddon($addonName)))
        {
            return $this->message('插件不存在',$this->redirect(['index']),'error');
        }

        /**插件信息加入公共配置**/
        Yii::$app->params['addon']['info'] = ArrayHelper::toArray($model);

        return $this->render('binding',[
            'model' => $model,
            'list' => AddonsBinding::getList($addonName)
        ]);
    }

    /**
     * 导航链接
     * @return bool|string
     */
    public function actionCover()
    {
        $request  = Yii::$app->request;
        $id = $request->get('id');

        if(!($model = AddonsBinding::find()->where(['id' => $id])->with('addon')->asArray()->one()))
        {
            return $this->message('插件不存在',$this->redirect(['index']),'error');
        }

        Yii::$app->params['addon'] = $model['addon'];

        return $this->render('cover',[
            'model' => $model,
        ]);
    }

    /**
     * 转换二维码
     */
    public function actionQr()
    {
        $getUrl = Yii::$app->request->get('shortUrl');
        return \dosamigos\qrcode\QrCode::png($getUrl,false,0,5,4);
    }

    /**
     * 后台插件页面实现
     */
    public function actionExecute($route,$addon)
    {
        return $this->skip(AddonsHelp::analysisBusinessRoute($route,$addon));
    }

    /**
     * 后台插件设置实现
     */
    public function actionCentre($route,$addon)
    {
        return $this->skip(AddonsHelp::analysisBaseRoute($route,$addon));
    }

    /**
     * 渲染页面
     * @param $through
     * @return bool
     * @throws \yii\web\UnauthorizedHttpException
     */
    public function skip($through)
    {
        $class = $through['class'];
        $actionName = $through['actionName'];

        if(!($model = Addons::getAddon($through['addon'])))
        {
            throw new NotFoundHttpException('插件不存在');
        }

        if(!class_exists($class))
        {
            throw new NotFoundHttpException($class . '未找到');
        }

        $list = new $class($through['controller'],Yii::$app->module);
        if(!method_exists($list,$actionName))
        {
            throw new NotFoundHttpException($through['controller'].'/' . $actionName . '方法未找到');
        }

        Yii::$app->params['addon']['info'] = ArrayHelper::toArray($model);

        return $list->$actionName();
    }

    /**
     * 返回模型
     * @param $id
     * @return null|static
     */
    protected function findModel($name)
    {
        if ($model = Addons::find()->where(['name' => $name])->one())
        {
            return $model;
        }

        return new Addons();
    }
}