<?php
namespace e282486518\migration;

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

class WebAction extends Action
{

    /**
     * @var string $returnFormat 返回格式，json/txt
     */
    public $returnFormat = 'json';

    /**
     * @var string migration class files 保存路径
     */
    public $migrationPath = '@console/migrations';

    /**
     * 处理action
     */
    public function run()
    {
        $name = Yii::$app->request->get('tables');

        $name = trim($name,',');
        if(strpos($name, ',')){
            /* 备份部分数据表 */
            $tables = explode(',', $name);
        } else {
            /* 备份一个数据表 */
            $tables = [$name];
        }

        /* 所有数据表 */
        $alltables  = Yii::$app->db->createCommand('SHOW TABLE STATUS')->queryAll();
        $alltables  = array_map('array_change_key_case', $alltables);
        $alltables  = ArrayHelper::getColumn($alltables, 'name');

        /* 检查表是否存在 */
        foreach ($tables as $table) {
            if (!in_array($table,$alltables)) {
                if ($this->returnFormat == 'json') {
                    $this->ajaxReturn(1,$table.' table no find ...',$table);
                } else {
                    echo $table.' table no find ...';
                }
            }
        }
        /* 创建migration */
        foreach ($tables as $table) {
            $migrate = Yii::createObject([
                'class' => 'e282486518\migration\components\MigrateCreate',
                'migrationPath' => $this->migrationPath
            ]);
            $migrate->create($table);
            unset($migrate);
        }
        if ($this->returnFormat == 'json') {
            $this->ajaxReturn(0,'backup success.');
        } else {
            echo 'backup success..';
        }
    }

    /**
     * ---------------------------------------
     * ajax标准返回格式
     * @param $code integer  错误码
     * @param $msg string  提示信息
     * @param $obj mixed  返回数据
     * @return void
     * ---------------------------------------
     */
    public function ajaxReturn($code = 0, $msg = 'success', $obj = ''){
        /* api标准返回格式 */
        $json = array(
            'code' => $code,
            'msg'  => $msg,
            'obj'  => $obj,
        );
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode($json));
    }

}