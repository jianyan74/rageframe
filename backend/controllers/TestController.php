<?php
namespace backend\controllers;

use yii;
use common\helpers\ExcelHelper;
use common\helpers\ArithmeticHelper;
use jianyan\basics\common\models\sys\Provinces;
use jianyan\basics\common\models\sys\Manager;

/**
 * 文件图片上传控制器
 * Class FileController
 * @package backend\modules\sys\controllers
 */
class TestController extends MController
{
    public function actionUploadImg()
    {
        $model = new Manager();

        return $this->render('upload-img', [
            'model'  => $model,
        ]);
    }

    /**
     * 待优化
     * 测试csv导出
     */
    public function actionCsvExport()
    {
        $header = [
            'areaname' => '编号',
            'parentid' =>  '名称',
            'level' => '年龄',
            'position' => '金额',
        ];

        $dataList = Provinces::find()
            ->asArray()
            ->limit(10000)
            ->all();

        ExcelHelper::exportCSVData($dataList,$header);
        return false;
    }

    /**
     * 红包生成测试
     */
    public function actionRedPacket()
    {
        //切记如果红包数量太多，不要设置为0.1 会导致最后红包金额不对
        $data = ArithmeticHelper::getRedPackage(100,998,0.01,3);

        $all_money = 0;
        foreach ($data as $datum)
        {
            $all_money += $datum;
        }

        $this->p($all_money);
        $this->p($data);
    }

    /**
     * 测试接口返回时间
     * @return array
     */
    public function actionApiResult()
    {
        $this->setResult();
        $this->_result->code = 200;

        $data = [];
        for ($i = 0; $i < 50; $i++)
        {
            $user   = Manager::find()
                ->with('assignment')
                ->asArray()
                ->all();
        }

        $this->_result->data = $data;

        return $this->getResult();
    }
}