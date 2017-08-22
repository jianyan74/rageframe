<?php
namespace backend\controllers;

use yii;
use common\helpers\ExcelHelper;
use jianyan\basics\common\models\sys\ActionLog;

/**
 * 文件图片上传控制器
 * Class FileController
 * @package backend\modules\sys\controllers
 */
class TestController extends MController
{
    /**
     * 测试导出
     */
    public function actionExport()
    {
        $fields = [
            ['key' => 'action', 'name' => '动作', 'required' => false],
            ['key' => 'username', 'name' => '账号', 'required' => true],
            ['key' => 'action_ip', 'name' => 'ip地址', 'required' => false],
            ['key' => 'append', 'name' => '创建时间', 'required' => false]
         ];

        $dataList = ActionLog::find()
            ->select('action,username,action_ip,append')
            ->asArray()
            ->all();

        ExcelHelper::createExcelFromData($fields,$dataList,time().".xls");
        return false;
    }
}