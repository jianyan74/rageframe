<?php
namespace wechat\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use common\helpers\FileHelper;

/**
 * 微信支付回调控制器
 *
 * Class WeNotifyController
 * @package wechat\controllers
 */
class WeNotifyController extends WController
{
    /**
     * 回调通知
     *
     * @return mixed
     */
    public function actionNotify()
    {
        $payment = Yii::$app->wechat->payment;
        $response = $payment->handlePaidNotify(function($notify, $successful)
        {
            //记录写入日志
            $logFolder = Yii::getAlias('@wechat') . "/runtime/pay_log/" . date('Y_m_d') . "/";
            //创建日志目录
            FileHelper::mkdirs($logFolder);
            FileHelper::writeLog($logFolder . $notify->openid . '.txt',json_encode(ArrayHelper::toArray($notify)));

            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            //$notify->out_trade_no;

            // 如果订单不存在
            if (!$order)
            {
                return '订单已经处理完毕'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->pay_status == 1)
            {
                return '完成'; //已经支付成功了就不再更新了
            }

            // 用户是否支付成功
            if ($successful)
            {
                //支付成功逻辑
            }
            else
            {
                //支付失败逻辑
            }

            $order->save(); // 保存订单
            return true; // 返回处理完成
        });

        return $response;
    }
}
