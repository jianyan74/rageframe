<?php
namespace common\components;


use yii;
use common\helpers\AddonsHelp;
use common\helpers\StringHelper;
use common\helpers\AddonsUrl;
use common\controllers\WechatController;
use common\models\sys\Addons as AddonsModel;

/**
 * 插件基类
 * Class Addons
 * @package common\components
 */
class Addons extends WechatController
{
    /**
     * @var string
     */
    public $layout = '@backend/views/layouts/main';

    /**
     * 获取当前插件根目录
     * @var
     */
    public $_path;

    /**
     * 当前模块名称
     * @var
     */
    public $_addonName;

    /**
     * 模拟用户信息
     * @var bool
     */
    public $_addonSwitch = false;

    /**
     * 自动运行
     */
    public function init()
    {
        $request  = Yii::$app->request;
        $this->_addonName = $request->get('addon');
        $this->_path = Yii::getAlias('@addonurl') . '/' . $this->_addonName . '/';

        //微信支付回调地址
        $this->_notifyUrl = Yii::$app->request->hostInfo . AddonsUrl::toAbsoluteUrl(['we-notify/notify']);

        //继承
        parent::init();

        //非微信网页打开时候开启模拟数据
        if($this->_addonSwitch == true && empty($this->_wechatMember))
        {
            $this->_wechatMember = Yii::$app->params['wecahtSimulate']['userInfo'];
        }
    }

    /**
     * 普通渲染插件后台视图
     * @param $view
     * @param array $params
     * @return string
     */
    public function renderAddon($view, $params = [])
    {
        $viewPath = $this->renderBase($view);

        /**直接渲染前台视图**/
        if(AddonsHelp::$skipPath != Yii::$app->params['addon']['skipPath'])
        {
            $this->layout = '@frontend/views/layouts/main';
            return $this->render($viewPath,$params);
        }

        return $this->render('@common/helpers/AddonsView',[
            'params' => $params,
            'addon' => Yii::$app->params['addon']['addon'],
            'view' => $viewPath,
            'addonModel' => Yii::$app->params['addon']['info'],
        ]);
    }

    /**
     * ajax渲染插件后台视图
     * @param $view
     * @param array $params
     * @return string
     */
    public function renderAjaxAddon($view, $params = [])
    {
        $viewPath = $this->renderBase($view);
        return $this->renderAjax($viewPath,$params);
    }

    /**
     * Partial渲染插件后台视图
     * @param $view
     * @param array $params
     * @return string
     */
    public function renderPartialAddon($view, $params = [])
    {
        $viewPath = $this->renderBase($view);
        return $this->renderPartial($viewPath,$params);
    }

    /**
     * 视图渲染基类
     * @param $view
     * @return string
     */
    public function renderBase($view)
    {
        $skipPath = Yii::$app->params['addon']['skipPath'];
        $controller = StringHelper::toUnderScore(Yii::$app->params['addon']['oldController']);
        $addon = Yii::$app->params['addon']['addon'];

        $viewPath = "@addons/{$addon}/{$skipPath}/views/{$controller}/{$view}";
        if(count(explode('/',$view)) >= 2)
        {
            $viewPath = "@addons/{$addon}/{$skipPath}/views/{$view}";
        }

        return $viewPath;
    }

    /**
     * 直接跳转
     * @param $url
     * @param int $statusCode
     * @return yii\web\Response
     */
    public function redirectAddon($url, $statusCode = 302)
    {
        return $this->redirect(AddonsHelp::regroupUrl($url),$statusCode);
    }

    /**
     * 渲染钩子视图
     * @param $view
     * @param array $params
     * @return string
     */
    public function rederHook($addons, $params = [])
    {
        $viewUrl = "@addons/{$addons}/admin/views/setting/hook";
        return $this->renderPartial($viewUrl,$params);
    }

    /**
     * 获取配置信息
     * @return mixed
     */
    public function getConfig()
    {
        $addon = Yii::$app->request->get('addon');
        $model = AddonsModel::getAddon($addon);

        return $model ? unserialize($model->config) : false;
    }

    /**
     * 写入配置信息
     * @param $config
     * @return bool
     */
    public function setConfig($config)
    {
        $addon = Yii::$app->request->get('addon');
        $model = AddonsModel::getAddon($addon);
        $model->config = serialize($config);

        return $model->save() ? true : false;
    }

    /**
     * 错误提示信息
     * @param $msgText  -错误内容
     * @param $skipUrl  -跳转链接
     * @param $msgType  -提示类型
     * @param int $closeTime -提示关闭时间
     * @return mixed
     */
    public function message($msgText,$skipUrl,$msgType="",$closeTime=5)
    {
        $closeTime = (int)$closeTime;

        //如果是成功的提示则默认为3秒关闭时间
        if(!$closeTime && $msgType == "success" || !$msgType)
        {
            $closeTime = 3;
        }

        $html = $this->hintText($msgText,$closeTime);

        switch ($msgType)
        {
            case "success" :

                Yii::$app->getSession()->setFlash('success',$html);

                break;

            case "error" :

                Yii::$app->getSession()->setFlash('error',$html);

                break;

            case "info" :

                Yii::$app->getSession()->setFlash('info',$html);

                break;

            case "warning" :

                Yii::$app->getSession()->setFlash('warning',$html);

                break;

            default :

                Yii::$app->getSession()->setFlash('success',$html);

                break;
        }

        return $skipUrl;
    }

    /**
     * @param $msg
     * @param $closeTime
     * @return string
     */
    public function hintText($msg,$closeTime)
    {
        $text = $msg." <span class='closeTimeYl'>".$closeTime."</span>秒后自动关闭...";
        return $text;
    }
}